<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;

class ProductModelTest extends TestCase
{
    use RefreshDatabase;
    
    public $data;
    
    public function setUp(): void
    {
        parent::setUp();
        
        $this->data = [
            'name' => 'Some Name',
            'unit_price' => 9.55,
            'unit' => 'kg',
            'tax' => 0.23,
        ];
        
        $product = new Product($this->data);
        $product->save();
        
    }
    
    /** @test */   
    public function testCreateProduct()
    {
        $product = Product::first();
        
        $this->assertEquals($product->name, $this->data['name']);
        $this->assertEquals($product->unit_price, $this->data['unit_price']);
        $this->assertEquals($product->unit, $this->data['unit']);
        $this->assertEquals($product->tax, $this->data['tax']);
        
        $this->assertEquals($product->description, null);
    }
}
