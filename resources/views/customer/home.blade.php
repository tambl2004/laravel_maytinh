@extends('layouts.customer')

@section('title', 'Trang chủ')

@section('content')
<div class="container">
    <div class="p-5 mb-4 bg-light rounded-3 mt-4">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">Tablet Shop - Thế giới trong tay bạn</h1>
            <p class="col-md-8 fs-4">Khám phá những dòng máy tính bảng mới nhất từ các thương hiệu hàng đầu với mức giá tốt nhất.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">Xem tất cả sản phẩm</a>
        </div>
    </div>

    <h2 class="mb-4">Sản phẩm nổi bật</h2>
    <div class="row">
        @forelse ($featuredProducts as $product)
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100 product-card">
                    <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ Str::limit($product->name, 50) }}</h5>
                        <p class="text-danger fw-bold mt-auto">{{ number_format($product->price, 0, ',', '.') }} VNĐ</p>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary btn-sm mt-2">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        @empty
            <p>Chưa có sản phẩm nào để hiển thị.</p>
        @endforelse
    </div>
</div>
@endsection