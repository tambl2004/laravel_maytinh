@extends('layouts.customer')

@section('title', 'Trang chủ - Tablet Shop')

@section('content')
<div class="container mt-5">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <img src="{{ $product->image }}" class="img-fluid rounded" alt="{{ $product->name }}">
            </div>
            <div class="col-md-6">
                <h1>{{ $product->name }}</h1>
                <h2 class="text-danger my-3">{{ number_format($product->price, 0, ',', '.') }} VNĐ</h2>
                <p class="lead">{{ $product->description }}</p>
                <hr>
                <p><strong>Số lượng trong kho:</strong> {{ $product->stock }}</p>
                <form action="{{ route('cart.add', $product) }}" method="POST">
                    @csrf <div class="input-group mb-3" style="max-width: 200px;">
                        <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{ $product->stock }}">
                        <button class="btn btn-success" type="submit">Thêm vào giỏ hàng</button>
                    </div>
                </form>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-lg">Quay lại</a>
            </div>
        </div>
    </div>
@endsection

