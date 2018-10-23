<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('providers', [\App\Http\Controllers\ProviderController::class, 'index']);
    Route::get('providers/create', [\App\Http\Controllers\ProviderController::class, 'create']);
    Route::post('providers', [\App\Http\Controllers\ProviderController::class, 'store'])->name('providers.store');
    Route::get('providers/{provider}/edit', [\App\Http\Controllers\ProviderController::class, 'edit']);
    Route::put('providers/{provider}', [\App\Http\Controllers\ProviderController::class, 'update'])->name('providers.update');

    Route::get('products', [\App\Http\Controllers\ProductController::class, 'index']);
    Route::get('products/create', [\App\Http\Controllers\ProductController::class, 'create']);
    Route::post('products', [\App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
    Route::get('products/{product}/edit', [\App\Http\Controllers\ProductController::class, 'edit']);
    Route::put('products/{product}', [\App\Http\Controllers\ProductController::class, 'update'])->name('products.update');
});

