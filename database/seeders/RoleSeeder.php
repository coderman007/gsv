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
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Definir permisos comunes
        $commonPermissions = [];

        // Asignar permisos a roles
        $rolePermissions = [
            'Administrador' => [],
            'Vendedor' => array_merge($commonPermissions, []),
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
