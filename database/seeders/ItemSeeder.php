<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    public function run()
    {
        $item = new Item([
            'invoice_code' => 202011113,
            'name' => 'Cement SUPER-CEMENT 25kg',
            'description'  => '',
            'unit_net_price' => 15.55,
            'unit' => 'szt',
            'quantity' => 4,
            'tax' => 0.23,
            'tax_value' => 14.31,
            'total_cost' => 76.51,
        ]);
        $item->save();
        
        $item = new Item([
            'invoice_code' => 202011113,
            'name' => 'Gwoździe nierdzewne 7cm',
            'description'  => '',
            'unit_net_price' => 11.50,
            'unit' => 'kg',
            'quantity' => 4,
            'tax' => 0.07,
            'tax_value' => 3.22,
            'total_cost' => 49.22,
        ]);
        $item->save();
    }
}
