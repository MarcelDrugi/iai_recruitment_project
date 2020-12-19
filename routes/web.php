<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\HomepageController@index')->name('homepage.index');

Route::get('/products', 'App\Http\Controllers\ProductController@index')->name('products.index');
Route::put('/products', 'App\Http\Controllers\ProductController@update')->name('products.update');
Route::post('/products', 'App\Http\Controllers\ProductController@store')->name('products.store');

Route::get('/newinvoice', 'App\Http\Controllers\InvoiceController@index')->name('invoice.index');
Route::post('/newinvoice', 'App\Http\Controllers\InvoiceController@store')->name('invoice.store');

Route::get('/preview', 'App\Http\Controllers\InvoicePreviewController@index')->name('invoice-preview.index');
Route::post('/preview', 'App\Http\Controllers\InvoicePreviewController@store')->name('invoice-preview.store');

Route::get('/list', 'App\Http\Controllers\InvoiceListController@index')->name('invoice-list.index');
Route::delete('/list', 'App\Http\Controllers\InvoiceListController@destroy')->name('invoice-list.destroy');
