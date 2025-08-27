@extends('layouts.admin.app')

@section('title', 'Thêm Sản phẩm mới')

@section('content')
<h1>Thêm Sản phẩm mới</h1>

{{-- Hiển thị lỗi validation nếu có --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.products.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Tên sản phẩm</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Mô tả</label>
        <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Giá (VNĐ)</label>
        <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
    </div>
    <div class="mb-3">
        <label for="stock" class="form-label">Số lượng tồn kho</label>
        <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock') }}" required>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">URL Hình ảnh</label>
        <input type="text" class="form-control" id="image" name="image" value="{{ old('image') }}">
    </div>
    <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Hủy</a>
</form>
@endsection