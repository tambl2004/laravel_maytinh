@extends('layouts.customer')

@section('title', 'Liên hệ - Laptop Shop')

@section('content')


<!-- Contact Content -->
<div class="container py-5">
    <div class="row">
        <!-- Contact Form -->
        <div class="col-lg-6 mb-5">
            <div class="contact-form-container">
                <h3 class="form-title">Gửi tin nhắn</h3>
                <p class="form-subtitle">Điền thông tin bên dưới để gửi tin nhắn cho chúng tôi</p>
                
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('contact.send') }}" method="POST" class="contact-form">
                    @csrf
                    
                    <div class="form-group">
                        <label for="name" class="form-label">
                            <i class="fas fa-user me-2"></i>Họ và tên
                        </label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Nhập họ và tên của bạn" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-2"></i>Email
                        </label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Nhập địa chỉ email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="subject" class="form-label">
                            <i class="fas fa-tag me-2"></i>Chủ đề
                        </label>
                        <input type="text" id="subject" name="subject" class="form-control" placeholder="Nhập chủ đề tin nhắn" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="message" class="form-label">
                            <i class="fas fa-comment me-2"></i>Nội dung tin nhắn
                        </label>
                        <textarea id="message" name="message" class="form-control" rows="6" placeholder="Nhập nội dung tin nhắn của bạn" required></textarea>
                    </div>
                    
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane me-2"></i>
                        Gửi tin nhắn
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Contact Info & Map -->
        <div class="col-lg-6">
            <!-- Contact Information -->
            <div class="contact-info-container mb-4">
                <h3 class="info-title">Thông tin liên hệ</h3>
                
                <div class="contact-items">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-details">
                            <h5>Địa chỉ</h5>
                            <p>Trường Đại học Tài nguyên và môi trường Hà Nội</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-details">
                            <h5>Điện thoại</h5>
                            <p>+84 123 456 789</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-details">
                            <h5>Email</h5>
                            <p>info@laptopshop.com</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-details">
                            <h5>Giờ làm việc</h5>
                            <p>Thứ 2 - Thứ 6: 8:00 - 18:00<br>Thứ 7 - Chủ nhật: 9:00 - 17:00</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Google Maps -->
            <div class="map-container">
                <h3 class="map-title">Vị trí của chúng tôi</h3>
                <div class="map-wrapper">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.640930538255!2d105.75986217555872!3d21.04704858060693!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313454c3ce577141%3A0xb1a1ac92701777bc!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBUw6BpIG5ndXnDqm4gdsOgIE3DtGkgdHLGsOG7nW5nIEjDoCBO4buZaQ!5e0!3m2!1svi!2s!4v1757642756639!5m2!1svi!2s" 
                        width="100%" 
                        height="300" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Form validation và UX improvements
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('.contact-form');
        const submitBtn = document.querySelector('.btn-submit');
        
        form.addEventListener('submit', function(e) {
            const originalText = submitBtn.innerHTML;
            
            // Hiển thị trạng thái loading
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang gửi...';
            submitBtn.disabled = true;
            
            // Reset sau 3 giây (trong trường hợp không có response)
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 3000);
        });
        
        // Smooth scroll cho các link nội bộ
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
    });
</script>
@endsection