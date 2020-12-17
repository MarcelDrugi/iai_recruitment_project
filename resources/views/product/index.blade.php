<script>
	const selectExistingProduct = (event) => {
		const product = JSON.parse(event.target.value);
		console.log(product);
		
		const newProductInputs = document.getElementById('newProductData');
		newProductInputs.style.display = 'none';
		document.getElementById('newProductCheckBox').checked = false;
		
		const productInputs = document.getElementById('existingProductData');
		productInputs.style.display = 'block';
		
		document.getElementById('name').value = product.name;
		document.getElementById('description').value = product.description;
		document.getElementById('price').value = product.unit_price;
		document.getElementById('unit').value = product.unit;
		document.getElementById('tax').value = (product.tax * 100);
		document.getElementById('id').value = product.id;
		
	};
	
	const newProduct = (event) => {
		if(event.target.checked == true) {
			const productInputs = document.getElementById('existingProductData');
			productInputs.style.display = 'none';
			
			document.getElementById('existingProduct').value = 'begin';
			
			const newProductInputs = document.getElementById('newProductData');
			newProductInputs .style.display = 'block';
		}
		else if(event.target.checked == false) {
			const newProductInputs = document.getElementById('newProductData');
			newProductInputs .style.display = 'none';
		}
	};
</script>


@extends('layout')

@section('content')

    <div class="tabs">
    	<ul class="nav nav-tabs">
    		<li class="nav-item"><a class="nav-link" href="{{ route('homepage.index') }}">Strona główna</a></li>
            <li class="nav-item"><a class="nav-link active" href="{{ route('products.index') }}">Dodaj/usuń produkt</a></li>
            <li class="nav-item"><a class="nav-link" href="">Wystaw fakturę</a></li>
            <li class="nav-item"><a class="nav-link" href="">Wystawione faktury</a></li>
    	</ul>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible">
        <ul>
            @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif
    @if($productCreated)
		<div class="alert alert-success alert-dismissible" role="alert">
        	<b>Stworzono nowy produkt.</b>
        	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        		<span aria-hidden="true">&times;</span>
        	</button>
        </div>
    @endif
	@if($productDeleted)
		<div class="alert alert-success alert-dismissible" role="alert">
        	<b>Produkt został usunięty.</b>
        	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        		<span aria-hidden="true">&times;</span>
        	</button>
        </div>
    @endif
    @if($productModified)
		<div class="alert alert-success alert-dismissible" role="alert">
        	<b>Produkt zmodyfikowany pomyślnie.</b>
        	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        		<span aria-hidden="true">&times;</span>
        	</button>
        </div>
	@endif

	<h3 class="productLabel">EDYTUJ ISTNIEJĄCY PRODUKT</h3>
	
	<form method="post" id="editMovie" class="product">
    	@csrf
        @method('PUT')
    	<select class="form-control" name="existingProduct" id="existingProduct" onchange="selectExistingProduct(event)">
    		<option selected="selected" value="begin" disabled>wybierz produkt</option>
    		@foreach($products as $product)
          		<option value="{{ $product }}">{{ $product->name }}</option>
          	@endforeach
        </select>
        <div id="existingProductData" style="display: none">
            <div class="group form-row">
            	<label for="name" class="col-3">nazwa: </label>
            	<input type="text" id="name" name="name" class="form-control col-8">
            </div>
            <div class="group form-row">
            	<label for="description" class="col-3">opis (opcjonalnie): </label>
            	<input type="text" id="description" name="description" class="form-control col-8">
            </div>
            <div class="group form-row">
            	<label for="price" class="col-3">Cana jednostkowa (PLN): </label>
            	<input type="text" id="price" name="price" class="form-control col-8">
            </div>
            <div class="group form-row">
            	<label for="unit" class="col-3">jednostka: </label>
            	<input type="text" id="unit" name="unit" class="form-control col-8">
            </div>
            <div class="group form-row">
            	<label for="tax" class="col-3">podatek VAT (%): </label>
            	<input type="text" id="tax" name="tax" class="form-control col-8">
            </div>
            <input type="hidden" id="id" name="id">
            <button type="submit" name="update" class="btn btn-secondary" formaction="{{ route('products.update') }}">edytuj produkt</button>
            <button type="submit" name="remove" class="btn btn-danger" formaction="{{ route('products.update') }}">usuń produkt</button>
        </div>
	</form>
	
	<div class="custom-control custom-switch productSwitch">
		<input type="checkbox" class="custom-control-input" id="newProductCheckBox" onchange="newProduct(event)">
		<label class="custom-control-label" for="newProductCheckBox">Dodaj nowy produkt</label>
    </div>
	
	<form method="post" class="product" action="{{ route('products.store') }}">
		@csrf
        <div id="newProductData" style="display: none" class="newProduct">
       		<h3>STWÓRZ NOWY PRODUKT</h3>
            <div class="group form-row">
            	<label for="name" class="col-3">nazwa: </label>
            	<input type="text" id="name" name="name" class="form-control col-8">
            </div>
            <div class="group form-row">
            	<label for="description" class="col-3">opis (opcjonalnie): </label>
            	<input type="text" id="description" name="description" class="form-control col-8">
            </div>
            <div class="group form-row">
            	<label for="price" class="col-3">Cana jednostkowa (PLN): </label>
            	<input type="text" id="price" name="price" class="form-control col-8">
            </div>
            <div class="group form-row">
            	<label for="unit" class="col-3">jednostka: </label>
            	<input type="text" id="unit" name="unit" class="form-control col-8">
            </div>
            <div class="group form-row">
            	<label for="tax" class="col-3">podatek VAT (%): </label>
            	<input type="text" id="tax" name="tax" class="form-control col-8">
            </div>
            <button type="submit" class="btn btn-info">stwórz nowy produkt</button>
        </div>
    </form>
@endsection