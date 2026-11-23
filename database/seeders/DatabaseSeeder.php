<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // CHANGE THESE PASSWORDS after first login.
        User::updateOrCreate(['email' => 'admin@office.test'], [
            'name' => 'Office Administrator',
            'password' => 'Admin@12345',
            'role' => 'admin',
            'is_active' => true,
        ]);

        User::updateOrCreate(['email' => 'reception@office.test'], [
            'name' => 'Front Desk',
            'password' => 'Reception@12345',
            'role' => 'receptionist',
            'is_active' => true,
        ]);
    }
}
