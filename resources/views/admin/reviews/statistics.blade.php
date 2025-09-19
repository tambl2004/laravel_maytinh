@extends('layouts.admin.app')

@section('title', 'Thống kê đánh giá')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">Thống kê đánh giá</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.reviews.index') }}">Đánh giá</a></li>
                            <li class="breadcrumb-item active">Thống kê</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                    </a>
                </div>
            </div>

            <!-- Overview Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-left-primary h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Tổng đánh giá
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalReviews }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-star fa-2x text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-left-success h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Đã duyệt
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $approvedReviews }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-left-warning h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Chờ duyệt
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingReviews }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clock fa-2x text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-left-info h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Tỷ lệ duyệt
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $totalReviews > 0 ? round(($approvedReviews / $totalReviews) * 100, 1) : 0 }}%
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-percentage fa-2x text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Rating Distribution -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-chart-bar me-2"></i>Phân bố đánh giá theo sao
                            </h6>
                        </div>
                        <div class="card-body">
                            @foreach($ratingStats as $rating => $count)
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <div class="d-flex align-items-center">
                                            <span class="me-2">{{ $rating }}</span>
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $rating ? 'text-warning' : 'text-muted' }} small me-1"></i>
                                            @endfor
                                        </div>
                                        <span class="fw-semibold">{{ $count }} ({{ $approvedReviews > 0 ? round(($count / $approvedReviews) * 100, 1) : 0 }}%)</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-{{ $rating >= 4 ? 'success' : ($rating >= 3 ? 'warning' : 'danger') }}" 
                                             style="width: {{ $approvedReviews > 0 ? ($count / $approvedReviews * 100) : 0 }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Top Rated Products -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-trophy me-2"></i>Top sản phẩm được đánh giá cao
                            </h6>
                        </div>
                        <div class="card-body">
                            @forelse($topProducts as $index => $product)
                                <div class="d-flex align-items-center mb-3 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                                    <div class="me-3">
                                        <span class="badge bg-{{ $index == 0 ? 'warning' : ($index == 1 ? 'secondary' : 'success') }} fs-6">
                                            #{{ $index + 1 }}
                                        </span>
                                    </div>
                                    <img src="{{ $product->image }}" 
                                         alt="{{ $product->name }}" 
                                         class="me-3 rounded"
                                         style="width: 40px; height: 40px; object-fit: cover;">
                                    <div class="flex-fill">
                                        <h6 class="mb-1">{{ Str::limit($product->name, 30) }}</h6>
                                        <div class="d-flex align-items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= round($product->avg_rating) ? 'text-warning' : 'text-muted' }} small"></i>
                                            @endfor
                                            <span class="ms-2 small fw-semibold">{{ number_format($product->avg_rating, 1) }}</span>
                                            <span class="ms-2 small text-muted">({{ $product->approved_reviews_count }} đánh giá)</span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-star fa-2x mb-2"></i>
                                    <p>Chưa có sản phẩm nào được đánh giá</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-clock me-2"></i>Hoạt động gần đây
                            </h6>
                        </div>
                        <div class="card-body">
                            @php
                                $recentReviews = \App\Models\Review::with(['user', 'product'])
                                    ->latest()
                                    ->limit(5)
                                    ->get();
                            @endphp
                            
                            @forelse($recentReviews as $review)
                                <div class="d-flex align-items-center mb-3 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 35px; height: 35px; font-size: 12px;">
                                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                    </div>
                                    <div class="flex-fill">
                                        <div class="d-flex align-items-center mb-1">
                                            <strong class="me-2">{{ $review->user->name }}</strong>
                                            <span class="text-muted me-2">đã đánh giá</span>
                                            <a href="{{ route('admin.products.show', $review->product) }}" class="text-decoration-none">
                                                {{ Str::limit($review->product->name, 30) }}
                                            </a>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }} small me-1"></i>
                                            @endfor
                                            <span class="ms-2 small">{{ $review->rating }}/5</span>
                                            <span class="badge bg-{{ $review->is_approved ? 'success' : 'warning' }} ms-2">
                                                {{ $review->is_approved ? 'Đã duyệt' : 'Chờ duyệt' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                        <div>
                                            <a href="{{ route('admin.reviews.show', $review) }}" class="btn btn-sm btn-outline-primary">
                                                Xem
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-history fa-2x mb-2"></i>
                                    <p>Chưa có hoạt động nào</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }
    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }
    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }
    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }
    .text-xs {
        font-size: 0.7rem;
    }
</style>
@endsection