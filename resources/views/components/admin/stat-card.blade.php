{{-- Component Stat Card cho Admin --}}
{{-- Sử dụng: @include('components.admin.stat-card', ['type' => 'primary', 'value' => '100', 'label' => 'Tổng số']) --}}

@php
    $type = $type ?? 'primary';
    $value = $value ?? '';
    $label = $label ?? '';
    $icon = $icon ?? '';
    $trend = $trend ?? null;
    $trendValue = $trendValue ?? null;
@endphp

<div class="stat-card {{ $type }}" {{ $attributes ?? '' }}>
    @if($icon)
        <div class="stat-icon {{ $type }}">
            <i class="{{ $icon }}"></i>
        </div>
    @endif
    
    <div class="stat-value">{{ $value }}</div>
    <div class="stat-label">{{ $label }}</div>
    
    @if($trend && $trendValue)
        <div class="stat-trend mt-2">
            @if($trend === 'up')
                <small class="text-success">
                    <i class="fas fa-arrow-up"></i> +{{ $trendValue }}%
                </small>
            @elseif($trend === 'down')
                <small class="text-danger">
                    <i class="fas fa-arrow-down"></i> -{{ $trendValue }}%
                </small>
            @else
                <small class="text-muted">
                    <i class="fas fa-minus"></i> {{ $trendValue }}%
                </small>
            @endif
        </div>
    @endif
</div>
