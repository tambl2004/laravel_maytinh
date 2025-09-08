<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Balo Shop')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- Modular CSS files for better organization --}}
    <link rel="stylesheet" href="{{ asset('css/base-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cart-checkout-styles.css') }}">
    @yield('styles')
</head>
<body>
    {{-- Cấu trúc flex để đẩy footer xuống cuối trang --}}
    <div class="d-flex flex-column min-vh-100">
        <nav class="navbar navbar-expand-lg navbar-dark bg-gradient-primary shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                    <i class="fas fa-backpack me-2"></i>Balo Shop
                </a>
                <ul class="navbar-nav ms-auto d-flex flex-row align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i>Trang chủ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">
                            <i class="fas fa-backpack me-1"></i>Sản phẩm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact.index') }}">
                            <i class="fas fa-envelope me-1"></i>Liên hệ
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart me-1"></i>Giỏ hàng 
                            @if(count((array) session('cart')) > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">
                                    {{ count((array) session('cart')) }}
                                    <span class="visually-hidden">sản phẩm trong giỏ</span>
                                </span>
                            @endif
                        </a>
                    </li>
                    @guest
                        <li class="nav-item me-2">
                            <a class="nav-link btn btn-outline-light btn-sm px-3" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>Đăng nhập
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-warning btn-sm px-3 text-dark" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-1"></i>Đăng ký
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="user-avatar me-2">
                                    <i class="fas fa-user-circle fa-lg"></i>
                                </div>
                                <span>{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" aria-labelledby="navbarDropdown">
                                <li><h6 class="dropdown-header"><i class="fas fa-user me-2"></i>Tài khoản của tôi</h6></li>
                                <li><a class="dropdown-item" href="{{ route('addresses.index') }}">
                                    <i class="fas fa-map-marker-alt me-2 text-primary"></i>Địa chỉ của tôi
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.my') }}">
                                    <i class="fas fa-box me-2 text-success"></i>Đơn hàng của tôi
                                </a></li>
                                @if(Auth::user()->role === 'admin')
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-cogs me-2 text-warning"></i>Trang Admin
                                    </a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>

        <main class="flex-grow-1">
            @yield('content')
        </main>

        {{-- Footer mới --}}
        <footer class="footer mt-auto py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mb-4">
                        <h5 class="fw-bold mb-3">
                            <i class="fas fa-backpack me-2 text-warning"></i>Balo Shop
                        </h5>
                        <p class="text-muted mb-3">Đồng hành cùng mọi hành trình của bạn với những chiếc balo chất lượng cao, phong cách và tiện dụng.</p>
                        <div class="social-links">
                            <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
                            <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
                            <a href="#" class="text-white me-3"><i class="fab fa-youtube fa-lg"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 mb-4">
                        <h6 class="fw-bold mb-3">Liên kết</h6>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Trang chủ</a></li>
                            <li><a href="{{ route('products.index') }}" class="text-white-50 text-decoration-none">Sản phẩm</a></li>
                            <li><a href="{{ route('contact.index') }}" class="text-white-50 text-decoration-none">Liên hệ</a></li>
                            <li><a href="#" class="text-white-50 text-decoration-none">Giới thiệu</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <h6 class="fw-bold mb-3">Hỗ trợ khách hàng</h6>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-white-50 text-decoration-none">Hướng dẫn mua hàng</a></li>
                            <li><a href="#" class="text-white-50 text-decoration-none">Chính sách đổi trả</a></li>
                            <li><a href="#" class="text-white-50 text-decoration-none">Bảo hành</a></li>
                            <li><a href="#" class="text-white-50 text-decoration-none">Câu hỏi thường gặp</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 mb-4">
                        <h6 class="fw-bold mb-3">Liên hệ</h6>
                        <div class="contact-info">
                            <p class="text-white-50 mb-2">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                123 Đường ABC, Quận XYZ, TP.HCM
                            </p>
                            <p class="text-white-50 mb-2">
                                <i class="fas fa-phone me-2"></i>
                                0123 456 789
                            </p>
                            <p class="text-white-50 mb-2">
                                <i class="fas fa-envelope me-2"></i>
                                info@baloshop.vn
                            </p>
                        </div>
                    </div>
                </div>
               
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>