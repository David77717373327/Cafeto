<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['lang'])->group(function () {
    Route::prefix('cafeto')->group(function () {
        // Public and role-based views for CAFETO module
        Route::controller(CAFETOController::class)->group(function () {
            Route::get('index', 'index')->name('cefa.cafeto.index'); // Main public dashboard
            Route::get('developers', 'devs')->name('cefa.cafeto.devs'); // Developer credits page (public)
            Route::get('information', 'info')->name('cefa.cafeto.info'); // Information page about CAFETO (public)
            Route::get('admin', 'admin')->name('cafeto.admin.index'); // Admin dashboard (requires admin role)
            Route::get('cashier', 'cashier')->name('cafeto.cashier.index'); // Cashier dashboard (requires cashier role)
            Route::get('instructor', 'instructor')->name('cafeto.instructor.index'); // Instructor dashboard (requires instructor role)
            Route::get('admin/configuration', 'configuration')->name('cafeto.admin.configuration.index'); // Admin configuration (e.g., printer testing)
            Route::get('cashier/configuration', 'configuration')->name('cafeto.cashier.configuration.index'); // Cashier configuration (e.g., printer testing)
        });

        // Inventory management routes
        Route::controller(InventoryController::class)->group(function () {
            Route::get('admin/inventory/index', 'index')->name('cafeto.admin.inventory.index'); // View current inventory (admin)
            Route::get('cashier/inventory/index', 'index')->name('cafeto.cashier.inventory.index'); // View current inventory (cashier)
            Route::get('admin/inventory/create', 'create')->name('cafeto.admin.inventory.create'); // Form to add inventory (admin)
            Route::get('cashier/inventory/create', 'create')->name('cafeto.cashier.inventory.create'); // Form to add inventory (cashier)
            Route::get('admin/inventory/status', 'status')->name('cafeto.admin.inventory.status'); // View expired/expiring products (admin)
            Route::get('cashier/inventory/status', 'status')->name('cafeto.cashier.inventory.status'); // View expired/expiring products (cashier)
            Route::get('admin/inventory/low', 'low_create')->name('cafeto.admin.inventory.low'); // Form to register inventory write-offs (admin)
            Route::get('cashier/inventory/low', 'low_create')->name('cafeto.cashier.inventory.low'); // Form to register inventory write-offs (cashier)

            // Inventory and sales reports
            Route::get('admin/reports/index', 'reports')->name('cafeto.admin.reports.index'); // Main reports page (admin)
            Route::get('cashier/reports/index', 'reports')->name('cafeto.cashier.reports.index'); // Main reports page (cashier)
            Route::post('admin/reports/inventory/generatepdf', 'generateInventoryPDF')->name('cafeto.admin.reports.inventory.generate.pdf'); // Generate current inventory PDF (admin)
            Route::post('cashier/reports/inventory/generatepdf', 'generateInventoryPDF')->name('cafeto.cashier.reports.inventory.generate.pdf'); // Generate current inventory PDF (cashier)
            Route::get('admin/reports/inventory/entries', 'showInventoryEntriesForm')->name('cafeto.admin.reports.inventory.entries'); // Form for inventory entries by date (admin)
            Route::get('cashier/reports/inventory/entries', 'showInventoryEntriesForm')->name('cafeto.cashier.reports.inventory.entries'); // Form for inventory entries by date (cashier)
            Route::post('admin/reports/inventory/entries', 'generateInventoryEntries')->name('cafeto.admin.reports.generate.inventory.entries'); // Query inventory entries by date (admin)
            Route::post('cashier/reports/inventory/entries', 'generateInventoryEntries')->name('cafeto.cashier.reports.generate.inventory.entries'); // Query inventory entries by date (cashier)
            Route::post('admin/reports/inventory/entries/generatepdf', 'generateInventoryEntriesPDF')->name('cafeto.admin.reports.generate.entries.pdf'); // Generate inventory entries PDF (admin)
            Route::post('cashier/reports/inventory/entries/generatepdf', 'generateInventoryEntriesPDF')->name('cafeto.cashier.reports.generate.entries.pdf'); // Generate inventory entries PDF (cashier)
            Route::get('admin/reports/sales', 'showSalesForm')->name('cafeto.admin.reports.sales'); // Form for sales reports by date (admin)
            Route::get('cashier/reports/sales', 'showSalesForm')->name('cafeto.cashier.reports.sales'); // Form for sales reports by date (cashier)
            Route::post('admin/reports/sales', 'generateSales')->name('cafeto.admin.reports.generate.sales'); // Query sales by date (admin)
            Route::post('cashier/reports/sales', 'generateSales')->name('cafeto.cashier.reports.generate.sales'); // Query sales by date (cashier)
            Route::post('admin/reports/sales/generatepdf', 'generateSalesPDF')->name('cafeto.admin.reports.generate.sales.pdf'); // Generate sales PDF (admin)
            Route::post('cashier/reports/sales/generatepdf', 'generateSalesPDF')->name('cafeto.cashier.reports.generate.sales.pdf'); // Generate sales PDF (cashier)
            Route::get('admin/entries/show/{movement}', 'show_entry')->name('cafeto.admin.movements.entries.show'); // View inventory movement details (admin)
            Route::get('cashier/entries/show/{movement}', 'show_entry')->name('cafeto.cashier.movements.entries.show'); // View inventory movement details (cashier)
            Route::get('admin/low/show/{movement}', 'showLow')->name('cafeto.admin.movements.low.show'); // View inventory write-off details (admin)
            Route::get('cashier/low/show/{movement}', 'showLow')->name('cafeto.cashier.movements.low.show'); // View inventory write-off details (cashier)
        });

        // Sales management routes
        Route::controller(SaleController::class)->group(function () {
            Route::get('admin/sale/index', 'index')->name('cafeto.admin.sale.index'); // View sales for current cash session (admin)
            Route::get('cashier/sale/index', 'index')->name('cafeto.cashier.sale.index'); // View sales for current cash session (cashier)
            Route::get('admin/sale/register', 'register')->name('cafeto.admin.sale.register'); // Form to register a sale (admin)
            Route::get('cashier/sale/register', 'register')->name('cafeto.cashier.sale.register'); // Form to register a sale (cashier)
            Route::get('admin/sale/show/{movement}', 'show')->name('cafeto.admin.movements.sale.show'); // View sale details (admin)
            Route::get('cashier/sale/show/{movement}', 'show')->name('cafeto.cashier.movements.sale.show'); // View sale details (cashier)
        });

        // Product management routes
        Route::controller(ElementController::class)->group(function () {
            Route::get('admin/element/index', 'index')->name('cafeto.admin.element.index'); // View all products (admin)
            Route::get('admin/element/edit/{element}', 'edit')->name('cafeto.admin.element.edit'); // Form to edit a product (admin)
            Route::post('admin/element/update/{element}', 'update')->name('cafeto.admin.element.update'); // Update a product (admin)
            Route::get('admin/element/create', 'create')->name('cafeto.admin.element.create'); // Form to create a product (admin)
            Route::post('admin/element/store', 'store')->name('cafeto.admin.element.store'); // Store a new product (admin)
        });

        // Cash register management routes
        Route::controller(CashController::class)->group(function () {
            Route::get('admin/cash/index', 'index')->name('cafeto.admin.cash.index'); // View active cash session and history (admin)
            Route::get('cashier/cash/index', 'index')->name('cafeto.cashier.cash.index'); // View active cash session and history (cashier)
            Route::post('admin/cash/store', 'store')->name('cafeto.admin.cash.store'); // Create a new cash session (admin)
            Route::post('cashier/cash/store', 'store')->name('cafeto.cashier.cash.store'); // Create a new cash session (cashier)
            Route::post('admin/cash/close', 'close')->name('cafeto.admin.cash.close'); // Close a cash session (admin)
            Route::post('cashier/cash/close', 'close')->name('cafeto.cashier.cash.close'); // Close a cash session (cashier)
        });

        // Movement history routes
        Route::controller(MovementController::class)->group(function () {
            Route::get('admin/movement/index', 'index')->name('cafeto.admin.movements.index'); // View movement history (admin)
            Route::get('cashier/movement/index', 'index')->name('cafeto.cashier.movements.index'); // View movement history (cashier)
            Route::post('admin/movement/consult', 'consult')->name('cafeto.admin.movements.consult'); // Query movements by date and actor (admin)
            Route::post('cashier/movement/consult', 'consult')->name('cafeto.cashier.movements.consult'); // Query movements by date and actor (cashier)
        });

        // Recipe management routes
        Route::controller(RecipesController::class)->group(function () {
            Route::get('admin/recipes/index', 'index')->name('cafeto.admin.recipes.index'); // View all recipes (admin)
            Route::get('cashier/recipes/index', 'index')->name('cafeto.cashier.recipes.index'); // View all recipes (cashier)
            Route::get('admin/recipes/create', 'create')->name('cafeto.admin.recipes.create'); // Form to create a recipe (admin)
            Route::get('cashier/recipes/create', 'create')->name('cafeto.cashier.recipes.create'); // Form to create a recipe (cashier)
            Route::get('admin/recipes/details', 'details')->name('cafeto.admin.recipes.details'); // View recipe details (admin)
            Route::get('cashier/recipes/details', 'details')->name('cafeto.cashier.recipes.details'); // View recipe details (cashier)
        });
        Route::group(['prefix' => 'cashier', 'middleware' => ['auth', 'permission:cafeto.cashier.formulations.index']], function () {
            Route::get('/formulations', [FormulationsController::class, 'index'])
                ->name('cafeto.cashier.formulations.index')
                ->middleware('skip.csrf.formulations');
        });
    });
});