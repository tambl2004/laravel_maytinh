@extends('layouts.customer')

@section('title', 'Trang chủ - Laptop Shop')

@section('content')
<!-- Hero Banner Section với Carousel -->
<div class="hero-banner">
    <div class="hero-carousel">
        <!-- Slide 1 -->
        <div class="hero-slide active"></div>
        <!-- Slide 2 -->
        <div class="hero-slide"></div>
        <!-- Slide 3 -->
        <div class="hero-slide"></div>
        
        <!-- Overlay -->
        <div class="hero-overlay"></div>

        <!-- Carousel Controls -->
        <div class="carousel-controls">
            <div class="carousel-dot active" data-slide="0"></div>
            <div class="carousel-dot" data-slide="1"></div>
            <div class="carousel-dot" data-slide="2"></div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="features-section py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="feature-item">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-shield-alt fa-3x text-primary"></i>
                    </div>
                    <h5 class="fw-bold">Chất lượng đảm bảo</h5>
                    <p class="text-muted">Sản phẩm chính hãng, bảo hành dài hạn</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-item">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-shipping-fast fa-3x text-success"></i>
                    </div>
                    <h5 class="fw-bold">Giao hàng nhanh</h5>
                    <p class="text-muted">Miễn phí ship toàn quốc cho đơn từ 500k</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-item">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-heart fa-3x text-danger"></i>
                    </div>
                    <h5 class="fw-bold">Tư vấn tận tình</h5>
                    <p class="text-muted">Hỗ trợ 24/7, tư vấn miễn phí</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Products Section -->
<div class="container py-5" id="featured-products">
    <div class="section-header text-center mb-5">
        <h2 class="display-5 fw-bold mb-3">Sản phẩm nổi bật</h2>
        <p class="lead text-muted">Những chiếc laptop được yêu thích nhất</p>
        <div class="divider mx-auto"></div>
    </div>
    
    <div class="row">
        @forelse ($featuredProducts as $product)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="modern-product-card">
                    <!-- Hình ảnh sản phẩm -->
                    <div class="product-image-container">
                        <img src="{{ $product->image }}" class="product-img" alt="{{ $product->name }}">
                        
                        <!-- Badge trạng thái kho -->
                        @if($product->stock <= 5 && $product->stock > 0)
                            <div class="stock-badge warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span>Sắp hết</span>
                            </div>
                        @elseif($product->stock == 0)
                            <div class="stock-badge danger">
                                <i class="fas fa-times-circle"></i>
                                <span>Hết hàng</span>
                            </div>
                        @else
                            <div class="stock-badge success">
                                <i class="fas fa-check-circle"></i>
                                <span>Còn hàng</span>
                            </div>
                        @endif
                        
                        <!-- Nút hành động nhanh -->
                        <div class="quick-actions">
                            <a href="{{ route('products.show', $product) }}" class="action-btn" title="Xem chi tiết">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Nội dung sản phẩm -->
                    <div class="product-content">
                        <!-- Meta thông tin -->
                        <div class="product-meta">
                            @if($product->category)
                                <span class="category-tag">{{ $product->category->name }}</span>
                            @endif
                            <div class="rating">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <span class="rating-count">(4.0)</span>
                            </div>
                        </div>
                        
                        <!-- Tên sản phẩm -->
                        <h3 class="product-title">
                            <a href="{{ route('products.show', $product) }}">{{ Str::limit($product->name, 45) }}</a>
                        </h3>
                        
                        <!-- Mô tả -->
                        <p class="product-description">{{ Str::limit($product->description, 70) }}</p>
                        
                        <!-- Giá và kho -->
                        <div class="price-section">
                            <div class="price">{{ number_format($product->price, 0, ',', '.') }}₫</div>
                            <div class="stock-info">
                                @if($product->stock > 0)
                                    <span class="in-stock">Còn {{ $product->stock }} sản phẩm</span>
                                @else
                                    <span class="out-of-stock">Hết hàng</span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Nút hành động -->
                        <div class="card-actions">
                            @if($product->stock > 0)
                                <form action="{{ route('cart.add', $product) }}" method="POST" class="add-to-cart-form">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn-add-cart">
                                        <i class="fas fa-shopping-cart"></i>
                                        <span>Thêm vào giỏ</span>
                                    </button>
                                </form>
                            @else
                                <button class="btn-add-cart disabled" disabled>
                                    <i class="fas fa-ban"></i>
                                    <span>Hết hàng</span>
                                </button>
                            @endif
                            
                            <a href="{{ route('products.show', $product) }}" class="btn-view-details">
                                Chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-box-open fa-4x text-muted mb-4"></i>
                <h4 class="text-muted">Chưa có sản phẩm nào để hiển thị</h4>
                <p class="text-muted">Vui lòng quay lại sau!</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Call to Action Section -->
<div class="cta-section py-5">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h3 class="display-6 fw-bold mb-4 text-white">Bạn chưa tìm được laptop ưng ý?</h3>
                <p class="lead mb-4 text-white">Liên hệ với chúng tôi để được tư vấn miễn phí!</p>
                <a href="{{ route('contact.index') }}" class="btn btn-warning btn-lg px-5 py-3">
                    <i class="fas fa-phone me-2"></i>Liên hệ ngay
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Hero Carousel functionality
    document.addEventListener('DOMContentLoaded', function() {
        const slides = document.querySelectorAll('.hero-slide');
        const dots = document.querySelectorAll('.carousel-dot');
        let currentSlide = 0;
        const totalSlides = slides.length;
        
        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));
            slides[index].classList.add('active');
            dots[index].classList.add('active');
        }
        
        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            showSlide(currentSlide);
        }
        
        // Tự động chuyển slide mỗi 5 giây
        setInterval(nextSlide, 5000);
        
        // Click vào dots để chuyển slide
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentSlide = index;
                showSlide(currentSlide);
            });
        });
    });
    
    // Add to Cart functionality
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const button = this.querySelector('.btn-add-cart');
            const originalContent = button.innerHTML;
            
            // Hiển thị trạng thái loading
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Đang thêm...</span>';
            button.disabled = true;
            
            // Gửi request
            fetch(this.action, {
                method: 'POST',
                body: new FormData(this),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    button.innerHTML = '<i class="fas fa-check"></i><span>Đã thêm!</span>';
                    button.style.background = '#10b981';
                    
                    // Reset sau 2 giây
                    setTimeout(() => {
                        button.innerHTML = originalContent;
                        button.style.background = '';
                        button.disabled = false;
                    }, 2000);
                } else {
                    button.innerHTML = '<i class="fas fa-times"></i><span>Lỗi!</span>';
                    button.style.background = '#ef4444';
                    
                    setTimeout(() => {
                        button.innerHTML = originalContent;
                        button.style.background = '';
                        button.disabled = false;
                    }, 2000);
                }
            })
            .catch(error => {
                button.innerHTML = '<i class="fas fa-times"></i><span>Lỗi!</span>';
                button.style.background = '#ef4444';
                
                setTimeout(() => {
                    button.innerHTML = originalContent;
                    button.style.background = '';
                    button.disabled = false;
                }, 2000);
            });
        });
    });
</script>
@endsection
