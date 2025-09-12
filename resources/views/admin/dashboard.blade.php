@extends('layouts.admin.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Tổng quan hệ thống quản lý')

@section('content')
<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card primary">
        <div class="stat-icon primary">
            <i class="fas fa-dollar-sign"></i>
        </div>
        <div class="stat-value">{{ number_format($totalRevenue, 0, ',', '.') }}₫</div>
        <div class="stat-label">Tổng doanh thu</div>
    </div>
    
    <div class="stat-card success">
        <div class="stat-icon success">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div class="stat-value">{{ $totalOrders }}</div>
        <div class="stat-label">Tổng đơn hàng</div>
    </div>
    
    <div class="stat-card warning">
        <div class="stat-icon warning">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-value">{{ $totalCustomers }}</div>
        <div class="stat-label">Khách hàng</div>
    </div>
    
    <div class="stat-card danger">
        <div class="stat-icon danger">
            <i class="fas fa-laptop"></i>
        </div>
        <div class="stat-value">{{ $totalProducts ?? 0 }}</div>
        <div class="stat-label">Sản phẩm</div>
    </div>
</div>

<!-- Recent Orders -->
<div class="admin-card">
    <div class="admin-card-header">
        <h5 class="admin-card-title">
            <i class="fas fa-clock me-2"></i>
            Đơn hàng mới nhất
        </h5>
    </div>
    <div class="admin-card-body">
        <div class="admin-table">
            <table class="table">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Khách hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestOrders as $order)
                        <tr>
                            <td>
                                <strong class="text-primary">#{{ $order->id }}</strong>
                            </td>
                            <td>
                                <div>
                                    <div class="fw-semibold">{{ $order->customer_name }}</div>
                                    <small class="text-muted">{{ $order->customer_email ?? 'N/A' }}</small>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div>{{ $order->created_at->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                </div>
                            </td>
                            <td>
                                <strong>{{ number_format($order->total_amount, 0, ',', '.') }}₫</strong>
                            </td>
                            <td>
                                @php
                                    $statusClass = match($order->status) {
                                        'pending' => 'badge-pending',
                                        'processing' => 'badge-processing', 
                                        'completed' => 'badge-completed',
                                        'cancelled' => 'badge-cancelled',
                                        default => 'badge-pending'
                                    };
                                @endphp
                                <span class="badge-admin {{ $statusClass }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2"></i>
                                    <div>Chưa có đơn hàng nào</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($latestOrders->count() > 0)
            <div class="text-center mt-3">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-admin-primary">
                    <i class="fas fa-list me-2"></i>
                    Xem tất cả đơn hàng
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5 class="admin-card-title">
                    <i class="fas fa-plus-circle me-2"></i>
                    Thêm mới
                </h5>
            </div>
            <div class="admin-card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-admin-primary">
                        <i class="fas fa-laptop me-2"></i>
                        Thêm sản phẩm mới
                    </a>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-tags me-2"></i>
                        Thêm danh mục mới
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5 class="admin-card-title">
                    <i class="fas fa-chart-bar me-2"></i>
                    Thống kê nhanh
                </h5>
            </div>
            <div class="admin-card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <div class="h4 text-primary mb-1">{{ $todayOrders ?? 0 }}</div>
                            <small class="text-muted">Đơn hàng hôm nay</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="h4 text-success mb-1">{{ $todayRevenue ?? 0 }}₫</div>
                        <small class="text-muted">Doanh thu hôm nay</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection