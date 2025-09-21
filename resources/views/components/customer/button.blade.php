{{-- Component Button cho Customer --}}
{{-- Sử dụng: @include('components.customer.button', ['type' => 'primary', 'size' => 'sm', 'href' => '#', 'text' => 'Nút bấm']) --}}

@php
    $type = $type ?? 'primary';
    $size = $size ?? '';
    $href = $href ?? null;
    $target = $target ?? null;
    $disabled = $disabled ?? false;
    $text = $text ?? '';
    $classes = 'btn-customer btn-customer-' . $type;
    if($size) {
        $classes .= ' btn-customer-' . $size;
    }
    if($disabled) {
        $classes .= ' disabled';
    }
@endphp

@if($href)
    <a href="{{ $href }}" 
       class="{{ $classes }}" 
       @if($target) target="{{ $target }}" @endif
       @if($disabled) aria-disabled="true" @endif
       {{ $attributes ?? '' }}>
        {!! $text !!}
    </a>
@else
    <button type="button" 
            class="{{ $classes }}" 
            @if($disabled) disabled @endif
            {{ $attributes ?? '' }}>
        {!! $text !!}
    </button>
@endif
