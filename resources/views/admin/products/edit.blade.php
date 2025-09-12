@extends('layouts.admin.app')

@section('title', 'Sửa sản phẩm')
@section('page-title', 'Sửa sản phẩm')
@section('page-subtitle', 'Chỉnh sửa thông tin sản phẩm')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Sản phẩm</a></li>
        <li class="breadcrumb-item active">{{ $product->name }}</li>
    </ol>
</nav>

<!-- Form Card -->
<div class="row">
    <div class="col-lg-12">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5 class="admin-card-title">
                    <i class="fas fa-edit me-2"></i>
                    Chỉnh sửa sản phẩm: {{ $product->name }}
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

                <form action="{{ route('admin.products.update', $product) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group mb-4">
                                <label for="name" class="form-label fw-semibold">
                                    <i class="fas fa-laptop me-2"></i>Tên sản phẩm
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $product->name) }}" 
                                       placeholder="Nhập tên sản phẩm..."
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Tên sản phẩm sẽ được hiển thị trên website</div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label for="category_id" class="form-label fw-semibold">
                                    <i class="fas fa-tags me-2"></i>Danh mục
                                </label>
                                <select class="form-select form-select-lg @error('category_id') is-invalid @enderror" 
                                        id="category_id" 
                                        name="category_id">
                                    <option value="">-- Chọn danh mục --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="description" class="form-label fw-semibold">
                            <i class="fas fa-align-left me-2"></i>Mô tả sản phẩm
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="6" 
                                  placeholder="Nhập mô tả chi tiết về sản phẩm...">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Mô tả chi tiết sẽ giúp khách hàng hiểu rõ hơn về sản phẩm</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="price" class="form-label fw-semibold">
                                    <i class="fas fa-dollar-sign me-2"></i>Giá bán (₫)
                                </label>
                                <input type="number" 
                                       class="form-control form-control-lg @error('price') is-invalid @enderror" 
                                       id="price" 
                                       name="price" 
                                       value="{{ old('price', $product->price) }}" 
                                       placeholder="0"
                                       min="0"
                                       required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Giá bán tính bằng VNĐ</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="stock" class="form-label fw-semibold">
                                    <i class="fas fa-boxes me-2"></i>Số lượng tồn kho
                                </label>
                                <input type="number" 
                                       class="form-control form-control-lg @error('stock') is-invalid @enderror" 
                                       id="stock" 
                                       name="stock" 
                                       value="{{ old('stock', $product->stock) }}" 
                                       placeholder="0"
                                       min="0"
                                       required>
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Số lượng sản phẩm có sẵn</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="image" class="form-label fw-semibold">
                            <i class="fas fa-image me-2"></i>Link hình ảnh sản phẩm
                        </label>
                        <input type="url" 
                               class="form-control form-control-lg @error('image') is-invalid @enderror" 
                               id="image" 
                               name="image" 
                               value="{{ old('image', $product->image) }}" 
                               placeholder="https://example.com/image.jpg">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Nhập URL hình ảnh từ internet (ví dụ: từ Google Images, Unsplash...)</div>
                    </div>

                    <!-- Current Image -->
                    @if($product->image)
                        <div class="form-group mb-4">
                            <label class="form-label fw-semibold">Hình ảnh hiện tại</label>
                            <div class="current-image-container">
                                <img src="{{ $product->image }}" 
                                     alt="{{ $product->name }}" 
                                     class="img-thumbnail" 
                                     style="max-width: 200px; max-height: 200px;">
                                <div class="mt-2">
                                    <small class="text-muted">Hình ảnh hiện tại của sản phẩm</small>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Image Preview -->
                    <div class="form-group mb-4" id="imagePreview" style="display: none;">
                        <label class="form-label fw-semibold">Xem trước hình ảnh mới</label>
                        <div class="image-preview-container">
                            <img id="previewImage" src="" alt="Preview" class="img-thumbnail" style="max-width: 300px; max-height: 300px;">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Hủy bỏ
                        </a>
                        <button type="submit" class="btn btn-admin-primary">
                            <i class="fas fa-save me-2"></i>Cập nhật sản phẩm
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
    const imageInput = document.getElementById('image');
    const previewContainer = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImage');
    
    // Preview image when URL is entered
    imageInput.addEventListener('input', function() {
        const url = this.value.trim();
        
        if (url && isValidImageUrl(url)) {
            previewImage.src = url;
            previewImage.onload = function() {
                previewContainer.style.display = 'block';
            };
            previewImage.onerror = function() {
                previewContainer.style.display = 'none';
                alert('Không thể tải hình ảnh từ URL này. Vui lòng kiểm tra lại.');
            };
        } else {
            previewContainer.style.display = 'none';
        }
    });
    
    // Validate image URL
    function isValidImageUrl(url) {
        const imageExtensions = /\.(jpg|jpeg|png|gif|webp|svg)$/i;
        return imageExtensions.test(url) || url.includes('unsplash.com') || url.includes('images.unsplash.com');
    }
    
    // Format price input
    const priceInput = document.getElementById('price');
    priceInput.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        this.value = value;
    });
});
</script>
@endsection