<?php

use App\Http\Controllers\IndexController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard',[IndexController::class,'index'])->name('dashboard');
    Route::get('/products/{productId}',[IndexController::class,'show'])->name('products.show');
    Route::patch('/add-to-cart/{productId}',[IndexController::class,'addCart'])->name('cart.add');
    Route::patch('/remove-to-cart/{productId}',[IndexController::class,'removeCart'])->name('cart.remove');
    Route::get('/cart',[IndexController::class,'cart'])->name('cart');
    Route::post('/order/store',[IndexController::class,'storeOrder'])->name('order.store');
});
