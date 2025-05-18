<?php

namespace Modules\CAFETO\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\AGROINDUSTRIA\Entities\Formulation;
use Modules\AGROINDUSTRIA\Entities\Ingredient;
use Modules\SICA\Entities\Element;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class FormulationsController extends Controller
{
    // Mostrar lista de formulaciones
    public function index()
    {
        // Obtener formulaciones según el rol del usuario
        $user = Auth::user();
        if ($user->hasPermissionTo('cafeto.admin.formulations') || $user->hasPermissionTo('cafeto.instructor.formulations')) {
            // Administrador e Instructor: todas las formulaciones
            $formulations = Formulation::with(['element', 'ingredients.element'])->get();
        } else {
            // Cajero/Pasante: solo sus propias formulaciones
            $formulations = Formulation::with(['element', 'ingredients.element'])
                ->where('person_id', $user->person->id ?? $user->id)
                ->get();
        }

        return view('cafeto::formulations.index', [
            'formulations' => $formulations,
            'view' => ['titlePage' => trans('cafeto::formulations.Title') ?: 'Formulations']
        ]);
    }

    // Mostrar formulario para crear formulación
    public function create()
    {
        // Verificar permisos (admin, instructor, cajero)
        if (!$this->hasFormulationPermission()) {
            abort(403, 'No autorizado');
        }

        // Obtener elementos (excluyendo insumos intermedios si existe el campo)
        $elements = Element::where(function ($query) {
            if (Schema::hasColumn('elements', 'is_intermediate')) {
                $query->where('is_intermediate', false);
            }
        })->get();

        // Unidades de medida hardcodeadas
        $units = [
            ['name' => 'Gramos', 'abbreviation' => 'g'],
            ['name' => 'Miligramos', 'abbreviation' => 'mg'],
            ['name' => 'Mililitros', 'abbreviation' => 'ml'],
        ];

        return view('cafeto::formulations.create', [
            'elements' => $elements,
            'units' => $units,
            'view' => ['titlePage' => trans('cafeto::formulations.Create') ?: 'Create Formulation']
        ]);
    }

    // Guardar nueva formulación
    public function store(Request $request)
    {
        // Verificar permisos
        if (!$this->hasFormulationPermission()) {
            abort(403, 'No autorizado');
        }

        // Validar datos de entrada
        $request->validate([
            'name' => 'required|string|max:255',
            'element_id' => 'nullable|exists:elements,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'ingredients' => 'required|array',
            'ingredients.*.element_id' => 'required подняться

            // Obtener la unidad productiva (si existe)
            $productiveUnitId = $this->getProductiveUnitId();

            // Determinar estado inicial
            $proccess = Auth::user()->hasPermissionTo('cafeto.cashier.formulations') ? 'pending' : 'approved';

            // Crear formulación
            $formulation = Formulation::create([
                'name' => $request->name,
                'element_id' => $request->element_id,
                'person_id' => Auth::user()->person->id ?? Auth::id(),
                'productive_unit_id' => $productiveUnitId,
                'proccess' => $proccess,
                'amount' => $request->amount,
                'date' => $request->date,
            ]);

            // Guardar ingredientes
            foreach ($request->ingredients as $ingredient) {
                Ingredient::create([
                    'formulation_id' => $formulation->id,
                    'element_id' => $ingredient['element_id'],
                    'amount' => $ingredient['amount'],
                    'unit' => $ingredient['unit'],
                ]);
            }

            return redirect()->route($this->getRedirectRoute() . '.formulations.index')
                ->with('success', 'Formulación creada con éxito.');
        }

        // Mostrar formulario para editar formulación
        public function edit(Formulation $formulation)
        {
            // Verificar permisos (solo admin e instructor)
            if (!Auth::user()->hasPermissionTo('cafeto.admin.formulations') && !Auth::user()->hasPermissionTo('cafeto.instructor.formulations')) {
                abort(403, 'No autorizado');
            }

            $elements = Element::where(function ($query) {
                if (Schema::hasColumn('elements', 'is_intermediate')) {
                    $query->where('is_intermediate', false);
                }
            })->get();

            $units = [
                ['name' => 'Gramos', 'abbreviation' => 'g'],
                ['name' => 'Miligramos', 'abbreviation' => 'mg'],
                ['name' => 'Mililitros', 'abbreviation' => 'ml'],
            ];

            return view('cafeto::formulations.edit', [
                'formulation' => $formulation,
                'elements' => $elements,
                'units' => $units,
                'view' => ['titlePage' => trans('cafeto::formulations.Edit') ?: 'Edit Formulation']
            ]);
        }

        // Actualizar formulación
        public function update(Request $request, Formulation $formulation)
        {
            // Verificar permisos
            if (!Auth::user()->hasPermissionTo('cafeto.admin.formulations') && !Auth::user()->hasPermissionTo('cafeto.instructor.formulations')) {
                abort(403, 'No autorizado');
            }

            // Validar datos
            $request->validate([
                'name' => 'required|string|max:255',
                'element_id' => 'nullable|exists:elements,id',
                'amount' => 'required|numeric|min:0',
                'date' => 'required|date',
                'ingredients' => 'required|array',
                'ingredients.*.element_id' => 'required|exists:elements,id',
                'ingredients.*.amount' => 'required|numeric|min:0',
                'ingredients.*.unit' => 'required|in:g,mg,ml',
            ]);

            // Actualizar formulación
            $formulation->update([
                'name' => $request->name,
                'element_id' => $request->element_id,
                'amount' => $request->amount,
                'date' => $request->date,
                'proccess' => $formulation->proccess, // Mantener estado actual
            ]);

            // Eliminar ingredientes existentes
            $formulation->ingredients()->delete();

            // Guardar nuevos ingredientes
            foreach ($request->ingredients as $ingredient) {
                Ingredient::create([
                    'formulation_id' => $formulation->id,
                    'element_id' => $ingredient['element_id'],
                    'amount' => $ingredient['amount'],
                    'unit' => $ingredient['unit'],
                ]);
            }

            return redirect()->route($this->getRedirectRoute() . '.formulations.index')
                ->with('success', 'Formulación actualizada con éxito.');
        }

        // Aprobar formulación
        public function approve(Formulation $formulation)
        {
            // Verificar permisos
            if (!Auth::user()->hasPermissionTo('cafeto.admin.formulations') && !Auth::user()->hasPermissionTo('cafeto.instructor.formulations')) {
                abort(403, 'No autorizado');
            }

            $formulation->update(['proccess' => 'approved']);

            return redirect()->route($this->getRedirectRoute() . '.formulations.index')
                ->with('success', 'Formulación aprobada con éxito.');
        }

        // Eliminar formulación
        public function destroy(Formulation $formulation)
        {
            // Verificar permisos
            if (!Auth::user()->hasPermissionTo('cafeto.admin.formulations') && !Auth::user()->hasPermissionTo('cafeto.instructor.formulations')) {
                abort(403, 'No autorizado');
            }

            $formulation->delete();

            return redirect()->route($this->getRedirectRoute() . '.formulations.index')
                ->with('success', 'Formulación eliminada con éxito.');
        }

        // Mostrar detalles de formulación
        public function show(Formulation $formulation)
        {
            // Verificar permisos
            if (!$this->hasFormulationPermission()) {
                abort(403, 'No autorizado');
            }

            return view('cafeto::formulations.show', [
                'formulation' => $formulation,
                'view' => ['titlePage' => trans('cafeto::formulations.Show') ?: 'Formulation Details']
            ]);
        }

        // Helper para verificar permisos
        private function hasFormulationPermission()
        {
            return Auth::user()->hasPermissionTo('cafeto.admin.formulations') ||
                   Auth::user()->hasPermissionTo('cafeto.instructor.formulations') ||
                   Auth::user()->hasPermissionTo('cafeto.cashier.formulations');
        }

        // Helper para obtener ruta de redirección según rol
        private function getRedirectRoute()
        {
            if (Auth::user()->hasPermissionTo('cafeto.admin.formulations')) {
                return 'cafeto.admin';
            } elseif (Auth::user()->hasPermissionTo('cafeto.instructor.formulations')) {
                return 'cafeto.instructor';
            } else {
                return 'cafeto.cashier';
            }
        }

        // Helper para obtener el ID de la unidad productiva
        private function getProductiveUnitId()
        {
            // Reemplazar con lógica real para obtener la unidad productiva
            // Ejemplo: Obtener de la configuración del usuario o sistema
            return 1; // Valor por defecto, ajustar según necesidades
        }
    }
?>