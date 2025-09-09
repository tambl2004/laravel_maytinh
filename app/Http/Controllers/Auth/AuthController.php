<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    // ----- ĐĂNG KÝ -----
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        // Tự động gửi email xác thực ngay sau khi tạo user
        $user->sendEmailVerificationNotification();

        // Đăng nhập cho user
        Auth::login($user);

        // Quay lại trang đăng ký với thông báo thành công
        return back()->with('registration_success', 'Đăng ký thành công! Chúng tôi đã gửi email xác thực đến địa chỉ email của bạn. Vui lòng kiểm tra email và nhấp vào liên kết xác thực để hoàn tất việc đăng ký.');
    }

    // ----- ĐĂNG NHẬP -----
    public function showLoginForm()
    {
        return view('auth.login');
    }

   // Sửa trong hàm login()
   public function login(Request $request)
   {
       $credentials = $request->validate([
           'email' => 'required|email',
           'password' => 'required',
       ]);

       // Thử đăng nhập
       if (Auth::attempt($credentials)) {
           $user = Auth::user();

           // Nếu user không phải admin và chưa xác thực email
           if ($user->role !== 'admin' && is_null($user->email_verified_at)) {
               Auth::logout(); // Đăng xuất họ ra

               // Quay lại trang đăng nhập và hiển thị thông báo lỗi
               return back()->withErrors([
                   'email' => 'Vui lòng xác thực email của bạn trước khi đăng nhập.',
               ])->onlyInput('email');
           }

           // Nếu đăng nhập thành công và đã xác thực (hoặc là admin)
           $request->session()->regenerate();
           if ($user->role === 'admin') {
               return redirect()->intended(route('admin.dashboard'));
           }
           return redirect()->intended(route('products.index'));
       }

       // Nếu sai email hoặc mật khẩu
       return back()->withErrors([
           'email' => 'Thông tin đăng nhập không chính xác.',
       ])->onlyInput('email');
   }

    // ----- ĐĂNG XUẤT -----
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}