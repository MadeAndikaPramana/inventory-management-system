<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
        ]);

        User::create([
            'username' => 'warehouse',
            'password' => Hash::make('warehouse123'),
        ]);

        User::create([
            'username' => 'procurement',
            'password' => Hash::make('procurement123'),
        ]);
    }
}