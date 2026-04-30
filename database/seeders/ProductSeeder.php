<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        
        $seller = User::where('role', 'seller')->first(); 

        
        if (!$seller) {
            $seller = User::create([
                'name' => 'seller',
                'email' => 'seller@diu.edu.bd',
                'password' => bcrypt('password'),
                'role' => 'seller',
            ]);
        }

        //  dummy product
        $products = [
            [
                'name' => 'CSE Book – Data Structures',
                'description' => 'Used but in good condition',
                'price' => 450,
                'stock' => 5,
                'department' => 'CSE',
                'pickup_point' => 'DIU Main Gate',
                'image' => 'book.jpg',
            ],
            [
                'name' => 'Scientific Calculator',
                'description' => 'Casio original fx-991ES Plus',
                'price' => 1200,
                'stock' => 3,
                'department' => 'EEE',
                'pickup_point' => 'Reception',
                'image' => 'calculator.jpg',
            ],
            [
                'name' => 'DIU ID Card Holder',
                'description' => 'Premium quality ID card holder',
                'price' => 150,
                'stock' => 10,
                'department' => 'All',
                'pickup_point' => 'Campus Plaza',
                'image' => 'id.jpg',
            ]
        ];

        foreach ($products as $productData) {
            Product::create(array_merge($productData, [
                'user_id' => $seller->id, 
                'is_active' => true,
            ]));
        }
    }
}