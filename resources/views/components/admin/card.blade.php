{{-- Component Card cho Admin --}}
{{-- Sử dụng: @include('components.admin.card', ['title' => 'Tiêu đề', 'content' => 'Nội dung']) --}}

@php
    $title = $title ?? '';
    $subtitle = $subtitle ?? '';
    $headerActions = $headerActions ?? null;
    $footer = $footer ?? null;
    $content = $content ?? '';
@endphp

<div class="admin-card" {{ $attributes ?? '' }}>
    @if($title || $subtitle || $headerActions)
        <div class="admin-card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    @if($title)
                        <h5 class="admin-card-title">{{ $title }}</h5>
                    @endif
                    @if($subtitle)
                        <small class="text-muted">{{ $subtitle }}</small>
                    @endif
                </div>
                @if($headerActions)
                    <div class="d-flex gap-2">
                        {!! $headerActions !!}
                    </div>
                @endif
            </div>
        </div>
    @endif
    
    <div class="admin-card-body">
        {!! $content !!}
    </div>
    
    @if($footer)
        <div class="admin-card-footer">
            {!! $footer !!}
        </div>
    @endif
</div>
