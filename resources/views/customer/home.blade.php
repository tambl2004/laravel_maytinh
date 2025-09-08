@extends('layouts.customer')

@section('title', 'Trang chủ - Balo Shop')

@section('content')
<!-- Hero Banner Section -->
<div class="hero-banner">
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
        <p class="lead text-muted">Những chiếc balo được yêu thích nhất</p>
        <div class="divider mx-auto"></div>
    </div>
    
    <div class="row">
        @forelse ($featuredProducts as $product)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="modern-product-card">
                    <div class="product-image-container">
                        <img src="{{ $product->image }}" class="product-img" alt="{{ $product->name }}">
                        
                        <!-- Stock Badge -->
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
                        
                        <!-- Quick Actions Overlay -->
                        <div class="quick-actions">
                            <a href="{{ route('products.show', $product) }}" class="action-btn view-btn" title="Xem chi tiết">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button class="action-btn wishlist-btn" title="Yêu thích">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="product-content">
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
                        
                        <h3 class="product-title">
                            <a href="{{ route('products.show', $product) }}">{{ Str::limit($product->name, 50) }}</a>
                        </h3>
                        
                        <p class="product-description">{{ Str::limit($product->description, 80) }}</p>
                        
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
                        
                        <div class="card-actions">
                            @if($product->stock > 0)
                                <form action="{{ route('cart.add', $product) }}" method="POST" class="add-to-cart-form">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn-add-cart">
                                        <i class="fas fa-shopping-cart"></i>
                                        <span>Thêm</span>
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
                                <i class="fas fa-arrow-right"></i>
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
                <h3 class="display-6 fw-bold mb-4 text-white">Bạn chưa tìm được balo ưng ý?</h3>
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
    // Add to Cart functionality for modern cards
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const button = this.querySelector('.btn-add-cart');
            const originalContent = button.innerHTML;
            
            // Show loading state
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Đang thêm...</span>';
            button.disabled = true;
            button.classList.add('loading');
            
            // Submit form via fetch
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
                    // Show success feedback
                    button.innerHTML = '<i class="fas fa-check"></i><span>Đã thêm!</span>';
                    button.classList.remove('loading');
                    button.classList.add('success');
                    
                    // Show toast notification
                    showToast('success', data.message);
                    
                    // Update cart count if available
                    const cartBadge = document.querySelector('.nav-link .badge');
                    if (cartBadge && data.cartCount) {
                        cartBadge.textContent = data.cartCount;
                    }
                    
                    // Reset button after delay
                    setTimeout(() => {
                        button.innerHTML = originalContent;
                        button.classList.remove('success');
                        button.disabled = false;
                    }, 2000);
                } else {
                    // Show error feedback
                    button.innerHTML = '<i class="fas fa-times"></i><span>Lỗi!</span>';
                    button.classList.remove('loading');
                    button.classList.add('error');
                    
                    showToast('error', data.message || 'Có lỗi xảy ra. Vui lòng thử lại.');
                    
                    setTimeout(() => {
                        button.innerHTML = originalContent;
                        button.classList.remove('error');
                        button.disabled = false;
                    }, 2000);
                }
            })
            .catch(error => {
                // Show error feedback
                button.innerHTML = '<i class="fas fa-times"></i><span>Lỗi!</span>';
                button.classList.remove('loading');
                button.classList.add('error');
                
                showToast('error', 'Có lỗi xảy ra. Vui lòng thử lại sau.');
                
                setTimeout(() => {
                    button.innerHTML = originalContent;
                    button.classList.remove('error');
                    button.disabled = false;
                }, 2000);
            });
        });
    });
    
    // Wishlist functionality
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const icon = this.querySelector('i');
            if (icon.classList.contains('far')) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                this.classList.add('active');
                showToast('success', 'Đã thêm vào danh sách yêu thích!');
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                this.classList.remove('active');
                showToast('info', 'Đã xóa khỏi danh sách yêu thích!');
            }
        });
    });
    
    // Toast notification function
    function showToast(type, message) {
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `modern-toast ${type}`;
        toast.innerHTML = `
            <div class="toast-content">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'times-circle' : 'info-circle'}"></i>
                <span>${message}</span>
            </div>
        `;
        
        // Add to page
        document.body.appendChild(toast);
        
        // Animate in
        setTimeout(() => toast.classList.add('show'), 100);
        
        // Remove after delay
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => document.body.removeChild(toast), 300);
        }, 3000);
    }
    
    // Modern card animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationDelay = Math.random() * 0.3 + 's';
                entry.target.classList.add('animate-slide-up');
            }
        });
    }, observerOptions);
    
    // Observe all modern product cards
    document.querySelectorAll('.modern-product-card').forEach(el => {
        observer.observe(el);
    });
</script>
@endsection
