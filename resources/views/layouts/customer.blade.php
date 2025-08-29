<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tablet Shop')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Link tới file CSS tùy chỉnh của chúng ta --}}
    <link rel="stylesheet" href="{{ asset('css/customer-style.css') }}">
    @yield('styles')
</head>
<body>
    {{-- Cấu trúc flex để đẩy footer xuống cuối trang --}}
    <div class="d-flex flex-column min-vh-100">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ route('products.index') }}">Tablet Shop</a>
                <ul class="navbar-nav ms-auto d-flex flex-row">
                    <li class="nav-item me-3">
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            Giỏ hàng <span class="badge bg-danger">{{ count((array) session('cart')) }}</span>
                        </a>
                    </li>
                    @guest
                        <li class="nav-item me-2">
                            <a class="nav-link" href="{{ route('login') }}">Đăng nhập</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('orders.my') }}">Đơn hàng của tôi</a></li>
                                @if(Auth::user()->role === 'admin')
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Trang Admin</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Đăng xuất</button>
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
        <footer class="footer mt-auto py-3">
            <div class="container text-center">
                <span class="text-muted">© 2025 Tablet Shop - Xây dựng với Laravel bởi Đối tác lập trình.</span>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>