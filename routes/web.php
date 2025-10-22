<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;

// Dashboard route - redirect to products
Route::get('/dashboard', function () {
    return redirect()->route('products.index');
})->middleware(['auth'])->name('dashboard');

// Public routes - anyone can view
Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');

// Cart routes - viewing cart is public, but checkout requires auth
Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::post('cart/{product}', [CartController::class, 'store'])->name('cart.store');
Route::patch('cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

// Checkout route - requires authentication
Route::post('cart/checkout', [CartController::class, 'checkout'])
    ->middleware('auth')
    ->name('cart.checkout');

// Admin only routes - requires authentication AND admin role
Route::middleware(['auth', 'admin'])->group(function () {
    // Product management
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::patch('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    
    // Category management
    Route::resource('categories', CategoryController::class)->except(['show']);
});

require __DIR__.'/auth.php';
