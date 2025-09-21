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
                <i class="fas fa-toolbox me-2"></i>Laptop Shop
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
                <!-- Sidebar Header -->
                <div class="admin-sidebar-header">
                    <a href="{{ route('admin.dashboard') }}" class="admin-sidebar-brand">
                        <div class="admin-sidebar-brand-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        Admin
                    </a>
                </div>
                
                <!-- Sidebar Navigation -->
                <div class="admin-sidebar-nav">
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
    
    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>
    
    <script>
        // Kích hoạt tooltip Bootstrap trên toàn trang (nếu có sử dụng)
        document.addEventListener('DOMContentLoaded', function () {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function (el) { new bootstrap.Tooltip(el); });
            
            // Khởi tạo toast system
            initToastSystem();
        });
        
        // Toast Notification System
        function initToastSystem() {
            // Tạo container nếu chưa có
            if (!document.getElementById('toastContainer')) {
                const container = document.createElement('div');
                container.className = 'toast-container';
                container.id = 'toastContainer';
                document.body.appendChild(container);
            }
        }
        
        // Hiển thị toast notification
        function showToast(type, title, message, duration = 5000) {
            const container = document.getElementById('toastContainer');
            const toastId = 'toast-' + Date.now();
            
            const toastHtml = `
                <div class="toast-notification toast-${type}" id="${toastId}" data-duration="${duration}">
                    <div class="toast-icon" style="background: ${getToastConfig(type).bg}">
                        <i class="${getToastConfig(type).icon}"></i>
                    </div>
                    <div class="toast-content">
                        ${title ? `<div class="toast-title">${title}</div>` : ''}
                        ${message ? `<div class="toast-message">${message}</div>` : ''}
                    </div>
                    <button type="button" class="toast-close" onclick="hideToast('${toastId}')">
                        <i class="fas fa-times"></i>
                    </button>
                    <div class="toast-progress" style="background: ${getToastConfig(type).bg}; animation-duration: ${duration}ms;"></div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', toastHtml);
            
            // Hiển thị toast với animation
            setTimeout(() => {
                const toast = document.getElementById(toastId);
                if (toast) {
                    toast.style.display = 'flex';
                    setTimeout(() => toast.classList.add('show'), 10);
                }
            }, 10);
            
            // Tự động ẩn toast
            if (duration > 0) {
                setTimeout(() => hideToast(toastId), duration);
            }
        }
        
        // Ẩn toast notification
        function hideToast(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.classList.add('hide');
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 300);
            }
        }
        
        // Cấu hình toast
        function getToastConfig(type) {
            const configs = {
                'success': {
                    bg: 'linear-gradient(135deg, #10b981 0%, #059669 100%)',
                    icon: 'fas fa-check-circle'
                },
                'error': {
                    bg: 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)',
                    icon: 'fas fa-times-circle'
                },
                'danger': {
                    bg: 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)',
                    icon: 'fas fa-exclamation-triangle'
                },
                'warning': {
                    bg: 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)',
                    icon: 'fas fa-exclamation-triangle'
                },
                'info': {
                    bg: 'linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)',
                    icon: 'fas fa-info-circle'
                }
            };
            return configs[type] || configs['info'];
        }
        
        // Xử lý session messages từ Laravel
        @if(session('success'))
            showToast('success', 'Thành công', '{{ session('success') }}');
        @endif
        
        @if(session('error'))
            showToast('error', 'Lỗi', '{{ session('error') }}');
        @endif
        
        @if(session('warning'))
            showToast('warning', 'Cảnh báo', '{{ session('warning') }}');
        @endif
        
        @if(session('info'))
            showToast('info', 'Thông tin', '{{ session('info') }}');
        @endif
    </script>
    @yield('scripts')
</body>
</html>