
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

<div class="info">
	<h4>Fakturowanie</h4>
	<p>
		Aplikacja wykonana na potrzeby procesu rekrutacyjnego IAI na stanowisko: Junior Developer.
	</p>
	<p class="repo">
		<b>link do repozytorium z kodem</b>: <a href="https://github.com/MarcelDrugi/iai_recruitment_project"><img src="{{ asset('images/git.png') }}" > https://github.com/MarcelDrugi/iai_recruitment_project</a>
	</p>


    <p>
        Zadanie wykonano z wykorzystaniem frameworka Laravel 8, zgodnie ze wzorcem MVC. Do obsługi modeli wykorzystano 
        Eloquent ORM.
        Niektóre widoki posiadają skrypty JS ułatwiające korzystanie z formularzy, nie realizują one jednak
        logiki biznesowej (wszystkie obliczenia wykonywane są ponownie po stronie serwera a wyniki przedstawiane 
        użtkownikowi do zatwierdzenia).
    </p>
    
    <h4 class="personalData">Infomracje o autorze:</h4>
    <p>Piotr Mazur</p>
    <p>piotr.a.mazur@wp.pl</p>
    <p><a href="https://github.com/MarcelDrugi">https://github.com/MarcelDrugi</a></p>
</div>
@endsection