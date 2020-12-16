<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\HomepageController@index')->name('homepage.index');
