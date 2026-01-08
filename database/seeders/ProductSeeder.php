<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            ['name' => 'Laptop', 'description' => 'High-performance laptop', 'price' => 1200.00, 'stock' => 10, ],
            ['name' => 'Smartphone', 'description' => 'Latest smartphone', 'price' => 800.00, 'stock' => 20, ],
            ['name' => 'Headphones', 'description' => 'Noise-cancelling headphones', 'price' => 150.00, 'stock' => 30, ],
            ['name' => 'Gaming-PC', 'description' => 'High-performance PC', 'price' => 2000.00, 'stock' => 10, ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
