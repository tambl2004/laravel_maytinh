@extends('layouts.customer')

@section('title', $product->name . ' - Balo Shop')

@section('content')
<div class="container my-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-white p-0">
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
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($product->name, 60) }}</li>
        </ol>
    </nav>

    <!-- Product Details -->
    <div class="row mb-5">
        <!-- Product Images -->
        <div class="col-lg-6 mb-4">
            <div class="product-image-gallery">
                <div class="d-lg-flex gallery-vertical">
                    <div class="thumbs d-none d-lg-flex flex-column me-3">
                        <button type="button" class="thumb-item active">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}">
                        </button>
                    </div>
                    <div class="flex-fill">
                        <div class="main-image-container shadow-sm position-relative">
                            @php $runningPromo = \Illuminate\Support\Facades\Schema::hasTable('promotions') ? $product->promotions->firstWhere(fn($p) => $p->isRunning()) : null; @endphp
                            @if($runningPromo)
                                <div class="promo-badge">{{ $runningPromo->type==='percent' ? (int)$runningPromo->value.'%' : (number_format($runningPromo->value,0,',','.').'₫') }} OFF</div>
                            @endif
                            <button class="btn-wishlist wishlist-toggle {{ $wishlistIds->contains($product->id) ? 'active' : '' }}" data-id="{{ $product->id }}" aria-label="Thêm yêu thích">
                                <i class="fas fa-heart"></i>
                            </button>
                            <img src="{{ $product->image }}" 
                                 class="img-fluid rounded-3 main-product-image" 
                                 alt="{{ $product->name }}"
                                 id="mainProductImage">
                            <div class="image-zoom-overlay" aria-hidden="true">
                                <i class="fas fa-search-plus"></i>
                            </div>
                        </div>
                        <div class="thumbnail-images mt-3 d-lg-none">
                            <div class="row g-2">
                                <div class="col-3">
                                    <img src="{{ $product->image }}" class="img-thumbnail rounded-2 thumbnail-img active" alt="{{ $product->name }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-lg-6">
            <div class="product-info position-sticky buy-card card border-0 shadow-sm" style="top: 1.25rem;">
                <div class="card-body">
                <h1 class="product-title mb-2 h3">{{ $product->name }}</h1>
                
                <!-- Product Meta -->
                <div class="product-meta mb-3">
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
                <div class="price-line d-flex align-items-center justify-content-between mb-3">
                    @php $discountPrice = \Illuminate\Support\Facades\Schema::hasTable('promotions') ? $product->discounted_price : $product->price; @endphp
                    @if($discountPrice < $product->price)
                        <span class="h2 text-danger fw-bold mb-0">{{ number_format($discountPrice, 0, ',', '.') }}₫</span>
                        <small class="text-muted text-decoration-line-through">{{ number_format($product->price, 0, ',', '.') }}₫</small>
                    @else
                        <span class="h2 text-primary fw-bold mb-0">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                    @endif
                    <small class="text-success"><i class="fas fa-shipping-fast me-1"></i>Miễn phí > 500.000₫</small>
                </div>

                <ul class="benefit-list list-unstyled mb-4">
                    <li><i class="fas fa-rotate-left text-success me-2"></i>Đổi trả 7 ngày</li>
                    <li><i class="fas fa-shield-halved text-primary me-2"></i>Chính hãng 100%</li>
                    <li><i class="fas fa-truck-fast text-warning me-2"></i>Giao nhanh 2-5 ngày</li>
                    <li><i class="fas fa-lock text-dark me-2"></i>Thanh toán an toàn</li>
                </ul>

                <!-- Product Description -->
                <div class="product-description mb-3">
                    <h5 class="mb-3">Mô tả sản phẩm</h5>
                    <p class="lead text-muted">{{ $product->description }}</p>
                </div>

                <!-- Product Features (placeholder for future features) -->
                <div class="product-features mb-3">
                    <div class="d-flex flex-wrap gap-3 small text-muted">
                        <span><i class="fas fa-shield-alt text-primary me-1"></i>Bảo hành 12 tháng</span>
                        <span><i class="fas fa-water text-info me-1"></i>Chống nước</span>
                        <span><i class="fas fa-weight-hanging text-success me-1"></i>Nhẹ và bền</span>
                        <span><i class="fas fa-laptop text-warning me-1"></i>Ngăn laptop</span>
                    </div>
                </div>

                <!-- Add to Cart Section -->
                @if($product->stock > 0)
                    <div class="add-to-cart-section">
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="add-to-cart-form">
                            @csrf
                            <div class="mb-3">
                                <label for="quantity" class="form-label fw-semibold">Số lượng</label>
                                <div class="quantity-selector d-flex align-items-center justify-content-start">
                                    <button type="button" class="btn btn-outline-secondary quantity-btn" id="decreaseQty" aria-label="Giảm số lượng">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" name="quantity" id="quantity" class="form-control quantity-input text-center mx-0" value="1" min="1" max="{{ $product->stock }}">
                                    <button type="button" class="btn btn-outline-secondary quantity-btn" id="increaseQty" aria-label="Tăng số lượng">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="d-flex gap-3 align-items-center">
                                <button type="submit" class="btn btn-primary btn-lg flex-fill">
                                    <i class="fas fa-cart-plus me-2"></i>Thêm vào giỏ
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-lg px-4" aria-label="Thêm vào yêu thích">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </div>
                        </form>
                        <div class="quick-actions d-flex gap-2 mt-3">
                            <button class="btn btn-outline-primary btn-sm" data-action="share"><i class="fas fa-share-alt me-1"></i>Chia sẻ</button>
                            <button class="btn btn-outline-info btn-sm"><i class="fas fa-ruler me-1"></i>Hướng dẫn chọn size</button>
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
    </div>

    <!-- Product Tabs -->
    <div class="product-tabs-section mb-5">
        <ul class="nav nav-underline product-tabs" id="productTabs" role="tablist">
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
                    <i class="fas fa-star me-2"></i>Đánh giá ({{ $product->review_count }})
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
                <div class="reviews-section">
                    <!-- Review Summary -->
                    <div class="review-summary mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="rating-overview">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="average-rating me-3">
                                            <span class="h2 mb-0">{{ number_format($product->average_rating, 1) }}</span>
                                            <div class="stars">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= round($product->average_rating) ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                            </div>
                                            <small class="text-muted">({{ $product->review_count }} đánh giá)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="rating-distribution">
                                    @php $distribution = $product->rating_distribution; @endphp
                                    @for($i = 5; $i >= 1; $i--)
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="me-2">{{ $i }} <i class="fas fa-star text-warning small"></i></span>
                                            <div class="progress flex-fill me-2" style="height: 6px;">
                                                <div class="progress-bar bg-warning" style="width: {{ $product->review_count > 0 ? ($distribution[$i] / $product->review_count * 100) : 0 }}%"></div>
                                            </div>
                                            <small class="text-muted">{{ $distribution[$i] }}</small>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Review Form -->
                    @auth
                        @if(!$userReview)
                            @if($hasPurchased)
                                <div class="review-form-section mb-4 p-4" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 12px; border: 1px solid #dee2e6;">
                                    <h6 class="mb-3 text-dark fw-bold">
                                        <i class="fas fa-star text-warning me-2"></i>Đánh giá sản phẩm này
                                    </h6>
                                    <form action="{{ route('reviews.store', $product) }}" method="POST" class="review-form">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-dark">Đánh giá của bạn <span class="text-danger">*</span></label>
                                            <div class="rating-input d-flex align-items-center p-3 border rounded" style="background-color: #ffffff; border-color: #ced4da;">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="far fa-star rating-star" data-rating="{{ $i }}" title="{{ $i }} sao" style="color: #6c757d; font-size: 1.8rem; margin-right: 0.3rem; cursor: pointer; transition: color 0.2s ease;"></i>
                                                @endfor
                                                <input type="hidden" name="rating" id="rating" required>
                                                <span class="ms-3 rating-text text-muted small fst-italic">Nhấp vào sao để đánh giá</span>
                                            </div>
                                            @error('rating')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="comment" class="form-label text-dark fw-semibold">Nhận xét (tùy chọn)</label>
                                            <textarea name="comment" id="comment" class="form-control" rows="4" placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm..." style="border-color: #ced4da; border-radius: 8px;">{{ old('comment') }}</textarea>
                                            @error('comment')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; color: white; padding: 10px 24px; border-radius: 8px; font-weight: 600; transition: all 0.3s ease;">
                                            <i class="fas fa-paper-plane me-2"></i>Gửi đánh giá
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="alert" style="background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%); border: 1px solid #bee5eb; color: #0c5460; border-radius: 12px;">
                                    <i class="fas fa-info-circle me-2" style="color: #0c5460;"></i>
                                    <strong>Bạn cần mua sản phẩm này để có thể đánh giá.</strong>
                                </div>
                            @endif
                        @else
                            <div class="user-review-section mb-4">
                                <div class="alert" style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); border: 1px solid #c3e6cb; color: #155724; border-radius: 12px;">
                                    <h6 class="mb-2 fw-bold">
                                        <i class="fas fa-user-check me-2" style="color: #155724;"></i>Đánh giá của bạn
                                    </h6>
                                    <div class="d-flex align-items-center mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star" style="color: {{ $i <= $userReview->rating ? '#ffc107' : '#6c757d' }}; font-size: 1.2rem; margin-right: 0.2rem;"></i>
                                        @endfor
                                        <span class="ms-2 fw-semibold" style="color: #155724;">{{ $userReview->rating }}/5</span>
                                    </div>
                                    @if($userReview->comment)
                                        <p class="mb-2" style="color: #155724;">{{ $userReview->comment }}</p>
                                    @endif
                                    <small class="text-muted">Đánh giá vào {{ $userReview->created_at->format('d/m/Y H:i') }}</small>
                                    <div class="mt-3">
                                        <button class="btn btn-sm edit-review-btn" style="background: #007bff; border: none; color: white; padding: 6px 16px; border-radius: 6px; margin-right: 8px;">
                                            <i class="fas fa-edit me-1"></i>Chỉnh sửa
                                        </button>
                                        <form action="{{ route('reviews.destroy', $userReview) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa đánh giá này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm" style="background: #dc3545; border: none; color: white; padding: 6px 16px; border-radius: 6px;">
                                                <i class="fas fa-trash me-1"></i>Xóa
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                
                                <!-- Edit Form (hidden by default) -->
                                <div class="edit-review-form" style="display: none;">
                                    <div class="p-4" style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); border-radius: 12px; border: 1px solid #ffeaa7;">
                                        <h6 class="mb-3 fw-bold text-dark">
                                            <i class="fas fa-edit text-warning me-2"></i>Chỉnh sửa đánh giá
                                        </h6>
                                        <form action="{{ route('reviews.update', $userReview) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label class="form-label fw-bold text-dark">Đánh giá của bạn</label>
                                                <div class="rating-input d-flex align-items-center p-3 border rounded" style="background-color: #ffffff; border-color: #ced4da;">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="far fa-star rating-star-edit {{ $i <= $userReview->rating ? 'fas text-warning' : '' }}" data-rating="{{ $i }}" style="cursor: pointer; font-size: 1.8rem; margin-right: 0.3rem; transition: color 0.2s ease;"></i>
                                                    @endfor
                                                    <input type="hidden" name="rating" id="edit-rating" value="{{ $userReview->rating }}" required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="edit-comment" class="form-label text-dark fw-semibold">Nhận xét</label>
                                                <textarea name="comment" id="edit-comment" class="form-control" rows="4" style="border-color: #ced4da; border-radius: 8px;">{{ $userReview->comment }}</textarea>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <button type="submit" class="btn" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; color: white; padding: 8px 20px; border-radius: 8px; font-weight: 600;">
                                                    <i class="fas fa-save me-2"></i>Cập nhật
                                                </button>
                                                <button type="button" class="btn btn-secondary cancel-edit-btn" style="border-radius: 8px;">
                                                    <i class="fas fa-times me-2"></i>Hủy
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info mb-4">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Bạn cần đăng nhập để đánh giá sản phẩm.</strong>
                            <a href="{{ route('login') }}" class="btn btn-sm btn-primary ms-2">Đăng nhập</a>
                        </div>
                    @endauth

                    <!-- Reviews List -->
                    <div class="reviews-list">
                        <h6 class="mb-3 fw-bold text-dark">
                            <i class="fas fa-users text-primary me-2"></i>Đánh giá từ khách hàng
                        </h6>
                        @forelse($reviews as $review)
                            <div class="review-item p-3 mb-3" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 12px; border: 1px solid #dee2e6;">
                                <div class="d-flex align-items-start">
                                    <div class="reviewer-avatar me-3">
                                        <div class="text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);">
                                            {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="review-content flex-fill">
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <h6 class="mb-0 fw-bold text-dark">{{ $review->user->name }}</h6>
                                            <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div class="rating mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star" style="color: {{ $i <= $review->rating ? '#ffc107' : '#6c757d' }}; font-size: 1rem; margin-right: 0.1rem;"></i>
                                            @endfor
                                            <span class="ms-2 fw-semibold text-dark">{{ $review->rating }}/5</span>
                                        </div>
                                        @if($review->comment)
                                            <p class="mb-0 text-dark">{{ $review->comment }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 12px; border: 1px solid #dee2e6;">
                                <i class="fas fa-comments text-muted mb-3" style="font-size: 3rem;"></i>
                                <p class="text-muted mb-3">Chưa có đánh giá nào cho sản phẩm này.</p>
                                @auth
                                    @if(!$userReview)
                                        <button class="btn" id="writeFirstReview" style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); border: none; color: white; padding: 10px 24px; border-radius: 8px; font-weight: 600;">
                                            <i class="fas fa-star me-2"></i>Viết đánh giá đầu tiên
                                        </button>
                                    @endif
                                @endauth
                            </div>
                        @endforelse
                        
                        @if($reviews->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $reviews->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


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
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing product page scripts...');
    
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
    
    // Toast notification helper
    function showToast(type, message) {
        // Create toast if it doesn't exist
        let toast = document.getElementById('success-toast');
        if (!toast) {
            const toastContainer = document.createElement('div');
            toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
            toastContainer.style.zIndex = '9999';
            
            toastContainer.innerHTML = `
                <div id="success-toast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas fa-check-circle me-2"></i>
                            <span id="toast-message">Sản phẩm đã được thêm vào giỏ hàng!</span>
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `;
            
            document.body.appendChild(toastContainer);
            toast = document.getElementById('success-toast');
        }
        
        const toastMessage = document.getElementById('toast-message');
        
        // Update toast styling and message
        toast.className = `toast align-items-center text-white border-0 ${type === 'success' ? 'bg-success' : 'bg-danger'}`;
        toastMessage.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} me-2"></i>${message}`;
        
        // Show toast
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
    }
    
    // Tab content dynamic loading (placeholder)
    document.querySelectorAll('#productTabs button').forEach(tabBtn => {
        tabBtn.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-bs-target');
            // Here you could load content dynamically if needed
        });
    });
    
    // Review Rating System
    console.log('Initializing star rating system...');
    const ratingStars = document.querySelectorAll('.rating-star');
    const ratingInput = document.getElementById('rating');
    const ratingText = document.querySelector('.rating-text');
    const reviewForm = document.querySelector('.review-form');
    
    console.log('Found elements:');
    console.log('- Rating stars:', ratingStars.length);
    console.log('- Rating input:', ratingInput ? 'found' : 'NOT FOUND');
    console.log('- Rating text:', ratingText ? 'found' : 'NOT FOUND');
    console.log('- Review form:', reviewForm ? 'found' : 'NOT FOUND');
    
    if (ratingStars.length === 0) {
        console.error('No rating stars found! Check if user is logged in and on reviews tab.');
    }
    
    const ratingTexts = {
        1: 'Rất tệ',
        2: 'Tệ', 
        3: 'Bình thường',
        4: 'Tốt',
        5: 'Rất tốt'
    };
    
    ratingStars.forEach((star, index) => {
        console.log(`Setting up star ${index + 1}:`, star);
        
        star.addEventListener('click', function() {
            console.log('Star clicked! Rating:', this.dataset.rating);
            const rating = parseInt(this.dataset.rating);
            
            if (ratingInput) {
                ratingInput.value = rating;
                console.log('Rating input value set to:', rating);
            } else {
                console.error('Rating input not found!');
            }
            
            // Update visual stars
            ratingStars.forEach((s, i) => {
                s.classList.remove('fas', 'far', 'text-warning', 'text-muted');
                if (i < rating) {
                    s.classList.add('fas', 'text-warning');
                } else {
                    s.classList.add('far', 'text-muted');
                }
            });
            
            // Update rating text
            if (ratingText) {
                ratingText.textContent = ratingTexts[rating];
                ratingText.classList.remove('text-muted');
                ratingText.classList.add('text-primary', 'fw-bold');
            }
            
            console.log('Star rating updated successfully!');
        });
        
        // Hover effect
        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.dataset.rating);
            ratingStars.forEach((s, i) => {
                if (i < rating) {
                    s.classList.add('text-warning');
                    s.classList.remove('text-muted');
                } else {
                    s.classList.add('text-muted');
                    s.classList.remove('text-warning');
                }
            });
        });
        
        // Make sure stars are visually clickable
        star.style.cursor = 'pointer';
        star.style.fontSize = '1.5rem';
        star.style.marginRight = '0.25rem';
        star.style.transition = 'all 0.2s ease';
    });
    
    // Reset stars on mouse leave
    const ratingInputContainer = document.querySelector('.rating-input');
    if (ratingInputContainer) {
        ratingInputContainer.addEventListener('mouseleave', function() {
            const currentRating = parseInt(ratingInput ? ratingInput.value : 0) || 0;
            ratingStars.forEach((s, index) => {
                s.classList.remove('fas', 'far', 'text-warning', 'text-muted');
                if (index < currentRating) {
                    s.classList.add('fas', 'text-warning');
                } else {
                    s.classList.add('far', 'text-muted');
                }
            });
        });
    }
    
    // Form validation for review submission
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            const ratingValue = ratingInput ? ratingInput.value : '';
            console.log('Form submitted with rating:', ratingValue);
            
            if (!ratingValue || ratingValue === '') {
                e.preventDefault();
                
                // Show error message
                const existingError = document.querySelector('.rating-error');
                if (existingError) {
                    existingError.remove();
                }
                
                const errorDiv = document.createElement('div');
                errorDiv.className = 'text-danger small mt-1 rating-error';
                errorDiv.textContent = 'Vui lòng chọn số sao đánh giá';
                
                const ratingContainer = document.querySelector('.rating-input').parentElement;
                ratingContainer.appendChild(errorDiv);
                
                // Highlight the rating input
                ratingInputContainer.style.border = '2px solid #dc3545';
                ratingInputContainer.style.borderRadius = '4px';
                ratingInputContainer.style.padding = '8px';
                
                // Scroll to rating section
                ratingContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                console.log('Form submission prevented - no rating selected');
                return false;
            }
            
            console.log('Form validation passed, submitting...');
        });
    }
    
    // Edit Review Rating System
    const editRatingStars = document.querySelectorAll('.rating-star-edit');
    const editRatingInput = document.getElementById('edit-rating');
    
    editRatingStars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.dataset.rating);
            editRatingInput.value = rating;
            
            // Update visual stars
            editRatingStars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.remove('far');
                    s.classList.add('fas', 'text-warning');
                } else {
                    s.classList.remove('fas', 'text-warning');
                    s.classList.add('far');
                }
            });
        });
    });
    
    // Edit Review Toggle
    const editReviewBtn = document.querySelector('.edit-review-btn');
    const cancelEditBtn = document.querySelector('.cancel-edit-btn');
    const userReviewSection = document.querySelector('.user-review-section .alert');
    const editReviewForm = document.querySelector('.edit-review-form');
    
    if (editReviewBtn) {
        editReviewBtn.addEventListener('click', function() {
            userReviewSection.style.display = 'none';
            editReviewForm.style.display = 'block';
        });
    }
    
    if (cancelEditBtn) {
        cancelEditBtn.addEventListener('click', function() {
            userReviewSection.style.display = 'block';
            editReviewForm.style.display = 'none';
        });
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
    
    // Write first review button functionality
    const writeFirstReviewBtn = document.getElementById('writeFirstReview');
    if (writeFirstReviewBtn) {
        writeFirstReviewBtn.addEventListener('click', function() {
            // Switch to reviews tab
            const reviewsTab = document.getElementById('reviews-tab');
            if (reviewsTab) {
                reviewsTab.click();
                
                // Scroll to review form after a short delay
                setTimeout(() => {
                    const reviewForm = document.querySelector('.review-form');
                    if (reviewForm) {
                        reviewForm.scrollIntoView({ behavior: 'smooth' });
                        
                        // Automatically select 5 stars
                        const fiveStarBtn = document.querySelector('.rating-star[data-rating="5"]');
                        if (fiveStarBtn) {
                            fiveStarBtn.click();
                        }
                    }
                }, 300);
            }
        });
    }
});
</script>

<!-- Include wishlist functionality -->
<script src="{{ asset('js/wishlist.js') }}"></script>