<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // fake user created with role admin
        User::query()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // fake user created with role manager
        User::query()->create([
            'name' => 'Manager 1',
            'email' => 'manager@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        User::query()->create([
            'name' => 'Manager 2',
            'email' => 'manager2@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        User::query()->create([
            'name' => 'Manager 3',
            'email' => 'manager3@gmail.com',
            'password' => Hash::make('password123'),
        ]);

    }
}
