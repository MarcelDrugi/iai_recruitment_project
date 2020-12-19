@extends('layout')

@section('content')

    <div class="tabs">
    	<ul class="nav nav-tabs">
    		<li class="nav-item"><a class="nav-link" href="{{ route('homepage.index') }}">Strona główna</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Dodaj/usuń produkt</a></li>
            <li class="nav-item"><a class="nav-link active" href="{{ route('invoice.index') }}">Wystaw fakturę</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('invoice-list.index') }}">Wystawione faktury</a></li>
    	</ul>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible">
        <ul>
            @foreach($errors->all() as $error)
               <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif
    
    @if($newInvoice)
		<div class="alert alert-success alert-dismissible" role="alert">
        	<b>Faktura zapisana pomyślnie.</b><br />
        	Możesz ją przejrzeć lub usunąć w zakładce <a href="{{ route('invoice-list.index') }}">Wystawiona faktury</a>
        	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        		<span aria-hidden="true">&times;</span>
        	</button>
        </div>
    @endif
    
    <form id="invoice"  class="invoiceForm" method="post" action="{{ route('invoice.store') }}" class="centerForm" onchange="total()">
    	@csrf
    	
    	<div class="headerData">
        	<h3>Dane klienta:</h3>
            <div class="custom-control custom-switch">
        		<input type="checkbox" class="custom-control-input" id="customerTypeCheckBox" name="customerTypeCheckBox"  @if(old('customerTypeCheckBox')) checked  @endif onchange="customerType(event)">
        		<label class="custom-control-label" id="customerSwitchLabel" for="customerTypeCheckBox">osoba prywatna</label>
            </div>
            <div id="company" @if(old('customerTypeCheckBox')) style="display: none;" @else style="display: block;" @endif>
                <div class="group form-row">
                	<label for="name" class="col-3">nazwa odbiorcy: </label>
                	<input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control col-8">
            	</div>
            	<div class="group form-row">
                	<label for="address" class="col-3">adres odbiorcy(opcjonalnie): </label>
                	<input type="text" id="address" name="address" value="{{ old('address') }}" class="form-control col-8">
            	</div>
            	<div class="group form-row">
                	<label for="nip" class="col-3">NIP odbiorcy: </label>
                	<input type="text" id="nip" name="nip" value="{{ old('nip') }}" class="form-control col-8">
            	</div>
            </div>
            <div id="customer" @if(old('customerTypeCheckBox')) style="display: block;" @else style="display: none;" @endif>
                <div class="group form-row">
                	<label for="first_name" class="col-3">Imię odbiorcy: </label>
                	<input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}"  class="form-control col-8">
            	</div>
            	<div class="group form-row">
                	<label for="last_name" class="col-3">Nazwisko odbiorcy: </label>
                	<input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}"  class="form-control col-8">
            	</div>
            	<div class="group form-row">
                	<label for="personalAddress" class="col-3">adres odbiorcy(opcjonalnie): </label>
                	<input type="text" id="personalAddress" name="personalAddress" value="{{ old('personalAddress') }}" class="form-control col-8">
            	</div>
            </div>
        </div>
        
        <div class="headerData issuer">
        	<h3> Wystawiający:</h3>
        	<select class="form-control" name="issuer" id="issuer" onchange="selectIssuer()">
        		<option selected="selected" value="begin" disabled>wybierz podmiot</option>
        		@foreach($issuers as $issuer)
            		@if($issuer == old('issuer'))
            			<option value="{{ $issuer }}" selected="selected" >{{ $issuer->name }}</option>
            		@else
              			<option value="{{ $issuer }}">{{ $issuer->name }}</option>
              		@endif
              	@endforeach
            </select>
            <div id="issuerInfo" class="issuerData"></div>
        </div>
        
    	<div id="items" class="headerData">
    		<h3> Pozycje:</h3>
            <div id="item" style="display: none" class="singleItem">
            	<div class="row">
                	<div class="col-3">
                		<label for="selectedProduct"> produkt </label>
                    	<select class="form-control" name="selectedProduct[]" id="selectedProduct" onchange="selectItem(event.target.value)">
                			<option selected="selected" value="begin" disabled>wybierz produkt</option>
                    		@foreach($products as $product)
                          		<option value="{{ $product }}">{{ $product->name }}</option>
                          	@endforeach
                        </select>
                    </div>
                    <div class="col-3">
                		<label for="unitPrice"> cena jednostkowa NETTO </label>
                    	<div id="unitPrice"></div>
                    </div>
                    <div class="col-3">
                		<label for="count"> liczba </label>
                    	<input type="number" id="count" name="count[]" value="1" min="1" max="999" class="form-control" style="display: none;" onchange="changeQuantity(event)">
                    </div>
                    <div class="col-3">
                		<label for="unit"> jednostka </label>
                    	<div id="unit"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                		<label for="fullNet"> całkowita cena netto </label>
                    	<div id="fullNet"></div>
                    </div>
                    <div class="col-3">
                		<label for="vat"> stawka VAT </label>
                    	<div id="vat"></div>
                    </div>
                    <div class="col-3">
                		<label for="fullVat"> kwota VAT </label>
                    	<div id="fullVat"></div>
                    </div>
                    <div class="col-3">
                		<label for="fullItemCost"> całkowita wartość pozycji </label>
                    	<div id="fullItemCost"></div>
					</div>
                </div>
            	<button type="button" class="btn btn-danger" onclick="subtractItem(event)"> usuń tę pozycję </button>
            </div>
        </div>
		<button type="button" class="btn btn-success newItemButton" onclick="addItem()"> dodaj kolejną pozycję </button>
		<div class="group form-row deliveryGroup">
        	<label for="delivery" class="col-4">koszt dostawy(PLN): </label>
        	<input type="text" id="delivery" name="delivery" value="{{ old('delivery') ? old('delivery') : 0 }}" class="form-control col-5">
    	</div>
		<div id="totalCost" class="summaryInvoice">
        	<u>Do zapłaty BRUTTO</u>: 0.00 PLN
        </div>
        <button type="submit" class="btn btn-secondary confirmButton">podgląd faktury</button>
    </form>

   	@if(old('count') && old('selectedProduct'))
       	<script>
			let data = '';
			let count = 0;
       		@foreach(old('selectedProduct') as $x)
                addItem();
                
                data = "{{$x}}".replaceAll('&quot;','"');
                document.getElementById('selectedProduct' + "{{$loop->index}}").value = data;
                selectItem(data, "{{$loop->index}}");
                
                data =JSON.parse(data)
                count = parseInt("{{old('count')[$loop->index]}}");
                document.getElementById('count' + "{{$loop->index}}").value = "{{old('count')[$loop->index]}}";
                document.getElementById('fullNet' + "{{$loop->index}}").innerHTML = '' + (count * data.unit_price).toFixed(2) + ' PLN';
                document.getElementById('fullVat' + "{{$loop->index}}").innerHTML = '' + (count * data.unit_price * data.tax).toFixed(2) + ' PLN';
                document.getElementById('fullItemCost' + "{{$loop->index}}").innerHTML = '' + ((data.unit_price + data.unit_price * data.tax) * count).toFixed(2) + ' PLN';
                   
                console.log(data, "{{$loop->index}}");
                total();

        	@endforeach
        </script>
    @elseif(old('delivery'))
    	<script>
        	total();
        </script>
    @endif
    @if(old('issuer'))
    	<script>
    		data = "{{old('issuer')}}".replaceAll('&quot;','"');
    		selectIssuer(data);
    	</script>
    @endif
    
@endsection
