@extends('layouts.customer')

@section('title', 'Chi tiết đơn hàng #' . $order->id)

@section('content')
<!-- Enhanced Order Details Hero Section -->
<div class="order-hero bg-gradient-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="hero-content animate-slide-up">
                    <h1 class="display-4 fw-bold mb-3">
                        <i class="fas fa-receipt me-3"></i>Chi tiết đơn hàng #{{ $order->id }}
                    </h1>
                    <p class="lead mb-4">Theo dõi thông tin chi tiết và trạng thái đơn hàng của bạn một cách dễ dàng</p>
                    <div class="order-stats d-flex gap-4 flex-wrap">
                        <div class="stat-item d-flex align-items-center">
                            <i class="fas fa-box text-warning me-2"></i>
                            <span class="fw-semibold">{{ $order->items->count() }} sản phẩm</span>
                        </div>
                        <div class="stat-item d-flex align-items-center">
                            <i class="fas fa-money-bill-wave text-success me-2"></i>
                            <span class="fw-semibold">{{ number_format($order->total_amount, 0, ',', '.') }}₫</span>
                        </div>
                        <div class="stat-item d-flex align-items-center">
                            <i class="fas fa-truck text-info me-2"></i>
                            <span class="fw-semibold">Miễn phí vận chuyển</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                <div class="order-meta animate-slide-up">
                    <div class="order-date mb-3">
                        <i class="fas fa-calendar-alt me-2"></i>
                        <span class="fw-semibold">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="order-status">
                        <span class="badge fs-6 px-4 py-3 
                            @if($order->status == 'pending') bg-warning text-dark
                            @elseif($order->status == 'processing') bg-info text-dark
                            @elseif($order->status == 'completed') bg-success
                            @elseif($order->status == 'cancelled') bg-danger
                            @else bg-secondary
                            @endif">
                            @if($order->status == 'pending')
                                <i class="fas fa-clock me-2"></i>Chờ xử lý
                            @elseif($order->status == 'processing')
                                <i class="fas fa-cog fa-spin me-2"></i>Đang xử lý
                            @elseif($order->status == 'completed')
                                <i class="fas fa-check-circle me-2"></i>Hoàn thành
                            @elseif($order->status == 'cancelled')
                                <i class="fas fa-times-circle me-2"></i>Đã hủy
                            @else
                                {{ ucfirst($order->status) }}
                            @endif
                        </span>
                    </div>
                    
                    @if($order->status == 'cancelled' && $order->cancel_reason)
                    <div class="cancel-reason mt-3 p-3 bg-danger bg-opacity-10 rounded-3">
                        <small class="text-white">
                            <i class="fas fa-info-circle me-1"></i>
                            Lý do hủy: {{ $order->cancel_reason }}
                        </small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <!-- Enhanced Back Button -->
    <div class="mb-5">
        <a href="{{ route('orders.my') }}" class="btn btn-outline-primary btn-lg">
            <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách đơn hàng
        </a>
    </div>

    <!-- Enhanced Order Progress Timeline -->
    <div class="order-timeline-section mb-5 animate-slide-up">
        <div class="card border-0 shadow-lg">
            <div class="card-header bg-light border-0 py-4">
                <h4 class="mb-0 fw-bold d-flex align-items-center">
                    <i class="fas fa-route text-primary me-3"></i>Tiến trình đơn hàng
                    <span class="badge bg-primary ms-auto px-3">{{ ucfirst($order->status) }}</span>
                </h4>
                <p class="text-muted mb-0 mt-2">Theo dõi quá trình xử lý đơn hàng của bạn</p>
            </div>
            <div class="card-body p-5">
                <div class="order-progress-timeline">
                    <div class="progress-steps-horizontal">
                        <div class="step {{ in_array($order->status, ['pending', 'processing', 'completed']) ? 'active' : '' }}">
                            <div class="step-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="step-content">
                                <div class="step-title">Đơn hàng được tạo</div>
                                <div class="step-time">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                        
                        <div class="step {{ in_array($order->status, ['processing', 'completed']) ? 'active' : '' }}">
                            <div class="step-icon">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <div class="step-content">
                                <div class="step-title">Đang xử lý</div>
                                <div class="step-time">
                                    @if(in_array($order->status, ['processing', 'completed']))
                                        Đang được xử lý
                                    @else
                                        Chưa xử lý
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="step {{ $order->status == 'completed' ? 'active' : '' }}">
                            <div class="step-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="step-content">
                                <div class="step-title">Hoàn thành</div>
                                <div class="step-time">
                                    @if($order->status == 'completed')
                                        Đã hoàn thành
                                    @else
                                        Chưa hoàn thành
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        @if($order->status == 'cancelled')
                        <div class="step active cancelled">
                            <div class="step-icon">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <div class="step-content">
                                <div class="step-title">Đã hủy</div>
                                <div class="step-time">
                                    @if($order->cancelled_at)
                                        {{ $order->cancelled_at->format('d/m/Y H:i') }}
                                    @else
                                        Đơn hàng đã bị hủy
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Enhanced Order Items Section -->
        <div class="col-lg-8">
            <div class="order-items-section animate-slide-up">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-gradient-primary text-white border-0">
                        <h5 class="mb-0 fw-bold d-flex align-items-center">
                            <i class="fas fa-shopping-bag me-3"></i>
                            Sản phẩm trong đơn hàng
                            <span class="badge bg-white text-primary ms-auto rounded-pill px-3 py-2">
                                {{ $order->items->count() }} sản phẩm
                            </span>
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="order-items-list">
                            @foreach($order->items as $index => $item)
                            <div class="order-item-card {{ $index < $order->items->count() - 1 ? 'border-bottom' : '' }}">
                                <div class="row align-items-center p-4">
                                    <div class="col-lg-3 col-md-4">
                                        <div class="item-image-wrapper">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ $item->product->image }}" alt="{{ $item->product_name }}" class="order-item-image">
                                            @else
                                                <div class="placeholder-image">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-8 mt-3 mt-md-0">
                                        <div class="item-details">
                                            <h6 class="item-name mb-2">{{ $item->product_name }}</h6>
                                            <div class="item-meta">
                                                <span class="item-price">{{ number_format($item->price, 0, ',', '.') }}₫</span>
                                                @if($item->product)
                                                    <span class="item-sku text-muted">• SKU: PRD-{{ $item->product->id }}</span>
                                                @endif
                                            </div>
                                            @if($item->product)
                                            <div class="item-actions mt-2">
                                                <a href="{{ route('products.show', $item->product) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye me-1"></i>Xem sản phẩm
                                                </a>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-6 text-center mt-3 mt-lg-0">
                                        <div class="item-quantity">
                                            <span class="quantity-badge">x{{ $item->quantity }}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-6 text-end mt-3 mt-lg-0">
                                        <div class="item-total">
                                            <span class="total-price">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <!-- Order Items Summary -->
                        <div class="order-items-summary p-4 bg-light">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="summary-stats d-flex gap-3">
                                        <div class="stat-item">
                                            <i class="fas fa-box text-primary me-1"></i>
                                            <strong>{{ $order->items->count() }}</strong> sản phẩm
                                        </div>
                                        <div class="stat-item">
                                            <i class="fas fa-weight text-success me-1"></i>
                                            <strong>{{ $order->items->sum('quantity') }}</strong> số lượng
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 text-md-end mt-2 mt-md-0">
                                    <div class="summary-total">
                                        <span class="text-muted me-2">Tạm tính:</span>
                                        <span class="fw-bold fs-5 text-primary">
                                            {{ number_format($order->items->sum(function($item) { return $item->price * $item->quantity; }), 0, ',', '.') }}₫
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Order Summary Section -->
        <div class="col-lg-4">
            <!-- Order Total Card -->
            <div class="order-summary-card mb-4 animate-slide-up">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-gradient-success text-white border-0">
                        <h5 class="mb-0 fw-bold d-flex align-items-center">
                            <i class="fas fa-calculator me-3"></i>Tổng đơn hàng
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="order-totals">
                            @php
                                $subtotal = $order->items->sum(function($item) {
                                    return $item->price * $item->quantity;
                                });
                                $shipping = 0; // Free shipping
                                $tax = 0; // No tax
                                $discount = 0; // No discount for now
                            @endphp
                            
                            <div class="total-row">
                                <span><i class="fas fa-shopping-cart text-primary me-2"></i>Tạm tính:</span>
                                <span>{{ number_format($subtotal, 0, ',', '.') }}₫</span>
                            </div>
                            
                            <div class="total-row">
                                <span><i class="fas fa-truck text-success me-2"></i>Phí vận chuyển:</span>
                                <span class="text-success fw-bold">
                                    @if($shipping == 0)
                                        Miễn phí
                                    @else
                                        {{ number_format($shipping, 0, ',', '.') }}₫
                                    @endif
                                </span>
                            </div>
                            
                            @if($tax > 0)
                            <div class="total-row">
                                <span><i class="fas fa-percent text-warning me-2"></i>Thuế (10%):</span>
                                <span>{{ number_format($tax, 0, ',', '.') }}₫</span>
                            </div>
                            @endif
                            
                            @if($discount > 0)
                            <div class="total-row">
                                <span><i class="fas fa-tag text-danger me-2"></i>Giảm giá:</span>
                                <span class="text-danger">-{{ number_format($discount, 0, ',', '.') }}₫</span>
                            </div>
                            @endif
                            
                            <div class="final-total">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold fs-5">
                                        <i class="fas fa-money-check-alt text-success me-2"></i>Tổng cộng:
                                    </span>
                                    <span class="fw-bold fs-4 text-primary">{{ number_format($order->total_amount, 0, ',', '.') }}₫</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Payment Method Info -->
                        <div class="payment-method-info mt-4 p-3 bg-light rounded-3">
                            <h6 class="fw-bold mb-2">
                                <i class="fas fa-credit-card text-primary me-2"></i>Phương thức thanh toán
                            </h6>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-money-bill-wave text-success me-2"></i>
                                <span class="fw-semibold">Thanh toán khi nhận hàng (COD)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Customer Information Card -->
            <div class="customer-info-card mb-4 animate-slide-up">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-gradient-info text-white border-0">
                        <h5 class="mb-0 fw-bold d-flex align-items-center">
                            <i class="fas fa-user-circle me-3"></i>Thông tin khách hàng
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="customer-details">
                            <div class="detail-item mb-3">
                                <div class="detail-label">
                                    <i class="fas fa-user text-primary me-2"></i>Họ tên
                                </div>
                                <div class="detail-value fw-semibold">{{ $order->customer_name }}</div>
                            </div>
                            
                            <div class="detail-item mb-3">
                                <div class="detail-label">
                                    <i class="fas fa-phone text-success me-2"></i>Số điện thoại
                                </div>
                                <div class="detail-value">
                                    <a href="tel:{{ $order->customer_phone }}" class="text-decoration-none">
                                        {{ $order->customer_phone }}
                                    </a>
                                </div>
                            </div>
                            
                            <div class="detail-item mb-3">
                                <div class="detail-label">
                                    <i class="fas fa-envelope text-warning me-2"></i>Email
                                </div>
                                <div class="detail-value">
                                    <a href="mailto:{{ $order->customer_email }}" class="text-decoration-none">
                                        {{ $order->customer_email }}
                                    </a>
                                </div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-map-marker-alt text-danger me-2"></i>Địa chỉ giao hàng
                                </div>
                                <div class="detail-value">{{ $order->customer_address }}</div>
                            </div>
                        </div>
                        
                        <!-- Customer Actions -->
                        <div class="customer-actions mt-4 pt-3 border-top">
                            <div class="d-flex gap-2">
                                <a href="tel:{{ $order->customer_phone }}" class="btn btn-sm btn-outline-success flex-fill">
                                    <i class="fas fa-phone me-1"></i>Gọi
                                </a>
                                <a href="mailto:{{ $order->customer_email }}" class="btn btn-sm btn-outline-primary flex-fill">
                                    <i class="fas fa-envelope me-1"></i>Email
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Order Actions Card -->
            <div class="order-actions-card animate-slide-up">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-light border-0">
                        <h5 class="mb-0 fw-bold d-flex align-items-center">
                            <i class="fas fa-cogs text-primary me-3"></i>Thao tác đơn hàng
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="action-buttons d-grid gap-3">
                            @if($order->status == 'pending')
                                <button class="btn btn-outline-danger btn-lg cancel-order-btn" data-order-id="{{ $order->id }}">
                                    <i class="fas fa-times-circle me-2"></i>Hủy đơn hàng
                                </button>
                            @endif
                            
                            @if($order->status == 'completed')
                                <button class="btn btn-outline-success btn-lg" data-action="reorder" data-order-id="{{ $order->id }}">
                                    <i class="fas fa-redo-alt me-2"></i>Đặt lại đơn hàng
                                </button>
                            @endif
                            
                            <a href="{{ route('contact.index') }}" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-headset me-2"></i>Liên hệ hỗ trợ
                            </a>
                            
                            <button class="btn btn-outline-secondary btn-lg" onclick="window.print()">
                                <i class="fas fa-print me-2"></i>In đơn hàng
                            </button>
                            
                            <a href="{{ route('products.index') }}" class="btn btn-outline-info btn-lg">
                                <i class="fas fa-shopping-bag me-2"></i>Tiếp tục mua sắm
                            </a>
                        </div>
                        
                        <!-- Order Stats -->
                        <div class="order-stats mt-4 pt-3 border-top">
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="stat-box p-2">
                                        <i class="fas fa-clock text-warning mb-2 d-block"></i>
                                        <small class="text-muted">Thời gian đặt</small>
                                        <div class="fw-bold">{{ $order->created_at->format('H:i') }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-box p-2">
                                        <i class="fas fa-hashtag text-info mb-2 d-block"></i>
                                        <small class="text-muted">Mã đơn hàng</small>
                                        <div class="fw-bold">#{{ $order->id }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Cancel Order Modal -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="cancelOrderModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    Xác nhận hủy đơn hàng
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="fas fa-times-circle text-danger mb-3" style="font-size: 4rem;"></i>
                    <h6 class="fw-bold">Bạn có chắc chắn muốn hủy đơn hàng #{{ $order->id }} không?</h6>
                </div>
                
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Lưu ý:</strong> Việc hủy đơn hàng không thể hoàn tác.
                </div>
                
                <!-- Cancellation Reason -->
                <div class="mb-3">
                    <label for="cancelReason" class="form-label fw-semibold">Lý do hủy đơn hàng (tùy chọn):</label>
                    <select class="form-select" id="cancelReason">
                        <option value="">Chọn lý do hủy...</option>
                        <option value="Đổi ý kiến">Đổi ý kiến</option>
                        <option value="Tìm thấy giá tốt hơn">Tìm thấy giá tốt hơn</option>
                        <option value="Không cần nữa">Không cần nữa</option>
                        <option value="Lý do khác">Lý do khác</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Không hủy
                </button>
                <button type="button" class="btn btn-danger" id="confirmCancelOrder">
                    <i class="fas fa-check me-1"></i>Có, hủy đơn hàng
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 11000;">
    <div id="orderToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="fas fa-bell text-primary me-2"></i>
            <strong class="me-auto">Thông báo</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <!-- Message will be inserted here -->
        </div>
    </div>
</div>

<script>
// Enhanced order actions with animations and feedback
document.addEventListener('DOMContentLoaded', function() {
    // Cancel order functionality
    const cancelBtn = document.querySelector('.cancel-order-btn');
    const cancelModal = new bootstrap.Modal(document.getElementById('cancelOrderModal'));
    const confirmBtn = document.getElementById('confirmCancelOrder');
    const reasonSelect = document.getElementById('cancelReason');
    
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            cancelModal.show();
        });
    }
    
    if (confirmBtn) {
        confirmBtn.addEventListener('click', function() {
            const reason = reasonSelect.value;
            const orderId = {{ json_encode($order->id) }};
            
            // Add loading state
            confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Đang xử lý...';
            confirmBtn.disabled = true;
            
            // Send actual AJAX request to cancel the order
            fetch(`/orders/${orderId}/cancel`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    reason: reason
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Đơn hàng đã được hủy thành công!', 'success');
                    cancelModal.hide();
                    
                    // Redirect to orders list after successful cancellation
                    setTimeout(() => {
                        window.location.href = '{{ route("orders.my") }}';
                    }, 2000);
                } else {
                    showToast(data.message || 'Có lỗi xảy ra khi hủy đơn hàng', 'error');
                    confirmBtn.innerHTML = '<i class="fas fa-check me-1"></i>Có, hủy đơn hàng';
                    confirmBtn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error canceling order:', error);
                showToast('Có lỗi xảy ra. Vui lòng thử lại sau.', 'error');
                confirmBtn.innerHTML = '<i class="fas fa-check me-1"></i>Có, hủy đơn hàng';
                confirmBtn.disabled = false;
            });
        });
    }
    
    // Reorder functionality
    const reorderBtn = document.querySelector('[data-action="reorder"]');
    if (reorderBtn) {
        reorderBtn.addEventListener('click', function() {
            const orderId = this.dataset.orderId;
            
            // Add loading state
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang thêm vào giỏ hàng...';
            this.disabled = true;
            
            // Simulate adding to cart
            setTimeout(() => {
                this.innerHTML = originalText;
                this.disabled = false;
                showToast('Đã thêm tất cả sản phẩm vào giỏ hàng!', 'success');
            }, 2000);
        });
    }
    
    // Animation on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-slide-up');
            }
        });
    }, observerOptions);
    
    // Observe all animatable elements
    document.querySelectorAll('.animate-slide-up').forEach(el => {
        observer.observe(el);
    });
});

function showToast(message, type = 'info') {
    const toast = document.getElementById('orderToast');
    const toastBody = toast.querySelector('.toast-body');
    const toastHeader = toast.querySelector('.toast-header');
    
    // Update toast content
    toastBody.textContent = message;
    
    // Update toast style based on type
    toast.className = 'toast';
    if (type === 'success') {
        toast.classList.add('bg-success', 'text-white');
        toastHeader.querySelector('i').className = 'fas fa-check-circle text-white me-2';
    } else if (type === 'error') {
        toast.classList.add('bg-danger', 'text-white');
        toastHeader.querySelector('i').className = 'fas fa-exclamation-circle text-white me-2';
    } else {
        toast.classList.add('bg-info', 'text-white');
        toastHeader.querySelector('i').className = 'fas fa-info-circle text-white me-2';
    }
    
    // Show toast
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
}
</script>
@endsection