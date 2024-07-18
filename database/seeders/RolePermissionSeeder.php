<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Crear roles
        $adminRole = Role::create(['name' => 'administrador']);
        $userRole = Role::create(['name' => 'usuario']);
        $viewerRole = Role::create(['name' => 'visualizador']);

        // Crear permisos
        $permissions = [
            'create users',
            'edit users',
            'delete users',
            'view users',
            'create data',
            'edit data',
            'delete data',
            'view data',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Asignar permisos a roles
        $adminRole->givePermissionTo(Permission::all());
        $userRole->givePermissionTo(['view users', 'view data', 'create data', 'edit data', 'delete data']);
        $viewerRole->givePermissionTo(['view data']);
    }
}
