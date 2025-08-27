@extends('layouts.admin.app')

@section('title', 'Quản lý Sản phẩm')

@section('content')
    <h1>Quản lý Sản phẩm</h1>
    <div class="d-flex justify-content-end mb-3">
        <a href="#" class="btn btn-success">Thêm Sản phẩm mới</a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
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
                <td>{{ $product->name }}</td>
                <td>{{ number_format($product->price) }} VNĐ</td>
                <td>{{ $product->stock }}</td>
                <td>
                    <a href="#" class="btn btn-primary btn-sm">Sửa</a>
                    <a href="#" class="btn btn-danger btn-sm">Xóa</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {!! $products->links() !!}
    </div>
@endsection