@extends('layouts.customer')

@section('title', 'Đơn hàng của tôi')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Đơn hàng của tôi</h1>

    <div class="card">
        <div class="card-body">
            @if($orders->isEmpty())
                <p class="text-center">Bạn chưa có đơn hàng nào.</p>
            @else
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Mã ĐH</th>
                            <th>Ngày Đặt</th>
                            <th>Tổng Tiền</th>
                            <th>Trạng thái</th>
                            <th>Số lượng SP</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                            <td>{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</td>
                            <td>
                                <span class="badge 
                                    @if($order->status == 'pending') bg-warning text-dark
                                    @elseif($order->status == 'processing') bg-info text-dark
                                    @elseif($order->status == 'completed') bg-success
                                    @else bg-danger
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->items_count }}</td>
                            <td class="text-end">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Xem chi tiết</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <div class="card-footer">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection