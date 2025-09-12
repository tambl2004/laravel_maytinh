@extends('layouts.admin.app')

@section('title', 'Quản lý tin tức')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-newspaper me-2"></i>Quản lý tin tức
            </h1>
            <p class="text-muted mb-0">Quản lý các bài viết tin tức của website</p>
        </div>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Thêm tin tức mới
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tổng tin tức
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $news->total() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Đã xuất bản
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $news->where('is_published', true)->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Tin nổi bật
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $news->where('is_featured', true)->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-star fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Tổng lượt xem
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $news->sum('views') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-eye fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- News Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list me-2"></i>Danh sách tin tức
            </h6>
        </div>
        <div class="card-body">
            @if($news->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Hình ảnh</th>
                                <th>Tiêu đề</th>
                                <th>Tác giả</th>
                                <th>Trạng thái</th>
                                <th>Nổi bật</th>
                                <th>Lượt xem</th>
                                <th>Ngày tạo</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($news as $article)
                            <tr>
                                <td>
                                    @if($article->featured_image)
                                        <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" 
                                             class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" 
                                             style="width: 60px; height: 60px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold">{{ Str::limit($article->title, 50) }}</div>
                                    @if($article->excerpt)
                                        <small class="text-muted">{{ Str::limit($article->excerpt, 80) }}</small>
                                    @endif
                                </td>
                                <td>{{ $article->author }}</td>
                                <td>
                                    @if($article->is_published)
                                        <span class="badge bg-success">Đã xuất bản</span>
                                    @else
                                        <span class="badge bg-secondary">Bản nháp</span>
                                    @endif
                                </td>
                                <td>
                                    @if($article->is_featured)
                                        <span class="badge bg-warning">
                                            <i class="fas fa-star me-1"></i>Nổi bật
                                        </span>
                                    @else
                                        <span class="badge bg-light text-dark">Thường</span>
                                    @endif
                                </td>
                                <td>
                                    <i class="fas fa-eye me-1"></i>{{ $article->views }}
                                </td>
                                <td>{{ $article->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('news.show', $article->slug) }}" 
                                           class="btn btn-sm btn-outline-info" target="_blank" 
                                           title="Xem tin tức">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.news.edit', $article) }}" 
                                           class="btn btn-sm btn-outline-primary" title="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.news.destroy', $article) }}" 
                                              method="POST" class="d-inline" 
                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa tin tức này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    title="Xóa tin tức">
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

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $news->links('vendor.pagination.bootstrap-5') }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-newspaper text-muted mb-3" style="font-size: 4rem;"></i>
                    <h4 class="fw-bold mb-3">Chưa có tin tức nào</h4>
                    <p class="text-muted mb-4">Bắt đầu tạo tin tức đầu tiên của bạn!</p>
                    <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Thêm tin tức mới
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Vietnamese.json"
            },
            "pageLength": 10,
            "order": [[ 6, "desc" ]], // Sắp xếp theo ngày tạo
            "columnDefs": [
                { "orderable": false, "targets": [0, 7] } // Không sắp xếp cột hình ảnh và thao tác
            ]
        });
    });
</script>
@endsection
