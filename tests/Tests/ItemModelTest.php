<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;
use App\Models\Issuer;
use App\Models\Invoice;


class ItemModelTest extends TestCase
{
    use RefreshDatabase;
    
    protected Issuer $issuer;
    protected Invoice $invoice;
    protected Item $item;
    
    public function setUp(): void
    {
        parent::setUp();
        

        $this->issuer = new Issuer([
            'nip' => '0000000000',
            'name' => 'Some Company',
            'address' => 'Some address',
            'telephone' => '555555555',
        ]);
        $this->issuer->save();
        
        
        $this->invoice = new Invoice([
            'issuer_id' => $this->issuer->id,
            'code' => '202011113',
            'date' => '2020-11-11',
            'name' => 'Przykładowa Firma',
            'address' => 'ul. Kwiatowa 10/2, 55-222 Gotham City',
            'nip' => '3335557779',
            'to_pay' => 125.73,
        ]);
        $this->invoice->save();
        
        $this->item = new Item([
            'invoice_code' => $this->invoice->code,
            'name' => 'XYZ',
            'description'  => '',
            'unit_net_price' => 22.22,
            'unit' => 'szt',
            'quantity' => 3,
            'tax' => 0.23,
            'tax_value' => 15.33,
            'total_cost' => 81.99,
        ]);
        $this->item->save();
        
    }
    
    /** @test */   
    public function relationWithInvoice()
    {
        $this->assertEquals($this->item->invoice->code, $this->invoice->code);
        $this->assertEquals($this->item->invoice->code, $this->item->invoice_code);
    }
}
