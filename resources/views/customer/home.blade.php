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
                <div class="product-card">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-img-wrapper">
                            <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                            <div class="card-overlay">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-primary">
                                    <i class="fas fa-eye me-2"></i>Xem chi tiết
                                </a>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-2">{{ Str::limit($product->name, 50) }}</h5>
                            <div class="price-section mt-auto">
                                <p class="price text-primary fw-bold h5 mb-2">{{ number_format($product->price, 0, ',', '.') }}₫</p>
                                <button class="btn btn-outline-primary btn-sm w-100">
                                    <i class="fas fa-cart-plus me-2"></i>Thêm vào giỏ
                                </button>
                            </div>
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
    // Add smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Add intersection observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationDelay = '0.1s';
                entry.target.style.animationFillMode = 'both';
                entry.target.classList.add('animate-fade-in');
            }
        });
    }, observerOptions);
    
    // Observe all product cards and feature items
    document.querySelectorAll('.product-card, .feature-item').forEach(el => {
        observer.observe(el);
    });
</script>