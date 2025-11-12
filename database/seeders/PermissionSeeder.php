<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $permissions = [
            // crm
            'crm.master',
            'dashboard.view',
            'user.create',
            'user.view',
            'user.edit',
            'user.delete',

            // Role
            'role.create',
            'role.view',
            'role.edit',
            'role.delete',

            // Permission
            'permission.create',
            'permission.view',
            'permission.edit',
            'permission.delete',

            // Warranty
            'warranty.create',
            'warranty.view',
            'warranty.edit',
            'warranty.delete',

            // Ftr File
            'ftr-file.create',
            'ftr-file.view',
            'ftr-file.edit',
            'ftr-file.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
