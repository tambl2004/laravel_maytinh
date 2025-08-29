@extends('layouts.customer')

@section('title', 'Chi tiết đơn hàng #' . $order->id)

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Chi tiết đơn hàng #{{ $order->id }}</h1>
        <a href="{{ route('orders.my') }}" class="btn btn-secondary">Quay lại danh sách</a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Sản phẩm trong đơn hàng</div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <p class="fw-bold mb-0">{{ $item->product_name }}</p>
                                    <small class="text-muted">Giá: {{ number_format($item->price, 0, ',', '.') }} VNĐ</small>
                                </td>
                                <td class="text-center">x {{ $item->quantity }}</td>
                                <td class="text-end fw-bold">{{ number_format($item->price * $item->quantity, 0, ',', '.') }} VNĐ</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Thông tin đơn hàng</div>
                <div class="card-body">
                    <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Tổng tiền:</strong> <span class="fs-5 text-danger fw-bold">{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</span></p>
                    <p><strong>Trạng thái:</strong> {{ ucfirst($order->status) }}</p>
                    <hr>
                    <h5 class="card-title">Địa chỉ giao hàng</h5>
                    <p class="card-text mb-0"><strong>{{ $order->customer_name }}</strong></p>
                    <p class="card-text mb-0">{{ $order->customer_phone }}</p>
                    <p class="card-text mb-0">{{ $order->customer_email }}</p>
                    <p class="card-text">{{ $order->customer_address }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection