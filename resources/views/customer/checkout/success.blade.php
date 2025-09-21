@extends('layouts.customer')

@section('title', 'Đặt hàng thành công')

@section('content')
<div class="container my-5 text-center">
    <div class="py-5">
        {{-- Toast notification sẽ được hiển thị tự động từ layout --}}
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <strong>Đặt hàng thành công!</strong><br>
            Cảm ơn bạn đã mua hàng. Mã đơn hàng của bạn là #{{ $order->id }}. Chúng tôi sẽ sớm liên hệ với bạn để xác nhận đơn hàng.
        </div>
        
        <div class="mt-4">
            @include('components.customer.button', [
                'type' => 'primary',
                'size' => 'lg',
                'href' => route('products.index'),
                'text' => '<i class="fas fa-shopping-bag me-2"></i>Tiếp tục mua sắm'
            ])
        </div>
    </div>
</div>
@endsection