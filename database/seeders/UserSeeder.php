<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin
        User::updateOrCreate(
            ['email' => 'admin@diu.edu.bd'],
            [
                'name' => 'admin',
                'password' => Hash::make('password'),
                'role' => 'admin',     
                'is_admin' => true,
                'is_seller' => false
            ]
        );

        // 2. Seller (Student)
        User::updateOrCreate(
            ['email' => 'seller@diu.edu.bd'], // seller account
            [
                'name' => 'seller',
                'password' => Hash::make('password'),
                'role' => 'seller',    
                'is_admin' => false,
                'is_seller' => true
            ]
        );

        // 3. Regular User (Student)
        User::updateOrCreate(
            ['email' => 'user@diu.edu.bd'],
            [
                'name' => 'user',
                'password' => Hash::make('password'),
                'role' => 'user',     
                'is_admin' => false,
                'is_seller' => false
            ]
        );
    }
}