@extends('layouts.customer')

@section('title', 'Giỏ hàng của bạn')

@section('content')

<div class="container py-5">
{{-- Toast notifications sẽ được hiển thị tự động từ layout --}}

    @if(!empty($cart))
        <div class="row g-4">
            <!-- Cart Items Section -->
            <div class="col-lg-8">
                <div class="cart-section">
                    <div class="section-header mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="fw-bold mb-1">
                                    <i class="fas fa-list-alt me-2 text-primary"></i>Danh sách sản phẩm
                                </h3>
                                <p class="text-muted mb-0">Chọn sản phẩm muốn thanh toán và quản lý số lượng</p>
                            </div>
                            <div class="cart-actions">
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="clearAllCart()" id="clearAllBtn">
                                    <i class="fas fa-trash-alt me-1"></i>Xóa tất cả
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="cart-items">
                        @php $total = 0; @endphp
                        @foreach($cart as $id => $details)
                            @php $subtotal = $details['price'] * $details['quantity']; $total += $subtotal; @endphp
                            <div class="cart-item-card mb-4">
                                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                                    <div class="card-body p-4">
                                        <div class="row align-items-center">
                                            <!-- Product Selection Checkbox -->
                                            <div class="col-md-1">
                                                <div class="form-check">
                                                    <input class="form-check-input product-checkbox" type="checkbox" 
                                                           id="product_{{ $id }}" 
                                                           data-product-id="{{ $id }}"
                                                           data-price="{{ $details['price'] }}"
                                                           data-quantity="{{ $details['quantity'] }}"
                                                           checked
                                                           onchange="updateCartSummary()">
                                                    <label class="form-check-label" for="product_{{ $id }}">
                                                        <span class="visually-hidden">Chọn sản phẩm</span>
                                                    </label>
                                                </div>
                                            </div>
                                            
                                            <!-- Product Image & Info -->
                                            <div class="col-md-5">
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
                                                    <label class="form-label small text-muted mb-2 d-block text-center">Số lượng</label>
                                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="quantity-form">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="input-group quantity-input-group mx-auto">
                                                            <button type="button" class="btn btn-outline-secondary quantity-btn" onclick="changeQuantity(this, -1)" aria-label="Giảm số lượng">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                            <input type="number" name="quantity" class="form-control text-center quantity-input" value="{{ $details['quantity'] }}" min="1" max="999" aria-label="Số lượng sản phẩm">
                                                            <button type="button" class="btn btn-outline-secondary quantity-btn" onclick="changeQuantity(this, 1)" aria-label="Tăng số lượng">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </div>
                                                        <button type="submit" class="btn btn-sm btn-primary mt-2 w-100 update-btn">
                                                            <i class="fas fa-sync-alt me-1"></i><span class="d-none d-sm-inline">Cập nhật</span><span class="d-sm-none">Cập nhật</span>
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
                                        <span class="fw-semibold" id="selected-count">{{ array_sum(array_column($cart, 'quantity')) }} món</span>
                                    </div>
                                    <div class="summary-row d-flex justify-content-between mb-3">
                                        <span class="text-muted">Tạm tính:</span>
                                        <span class="fw-semibold" id="subtotal-amount">{{ number_format($total, 0, ',', '.') }}₫</span>
                                    </div>
                                    <div class="summary-row d-flex justify-content-between mb-3">
                                        <span class="text-muted">Phí vận chuyển:</span>
                                        <span class="fw-semibold text-success">Miễn phí</span>
                                    </div>
                                    <hr class="my-3">
                                    <div class="total-section">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="h5 mb-0 fw-bold">Tổng cộng:</span>
                                            <span class="h4 mb-0 fw-bold text-primary" id="total-amount">{{ number_format($total, 0, ',', '.') }}₫</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 p-4 pt-0">
                                <div class="d-grid gap-3">
                                    <button type="button" class="btn btn-primary btn-lg checkout-btn" onclick="proceedToCheckout()" id="checkoutBtn">
                                        <i class="fas fa-credit-card me-2"></i>Tiến hành thanh toán
                                    </button>
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
// Suppress browser extension errors
window.addEventListener('error', function(e) {
    // Ignore errors from browser extensions
    if (e.filename && (e.filename.includes('extension') || e.filename.includes('share-modal'))) {
        e.preventDefault();
        return false;
    }
});

// Cập nhật tóm tắt giỏ hàng khi chọn/bỏ chọn sản phẩm
function updateCartSummary() {
    const checkboxes = document.querySelectorAll('.product-checkbox:checked');
    let totalAmount = 0;
    let totalQuantity = 0;
    
    checkboxes.forEach(checkbox => {
        const price = parseFloat(checkbox.dataset.price);
        const quantity = parseInt(checkbox.dataset.quantity);
        totalAmount += price * quantity;
        totalQuantity += quantity;
    });
    
    // Cập nhật UI với null checks
    const selectedCountEl = document.getElementById('selected-count');
    const subtotalAmountEl = document.getElementById('subtotal-amount');
    const totalAmountEl = document.getElementById('total-amount');
    const checkoutBtn = document.getElementById('checkoutBtn');
    
    if (selectedCountEl) {
        selectedCountEl.textContent = totalQuantity + ' món';
    }
    if (subtotalAmountEl) {
        subtotalAmountEl.textContent = formatCurrency(totalAmount);
    }
    if (totalAmountEl) {
        totalAmountEl.textContent = formatCurrency(totalAmount);
    }
    
    // Enable/disable checkout button với null check
    if (checkoutBtn) {
        if (totalQuantity === 0) {
            checkoutBtn.disabled = true;
            checkoutBtn.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Vui lòng chọn sản phẩm';
            checkoutBtn.classList.add('btn-secondary');
            checkoutBtn.classList.remove('btn-primary');
        } else {
            checkoutBtn.disabled = false;
            checkoutBtn.innerHTML = '<i class="fas fa-credit-card me-2"></i>Tiến hành thanh toán';
            checkoutBtn.classList.add('btn-primary');
            checkoutBtn.classList.remove('btn-secondary');
        }
    }
}

// Format currency
function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN').format(amount) + '₫';
}

// Xóa tất cả sản phẩm trong giỏ hàng
function clearAllCart() {
    if (confirm('Bạn có chắc chắn muốn xóa tất cả sản phẩm trong giỏ hàng?')) {
        // Disable button để tránh double click
        const clearBtn = document.getElementById('clearAllBtn');
        clearBtn.disabled = true;
        clearBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Đang xóa...';
        
        // Gửi request xóa tất cả
        fetch('{{ route("cart.clear") }}', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                location.reload();
            } else {
                alert('Có lỗi xảy ra khi xóa giỏ hàng: ' + (data.message || 'Lỗi không xác định'));
            }
        })
        .catch(error => {
            console.error('Error details:', error);
            alert('Có lỗi xảy ra khi xóa giỏ hàng: ' + error.message);
        })
        .finally(() => {
            // Reset button state
            clearBtn.disabled = false;
            clearBtn.innerHTML = '<i class="fas fa-trash-alt me-1"></i>Xóa tất cả';
        });
    }
}

// Tiến hành thanh toán với sản phẩm được chọn
function proceedToCheckout() {
    const selectedProducts = [];
    const checkboxes = document.querySelectorAll('.product-checkbox:checked');
    
    if (checkboxes.length === 0) {
        alert('Vui lòng chọn ít nhất một sản phẩm để thanh toán!');
        return;
    }
    
    // Disable button để tránh double click
    const checkoutBtn = document.getElementById('checkoutBtn');
    if (checkoutBtn) {
        checkoutBtn.disabled = true;
        checkoutBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...';
    }
    
    checkboxes.forEach(checkbox => {
        selectedProducts.push({
            id: checkbox.dataset.productId,
            quantity: parseInt(checkbox.dataset.quantity),
            price: parseFloat(checkbox.dataset.price)
        });
    });
    
    console.log('Selected products:', selectedProducts);
    
    // Lưu sản phẩm được chọn vào session
    fetch('{{ route("cart.setSelected") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ selectedProducts: selectedProducts })
    })
    .then(response => {
        console.log('Checkout response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Checkout response data:', data);
        if (data.success) {
            window.location.href = '{{ route("checkout.index") }}';
        } else {
            alert('Có lỗi xảy ra khi chuẩn bị thanh toán: ' + (data.message || 'Lỗi không xác định'));
        }
    })
    .catch(error => {
        console.error('Checkout error details:', error);
        alert('Có lỗi xảy ra khi chuẩn bị thanh toán: ' + error.message);
    })
    .finally(() => {
        // Reset button state
        if (checkoutBtn) {
            checkoutBtn.disabled = false;
            checkoutBtn.innerHTML = '<i class="fas fa-credit-card me-2"></i>Tiến hành thanh toán';
        }
    });
}

function changeQuantity(button, change) {
    const input = button.parentNode.querySelector('.quantity-input');
    let value = parseInt(input.value) + change;
    if (value < 1) value = 1;
    if (value > 999) value = 999;
    input.value = value;
    
    // Cập nhật data-quantity của checkbox
    const checkbox = button.closest('.cart-item-card').querySelector('.product-checkbox');
    checkbox.dataset.quantity = value;
    
    // Thêm hiệu ứng visual feedback
    button.style.transform = 'scale(0.95)';
    setTimeout(() => {
        button.style.transform = 'scale(1)';
    }, 150);
    
    // Cập nhật tóm tắt
    updateCartSummary();
}

// Auto-submit form when quantity changes
document.addEventListener('DOMContentLoaded', function() {
    const quantityInputs = document.querySelectorAll('.quantity-input');
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            // Kiểm tra giá trị hợp lệ
            let value = parseInt(this.value);
            if (isNaN(value) || value < 1) {
                this.value = 1;
            } else if (value > 999) {
                this.value = 999;
            }
            
            // Cập nhật data-quantity của checkbox
            const checkbox = this.closest('.cart-item-card').querySelector('.product-checkbox');
            checkbox.dataset.quantity = this.value;
            
            // Thêm visual feedback
            const updateBtn = this.closest('.quantity-form').querySelector('.update-btn');
            updateBtn.classList.add('btn-warning');
            updateBtn.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>Cần cập nhật';
            
            // Cập nhật tóm tắt
            updateCartSummary();
            
            // Tự động submit sau 2 giây nếu không có thao tác nào khác
            clearTimeout(this.submitTimeout);
            this.submitTimeout = setTimeout(() => {
                updateBtn.closest('form').submit();
            }, 2000);
        });
        
        // Reset khi focus vào input
        input.addEventListener('focus', function() {
            const updateBtn = this.closest('.quantity-form').querySelector('.update-btn');
            updateBtn.classList.remove('btn-warning');
            updateBtn.innerHTML = '<i class="fas fa-sync-alt me-1"></i>Cập nhật';
            clearTimeout(this.submitTimeout);
        });
    });
    
    // Cải thiện UX cho mobile - thêm touch feedback
    const quantityBtns = document.querySelectorAll('.quantity-btn');
    quantityBtns.forEach(btn => {
        btn.addEventListener('touchstart', function() {
            this.style.backgroundColor = '#1d4ed8';
        });
        
        btn.addEventListener('touchend', function() {
            setTimeout(() => {
                this.style.backgroundColor = '';
            }, 150);
        });
    });
    
    // Khởi tạo tóm tắt giỏ hàng chỉ khi có sản phẩm
    const cartItems = document.querySelectorAll('.cart-item-card');
    if (cartItems.length > 0) {
        updateCartSummary();
    } else {
        // Nếu giỏ hàng trống, ẩn phần tóm tắt đơn hàng
        const cartSummarySection = document.querySelector('.cart-summary-section');
        if (cartSummarySection) {
            cartSummarySection.style.display = 'none';
        }
    }
});
</script>
@endsection