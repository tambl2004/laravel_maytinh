@extends('layouts.admin.app')

@section('title', 'Chi tiết đơn hàng #' . $order->id)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Chi tiết đơn hàng #{{ $order->id }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-8">
            {{-- ... (Copy toàn bộ thẻ <div class="card"> chứa sản phẩm từ view customer.orders.show) ... --}}
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Cập nhật Trạng thái</div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="input-group">
                            <select name="status" class="form-select">
                                <option value="pending" @if($order->status == 'pending') selected @endif>Pending</option>
                                <option value="processing" @if($order->status == 'processing') selected @endif>Processing</option>
                                <option value="completed" @if($order->status == 'completed') selected @endif>Completed</option>
                                <option value="cancelled" @if($order->status == 'cancelled') selected @endif>Cancelled</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-4">
                 {{-- ... (Copy toàn bộ thẻ <div class="card-header"> và <div class="card-body"> chứa thông tin đơn hàng từ view customer.orders.show) ... --}}
            </div>
        </div>
    </div>
@endsection