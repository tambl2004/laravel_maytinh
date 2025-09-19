@extends('layouts.admin.app')

@section('title', 'Thêm FAQ')
@section('page-title', 'Thêm câu hỏi thường gặp')

@section('content')
<div class="admin-card">
    <div class="admin-card-body">
        <form action="{{ route('admin.faq.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Câu hỏi</label>
                <input type="text" name="question" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Câu trả lời</label>
                <textarea name="answer" rows="6" class="form-control" required></textarea>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Thứ tự hiển thị</label>
                    <input type="number" name="display_order" class="form-control" value="0" min="0">
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
                        <label class="form-check-label" for="is_active">Hiển thị</label>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.faq.index') }}" class="btn btn-outline-secondary">Quay lại</a>
                <button class="btn btn-admin btn-admin-primary" type="submit">Lưu</button>
            </div>
        </form>
    </div>
</div>
@endsection


