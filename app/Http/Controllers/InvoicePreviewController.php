<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\InvoiceService;

class InvoicePreviewController extends Controller
{
    public function index(Request $request)
    {
        session()->keep('invoiceData');
        return response()->view('invoice-preview.index', [
            'invoiceData' => session()->get('invoiceData'),
        ]);
    }
    
    public function store(Request $request)
    {
        $service = InvoiceService::createInstance(session()->get('invoiceData'));
        $service->createInvoice();
        
        $request->session()->flash('newInvoice', true);
        return redirect()->route('invoice.index');
    }
}
