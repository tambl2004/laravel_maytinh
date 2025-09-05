@extends('layouts.guest')

@section('title', 'Đăng nhập - Balo Shop')

@section('content')
<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-lg-5 col-md-7">
                <div class="auth-card">
                    <div class="card border-0 shadow-lg">
                        <div class="card-body p-5">
                            <!-- Header -->
                            <div class="text-center mb-4">
                                <div class="auth-logo mb-3">
                                    <i class="fas fa-backpack fa-3x text-primary"></i>
                                </div>
                                <h2 class="fw-bold mb-2">Chào mừng trở lại!</h2>
                                <p class="text-muted">Vui lòng đăng nhập để tiếp tục</p>
                            </div>

                            <!-- Social Login Buttons -->
                            <div class="social-login mb-4">
                                <button class="btn btn-outline-danger w-100 mb-3 social-btn">
                                    <i class="fab fa-google me-2"></i>
                                    Đăng nhập với Google
                                </button>
                                <button class="btn btn-outline-primary w-100 mb-3 social-btn">
                                    <i class="fab fa-facebook-f me-2"></i>
                                    Đăng nhập với Facebook
                                </button>
                            </div>

                            <!-- Divider -->
                            <div class="auth-divider mb-4">
                                <span class="divider-text">hoặc</span>
                            </div>

                            <!-- Login Form -->
                            <form method="POST" action="{{ route('login') }}" class="auth-form">
                                @csrf

                                @if ($errors->any())
                                    <div class="alert alert-danger border-0 rounded-3">
                                        <i class="fas fa-exclamation-circle me-2"></i>
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif

                                <div class="form-floating mb-3">
                                    <input type="email" 
                                           class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           placeholder="name@example.com"
                                           required>
                                    <label for="email">
                                        <i class="fas fa-envelope me-2"></i>Địa chỉ Email
                                    </label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-4">
                                    <input type="password" 
                                           class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Password"
                                           required>
                                    <label for="password">
                                        <i class="fas fa-lock me-2"></i>Mật khẩu
                                    </label>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                        <label class="form-check-label text-muted" for="remember">
                                            Ghi nhớ đăng nhập
                                        </label>
                                    </div>
                                    <a href="#" class="text-primary text-decoration-none small">
                                        Quên mật khẩu?
                                    </a>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                                    <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                                </button>
                            </form>

                            <!-- Register Link -->
                            <div class="text-center">
                                <p class="text-muted mb-0">
                                    Chưa có tài khoản? 
                                    <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-semibold">
                                        Đăng ký ngay
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>