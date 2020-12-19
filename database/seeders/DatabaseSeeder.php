<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            ProductSeeder::class,
            IssuerSeeder::class,
            InvoiceSeeder::class,
            ItemSeeder::class,
        ]);
    }
}
