<?php

namespace Modules\CAFETO\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\SICA\Entities\App;
use Modules\SICA\Entities\Permission;
use Modules\SICA\Entities\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Definir arreglos de PERMISOS que van ser asignados a los ROLES
        $permissions_admin = []; // Permisos para Administrador
        $permissions_cashier = []; // Permisos para Cajero
        $permissions_instructor = []; // Permisos para Instructor

        // Consultar aplicación SICA para registrar los permisos
        $app = App::where('name', 'CAFETO')->first();

        // ===================== Registro de todos los permisos de la aplicación CAFETO ==================
        // Vista principal del administrador
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.index'], [
            'name' => 'Vista principal del administrador',
            'description' => 'Pueder ver la vista principal del administrador',
            'description_english' => 'You can see the main view of the administrator',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Vista principal del cajero
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.cashier.index'], [
            'name' => 'Vista principal del cajero',
            'description' => 'Pueder ver la vista principal del cajero',
            'description_english' => 'You can see the main view of the cashier',
            'app_id' => $app->id
        ]);
        $permissions_cashier[] = $permission->id;

        // Vista principal del instructor
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.instructor.index'], [
            'name' => 'Vista principal del instructor',
            'description' => 'Puede ver la vista principal del instructor',
            'description_english' => 'Can view the main instructor dashboard',
            'app_id' => $app->id
        ]);
        $permissions_instructor[] = $permission->id;

        // Vista de configuración (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.configuration.index'], [
            'name' => 'Vista de configuración (Administrador)',
            'description' => 'Configuración de parámetros generales y testeo de impresión pos',
            'description_english' => 'Configuration of general parameters and post printing test',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Vista de configuración (Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.cashier.configuration.index'], [
            'name' => 'Vista de configuración (Cajero)',
            'description' => 'Configuración de parámetros generales y testeo de impresión pos',
            'description_english' => 'Configuration of general parameters and post printing test',
            'app_id' => $app->id
        ]);
        $permissions_cashier[] = $permission->id;

        // Generar impresión pos de prueba (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.configuration.postprinting'], [
            'name' => 'Generar impresión pos de prueba (Administrador)',
            'description' => 'Generar impresión pos de prueba',
            'description_english' => 'Generate test post printing',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Generar impresión pos de prueba (Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.cashier.configuration.postprinting'], [
            'name' => 'Generar impresión pos de prueba (Cajero)',
            'description' => 'Generar impresión pos de prueba',
            'description_english' => 'Generate test post printing',
            'app_id' => $app->id
        ]);
        $permissions_cashier[] = $permission->id;

        // Vista del inventario actual (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.inventory.index'], [
            'name' => 'Vista del inventario actual (Administrador)',
            'description' => 'Puede ver el inventario actual de productos (elementos) en bodega',
            'description_english' => 'You can see the current inventory of products (elements) in warehouse',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Vista del inventario actual (Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.cashier.inventory.index'], [
            'name' => 'Vista del inventario actual (Cajero)',
            'description' => 'Puede ver el inventario actual de productos (elementos) en bodega',
            'description_english' => 'You can see the current inventory of products (elements) in warehouse',
            'app_id' => $app->id
        ]);
        $permissions_cashier[] = $permission->id;

        // Formulario de registro de entrada de inventario (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.inventory.create'], [
            'name' => 'Formulario de registro de entrada de inventario (Administrador)',
            'description' => 'Formulario de registro de entrada de inventario',
            'description_english' => 'Inventory entry registration form',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Formulario de registro de entrada de inventario (Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.cashier.inventory.create'], [
            'name' => 'Formulario de registro de entrada de inventario (Cajero)',
            'description' => 'Formulario de registro de entrada de inventario',
            'description_english' => 'Inventory entry registration form',
            'app_id' => $app->id
        ]);
        $permissions_cashier[] = $permission->id;

        // Registro de entrada de inventario (Administrador y/o Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin-cashier.inventory.store'], [
            'name' => 'Registro de entrada de inventario (Administrador y/o Cajero)',
            'description' => 'Registro de entrada de inventario',
            'description_english' => 'Inventory entry record',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;
        $permissions_cashier[] = $permission->id;

        // Ver productos vencidos y por vencer (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.inventory.status'], [
            'name' => 'Ver productos vencidos y por vencer (Administrador)',
            'description' => 'Ver productos vencidos y por vencer',
            'description_english' => 'View expired and expiring products',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Ver productos vencidos y por vencer (Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.cashier.inventory.status'], [
            'name' => 'Ver productos vencidos y por vencer (Cajero)',
            'description' => 'Ver productos vencidos y por vencer',
            'description_english' => 'View expired and expiring products',
            'app_id' => $app->id
        ]);
        $permissions_cashier[] = $permission->id;

        // Formulario de registro de bajas de inventario (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.inventory.low'], [
            'name' => 'Formulario de registro de bajas de inventario (Administrador)',
            'description' => 'Formulario de registro de bajas de inventario',
            'description_english' => 'Inventory removal registration form',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Formulario de registro de bajas de inventario (Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.cashier.inventory.low'], [
            'name' => 'Formulario de registro de bajas de inventario (Cajero)',
            'description' => 'Formulario de registro de bajas de inventario',
            'description_english' => 'Inventory removal registration form',
            'app_id' => $app->id
        ]);
        $permissions_cashier[] = $permission->id;

        // Vista principal de la sección de reportes (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.reports.index'], [
            'name' => 'Vista principal de la sección de reportes (Administrador)',
            'description' => 'Vista principal de la sección de reportes',
            'description_english' => 'Main view of the reports section',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Vista principal de la sección de reportes (Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.cashier.reports.index'], [
            'name' => 'Vista principal de la sección de reportes (Cajero)',
            'description' => 'Vista principal de la sección de reportes',
            'description_english' => 'Main view of the reports section',
            'app_id' => $app->id
        ]);
        $permissions_cashier[] = $permission->id;

        // Generar PDF del inventario actual (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.reports.inventory.generate.pdf'], [
            'name' => 'Generar PDF del inventario actual (Administrador)',
            'description' => 'Generar PDF del inventario actual',
            'description_english' => 'Generate PDF of current inventory',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Generar PDF del inventario actual (Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.cashier.reports.inventory.generate.pdf'], [
            'name' => 'Generar PDF del inventario actual (Cajero)',
            'description' => 'Generar PDF del inventario actual',
            'description_english' => 'Generate PDF of current inventory',
            'app_id' => $app->id
        ]);
        $permissions_cashier[] = $permission->id;

        // Vista de consulta de entradas de inventario por fecha (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.reports.inventory.entries'], [
            'name' => 'Vista de consulta de entradas de inventario por fecha (Administrador)',
            'description' => 'Vista de consulta de entradas de inventario por fecha',
            'description_english' => 'Consult view of inventory entries by date',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Vista de consulta de entradas de inventario por fecha (Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.cashier.reports.inventory.entries'], [
            'name' => 'Vista de consulta de entradas de inventario por fecha (Cajero)',
            'description' => 'Vista de consulta de entradas de inventario por fecha',
            'description_english' => 'Consult view of inventory entries by date',
            'app_id' => $app->id
        ]);
        $permissions_cashier[] = $permission->id;

        // Realizar consulta de entradas de inventario por fechas recibidas (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.reports.generate.inventory.entries'], [
            'name' => 'Realizar consulta de entradas de inventario por fechas recibidas (Administrador)',
            'description' => 'Realizar consulta de entradas de inventario por fechas recibidas',
            'description_english' => 'Perform inventory entries query by received dates',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Realizar consulta de entradas de inventario por fechas recibidas (Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.cashier.reports.generate.inventory.entries'], [
            'name' => 'Realizar consulta de entradas de inventario por fechas recibidas (Cajero)',
            'description' => 'Realizar consulta de entradas de inventario por fechas recibidas',
            'description_english' => 'Perform inventory entries query by received dates',
            'app_id' => $app->id
        ]);
        $permissions_cashier[] = $permission->id;

        // Generar PDF de entradas de inventario (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.reports.generate.entries.pdf'], [
            'name' => 'Generar PDF de entradas de inventario (Administrador)',
            'description' => 'Generar PDF de entradas de inventario',
            'description_english' => 'Generate PDF of inventory entries',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Generar PDF de entradas de inventario (Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.cashier.reports.generate.entries.pdf'], [
            'name' => 'Generar PDF de entradas de inventario (Cajero)',
            'description' => 'Generar PDF de entradas de inventario',
            'description_english' => 'Generate PDF of inventory entries',
            'app_id' => $app->id
        ]);
        $permissions_cashier[] = $permission->id;

        // Vista de consulta de ventas realizadas por fechas (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.reports.sales'], [
            'name' => 'Vista de consulta de ventas realizadas por fechas (Administrador)',
            'description' => 'Vista de consulta de ventas realizadas por fechas',
            'description_english' => 'Consult view of sales made by dates',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Vista de consulta de ventas realizadas por fechas (Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.cashier.reports.sales'], [
            'name' => 'Vista de consulta de ventas realizadas por fechas (Cajero)',
            'description' => 'Vista de consulta de ventas realizadas por fechas',
            'description_english' => 'Consult view of sales made by dates',
            'app_id' => $app->id
        ]);
        $permissions_cashier[] = $permission->id;

        // Realizar consulta de ventas realizadas por fechas recibidas (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.reports.generate.sales'], [
            'name' => 'Realizar consulta de ventas realizadas por fechas recibidas (Administrador)',
            'description' => 'Realizar consulta de ventas realizadas por fechas recibidas',
            'description_english' => 'Perform sales made query by received dates',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Realizar consulta de ventas realizadas por fechas recibidas (Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.cashier.reports.generate.sales'], [
            'name' => 'Realizar consulta de ventas realizadas por fechas recibidas (Cajero)',
            'description' => 'Realizar consulta de ventas realizadas por fechas recibidas',
            'description_english' => 'Perform sales made query by received dates',
            'app_id' => $app->id
        ]);
        $permissions_cashier[] = $permission->id;

        // Generar PDF de ventas realizadas (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.reports.generate.sales.pdf'], [
            'name' => 'Generar PDF de ventas realizadas (Administrador)',
            'description' => 'Generar PDF de ventas realizadas',
            'description_english' => 'Generate PDF of sales made',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Generar PDF de ventas realizadas (Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.cashier.reports.generate.sales.pdf'], [
            'name' => 'Generar PDF de ventas realizadas (Cajero)',
            'description' => 'Generar PDF de ventas realizadas',
            'description_english' => 'Generate PDF of sales made',
            'app_id' => $app->id
        ]);
        $permissions_cashier[] = $permission->id;

        // Ver detalle de movimiento interno (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.movements.entries.show'], [
            'name' => 'Ver detalle de movimiento interno (Administrador)',
            'description' => 'Ver detalle de movimiento interno',
            'description_english' => 'See internal movement details',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Ver detalle de movimiento interno (Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.cashier.movements.entries.show'], [
            'name' => 'Ver detalle de movimiento interno (Cajero)',
            'description' => 'Ver detalle de movimiento interno',
            'description_english' => 'See internal movement details',
            'app_id' => $app->id
        ]);
        $permissions_cashier[] = $permission->id;

        // Ver detalle de baja (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.movements.low.show'], [
            'name' => 'Ver detalle de baja (Administrador)',
            'description' => 'Ver detalle de baja',
            'description_english' => 'See low detail',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Ver detalle de baja (Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.cashier.movements.low.show'], [
            'name' => 'Ver detalle de baja (Cajero)',
            'description' => 'Ver detalle de baja',
            'description_english' => 'See low detail',
            'app_id' => $app->id
        ]);
        $permissions_cashier[] = $permission->id;

        // Vista principal de ventas realizadas en sesión de caja (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.sale.index'], [
            'name' => 'Vista principal de ventas realizadas en sesión de caja (Administrador)',
            'description' => 'Vista principal de ventas realizadas en sesión de caja',
            'description_english' => 'Main view of sales made in the cash session',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Vista principal de ventas realizadas en sesión de caja (Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.cashier.sale.index'], [
            'name' => 'Vista principal de ventas realizadas en sesión de caja (Cajero)',
            'description' => 'Vista principal de ventas realizadas en sesión de caja',
            'description_english' => 'Main view of sales made in the cash session',
            'app_id' => $app->id
        ]);
        $permissions_cashier[] = $permission->id;

        // Formulario de registro de venta (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.sale.register'], [
            'name' => 'Formulario de registro de venta (Administrador)',
            'description' => 'Formulario de registro de venta',
            'description_english' => 'Sale registration form',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Formulario de registro de venta (Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.cashier.sale.register'], [
            'name' => 'Formulario de registro de venta (Cajero)',
            'description' => 'Formulario de registro de venta',
            'description_english' => 'Sale registration form',
            'app_id' => $app->id
        ]);
        $permissions_cashier[] = $permission->id;

        // Registro de venta (Administrador y/o Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin-cashier.generate.sale'], [
            'name' => 'Registro de venta (Administrador y/o Cajero)',
            'description' => 'Registro de venta',
            'description_english' => 'Sale record',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;
        $permissions_cashier[] = $permission->id;

        // Ver detalle de venta (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.movements.sale.show'], [
            'name' => 'Ver detalle de venta (Administrador)',
            'description' => 'Ver detalle de venta',
            'description_english' => 'See sales details',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Ver detalle de venta (Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.cashier.movements.sale.show'], [
            'name' => 'Ver detalle de venta (Cajero)',
            'description' => 'Ver detalle de venta',
            'description_english' => 'See sales details',
            'app_id' => $app->id
        ]);
        $permissions_cashier[] = $permission->id;

        // Vista principal de productos (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.element.index'], [
            'name' => 'Vista principal de productos (Administrador)',
            'description' => 'Vista principal de productos',
            'description_english' => 'Products main view',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Formulario para actualizar producto (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.element.edit'], [
            'name' => 'Formulario para actualizar producto (Administrador)',
            'description' => 'Formulario para actualizar producto',
            'description_english' => 'Form to update product',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Actualizar producto (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.element.update'], [
            'name' => 'Actualizar producto (Administrador)',
            'description' => 'Actualizar producto',
            'description_english' => 'Update product',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Formulario de registro de producto (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.element.create'], [
            'name' => 'Formulario de registro de producto (Administrador)',
            'description' => 'Formulario de registro de producto',
            'description_english' => 'Product registration form',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Registrar producto (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.element.store'], [
            'name' => 'Registrar producto (Administrador)',
            'description' => 'Registrar producto',
            'description_english' => 'Register product',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Vista principal de sesión de caja activa e historico de sesiones de caja (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.cash.index'], [
            'name' => 'Vista principal de sesión de caja activa e historico de sesiones de caja (Administrador)',
            'description' => 'Vista principal de sesión de caja activa e historico de sesiones de caja',
            'description_english' => 'Main view of active cash session and cash session history',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Vista principal de sesión de caja activa e historico de sesiones de caja (Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.cashier.cash.index'], [
            'name' => 'Vista principal de sesión de caja activa e historico de sesiones de caja (Cajero)',
            'description' => 'Vista principal de sesión de caja activa e historico de sesiones de caja',
            'description_english' => 'Main view of active cash session and cash session history',
            'app_id' => $app->id
        ]);
        $permissions_cashier[] = $permission->id;

        // Registrar caja cuando no hay ninguna activa (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.cash.store'], [
            'name' => 'Registrar caja cuando no hay ninguna activa (Administrador)',
            'description' => 'Registrar caja cuando no hay ninguna activa',
            'description_english' => 'Register box when there is none active',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Registrar caja cuando no hay ninguna activa (Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.cashier.cash.store'], [
            'name' => 'Registrar caja cuando no hay ninguna activa (Cajero)',
            'description' => 'Registrar caja cuando no hay ninguna activa',
            'description_english' => 'Register box when there is none active',
            'app_id' => $app->id
        ]);
        $permissions_cashier[] = $permission->id;

        // Cerrar sesión de caja (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.cash.close'], [
            'name' => 'Cerrar sesión de caja (Administrador)',
            'description' => 'Cerrar sesión de caja',
            'description_english' => 'Close cash session',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Cerrar sesión de caja (Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.cashier.cash.close'], [
            'name' => 'Cerrar sesión de caja (Cajero)',
            'description' => 'Cerrar sesión de caja',
            'description_english' => 'Close cash session',
            'app_id' => $app->id
        ]);
        $permissions_cashier[] = $permission->id;

        // Vista principal de historico de movimientos (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.movements.index'], [
            'name' => 'Vista principal de movimientos (Administrador)',
            'description' => 'Vista principal de histórico de movimientos',
            'description_english' => 'Main view of movement history',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Vista principal de historico de movimientos (Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.cashier.movements.index'], [
            'name' => 'Vista principal de movimientos (Cajero)',
            'description' => 'Vista principal de histórico de movimientos',
            'description_english' => 'Main view of movement history',
            'app_id' => $app->id
        ]);
        $permissions_cashier[] = $permission->id;

        // Consultar movimientos por fecha y actor (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.movements.consult'], [
            'name' => 'Consultar movimientos (Administrador)',
            'description' => 'Consultar movimientos por fecha y actor',
            'description_english' => 'Consult movements by date and actor',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Consultar movimientos por fecha y actor (Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.cashier.movements.consult'], [
            'name' => 'Consultar movimientos (Cajero)',
            'description' => 'Consultar movimientos por fecha y actor',
            'description_english' => 'Consult movements by date and actor',
            'app_id' => $app->id
        ]);
        $permissions_cashier[] = $permission->id;

        // Vista principal de recetas (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.recipes.index'], [
            'name' => 'Vista principal de recetas (Administrador)',
            'description' => 'Vista principal de recetas',
            'description_english' => 'Main view of recipes',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Vista principal de recetas (Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.cashier.recipes.index'], [
            'name' => 'Vista principal de recetas (Cajero)',
            'description' => 'Vista principal de recetas',
            'description_english' => 'Main view of recipes',
            'app_id' => $app->id
        ]);
        $permissions_cashier[] = $permission->id;

        // Vista de creación de recetas (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.recipes.create'], [
            'name' => 'Vista de creación de recetas (Administrador)',
            'description' => 'Vista de creación de recetas',
            'description_english' => 'View of recipe creation',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Vista de creación de recetas (Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.cashier.recipes.create'], [
            'name' => 'Vista de creación de recetas (Cajero)',
            'description' => 'Vista de creación de recetas',
            'description_english' => 'View of recipe creation',
            'app_id' => $app->id
        ]);
        $permissions_cashier[] = $permission->id;

        // Vista detalles de una receta (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.recipes.details'], [
            'name' => 'Vista detalles de una receta (Administrador)',
            'description' => 'Vista detalles de una receta',
            'description_english' => 'View details of a recipe',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Vista detalles de una receta (Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.cashier.recipes.details'], [
            'name' => 'Vista detalles de una receta (Cajero)',
            'description' => 'Vista detalles de una receta',
            'description_english' => 'View details of a recipe',
            'app_id' => $app->id
        ]);
        $permissions_cashier[] = $permission->id;

        // Gestión de formulaciones (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.admin.formulations'], [
            'name' => 'Gestión de formulaciones (Administrador)',
            'description' => 'Permite ver, crear, editar, actualizar, aprobar, eliminar y consultar detalles de formulaciones',
            'description_english' => 'Allows viewing, creating, editing, updating, approving, deleting, and consulting formulation details',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;

        // Gestión de formulaciones (Instructor)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.instructor.formulations'], [
            'name' => 'Gestión de formulaciones (Instructor)',
            'description' => 'Permite ver, crear, editar, actualizar, aprobar, eliminar y consultar detalles de formulaciones',
            'description_english' => 'Allows viewing, creating, editing, updating, approving, deleting, and consulting formulation details',
            'app_id' => $app->id
        ]);
        $permissions_instructor[] = $permission->id;

        // Gestión de formulaciones (Cajero)
        $permission = Permission::updateOrCreate(['slug' => 'cafeto.cashier.formulations'], [
            'name' => 'Gestión de formulaciones (Cajero)',
            'description' => 'Permite ver, crear y consultar detalles de formulaciones propias',
            'description_english' => 'Allows viewing, creating, and consulting details of own formulations',
            'app_id' => $app->id
        ]);
        $permissions_cashier[] = $permission->id;

        // Consulta de ROLES
        $rol_admin = Role::where('slug', 'cafeto.admin')->first(); // Rol Administrador
        $rol_cashier = Role::where('slug', 'cafeto.cashier')->first(); // Rol Cajero
        $rol_instructor = Role::where('slug', 'cafeto.instructor')->first(); // Rol Instructor

        // Asignación de PERMISOS para los ROLES de la aplicación CAFETO (Sincronización de las relaciones sin eliminar las relaciones existentes)
        $rol_admin->permissions()->syncWithoutDetaching($permissions_admin);
        $rol_cashier->permissions()->syncWithoutDetaching($permissions_cashier);
        $rol_instructor->permissions()->syncWithoutDetaching($permissions_instructor);
    }
}
?>