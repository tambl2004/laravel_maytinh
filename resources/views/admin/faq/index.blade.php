@extends('layouts.admin.app')

@section('title', 'Quản lý FAQ')

@section('page-title', 'FAQ')
@section('page-subtitle', 'Câu hỏi thường gặp')

@section('content')
<div class="admin-card">
    <div class="admin-card-header d-flex justify-content-between align-items-center">
        <h5 class="admin-card-title mb-0">Danh sách FAQ</h5>
        <a href="{{ route('admin.faq.create') }}" class="btn btn-admin btn-admin-primary">
            <i class="fas fa-plus me-1"></i>Thêm FAQ
        </a>
    </div>
    <div class="admin-card-body">
        <div class="table-responsive admin-table">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Câu hỏi</th>
                        <th>Hiển thị</th>
                        <th>Thứ tự</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($faqs as $faq)
                    <tr>
                        <td>{{ $faq->id }}</td>
                        <td class="fw-semibold">{{ $faq->question }}</td>
                        <td>
                            @if($faq->is_active)
                                <span class="badge bg-success">Đang hiển thị</span>
                            @else
                                <span class="badge bg-secondary">Ẩn</span>
                            @endif
                        </td>
                        <td>{{ $faq->display_order }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.faq.edit', $faq) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.faq.destroy', $faq) }}" method="POST" class="d-inline" onsubmit="return confirm('Xoá FAQ này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="4" class="text-muted">{!! nl2br(e($faq->answer)) !!}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Chưa có FAQ nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $faqs->links('vendor.pagination.bootstrap-5') }}</div>
    </div>
    
</div>
@endsection


