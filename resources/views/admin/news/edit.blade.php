@extends('layouts.admin.app')

@section('title', 'Chỉnh sửa tin tức')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-edit me-2"></i>Chỉnh sửa tin tức
            </h1>
            <p class="text-muted mb-0">Cập nhật thông tin tin tức: {{ Str::limit($news->title, 50) }}</p>
        </div>
        <div>
            <a href="{{ route('news.show', $news->slug) }}" class="btn btn-info me-2" target="_blank">
                <i class="fas fa-eye me-2"></i>Xem tin tức
            </a>
            <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Quay lại
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-edit me-2"></i>Thông tin tin tức
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-lg-8">
                        <!-- Title -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold">
                                <i class="fas fa-heading me-2"></i>Tiêu đề tin tức <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $news->title) }}" 
                                   placeholder="Nhập tiêu đề tin tức..." required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Excerpt -->
                        <div class="mb-4">
                            <label for="excerpt" class="form-label fw-bold">
                                <i class="fas fa-align-left me-2"></i>Tóm tắt
                            </label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                      id="excerpt" name="excerpt" rows="3" 
                                      placeholder="Nhập tóm tắt ngắn về tin tức...">{{ old('excerpt', $news->excerpt) }}</textarea>
                            <div class="form-text">Tóm tắt sẽ hiển thị trong danh sách tin tức và preview.</div>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div class="mb-4">
                            <label for="content" class="form-label fw-bold">
                                <i class="fas fa-file-alt me-2"></i>Nội dung chi tiết <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="15" 
                                      placeholder="Nhập nội dung chi tiết của tin tức..." required>{{ old('content', $news->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-lg-4">
                        <!-- Current Image -->
                        @if($news->image_url || $news->image)
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-image me-2"></i>Hình ảnh hiện tại
                            </label>
                            <div class="current-image">
                                <img src="{{ $news->featured_image }}" alt="{{ $news->title }}" 
                                     class="img-fluid rounded mb-2">
                                <div class="text-center">
                                    <small class="text-muted">Hình ảnh hiện tại</small>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Image URL -->
                        <div class="mb-4">
                            <label for="image_url" class="form-label fw-bold">
                                <i class="fas fa-link me-2"></i>{{ $news->image_url ? 'Thay đổi link hình ảnh' : 'Link hình ảnh' }}
                            </label>
                            <input type="url" class="form-control @error('image_url') is-invalid @enderror" 
                                   id="image_url" name="image_url" value="{{ old('image_url', $news->image_url) }}" 
                                   placeholder="https://example.com/image.jpg">
                            <div class="form-text">Nhập link hình ảnh từ internet (ưu tiên)</div>
                            @error('image_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <!-- Image Preview -->
                            <div id="imageUrlPreview" class="mt-3" style="display: none;">
                                <img id="previewImgUrl" src="" alt="Preview" class="img-fluid rounded">
                                <div class="text-center mt-2">
                                    <small class="text-success">Hình ảnh mới</small>
                                </div>
                            </div>
                        </div>

                        <!-- Image Upload (Alternative) -->
                        <div class="mb-4">
                            <label for="image" class="form-label fw-bold">
                                <i class="fas fa-upload me-2"></i>{{ $news->image ? 'Thay đổi hình ảnh upload' : 'Hoặc upload hình ảnh' }}
                            </label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            <div class="form-text">Kích thước khuyến nghị: 800x400px. Định dạng: JPG, PNG, GIF</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <!-- Image Preview -->
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <img id="previewImg" src="" alt="Preview" class="img-fluid rounded">
                                <div class="text-center mt-2">
                                    <small class="text-success">Hình ảnh mới</small>
                                </div>
                            </div>
                        </div>

                        <!-- Author -->
                        <div class="mb-4">
                            <label for="author" class="form-label fw-bold">
                                <i class="fas fa-user me-2"></i>Tác giả <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('author') is-invalid @enderror" 
                                   id="author" name="author" value="{{ old('author', $news->author) }}" 
                                   placeholder="Nhập tên tác giả..." required>
                            @error('author')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status Options -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-cog me-2"></i>Tùy chọn
                            </label>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" 
                                       value="1" {{ old('is_featured', $news->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_featured">
                                    <i class="fas fa-star me-2 text-warning"></i>Tin tức nổi bật
                                </label>
                                <div class="form-text">Tin tức nổi bật sẽ hiển thị ở trang chủ</div>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_published" name="is_published" 
                                       value="1" {{ old('is_published', $news->is_published) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_published">
                                    <i class="fas fa-eye me-2 text-success"></i>Xuất bản
                                </label>
                                <div class="form-text">Bỏ chọn để lưu dưới dạng bản nháp</div>
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-chart-bar me-2"></i>Thống kê
                            </label>
                            <div class="stats-info">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Lượt xem:</span>
                                    <span class="fw-bold text-primary">{{ $news->views }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Ngày tạo:</span>
                                    <span class="fw-bold">{{ $news->created_at->format('d/m/Y') }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Cập nhật:</span>
                                    <span class="fw-bold">{{ $news->updated_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Cập nhật tin tức
                            </button>
                            <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Hủy bỏ
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Image URL preview
        $('#image_url').on('input', function() {
            const url = $(this).val();
            if (url && isValidUrl(url)) {
                $('#previewImgUrl').attr('src', url);
                $('#imageUrlPreview').show();
            } else {
                $('#imageUrlPreview').hide();
            }
        });

        // Image file preview
        $('#image').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImg').attr('src', e.target.result);
                    $('#imagePreview').show();
                };
                reader.readAsDataURL(file);
            } else {
                $('#imagePreview').hide();
            }
        });

        // Character counter for excerpt
        $('#excerpt').on('input', function() {
            const length = $(this).val().length;
            const maxLength = 500;
            if (length > maxLength) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
    });

    // Helper function to validate URL
    function isValidUrl(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }
</script>
@endsection
