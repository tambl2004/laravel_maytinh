@extends('layouts.customer')

@section('title', 'Địa chỉ của tôi')

@section('content')
<!-- Address Hero Section -->
<div class="address-hero bg-gradient-primary text-black py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-5 fw-bold mb-3">
                    <i class="fas fa-map-marker-alt me-3"></i>Sổ địa chỉ của tôi
                </h1>
                <p class="lead mb-0">Quản lý thông tin địa chỉ nhận hàng của bạn</p>
            </div>
            <div class="col-md-4 text-md-end">
                <button type="button" id="addAddressBtn" class="btn btn-light btn-lg shadow-sm" style="cursor: pointer;" onclick="openCreateModal()">
                    <i class="fas fa-plus me-2"></i>Thêm địa chỉ mới
                </button>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($addresses->isEmpty())
        <div class="empty-state text-center py-5">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-5">
                    <i class="fas fa-map-marker-alt text-muted mb-4" style="font-size: 4rem;"></i>
                    <h4 class="fw-bold mb-3">Chưa có địa chỉ nào</h4>
                    <p class="text-muted mb-4">Bạn chưa có địa chỉ nào được lưu. Hãy sử dụng nút "Thêm địa chỉ mới" ở trên để thêm địa chỉ đầu tiên.</p>
                </div>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($addresses as $address)
            <div class="col-md-6 col-lg-4">
                <div class="address-card h-100">
                    <div class="card border-2 h-100 {{ $address->is_default ? ' bg-opacity-5' : 'border-light' }}">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="address-header">
                                    <h5 class="card-title mb-1 d-flex align-items-center">
                                        <i class="fas fa-user me-2 text-primary"></i>{{ $address->name }}
                                        @if($address->is_default)
                                            <span class="badge bg-primary ms-2">Mặc định</span>
                                        @endif
                                    </h5>
                                    <div class="text-muted small">
                                        <i class="fas fa-phone me-1"></i>{{ $address->phone }}
                                    </div>
                                </div>
                                <div class="address-actions">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            @if(!$address->is_default)
                                            <li>
                                                <form action="{{ route('addresses.setDefault', $address) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="fas fa-star me-2"></i>Đặt mặc định
                                                    </button>
                                                </form>
                                            </li>
                                            @endif
                                            <li>
                                                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editAddressModal{{ $address->id }}">
                                                    <i class="fas fa-edit me-2"></i>Sửa địa chỉ
                                                </button>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('addresses.destroy', $address) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa địa chỉ này?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="fas fa-trash me-2"></i>Xóa địa chỉ
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="address-details">
                                <div class="address-location">
                                    <i class="fas fa-map-marker-alt me-2 text-muted"></i>
                                    @if($address->full_address)
                                        <span>{{ $address->full_address }}</span>
                                    @else
                                        <span>{{ $address->address }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Modal thêm địa chỉ -->
<div class="modal fade" id="createAddressModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="fas fa-plus me-2"></i>Thêm địa chỉ mới
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('addresses.store') }}" method="POST" id="createAddressForm">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="create_name" class="form-label">
                  <i class="fas fa-user me-1"></i>Họ và Tên
                </label>
                <input type="text" class="form-control" id="create_name" name="name" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="create_phone" class="form-label">
                  <i class="fas fa-phone me-1"></i>Số điện thoại
                </label>
                <input type="tel" class="form-control" id="create_phone" name="phone" required>
              </div>
            </div>
          </div>
          
          <!-- Dropdown tỉnh thành -->
          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label for="create_province" class="form-label">
                  <i class="fas fa-map-marker-alt me-1"></i>Tỉnh/Thành phố
                </label>
                <select class="form-select" id="create_province" name="province_id" required>
                  <option value="">Chọn tỉnh/thành phố</option>
                </select>
                <input type="hidden" id="create_province_name" name="province_name">
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label for="create_district" class="form-label">
                  <i class="fas fa-map-marker-alt me-1"></i>Quận/Huyện
                </label>
                <select class="form-select" id="create_district" name="district_id" required disabled>
                  <option value="">Chọn quận/huyện</option>
                </select>
                <input type="hidden" id="create_district_name" name="district_name">
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label for="create_ward" class="form-label">
                  <i class="fas fa-map-marker-alt me-1"></i>Phường/Xã
                </label>
                <select class="form-select" id="create_ward" name="ward_id" required disabled>
                  <option value="">Chọn phường/xã</option>
                </select>
                <input type="hidden" id="create_ward_name" name="ward_name">
              </div>
            </div>
          </div>
          
          <div class="mb-3">
            <label for="create_detail_address" class="form-label">
              <i class="fas fa-home me-1"></i>Địa chỉ chi tiết
            </label>
            <textarea class="form-control" id="create_detail_address" name="detail_address" rows="3" placeholder="Số nhà, tên đường, tòa nhà..." required></textarea>
          </div>
          
          <!-- Giữ lại trường address cũ để tương thích -->
          <input type="hidden" id="create_address" name="address">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>Đóng
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i>Lưu địa chỉ
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal sửa địa chỉ -->
@foreach($addresses as $address)
<div class="modal fade" id="editAddressModal{{ $address->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="fas fa-edit me-2"></i>Sửa địa chỉ
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('addresses.update', $address) }}" method="POST" id="editAddressForm{{ $address->id }}">
        @csrf
        @method('PATCH')
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="edit_name{{ $address->id }}" class="form-label">
                  <i class="fas fa-user me-1"></i>Họ và Tên
                </label>
                <input type="text" class="form-control" id="edit_name{{ $address->id }}" name="name" value="{{ $address->name }}" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="edit_phone{{ $address->id }}" class="form-label">
                  <i class="fas fa-phone me-1"></i>Số điện thoại
                </label>
                <input type="tel" class="form-control" id="edit_phone{{ $address->id }}" name="phone" value="{{ $address->phone }}" required>
              </div>
            </div>
          </div>
          
          <!-- Dropdown tỉnh thành -->
          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label for="edit_province{{ $address->id }}" class="form-label">
                  <i class="fas fa-map-marker-alt me-1"></i>Tỉnh/Thành phố
                </label>
                <select class="form-select" id="edit_province{{ $address->id }}" name="province_id" required>
                  <option value="">Chọn tỉnh/thành phố</option>
                </select>
                <input type="hidden" id="edit_province_name{{ $address->id }}" name="province_name" value="{{ $address->province_name }}">
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label for="edit_district{{ $address->id }}" class="form-label">
                  <i class="fas fa-map-marker-alt me-1"></i>Quận/Huyện
                </label>
                <select class="form-select" id="edit_district{{ $address->id }}" name="district_id" required>
                  <option value="">Chọn quận/huyện</option>
                </select>
                <input type="hidden" id="edit_district_name{{ $address->id }}" name="district_name" value="{{ $address->district_name }}">
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label for="edit_ward{{ $address->id }}" class="form-label">
                  <i class="fas fa-map-marker-alt me-1"></i>Phường/Xã
                </label>
                <select class="form-select" id="edit_ward{{ $address->id }}" name="ward_id" required>
                  <option value="">Chọn phường/xã</option>
                </select>
                <input type="hidden" id="edit_ward_name{{ $address->id }}" name="ward_name" value="{{ $address->ward_name }}">
              </div>
            </div>
          </div>
          
          <div class="mb-3">
            <label for="edit_detail_address{{ $address->id }}" class="form-label">
              <i class="fas fa-home me-1"></i>Địa chỉ chi tiết
            </label>
            <textarea class="form-control" id="edit_detail_address{{ $address->id }}" name="detail_address" rows="3" placeholder="Số nhà, tên đường, tòa nhà..." required>{{ $address->detail_address }}</textarea>
          </div>
          
          <!-- Giữ lại trường address cũ để tương thích -->
          <input type="hidden" id="edit_address{{ $address->id }}" name="address">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>Đóng
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i>Lưu thay đổi
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

<!-- JavaScript cho API tỉnh thành -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Function để mở modal tạo địa chỉ
function openCreateModal() {
    console.log('openCreateModal called');
    const modal = document.getElementById('createAddressModal');
    if (modal) {
        console.log('Modal found, opening...');
        // Sử dụng Bootstrap modal
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
    } else {
        console.error('Modal not found!');
        alert('Không thể mở modal. Vui lòng refresh trang và thử lại.');
    }
}
</script>
<script>
$(document).ready(function() {
    console.log('Address page loaded');
    console.log('jQuery version:', $.fn.jquery);
    console.log('Bootstrap modal available:', typeof $.fn.modal !== 'undefined');
    
    // Kiểm tra xem modal có tồn tại không
    if ($('#createAddressModal').length === 0) {
        console.error('Modal createAddressModal not found');
        return;
    }
    
    console.log('Modal found, setting up...');
    
    // Hàm load tỉnh thành
    function loadProvinces(selectId, hiddenId) {
        console.log('Loading provinces for:', selectId);
        $.getJSON('https://esgoo.net/api-tinhthanh/1/0.htm', function(data) {
            if (data.error == 0) {
                const select = $('#' + selectId);
                if (select.length === 0) {
                    console.error('Select element not found:', selectId);
                    return;
                }
                select.html('<option value="">Chọn tỉnh/thành phố</option>');
                $.each(data.data, function(key, val) {
                    select.append('<option value="' + val.id + '">' + val.full_name + '</option>');
                });
                console.log('Provinces loaded successfully');
            } else {
                console.error('Error loading provinces:', data);
            }
        }).fail(function(xhr, status, error) {
            console.error('Failed to load provinces:', error);
            // Fallback: thêm một số tỉnh thành phổ biến
            const select = $('#' + selectId);
            if (select.length > 0) {
                select.html('<option value="">Chọn tỉnh/thành phố</option>');
                select.append('<option value="01">Hà Nội</option>');
                select.append('<option value="79">TP. Hồ Chí Minh</option>');
                select.append('<option value="31">Hải Phòng</option>');
                select.append('<option value="48">Đà Nẵng</option>');
            }
        });
    }

    // Hàm load quận huyện
    function loadDistricts(provinceId, selectId, hiddenId) {
        if (!provinceId) {
            $('#' + selectId).html('<option value="">Chọn quận/huyện</option>').prop('disabled', true);
            $('#' + hiddenId).val('');
            return;
        }
        
        console.log('Loading districts for province:', provinceId);
        $.getJSON('https://esgoo.net/api-tinhthanh/2/' + provinceId + '.htm', function(data) {
            if (data.error == 0) {
                const select = $('#' + selectId);
                if (select.length === 0) {
                    console.error('Select element not found:', selectId);
                    return;
                }
                select.html('<option value="">Chọn quận/huyện</option>').prop('disabled', false);
                $.each(data.data, function(key, val) {
                    select.append('<option value="' + val.id + '">' + val.full_name + '</option>');
                });
                console.log('Districts loaded successfully');
            } else {
                console.error('Error loading districts:', data);
            }
        }).fail(function(xhr, status, error) {
            console.error('Failed to load districts:', error);
        });
    }

    // Hàm load phường xã
    function loadWards(districtId, selectId, hiddenId) {
        if (!districtId) {
            $('#' + selectId).html('<option value="">Chọn phường/xã</option>').prop('disabled', true);
            $('#' + hiddenId).val('');
            return;
        }
        
        console.log('Loading wards for district:', districtId);
        $.getJSON('https://esgoo.net/api-tinhthanh/3/' + districtId + '.htm', function(data) {
            if (data.error == 0) {
                const select = $('#' + selectId);
                if (select.length === 0) {
                    console.error('Select element not found:', selectId);
                    return;
                }
                select.html('<option value="">Chọn phường/xã</option>').prop('disabled', false);
                $.each(data.data, function(key, val) {
                    select.append('<option value="' + val.id + '">' + val.full_name + '</option>');
                });
                console.log('Wards loaded successfully');
            } else {
                console.error('Error loading wards:', data);
            }
        }).fail(function(xhr, status, error) {
            console.error('Failed to load wards:', error);
        });
    }

    // Load tỉnh thành cho modal tạo mới
    console.log('Loading provinces for create modal');
    loadProvinces('create_province', 'create_province_name');

    // Load tỉnh thành cho các modal sửa
    @foreach($addresses as $address)
    console.log('Loading provinces for edit modal {{ $address->id }}');
    loadProvinces('edit_province{{ $address->id }}', 'edit_province_name{{ $address->id }}');
    @endforeach

    // Kiểm tra modal có hoạt động không
    $('#createAddressModal').on('show.bs.modal', function () {
        console.log('Create address modal is opening');
    });

    $('#createAddressModal').on('shown.bs.modal', function () {
        console.log('Create address modal is opened');
        // Đảm bảo tỉnh thành được load khi modal mở
        if ($('#create_province option').length <= 1) {
            console.log('Reloading provinces for create modal');
            loadProvinces('create_province', 'create_province_name');
        }
    });

    // Event listener cho nút "Thêm địa chỉ mới" trong hero section
    $('#addAddressBtn').on('click', function(e) {
        console.log('Hero section button clicked');
        e.preventDefault();
        e.stopPropagation();
        
        // Đảm bảo modal tồn tại
        if ($('#createAddressModal').length > 0) {
            console.log('Opening modal...');
            try {
                $('#createAddressModal').modal('show');
            } catch (error) {
                console.error('Error opening modal:', error);
                // Fallback: hiển thị modal bằng cách thay đổi CSS
                $('#createAddressModal').show();
                $('body').addClass('modal-open');
            }
        } else {
            console.error('Modal not found!');
        }
    });


    // Xử lý sự kiện thay đổi tỉnh thành cho modal tạo mới
    $('#create_province').change(function() {
        const provinceId = $(this).val();
        const provinceName = $(this).find('option:selected').text();
        $('#create_province_name').val(provinceName);
        
        loadDistricts(provinceId, 'create_district', 'create_district_name');
        $('#create_ward').html('<option value="">Chọn phường/xã</option>').prop('disabled', true);
        $('#create_ward_name').val('');
    });

    // Xử lý sự kiện thay đổi quận huyện cho modal tạo mới
    $('#create_district').change(function() {
        const districtId = $(this).val();
        const districtName = $(this).find('option:selected').text();
        $('#create_district_name').val(districtName);
        
        loadWards(districtId, 'create_ward', 'create_ward_name');
    });

    // Xử lý sự kiện thay đổi phường xã cho modal tạo mới
    $('#create_ward').change(function() {
        const wardName = $(this).find('option:selected').text();
        $('#create_ward_name').val(wardName);
        updateFullAddress('create');
    });

    // Xử lý sự kiện cho các modal sửa
    @foreach($addresses as $address)
    $('#edit_province{{ $address->id }}').change(function() {
        const provinceId = $(this).val();
        const provinceName = $(this).find('option:selected').text();
        $('#edit_province_name{{ $address->id }}').val(provinceName);
        
        loadDistricts(provinceId, 'edit_district{{ $address->id }}', 'edit_district_name{{ $address->id }}');
        $('#edit_ward{{ $address->id }}').html('<option value="">Chọn phường/xã</option>').prop('disabled', true);
        $('#edit_ward_name{{ $address->id }}').val('');
    });

    $('#edit_district{{ $address->id }}').change(function() {
        const districtId = $(this).val();
        const districtName = $(this).find('option:selected').text();
        $('#edit_district_name{{ $address->id }}').val(districtName);
        
        loadWards(districtId, 'edit_ward{{ $address->id }}', 'edit_ward_name{{ $address->id }}');
    });

    $('#edit_ward{{ $address->id }}').change(function() {
        const wardName = $(this).find('option:selected').text();
        $('#edit_ward_name{{ $address->id }}').val(wardName);
        updateFullAddress('edit{{ $address->id }}');
    });
    @endforeach

    // Hàm cập nhật địa chỉ đầy đủ
    function updateFullAddress(prefix) {
        const detailAddress = $('#' + prefix + '_detail_address').val();
        const wardName = $('#' + prefix + '_ward_name').val();
        const districtName = $('#' + prefix + '_district_name').val();
        const provinceName = $('#' + prefix + '_province_name').val();
        
        const fullAddress = [detailAddress, wardName, districtName, provinceName]
            .filter(part => part && part.trim() !== '')
            .join(', ');
        
        $('#' + prefix + '_address').val(fullAddress);
    }

    // Cập nhật địa chỉ khi thay đổi địa chỉ chi tiết
    $('#create_detail_address').on('input', function() {
        updateFullAddress('create');
    });

    @foreach($addresses as $address)
    $('#edit_detail_address{{ $address->id }}').on('input', function() {
        updateFullAddress('edit{{ $address->id }}');
    });
    @endforeach

    // Xử lý submit form
    $('#createAddressForm').on('submit', function(e) {
        console.log('Create address form submitted');
        // Đảm bảo địa chỉ đầy đủ được tạo
        updateFullAddress('create');
        
        // Kiểm tra validation
        const name = $('#create_name').val();
        const phone = $('#create_phone').val();
        const province = $('#create_province').val();
        const district = $('#create_district').val();
        const ward = $('#create_ward').val();
        const detailAddress = $('#create_detail_address').val();
        
        if (!name || !phone || !province || !district || !ward || !detailAddress) {
            e.preventDefault();
            alert('Vui lòng điền đầy đủ thông tin địa chỉ');
            return false;
        }
        
        console.log('Form validation passed, submitting...');
    });

    // Load dữ liệu hiện tại khi mở modal sửa
    @foreach($addresses as $address)
    $('#editAddressModal{{ $address->id }}').on('show.bs.modal', function() {
        // Load quận huyện nếu đã có tỉnh thành
        @if($address->province_id)
        loadDistricts('{{ $address->province_id }}', 'edit_district{{ $address->id }}', 'edit_district_name{{ $address->id }}');
        setTimeout(function() {
            $('#edit_district{{ $address->id }}').val('{{ $address->district_id }}');
            // Load phường xã nếu đã có quận huyện
            @if($address->district_id)
            loadWards('{{ $address->district_id }}', 'edit_ward{{ $address->id }}', 'edit_ward_name{{ $address->id }}');
            setTimeout(function() {
                $('#edit_ward{{ $address->id }}').val('{{ $address->ward_id }}');
            }, 500);
            @endif
        }, 500);
        @endif
    });
    @endforeach
});
</script>

@endsection