@extends('layouts.customer')

@section('title', 'Thanh toán đơn hàng')

@section('content')
<!-- Checkout Hero Section -->
<div class="checkout-hero bg-gradient-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-5 fw-bold mb-3">
                    <i class="fas fa-credit-card me-3"></i>Thanh toán đơn hàng
                </h1>
                <p class="lead mb-0">Hoàn tất đơn hàng của bạn chỉ trong vài bước đơn giản</p>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="checkout-steps">
                    <div class="step-item active">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Giỏ hàng</span>
                    </div>
                    <div class="step-item active">
                        <i class="fas fa-credit-card"></i>
                        <span>Thanh toán</span>
                    </div>
                    <div class="step-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Hoàn thành</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4">
            <i class="fas fa-exclamation-triangle me-2"></i>Vui lòng chọn một địa chỉ giao hàng.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-5">
        <!-- Address Selection Section -->
        <div class="col-lg-7">
            <form action="{{ route('checkout.store') }}" method="POST" class="checkout-form">
                @csrf
                
                <!-- Address Selection -->
                <div class="checkout-section mb-5">
                    <div class="section-header mb-4">
                        <h3 class="fw-bold mb-1">
                            <i class="fas fa-map-marker-alt me-2 text-primary"></i>Địa chỉ giao hàng
                        </h3>
                        <p class="text-muted mb-0">Chọn địa chỉ bạn muốn nhận hàng</p>
                    </div>
                    
                    <div class="address-selection">
                        @if(count($addresses) > 0)
                            @foreach($addresses as $address)
                                <div class="address-card mb-3">
                                    <div class="card border-2 address-option" data-address-id="{{ $address->id }}">
                                        <div class="card-body p-4">
                                            <div class="form-check">
                                                <input class="form-check-input address-radio" type="radio" name="address_id" id="address{{ $address->id }}" value="{{ $address->id }}">
                                                <label class="form-check-label w-100 cursor-pointer" for="address{{ $address->id }}">
                                                    <div class="address-details">
                                                        <div class="d-flex align-items-start justify-content-between">
                                                            <div class="address-info">
                                                                <h5 class="address-name mb-2">
                                                                    <i class="fas fa-user me-2 text-primary"></i>{{ $address->name }}
                                                                </h5>
                                                                <div class="address-contact mb-2">
                                                                    <i class="fas fa-phone me-2 text-muted"></i>
                                                                    <span>{{ $address->phone }}</span>
                                                                </div>
                                                                <div class="address-location">
                                                                    <i class="fas fa-map-marker-alt me-2 text-muted"></i>
                                                                    @if($address->full_address)
                                                                        <span>{{ $address->full_address }}</span>
                                                                    @else
                                                                        <span>{{ $address->address }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="address-badge">
                                                                <span class="badge bg-primary rounded-pill">
                                                                    <i class="fas fa-home"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="no-address-card">
                                <div class="card border-2 bg-opacity-10">
                                    <div class="card-body text-center p-5">
                                        <i class="fas fa-exclamation-triangle text-danger mb-3" style="font-size: 3rem;"></i>
                                        <h5 class="fw-bold mb-3 text-danger">Bạn chưa có địa chỉ giao hàng</h5>
                                        <p class="text-muted mb-4">Vui lòng thêm ít nhất một địa chỉ để có thể tiếp tục thanh toán đơn hàng</p>
                                        <a href="{{ route('addresses.index') }}" class="btn btn-danger">
                                            <i class="fas fa-plus me-2"></i>Thêm địa chỉ ngay
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="address-actions mt-4">
                        <a href="{{ route('addresses.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-cog me-2"></i>Quản lý sổ địa chỉ
                        </a>
                    </div>
                </div>
                
                <!-- Payment Method Section -->
                <div class="checkout-section mb-5">
                    <div class="section-header mb-4">
                        <h3 class="fw-bold mb-1">
                            <i class="fas fa-credit-card me-2 text-primary"></i>Phương thức thanh toán
                        </h3>
                        <p class="text-muted mb-0">Chọn cách thức thanh toán phù hợp</p>
                    </div>
                    
                    <div class="payment-methods">
                        <!-- COD Payment Option -->
                        <div class="payment-option mb-3">
                            <div class="card border-2">
                                <div class="card-body p-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                                        <label class="form-check-label w-100 cursor-pointer" for="cod">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="payment-info">
                                                    <h5 class="mb-1">
                                                        <i class="fas fa-money-bill-wave me-2 text-success"></i>Thanh toán khi nhận hàng (COD)
                                                    </h5>
                                                    <p class="text-muted mb-0 small">Thanh toán bằng tiền mặt khi nhận hàng</p>
                                                </div>
                                                <div class="payment-badge">
                                                    <span class="badge bg-success">Miễn phí</span>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- MoMo Payment Option -->
                        <div class="payment-option mb-3">
                            <div class="card border-2">
                                <div class="card-body p-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="momo" value="momo">
                                        <label class="form-check-label w-100 cursor-pointer" for="momo">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="payment-info">
                                                    <h5 class="mb-1">
                                                        <i class="fas fa-mobile-alt me-2 text-danger"></i>Thanh toán qua MoMo
                                                    </h5>
                                                    <p class="text-muted mb-0 small">Thanh toán nhanh chóng và an toàn qua ví điện tử MoMo</p>
                                                    <p class="text-warning mb-0 small">
                                                        <i class="fas fa-info-circle me-1"></i>Từ {{ number_format(config('services.momo.min_amount', 10000), 0, ',', '.') }}₫ đến {{ number_format(config('services.momo.max_amount', 50000000), 0, ',', '.') }}₫
                                                    </p>
                                                </div>
                                                <div class="payment-badge">
                                                    <img src="https://cdn.haitrieu.com/wp-content/uploads/2022/10/Logo-MoMo-Square.png" alt="MoMo" style="width: 32px; height: 32px;">
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Order Actions -->
                <div class="order-actions">
                    <div class="d-grid gap-3">
                        @if(count($addresses) > 0)
                            <button type="submit" class="btn btn-primary btn-lg order-submit-btn">
                                <i class="fas fa-check-circle me-2"></i>Hoàn tất đặt hàng
                            </button>
                        @else
                            <button type="button" class="btn btn-secondary btn-lg" disabled>
                                <i class="fas fa-exclamation-triangle me-2"></i>Cần thêm địa chỉ giao hàng
                            </button>
                        @endif
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại giỏ hàng
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Order Summary Section -->
        <div class="col-lg-5">
            <div class="order-summary-section">
                <div class="order-summary-card">
                    <div class="card border-0 shadow-lg rounded-3">
                        <div class="card-header bg-gradient-primary text-white border-0 rounded-top">
                            <h4 class="mb-0 fw-bold d-flex align-items-center justify-content-between">
                                <span>
                                    <i class="fas fa-receipt me-2"></i>Đơn hàng của bạn
                                </span>
                                <span class="badge bg-white text-primary rounded-pill">{{ count($cart) }}</span>
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="order-items">
                                @php $total = 0; @endphp
                                @foreach($cart as $id => $details)
                                    @php $itemTotal = $details['price'] * $details['quantity']; $total += $itemTotal; @endphp
                                    <div class="order-item mb-4">
                                        <div class="d-flex align-items-start">
                                            <div class="item-image me-3">
                                                <img src="{{ $details['image'] }}" alt="{{ $details['name'] }}" class="order-item-image">
                                                <span class="quantity-badge">{{ $details['quantity'] }}</span>
                                            </div>
                                            <div class="item-details flex-grow-1">
                                                <h6 class="item-name mb-1">{{ $details['name'] }}</h6>
                                                <div class="item-price-info">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="item-unit-price text-muted small">{{ number_format($details['price'], 0, ',', '.') }}₫ x {{ $details['quantity'] }}</span>
                                                        <span class="item-total-price fw-bold">{{ number_format($itemTotal, 0, ',', '.') }}₫</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <hr class="my-4">
                            
                            <div class="order-totals">
                                <div class="total-row d-flex justify-content-between mb-2">
                                    <span class="text-muted">Tạm tính:</span>
                                    <span class="fw-semibold">{{ number_format($total, 0, ',', '.') }}₫</span>
                                </div>
                                <div class="total-row d-flex justify-content-between mb-2">
                                    <span class="text-muted">Phí vận chuyển:</span>
                                    <span class="fw-semibold text-success">Miễn phí</span>
                                </div>
                                <div class="total-row d-flex justify-content-between mb-3">
                                    <span class="text-muted">Thuế VAT:</span>
                                    <span class="fw-semibold text-success">Đã bao gồm</span>
                                </div>
                                <hr class="my-3">
                                <div class="final-total">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 mb-0 fw-bold">Tổng cộng:</span>
                                        <span class="h4 mb-0 fw-bold text-primary">{{ number_format($total, 0, ',', '.') }}₫</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Security Notice -->
                        <div class="card-footer bg-light border-0 rounded-bottom">
                            <div class="security-notice text-center">
                                <small class="text-muted">
                                    <i class="fas fa-shield-alt text-success me-1"></i>
                                    Thông tin của bạn được bảo mật an toàn
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Promotion Banner -->
                <div class="promotion-banner mt-4">
                    <div class="card border-0 bg-gradient-warning text-white rounded-3">
                        <div class="card-body p-3">
                            <div class="text-center">
                                <h6 class="fw-bold mb-1">
                                    <i class="fas fa-gift me-2"></i>Ưu đãi đặc biệt
                                </h6>
                                <p class="small mb-0">Miễn phí vận chuyển toàn quốc cho đơn hàng từ 500.000₫</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for address selection -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle address card selection
    const addressCards = document.querySelectorAll('.address-option');
    const addressRadios = document.querySelectorAll('.address-radio');
    
    addressCards.forEach(card => {
        card.addEventListener('click', function() {
            const addressId = this.dataset.addressId;
            const radio = document.getElementById('address' + addressId);
            
            // Uncheck all radios and remove active class
            addressRadios.forEach(r => r.checked = false);
            addressCards.forEach(c => c.classList.remove('border-primary', 'bg-primary', 'bg-opacity-10'));
            
            // Check the clicked radio and add active class
            radio.checked = true;
            this.classList.add('border-primary', 'bg-primary', 'bg-opacity-10');
        });
    });
    
    // Handle radio change events
    addressRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            addressCards.forEach(c => c.classList.remove('border-primary', 'bg-primary', 'bg-opacity-10'));
            if (this.checked) {
                const card = document.querySelector('[data-address-id="' + this.value + '"]');
                if (card) {
                    card.classList.add('border-primary', 'bg-primary', 'bg-opacity-10');
                }
            }
        });
    });
    
    // Check MoMo amount requirements
    const totalAmount = {{ $total }};
    const momoMinAmount = {{ config('services.momo.min_amount', 10000) }};
    const momoMaxAmount = {{ config('services.momo.max_amount', 50000000) }};
    const momoRadio = document.getElementById('momo');
    const momoCard = momoRadio.closest('.payment-option');
    
    if (totalAmount < momoMinAmount || totalAmount > momoMaxAmount) {
        // Disable MoMo option for amounts outside range
        momoRadio.disabled = true;
        momoCard.style.opacity = '0.6';
        momoCard.style.pointerEvents = 'none';
        
        // Add warning text
        const warningText = momoCard.querySelector('.payment-info');
        if (warningText && !warningText.querySelector('.amount-warning')) {
            const warning = document.createElement('p');
            warning.className = 'amount-warning text-danger mb-0 small';
            if (totalAmount < momoMinAmount) {
                warning.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>Đơn hàng dưới mức tối thiểu';
            } else {
                warning.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>Đơn hàng vượt mức tối đa';
            }
            warningText.appendChild(warning);
        }
    }
    
    // Form submission with loading state and MoMo payment handling
    const submitBtn = document.querySelector('.order-submit-btn');
    const checkoutForm = document.querySelector('.checkout-form');
    
    if (checkoutForm && submitBtn) {
        checkoutForm.addEventListener('submit', function(e) {
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked')?.value;
            
            if (paymentMethod === 'momo') {
                e.preventDefault();
                handleMoMoPayment();
            } else {
                // Regular COD submission
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...';
            }
        });
    }
    
    // Handle MoMo payment process
    async function handleMoMoPayment() {
        try {
            // Show loading state
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang tạo đơn hàng...';
            
            // First create the order
            const formData = new FormData(checkoutForm);
            
            const orderResponse = await fetch('{{ route("checkout.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            });
            
            // Check if response is ok
            if (!orderResponse.ok) {
                const errorText = await orderResponse.text();
                console.error('Order creation failed:', errorText);
                throw new Error(`Không thể tạo đơn hàng (${orderResponse.status})`);
            }
            
            // Parse JSON response
            let orderResult;
            try {
                orderResult = await orderResponse.json();
            } catch (parseError) {
                console.error('Failed to parse order response as JSON:', parseError);
                const responseText = await orderResponse.text();
                console.error('Response text:', responseText);
                throw new Error('Phản hồi từ server không hợp lệ');
            }
            
            if (!orderResult.success) {
                throw new Error(orderResult.message || 'Có lỗi xảy ra khi tạo đơn hàng');
            }
            
            // Update button text
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang chuyển đến MoMo...';
            
            // Create MoMo payment
            const momoResponse = await fetch('{{ route("payment.momo.create") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    order_id: orderResult.order_id,
                    return_type: 'json'
                })
            });
            
            if (!momoResponse.ok) {
                const errorText = await momoResponse.text();
                console.error('MoMo payment creation failed:', errorText);
                throw new Error(`Không thể kết nối với MoMo (${momoResponse.status})`);
            }
            
            // Parse MoMo response
            let momoResult;
            try {
                momoResult = await momoResponse.json();
            } catch (parseError) {
                console.error('Failed to parse MoMo response as JSON:', parseError);
                const responseText = await momoResponse.text();
                console.error('MoMo Response text:', responseText);
                throw new Error('Phản hồi từ MoMo không hợp lệ');
            }
            
            if (momoResult.success && momoResult.payUrl) {
                // Mở trang MoMo ở tab mới để tránh chặn UI và bắt đầu polling trạng thái
                const paymentWindow = window.open(momoResult.payUrl, '_blank');

                // Hiển thị trạng thái chờ trên nút
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang chờ bạn thanh toán...';

                // Polling trạng thái đơn hàng mỗi 3s
                const orderId = orderResult.order_id;
                let elapsed = 0; // theo dõi thời gian chờ để timeout hợp lý
                const pollInterval = setInterval(async () => {
                    try {
                        const statusResp = await fetch('{{ route("payment.momo.status") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ order_id: orderId })
                        });

                        if (statusResp.ok) {
                            const statusJson = await statusResp.json();
                            const paymentStatus = statusJson?.data?.payment_status;
                            if (paymentStatus === 'paid') {
                                clearInterval(pollInterval);
                                // Đóng tab MoMo nếu còn mở
                                try { if (paymentWindow && !paymentWindow.closed) paymentWindow.close(); } catch (_) {}
                                window.location.href = '{{ url('/my-orders') }}' + '/' + statusJson.data.order_id;
                                return;
                            }
                            if (paymentStatus === 'failed' || statusJson?.success === false) {
                                clearInterval(pollInterval);
                                alert('Thanh toán không thành công. Vui lòng thử lại hoặc chọn phương thức khác.');
                                submitBtn.classList.remove('loading');
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i>Hoàn tất đặt hàng';
                                return;
                            }
                        }
                    } catch (e) {
                        // Bỏ qua lỗi tạm thời trong quá trình polling
                        console.warn('Polling error', e);
                    }

                    // Timeout sau 10 phút để tránh treo vô hạn
                    elapsed += 3000;
                    if (elapsed >= 10 * 60 * 1000) {
                        clearInterval(pollInterval);
                        alert('Chưa nhận được kết quả thanh toán. Bạn có thể kiểm tra lại trong lịch sử đơn hàng.');
                        submitBtn.classList.remove('loading');
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i>Hoàn tất đặt hàng';
                    }
                }, 3000);
            } else {
                // Check if it's a minimum amount error
                if (momoResult.message && momoResult.message.includes('nhỏ hơn mức tối thiểu')) {
                    // Show user-friendly error and suggest COD
                    alert('Số tiền đơn hàng của bạn không phù hợp để thanh toán qua MoMo (từ {{ number_format(config("services.momo.min_amount", 10000), 0, ",", ".") }}₫ đến {{ number_format(config("services.momo.max_amount", 50000000), 0, ",", ".") }}₫). Vui lòng chọn thanh toán khi nhận hàng (COD).');
                    
                    // Auto-select COD payment method
                    const codRadio = document.getElementById('cod');
                    if (codRadio) {
                        codRadio.checked = true;
                    }
                    
                    // Reset button state
                    submitBtn.classList.remove('loading');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i>Hoàn tất đặt hàng';
                    return;
                }
                
                throw new Error(momoResult.message || 'Không thể tạo liên kết thanh toán MoMo');
            }
            
        } catch (error) {
            console.error('MoMo Payment Error:', error);
            alert('Lỗi thanh toán MoMo: ' + error.message);
            
            // Reset button state
            submitBtn.classList.remove('loading');
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i>Hoàn tất đặt hàng';
        }
    }
});
</script>
@endsection