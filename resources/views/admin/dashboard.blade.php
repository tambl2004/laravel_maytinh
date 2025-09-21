@extends('layouts.admin.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Tổng quan hệ thống quản lý')

@section('content')
<!-- Stats Cards -->
<div class="stats-grid">
    @include('components.admin.stat-card', [
        'type' => 'primary',
        'value' => number_format($totalRevenue, 0, ',', '.') . '₫',
        'label' => 'Tổng doanh thu',
        'icon' => 'fas fa-dollar-sign'
    ])
    
    @include('components.admin.stat-card', [
        'type' => 'success',
        'value' => $totalOrders,
        'label' => 'Tổng đơn hàng',
        'icon' => 'fas fa-shopping-cart'
    ])
    
    @include('components.admin.stat-card', [
        'type' => 'warning',
        'value' => $totalCustomers,
        'label' => 'Khách hàng',
        'icon' => 'fas fa-users'
    ])
    
    @include('components.admin.stat-card', [
        'type' => 'danger',
        'value' => $totalProducts ?? 0,
        'label' => 'Sản phẩm',
        'icon' => 'fas fa-laptop'
    ])
</div>

<!-- Recent Orders -->
@php
    $tableContent = '';
    if($latestOrders->count() > 0) {
        foreach($latestOrders as $order) {
            $tableContent .= '<tr>';
            $tableContent .= '<td><strong class="text-admin-primary">#' . $order->id . '</strong></td>';
            $tableContent .= '<td><div><div class="fw-semibold">' . $order->customer_name . '</div><small class="text-muted">' . ($order->customer_email ?? 'N/A') . '</small></div></td>';
            $tableContent .= '<td><div><div>' . $order->created_at->format('d/m/Y') . '</div><small class="text-muted">' . $order->created_at->format('H:i') . '</small></div></td>';
            $tableContent .= '<td><strong>' . number_format($order->total_amount, 0, ',', '.') . '₫</strong></td>';
            $tableContent .= '<td><span class="badge-admin badge-' . $order->status . '">' . ucfirst($order->status) . '</span></td>';
            $tableContent .= '<td><a href="' . route('admin.orders.show', $order) . '" class="btn-admin btn-admin-outline btn-admin-sm"><i class="fas fa-eye"></i></a></td>';
            $tableContent .= '</tr>';
        }
    } else {
        $tableContent = '<tr><td colspan="6" class="text-center py-4"><div class="text-muted"><i class="fas fa-inbox fa-2x mb-2"></i><div>Chưa có đơn hàng nào</div></div></td></tr>';
    }
@endphp

@include('components.admin.card', [
    'title' => 'Đơn hàng mới nhất',
    'subtitle' => 'Danh sách các đơn hàng gần đây',
    'headerActions' => '<i class="fas fa-clock"></i>',
    'content' => view('components.admin.table', [
        'headers' => ['Mã đơn hàng', 'Khách hàng', 'Ngày đặt', 'Tổng tiền', 'Trạng thái', 'Hành động'],
        'content' => $tableContent
    ])->render() . ($latestOrders->count() > 0 ? '<div class="text-center mt-3"><a href="' . route('admin.orders.index') . '" class="btn-admin btn-admin-primary"><i class="fas fa-list me-2"></i>Xem tất cả đơn hàng</a></div>' : '')
])

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-md-6">
        @include('components.admin.card', [
            'title' => 'Thêm mới',
            'subtitle' => 'Tạo nội dung mới cho hệ thống',
            'content' => '<div class="d-grid gap-2">
                <a href="' . route('admin.products.create') . '" class="btn-admin btn-admin-primary">
                    <i class="fas fa-laptop me-2"></i>Thêm sản phẩm mới
                </a>
                <a href="' . route('admin.categories.create') . '" class="btn-admin btn-admin-outline">
                    <i class="fas fa-tags me-2"></i>Thêm danh mục mới
                </a>
            </div>'
        ])
    </div>
    
    <div class="col-md-6">
        @include('components.admin.card', [
            'title' => 'Thống kê nhanh',
            'subtitle' => 'Số liệu hôm nay',
            'content' => '<div class="row text-center">
                <div class="col-6">
                    <div class="border-end">
                        <div class="h4 text-admin-primary mb-1">' . ($todayOrders ?? 0) . '</div>
                        <small class="text-muted">Đơn hàng hôm nay</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="h4 text-admin-success mb-1">' . ($todayRevenue ?? 0) . '₫</div>
                    <small class="text-muted">Doanh thu hôm nay</small>
                </div>
            </div>'
        ])
    </div>
</div>
@endsection