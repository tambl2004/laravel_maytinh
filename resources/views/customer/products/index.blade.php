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
                <div class="product-card-enhanced">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="product-image-wrapper">
                            <img src="{{ $product->image }}" class="card-img-top product-image" alt="{{ $product->name }}">
                            <div class="product-overlay">
                                <div class="overlay-buttons">
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-light btn-sm mb-2">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('cart.add', $product) }}" method="POST" class="quick-add-form">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-primary btn-sm" title="Thêm vào giỏ">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @if($product->stock <= 5 && $product->stock > 0)
                                <div class="product-badge badge-warning">Sắp hết</div>
                            @elseif($product->stock == 0)
                                <div class="product-badge badge-danger">Hết hàng</div>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-2">{{ Str::limit($product->name, 50) }}</h5>
                            <p class="card-text text-muted small flex-grow-1">{{ Str::limit($product->description, 80) }}</p>
                            <div class="product-info mt-auto">
                                <div class="price-section">
                                    <span class="current-price text-primary fw-bold h5">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                </div>
                                <div class="product-actions mt-3">
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary btn-sm flex-fill me-2">
                                        Xem chi tiết
                                    </a>
                                    @if($product->stock > 0)
                                        <form action="{{ route('cart.add', $product) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fas fa-cart-plus"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-secondary btn-sm" disabled>
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
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

<!-- Quick View Modal -->
<div class="modal fade" id="quickViewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xem nhanh sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <img id="quick-view-image" src="" class="img-fluid rounded" alt="">
                    </div>
                    <div class="col-md-6">
                        <h4 id="quick-view-name"></h4>
                        <p id="quick-view-description" class="text-muted"></p>
                        <div class="price-section mb-3">
                            <span id="quick-view-price" class="h4 text-primary fw-bold"></span>
                        </div>
                        <div class="quick-view-actions">
                            <a id="quick-view-link" href="#" class="btn btn-primary me-2">Xem chi tiết</a>
                            <button class="btn btn-outline-primary">Thêm vào giỏ</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Quick Add to Cart functionality
    document.querySelectorAll('.quick-add-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const button = this.querySelector('button');
            const originalText = button.innerHTML;
            
            // Show loading state
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            button.disabled = true;
            
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
                // Show success feedback
                button.innerHTML = '<i class="fas fa-check"></i>';
                button.classList.remove('btn-primary');
                button.classList.add('btn-success');
                
                // Update cart count if available
                const cartBadge = document.querySelector('.nav-link .badge');
                if (cartBadge && data.cartCount) {
                    cartBadge.textContent = data.cartCount;
                }
                
                // Reset button after delay
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.classList.remove('btn-success');
                    button.classList.add('btn-primary');
                    button.disabled = false;
                }, 2000);
            })
            .catch(error => {
                // Show error feedback
                button.innerHTML = '<i class="fas fa-times"></i>';
                button.classList.remove('btn-primary');
                button.classList.add('btn-danger');
                
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.classList.remove('btn-danger');
                    button.classList.add('btn-primary');
                    button.disabled = false;
                }, 2000);
            });
        });
    });
    
    // Filter form auto-submit on select change
    document.querySelectorAll('.filters-section select').forEach(select => {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });
    
    // Add fade-in animation to product cards
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '0';
                entry.target.style.transform = 'translateY(20px)';
                entry.target.style.transition = 'all 0.6s ease';
                
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, 100);
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.product-card-enhanced').forEach(card => {
        observer.observe(card);
    });
</script>