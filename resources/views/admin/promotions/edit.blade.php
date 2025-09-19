@extends('layouts.admin.app')

@section('title', 'Sửa khuyến mãi')

@section('content')
<div class="container-fluid py-4">
    <h4 class="mb-3">Sửa khuyến mãi</h4>
    <div class="card">
        <form action="{{ route('admin.promotions.update', $promotion) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Tên khuyến mãi</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $promotion->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kích hoạt</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="active" value="1" {{ old('active', $promotion->active) ? 'checked' : '' }}>
                            <span class="small text-muted ms-2">Bật/Tắt khuyến mãi</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Mô tả</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $promotion->description) }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Loại</label>
                        <select name="type" class="form-select" required>
                            <option value="percent" {{ old('type', $promotion->type)==='percent' ? 'selected' : '' }}>Phần trăm (%)</option>
                            <option value="fixed" {{ old('type', $promotion->type)==='fixed' ? 'selected' : '' }}>Số tiền (₫)</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Giá trị</label>
                        <input type="number" step="0.01" name="value" class="form-control" value="{{ old('value', $promotion->value) }}" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Bắt đầu</label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $promotion->start_date->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Kết thúc</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date', optional($promotion->end_date)->format('Y-m-d')) }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Áp dụng cho sản phẩm</label>
                        <select name="products[]" class="form-select" multiple size="10">
                            @foreach($products as $p)
                                <option value="{{ $p->id }}" {{ in_array($p->id, $selected) ? 'selected' : '' }}>
                                    {{ $p->name }} - {{ number_format($p->price,0,',','.') }}₫
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Giữ Ctrl/Command để chọn nhiều sản phẩm</small>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end gap-2">
                <a href="{{ route('admin.promotions.index') }}" class="btn btn-secondary">Hủy</a>
                <button class="btn btn-primary">Cập nhật</button>
            </div>
        </form>
    </div>
    
</div>
@endsection


