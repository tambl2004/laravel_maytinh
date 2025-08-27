@extends('layouts.customer')

@section('title', 'Trang chủ - Tablet Shop')

@section('content')
<div class="container mt-4">
    <div class="p-4 mb-4 bg-light rounded-3">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">Chào mừng đến với Tablet Shop!</h1>
            <p class="col-md-8 fs-4">Nơi bạn có thể tìm thấy những chiếc máy tính bảng tốt nhất.</p>
        </div>
    </div>

    <div class="row">
        @foreach ($products as $product)
        {{-- Mỗi sản phẩm chiếm 4 cột trên màn hình vừa, 6 cột trên màn hình nhỏ --}}
        <div class="col-md-4 col-sm-6 product-card">
            <div class="card h-100">
                <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text text-muted flex-grow-1">{{ Str::limit($product->description, 100) }}</p>
                    <h4 class="text-danger">{{ number_format($product->price, 0, ',', '.') }} VNĐ</h4>
                    <a href="{{ route('products.show', $product) }}" class="btn btn-primary mt-auto">Xem chi tiết</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection