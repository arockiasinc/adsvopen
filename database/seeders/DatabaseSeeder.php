<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
                'role' => 'admin',
            ],
        );

        User::updateOrCreate(
            ['username' => 'user'],
            [
                'name' => 'User',
                'email' => 'user@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
                'role' => 'user',
            ],
        );
    }
}
