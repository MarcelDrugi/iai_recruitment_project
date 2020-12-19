<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Issuer;

class IssuerSeeder extends Seeder
{
    public function run()
    {
        $issuer = new Issuer([
            'nip' => '0123456789',
            'name' => 'Nasza Firma Sp. z o. o.',
            'address' => 'ul. Jakaś Ulica 34/2, 12-345 Rivendell',
            'telephone' => '48 00x 00y 00z',
        ]);
        $issuer->save();
    }
}
