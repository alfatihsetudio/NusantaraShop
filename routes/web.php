<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\AdminLoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Single source of truth: public routes, auth scaffold (auth.php) and
| admin routes (protected by auth + is_admin).
|
*/

/*
| Public
*/
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::post('/midtrans/webhook', [MidtransController::class, 'webhook'])->name('midtrans.webhook');

/*
| Laravel auth scaffolding (login/register/etc.)
*/
require __DIR__.'/auth.php';

/*
| Routes for authenticated users (regular users)
| - Cart & checkout only accessible setelah login
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout.process');
});

/*
| Admin auth (separate login page for admin)
| Note: Admin login page and submit are public (middleware web), but admin-protected pages use 'auth' + 'is_admin'
*/
Route::get('/admin_login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin_login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin_logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

/*
| Admin area: semua route admin berada di prefix /admin, dilindungi auth + is_admin
| IMPORTANT: we expose a route named 'dashboard' here because AdminLoginController  
| redirects to route('dashboard') setelah login.
*/
// admin area: hanya butuh login (tanpa is_admin)
Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // dashboard admin
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // resource produk admin
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
});


