@extends('layouts.admin.app')
@section('title', 'Sửa sản phẩm')
@section('content')
<h1>Sửa sản phẩm: {{ $product->name }}</h1>

<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT') {{-- Rất quan trọng: Báo cho Laravel biết đây là request UPDATE --}}

    <div class="mb-3">
        <label for="name" class="form-label">Tên sản phẩm</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Mô tả</label>
        <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description', $product->description) }}</textarea>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Giá (VNĐ)</label>
        <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}" required>
    </div>
    <div class="mb-3">
        <label for="stock" class="form-label">Số lượng tồn kho</label>
        <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
    </div>

    <div class="mb-3">
        <label for="category_id" class="form-label">Danh mục</label>
        <select class="form-select" id="category_id" name="category_id">
            <option value="">-- Không chọn --</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Ảnh sản phẩm</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
        @if($product->image)
            <div class="mt-2">
                <img src="/{{ $product->image }}" alt="{{ $product->name }}" style="height: 80px">
            </div>
        @endif
    </div>
    <button type="submit" class="btn btn-primary">Cập nhật</button>
</form>
@endsection