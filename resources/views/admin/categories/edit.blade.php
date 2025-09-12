@extends('layouts.admin.app')

@section('title', 'Sửa danh mục')
@section('page-title', 'Sửa danh mục')
@section('page-subtitle', 'Chỉnh sửa thông tin danh mục')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Danh mục</a></li>
        <li class="breadcrumb-item active">{{ $category->name }}</li>
    </ol>
</nav>

<!-- Form Card -->
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5 class="admin-card-title">
                    <i class="fas fa-edit me-2"></i>
                    Chỉnh sửa danh mục: {{ $category->name }}
                </h5>
            </div>
            <div class="admin-card-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Có lỗi xảy ra:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group mb-4">
                                <label for="name" class="form-label fw-semibold">
                                    <i class="fas fa-tag me-2"></i>Tên danh mục
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $category->name) }}" 
                                       placeholder="Nhập tên danh mục..."
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Tên danh mục sẽ được hiển thị trên website</div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label for="slug" class="form-label fw-semibold">
                                    <i class="fas fa-link me-2"></i>Slug
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg @error('slug') is-invalid @enderror" 
                                       id="slug" 
                                       name="slug" 
                                       value="{{ old('slug', $category->slug) }}" 
                                       placeholder="slug-tu-dong">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">URL thân thiện (tự động tạo)</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="description" class="form-label fw-semibold">
                            <i class="fas fa-align-left me-2"></i>Mô tả danh mục
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="4" 
                                  placeholder="Nhập mô tả cho danh mục...">{{ old('description', $category->description ?? '') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Mô tả sẽ giúp khách hàng hiểu rõ hơn về danh mục</div>
                    </div>

                    <!-- Category Stats -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="stat-card info">
                                <div class="stat-icon info">
                                    <i class="fas fa-laptop"></i>
                                </div>
                                <div class="stat-value">{{ $category->products_count ?? 0 }}</div>
                                <div class="stat-label">Sản phẩm trong danh mục</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="stat-card warning">
                                <div class="stat-icon warning">
                                    <i class="fas fa-calendar"></i>
                                </div>
                                <div class="stat-value">{{ $category->created_at->format('d/m/Y') }}</div>
                                <div class="stat-label">Ngày tạo</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Hủy bỏ
                        </a>
                        <button type="submit" class="btn btn-admin-primary">
                            <i class="fas fa-save me-2"></i>Cập nhật danh mục
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto generate slug from name
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    
    nameInput.addEventListener('input', function() {
        if (!slugInput.value || slugInput.dataset.manual !== 'true') {
            const slug = this.value
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            slugInput.value = slug;
        }
    });
    
    // Mark slug as manual if user edits it
    slugInput.addEventListener('input', function() {
        this.dataset.manual = 'true';
    });
});
</script>
@endsection