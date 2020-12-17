<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;

class ProductFeatureTest extends TestCase
{
    use RefreshDatabase;
    
    protected $url = '/products';
    protected $data;
    
    public function setUp(): void
    {
        parent::setUp();
        
        $this->data = [
            'name' => 'Name of the product',
            'description' => '',
            'unit_price' => 2.65,
            'unit' => 'ml',
            'tax' => 7,
        ];
    }
    
    /** @test */
    public function createProduct()
    {
        $response = $this->post($this->url, $this->data);
        $response->assertStatus(302);
        $response->assertRedirect($this->url);
        
        $newProduct = Product::orderBy('id', 'desc')->first();
        
        $this->assertEquals($newProduct->name, $this->data['name']);
        $this->assertEquals($newProduct->description, null);
        $this->assertEquals($newProduct->unit_price, $this->data['unit_price']);
        $this->assertEquals($newProduct->unit, $this->data['unit']);
        $this->assertEquals($newProduct->tax, $this->data['tax']/100);
        
        $response->assertSessionHas('productCreated', true);
    }
    
    /** @test */
    public function updateProduct()
    {
        $product = new Product($this->data);
        $product->save();
        
        $newName = 'Some new name';
        $newPrice = 22.99;
        
        $this->data['name'] = $newName;
        $this->data['unit_price'] = $newPrice;
        $this->data['id'] = $product->id;
        $_POST['update'] = true;
        
        $response = $this->put($this->url, $this->data);
        $response->assertStatus(302);
        $response->assertRedirect($this->url);
        
        $newProduct = Product::orderBy('id', 'desc')->first();
        
        $this->assertEquals($newProduct->name, $newName);
        $this->assertEquals($newProduct->unit_price, $newPrice);
        
        $response->assertSessionHas('productModified', true);
    }
    
    /** @test */
    public function removeProduct()
    {
        $product = new Product($this->data);
        $product->save();

        $this->data['id'] = $product->id;
        if(isset($_POST['update']))
            unset($_POST['update']);
        
        $response = $this->put($this->url, $this->data);
        $response->assertStatus(302);
        $response->assertRedirect($this->url);
        
        $response->assertSessionHas('productDeleted', true);
    }
}