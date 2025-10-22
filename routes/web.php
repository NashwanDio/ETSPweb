<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController; // Import the new controller

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ProductController::class, 'index'])->name('products.index');

// Resource route for products
// This will automatically create routes for:
// index, create, store, show, edit, update, destroy
Route::resource('products', ProductController::class);

// Resource route for categories
Route::resource('categories', CategoryController::class)->except(['show']);


// Cart Routes
Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::post('cart/{product}', [CartController::class, 'store'])->name('cart.store');
Route::patch('cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
