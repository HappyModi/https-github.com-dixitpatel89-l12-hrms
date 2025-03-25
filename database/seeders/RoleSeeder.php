<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $superAdmin = Role::create(['name' => 'Super Admin']);
        $companyAdmin = Role::create(['name' => 'Company Admin']);
        $hrAdmin = Role::create(['name' => 'HR Admin']);

        // Define permissions
        $permissions = [
            'manage users',
            'manage companies',
            'view reports',
            'assign roles'
        ];

        // Create permissions and assign to Super Admin
        foreach ($permissions as $permission) {
            $perm = Permission::create(['name' => $permission]);
            $superAdmin->givePermissionTo($perm);
        }

        // Assign specific permissions to other roles
        $companyAdmin->givePermissionTo(['manage users', 'view reports']);
        $hrAdmin->givePermissionTo(['view reports']);
    }
}
