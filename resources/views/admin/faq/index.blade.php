@extends('layouts.admin.app')

@section('title', 'Quản lý FAQ')
@section('page-title', 'Quản lý FAQ')
@section('page-subtitle', 'Câu hỏi thường gặp')

@section('content')
<!-- Header Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-1">Câu hỏi thường gặp</h2>
        <p class="text-muted mb-0">Quản lý các câu hỏi và câu trả lời</p>
    </div>
    <a href="{{ route('admin.faq.create') }}" class="btn btn-admin-primary">
        <i class="fas fa-plus me-2"></i>Thêm FAQ
    </a>
</div>

<!-- FAQ Table -->
@php
    $tableContent = '';
    if($faqs->count() > 0) {
        foreach($faqs as $faq) {
            $tableContent .= '<tr>';
            $tableContent .= '<td>' . $faq->id . '</td>';
            $tableContent .= '<td class="fw-semibold">' . $faq->question . '</td>';
            $tableContent .= '<td>';
            if($faq->is_active) {
                $tableContent .= '<span class="badge-admin badge-completed">Đang hiển thị</span>';
            } else {
                $tableContent .= '<span class="badge-admin badge-pending">Ẩn</span>';
            }
            $tableContent .= '</td>';
            $tableContent .= '<td>' . $faq->display_order . '</td>';
            $tableContent .= '<td class="text-end">';
            $tableContent .= '<a href="' . route('admin.faq.edit', $faq) . '" class="btn-admin btn-admin-outline btn-admin-sm"><i class="fas fa-edit"></i></a>';
            $tableContent .= '<form action="' . route('admin.faq.destroy', $faq) . '" method="POST" class="d-inline" onsubmit="return confirm(\'Xoá FAQ này?\')">';
            $tableContent .= csrf_field();
            $tableContent .= method_field('DELETE');
            $tableContent .= '<button type="submit" class="btn-admin btn-admin-danger btn-admin-sm"><i class="fas fa-trash"></i></button>';
            $tableContent .= '</form>';
            $tableContent .= '</td>';
            $tableContent .= '</tr>';
            $tableContent .= '<tr>';
            $tableContent .= '<td></td>';
            $tableContent .= '<td colspan="4" class="text-muted">' . nl2br(e($faq->answer)) . '</td>';
            $tableContent .= '</tr>';
        }
    } else {
        $tableContent = '<tr><td colspan="5" class="text-center text-muted py-4">Chưa có FAQ nào</td></tr>';
    }
@endphp

@include('components.admin.card', [
    'title' => 'Danh sách FAQ',
    'subtitle' => 'Quản lý các câu hỏi thường gặp',
    'headerActions' => '<i class="fas fa-question-circle"></i>',
    'content' => view('components.admin.table', [
        'headers' => ['#', 'Câu hỏi', 'Hiển thị', 'Thứ tự', 'Hành động'],
        'content' => $tableContent
    ])->render() . '<div class="mt-3">' . $faqs->links('vendor.pagination.bootstrap-5') . '</div>'
])
@endsection


