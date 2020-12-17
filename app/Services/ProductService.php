<?php

namespace App\Services;

use \OutOfBoundsException;
use App\Models\Product;


class ProductService
{
    protected $data;
    
    protected function __construct($data) {
        $this->data = $data;
    }
    
    static public function createProductService($data) {
        if(empty($data['name']) || empty($data['unit_price']) || empty($data['unit']) || empty($data['tax']))
            throw new OutOfBoundsException('Not all mandatory fields are available.');
        
        return new self($data);
    }
    
    public function createProduct() {
        $product = new Product([
            'name' => $this->data['name'],
            'description' => $this->data['description'] ? $this->data['description']: null,
            'unit_price' => $this->data['unit_price'],
            'unit' => $this->data['unit'],
            'tax' => $this->data['tax'] / 100,
        ]);
        $product->save();
        
        $request = request();
        $request->session()->flash('productCreated', true);
    }
    
    public function updateProduct() {
        if(empty($this->data['id']))
            throw new OutOfBoundsException('Not all mandatory fields are available.');
        
        $product = Product::findOrFail($this->data['id']);
        
        $product->name = $this->data['name'];
        $product->description = $this->data['description'] ? $this->data['description']: null;
        $product->unit_price = $this->data['unit_price'];
        $product->unit = $this->data['unit'];
        $product->tax = $this->data['tax'] / 100;

        $product->save();
        
        $request = request();
        $request->session()->flash('productModified', true);
    }
    
    public function removeProduct() {
        if(empty($this->data['id']))
            throw new OutOfBoundsException('Not all mandatory fields are available.');
            
        $product = Product::findOrFail($this->data['id']);
        $product->delete();
        
        $request = request();
        $request->session()->flash('productDeleted', true);
    }
}