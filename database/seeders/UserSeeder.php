<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Account
        User::updateOrCreate(
            ['email' => 'admin@ventuz.com'],
            [
                'name' => 'Admin Ventuz',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Regular User Account
        User::updateOrCreate(
            ['email' => 'user@ventuz.com'],
            [
                'name' => 'Arjunanda',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );
    }
}
