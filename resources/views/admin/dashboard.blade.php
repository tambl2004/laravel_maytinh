@extends('layouts.admin.app')

@section('title', 'Báo cáo Thống kê')

@section('content')
    <h1 class="mb-4">Báo cáo Thống kê</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Tổng Doanh thu</div>
                <div class="card-body">
                    <h5 class="card-title fs-2">{{ number_format($totalRevenue, 0, ',', '.') }} VNĐ</h5>
                    <p class="card-text">Tính trên các đơn hàng đã hoàn thành.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Tổng số Đơn hàng</div>
                <div class="card-body">
                    <h5 class="card-title fs-2">{{ $totalOrders }}</h5>
                    <p class="card-text">Bao gồm tất cả các trạng thái.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Số lượng Khách hàng</div>
                <div class="card-body">
                    <h5 class="card-title fs-2">{{ $totalCustomers }}</h5>
                    <p class="card-text">Số lượng tài khoản đã đăng ký.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h4>5 Đơn hàng mới nhất</h4>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Mã ĐH</th>
                        <th>Khách hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestOrders as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td>{{ $order->customer_name }}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</td>
                            <td><span class="badge bg-warning text-dark">{{ $order->status }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Chưa có đơn hàng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection