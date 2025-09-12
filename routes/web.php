<?php

use Illuminate\Support\Facades\Route;

// --- Import Controllers ---
// Controllers cho Khách hàng
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;

// Controllers cho Xác thực
use App\Http\Controllers\Auth\AuthController;

// Controllers cho Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ReportController; 

use App\Http\Controllers\NewsController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AddressController;
/*
|--------------------------------------------------------------------------
| KHU VỰC ROUTE CHO KHÁCH (GUEST & CUSTOMER)
|--------------------------------------------------------------------------
|
| Các route này dành cho tất cả người dùng, bao gồm cả khách vãng lai.
|
*/
// Trang chủ mới với sản phẩm nổi bật
Route::get('/', [HomeController::class, 'index'])->name('home');

// Dashboard cho người dùng thường
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Hồ sơ người dùng (sửa, cập nhật, xoá tài khoản)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Trang hiển thị TẤT CẢ sản phẩm (trang chủ cũ)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Tin tức
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::get('/my-addresses', [AddressController::class, 'index'])->name('addresses.index');
Route::post('/my-addresses', [AddressController::class, 'store'])->name('addresses.store');
Route::patch('/my-addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
Route::post('/my-addresses/{address}/default', [AddressController::class, 'setDefault'])->name('addresses.setDefault');
Route::delete('/my-addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');

/*
|--------------------------------------------------------------------------
| KHU VỰC ROUTE XÁC THỰC (AUTH)
|--------------------------------------------------------------------------
|
| Các route xử lý việc đăng ký, đăng nhập, đăng xuất và xác thực email.
|
*/
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Email Verification ---
// Các route xác thực đã được định nghĩa tập trung trong routes/auth.php


/*
|--------------------------------------------------------------------------
| KHU VỰC ROUTE CỦA KHÁCH HÀNG ĐÃ ĐĂNG NHẬP
|--------------------------------------------------------------------------
|
| Các route này yêu cầu người dùng phải đăng nhập và đã xác thực email.
|
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Cart
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::patch('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    
    // My Orders
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.my');
    Route::get('/my-orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});


/*
|--------------------------------------------------------------------------
| KHU VỰC ROUTE CỦA ADMIN
|--------------------------------------------------------------------------
|
| Tất cả các route trong này đều được bảo vệ và có tiền tố /admin.
|
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/chart-data', [ReportController::class, 'getChartData'])->name('reports.chart-data');
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
    Route::resource('users', AdminUserController::class);
    Route::resource('news', AdminNewsController::class);
});

// Nạp nhóm route xác thực (register/login/verify...) để có route verification.verify
require __DIR__.'/auth.php';