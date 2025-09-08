@extends('layouts.customer')

@section('title', 'Đơn hàng của tôi - Balo Shop')

@section('content')
<div class="container my-5">
    <!-- Header Section -->
    <div class="page-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-5 fw-bold mb-2">
                    <i class="fas fa-box text-primary me-3"></i>Đơn hàng của tôi
                </h1>
                <p class="lead text-muted mb-0">Theo dõi tình trạng đơn hàng và lịch sử mua hàng của bạn</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-shopping-bag me-2"></i>Tiếp tục mua sắm
                </a>
            </div>
        </div>
    </div>

    <!-- Orders Filter -->
    <div class="orders-filter mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form method="GET" action="{{ route('orders.my') }}" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Trạng thái</label>
                        <select class="form-select" name="status">
                            <option value="">Tất cả trạng thái</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Từ ngày</label>
                        <input type="date" class="form-control" name="from_date" value="{{ request('from_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Đến ngày</label>
                        <input type="date" class="form-control" name="to_date" value="{{ request('to_date') }}">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-2"></i>Lọc
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Orders List -->
    @if($orders->isEmpty())
        <div class="empty-orders text-center py-5">
            <div class="empty-state-illustration mb-4">
                <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
            </div>
            <h3 class="text-muted mb-3">Chưa có đơn hàng nào</h3>
            <p class="text-muted mb-4">Bạn chưa thực hiện đơn hàng nào. Hãy khám phá các sản phẩm tuyệt vời của chúng tôi!</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg px-5">
                <i class="fas fa-shopping-bag me-2"></i>Bắt đầu mua sắm
            </a>
        </div>
    @else
        <div class="orders-list">
            @foreach($orders as $order)
                <div class="order-card mb-4" data-order-id="{{ $order->id }}">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light border-0 py-3">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h5 class="mb-0 fw-bold">
                                        <i class="fas fa-receipt text-primary me-2"></i>
                                        Đơn hàng #{{ $order->id }}
                                    </h5>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        Đặt ngày: {{ $order->created_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <span class="order-status badge fs-6 px-3 py-2
                                        @if($order->status == 'pending') bg-warning text-dark
                                        @elseif($order->status == 'processing') bg-info text-dark
                                        @elseif($order->status == 'completed') bg-success
                                        @elseif($order->status == 'cancelled') bg-danger
                                        @else bg-secondary
                                        @endif">
                                        @if($order->status == 'pending')
                                            <i class="fas fa-clock me-1"></i>Chờ xử lý
                                        @elseif($order->status == 'processing')
                                            <i class="fas fa-cog fa-spin me-1"></i>Đang xử lý
                                        @elseif($order->status == 'completed')
                                            <i class="fas fa-check-circle me-1"></i>Hoàn thành
                                        @elseif($order->status == 'cancelled')
                                            <i class="fas fa-times-circle me-1"></i>Đã hủy
                                        @else
                                            {{ ucfirst($order->status) }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <div class="order-summary">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-box text-muted me-2"></i>
                                            <span class="text-muted">Số lượng:</span>
                                            <strong class="ms-2">{{ $order->items_count }} sản phẩm</strong>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-money-bill-wave text-success me-2"></i>
                                            <span class="text-muted">Tổng tiền:</span>
                                            <strong class="ms-2 text-primary h6 mb-0">{{ number_format($order->total_amount, 0, ',', '.') }}₫</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="order-progress">
                                        <div class="progress-steps">
                                            <div class="step {{ $order->status == 'pending' || $order->status == 'processing' || $order->status == 'completed' ? 'active' : '' }}">
                                                <div class="step-icon">
                                                    <i class="fas fa-shopping-cart"></i>
                                                </div>
                                                <span class="step-label">Đặt hàng</span>
                                            </div>
                                            <div class="step {{ $order->status == 'processing' || $order->status == 'completed' ? 'active' : '' }}">
                                                <div class="step-icon">
                                                    <i class="fas fa-cog"></i>
                                                </div>
                                                <span class="step-label">Xử lý</span>
                                            </div>
                                            <div class="step {{ $order->status == 'completed' ? 'active' : '' }}">
                                                <div class="step-icon">
                                                    <i class="fas fa-check"></i>
                                                </div>
                                                <span class="step-label">Hoàn thành</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 text-md-end">
                                    <div class="order-actions">
                                        <a href="{{ route('orders.show', $order) }}" class="btn btn-primary btn-sm mb-2 w-100">
                                            <i class="fas fa-eye me-1"></i>Xem chi tiết
                                        </a>
                                        @if($order->status == 'completed')
                                            <button class="btn btn-outline-success btn-sm w-100" data-action="reorder" data-order-id="{{ $order->id }}">
                                                <i class="fas fa-redo me-1"></i>Mua lại
                                            </button>
                                        @elseif($order->status == 'pending')
                                            <button type="button" 
                                                    class="btn btn-outline-danger btn-sm w-100 cancel-order-btn" 
                                                    data-order-id="{{ $order->id }}"
                                                    title="Nhấp để hủy đơn hàng"
                                                    style="cursor: pointer;"
                                                    onclick="alert('Button clicked! Order ID: {{ $order->id }}'); return false;">
                                                <i class="fas fa-times me-1"></i>Hủy đơn
                                            </button>
                                            <!-- Debug: Test if button is visible and clickable -->
                                            <small class="text-muted d-block mt-1">Order ID: {{ $order->id }} | Status: {{ $order->status }}</small>
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
        @if(method_exists($orders, 'links'))
            <div class="d-flex justify-content-center mt-4">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        @endif
    @endif
</div>

<!-- Cancel Order Modal -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    Xác nhận hủy đơn hàng
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn hủy đơn hàng này không?</p>
                <p class="text-muted small">Lưu ý: Việc hủy đơn hàng không thể hoàn tác.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Không</button>
                <button type="button" class="btn btn-danger" id="confirmCancelOrder">
                    <i class="fas fa-times me-1"></i>Có, hủy đơn hàng
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let orderToCancel = null;
    
    // Debug function
    function debugLog(message, data = null) {
        console.log('Order Cancel Debug:', message, data);
    }
    
    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        debugLog('DOM loaded, setting up cancel order functionality');
        
        // Check if cancel buttons exist
        const cancelButtons = document.querySelectorAll('.cancel-order-btn');
        debugLog('Found cancel buttons:', cancelButtons.length);
        
        // Method 1: Event delegation (primary)
        document.addEventListener('click', function(e) {
            debugLog('Click detected on:', e.target);
            
            // Check if clicked element or its parent has cancel-order-btn class
            const cancelBtn = e.target.closest('.cancel-order-btn');
            if (cancelBtn) {
                e.preventDefault();
                e.stopPropagation();
                
                const orderId = cancelBtn.getAttribute('data-order-id');
                debugLog('Cancel button clicked for order:', orderId);
                
                if (orderId) {
                    cancelOrder(orderId);
                } else {
                    debugLog('Error: No order ID found on button');
                }
            }
        });
        
        // Method 2: Direct event listeners (backup)
        cancelButtons.forEach(function(button, index) {
            debugLog('Setting up direct listener for button:', index);
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const orderId = this.getAttribute('data-order-id');
                debugLog('Direct click - Order ID:', orderId);
                
                if (orderId) {
                    cancelOrder(orderId);
                }
            });
        });
    });
    
    function cancelOrder(orderId) {
        debugLog('cancelOrder function called with ID:', orderId);
        
        orderToCancel = orderId;
        
        try {
            const modalElement = document.getElementById('cancelOrderModal');
            if (modalElement) {
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
                debugLog('Modal shown successfully');
            } else {
                debugLog('Error: Modal element not found');
                alert('Lỗi: Không tìm thấy modal xác nhận. Vui lòng tải lại trang.');
            }
        } catch (error) {
            debugLog('Error showing modal:', error);
            alert('Lỗi hiển thị modal: ' + error.message);
        }
    }
    
    // Confirm cancel order
    document.addEventListener('DOMContentLoaded', function() {
        const confirmButton = document.getElementById('confirmCancelOrder');
        if (confirmButton) {
            confirmButton.addEventListener('click', function() {
                debugLog('Confirm cancel button clicked, orderToCancel:', orderToCancel);
                
                if (orderToCancel) {
                    // Show loading state
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Đang hủy...';
                    this.disabled = true;
                    
                    fetch(`/orders/${orderToCancel}/cancel`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        debugLog('Cancel response status:', response.status);
                        return response.json();
                    })
                    .then(data => {
                        debugLog('Cancel response data:', data);
                        
                        if (data.success) {
                            // Update the order status in the UI
                            const orderCard = document.querySelector(`[data-order-id="${orderToCancel}"]`);
                            if (orderCard) {
                                // Add cancelled class to the entire order card
                                orderCard.classList.add('cancelled');
                                
                                const statusBadge = orderCard.querySelector('.order-status');
                                statusBadge.className = 'order-status badge fs-6 px-3 py-2 bg-danger';
                                statusBadge.innerHTML = '<i class="fas fa-times-circle me-1"></i>Đã hủy';
                                
                                // Update progress steps to show cancelled state
                                const progressSteps = orderCard.querySelectorAll('.step');
                                progressSteps.forEach(step => {
                                    step.classList.remove('active');
                                    const stepIcon = step.querySelector('.step-icon');
                                    stepIcon.style.background = '#e5e7eb';
                                    stepIcon.style.color = '#9ca3af';
                                });
                                
                                // Remove cancel button and replace with cancelled message
                                const cancelBtn = orderCard.querySelector('.cancel-order-btn');
                                if (cancelBtn) {
                                    cancelBtn.outerHTML = '<div class="btn btn-secondary btn-sm w-100" disabled><i class="fas fa-ban me-1"></i>Đã hủy</div>';
                                }
                            }
                            
                            // Show success message
                            showToast('success', 'Đơn hàng đã được hủy thành công!');
                        } else {
                            showToast('error', data.message || 'Có lỗi xảy ra khi hủy đơn hàng. Vui lòng thử lại.');
                        }
                    })
                    .catch(error => {
                        debugLog('Cancel error:', error);
                        showToast('error', 'Có lỗi xảy ra. Vui lòng thử lại sau.');
                    })
                    .finally(() => {
                        // Reset button
                        this.innerHTML = originalText;
                        this.disabled = false;
                        
                        // Close modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('cancelOrderModal'));
                        if (modal) {
                            modal.hide();
                        }
                        orderToCancel = null;
                    });
                } else {
                    debugLog('Error: No order to cancel');
                }
            });
        } else {
            debugLog('Error: Confirm button not found');
        }
    });
    
    // Filter form auto-submit
    document.querySelectorAll('.orders-filter select, .orders-filter input[type="date"]').forEach(input => {
        input.addEventListener('change', function() {
            this.form.submit();
        });
    });
    
    // Order cards animation
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Animate order cards on load
    document.querySelectorAll('.order-card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'all 0.6s ease';
        card.style.transitionDelay = `${index * 0.1}s`;
        
        observer.observe(card);
    });
    
    // Reorder functionality
    document.querySelectorAll('[data-action="reorder"]').forEach(btn => {
        btn.addEventListener('click', function() {
            const orderId = this.getAttribute('data-order-id');
            
            // Show loading state
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Đang xử lý...';
            this.disabled = true;
            
            // Make request to reorder
            fetch(`/orders/${orderId}/reorder`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
                    
                    // Update cart count
                    const cartBadge = document.querySelector('.nav-link .badge');
                    if (cartBadge && data.cartCount) {
                        cartBadge.textContent = data.cartCount;
                    }
                } else {
                    showToast('error', data.message || 'Có lỗi xảy ra. Vui lòng thử lại.');
                }
            })
            .catch(error => {
                showToast('error', 'Có lỗi xảy ra. Vui lòng thử lại sau.');
            })
            .finally(() => {
                // Reset button
                this.innerHTML = originalText;
                this.disabled = false;
            });
        });
    });
    
    // Toast notification helper
    function showToast(type, message) {
        const toast = document.createElement('div');
        toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed`;
        toast.style.top = '20px';
        toast.style.right = '20px';
        toast.style.zIndex = '9999';
        toast.style.minWidth = '300px';
        toast.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close float-end" onclick="this.parentElement.remove()"></button>
        `;
        
        document.body.appendChild(toast);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (toast.parentElement) {
                toast.remove();
            }
        }, 5000);
    }
</script>