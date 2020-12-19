<?php

namespace App\Services;

use \OutOfBoundsException;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;
use App\Models\Item;


class InvoiceService
{
    protected $invoice, $items;
    
    protected function __construct($invoice, $items) {
        $this->invoice = $invoice;
        $this->items = $items;
    }
    
    static public function createInstance($data) {
        $items = $data['items'];
        unset($data['items']);
        
        $data['issuer_id'] = $data['issuer']['id'];
        unset($data['issuer']);
        
        return new self($data, $items);
    }
    
    protected function createItem($itemData, $invoiceCode) {
        $item = new Item($itemData);
        $item['invoice_code'] = $invoiceCode;
        $item->save();
    }
    
    public function createInvoice() {
        DB::transaction(function() {
            $invoice = new Invoice($this->invoice);
            $invoice->save();
            
            foreach($this->items as $item) {
                $this->createItem($item, $invoice->code);
            }
        });
    }
    
    static public function prepareSession($data) {
        $invoiceData = array();
        
        $invoiceData['date'] = Carbon::today()->toDateString();
        $i = 1;
        
        while(true) {
            $code = str_replace('-', '', $invoiceData['date']) . $i;
            if(empty(Invoice::where('code', $code)->first())) {
                $invoiceData['code'] = $code;
                break;
            }
            else
                $i++;
        }
        
        if(isset($data['name'], $data['nip'])) {
            $invoiceData['name'] = $data['name'];
            $invoiceData['nip'] = $data['nip'];
        }
        elseif(isset($data['first_name'], $data['last_name'])) {
            $invoiceData['first_name'] = $data['first_name'];
            $invoiceData['last_name'] = $data['last_name'];
        }
        
        if(isset($data['address']))
            $invoiceData['address'] = $data['address'];
        elseif(isset($data['personalAddress']))
            $invoiceData['address'] = $data['personalAddress'];
        
        $toPay = 0;
        
        if(isset($data['delivery'])) {
            $invoiceData['delivery_cost'] = $data['delivery'];
            $toPay += $invoiceData['delivery_cost'];
        }
        
        $invoiceData['items'] = array();
        
        foreach($data['selectedProduct'] as $index => $product) {
            $item = array();
            
            $productData = json_decode($product, true);
            $item['quantity'] = json_decode($data['count'][$index], true);
            
            $item['name'] = $productData['name'];
            
            if(!empty($product['description']))
                $item['description'] = $product['description'];
            
            $item['unit_net_price'] = $productData['unit_price'];
            $item['unit'] = $productData['unit'];
            $item['tax'] = $productData['tax'];
            $item['tax_value'] = round($item['tax'] * $item['unit_net_price'] * $item['quantity'], 2);
            $item['total_cost'] = round($item['tax_value'] + $item['unit_net_price'] * $item['quantity'], 2);
            
            $toPay += $item['total_cost'];
            
            $invoiceData['items'][] = $item;
        }
        
        $invoiceData['to_pay'] = $toPay;
        
        $issuerData = json_decode($data['issuer'], true);
        $issuer = array(
            'id' => $issuerData['id'],
            'nip' => $issuerData['nip'],
            'name' => $issuerData['name'],
        );
        
        if(isset($issuerData['address']))
            $issuer['address'] = $issuerData['address'];
        
        if(isset($issuerData['telephone']))
            $issuer['telephone'] = $issuerData['telephone'];
            
        $invoiceData['issuer'] = $issuer;
        
        return $invoiceData;
    }
    
    public static function delInvoice($code) {
        DB::table('invoices')->where('code', $code)->delete();
    }
}
