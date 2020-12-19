<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Services\InvoiceService;

class InvoiceListController extends Controller
{
    public function index(Request $request)
    {
        return response()->view('invoice-list.index', [
            'invoices' => Invoice::with('issuer')->with('items')->get(),
            'invoiceDeleted' => session()->pull('invoiceDeleted'),
        ]);
    }
    
    public function destroy(Request $request)
    {
        $code = $request->input('removedInvoiceCode');
        InvoiceService::delInvoice($code);
        $request->session()->flash('invoiceDeleted', $code);
        
        return redirect()->route('invoice-list.index');
    }
}
