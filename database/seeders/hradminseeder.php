<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class hradminseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'hradmin@gmail.com'], // Check if user already exists
            [
                'company_id' => 1,
                'name' => 'HR Admin',
                'password' => Hash::make('hradmin@gmail.com'),
            ]
        );

        // Ensure the role is assigned only if not already assigned
        if (!$user->hasRole('HR Admin')) {
            $user->assignRole('HR Admin');
        }
    }
}
