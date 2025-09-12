@extends('layouts.admin.app')

@section('title', 'Quản lý sản phẩm')
@section('page-title', 'Quản lý sản phẩm')
@section('page-subtitle', 'Thêm, sửa và quản lý các sản phẩm laptop')

@section('content')
<!-- Header Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-1">Sản phẩm laptop</h2>
        <p class="text-muted mb-0">Quản lý và cập nhật thông tin sản phẩm</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-admin-primary">
        <i class="fas fa-plus me-2"></i>Thêm sản phẩm mới
    </a>
</div>

<!-- Success Message -->
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Stats Cards -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="stat-card primary">
            <div class="stat-icon primary">
                <i class="fas fa-laptop"></i>
            </div>
            <div class="stat-value">{{ $products->total() }}</div>
            <div class="stat-label">Tổng sản phẩm</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card success">
            <div class="stat-icon success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-value">{{ $products->where('stock', '>', 0)->count() }}</div>
            <div class="stat-label">Còn hàng</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card warning">
            <div class="stat-icon warning">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-value">{{ $products->where('stock', '<=', 10)->where('stock', '>', 0)->count() }}</div>
            <div class="stat-label">Sắp hết hàng</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card danger">
            <div class="stat-icon danger">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-value">{{ $products->where('stock', 0)->count() }}</div>
            <div class="stat-label">Hết hàng</div>
        </div>
    </div>
</div>

<!-- Products Table -->
<div class="admin-card">
    <div class="admin-card-header">
        <h5 class="admin-card-title">
            <i class="fas fa-laptop me-2"></i>
            Danh sách sản phẩm
        </h5>
    </div>
    <div class="admin-card-body p-0">
        @if($products->count() > 0)
            <div class="admin-table">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="border-0">ID</th>
                            <th class="border-0">Hình ảnh</th>
                            <th class="border-0">Thông tin sản phẩm</th>
                            <th class="border-0">Danh mục</th>
                            <th class="border-0">Giá</th>
                            <th class="border-0">Tồn kho</th>
                            <th class="border-0">Trạng thái</th>
                            <th class="border-0 text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>
                                <span class="badge bg-light text-dark">#{{ $product->id }}</span>
                            </td>
                            <td>
                                <div class="product-image">
                                    @if($product->image)
                                        <img src="{{ $product->image }}" 
                                             alt="{{ $product->name }}" 
                                             class="img-thumbnail"
                                             style="width: 80px; height: 80px; object-fit: cover;">
                                    @else
                                        <div class="no-image">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div class="fw-semibold">{{ $product->name }}</div>
                                    <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                    <div class="mt-1">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $product->created_at->format('d/m/Y') }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($product->category)
                                    <span class="badge bg-info">{{ $product->category->name }}</span>
                                @else
                                    <span class="badge bg-secondary">Chưa phân loại</span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-success">
                                    {{ number_format($product->price, 0, ',', '.') }}₫
                                </div>
                            </td>
                            <td>
                                @if($product->stock > 10)
                                    <span class="badge bg-success">{{ $product->stock }}</span>
                                @elseif($product->stock > 0)
                                    <span class="badge bg-warning">{{ $product->stock }}</span>
                                @else
                                    <span class="badge bg-danger">Hết hàng</span>
                                @endif
                            </td>
                            <td>
                                @if($product->stock > 0)
                                    <span class="badge bg-success">Còn hàng</span>
                                @else
                                    <span class="badge bg-danger">Hết hàng</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                       class="btn btn-sm btn-outline-primary" 
                                       title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" 
                                          method="POST" 
                                          class="d-inline" 
                                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này? Thao tác này không thể hoàn tác.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger" 
                                                title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <div class="empty-state">
                    <i class="fas fa-laptop fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Chưa có sản phẩm nào</h4>
                    <p class="text-muted mb-4">Hãy thêm sản phẩm đầu tiên để bắt đầu bán hàng</p>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-admin-primary">
                        <i class="fas fa-plus me-2"></i>Thêm sản phẩm đầu tiên
                    </a>
                </div>
            </div>
        @endif
    </div>
    
    @if($products->count() > 0)
        <div class="admin-card-body border-top">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Hiển thị {{ $products->firstItem() }} - {{ $products->lastItem() }} 
                    trong tổng số {{ $products->total() }} sản phẩm
                </div>
                <div>
                    {!! $products->links() !!}
                </div>
            </div>
        </div>
    @endif
</div>

@endsection

@section('styles')
<style>
.product-image {
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.no-image {
    width: 80px;
    height: 80px;
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}
</style>
@endsection