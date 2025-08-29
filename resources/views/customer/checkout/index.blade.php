@extends('layouts.customer')

@section('title', 'Thanh toán đơn hàng')

@section('content')
<div class="container my-5">
    <h1>Thông tin thanh toán</h1>
    <p>Vui lòng kiểm tra lại sản phẩm và điền đầy đủ thông tin giao hàng bên dưới.</p>

    <div class="row g-5">
        <div class="col-md-6">
            <h4 class="mb-3">Thông tin giao hàng</h4>
            @if ($errors->any())
                <div class="alert alert-danger">
                    Vui lòng kiểm tra lại các thông tin đã nhập.
                </div>
            @endif
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <label for="name" class="form-label">Họ và Tên</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                    </div>
                    <div class="col-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                    </div>
                    <div class="col-12">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                    </div>
                    <div class="col-12">
                        <label for="address" class="form-label">Địa chỉ nhận hàng</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                    </div>
                </div>
                <hr class="my-4">
                <button class="w-100 btn btn-primary btn-lg" type="submit">Hoàn tất Đặt hàng</button>
            </form>
        </div>

        <div class="col-md-6">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-primary">Đơn hàng của bạn</span>
                <span class="badge bg-primary rounded-pill">{{ count($cart) }}</span>
            </h4>
            <ul class="list-group mb-3">
                @php $total = 0; @endphp
                @foreach($cart as $id => $details)
                    @php $total += $details['price'] * $details['quantity']; @endphp
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0">{{ $details['name'] }}</h6>
                            <small class="text-muted">Số lượng: {{ $details['quantity'] }}</small>
                        </div>
                        <span class="text-muted">{{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }} VNĐ</span>
                    </li>
                @endforeach
                <li class="list-group-item d-flex justify-content-between bg-light">
                    <span class="fw-bold">Tổng cộng (VNĐ)</span>
                    <strong>{{ number_format($total, 0, ',', '.') }}</strong>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection