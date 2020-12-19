<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;

class InvoiceSeeder extends Seeder
{
    public function run()
    {
        $invoice = new Invoice([
            'issuer_id' => 1,
            'code' => '202011113',
            'date' => '2020-11-11',
            'name' => 'Przykładowa Firma',
            'address' => 'ul. Kwiatowa 10/2, 55-222 Gotham City',
            'nip' => '3335557779',
            'to_pay' => 125.73,
        ]);
        $invoice->save();
    }
}
