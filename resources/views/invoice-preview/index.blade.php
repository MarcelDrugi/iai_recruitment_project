
@extends('layout')

@section('content')
	<div class="invoicePreview">
		<div class="row">
			<div class="col-4">
            	<div class="seller">
            		<h4>Sprzedawca</h4>
            		<div>
            			{{ $invoiceData['issuer']['name'] }}<br />
            			NIP: {{ $invoiceData['issuer']['nip'] }}
            		</div>
            		<div>
        			@if(isset($invoiceData['issuer']['address']))
        				{{ $invoiceData['issuer']['address'] }} <br />
        			@endif
        			@if(isset($invoiceData['issuer']['telephone']))
        				tel.: {{ $invoiceData['issuer']['telephone'] }}
        			@endif
        			</div>
            	</div>
            	<div class="buyer">
            		<h4>Nabywca</h4>
            		@if(isset($invoiceData['name']))
            			<div>
                			{{ $invoiceData['name'] }}<br />
                			NIP: {{ $invoiceData['nip'] }}
                		</div>
            			@if(isset($invoiceData['address']))
            				<div>{{ $invoiceData['address'] }}</div>
            			@endif
            		@else
            			<div>
                			{{ $invoiceData['first_name'] }} {{ $invoiceData['last_name'] }}
                		</div>
            			@if(isset($invoiceData['address']))
            				<div>{{ $invoiceData['address'] }}</div>
            			@endif
            		@endif
            	</div>
        	</div>
        	<div class="col-1"></div>
        	<div class="col-7 invoicePreviewHeader">
        		<h4> Faktura VAT</h4>
        		<div class="row">
        			<div class="col-3">wystawiono:</div>
        			<div class="col-8">{{ $invoiceData['date'] }}</div>
        		</div>
        		<div class="row">
        			<div class="col-3">nr faktury:</div>
        			<div class="col-8">{{ $invoiceData['code'] }}</div>
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
          <tbody>
            @foreach($invoiceData['items'] as $item)
    			<tr>
                  <td>{{ $item['name']}}</td>
                  <td>{{ $item['unit_net_price']}}</td>
                  <td>{{ $item['unit']}}</td>
                  <td>{{ $item['quantity']}}</td>
                  <td>{{ $item['tax']}}</td>
                  <td>{{ $item['tax_value']}}</td>
                  <td>{{ $item['total_cost']}}</td>
                </tr>
    		@endforeach
          </tbody>
        </table>
        <div class="deliveryPreview">
        	<u>Koszt dostawy / transportu</u>: 
        	@if(isset($invoiceData['delivery_cost']))
            	{{ $invoiceData['delivery_cost'] }} PLN <br />
            @else
            	0.00 PLN
            @endif
    	</div>
    	<div class="toPayPreview">
    		DO ZAPŁATY BRUTTO: {{ $invoiceData['to_pay'] }} PLN <br />
    	</div>
	</div>
	<div class="row">
		<div class="col-4"></div>
		<div class="col-2 previewButton">
    		<a onclick="window.history.back()" class="btn btn-secondary">Wróć</a>
    	</div>
    	<div class="col-2 previewButton">
        	<form method="post" action="{{ route('invoice-preview.store') }}">
        		@csrf
        		<button type="submit" class="btn btn-success">Zapisz fakturę</button>
        	</form>
    	</div>
	</div>
@endsection
