{{-- Component Badge cho Admin --}}
{{-- Sử dụng: @include('components.admin.badge', ['type' => 'success', 'text' => 'Hoàn thành']) --}}

@php
    $type = $type ?? 'primary';
    $text = $text ?? '';
    $size = $size ?? '';
    $pill = $pill ?? false;
    
    $classes = 'badge-admin';
    
    // Xử lý các loại badge đặc biệt
    if(in_array($type, ['pending', 'processing', 'completed', 'cancelled'])) {
        $classes .= ' badge-' . $type;
    } else {
        $classes .= ' bg-' . $type;
    }
    
    if($size) {
        $classes .= ' badge-' . $size;
    }
    
    if($pill) {
        $classes .= ' rounded-pill';
    }
@endphp

<span class="{{ $classes }}" {{ $attributes ?? '' }}>
    {{ $text }}
</span>
