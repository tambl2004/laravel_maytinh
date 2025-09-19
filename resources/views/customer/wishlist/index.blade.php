@extends('layouts.customer')

@section('title', 'Yêu thích - Laptop Shop')

@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="fw-bold mb-0">Sản phẩm yêu thích</h2>
        @if($products->count() > 0)
        <form action="{{ route('wishlist.clear') }}" method="POST" onsubmit="return confirm('Xóa tất cả khỏi yêu thích?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-outline-danger btn-sm">
                <i class="fas fa-trash me-1"></i>Xóa tất cả
            </button>
        </form>
        @endif
    </div>

    @if($products->count() === 0)
        <div class="text-center py-5">
            <i class="fas fa-heart-broken fa-3x text-muted mb-3"></i>
            <p class="text-muted mb-3">Bạn chưa thêm sản phẩm nào vào danh sách yêu thích.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">Khám phá sản phẩm</a>
        </div>
    @else
        <div class="row">
            @foreach($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="modern-product-card h-100">
                    <div class="product-image-container">
                        <img src="{{ $product->image }}" class="product-img" alt="{{ $product->name }}">
                        <div class="quick-actions">
                            <a href="{{ route('products.show', $product) }}" class="action-btn" title="Xem chi tiết">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    <div class="product-content d-flex flex-column">
                        <h3 class="product-title mb-2">
                            <a href="{{ route('products.show', $product) }}">{{ Str::limit($product->name, 45) }}</a>
                        </h3>
                        <div class="price-section mb-3">
                            <div class="price">{{ number_format($product->price, 0, ',', '.') }}₫</div>
                        </div>
                        <div class="mt-auto d-flex gap-2">
                            <form action="{{ route('wishlist.remove', $product) }}" method="POST" class="wishlist-remove-form">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-heart-broken me-1"></i>Bỏ thích
                                </button>
                            </form>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-primary btn-sm">Mua ngay</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
// JS nhỏ: gửi form remove qua fetch để mượt
document.querySelectorAll('.wishlist-remove-form').forEach(form => {
    form.addEventListener('submit', function(e){
        if (!this.action || !window.fetch) return;
        e.preventDefault();
        fetch(this.action, { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' }, body: new FormData(this) })
            .then(() => location.reload());
    });
});
</script>
@endsection


