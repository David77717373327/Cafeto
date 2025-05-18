<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['lang'])->group(function () {
    Route::prefix('cafeto')->group(function () {
        // Public and role-based dashboard routes
        Route::controller(CAFETOController::class)->group(function () {
            Route::get('index', 'index')->name('cefa.cafeto.index'); // Public dashboard
            Route::get('developers', 'devs')->name('cefa.cafeto.devs'); // Developer credits
            Route::get('information', 'info')->name('cefa.cafeto.info'); // About CAFETO
            Route::get('admin', 'admin')->name('cafeto.admin.index'); // Admin dashboard
            Route::get('cashier', 'cashier')->name('cafeto.cashier.index'); // Cashier dashboard
            Route::get('instructor', 'instructor')->name('cafeto.instructor.index'); // Instructor dashboard
            Route::get('admin/configuration', 'configuration')->name('cafeto.admin.configuration.index'); // Admin configuration
            Route::get('cashier/configuration', 'configuration')->name('cafeto.cashier.configuration.index'); // Cashier configuration
        });

        // Inventory management routes
        Route::controller(InventoryController::class)->group(function () {
            Route::get('admin/inventory/index', 'index')->name('cafeto.admin.inventory.index'); // View inventory (admin)
            Route::get('cashier/inventory/index', 'index')->name('cafeto.cashier.inventory.index'); // View inventory (cashier)
            Route::get('admin/inventory/create', 'create')->name('cafeto.admin.inventory.create'); // Create inventory (admin)
            Route::get('cashier/inventory/create', 'create')->name('cafeto.cashier.inventory.create'); // Create inventory (cashier)
            Route::post('admin/inventory/store', 'store')->name('cafeto.admin.inventory.store'); // Store inventory (admin)
            Route::post('cashier/inventory/store', 'store')->name('cafeto.cashier.inventory.store'); // Store inventory (cashier)
            Route::get('admin/inventory/status', 'status')->name('cafeto.admin.inventory.status'); // Expired products (admin)
            Route::get('cashier/inventory/status', 'status')->name('cafeto.cashier.inventory.status'); // Expired products (cashier)
            Route::get('admin/inventory/low', 'low_create')->name('cafeto.admin.inventory.low'); // Register low stock (admin)
            Route::get('cashier/inventory/low', 'low_create')->name('cafeto.cashier.inventory.low'); // Register low stock (cashier)
        });

        // Sales management routes
        Route::controller(SaleController::class)->group(function () {
            Route::get('admin/sale/index', 'index')->name('cafeto.admin.sale.index'); // View sales (admin)
            Route::get('cashier/sale/index', 'index')->name('cafeto.cashier.sale.index'); // View sales (cashier)
            Route::get('admin/sale/register', 'register')->name('cafeto.admin.sale.register'); // Register sale (admin)
            Route::get('cashier/sale/register', 'register')->name('cafeto.cashier.sale.register'); // Register sale (cashier)
            Route::post('admin/sale/store', 'store')->name('cafeto.admin.sale.store'); // Store sale (admin)
            Route::post('cashier/sale/store', 'store')->name('cafeto.cashier.sale.store'); // Store sale (cashier)
            Route::get('admin/sale/show/{movement}', 'show')->name('cafeto.admin.movements.sale.show'); // Sale details (admin)
            Route::get('cashier/sale/show/{movement}', 'show')->name('cafeto.cashier.movements.sale.show'); // Sale details (cashier)
        });

        // Element management routes
        Route::controller(ElementController::class)->group(function () {
            Route::get('admin/element/index', 'index')->name('cafeto.admin.element.index'); // View elements (admin)
            Route::get('admin/element/edit/{element}', 'edit')->name('cafeto.admin.element.edit'); // Edit element (admin)
            Route::post('admin/element/update/{element}', 'update')->name('cafeto.admin.element.update'); // Update element (admin)
            Route::get('admin/element/create', 'create')->name('cafeto.admin.element.create'); // Create element (admin)
            Route::post('admin/element/store', 'store')->name('cafeto.admin.element.store'); // Store element (admin)
        });

        // Cash management routes
        Route::controller(CashController::class)->group(function () {
            Route::get('admin/cash/index', 'index')->name('cafeto.admin.cash.index'); // View cash (admin)
            Route::get('cashier/cash/index', 'index')->name('cafeto.cashier.cash.index'); // View cash (cashier)
            Route::post('admin/cash/store', 'store')->name('cafeto.admin.cash.store'); // Create cash (admin)
            Route::post('cashier/cash/store', 'store')->name('cafeto.cashier.cash.store'); // Create cash (cashier)
            Route::post('admin/cash/close', 'close')->name('cafeto.admin.cash.close'); // Close cash (admin)
            Route::post('cashier/cash/close', 'close')->name('cafeto.cashier.cash.close'); // Close cash (cashier)
        });

        // Movement history routes
        Route::controller(MovementController::class)->group(function () {
            Route::get('admin/movement/index', 'index')->name('cafeto.admin.movements.index'); // View movements (admin)
            Route::get('cashier/movement/index', 'index')->name('cafeto.cashier.movements.index'); // View movements (cashier)
            Route::post('admin/movement/consult', 'consult')->name('cafeto.admin.movements.consult'); // Consult movements (admin)
            Route::post('cashier/movement/consult', 'consult')->name('cafeto.cashier.movements.consult'); // Consult movements (cashier)
        });

        // Recipes management routes
        Route::controller(RecipesController::class)->group(function () {
            Route::get('admin/recipes/index', 'index')->name('cafeto.admin.recipes.index'); // View recipes (admin)
            Route::get('cashier/recipes/index', 'index')->name('cafeto.cashier.recipes.index'); // View recipes (cashier)
            Route::get('admin/recipes/create', 'create')->name('cafeto.admin.recipes.create'); // Create recipe (admin)
            Route::get('cashier/recipes/create', 'create')->name('cafeto.cashier.recipes.create'); // Create recipe (cashier)
            Route::get('admin/recipes/details', 'details')->name('cafeto.admin.recipes.details'); // Recipe details (admin)
            Route::get('cashier/recipes/details', 'details')->name('cafeto.cashier.recipes.details'); // Recipe details (cashier)
        });

        // Report management routes (admin)
        Route::middleware(['auth'])->group(function () {
            Route::controller(ReportController::class)->group(function () {
                Route::get('admin/reports/index', 'index')->name('cafeto.admin.reports.index'); // Reports panel
                Route::get('admin/reports/inventory/entries', 'inventoryEntries')->name('cafeto.admin.reports.inventory.entries'); // Inventory entries form
                Route::post('admin/reports/inventory/entries/generate', 'generateInventoryEntries')->name('cafeto.admin.reports.generate.inventory.entries'); // Generate entries report
                Route::post('admin/reports/inventory/generate/pdf', 'generateInventoryPDF')->name('cafeto.admin.reports.inventory.generate.pdf'); // Inventory PDF
                Route::post('admin/reports/entries/generate/pdf', 'generateEntriesPDF')->name('cafeto.admin.reports.generate.entries.pdf'); // Entries PDF
                Route::get('admin/reports/sales', 'sales')->name('cafeto.admin.reports.sales'); // Sales form
                Route::post('admin/reports/sales/generate', 'generateSales')->name('cafeto.admin.reports.generate.sales'); // Generate sales report
                Route::post('admin/reports/sales/generate/pdf', 'generateSalesPDF')->name('cafeto.admin.reports.generate.sales.pdf'); // Sales PDF
            });
        });

        // Report management routes (cashier)
        Route::middleware(['auth'])->group(function () {
            Route::controller(ReportController::class)->group(function () {
                Route::get('cashier/reports/index', 'index')->name('cafeto.cashier.reports.index'); // Reports panel
                Route::get('cashier/reports/inventory/entries', 'inventoryEntries')->name('cafeto.cashier.reports.inventory.entries'); // Inventory entries form
                Route::post('cashier/reports/inventory/entries/generate', 'generateInventoryEntries')->name('cafeto.cashier.reports.generate.inventory.entries'); // Generate entries report
                Route::post('cashier/reports/inventory/generate/pdf', 'generateInventoryPDF')->name('cafeto.cashier.reports.inventory.generate.pdf'); // Inventory PDF
                Route::post('cashier/reports/entries/generate/pdf', 'generateEntriesPDF')->name('cafeto.cashier.reports.generate.entries.pdf'); // Entries PDF
                Route::get('cashier/reports/sales', 'sales')->name('cafeto.cashier.reports.sales'); // Sales form
                Route::post('cashier/reports/sales/generate', 'generateSales')->name('cafeto.cashier.reports.generate.sales'); // Generate sales report
                Route::post('cashier/reports/sales/generate/pdf', 'generateSalesPDF')->name('cafeto.cashier.reports.generate.sales.pdf'); // Sales PDF
            });
        });

        // Formulations management routes
        Route::controller(FormulationsController::class)->group(function () {
            // Admin routes (full CRUD)
            Route::middleware(['auth', 'permission:cafeto.admin.formulations'])->group(function () {
                Route::get('admin/formulations/index', 'index')->name('cafeto.admin.formulations.index'); // View formulations
                Route::get('admin/formulations/create', 'create')->name('cafeto.admin.formulations.create'); // Create formulation
                Route::post('admin/formulations/store', 'store')->name('cafeto.admin.formulations.store'); // Store formulation
                Route::get('admin/formulations/edit/{formulation}', 'edit')->name('cafeto.admin.formulations.edit'); // Edit formulation
                Route::post('admin/formulations/update/{formulation}', 'update')->name('cafeto.admin.formulations.update'); // Update formulation
                Route::post('admin/formulations/approve/{formulation}', 'approve')->name('cafeto.admin.formulations.approve'); // Approve formulation
                Route::delete('admin/formulations/delete/{formulation}', 'destroy')->name('cafeto.admin.formulations.destroy'); // Delete formulation
                Route::get('admin/formulations/show/{formulation}', 'show')->name('cafeto.admin.formulations.show'); // View details
            });

            // Instructor routes (full CRUD)
            Route::middleware(['auth', 'permission:cafeto.instructor.formulations'])->group(function () {
                Route::get('instructor/formulations/index', 'index')->name('cafeto.instructor.formulations.index'); // View formulations
                Route::get('instructor/formulations/create', 'create')->name('cafeto.instructor.formulations.create'); // Create formulation
                Route::post('instructor/formulations/store', 'store')->name('cafeto.instructor.formulations.store'); // Store formulation
                Route::get('instructor/formulations/edit/{formulation}', 'edit')->name('cafeto.instructor.formulations.edit'); // Edit formulation
                Route::post('instructor/formulations/update/{formulation}', 'update')->name('cafeto.instructor.formulations.update'); // Update formulation
                Route::post('instructor/formulations/approve/{formulation}', 'approve')->name('cafeto.instructor.formulations.approve'); // Approve formulation
                Route::delete('instructor/formulations/delete/{formulation}', 'destroy')->name('cafeto.instructor.formulations.destroy'); // Delete formulation
                Route::get('instructor/formulations/show/{formulation}', 'show')->name('cafeto.instructor.formulations.show'); // View details
            });

            // Cashier routes (create and view own formulations)
            Route::middleware(['auth', 'permission:cafeto.cashier.formulations'])->group(function () {
                Route::get('cashier/formulations/index', 'index')->name('cafeto.cashier.formulations.index'); // View own formulations
                Route::get('cashier/formulations/create', 'create')->name('cafeto.cashier.formulations.create'); // Create formulation
                Route::post('cashier/formulations/store', 'store')->name('cafeto.cashier.formulations.store'); // Store formulation
                Route::get('cashier/formulations/show/{formulation}', 'show')->name('cafeto.cashier.formulations.show'); // View details
            });
        });
    });
});
?>