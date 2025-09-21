@extends('layouts.admin.app')

@section('title', 'Quản lý đơn hàng')
@section('page-title', 'Quản lý đơn hàng')
@section('page-subtitle', 'Theo dõi và quản lý các đơn hàng của khách hàng')

@section('content')
<!-- Header Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-1">Đơn hàng hệ thống</h2>
        <p class="text-muted mb-0">Theo dõi và quản lý các đơn hàng của khách hàng</p>
    </div>
    <div class="d-flex gap-2">
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                Lọc theo trạng thái
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('admin.orders.index') }}">Tất cả</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.orders.index', ['status' => 'pending']) }}">Chờ xử lý</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.orders.index', ['status' => 'processing']) }}">Đang xử lý</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.orders.index', ['status' => 'completed']) }}">Hoàn thành</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}">Đã hủy</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- Stats Cards -->
<div class="stats-grid">
    @include('components.admin.stat-card', [
        'type' => 'primary',
        'value' => $orders->total(),
        'label' => 'Tổng đơn hàng',
        'icon' => 'fas fa-shopping-cart'
    ])
    
    @include('components.admin.stat-card', [
        'type' => 'warning',
        'value' => $orders->where('status', 'pending')->count(),
        'label' => 'Chờ xử lý',
        'icon' => 'fas fa-clock'
    ])
    
    @include('components.admin.stat-card', [
        'type' => 'success',
        'value' => $orders->where('status', 'completed')->count(),
        'label' => 'Hoàn thành',
        'icon' => 'fas fa-check-circle'
    ])
    
    @include('components.admin.stat-card', [
        'type' => 'danger',
        'value' => $orders->where('status', 'cancelled')->count(),
        'label' => 'Đã hủy',
        'icon' => 'fas fa-times-circle'
    ])
</div>
<!-- Orders Table -->
<div class="admin-card">
    <div class="admin-card-header">
        <h5 class="admin-card-title">Danh sách đơn hàng</h5>
    </div>
    <div class="admin-card-body p-0">
        @if($orders->count() > 0)
            <div class="admin-table">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="border-0">Mã đơn hàng</th>
                            <th class="border-0">Khách hàng</th>
                            <th class="border-0">Sản phẩm</th>
                            <th class="border-0">Ngày đặt</th>
                            <th class="border-0">Tổng tiền</th>
                            <th class="border-0">Trạng thái</th>
                            <th class="border-0 text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>
                                <div>
                                    <div class="fw-bold text-primary">#{{ $order->id }}</div>
                                    <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div class="fw-semibold">{{ $order->customer_name }}</div>
                                    <small class="text-muted">{{ $order->customer_email }}</small>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div class="fw-medium">{{ $order->items_count ?? 0 }} sản phẩm</div>
                                    <small class="text-muted">{{ $order->customer_phone }}</small>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div>{{ $order->created_at->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-success">
                                    {{ number_format($order->total_amount, 0, ',', '.') }}₫
                                </div>
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
                                    @switch($order->status)
                                        @case('pending')
                                            Chờ xử lý
                                            @break
                                        @case('processing')
                                            Đang xử lý
                                            @break
                                        @case('completed')
                                            Hoàn thành
                                            @break
                                        @case('cancelled')
                                            Đã hủy
                                            @break
                                        @default
                                            {{ ucfirst($order->status) }}
                                    @endswitch
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.orders.show', $order) }}" 
                                       class="btn btn-sm btn-outline-primary" 
                                       title="Xem chi tiết">
                                        Xem
                                    </a>
                                    @if($order->status === 'pending')
                                        <form action="{{ route('admin.orders.update', $order) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="processing">
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-success" 
                                                    title="Xử lý đơn hàng"
                                                    onclick="return confirm('Xác nhận xử lý đơn hàng này?');">
                                                Xử lý
                                            </button>
                                        </form>
                                    @elseif($order->status === 'processing')
                                        <form action="{{ route('admin.orders.update', $order) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-success" 
                                                    title="Hoàn thành đơn hàng"
                                                    onclick="return confirm('Xác nhận hoàn thành đơn hàng này?');">
                                                Hoàn thành
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <div class="empty-state">
                    <h4 class="text-muted">Chưa có đơn hàng nào</h4>
                    <p class="text-muted mb-4">Các đơn hàng của khách hàng sẽ hiển thị ở đây</p>
                </div>
            </div>
        @endif
    </div>
    
    @if($orders->count() > 0)
        <div class="admin-card-body border-top">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Hiển thị {{ $orders->firstItem() }} - {{ $orders->lastItem() }} 
                    trong tổng số {{ $orders->total() }} đơn hàng
                </div>
                <div>
                    {!! $orders->links() !!}
                </div>
            </div>
        </div>
    @endif
</div>


@endsection