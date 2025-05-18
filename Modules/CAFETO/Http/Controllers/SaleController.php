<?php

namespace Modules\CAFETO\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;
use Modules\SICA\Entities\CashCount;
use Modules\SICA\Entities\Movement;
use Modules\SICA\Entities\MovementType;
use Modules\SICA\Entities\MovementDetail;
use Modules\SICA\Entities\Inventory;
use Modules\AGROINDUSTRIA\Entities\Formulation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class SaleController extends Controller
{
    /**
     * Mostrar lista de ventas
     */
    public function index()
    {
        $view = [
            'titlePage' => trans('cafeto::controllers.CAFETO_sale_index_title_page'),
            'titleView' => trans('cafeto::controllers.CAFETO_sale_index_title_view')
        ];
        $app_puw = PUW::getAppPuw(); // Obtener la unidad productiva y bodega de la aplicación
        $cashCount = CashCount::where('productive_unit_warehouse_id', $app_puw->id)
            ->where('state', 'Abierta')
            ->first();
        
        if ($cashCount) {
            $movement_type = MovementType::where('name', 'Venta')->first();
            $sales = Movement::where('movement_type_id', $movement_type->id)
                ->whereHas('warehouse_movements', function ($query) use ($app_puw) {
                    $query->where('productive_unit_warehouse_id', $app_puw->id)->where('role', 'Entrega');
                })
                ->where('registration_date', '>=', $cashCount->opening_date)
                ->with(['movement_details.inventory.element'])
                ->orderBy('registration_date', 'DESC')
                ->get();
            return view('cafeto::sale.index', compact('view', 'sales', 'cashCount'));
        } else {
            return view('cafeto::sale.index', compact('view', 'cashCount'));
        }
    }

    /**
     * Mostrar formulario para registrar venta
     */
    public function register()
    {
        // Verificar si hay una caja abierta
        $app_puw = PUW::getAppPuw();
        $open_cash_count = CashCount::where('productive_unit_warehouse_id', $app_puw->id)
            ->where('state', 'Abierta')
            ->first();
        if (!$open_cash_count) {
            return redirect(route('cafeto.' . $this->getRoleRouteName() . '.sale.index'))
                ->with('error', trans('cafeto::cash.TextFailedOpen'));
        }

        // Obtener formulaciones aprobadas
        $formulations = Formulation::where('proccess', 'approved')
            ->whereHas('element', function ($query) {
                if (Schema::hasColumn('elements', 'is_intermediate')) {
                    $query->where('is_intermediate', false);
                }
            })
            ->with('element')
            ->get();

        $view = [
            'titlePage' => trans('cafeto::controllers.CAFETO_sale_register_title_page'),
            'titleView' => trans('cafeto::controllers.CAFETO_sale_register_title_view')
        ];
        return view('cafeto::sale.register', compact('view', 'formulations'));
    }

    /**
     * Guardar nueva venta
     */
    public function store(Request $request)
    {
        // Validar datos de entrada
        $request->validate([
            'formulation_id' => 'required|exists:formulations,id',
            'quantity' => 'required|integer|min:1',
            'customer_id' => 'nullable|string|max:255',
            'is_internal' => 'boolean',
        ]);

        // Verificar caja abierta
        $app_puw = PUW::getAppPuw();
        $cashCount = CashCount::where('productive_unit_warehouse_id', $app_puw->id)
            ->where('state', 'Abierta')
            ->first();
        if (!$cashCount) {
            return redirect(route('cafeto.' . $this->getRoleRouteName() . '.sale.index'))
                ->with('error', trans('cafeto::cash.TextFailedOpen'));
        }

        // Obtener formulación y verificar estado
        $formulation = Formulation::with('ingredients.element')->findOrFail($request->formulation_id);
        if ($formulation->proccess !== 'approved') {
            return redirect()->back()->withErrors(['formulation' => 'La formulación no está aprobada.']);
        }
        if ($formulation->element && Schema::hasColumn('elements', 'is_intermediate') && $formulation->element->is_intermediate) {
            return redirect()->back()->withErrors(['formulation' => 'No se pueden vender insumos intermedios directamente.']);
        }

        // Crear movimiento de venta
        $movement_type = MovementType::where('name', 'Venta')->first();
        $sale = Movement::create([
            'registration_date' => now(),
            'movement_type_id' => $movement_type->id,
            'voucher_number' => 'SALE-' . time(),
            'price' => $formulation->element ? $formulation->element->price * $request->quantity : 0,
            'observation' => $request->is_internal ? 'Venta interna' : 'Venta al cliente',
            'state' => 'completed',
            'cash_count_id' => $cashCount->id,
            'productive_unit_warehouse_id' => $app_puw->id,
        ]);

        // Actualizar inventario y registrar detalles del movimiento
        foreach ($formulation->ingredients as $ingredient) {
            $inventory = Inventory::where('element_id', $ingredient->element_id)
                ->where('productive_unit_warehouse_id', $app_puw->id)
                ->firstOrFail();
            $newStock = $inventory->stock - ($ingredient->amount * $request->quantity);

            if ($newStock < 0) {
                return redirect()->back()->withErrors(['stock' => 'Inventario insuficiente para ' . $ingredient->element->name]);
            }

            $inventory->update(['stock' => $newStock]);

            MovementDetail::create([
                'movement_id' => $sale->id,
                'element_id' => $ingredient->element_id,
                'amount' => $ingredient->amount * $request->quantity,
            ]);
        }

        // Registrar movimiento en warehouse_movements
        $sale->warehouse_movements()->create([
            'productive_unit_warehouse_id' => $app_puw->id,
            'role' => 'Entrega',
        ]);

        // Generar recibo si no es venta interna
        if (!$request->is_internal) {
            $this->generateReceipt($sale, $formulation, $request->quantity, $request->customer_id);
        }

        return redirect(route('cafeto.' . $this->getRoleRouteName() . '.sale.index'))
            ->with('success', 'Venta registrada con éxito.');
    }

    /**
     * Ver detalle de venta
     */
    public function show($movement_id)
    {
        $movement = Movement::with('movement_details.inventory.element.measurement_unit')->findOrFail($movement_id);
        $view = [
            'titlePage' => trans('cafeto::controllers.CAFETO_sale_show_title_page'),
            'titleView' => trans('cafeto::controllers.CAFETO_sale_show_title_view')
        ];
        return view('cafeto::sale.show', compact('view', 'movement'));
    }

    /**
     * Generar recibo para impresora térmica (simulado)
     */
    protected function generateReceipt(Movement $sale, Formulation $formulation, $quantity, $customerId)
    {
        // Lógica para enviar datos a la impresora térmica
        // Ejemplo: nombre del producto, cantidad, precio, cliente
        // Aquí se implementaría la integración con la impresora térmica
    }

    /**
     * Obtener el nombre de la ruta según el rol
     */
    private function getRoleRouteName()
    {
        return getRoleRouteName(Route::currentRouteName());
    }
}
?>