<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Thêm một chút CSS tùy chỉnh nếu cần */
        body {
            background-color: #f8f9fa;
        }

        .product-card {
            margin-bottom: 24px;
        }
    </style>
</head>

<body>

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
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Đăng ký</a>
                </li>
            @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
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

    <div class="container mt-4">
        <div class="p-4 mb-4 bg-light rounded-3">
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold">Chào mừng đến với Tablet Shop!</h1>
                <p class="col-md-8 fs-4">Nơi bạn có thể tìm thấy những chiếc máy tính bảng tốt nhất.</p>
            </div>
        </div>

        <div class="row">
            @foreach ($products as $product)
            {{-- Mỗi sản phẩm chiếm 4 cột trên màn hình vừa, 6 cột trên màn hình nhỏ --}}
            <div class="col-md-4 col-sm-6 product-card">
                <div class="card h-100">
                    <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-muted flex-grow-1">{{ Str::limit($product->description, 100) }}</p>
                        <h4 class="text-danger">{{ number_format($product->price, 0, ',', '.') }} VNĐ</h4>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-primary mt-auto">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>