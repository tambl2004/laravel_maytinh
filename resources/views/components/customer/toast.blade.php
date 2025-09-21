{{-- Component Toast Notification cho Customer --}}
{{-- Sử dụng: @include('components.customer.toast', ['type' => 'success', 'title' => 'Thành công', 'message' => 'Đã thêm vào giỏ hàng']) --}}

@php
    $type = $type ?? 'info';
    $title = $title ?? '';
    $message = $message ?? '';
    $duration = $duration ?? 4000; // 4 giây cho customer
    
    // Thiết lập màu sắc và icon cho từng loại - thiết kế thân thiện hơn
    $config = [
        'success' => [
            'bg' => 'linear-gradient(135deg, #22c55e 0%, #16a34a 100%)',
            'icon' => 'fas fa-check-circle',
            'border' => '#22c55e',
            'text' => '#ffffff'
        ],
        'error' => [
            'bg' => 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)',
            'icon' => 'fas fa-times-circle',
            'border' => '#ef4444',
            'text' => '#ffffff'
        ],
        'danger' => [
            'bg' => 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)',
            'icon' => 'fas fa-exclamation-triangle',
            'border' => '#ef4444',
            'text' => '#ffffff'
        ],
        'warning' => [
            'bg' => 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)',
            'icon' => 'fas fa-exclamation-triangle',
            'border' => '#f59e0b',
            'text' => '#ffffff'
        ],
        'info' => [
            'bg' => 'linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)',
            'icon' => 'fas fa-info-circle',
            'border' => '#3b82f6',
            'text' => '#ffffff'
        ]
    ];
    
    $currentConfig = $config[$type] ?? $config['info'];
@endphp

<div class="customer-toast customer-toast-{{ $type }}" 
     data-duration="{{ $duration }}" 
     data-position="top-right"
     style="display: none;">
    <div class="customer-toast-icon" style="background: {{ $currentConfig['bg'] }}">
        <i class="{{ $currentConfig['icon'] }}"></i>
    </div>
    <div class="customer-toast-content">
        @if($title)
            <div class="customer-toast-title">{{ $title }}</div>
        @endif
        @if($message)
            <div class="customer-toast-message">{{ $message }}</div>
        @endif
    </div>
    <button type="button" class="customer-toast-close" onclick="this.closest('.customer-toast').remove()">
        <i class="fas fa-times"></i>
    </button>
    <div class="customer-toast-progress" style="background: {{ $currentConfig['bg'] }}"></div>
</div>
