@extends('layouts.guest')

@section('title', 'Đăng ký - Balo Shop')

@section('content')
<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-lg-5 col-md-8">
                <div class="auth-card">
                    <div class="card border-0 shadow-lg">
                        <div class="card-body p-5">
                            <!-- Header -->
                            <div class="text-center mb-4">
                                <div class="auth-logo mb-3">
                                    <i class="fas fa-backpack fa-3x text-primary"></i>
                                </div>
                                <h2 class="fw-bold mb-2">Tạo tài khoản mới</h2>
                            </div>

                            <!-- Success Message -->
                            @if(session('registration_success'))
                                <div class="alert alert-success border-0 rounded-3 mb-4">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-check-circle me-3 text-success mt-1"></i>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold">Đăng ký thành công!</h6>
                                            <p class="mb-2 small">{{ session('registration_success') }}</p>
                                            <a href="{{ route('login') }}" class="btn btn-success btn-sm">
                                                <i class="fas fa-sign-in-alt me-1"></i>Đi đến trang đăng nhập
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <!-- Registration Form -->
                            <form method="POST" action="{{ route('register') }}" class="auth-form">
                                @csrf
                                
                                <div class="form-floating mb-3">
                                    <input type="text" 
                                           class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ session('registration_success') ? '' : old('name') }}" 
                                           placeholder="Nguyễn Văn A"
                                           required>
                                    <label for="name">
                                        <i class="fas fa-user me-2"></i>Họ và tên
                                    </label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="email" 
                                           class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ session('registration_success') ? '' : old('email') }}" 
                                           placeholder="name@example.com"
                                           required>
                                    <label for="email">
                                        <i class="fas fa-envelope me-2"></i>Địa chỉ Email
                                    </label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
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
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="password" 
                                                   class="form-control form-control-lg" 
                                                   id="password_confirmation" 
                                                   name="password_confirmation" 
                                                   placeholder="Confirm Password"
                                                   required>
                                            <label for="password_confirmation">
                                                <i class="fas fa-lock me-2"></i>Xác nhận mật khẩu
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" id="terms" required>
                                    <label class="form-check-label text-muted" for="terms">
                                        Tôi đồng ý với 
                                        <a href="#" class="text-primary text-decoration-none">Thỏa thuận sử dụng</a> 
                                        và 
                                        <a href="#" class="text-primary text-decoration-none">Chính sách bảo mật</a>
                                    </label>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                                    <i class="fas fa-user-plus me-2"></i>Tạo tài khoản
                                </button>
                            </form>

                            <!-- Divider -->
                            <div class="divider-text mb-3">
                                <span class="text-muted small bg-white px-3">Hoặc đăng ký bằng</span>
                            </div>

                            <!-- Google Registration Button -->
                            <a href="{{ route('auth.google') }}" class="btn btn-outline-danger btn-lg w-100 mb-3">
                                <i class="fab fa-google me-2"></i>Đăng ký với Google
                            </a>

                            <!-- Login Link -->
                            <div class="text-center">
                                <p class="text-muted mb-0">
                                    Đã có tài khoản? 
                                    <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-semibold">
                                        Đăng nhập ngay
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