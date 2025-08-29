@extends('layouts.customer')

@section('title', 'Địa chỉ của tôi')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-7">
            <h1>Sổ địa chỉ của tôi</h1>
            <p>Quản lý thông tin địa chỉ nhận hàng của bạn.</p>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($addresses->isEmpty())
                <div class="alert alert-info">Bạn chưa có địa chỉ nào được lưu.</div>
            @else
                @foreach($addresses as $address)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title mb-1">{{ $address->name }}</h5>
                                <p class="card-text text-muted mb-1">{{ $address->phone }}</p>
                                <p class="card-text text-muted">{{ $address->address }}</p>
                            </div>
                            <div>
                                <form action="{{ route('addresses.destroy', $address) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa địa chỉ này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Xóa</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h4>Thêm địa chỉ mới</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('addresses.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Họ và Tên</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ chi tiết</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Lưu địa chỉ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection