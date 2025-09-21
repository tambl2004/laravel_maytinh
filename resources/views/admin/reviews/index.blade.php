@extends('layouts.admin.app')

@section('title', 'Quản lý đánh giá')
@section('page-title', 'Quản lý đánh giá')
@section('page-subtitle', 'Duyệt và quản lý các đánh giá sản phẩm')

@section('content')
<!-- Header Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-1">Đánh giá sản phẩm</h2>
        <p class="text-muted mb-0">Duyệt và quản lý các đánh giá từ khách hàng</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.reviews.statistics') }}" class="btn btn-admin-outline">
            <i class="fas fa-chart-bar me-2"></i>Thống kê
        </a>
    </div>
</div>

<!-- Filters -->
@include('components.admin.card', [
    'title' => 'Bộ lọc',
    'content' => '
    <form method="GET" action="' . route('admin.reviews.index') . '" class="row g-3">
        <div class="col-md-3">
            <label class="form-label">Trạng thái</label>
            <select name="status" class="form-select">
                <option value="">Tất cả</option>
                <option value="approved" ' . (request('status') == 'approved' ? 'selected' : '') . '>Đã duyệt</option>
                <option value="pending" ' . (request('status') == 'pending' ? 'selected' : '') . '>Chờ duyệt</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Số sao</label>
            <select name="rating" class="form-select">
                <option value="">Tất cả</option>
                ' . implode('', array_map(function($i) {
                    return '<option value="' . $i . '" ' . (request('rating') == $i ? 'selected' : '') . '>' . $i . ' sao</option>';
                }, range(5, 1))) . '
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Tìm kiếm</label>
            <input type="text" name="search" class="form-control" 
                   placeholder="Tên sản phẩm hoặc khách hàng..." 
                   value="' . request('search') . '">
        </div>
        <div class="col-md-2">
            <label class="form-label">&nbsp;</label>
            <div class="d-grid">
                <button type="submit" class="btn-admin btn-admin-primary">
                    <i class="fas fa-search me-1"></i>Lọc
                </button>
            </div>
        </div>
    </form>'
])

<!-- Reviews Table -->
@php
    $tableContent = '';
    if($reviews->count() > 0) {
        foreach($reviews as $review) {
            $tableContent .= '<tr>';
            $tableContent .= '<td>';
            $tableContent .= '<div class="d-flex align-items-center">';
            $tableContent .= '<div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px; font-size: 12px;">';
            $tableContent .= strtoupper(substr($review->user->name, 0, 1));
            $tableContent .= '</div>';
            $tableContent .= '<div>';
            $tableContent .= '<div class="fw-semibold">' . $review->user->name . '</div>';
            $tableContent .= '<small class="text-muted">' . $review->user->email . '</small>';
            $tableContent .= '</div>';
            $tableContent .= '</div>';
            $tableContent .= '</td>';
            $tableContent .= '<td>';
            $tableContent .= '<div class="d-flex align-items-center">';
            $tableContent .= '<img src="' . $review->product->image . '" alt="' . $review->product->name . '" class="me-2 rounded" style="width: 40px; height: 40px; object-fit: cover;">';
            $tableContent .= '<div>';
            $tableContent .= '<div class="fw-semibold">' . Str::limit($review->product->name, 30) . '</div>';
            $tableContent .= '<small class="text-muted">' . number_format($review->product->price, 0, ',', '.') . '₫</small>';
            $tableContent .= '</div>';
            $tableContent .= '</div>';
            $tableContent .= '</td>';
            $tableContent .= '<td>';
            $tableContent .= '<div class="d-flex align-items-center">';
            for($i = 1; $i <= 5; $i++) {
                $starClass = $i <= $review->rating ? 'text-warning' : 'text-muted';
                $tableContent .= '<i class="fas fa-star ' . $starClass . ' small"></i>';
            }
            $tableContent .= '<span class="ms-2 fw-semibold">' . $review->rating . '/5</span>';
            $tableContent .= '</div>';
            $tableContent .= '</td>';
            $tableContent .= '<td>';
            if($review->comment) {
                $tableContent .= '<span class="text-truncate d-inline-block" style="max-width: 200px;" title="' . $review->comment . '">';
                $tableContent .= Str::limit($review->comment, 50);
                $tableContent .= '</span>';
            } else {
                $tableContent .= '<em class="text-muted">Không có bình luận</em>';
            }
            $tableContent .= '</td>';
            $tableContent .= '<td>';
            if($review->is_approved) {
                $tableContent .= '<span class="badge-admin badge-completed">Đã duyệt</span>';
            } else {
                $tableContent .= '<span class="badge-admin badge-pending">Chờ duyệt</span>';
            }
            $tableContent .= '</td>';
            $tableContent .= '<td>';
            $tableContent .= '<div>' . $review->created_at->format('d/m/Y') . '</div>';
            $tableContent .= '<small class="text-muted">' . $review->created_at->format('H:i') . '</small>';
            $tableContent .= '</td>';
            $tableContent .= '<td>';
            $tableContent .= '<div class="btn-group" role="group">';
            $tableContent .= '<a href="' . route('admin.reviews.show', $review) . '" class="btn-admin btn-admin-outline btn-admin-sm" title="Xem chi tiết"><i class="fas fa-eye"></i></a>';
            if($review->is_approved) {
                $tableContent .= '<form action="' . route('admin.reviews.reject', $review) . '" method="POST" class="d-inline">';
                $tableContent .= csrf_field();
                $tableContent .= '<button type="submit" class="btn-admin btn-admin-warning btn-admin-sm" title="Từ chối"><i class="fas fa-times"></i></button>';
                $tableContent .= '</form>';
            } else {
                $tableContent .= '<form action="' . route('admin.reviews.approve', $review) . '" method="POST" class="d-inline">';
                $tableContent .= csrf_field();
                $tableContent .= '<button type="submit" class="btn-admin btn-admin-success btn-admin-sm" title="Duyệt"><i class="fas fa-check"></i></button>';
                $tableContent .= '</form>';
            }
            $tableContent .= '<form action="' . route('admin.reviews.destroy', $review) . '" method="POST" class="d-inline" onsubmit="return confirm(\'Bạn có chắc muốn xóa đánh giá này?\')">';
            $tableContent .= csrf_field();
            $tableContent .= method_field('DELETE');
            $tableContent .= '<button type="submit" class="btn-admin btn-admin-danger btn-admin-sm" title="Xóa"><i class="fas fa-trash"></i></button>';
            $tableContent .= '</form>';
            $tableContent .= '</div>';
            $tableContent .= '</td>';
            $tableContent .= '</tr>';
        }
    } else {
        $tableContent = '<tr><td colspan="7" class="text-center py-5"><div class="text-muted"><i class="fas fa-star fa-3x mb-3"></i><h5>Không có đánh giá nào</h5><p>Chưa có đánh giá nào phù hợp với bộ lọc hiện tại.</p></div></td></tr>';
    }
@endphp

@include('components.admin.card', [
    'title' => 'Danh sách đánh giá',
    'subtitle' => 'Quản lý các đánh giá từ khách hàng',
    'content' => view('components.admin.table', [
        'headers' => ['Khách hàng', 'Sản phẩm', 'Đánh giá', 'Bình luận', 'Trạng thái', 'Ngày tạo', 'Thao tác'],
        'content' => $tableContent
    ])->render() . ($reviews->hasPages() ? '<div class="d-flex justify-content-between align-items-center mt-3"><div class="text-muted">Hiển thị ' . $reviews->firstItem() . ' - ' . $reviews->lastItem() . ' trong tổng số ' . $reviews->total() . ' đánh giá</div>' . $reviews->withQueryString()->links() . '</div>' : '')
])
@endsection