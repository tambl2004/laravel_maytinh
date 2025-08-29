@extends('layouts.admin.app')

@section('title', 'Quản lý Sản phẩm')

@section('content')
    <h1>Quản lý Sản phẩm</h1>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <div class="d-flex justify-content-end mb-3">
    <a href="{{ route('admin.products.create') }}" class="btn btn-success">Thêm Sản phẩm mới</a>
    </div>
    <table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th>ID</th>
            <th>Hình ảnh</th> {{-- <-- CỘT MỚI --}}
            <th>Tên</th>
            <th>Giá</th>
            <th>Tồn kho</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            {{-- Ô DỮ LIỆU MỚI --}}
            <td>
                <img src="{{ $product->image }}" alt="{{ $product->name }}" style="width: 75px; height: 75px; object-fit: cover;">
            </td>
            {{-- KẾT THÚC PHẦN MỚI --}}
            <td>{{ $product->name }}</td>
            <td>{{ number_format($product->price) }} VNĐ</td>
            <td>{{ $product->stock }}</td>
            <td>
                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary btn-sm">Sửa</a>
                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
    <div class="d-flex justify-content-center">
        {!! $products->links() !!}
    </div>
@endsection