<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use \OutOfBoundsException;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        return response()->view('product.index', [
            'products' => Product::all(),
            'productCreated' => $request->session()->get('productCreated'),
            'productDeleted' => $request->session()->get('productDeleted'),
            'productModified' => $request->session()->get('productModified'),
        ]);
    }
    
    public function store(ProductRequest $request)
    {
        try {
            $service = ProductService::createProductService($request->all());
        }
        catch (OutOfBoundsException $e) {
            return response($e->getMessage(), 400);
        } 
        
        $service->createProduct();
        
        return redirect()->route('products.index');
    }
    
    public function update(ProductRequest $request)
    {
        try {
            $service = ProductService::createProductService($request->all());
        }
        catch (OutOfBoundsException $e) {
            return response($e->getMessage(), 400);
        }
        
        if(isset($_POST['update']))
            $service->updateProduct();
        else
            $service->removeProduct();
        
        return redirect()->route('products.index');
    }
    
}
