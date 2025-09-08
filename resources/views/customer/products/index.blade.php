@extends('layouts.customer')

@section('title', 'Tất cả sản phẩm - Balo Shop')

@section('content')


<!-- Filters and Search Section -->
<div class="filters-section py-4 bg-light">
    <div class="container">
        <form method="GET" action="{{ route('products.index') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Tìm kiếm</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm balo...">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Danh mục</label>
                <select class="form-select" name="category">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Sắp xếp</label>
                <select class="form-select" name="sort">
                    <option value="">Mặc định</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá thấp đến cao</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá cao đến thấp</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Tên A-Z</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Tên Z-A</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter me-2"></i>Lọc
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Products Grid -->
<div class="container py-5">
    @if($products->count() > 0)
        <div class="row" id="products-grid">
            @foreach ($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
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
                            <button class="action-btn compare-btn" title="So sánh">
                                <i class="fas fa-balance-scale"></i>
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
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if(method_exists($products, 'links'))
            <div class="d-flex justify-content-center mt-5">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-5">
            <div class="empty-state">
                <i class="fas fa-search fa-4x text-muted mb-4"></i>
                <h3 class="text-muted mb-3">Không tìm thấy sản phẩm nào</h3>
                <p class="text-muted mb-4">Thử thay đổi bộ lọc hoặc từ khóa tìm kiếm</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">
                    <i class="fas fa-refresh me-2"></i>Xem tất cả sản phẩm
                </a>
            </div>
        </div>
    @endif
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
    
    // Compare functionality
    document.querySelectorAll('.compare-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            this.classList.toggle('active');
            if (this.classList.contains('active')) {
                showToast('success', 'Đã thêm vào danh sách so sánh!');
            } else {
                showToast('info', 'Đã xóa khỏi danh sách so sánh!');
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
    
    // Filter functionality (if filters exist)
    const filterButtons = document.querySelectorAll('.filter-btn');
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            // Add loading animation to products grid
            const grid = document.getElementById('products-grid');
            grid.style.opacity = '0.5';
            
            // Simulate filter (you can implement actual filtering logic here)
            setTimeout(() => {
                grid.style.opacity = '1';
            }, 500);
        });
    });
</script>
@endsection
