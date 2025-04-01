<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create roles using firstOrCreate to avoid duplicates
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $companyAdmin = Role::firstOrCreate(['name' => 'Company Admin', 'guard_name' => 'web']);
        $hrAdmin = Role::firstOrCreate(['name' => 'HR Admin', 'guard_name' => 'web']);
        
        // Define permissions
        $permissions = [
            'manage users',
            'manage companies',
            'view reports',
            'assign roles'
        ];

        // Create permissions and assign them to Super Admin
        foreach ($permissions as $permission) {
            $perm = Permission::firstOrCreate(['name' => $permission]);
            $superAdmin->givePermissionTo($perm);
        }

        // Assign specific permissions to other roles
        $companyAdmin->givePermissionTo(['manage users', 'view reports']);
        $hrAdmin->givePermissionTo(['view reports']);
    }
}
