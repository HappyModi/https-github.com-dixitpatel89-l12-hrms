<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class companyseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'companyadmin@gmail.com'], // Check if user already exists
            [
                'company_id' => 1,
                'name' => 'Company Admin',
                'password' => Hash::make('companyadmin@gmail.com'),
            ]
        );

        // Ensure the role is assigned only if not already assigned
        if (!$user->hasRole('Company Admin')) {
            $user->assignRole('Company Admin');
        }
    }
}


