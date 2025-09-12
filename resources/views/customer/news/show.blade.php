@extends('layouts.customer')

@section('title', $news->title)

@section('content')
<!-- News Detail Hero Section -->
<div class="news-detail-hero bg-gradient-primary text-white py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" class="text-black text-decoration-none">
                                <i class="fas fa-home"></i> Trang chủ
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('news.index') }}" class="text-black text-decoration-none">Tin tức</a>
                        </li>
                        <li class="breadcrumb-item active text-black-50" aria-current="page">
                            {{ Str::limit($news->title, 50) }}
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="news-meta text-black-50">
                    <small>
                        <i class="fas fa-calendar me-1"></i>
                        {{ $news->created_at->format('d/m/Y H:i') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <article class="news-detail">
                <div class="card border-0 shadow-sm rounded-3">
                    @if($news->featured_image)
                    <div class="news-detail-image">
                        <img src="{{ $news->featured_image }}" alt="{{ $news->title }}" class="card-img-top">
                        @if($news->is_featured)
                        <div class="featured-badge">
                            <i class="fas fa-star"></i>
                            <span>Tin tức nổi bật</span>
                        </div>
                        @endif
                    </div>
                    @endif
                    
                    <div class="card-body p-4">
                        <div class="news-header mb-4">
                            <h1 class="news-title mb-3">{{ $news->title }}</h1>
                            
                            <div class="news-meta mb-3">
                                <div class="d-flex align-items-center text-muted">
                                    <div class="author-info me-4">
                                        <i class="fas fa-user me-2"></i>
                                        <span>{{ $news->author }}</span>
                                    </div>
                                    <div class="date-info me-4">
                                        <i class="fas fa-calendar me-2"></i>
                                        <span>{{ $news->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="views-info">
                                        <i class="fas fa-eye me-2"></i>
                                        <span>{{ $news->views }} lượt xem</span>
                                    </div>
                                </div>
                            </div>
                            
                            @if($news->excerpt)
                            <div class="news-excerpt">
                                <p class="lead text-muted">{{ $news->excerpt }}</p>
                            </div>
                            @endif
                        </div>
                        
                        <div class="news-content">
                            {!! nl2br(e($news->content)) !!}
                        </div>
                    </div>
                </div>
            </article>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="news-sidebar">
                <!-- Related News -->
                @if($relatedNews->count() > 0)
                <div class="sidebar-section mb-4">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-primary text-white border-0">
                            <h5 class="mb-0">
                                <i class="fas fa-newspaper me-2"></i>Tin tức liên quan
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            @foreach($relatedNews as $related)
                            <div class="related-news-item p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <div class="d-flex">
                                    @if($related->featured_image)
                                    <div class="related-image me-3">
                                        <img src="{{ $related->featured_image }}" alt="{{ $related->title }}" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                    </div>
                                    @endif
                                    <div class="related-content flex-grow-1">
                                        <h6 class="related-title mb-2">
                                            <a href="{{ route('news.show', $related->slug) }}" class="text-decoration-none text-dark">
                                                {{ Str::limit($related->title, 60) }}
                                            </a>
                                        </h6>
                                        <div class="related-meta text-muted small">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $related->created_at->format('d/m/Y') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Back to News -->
                <div class="sidebar-section">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body text-center">
                            <a href="{{ route('news.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách tin tức
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
