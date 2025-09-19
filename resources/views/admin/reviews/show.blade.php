@extends('layouts.admin.app')

@section('title', 'Chi tiết đánh giá')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">Chi tiết đánh giá</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.reviews.index') }}">Đánh giá</a></li>
                            <li class="breadcrumb-item active">Chi tiết</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Review Details -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-star me-2"></i>Thông tin đánh giá
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Rating Display -->
                            <div class="row mb-4">
                                <div class="col-sm-3">
                                    <strong>Đánh giá:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <div class="d-flex align-items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }} me-1"></i>
                                        @endfor
                                        <span class="ms-2 h5 mb-0">{{ $review->rating }}/5</span>
                                        <span class="badge bg-{{ $review->rating >= 4 ? 'success' : ($review->rating >= 3 ? 'warning' : 'danger') }} ms-2">
                                            @if($review->rating >= 4) Tích cực
                                            @elseif($review->rating >= 3) Trung bình  
                                            @else Tiêu cực
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Comment -->
                            <div class="row mb-4">
                                <div class="col-sm-3">
                                    <strong>Bình luận:</strong>
                                </div>
                                <div class="col-sm-9">
                                    @if($review->comment)
                                        <div class="bg-light p-3 rounded">
                                            <p class="mb-0">{{ $review->comment }}</p>
                                        </div>
                                    @else
                                        <em class="text-muted">Khách hàng không để lại bình luận</em>
                                    @endif
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="row mb-4">
                                <div class="col-sm-3">
                                    <strong>Trạng thái:</strong>
                                </div>
                                <div class="col-sm-9">
                                    @if($review->is_approved)
                                        <span class="badge bg-success fs-6">
                                            <i class="fas fa-check me-1"></i>Đã duyệt
                                        </span>
                                    @else
                                        <span class="badge bg-warning fs-6">
                                            <i class="fas fa-clock me-1"></i>Chờ duyệt
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Timestamps -->
                            <div class="row mb-4">
                                <div class="col-sm-3">
                                    <strong>Ngày tạo:</strong>
                                </div>
                                <div class="col-sm-9">
                                    {{ $review->created_at->format('d/m/Y H:i:s') }}
                                    <small class="text-muted">({{ $review->created_at->diffForHumans() }})</small>
                                </div>
                            </div>

                            @if($review->updated_at != $review->created_at)
                                <div class="row mb-4">
                                    <div class="col-sm-3">
                                        <strong>Cập nhật cuối:</strong>
                                    </div>
                                    <div class="col-sm-9">
                                        {{ $review->updated_at->format('d/m/Y H:i:s') }}
                                        <small class="text-muted">({{ $review->updated_at->diffForHumans() }})</small>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-md-4">
                    <!-- Customer Info -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-user me-2"></i>Thông tin khách hàng
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 50px; height: 50px;">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $review->user->name }}</h6>
                                    <small class="text-muted">{{ $review->user->email }}</small>
                                </div>
                            </div>
                            
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="border-end">
                                        <h5 class="mb-0 text-primary">{{ $review->user->reviews()->count() }}</h5>
                                        <small class="text-muted">Đánh giá</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h5 class="mb-0 text-success">{{ $review->user->orders()->count() }}</h5>
                                    <small class="text-muted">Đơn hàng</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-box me-2"></i>Thông tin sản phẩm
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-start mb-3">
                                <img src="{{ $review->product->image }}" 
                                     alt="{{ $review->product->name }}" 
                                     class="me-3 rounded"
                                     style="width: 60px; height: 60px; object-fit: cover;">
                                <div>
                                    <h6 class="mb-1">{{ $review->product->name }}</h6>
                                    <p class="text-primary mb-0 fw-semibold">{{ number_format($review->product->price, 0, ',', '.') }}₫</p>
                                </div>
                            </div>
                            
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="border-end">
                                        <h6 class="mb-0 text-warning">
                                            <i class="fas fa-star me-1"></i>{{ number_format($review->product->average_rating, 1) }}
                                        </h6>
                                        <small class="text-muted">Đ.giá TB</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h6 class="mb-0 text-info">{{ $review->product->review_count }}</h6>
                                    <small class="text-muted">Đánh giá</small>
                                </div>
                            </div>

                            <div class="mt-3">
                                <a href="{{ route('products.show', $review->product) }}" 
                                   class="btn btn-outline-primary btn-sm w-100" target="_blank">
                                    <i class="fas fa-external-link-alt me-1"></i>Xem sản phẩm
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-cogs me-2"></i>Thao tác
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                @if($review->is_approved)
                                    <form action="{{ route('admin.reviews.reject', $review) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-warning w-100">
                                            <i class="fas fa-times me-2"></i>Từ chối đánh giá
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.reviews.approve', $review) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="fas fa-check me-2"></i>Duyệt đánh giá
                                        </button>
                                    </form>
                                @endif
                                
                                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" 
                                      onsubmit="return confirm('Bạn có chắc muốn xóa đánh giá này? Hành động này không thể hoàn tác.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="fas fa-trash me-2"></i>Xóa đánh giá
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection