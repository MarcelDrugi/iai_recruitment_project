<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Issuer;
use App\Models\Invoice;


class IssuerModelTest extends TestCase
{
    use RefreshDatabase;
    
    protected Issuer $issuer;
    protected Invoice $invoice;
    
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
        
    }
    
    /** @test */   
    public function relationWithInvoices()
    {
        $this->assertEquals(count($this->issuer->invoices), 1);
        $this->assertEquals($this->invoice->code, $this->issuer->invoices[0]->code);
        $this->assertEquals($this->invoice->to_pay, $this->issuer->invoices[0]->to_pay);
    }
}
