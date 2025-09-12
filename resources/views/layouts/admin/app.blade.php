<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Laptop Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --admin-primary: #2563eb;
            --admin-secondary: #64748b;
            --admin-success: #10b981;
            --admin-warning: #f59e0b;
            --admin-danger: #ef4444;
            --admin-dark: #1e293b;
            --admin-light: #f8fafc;
            --admin-sidebar: #1e293b;
            --admin-sidebar-hover: #334155;
            --admin-border: #e2e8f0;
            --admin-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            --admin-shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--admin-light);
            color: var(--admin-dark);
            line-height: 1.6;
        }

        /* Admin Layout */
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .admin-sidebar {
            width: 300px;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            color: #1e293b;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            border-right: 1px solid #e2e8f0;
        }

        .admin-sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .admin-sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .admin-sidebar::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 2px;
        }

        .sidebar-header {
            padding: 2.5rem 2rem;
            border-bottom: 1px solid #e2e8f0;
            text-align: center;
            background: rgba(59, 130, 246, 0.05);
            backdrop-filter: blur(10px);
        }

        .sidebar-logo {
            font-size: 1.75rem;
            font-weight: 800;
            color: #1e293b;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
        }

        .sidebar-logo:hover {
            transform: scale(1.05);
            color: #3b82f6;
        }

        .sidebar-logo i {
            font-size: 2rem;
            color: #3b82f6;
            filter: drop-shadow(0 0 10px rgba(59, 130, 246, 0.3));
        }

        .sidebar-nav {
            padding: 1.5rem 0;
        }

        .nav-section {
            margin-bottom: 2.5rem;
        }

        .nav-section-title {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            padding: 0 2rem;
            margin-bottom: 1rem;
            position: relative;
        }

        .nav-section-title::after {
            content: '';
            position: absolute;
            bottom: -0.5rem;
            left: 2rem;
            right: 2rem;
            height: 1px;
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.3), transparent);
        }

        .nav-item {
            margin: 0.5rem 1rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.5rem;
            color: #64748b;
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 12px;
            position: relative;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .nav-link:hover {
            color: #1e293b;
            background: rgba(59, 130, 246, 0.1);
            transform: translateX(8px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
        }

        .nav-link.active {
            color: white;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            font-weight: 600;
            box-shadow: 0 4px 16px rgba(59, 130, 246, 0.3);
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: -1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 60%;
            background: #3b82f6;
            border-radius: 0 2px 2px 0;
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
        }

        .nav-link i {
            width: 24px;
            text-align: center;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .nav-link:hover i {
            transform: scale(1.1);
        }

        .nav-link.active i {
            color: #fbbf24;
        }

        /* Sidebar Footer */
        .sidebar-footer {
            margin-top: auto;
            padding: 2rem;
            border-top: 1px solid #e2e8f0;
            background: rgba(59, 130, 246, 0.02);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-radius: 16px;
            transition: all 0.3s ease;
            cursor: pointer;
            background: rgba(59, 130, 246, 0.05);
            backdrop-filter: blur(10px);
        }

        .user-profile:hover {
            background: rgba(59, 130, 246, 0.1);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.2);
        }

        .user-avatar {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
            border: 2px solid rgba(59, 130, 246, 0.1);
        }

        .user-info {
            flex: 1;
        }

        .user-info h6 {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
            color: #1e293b;
        }

        .user-info small {
            color: #64748b;
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* Main Content */
        .admin-main {
            flex: 1;
            margin-left: 300px;
            min-height: 100vh;
        }

        .admin-header {
            background: white;
            padding: 1rem 2rem;
            border-bottom: 1px solid var(--admin-border);
            box-shadow: var(--admin-shadow);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .admin-content {
            padding: 2rem;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--admin-dark);
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: var(--admin-secondary);
            font-size: 1rem;
        }

        /* Cards */
        .admin-card {
            background: white;
            border-radius: 12px;
            box-shadow: var(--admin-shadow);
            border: 1px solid var(--admin-border);
            overflow: hidden;
        }

        .admin-card-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--admin-border);
            background: #f8fafc;
        }

        .admin-card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--admin-dark);
            margin: 0;
        }

        .admin-card-body {
            padding: 1.5rem;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: var(--admin-shadow);
            border: 1px solid var(--admin-border);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--stat-color);
        }

        .stat-card.primary::before { background: var(--admin-primary); }
        .stat-card.success::before { background: var(--admin-success); }
        .stat-card.warning::before { background: var(--admin-warning); }
        .stat-card.danger::before { background: var(--admin-danger); }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 1rem;
        }

        .stat-icon.primary { background: var(--admin-primary); }
        .stat-icon.success { background: var(--admin-success); }
        .stat-icon.warning { background: var(--admin-warning); }
        .stat-icon.danger { background: var(--admin-danger); }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--admin-dark);
            margin-bottom: 0.25rem;
        }

        .stat-label {
            color: var(--admin-secondary);
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Tables */
        .admin-table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--admin-shadow);
            border: 1px solid var(--admin-border);
        }

        .admin-table table {
            margin: 0;
        }

        .admin-table th {
            background: #f8fafc;
            border: none;
            padding: 1rem;
            font-weight: 600;
            color: var(--admin-dark);
            font-size: 0.9rem;
        }

        .admin-table td {
            border: none;
            padding: 1rem;
            border-bottom: 1px solid var(--admin-border);
        }

        .admin-table tbody tr:hover {
            background: #f8fafc;
        }

        /* Buttons */
        .btn-admin {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
        }

        .btn-admin-primary {
            background: var(--admin-primary);
            border-color: var(--admin-primary);
            color: white;
        }

        .btn-admin-primary:hover {
            background: #1d4ed8;
            border-color: #1d4ed8;
            transform: translateY(-1px);
        }

        /* Badges */
        .badge-admin {
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 500;
            color: white;
        }

        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-processing { background: #dbeafe; color: #1e40af; }
        .badge-completed { background: #d1fae5; color: #065f46; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }

        /* Responsive */
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
                width: 280px;
            }

            .admin-sidebar.show {
                transform: translateX(0);
                box-shadow: 4px 0 20px rgba(0, 0, 0, 0.3);
            }

            .admin-main {
                margin-left: 0;
            }

            .admin-content {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .sidebar-header {
                padding: 2rem 1.5rem;
            }

            .nav-item {
                margin: 0.25rem 0.75rem;
            }

            .nav-link {
                padding: 0.875rem 1.25rem;
                font-size: 0.9rem;
            }

            .sidebar-footer {
                padding: 1.5rem;
            }

            .user-profile {
                padding: 0.875rem;
            }

            .user-avatar {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <div class="admin-sidebar">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
                    <i class="fas fa-laptop"></i>
                    <span>Admin</span>
                </a>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section">
                    <ul class="nav flex-column">
                         <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="fas fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                         <li class="nav-item">
                            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                                <i class="fas fa-tags"></i>
                                <span>Danh mục</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                                <i class="fas fa-laptop"></i>
                                <span>Sản phẩm</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Đơn hàng</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.news.index') }}" class="nav-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                                <i class="fas fa-newspaper"></i>
                                <span>Tin tức</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                <i class="fas fa-users"></i>
                                <span>Người dùng</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                                <i class="fas fa-chart-bar"></i>
                                <span>Báo cáo</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="sidebar-footer">
                <div class="dropdown">
                    <div class="user-profile" data-bs-toggle="dropdown">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="user-info">
                            <h6>{{ Auth::user()->name }}</h6>
                            <small>Administrator</small>
                        </div>
                        <i class="fas fa-chevron-down ms-auto"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="{{ route('products.index') }}">
                            <i class="fas fa-home me-2"></i>Xem trang chủ
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="admin-main">
            <div class="admin-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">@yield('page-title', 'Dashboard')</h4>
                        <small class="text-muted">@yield('page-subtitle', 'Tổng quan hệ thống')</small>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="text-muted">{{ now()->format('d/m/Y H:i') }}</span>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="dropdown">
                                <i class="fas fa-bell"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-content">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    @yield('scripts')
    <script>
        // Mobile sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.admin-sidebar');
            const main = document.querySelector('.admin-main');
            
            // Add mobile menu button if needed
            if (window.innerWidth <= 768) {
                const header = document.querySelector('.admin-header');
                const menuBtn = document.createElement('button');
                menuBtn.className = 'btn btn-outline-secondary btn-sm me-3';
                menuBtn.innerHTML = '<i class="fas fa-bars"></i>';
                menuBtn.onclick = () => sidebar.classList.toggle('show');
                header.querySelector('.d-flex').prepend(menuBtn);
            }
        });
    </script>
</body>
</html>