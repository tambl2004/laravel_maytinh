@extends('layouts.customer')

@section('title', 'Địa chỉ của tôi')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-12">
            <h1>Sổ địa chỉ của tôi</h1>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <p class="mb-0">Quản lý thông tin địa chỉ nhận hàng của bạn.</p>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAddressModal">Thêm địa chỉ</button>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($addresses->isEmpty())
                <div class="alert alert-info">Bạn chưa có địa chỉ nào được lưu.</div>
            @else
                @foreach($addresses as $address)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="d-flex align-items-center mb-2">
                                    <h5 class="card-title mb-0 me-2">{{ $address->name }}</h5>
                                    @if($address->is_default)
                                        <span class="badge bg-success">Mặc định</span>
                                    @endif
                                </div>
                                <div class="text-muted small">SĐT: {{ $address->phone }}</div>
                                <div class="text-muted">{{ $address->address }}</div>
                            </div>
                            <div class="d-flex gap-2">
                                @if(!$address->is_default)
                                <form action="{{ route('addresses.setDefault', $address) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-primary">Đặt mặc định</button>
                                </form>
                                @endif
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editAddressModal{{ $address->id }}">Sửa</button>
                                <form action="{{ route('addresses.destroy', $address) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa địa chỉ này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Xóa</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal sửa địa chỉ -->
                <div class="modal fade" id="editAddressModal{{ $address->id }}" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Sửa địa chỉ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="{{ route('addresses.update', $address) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="modal-body">
                          <div class="mb-3">
                            <label class="form-label">Họ và Tên</label>
                            <input type="text" name="name" class="form-control" value="{{ $address->name }}" required>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <input type="tel" name="phone" class="form-control" value="{{ $address->phone }}" required>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Địa chỉ chi tiết</label>
                            <textarea name="address" class="form-control" rows="3" required>{{ $address->address }}</textarea>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                          <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

<!-- Modal thêm địa chỉ -->
<div class="modal fade" id="createAddressModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Thêm địa chỉ mới</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('addresses.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="create_name" class="form-label">Họ và Tên</label>
            <input type="text" class="form-control" id="create_name" name="name" required>
          </div>
          <div class="mb-3">
            <label for="create_phone" class="form-label">Số điện thoại</label>
            <input type="tel" class="form-control" id="create_phone" name="phone" required>
          </div>
          <div class="mb-3">
            <label for="create_address" class="form-label">Địa chỉ chi tiết</label>
            <textarea class="form-control" id="create_address" name="address" rows="3" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
          <button type="submit" class="btn btn-primary">Lưu địa chỉ</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection