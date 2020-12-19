<script>
	const showInvoice = (event) => {
		const invoice = JSON.parse(event.target.value);
		
		document.getElementById('selectedInvoice').style.display = 'block';
		document.getElementById('invoiceDel').style.display = 'block';
		document.getElementById('removedInvoiceCode').value = invoice.code;
		
		document.getElementById('sellerMain').innerHTML = invoice.issuer.name + '<br /> NIP: ' + invoice.issuer.nip + 
			'<br />' + invoice.issuer.address + '<br /> tel.: ' + invoice.issuer.telephone;
		
		const buyer = (invoice.name ? invoice.name + '<br />NIP: ' + invoice.nip : invoice.first_name + ' ' + invoice.last_name);
		document.getElementById('buyerMain').innerHTML = buyer + (invoice.address ? '<br/ >' + invoice.address : '');
		
		document.getElementById('invoiceDate').innerHTML = invoice.date;
		document.getElementById('invoiceCode').innerHTML = invoice.code;
		
		document.getElementById('listItemsTable').innerHTML = '';
		
		for (let item of invoice.items) {
			const tr = document.createElement('tr');
			
			let th = document.createElement('th');
			th.innerHTML = item.name;
			tr.appendChild(th);
			
			th = document.createElement('th');
			th.innerHTML = item.unit_net_price;
			tr.appendChild(th);
			
			th = document.createElement('th');
			th.innerHTML = item.unit;
			tr.appendChild(th);
			
			th = document.createElement('th');
			th.innerHTML = item.quantity;
			tr.appendChild(th);
			
			th = document.createElement('th');
			th.innerHTML = item.tax;
			tr.appendChild(th);
			
			th = document.createElement('th');
			th.innerHTML = item.tax_value;
			tr.appendChild(th);
			
			th = document.createElement('th');
			th.innerHTML = item.total_cost;
			tr.appendChild(th);
			
			document.getElementById('listItemsTable').appendChild(tr);
		}
		
		document.getElementById('invoiceDelivery').innerHTML = 'Koszt dostay: ' + invoice.delivery_cost;
		document.getElementById('invoiceToPay').innerHTML = 'DO ZAPŁATY(BRUTTO): ' + invoice.to_pay;
	}
</script>

@extends('layout')

@section('content')
	<div class="tabs">
    	<ul class="nav nav-tabs">
    		<li class="nav-item"><a class="nav-link" href="{{ route('homepage.index') }}">Strona główna</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Dodaj/usuń produkt</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('invoice.index') }}">Wystaw fakturę</a></li>
            <li class="nav-item"><a class="nav-link active" href="{{ route('invoice-list.index') }}">Wystawione faktury</a></li>
    	</ul>
    </div>
    
    @if($invoiceDeleted)
		<div class="alert alert-success alert-dismissible" role="alert">
        	<b>Faktura o kodzie <b>{{ $invoiceDeleted}}</b> została usunięta</b><br />
        	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        		<span aria-hidden="true">&times;</span>
        	</button>
        </div>
    @endif
    
	<div class="row invoiceWrapper">
		<div class="col-1"></div>
        <div class="invoiceList col-4">
        	<h4> Wybierz fakturę:</h4>
            <select onchange="showInvoice(event)" class="form-control">
            	<option selected="selected" value="begin" disabled>utworzone faktury</option>
                @foreach($invoices->sortByDesc('date') as $invoice)
                	<option value="{{ $invoice }}">
                    	Odbiorca: <b>{{ $invoice->name ? $invoice->name : $invoice->first_name . ' ' . $invoice->last_name }}</b>
                    	nr: <b>{{ $invoice->code }}</b>
                	</option>
                @endforeach
            </select>
            <form method="post" action="{{ route('invoice-list.destroy') }}" id="invoiceDel" style="display: none;">
            	@csrf
            	@method('DELETE')
            	<input type="hidden" name="removedInvoiceCode" id="removedInvoiceCode">
            	<button class="btn btn-danger" type="submit"> USUŃ FAKTURĘ</button>
            </form>
        </div>
        
        <div class="col-1"></div>
        
        <div class="invoiceLook col-5" id ="selectedInvoice" style="display: none;">
        	<div class="row">
    			<div class="col-4">
                	<div class="seller">
                		<h4>Sprzedawca</h4>
                		<div id="sellerMain">
                		</div>
                		<div id="sellerAddress">
            			</div>
                	</div>
                	<div class="buyer">
                		<h4>Nabywca</h4>
                		<div id="buyerMain">
                		</div>
                	</div>
                </div>
                
                <div class="col-1"></div>
                
            	<div class="col-7 invoicePreviewHeader">
            		<h4> Faktura VAT</h4>
            		<div class="row">
            			<div class="col-4">wystawiono:</div>
            			<div class="col-8" id="invoiceDate"></div>
            		</div>
            		<div class="row">
            			<div class="col-4">nr faktury:</div>
            			<div class="col-8" id="invoiceCode"></div>
            		</div>
            	</div>
    		</div>
    		
    		<table class="table">
              <thead>
                <tr>
                  <th scope="col">Nazwa Produktu</th>
                  <th scope="col">Cena jednostkowa NETTO (PLN)</th>
                  <th scope="col">Jednostka miary</th>
                  <th scope="col">Ilość/Liczba</th>
                  <th scope="col">Stawka podatkowa (%)</th>
                  <th scope="col">Kwota podatku (PLN)</th>
                  <th scope="col">Łączna cena BRUTTO (PLN)</th>
                </tr>
              </thead>
              <tbody id="listItemsTable">
              </tbody>
            </table>
            
            <div class="invoiceDeliveryCost" id="invoiceDelivery">
        	</div>
        	<div class="invoiceToPay" id="invoiceToPay">
        	</div>
        	
        </div>
    </div>
@endsection
