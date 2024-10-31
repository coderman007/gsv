<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles
        $roles = [
            'Administrador',
            'Vendedor',
            'Usuario Nuevo',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Definir permisos a todos los roles
        $commonPermissions = [
        ];

        // Asignar permisos a roles
        $rolePermissions = [
            'Administrador' => array_merge($commonPermissions, [
                'manage_roles', // Permiso para gestionar roles
                'manage_permissions', // Permiso para gestionar permisos
                // Otros permisos específicos para Administradores
            ]),
            'Vendedor' => array_merge($commonPermissions, [
                // permisos específicos para Vendedores
            ]),
            'Usuario Nuevo' => [], // Permisos vacíos para Usuario Nuevo
        ];

        foreach ($rolePermissions as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            foreach ($permissions as $permissionName) {
                Permission::firstOrCreate(['name' => $permissionName]);
                $role->givePermissionTo($permissionName);
            }
        }
    }
}
