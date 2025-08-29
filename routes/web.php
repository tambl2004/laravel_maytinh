<?php
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\CategoryController; 
use App\Http\Controllers\CheckoutController; // Thêm ở trên cùng
use App\Http\Controllers\OrderController; // Thêm ở trên cùng
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
// ===== GUEST ROUTES =====
// Trang chủ, chi tiết sản phẩm và giỏ hàng cho khách
Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
// Sửa route của giỏ hàng
Route::get('/cart', [CartController::class, 'index'])->name('cart.index')->middleware(['auth', 'verified']);

// Thêm Route cho Đăng nhập & Đăng ký ở đây

// Route cho người dùng đã đăng nhập (sẽ bổ sung sau, ví dụ: trang profile)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
});

// ===== ADMIN ROUTES =====
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', CategoryController::class); // This defines admin.categories.* routes
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);

});

// Thêm Route cho Đăng ký & Đăng nhập ở đây
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Route cho đăng xuất
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Route để xử lý link trong email
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/products'); // Chuyển về trang sản phẩm sau khi xác thực thành công
})->middleware(['auth', 'signed'])->name('verification.verify');

// Route để xử lý việc gửi lại email
Route::post('/email/verify/resend', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('resent', true);
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.my');
Route::get('/my-orders/{order}', [OrderController::class, 'show'])->name('orders.show');
