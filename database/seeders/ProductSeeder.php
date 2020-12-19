<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $product = new Product([
            'name' => 'Cement SUPER-CEMENT 25kg',
            'description' => '',
            'unit_price' => 15.55,
            'tax' => 0.23,
        ]);
        $product->save();
        
        $product = new Product([
            'name' => 'Cement SUPER-CEMENT 50kg',
            'description' => '',
            'unit_price' => 29,
            'tax' => 0.23,
        ]);
        $product->save();
        
        $product = new Product([
            'name' => 'Piasek kwarcowy',
            'description' => '',
            'unit_price' => 0.24,
            'unit' => 'kg',
            'tax' => 0.23,
        ]);
        $product->save();
    }
}
