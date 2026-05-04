<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ── Super Admin ────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'admin@ventuzstore.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('V3ntuz@Adm!n#2026'),
                'role' => 'admin',
            ]
        );
        User::updateOrCreate(
            ['email' => 'admin@junastack.id'],
            [
                'name' => 'Arjunanda',
                'password' => Hash::make('V3ntuz@Adm!n#2026'),
                'role' => 'admin',
            ]
        );
    }
}
