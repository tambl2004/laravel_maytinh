@extends('layouts.customer')

@section('title', 'Tin tức')

@section('content')
<!-- News Hero Section -->
<div class="news-hero bg-gradient-primary text-black py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-5 fw-bold mb-3">
                    <i class="fas fa-newspaper me-3"></i>Tin tức công nghệ
                </h1>
                <p class="lead mb-0">Cập nhật những tin tức mới nhất về công nghệ và laptop</p>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="news-stats">
                    <div class="stat-item">
                        <i class="fas fa-newspaper fa-2x mb-2"></i>
                        <div class="h4 mb-0">{{ $news->total() }}</div>
                        <small>Bài viết</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    @if($news->count() > 0)
        <div class="row g-4">
            @foreach($news as $article)
            <div class="col-md-6 col-lg-4">
                <article class="news-card h-100">
                    <div class="card border-0 shadow-sm rounded-3 h-100">
                    @if($article->featured_image)
                    <div class="news-image">
                        <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" class="card-img-top">
                        @if($article->is_featured)
                        <div class="featured-badge">
                            <i class="fas fa-star"></i>
                            <span>Nổi bật</span>
                        </div>
                        @endif
                    </div>
                    @endif
                        
                        <div class="card-body d-flex flex-column">
                            <div class="news-meta mb-3">
                                <div class="d-flex align-items-center text-muted small">
                                    <i class="fas fa-user me-2"></i>
                                    <span>{{ $article->author }}</span>
                                    <i class="fas fa-calendar ms-3 me-2"></i>
                                    <span>{{ $article->created_at->format('d/m/Y') }}</span>
                                    <i class="fas fa-eye ms-3 me-2"></i>
                                    <span>{{ $article->views }}</span>
                                </div>
                            </div>
                            
                            <h5 class="card-title mb-3">
                                <a href="{{ route('news.show', $article->slug) }}" class="text-decoration-none text-dark">
                                    {{ $article->title }}
                                </a>
                            </h5>
                            
                            @if($article->excerpt)
                            <p class="card-text text-muted flex-grow-1">
                                {{ Str::limit($article->excerpt, 120) }}
                            </p>
                            @endif
                            
                            <div class="news-actions mt-auto">
                                <a href="{{ route('news.show', $article->slug) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-right me-2"></i>Đọc tiếp
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="row mt-5">
            <div class="col-12">
                <nav aria-label="Phân trang tin tức">
                    {{ $news->links('vendor.pagination.bootstrap-5') }}
                </nav>
            </div>
        </div>
    @else
        <div class="empty-state text-center py-5">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-5">
                    <i class="fas fa-newspaper text-muted mb-4" style="font-size: 4rem;"></i>
                    <h4 class="fw-bold mb-3">Chưa có tin tức nào</h4>
                    <p class="text-muted mb-4">Hiện tại chưa có tin tức nào được đăng. Vui lòng quay lại sau!</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fas fa-home me-2"></i>Về trang chủ
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
