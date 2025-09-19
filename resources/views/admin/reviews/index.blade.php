@extends('layouts.admin.app')

@section('title', 'Quản lý đánh giá')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-star me-2"></i>Quản lý đánh giá sản phẩm
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.reviews.statistics') }}" class="btn btn-info btn-sm">
                            <i class="fas fa-chart-bar me-1"></i>Thống kê
                        </a>
                    </div>
                </div>

                <!-- Filters -->
                <div class="card-body border-bottom">
                    <form method="GET" action="{{ route('admin.reviews.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Trạng thái</label>
                            <select name="status" class="form-select">
                                <option value="">Tất cả</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Đã duyệt</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Số sao</label>
                            <select name="rating" class="form-select">
                                <option value="">Tất cả</option>
                                @for($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                        {{ $i }} sao
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tìm kiếm</label>
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Tên sản phẩm hoặc khách hàng..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i>Lọc
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body p-0">
                    @if($reviews->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Khách hàng</th>
                                        <th>Sản phẩm</th>
                                        <th>Đánh giá</th>
                                        <th>Bình luận</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày tạo</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reviews as $review)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                                                         style="width: 30px; height: 30px; font-size: 12px;">
                                                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">{{ $review->user->name }}</div>
                                                        <small class="text-muted">{{ $review->user->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $review->product->image }}" 
                                                         alt="{{ $review->product->name }}" 
                                                         class="me-2 rounded"
                                                         style="width: 40px; height: 40px; object-fit: cover;">
                                                    <div>
                                                        <div class="fw-semibold">{{ Str::limit($review->product->name, 30) }}</div>
                                                        <small class="text-muted">{{ number_format($review->product->price, 0, ',', '.') }}₫</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }} small"></i>
                                                    @endfor
                                                    <span class="ms-2 fw-semibold">{{ $review->rating }}/5</span>
                                                </div>
                                            </td>
                                            <td>
                                                @if($review->comment)
                                                    <span class="text-truncate d-inline-block" style="max-width: 200px;" 
                                                          title="{{ $review->comment }}">
                                                        {{ Str::limit($review->comment, 50) }}
                                                    </span>
                                                @else
                                                    <em class="text-muted">Không có bình luận</em>
                                                @endif
                                            </td>
                                            <td>
                                                @if($review->is_approved)
                                                    <span class="badge bg-success">Đã duyệt</span>
                                                @else
                                                    <span class="badge bg-warning">Chờ duyệt</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div>{{ $review->created_at->format('d/m/Y') }}</div>
                                                <small class="text-muted">{{ $review->created_at->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.reviews.show', $review) }}" class="btn btn-info btn-sm" title="Xem chi tiết">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    
                                                    @if($review->is_approved)
                                                        <form action="{{ route('admin.reviews.reject', $review) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-warning btn-sm" title="Từ chối">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm" title="Duyệt">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    
                                                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline" 
                                                          onsubmit="return confirm('Bạn có chắc muốn xóa đánh giá này?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Xóa">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-star fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Không có đánh giá nào</h5>
                            <p class="text-muted">Chưa có đánh giá nào phù hợp với bộ lọc hiện tại.</p>
                        </div>
                    @endif
                </div>

                @if($reviews->hasPages())
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Hiển thị {{ $reviews->firstItem() }} - {{ $reviews->lastItem() }} 
                                trong tổng số {{ $reviews->total() }} đánh giá
                            </div>
                            {{ $reviews->withQueryString()->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto-submit form when filter changes
    document.querySelectorAll('select[name="status"], select[name="rating"]').forEach(select => {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });
    
    // Clear filters
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.toString()) {
            const clearBtn = document.createElement('a');
            clearBtn.href = '{{ route("admin.reviews.index") }}';
            clearBtn.className = 'btn btn-outline-secondary btn-sm ms-2';
            clearBtn.innerHTML = '<i class="fas fa-times me-1"></i>Xóa bộ lọc';
            document.querySelector('.card-tools').appendChild(clearBtn);
        }
    });
</script>
@endsection