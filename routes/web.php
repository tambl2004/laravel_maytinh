<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

Route::get('/', function () {
    return view('welcome');
});

// Đặt tên cho route trang chủ là 'products.index'
Route::get('/', [ProductController::class, 'index'])->name('products.index');

// Tạo route mới cho trang chi tiết sản phẩm
// {product} là một tham số động, nó sẽ chứa ID của sản phẩm
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');