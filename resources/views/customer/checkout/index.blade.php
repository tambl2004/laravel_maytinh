@extends('layouts.customer')

@section('title', 'Thanh toán đơn hàng')

@section('content')
<div class="container my-5">
    <h1>Thông tin thanh toán</h1>
    <p>Vui lòng chọn địa chỉ nhận hàng từ danh sách bên dưới.</p>

    <div class="row g-5">
        <div class="col-md-7">
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <h4 class="mb-3">Chọn địa chỉ nhận hàng</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">Vui lòng chọn một địa chỉ.</div>
                @endif

                <div class="mb-4">
                    @foreach($addresses as $address)
                    <div class="form-check card card-body mb-2">
                        <input class="form-check-input" type="radio" name="address_id" id="address{{ $address->id }}" value="{{ $address->id }}">
                        <label class="form-check-label w-100" for="address{{ $address->id }}">
                            <strong>{{ $address->name }}</strong><br>
                            {{ $address->phone }}<br>
                            {{ $address->address }}
                        </label>
                    </div>
                    @endforeach
                </div>

                <a href="{{ route('addresses.index') }}" class="btn btn-outline-secondary">Quản lý sổ địa chỉ</a>
                <hr class="my-4">
                <button class="w-100 btn btn-primary btn-lg" type="submit">Hoàn tất Đặt hàng</button>
            </form>
        </div>

        <div class="col-md-5">
            {{-- Phần hiển thị giỏ hàng không thay đổi --}}
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