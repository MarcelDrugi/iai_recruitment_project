
@extends('layout')

@section('content')
<div class="tabs">
	<ul class="nav nav-tabs">
		<li class="nav-item"><a class="nav-link active" href="{{ route('homepage.index') }}">Strona główna</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Dodaj/usuń produkt</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('invoice.index') }}">Wystaw fakturę</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('invoice-list.index') }}">Wystawione faktury</a></li>
	</ul>
</div>
	<h2>Witaj na stronie głównej</h2>
@endsection