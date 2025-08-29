@extends('layouts.customer')

@section('title', 'Giỏ hàng của bạn')

@section('content')
<div class="container my-5">
    <h1>Giỏ hàng của bạn</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(!empty($cart))
        <table class="table table-hover align-middle mt-4">
            <thead>
                <tr>
                    <th scope="col" style="width: 50%;">Sản phẩm</th>
                    <th scope="col">Giá</th>
                    <th scope="col" style="width: 15%;">Số lượng</th>
                    <th scope="col" class="text-end">Tổng phụ</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $id => $details)
                    @php $subtotal = $details['price'] * $details['quantity']; $total += $subtotal; @endphp
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $details['image'] }}" alt="{{ $details['name'] }}" style="width: 60px; height: 60px; object-fit: cover;" class="rounded">
                                <span class="ms-3 fw-bold">{{ $details['name'] }}</span>
                            </div>
                        </td>
                        <td>{{ number_format($details['price'], 0, ',', '.') }} VNĐ</td>
                        <td>
                            <form action="{{ route('cart.update', $id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="input-group">
                                    <input type="number" name="quantity" class="form-control form-control-sm" value="{{ $details['quantity'] }}" min="1">
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">Cập nhật</button>
                                </div>
                            </form>
                        </td>
                        <td class="text-end">{{ number_format($subtotal, 0, ',', '.') }} VNĐ</td>
                        <td>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">&times;</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-end mt-4">
            <h3>Tổng cộng: <span class="text-danger fw-bold">{{ number_format($total, 0, ',', '.') }} VNĐ</span></h3>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Tiếp tục mua sắm</a>
            <a href="{{ route('checkout.index') }}" class="btn btn-primary">Tiến hành thanh toán</a>
        </div>

    @else
        <div class="alert alert-info mt-4">
            <p class="mb-0">Giỏ hàng của bạn đang trống.</p>
            <a href="{{ route('products.index') }}">Bắt đầu mua sắm ngay!</a>
        </div>
    @endif
</div>
@endsection