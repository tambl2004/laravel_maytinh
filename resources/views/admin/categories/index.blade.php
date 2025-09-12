@extends('layouts.admin.app')

@section('title', 'Quản lý Danh mục')
@section('page-title', 'Quản lý Danh mục')
@section('page-subtitle', 'Thêm, sửa và quản lý các danh mục sản phẩm')

@section('content')
<!-- Header Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-1">Danh mục sản phẩm</h2>
        <p class="text-muted mb-0">Quản lý và tổ chức các danh mục sản phẩm</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-admin-primary">
        <i class="fas fa-plus me-2"></i>Thêm danh mục mới
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

<!-- Categories Table -->
<div class="admin-card">
    <div class="admin-card-header">
        <h5 class="admin-card-title">
            <i class="fas fa-tags me-2"></i>
            Danh sách danh mục
        </h5>
    </div>
    <div class="admin-card-body p-0">
        @if($categories->count() > 0)
            <div class="admin-table">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="border-0">ID</th>
                            <th class="border-0">Tên danh mục</th>
                            <th class="border-0">Slug</th>
                            <th class="border-0">Số sản phẩm</th>
                            <th class="border-0">Ngày tạo</th>
                            <th class="border-0 text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>
                                <span class="badge bg-light text-dark">#{{ $category->id }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="category-icon me-3">
                                        <i class="fas fa-folder text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $category->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <code class="text-muted">{{ $category->slug }}</code>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $category->products_count ?? 0 }}</span>
                            </td>
                            <td>
                                <small class="text-muted">{{ $category->created_at->format('d/m/Y') }}</small>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.categories.edit', $category) }}" 
                                       class="btn btn-sm btn-outline-primary" 
                                       title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" 
                                          method="POST" 
                                          class="d-inline" 
                                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này? Thao tác này không thể hoàn tác.');">
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
                    <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Chưa có danh mục nào</h4>
                    <p class="text-muted mb-4">Hãy tạo danh mục đầu tiên để bắt đầu quản lý sản phẩm</p>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-admin-primary">
                        <i class="fas fa-plus me-2"></i>Tạo danh mục đầu tiên
                    </a>
                </div>
            </div>
        @endif
    </div>
    
    @if($categories->count() > 0)
        <div class="admin-card-body border-top">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Hiển thị {{ $categories->firstItem() }} - {{ $categories->lastItem() }} 
                    trong tổng số {{ $categories->total() }} danh mục
                </div>
                <div>
                    {!! $categories->links() !!}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection