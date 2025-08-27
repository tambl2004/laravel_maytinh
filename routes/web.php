<?php
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;

// ===== GUEST ROUTES =====
// Trang chủ, chi tiết sản phẩm và giỏ hàng cho khách
Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// TODO: Thêm Route cho Đăng nhập & Đăng ký ở đây

// ===== AUTHENTICATED ROUTES =====
// Route cho người dùng đã đăng nhập (sẽ bổ sung sau, ví dụ: trang profile)
Route::middleware('auth')->group(function () {
    //
});

// ===== ADMIN ROUTES =====
// Route cho admin, được bảo vệ bởi middleware 'auth' và 'admin'
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
});

// Thêm Route cho Đăng ký & Đăng nhập ở đây
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Route cho đăng xuất
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');