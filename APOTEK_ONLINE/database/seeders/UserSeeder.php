<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('email', 'admin@apotek.com')->exists()) {
            User::create([
                'name'     => 'Admin Apotek',
                'email'    => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ]);
        }

        if (!User::where('email', 'user@apotek.com')->exists()) {
            User::create([
                'name'     => 'User Kosumen',
                'email'    => 'user@gmail.com',
                'password' => Hash::make('user123'),
                'role'     => 'user',
            ]);
        }
    }
}
