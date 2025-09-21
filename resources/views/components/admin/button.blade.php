{{-- Component Button cho Admin --}}
{{-- Sử dụng: @include('components.admin.button', ['type' => 'primary', 'size' => 'sm', 'href' => '#', 'text' => 'Nút bấm']) --}}

@php
    $type = $type ?? 'primary';
    $size = $size ?? '';
    $href = $href ?? null;
    $target = $target ?? null;
    $disabled = $disabled ?? false;
    $text = $text ?? '';
    $classes = 'btn-admin btn-admin-' . $type;
    if($size) {
        $classes .= ' btn-admin-' . $size;
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
