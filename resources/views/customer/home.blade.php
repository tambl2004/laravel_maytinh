@extends('layouts.customer')

@section('title', 'Trang chủ - Laptop Shop')

@section('styles')
<style>
    /* Thương hiệu: 1 hàng, kích thước đồng nhất, chạy vô hạn từ phải qua trái */
    .brand-marquee { background:#f8fafc; padding:20px 0; overflow:hidden; border-top:1px solid #eef2f7; border-bottom:1px solid #eef2f7; }
    .brand-inner { display:flex; min-width:200%; }
    .brand-track { display:flex; align-items:center; gap:48px; flex:1 0 50%; animation:brand-scroll 40s linear infinite; will-change:transform; }
    /* Card logo dạng bo góc như ảnh demo */
    .brand-logo { display:flex; align-items:center; justify-content:center; width:180px; height:110px; border-radius:18px; background:#ffffff; box-shadow:0 10px 25px rgba(2,6,23,0.06); }
    .brand-logo img { max-height:46px; width:auto; object-fit:contain; opacity:1; filter:none; }
    @keyframes brand-scroll { 0%{ transform:translateX(0); } 100%{ transform:translateX(-50%); } }
    @media (max-width:576px){ .brand-track{ gap:24px; } .brand-logo{ width:140px; height:90px; } .brand-logo img{ max-height:36px; } }
    /* Không dùng màu tím theo yêu cầu */
</style>
@endsection

@section('content')
<!-- Hero Banner Section với Carousel -->
<div class="hero-banner">
    <div class="hero-carousel">
        <!-- Slide 1 -->
        <div class="hero-slide active">
        </div>
        
        <!-- Slide 2 -->
        <div class="hero-slide">
        </div>
        
        <!-- Slide 3 -->
        <div class="hero-slide">
        </div>
        
        <!-- Navigation Arrows -->
        <button class="carousel-nav prev" onclick="changeSlide(-1)">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="carousel-nav next" onclick="changeSlide(1)">
            <i class="fas fa-chevron-right"></i>
        </button>
        
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
                    <div class="product-image-container position-relative">
                        @php $runningPromo = \Illuminate\Support\Facades\Schema::hasTable('promotions') ? $product->promotions->firstWhere(fn($p) => $p->isRunning()) : null; @endphp
                        @if($runningPromo)
                            <div class="promo-badge">{{ $runningPromo->type==='percent' ? (int)$runningPromo->value.'%' : (number_format($runningPromo->value,0,',','.').'₫') }} OFF</div>
                        @endif
                        <button class="btn-wishlist wishlist-toggle" data-id="{{ $product->id }}" aria-label="Thêm yêu thích">
                            <i class="fas fa-heart"></i>
                        </button>
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
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= round($product->average_rating) ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                </div>
                                <span class="rating-count">({{ number_format($product->average_rating, 1) }} - {{ $product->review_count }} đánh giá)</span>
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

<!-- Featured News Section -->
@if($featuredNews->count() > 0)
<div class="container py-5" id="featured-news">
    <div class="section-header text-center mb-5">
        <h2 class="display-5 fw-bold mb-3">Tin tức nổi bật</h2>
        <p class="lead text-muted">Cập nhật những tin tức mới nhất về công nghệ</p>
        <div class="divider mx-auto"></div>
    </div>
    
    <div class="row">
        @foreach($featuredNews as $news)
        <div class="col-lg-4 col-md-6 mb-4">
            <article class="news-card h-100">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    @if($news->featured_image)
                    <div class="news-image">
                        <img src="{{ $news->featured_image }}" alt="{{ $news->title }}" class="card-img-top">
                        <div class="featured-badge">
                            <i class="fas fa-star"></i>
                            <span>Nổi bật</span>
                        </div>
                    </div>
                    @endif
                    
                    <div class="card-body d-flex flex-column">
                        <div class="news-meta mb-3">
                            <div class="d-flex align-items-center text-muted small">
                                <i class="fas fa-user me-2"></i>
                                <span>{{ $news->author }}</span>
                                <i class="fas fa-calendar ms-3 me-2"></i>
                                <span>{{ $news->created_at->format('d/m/Y') }}</span>
                                <i class="fas fa-eye ms-3 me-2"></i>
                                <span>{{ $news->views }}</span>
                            </div>
                        </div>
                        
                        <h5 class="card-title mb-3">
                            <a href="{{ route('news.show', $news->slug) }}" class="text-decoration-none text-dark">
                                {{ Str::limit($news->title, 60) }}
                            </a>
                        </h5>
                        
                        @if($news->excerpt)
                        <p class="card-text text-muted flex-grow-1">
                            {{ Str::limit($news->excerpt, 100) }}
                        </p>
                        @endif
                        
                        <div class="news-actions mt-auto">
                            <a href="{{ route('news.show', $news->slug) }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-right me-2"></i>Đọc tiếp
                            </a>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        @endforeach
    </div>
    
    <!-- View All News Button -->
    <div class="text-center mt-4">
        <a href="{{ route('news.index') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-newspaper me-2"></i>Xem tất cả tin tức
        </a>
    </div>
</div>
@endif

<!-- Brand Logos: 1 hàng, chuyển động vô hạn từ phải qua trái -->
<section class="brand-marquee" aria-label="Thương hiệu đối tác">
    <div class="container-fluid px-0">
        <div class="brand-inner">
            <div class="brand-track">
                <div class="brand-logo"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSYrq2SDHsyK4YVWTX6Lvk4EGjDA55_9qCMBQ&s" alt="Apple" loading="lazy"></div>
                <div class="brand-logo"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQh0P_qONWsB8avfMxSeybh3eeyPOia05H5qA&s" alt="ASUS" loading="lazy"></div>
                <div class="brand-logo"><img src="https://logo.clearbit.com/dell.com" alt="Dell" loading="lazy"></div>
                <div class="brand-logo"><img src="https://logo.clearbit.com/hp.com" alt="HP" loading="lazy"></div>
                <div class="brand-logo"><img src="https://cdn-media.sforum.vn/storage/app/media/wp-content/uploads/2020/10/Branding_lenovo-logo_lenovologoposred_low_res.png" alt="Lenovo" loading="lazy"></div>
                <div class="brand-logo"><img src="https://inkythuatso.com/uploads/images/2021/11/logo-acer-inkythuatso-2-01-27-15-49-45.jpg" alt="Acer" loading="lazy"></div>
                <div class="brand-logo"><img src="https://inkythuatso.com/uploads/images/2021/11/logo-msi-inkythuatso-4-01-27-14-36-47.jpg" alt="MSI" loading="lazy"></div>
                <div class="brand-logo"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR_m2muP0ikavqAdSCpoH_D-ltfFQ4uzAKO06DetkyhuLOeuTcun-F-IjTTCnMgDcMkc_U&usqp=CAU" alt="Gigabyte" loading="lazy"></div>
                <div class="brand-logo"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRrfkucNHvTWnwsFPdg0WIus1eEWP6fAAkEgw&s" alt="Samsung" loading="lazy"></div>
                <div class="brand-logo"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQTaUmYZtcMHu5uPTy01RNTCx5RmbxAwb6kCw&s" alt="NVIDIA" loading="lazy"></div>
                <div class="brand-logo"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQlR2P8SEnAGCgNcAAh0bdJJIHL5j_5arZn_w&s" alt="AMD" loading="lazy"></div>
                <div class="brand-logo"><img src="https://upload.wikimedia.org/wikipedia/commons/7/7d/Intel_logo_%282006-2020%29.svg" alt="Intel" loading="lazy"></div>
            </div>
           
        </div>
    </div>
</section>

@if(isset($faqs) && $faqs->count() > 0)
<section class="py-5" style="background:#f8fafc;">
    <div class="container">
        <div class="section-header text-center mb-4">
            <h2 class="fw-bold mb-2">Câu hỏi thường gặp</h2>
            <p class="text-muted">Những thắc mắc phổ biến từ khách hàng</p>
        </div>
        <div class="accordion" id="faqAccordion">
            @foreach($faqs as $index => $faq)
            <div class="accordion-item mb-3 border-0 shadow-sm rounded-3">
                <h2 class="accordion-header" id="heading{{ $index }}">
                    <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
                        {{ $faq->question }}
                    </button>
                </h2>
                <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        {!! nl2br(e($faq->answer)) !!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

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
    let currentSlide = 0;
    let slideInterval;
    
    document.addEventListener('DOMContentLoaded', function() {
        const slides = document.querySelectorAll('.hero-slide');
        const dots = document.querySelectorAll('.carousel-dot');
        const totalSlides = slides.length;
        
        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));
            slides[index].classList.add('active');
            dots[index].classList.add('active');
            currentSlide = index;
        }
        
        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            showSlide(currentSlide);
        }
        
        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            showSlide(currentSlide);
        }
        
        // Tự động chuyển slide mỗi 5 giây
        function startSlideShow() {
            slideInterval = setInterval(nextSlide, 5000);
        }
        
        function stopSlideShow() {
            clearInterval(slideInterval);
        }
        
        // Click vào dots để chuyển slide
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                showSlide(index);
                stopSlideShow();
                startSlideShow(); // Restart autoplay
            });
        });
        
        // Start slideshow
        startSlideShow();
        
        // Pause on hover
        const carousel = document.querySelector('.hero-carousel');
        carousel.addEventListener('mouseenter', stopSlideShow);
        carousel.addEventListener('mouseleave', startSlideShow);
    });
    
    // Global function for navigation arrows
    function changeSlide(direction) {
        const slides = document.querySelectorAll('.hero-slide');
        const dots = document.querySelectorAll('.carousel-dot');
        const totalSlides = slides.length;
        
        if (direction === 1) {
            currentSlide = (currentSlide + 1) % totalSlides;
        } else {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        }
        
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));
        slides[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');
        
        // Restart autoplay
        clearInterval(slideInterval);
        slideInterval = setInterval(() => {
            currentSlide = (currentSlide + 1) % totalSlides;
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));
            slides[currentSlide].classList.add('active');
            dots[currentSlide].classList.add('active');
        }, 5000);
    }
    
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
    // Wishlist toggle
    document.querySelectorAll('.wishlist-toggle').forEach(btn => {
        btn.addEventListener('click', function(e){
            e.preventDefault();
            const id = this.getAttribute('data-id');
            fetch(`/wishlist/add/${id}`, { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') } })
                .then(r => r.json())
                .then(data => { if (data.success) this.classList.add('active'); });
        });
    });
</script>
@endsection
