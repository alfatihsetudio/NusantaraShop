<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MidtransController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// public
Route::get('/', [ProductController::class,'index'])->name('home');
Route::get('/product/{slug}', [ProductController::class,'show'])->name('product.show');

Route::post('/cart/add', [CartController::class,'add'])->name('cart.add');
Route::get('/cart', [CartController::class,'index'])->name('cart.index');
Route::post('/cart/remove', [CartController::class,'remove'])->name('cart.remove');

// checkout
Route::get('/checkout', [CheckoutController::class,'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class,'checkout'])->name('checkout.process');

// midtrans webhook (public)
Route::post('/midtrans/webhook', [MidtransController::class,'webhook'])->name('midtrans.webhook');

// admin (protect with auth)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function(){
    Route::resource('products', AdminProductController::class);
});
