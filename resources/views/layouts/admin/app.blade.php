<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Laptop Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <style>
        /* Giao diện sáng, tối giản - không dùng màu tím */
        body { background:#f6f8fb; }
        .admin-sidebar { background:#ffffff; border-right:1px solid #e9ecef; box-shadow: 0 0 20px rgba(0,0,0,0.04); }
        .admin-main { min-height: calc(100vh - 56px); }
        @media (min-width: 992px) {
            .admin-sidebar { position: sticky; top: 56px; height: calc(100vh - 56px); }
        }
        .list-group-item { border: 0; padding: .65rem .9rem; color:#495057; display:flex; align-items:center; border-left: 3px solid transparent; transition: all .15s ease; }
        .list-group-item i { width: 18px; text-align:center; margin-right:.5rem; color:#6c757d; }
        .list-group-item:hover { background:#f8f9fa; color:#212529; border-left-color:#cfe2ff; }
        .list-group-item.active { background:#e7f1ff; color:#0d6efd; font-weight:600; border-left-color:#0d6efd; }
        .list-group-item.active i { color:#0d6efd; }
        .navbar { backdrop-filter: saturate(120%) blur(2px); }
        .page-section { background:#fff; border:1px solid #e9ecef; border-radius:.75rem; padding:1rem; box-shadow: 0 6px 20px rgba(0,0,0,0.04); }
        .page-heading { margin-bottom: .25rem; font-weight: 600; }
        .page-toolbar .btn { border-radius:.4rem; }
        .breadcrumb { --bs-breadcrumb-divider: '›'; }
    </style>
</head>
<body>
    <!-- Navbar đơn giản -->
    <nav class="navbar navbar-light bg-light border-bottom">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-toolbox me-2"></i>Admin
            </a>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-home me-1"></i>Trang chủ
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mb-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-sign-out-alt me-1"></i>Đăng xuất
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Bố cục 2 cột thuần Bootstrap -->
    <div class="container-fluid">
        <div class="row">
            <aside class="col-12 col-md-3 col-lg-2 admin-sidebar py-3">
                <div class="list-group list-group-flush small">
                    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-gauge me-2"></i>Dashboard
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="fas fa-tags me-2"></i>Danh mục
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <i class="fas fa-laptop me-2"></i>Sản phẩm
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart me-2"></i>Đơn hàng
                    </a>
                    <a href="{{ route('admin.news.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                        <i class="fas fa-newspaper me-2"></i>Tin tức
                    </a>
                    <a href="{{ route('admin.reviews.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                        <i class="fas fa-star me-2"></i>Đánh giá
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-users me-2"></i>Người dùng
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-line me-2"></i>Báo cáo
                    </a>
                    <a href="{{ route('admin.promotions.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.promotions.*') ? 'active' : '' }}">
                        <i class="fas fa-percent me-2"></i>Khuyến mãi
                    </a>
                    <a href="{{ route('admin.faq.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.faq.*') ? 'active' : '' }}">
                        <i class="fas fa-circle-question me-2"></i>FAQ
                    </a>
                </div>
            </aside>
            <main class="col-12 col-md-9 col-lg-10 py-3 admin-main">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <h5 class="page-heading">@yield('page-title', 'Dashboard')</h5>
                        <small class="text-muted">@yield('page-subtitle')</small>
                    </div>
                    <div class="page-toolbar d-flex gap-2">
                        @yield('page-actions')
                    </div>
                </div>
                @hasSection('breadcrumbs')
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb mb-0 small">
                            @yield('breadcrumbs')
                        </ol>
                    </nav>
                @endif
                <div class="page-section">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Kích hoạt tooltip Bootstrap trên toàn trang (nếu có sử dụng)
        document.addEventListener('DOMContentLoaded', function () {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function (el) { new bootstrap.Tooltip(el); });
        });
    </script>
    @yield('scripts')
</body>
</html>