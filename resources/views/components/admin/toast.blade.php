{{-- Component Toast Notification cho Admin --}}
{{-- Sử dụng: @include('components.admin.toast', ['type' => 'success', 'title' => 'Thành công', 'message' => 'Đã lưu thành công']) --}}

@php
    $type = $type ?? 'info';
    $title = $title ?? '';
    $message = $message ?? '';
    $duration = $duration ?? 5000; // 5 giây
    $position = $position ?? 'top-right';
    
    // Thiết lập màu sắc và icon cho từng loại
    $config = [
        'success' => [
            'bg' => 'linear-gradient(135deg, #10b981 0%, #059669 100%)',
            'icon' => 'fas fa-check-circle',
            'border' => '#10b981',
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

<div class="toast-notification toast-{{ $type }}" 
     data-duration="{{ $duration }}" 
     data-position="{{ $position }}"
     style="display: none;">
    <div class="toast-icon" style="background: {{ $currentConfig['bg'] }}">
        <i class="{{ $currentConfig['icon'] }}"></i>
    </div>
    <div class="toast-content">
        @if($title)
            <div class="toast-title">{{ $title }}</div>
        @endif
        @if($message)
            <div class="toast-message">{{ $message }}</div>
        @endif
    </div>
    <button type="button" class="toast-close" onclick="this.closest('.toast-notification').remove()">
        <i class="fas fa-times"></i>
    </button>
    <div class="toast-progress" style="background: {{ $currentConfig['bg'] }}"></div>
</div>
