{{-- Component Table cho Admin --}}
{{-- Sử dụng: @include('components.admin.table', ['headers' => ['Tên', 'Email', 'Ngày tạo'], 'content' => '<tr>...</tr>']) --}}

@php
    $headers = $headers ?? [];
    $responsive = $responsive ?? true;
    $striped = $striped ?? true;
    $hover = $hover ?? true;
    $bordered = $bordered ?? false;
    $small = $small ?? false;
    $content = $content ?? '';
    
    $tableClasses = 'table';
    if($striped) $tableClasses .= ' table-striped';
    if($hover) $tableClasses .= ' table-hover';
    if($bordered) $tableClasses .= ' table-bordered';
    if($small) $tableClasses .= ' table-sm';
@endphp

<div class="admin-table" {{ $attributes ?? '' }}>
    <table class="{{ $tableClasses }}">
        @if(!empty($headers))
            <thead>
                <tr>
                    @foreach($headers as $header)
                        <th>{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
        @endif
        <tbody>
            {!! $content !!}
        </tbody>
    </table>
</div>
