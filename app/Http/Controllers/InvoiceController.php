<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Issuer;
use App\Models\Product;
use App\Services\InvoiceService;
use App\Http\Requests\InvoiceRequest;

class InvoiceController extends Controller
{
    public function index()
    {
        return response()->view('invoice.index', [
            'issuers' => Issuer::all(),
            'products' => Product::all(),
            'newInvoice' => session()->pull('newInvoice'),
        ]);
    }
    
    public function store(InvoiceRequest $request)
    {
        $data = InvoiceService::prepareSession($request->all());
        $request->session()->flash('invoiceData', $data);

        return redirect()->route('invoice-preview.index');
    }
}
