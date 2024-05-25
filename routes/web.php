<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BusinessController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    // Route::resource('invoices', InvoiceController::class);
    Route::resource('business', BusinessController::class);
    Route::get('/invoice/{id}', [App\Http\Controllers\InvoiceController::class, 'show'])->name('invoice.show');
    Route::post('/get-details', [App\Http\Controllers\InvoiceController::class, 'getDetails'])->name('get.details');
    Route::get('/get-details', [App\Http\Controllers\InvoiceController::class, 'getDetails'])->name('get.details');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
