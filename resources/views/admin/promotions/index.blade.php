@extends('layouts.admin.app')

@section('title', 'Quản lý khuyến mãi')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Khuyến mãi</h4>
        <a href="{{ route('admin.promotions.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Tạo khuyến mãi</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Tên</th>
                            <th>Loại</th>
                            <th>Giá trị</th>
                            <th>Thời gian</th>
                            <th>Trạng thái</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($promotions as $promotion)
                        <tr>
                            <td>{{ $promotion->id }}</td>
                            <td class="fw-semibold">{{ $promotion->name }}</td>
                            <td>{{ $promotion->type === 'percent' ? 'Phần trăm' : 'Số tiền' }}</td>
                            <td>{{ $promotion->type === 'percent' ? $promotion->value . '%' : number_format($promotion->value, 0, ',', '.') . '₫' }}</td>
                            <td>{{ $promotion->start_date->format('d/m/Y') }} - {{ $promotion->end_date? $promotion->end_date->format('d/m/Y') : 'Không giới hạn' }}</td>
                            <td>
                                @if($promotion->isRunning())
                                    <span class="badge bg-success">Đang chạy</span>
                                @elseif($promotion->active)
                                    <span class="badge bg-warning text-dark">Chưa đến hạn</span>
                                @else
                                    <span class="badge bg-secondary">Tắt</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.promotions.edit', $promotion) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.promotions.destroy', $promotion) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa khuyến mãi này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center p-4 text-muted">Chưa có khuyến mãi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(method_exists($promotions, 'links'))
        <div class="card-footer">{{ $promotions->links() }}</div>
        @endif
    </div>
</div>
@endsection


