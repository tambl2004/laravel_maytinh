@extends('layouts.customer')
@section('title', 'Liên hệ')
@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center mb-4">Liên hệ với chúng tôi</h1>
            <p class="text-center text-muted mb-5">Nếu bạn có bất kỳ câu hỏi nào, đừng ngần ngại gửi tin nhắn cho chúng tôi.</p>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-body p-4">
                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        <div class="mb-3"><input class="form-control" type="text" name="name" placeholder="Họ và Tên" required></div>
                        <div class="mb-3"><input class="form-control" type="email" name="email" placeholder="Email" required></div>
                        <div class="mb-3"><input class="form-control" type="text" name="subject" placeholder="Chủ đề" required></div>
                        <div class="mb-3"><textarea class="form-control" name="message" rows="6" placeholder="Nội dung tin nhắn" required></textarea></div>
                        <div><button class="btn btn-primary w-100" type="submit">Gửi tin nhắn</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection