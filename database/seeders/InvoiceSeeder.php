<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;

class InvoiceSeeder extends Seeder
{
    public function run()
    {
        $invoice1 = new Invoice([
            'issuer_id' => 1,
            'code' => '202011113',
            'date' => '2020-11-11',
            'name' => 'Przykładowa Firma',
            'address' => 'ul. Kwiatowa 10/2, 55-222 Gotham City',
            'nip' => '3335557779',
            'delivery_cost' => 20.00,
            'to_pay' => 145.73,
        ]);
        $invoice1->save();
        
        $invoice2 = new Invoice([
            'issuer_id' => 1,
            'code' => '202012197',
            'date' => '2020-12-19',
            'first_name' => 'Kazimierz',
            'last_name' => 'Kowalski',
            'address' => 'ul. Kręta 104/27, 55-222 Bielsko-Biała',
            'delivery_cost' => 10.00,
            'to_pay' => 1396.32,
        ]);
        $invoice2->save();
    }
}
