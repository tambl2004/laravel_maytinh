@extends('layouts.admin.app')

@section('title', 'Quản lý tin tức')
@section('page-title', 'Quản lý tin tức')
@section('page-subtitle', 'Thêm, sửa và quản lý các bài viết tin tức')

@section('content')
<!-- Header Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-1">Tin tức</h2>
        <p class="text-muted mb-0">Quản lý và cập nhật các bài viết tin tức</p>
    </div>
    <a href="{{ route('admin.news.create') }}" class="btn btn-admin-primary">
        <i class="fas fa-plus me-2"></i>Thêm tin tức mới
    </a>
</div>

{{-- Toast notifications sẽ được hiển thị tự động từ layout --}}

<!-- Stats Cards -->
<div class="stats-grid">
    @include('components.admin.stat-card', [
        'type' => 'primary',
        'value' => $news->total(),
        'label' => 'Tổng tin tức',
        'icon' => 'fas fa-newspaper'
    ])
    
    @include('components.admin.stat-card', [
        'type' => 'success',
        'value' => $news->where('is_published', true)->count(),
        'label' => 'Đã xuất bản',
        'icon' => 'fas fa-check-circle'
    ])
    
    @include('components.admin.stat-card', [
        'type' => 'warning',
        'value' => $news->where('is_featured', true)->count(),
        'label' => 'Tin nổi bật',
        'icon' => 'fas fa-star'
    ])
    
    @include('components.admin.stat-card', [
        'type' => 'danger',
        'value' => $news->sum('views'),
        'label' => 'Tổng lượt xem',
        'icon' => 'fas fa-eye'
    ])
</div>

<!-- News Table -->
@php
    $tableContent = '';
    if($news->count() > 0) {
        foreach($news as $article) {
            $tableContent .= '<tr>';
            $tableContent .= '<td>';
            if($article->featured_image) {
                $tableContent .= '<img src="' . $article->featured_image . '" alt="' . $article->title . '" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">';
            } else {
                $tableContent .= '<div class="bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;"><i class="fas fa-image text-muted"></i></div>';
            }
            $tableContent .= '</td>';
            $tableContent .= '<td style="
    width: 300px;><div class="fw-bold">' . Str::limit($article->title, 50) . '</div>';
            if($article->excerpt) {
                $tableContent .= '<small class="text-muted">' . Str::limit($article->excerpt, 80) . '</small>';
            }
            $tableContent .= '</td>';
            $tableContent .= '<td>' . $article->author . '</td>';
            $tableContent .= '<td>';
            if($article->is_published) {
                $tableContent .= '<span class="badge-admin badge-completed">Đã xuất bản</span>';
            } else {
                $tableContent .= '<span class="badge-admin badge-pending">Bản nháp</span>';
            }
            $tableContent .= '</td>';
            $tableContent .= '<td>';
            if($article->is_featured) {
                $tableContent .= '<span class="badge-admin badge-processing"><i class="fas fa-star me-1"></i>Nổi bật</span>';
            } else {
                $tableContent .= '<span class="badge-admin badge-pending">Thường</span>';
            }
            $tableContent .= '</td>';
            $tableContent .= '<td><i class="fas fa-eye me-1"></i>' . $article->views . '</td>';
            $tableContent .= '<td>' . $article->created_at->format('d/m/Y H:i') . '</td>';
            $tableContent .= '<td>';
            $tableContent .= '<div class="btn-group" role="group">';
            $tableContent .= '<a href="' . route('news.show', $article->slug) . '" class="btn-admin btn-admin-outline btn-admin-sm" target="_blank" title="Xem tin tức"><i class="fas fa-eye"></i></a>';
            $tableContent .= '<a href="' . route('admin.news.edit', $article) . '" class="btn-admin btn-admin-outline btn-admin-sm" title="Chỉnh sửa"><i class="fas fa-edit"></i></a>';
            $tableContent .= '<form action="' . route('admin.news.destroy', $article) . '" method="POST" class="d-inline" onsubmit="return confirm(\'Bạn có chắc chắn muốn xóa tin tức này?\')">';
            $tableContent .= csrf_field();
            $tableContent .= method_field('DELETE');
            $tableContent .= '<button type="submit" class="btn-admin btn-admin-danger btn-admin-sm" title="Xóa tin tức"><i class="fas fa-trash"></i></button>';
            $tableContent .= '</form>';
            $tableContent .= '</div>';
            $tableContent .= '</td>';
            $tableContent .= '</tr>';
        }
    } else {
        $tableContent = '<tr><td colspan="8" class="text-center py-5"><div class="text-muted"><i class="fas fa-newspaper fa-3x mb-3"></i><h4>Chưa có tin tức nào</h4><p class="mb-4">Bắt đầu tạo tin tức đầu tiên của bạn!</p><a href="' . route('admin.news.create') . '" class="btn-admin btn-admin-primary"><i class="fas fa-plus me-2"></i>Thêm tin tức mới</a></div></td></tr>';
    }
@endphp

@include('components.admin.card', [
    'title' => 'Danh sách tin tức',
    'subtitle' => 'Quản lý các bài viết tin tức',
    'headerActions' => '<i class="fas fa-list"></i>',
    'content' => view('components.admin.table', [
        'headers' => ['Hình ảnh', 'Tiêu đề', 'Tác giả', 'Trạng thái', 'Nổi bật', 'Lượt xem', 'Ngày tạo', 'Thao tác'],
        'content' => $tableContent
    ])->render() . ($news->count() > 0 ? '<div class="d-flex justify-content-center mt-4">' . $news->links('vendor.pagination.bootstrap-5') . '</div>' : '')
])
@endsection
