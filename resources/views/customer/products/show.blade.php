@extends('layouts.customer')

@section('title', $product->name)

@section('content')
<div class="container my-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Trang chủ</a></li>
            @if($product->category)
                <li class="breadcrumb-item"><a href="#">{{ $product->category->name }}</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($product->name, 50) }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-6">
            <img src="{{ $product->image }}" class="img-fluid rounded border" alt="{{ $product->name }}">
        </div>

        <div class="col-md-6">
            <h1>{{ $product->name }}</h1>

            <div class="my-3">
                @if($product->stock > 0)
                    <span class="badge bg-success">Còn hàng</span>
                @else
                    <span class="badge bg-danger">Hết hàng</span>
                @endif

                @if($product->category)
                    <span class="ms-2">Danh mục: <a href="#">{{ $product->category->name }}</a></span>
                @endif
            </div>

            <h2 class="text-danger fw-bold my-3">{{ number_format($product->price, 0, ',', '.') }} VNĐ</h2>

            <p class="lead">{{ $product->description }}</p>
            <hr>

            @if($product->stock > 0)
                <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="d-flex">
                        <div class="input-group" style="width: 150px;">
                            <span class="input-group-text">Số lượng</span>
                            <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{ $product->stock }}">
                        </div>
                        <button class="btn btn-primary ms-3" type="submit">Thêm vào giỏ hàng</button>
                    </div>
                </form>
            @else
                <button class="btn btn-secondary mt-4" disabled>Sản phẩm tạm hết hàng</button>
            @endif
        </div>
    </div>

    @if($relatedProducts->count() > 0)
    <hr class="my-5">
    <h2 class="mb-4">Sản phẩm liên quan</h2>
    <div class="row">
        @foreach($relatedProducts as $related)
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 product-card">
                <img src="{{ $related->image }}" class="card-img-top" alt="{{ $related->name }}">
                <div class="card-body d-flex flex-column">
                    <h6 class="card-title">{{ Str::limit($related->name, 50) }}</h6>
                    <p class="text-danger mt-auto">{{ number_format($related->price, 0, ',', '.') }} VNĐ</p>
                    <a href="{{ route('products.show', $related) }}" class="btn btn-outline-primary btn-sm mt-2">Xem chi tiết</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection