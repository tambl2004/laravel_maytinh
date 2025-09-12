@extends('layouts.admin.app')

@section('title', 'Chi tiết đơn hàng #' . $order->id)
@section('page-title', 'Chi tiết đơn hàng')
@section('page-subtitle', 'Xem và quản lý thông tin đơn hàng')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Đơn hàng</a></li>
        <li class="breadcrumb-item active">#{{ $order->id }}</li>
    </ol>
</nav>

<!-- Header Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-1">Đơn hàng #{{ $order->id }}</h2>
        <p class="text-muted mb-0">Chi tiết thông tin đơn hàng</p>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
        Quay lại danh sách
    </a>
</div>

<!-- Success Message -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <!-- Order Details -->
    <div class="col-lg-8">
        <!-- Order Items -->
        <div class="admin-card mb-4">
            <div class="admin-card-header">
                <h5 class="admin-card-title">Sản phẩm trong đơn hàng</h5>
            </div>
            <div class="admin-card-body p-0">
                @if($order->items->count() > 0)
                    <div class="admin-table">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="border-0">Sản phẩm</th>
                                    <th class="border-0">Giá</th>
                                    <th class="border-0">Số lượng</th>
                                    <th class="border-0">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ $item->product->image }}" 
                                                     alt="{{ $item->product->name }}" 
                                                     class="img-thumbnail me-3" 
                                                     style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="no-image me-3" style="width: 60px; height: 60px;">
                                                    <div class="d-flex align-items-center justify-content-center h-100 bg-light border rounded">
                                                        <span class="text-muted">No Image</span>
                                                    </div>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-semibold">{{ $item->product->name ?? 'Sản phẩm đã bị xóa' }}</div>
                                                @if($item->product)
                                                    <small class="text-muted">{{ $item->product->description }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-medium">{{ number_format($item->price, 0, ',', '.') }}₫</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $item->quantity }}</span>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-success">
                                            {{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="text-muted">Không có sản phẩm nào trong đơn hàng</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Customer Information -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h5 class="admin-card-title">Thông tin khách hàng</h5>
            </div>
            <div class="admin-card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tên khách hàng</label>
                            <div class="form-control-plaintext">{{ $order->customer_name }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <div class="form-control-plaintext">{{ $order->customer_email }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Số điện thoại</label>
                            <div class="form-control-plaintext">{{ $order->customer_phone }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Địa chỉ giao hàng</label>
                            <div class="form-control-plaintext">{{ $order->shipping_address }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Management -->
    <div class="col-lg-4">
        <!-- Order Status -->
        <div class="admin-card mb-4">
            <div class="admin-card-header">
                <h5 class="admin-card-title">Trạng thái đơn hàng</h5>
            </div>
            <div class="admin-card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Trạng thái hiện tại</label>
                    @php
                        $statusClass = match($order->status) {
                            'pending' => 'badge-pending',
                            'processing' => 'badge-processing', 
                            'completed' => 'badge-completed',
                            'cancelled' => 'badge-cancelled',
                            default => 'badge-pending'
                        };
                    @endphp
                    <div>
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
                    </div>
                </div>

                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="status" class="form-label fw-semibold">Cập nhật trạng thái</label>
                        <select name="status" id="status" class="form-select">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-admin-primary w-100">
                        Cập nhật trạng thái
                    </button>
                </form>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h5 class="admin-card-title">Tóm tắt đơn hàng</h5>
            </div>
            <div class="admin-card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Số sản phẩm:</span>
                    <span class="fw-semibold">{{ $order->items->sum('quantity') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Tạm tính:</span>
                    <span>{{ number_format($order->total_amount, 0, ',', '.') }}₫</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Phí vận chuyển:</span>
                    <span>Miễn phí</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span class="fw-bold">Tổng cộng:</span>
                    <span class="fw-bold text-success fs-5">{{ number_format($order->total_amount, 0, ',', '.') }}₫</span>
                </div>
            </div>
        </div>

        <!-- Order Timeline -->
        <div class="admin-card mt-4">
            <div class="admin-card-header">
                <h5 class="admin-card-title">Lịch sử đơn hàng</h5>
            </div>
            <div class="admin-card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="fw-semibold">Đơn hàng được tạo</div>
                            <small class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                    </div>
                    @if($order->status !== 'pending')
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <div class="fw-semibold">Đơn hàng được xử lý</div>
                                <small class="text-muted">{{ $order->updated_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                    @endif
                    @if($order->status === 'completed')
                        <div class="timeline-item">
                            <div class="timeline-marker completed"></div>
                            <div class="timeline-content">
                                <div class="fw-semibold">Đơn hàng hoàn thành</div>
                                <small class="text-muted">{{ $order->updated_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.no-image {
    width: 60px;
    height: 60px;
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -25px;
    top: 5px;
    width: 10px;
    height: 10px;
    background: #6c757d;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #6c757d;
}

.timeline-marker.completed {
    background: #28a745;
    box-shadow: 0 0 0 2px #28a745;
}

.timeline-content {
    padding-left: 10px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: -20px;
    top: 15px;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}
</style>
@endsection