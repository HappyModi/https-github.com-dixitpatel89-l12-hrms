<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'superadmin@gmail.com'], // Check if user already exists
            [
                'company_id' => 1,
                'name' => 'Super Admin',
                'password' => Hash::make('superadmin@gmail.com'),
            ]
        );

        // Ensure the role is assigned only if not already assigned
        if (!$user->hasRole('Super Admin')) {
            $user->assignRole('Super Admin');
        }
    }
}
