@extends('layouts.customer')

@section('title', 'Giỏ hàng của bạn')

@section('content')


<div class="container py-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(!empty($cart))
        <div class="row g-4">
            <!-- Cart Items Section -->
            <div class="col-lg-8">
                <div class="cart-section">
                    <div class="section-header mb-4">
                        <h3 class="fw-bold mb-1">
                            <i class="fas fa-list-alt me-2 text-primary"></i>Danh sách sản phẩm
                        </h3>
                        <p class="text-muted mb-0">Quản lý số lượng và xóa sản phẩm không mong muốn</p>
                    </div>
                    
                    <div class="cart-items">
                        @php $total = 0; @endphp
                        @foreach($cart as $id => $details)
                            @php $subtotal = $details['price'] * $details['quantity']; $total += $subtotal; @endphp
                            <div class="cart-item-card mb-4">
                                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                                    <div class="card-body p-4">
                                        <div class="row align-items-center">
                                            <!-- Product Image & Info -->
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center">
                                                    <div class="product-image-wrapper me-3">
                                                        <img src="{{ $details['image'] }}" alt="{{ $details['name'] }}" class="cart-product-image">
                                                    </div>
                                                    <div class="product-info">
                                                        <h5 class="product-name mb-1">{{ $details['name'] }}</h5>
                                                        <p class="product-price mb-0">{{ number_format($details['price'], 0, ',', '.') }}₫</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Quantity Controls -->
                                            <div class="col-md-3">
                                                <div class="quantity-controls">
                                                    <label class="form-label small text-muted mb-2">Số lượng</label>
                                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="quantity-form">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="input-group quantity-input-group">
                                                            <button type="button" class="btn btn-outline-secondary quantity-btn" onclick="changeQuantity(this, -1)">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                            <input type="number" name="quantity" class="form-control text-center quantity-input" value="{{ $details['quantity'] }}" min="1" max="999">
                                                            <button type="button" class="btn btn-outline-secondary quantity-btn" onclick="changeQuantity(this, 1)">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </div>
                                                        <button type="submit" class="btn btn-sm btn-primary mt-2 w-100 update-btn">
                                                            <i class="fas fa-sync-alt me-1"></i>Cập nhật
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            
                                            <!-- Subtotal & Remove -->
                                            <div class="col-md-3">
                                                <div class="text-end">
                                                    <div class="subtotal-section mb-3">
                                                        <label class="form-label small text-muted mb-1">Thành tiền</label>
                                                        <div class="subtotal-price">{{ number_format($subtotal, 0, ',', '.') }}₫</div>
                                                    </div>
                                                    <form action="{{ route('cart.remove', $id) }}" method="POST" class="remove-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm remove-btn" title="Xóa sản phẩm">
                                                            <i class="fas fa-trash-alt me-1"></i>Xóa
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Cart Summary Section -->
            <div class="col-lg-4">
                <div class="cart-summary-section">
                    <div class="cart-summary-card">
                        <div class="card border-0 shadow-lg rounded-3">
                            <div class="card-header bg-gradient-primary text-white border-0 rounded-top">
                                <h4 class="mb-0 fw-bold">
                                    <i class="fas fa-calculator me-2"></i>Tóm tắt đơn hàng
                                </h4>
                            </div>
                            <div class="card-body p-4">
                                <div class="summary-details">
                                    <div class="summary-row d-flex justify-content-between mb-3">
                                        <span class="text-muted">Số lượng sản phẩm:</span>
                                        <span class="fw-semibold">{{ array_sum(array_column($cart, 'quantity')) }} món</span>
                                    </div>
                                    <div class="summary-row d-flex justify-content-between mb-3">
                                        <span class="text-muted">Tạm tính:</span>
                                        <span class="fw-semibold">{{ number_format($total, 0, ',', '.') }}₫</span>
                                    </div>
                                    <div class="summary-row d-flex justify-content-between mb-3">
                                        <span class="text-muted">Phí vận chuyển:</span>
                                        <span class="fw-semibold text-success">Miễn phí</span>
                                    </div>
                                    <hr class="my-3">
                                    <div class="total-section">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="h5 mb-0 fw-bold">Tổng cộng:</span>
                                            <span class="h4 mb-0 fw-bold text-primary">{{ number_format($total, 0, ',', '.') }}₫</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 p-4 pt-0">
                                <div class="d-grid gap-3">
                                    <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg checkout-btn">
                                        <i class="fas fa-credit-card me-2"></i>Tiến hành thanh toán
                                    </a>
                                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary continue-shopping-btn">
                                        <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua sắm
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Promo Section -->
                    <div class="promo-section mt-4">
                        <div class="card border-0 bg-light rounded-3">
                            <div class="card-body p-3">
                                <h6 class="fw-bold text-success mb-2">
                                    <i class="fas fa-tags me-2"></i>Ưu đãi đặc biệt
                                </h6>
                                <p class="small text-muted mb-0">Miễn phí vận chuyển cho đơn hàng từ 500.000₫</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        <!-- Empty Cart Section -->
        <div class="empty-cart-section text-center py-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="empty-cart-card">
                        <div class="empty-cart-icon mb-4">
                            <i class="fas fa-shopping-cart text-muted" style="font-size: 4rem;"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Giỏ hàng trống</h3>
                        <p class="text-muted mb-4">Có vẻ như bạn chưa thêm sản phẩm nào vào giỏ hàng. Hãy khám phá các sản phẩm tuyệt vời của chúng tôi!</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-shopping-bag me-2"></i>Bắt đầu mua sắm
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- JavaScript for quantity controls -->
<script>
function changeQuantity(button, change) {
    const input = button.parentNode.querySelector('.quantity-input');
    let value = parseInt(input.value) + change;
    if (value < 1) value = 1;
    if (value > 999) value = 999;
    input.value = value;
}

// Auto-submit form when quantity changes
document.addEventListener('DOMContentLoaded', function() {
    const quantityInputs = document.querySelectorAll('.quantity-input');
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            // Optional: Add visual feedback that form will be submitted
            const updateBtn = this.closest('.quantity-form').querySelector('.update-btn');
            updateBtn.classList.add('btn-warning');
            updateBtn.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>Cần cập nhật';
        });
    });
});
</script>
@endsection