<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Creación de roles
        $admin = Role::create(['name' => 'Administrador']);
        $empleado = Role::create(['name' => 'Empleado']);

        /**
         * ============================
         * PERMISOS Y ASIGNACIÓN: ADMINISTRADOR
         * ============================
         */

        // Cliente
        Permission::create(['name' => 'admin.cliente.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.cliente.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.cliente.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.cliente.destroy'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.cliente.export.pdf'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.cliente.export.excel'])->syncRoles([$admin]);

        // Pedido
        Permission::create(['name' => 'admin.pedido.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.pedido.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.pedido.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.pedido.destroy'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.pedido.export.pdf'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.pedido.export.excel'])->syncRoles([$admin]);

        // Ingreso
        Permission::create(['name' => 'admin.ingreso.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.ingreso.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.ingreso.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.ingreso.destroy'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.ingreso.export.pdf'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.ingreso.export.excel'])->syncRoles([$admin]);

        // Tipo de Lavado
        Permission::create(['name' => 'admin.tipolavado.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.tipolavado.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.tipolavado.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.tipolavado.destroy'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.tipolavado.export.pdf'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.tipolavado.export.excel'])->syncRoles([$admin]);

        // Detalle Pedido
        Permission::create(['name' => 'admin.detallepedido.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.detallepedido.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.detallepedido.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.detallepedido.destroy'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.detallepedido.export.pdf'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.detallepedido.export.excel'])->syncRoles([$admin]);

        // Egreso
        Permission::create(['name' => 'admin.egreso.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.egreso.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.egreso.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.egreso.destroy'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.egreso.export.pdf'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.egreso.export.excel'])->syncRoles([$admin]);

        // Tipo de Ropa
        Permission::create(['name' => 'admin.tiporopa.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.tiporopa.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.tiporopa.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.tiporopa.destroy'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.tiporopa.export.pdf'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.tiporopa.export.excel'])->syncRoles([$admin]);

        // Caja
        Permission::create(['name' => 'admin.caja.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.caja.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.caja.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.caja.destroy'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.caja.export.pdf'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.caja.export.excel'])->syncRoles([$admin]);

        // Cierre Caja
        Permission::create(['name' => 'admin.cierrecaja.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.cierrecaja.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.cierrecaja.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.cierrecaja.destroy'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.cierrecaja.export.pdf'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.cierrecaja.export.excel'])->syncRoles([$admin]);

        /**
         * ============================
         * PERMISOS Y ASIGNACIÓN: EMPLEADO (sin ingreso ni egreso)
         * ============================
         */

        $permisosEmpleado = [
            // Cliente
            'admin.cliente.index',
            'admin.cliente.store',
            'admin.cliente.update',
            'admin.cliente.destroy',
            'admin.cliente.export.pdf',
            'admin.cliente.export.excel',

            // Pedido
            'admin.pedido.index',
            'admin.pedido.store',
            'admin.pedido.update',
            'admin.pedido.destroy',
            'admin.pedido.export.pdf',
            'admin.pedido.export.excel',

            // Tipo de Lavado
            'admin.tipolavado.index',
            'admin.tipolavado.store',
            'admin.tipolavado.update',
            'admin.tipolavado.destroy',
            'admin.tipolavado.export.pdf',
            'admin.tipolavado.export.excel',

            // Detalle Pedido
            'admin.detallepedido.index',
            'admin.detallepedido.store',
            'admin.detallepedido.update',
            'admin.detallepedido.destroy',
            'admin.detallepedido.export.pdf',
            'admin.detallepedido.export.excel',

            // Tipo de Ropa
            'admin.tiporopa.index',
            'admin.tiporopa.store',
            'admin.tiporopa.update',
            'admin.tiporopa.destroy',
            'admin.tiporopa.export.pdf',
            'admin.tiporopa.export.excel',

            // Caja
            'admin.caja.index',
            'admin.caja.store',
            'admin.caja.update',
            'admin.caja.destroy',
            'admin.caja.export.pdf',
            'admin.caja.export.excel',

            // Cierre Caja
            'admin.cierrecaja.index',
            'admin.cierrecaja.store',
            'admin.cierrecaja.update',
            'admin.cierrecaja.destroy',
            'admin.cierrecaja.export.pdf',
            'admin.cierrecaja.export.excel',
        ];

        foreach ($permisosEmpleado as $permiso) {
            Permission::findByName($permiso)->assignRole($empleado);
        }

        /**
         * ============================
         * USUARIOS DE EJEMPLO
         * ============================
         */

        User::factory()->create([
            'name' => 'Abdiel Ampa Salas',
            'email' => 'ampa@gmail.com',
            'password' => bcrypt('123456789')
        ])->assignRole('Administrador');

        User::factory()->create([
            'name' => 'Jinme Huaytan Uscamayta',
            'email' => 'huaytan@gmail.com',
            'password' => bcrypt('123456789')
        ])->assignRole('Empleado');
    }
}
