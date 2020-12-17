<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\HomepageController@index')->name('homepage.index');

Route::get('/products', 'App\Http\Controllers\ProductController@index')->name('products.index');
Route::put('/products', 'App\Http\Controllers\ProductController@update')->name('products.update');
Route::post('/products', 'App\Http\Controllers\ProductController@store')->name('products.store');

