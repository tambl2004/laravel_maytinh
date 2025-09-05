@extends('layouts.customer')

@section('title', $product->name . ' - Balo Shop')

@section('content')
<div class="container my-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light p-3 rounded">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="text-decoration-none">
                    <i class="fas fa-home me-1"></i>Trang chủ
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('products.index') }}" class="text-decoration-none">Sản phẩm</a>
            </li>
            @if($product->category)
                <li class="breadcrumb-item">
                    <a href="#" class="text-decoration-none">{{ $product->category->name }}</a>
                </li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($product->name, 50) }}</li>
        </ol>
    </nav>

    <!-- Product Details -->
    <div class="row mb-5">
        <!-- Product Images -->
        <div class="col-lg-6 mb-4">
            <div class="product-image-gallery">
                <div class="main-image-container">
                    <img src="{{ $product->image }}" 
                         class="img-fluid rounded-3 shadow-lg main-product-image" 
                         alt="{{ $product->name }}"
                         id="mainProductImage">
                    <div class="image-zoom-overlay">
                        <i class="fas fa-search-plus"></i>
                    </div>
                </div>
                <!-- Thumbnail images (if multiple images available) -->
                <div class="thumbnail-images mt-3">
                    <div class="row g-2">
                        <div class="col-3">
                            <img src="{{ $product->image }}" class="img-thumbnail thumbnail-img active" alt="{{ $product->name }}">
                        </div>
                        <!-- Add more thumbnails here when multiple images are available -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-lg-6">
            <div class="product-info">
                <h1 class="product-title mb-3">{{ $product->name }}</h1>
                
                <!-- Product Meta -->
                <div class="product-meta mb-4">
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        @if($product->stock > 0)
                            <span class="badge bg-success fs-6 px-3 py-2">
                                <i class="fas fa-check-circle me-1"></i>Còn hàng
                            </span>
                        @else
                            <span class="badge bg-danger fs-6 px-3 py-2">
                                <i class="fas fa-times-circle me-1"></i>Hết hàng
                            </span>
                        @endif

                        @if($product->category)
                            <span class="text-muted">
                                <i class="fas fa-tag me-1"></i>
                                Danh mục: <a href="#" class="text-primary text-decoration-none">{{ $product->category->name }}</a>
                            </span>
                        @endif

                        <span class="text-muted">
                            <i class="fas fa-box me-1"></i>
                            Còn lại: {{ $product->stock }} sản phẩm
                        </span>
                    </div>
                </div>

                <!-- Price Section -->
                <div class="price-section mb-4">
                    <div class="current-price">
                        <span class="h2 text-primary fw-bold mb-0">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                    </div>
                    <!-- Add discount price here if available -->
                    <div class="price-savings mt-2">
                        <small class="text-success">
                            <i class="fas fa-shipping-fast me-1"></i>
                            Miễn phí vận chuyển cho đơn hàng trên 500.000₫
                        </small>
                    </div>
                </div>

                <!-- Product Description -->
                <div class="product-description mb-4">
                    <h5 class="mb-3">Mô tả sản phẩm</h5>
                    <p class="lead text-muted">{{ $product->description }}</p>
                </div>

                <!-- Product Features (placeholder for future features) -->
                <div class="product-features mb-4">
                    <h6 class="mb-3">Tính năng nổi bật</h6>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="feature-item d-flex align-items-center">
                                <i class="fas fa-shield-alt text-primary me-2"></i>
                                <span class="small">Bảo hành 12 tháng</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="feature-item d-flex align-items-center">
                                <i class="fas fa-water text-info me-2"></i>
                                <span class="small">Chống nước</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="feature-item d-flex align-items-center">
                                <i class="fas fa-weight-hanging text-success me-2"></i>
                                <span class="small">Nhẹ và bền bỉ</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="feature-item d-flex align-items-center">
                                <i class="fas fa-laptop text-warning me-2"></i>
                                <span class="small">Ngăn laptop riêng</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add to Cart Section -->
                @if($product->stock > 0)
                    <div class="add-to-cart-section">
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="add-to-cart-form">
                            @csrf
                            <div class="row g-3 align-items-end">
                                <div class="col-md-4">
                                    <label for="quantity" class="form-label fw-semibold">Số lượng</label>
                                    <div class="quantity-selector">
                                        <button type="button" class="btn btn-outline-secondary" id="decreaseQty">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" name="quantity" id="quantity" class="form-control text-center" 
                                               value="1" min="1" max="{{ $product->stock }}">
                                        <button type="button" class="btn btn-outline-secondary" id="increaseQty">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary btn-lg flex-fill">
                                            <i class="fas fa-cart-plus me-2"></i>Thêm vào giỏ hàng
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-lg">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        
                        <!-- Quick Actions -->
                        <div class="quick-actions mt-3">
                            <div class="row g-2">
                                <div class="col-6">
                                    <button class="btn btn-outline-primary btn-sm w-100">
                                        <i class="fas fa-share-alt me-1"></i>Chia sẻ
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-outline-info btn-sm w-100">
                                        <i class="fas fa-ruler me-1"></i>Hướng dẫn chọn size
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="out-of-stock-section">
                        <button class="btn btn-secondary btn-lg w-100 mb-3" disabled>
                            <i class="fas fa-times me-2"></i>Sản phẩm tạm hết hàng
                        </button>
                        <button class="btn btn-outline-primary w-100">
                            <i class="fas fa-bell me-2"></i>Thông báo khi có hàng
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Product Tabs -->
    <div class="product-tabs-section mb-5">
        <ul class="nav nav-tabs nav-justified" id="productTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">
                    <i class="fas fa-info-circle me-2"></i>Mô tả chi tiết
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications" type="button" role="tab">
                    <i class="fas fa-list me-2"></i>Thông số kỹ thuật
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">
                    <i class="fas fa-star me-2"></i>Đánh giá (0)
                </button>
            </li>
        </ul>
        <div class="tab-content p-4 bg-light rounded-bottom" id="productTabsContent">
            <div class="tab-pane fade show active" id="description" role="tabpanel">
                <h5>Mô tả chi tiết</h5>
                <p>{{ $product->description }}</p>
                <p>Balo này được thiết kế với chất liệu cao cấp, phù hợp cho nhiều hoạt động khác nhau từ đi học, đi làm đến du lịch.</p>
            </div>
            <div class="tab-pane fade" id="specifications" role="tabpanel">
                <h5>Thông số kỹ thuật</h5>
                <table class="table table-striped">
                    <tr><td class="fw-bold">Chất liệu</td><td>Polyester cao cấp</td></tr>
                    <tr><td class="fw-bold">Kích thước</td><td>45 x 30 x 15 cm</td></tr>
                    <tr><td class="fw-bold">Dung lượng</td><td>25-30 liter</td></tr>
                    <tr><td class="fw-bold">Trọng lượng</td><td>0.8 kg</td></tr>
                    <tr><td class="fw-bold">Bảo hành</td><td>12 tháng</td></tr>
                </table>
            </div>
            <div class="tab-pane fade" id="reviews" role="tabpanel">
                <h5>Đánh giá của khách hàng</h5>
                <div class="text-center py-4">
                    <i class="fas fa-star-half-alt fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Chưa có đánh giá nào cho sản phẩm này.</p>
                    <button class="btn btn-primary">Viết đánh giá đầu tiên</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="related-products-section">
        <div class="section-header mb-4">
            <h3 class="display-6 fw-bold mb-2">Sản phẩm liên quan</h3>
            <p class="text-muted">Các sản phẩm tương tự mà bạn có thể quan tâm</p>
        </div>
        <div class="row">
            @foreach($relatedProducts as $related)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="product-card-enhanced">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="product-image-wrapper">
                            <img src="{{ $related->image }}" class="card-img-top product-image" alt="{{ $related->name }}">
                            <div class="product-overlay">
                                <div class="overlay-buttons">
                                    <a href="{{ route('products.show', $related) }}" class="btn btn-light btn-sm mb-2">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('cart.add', $related) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title mb-2">{{ Str::limit($related->name, 50) }}</h6>
                            <p class="text-primary fw-bold mb-2">{{ number_format($related->price, 0, ',', '.') }}₫</p>
                            <a href="{{ route('products.show', $related) }}" class="btn btn-outline-primary btn-sm w-100">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- Image Zoom Modal -->
<div class="modal fade" id="imageZoomModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $product->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <img src="{{ $product->image }}" class="img-fluid" alt="{{ $product->name }}">
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Quantity selector functionality
    const quantityInput = document.getElementById('quantity');
    const decreaseBtn = document.getElementById('decreaseQty');
    const increaseBtn = document.getElementById('increaseQty');
    const maxStock = parseInt('{{ $product->stock ?? 0 }}') || 0;
    
    if (decreaseBtn && increaseBtn && quantityInput) {
        decreaseBtn.addEventListener('click', function() {
            const currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });
        
        increaseBtn.addEventListener('click', function() {
            const currentValue = parseInt(quantityInput.value);
            if (currentValue < maxStock) {
                quantityInput.value = currentValue + 1;
            }
        });
        
        quantityInput.addEventListener('change', function() {
            const value = parseInt(this.value);
            if (value < 1) this.value = 1;
            if (value > maxStock) this.value = maxStock;
        });
    }
    
    // Image zoom functionality
    const mainImage = document.getElementById('mainProductImage');
    if (mainImage) {
        mainImage.addEventListener('click', function() {
            const modal = new bootstrap.Modal(document.getElementById('imageZoomModal'));
            modal.show();
        });
    }
    
    // Thumbnail image switching
    document.querySelectorAll('.thumbnail-img').forEach(thumb => {
        thumb.addEventListener('click', function() {
            // Remove active class from all thumbnails
            document.querySelectorAll('.thumbnail-img').forEach(t => t.classList.remove('active'));
            // Add active class to clicked thumbnail
            this.classList.add('active');
            // Update main image
            mainImage.src = this.src;
        });
    });
    
    // Enhanced add to cart with feedback
    const addToCartForm = document.querySelector('.add-to-cart-form');
    if (addToCartForm) {
        addToCartForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang thêm...';
            submitBtn.disabled = true;
            
            // If using AJAX, prevent form submission and handle response
            // For now, let the form submit normally
        });
    }
    
    // Tab content dynamic loading (placeholder)
    document.querySelectorAll('#productTabs button').forEach(tabBtn => {
        tabBtn.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-bs-target');
            // Here you could load content dynamically if needed
        });
    });
    
    // Smooth scroll for related products
    const relatedProductsSection = document.querySelector('.related-products-section');
    if (relatedProductsSection) {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.querySelectorAll('.product-card-enhanced').forEach((card, index) => {
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }, index * 100);
                    });
                }
            });
        }, observerOptions);
        
        // Set initial state
        relatedProductsSection.querySelectorAll('.product-card-enhanced').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'all 0.6s ease';
        });
        
        observer.observe(relatedProductsSection);
    }
    
    // Share functionality
    document.querySelectorAll('[data-action="share"]').forEach(shareBtn => {
        shareBtn.addEventListener('click', function() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $product->name }}',
                    text: 'Xem sản phẩm này tại Balo Shop',
                    url: window.location.href
                });
            } else {
                // Fallback: copy to clipboard
                navigator.clipboard.writeText(window.location.href)
                    .then(() => {
                        // Show success message
                        const toast = document.createElement('div');
                        toast.className = 'alert alert-success position-fixed';
                        toast.style.top = '20px';
                        toast.style.right = '20px';
                        toast.style.zIndex = '9999';
                        toast.textContent = 'Đã sao chép link sản phẩm!';
                        document.body.appendChild(toast);
                        
                        setTimeout(() => {
                            toast.remove();
                        }, 3000);
                    });
            }
        });
    });
</script>