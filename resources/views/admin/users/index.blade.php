@extends('layouts.admin.app')

@section('title', 'Quản lý người dùng')
@section('page-title', 'Quản lý người dùng')
@section('page-subtitle', 'Quản lý tài khoản và phân quyền người dùng')

@section('content')
<!-- Header Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-1">Người dùng hệ thống</h2>
        <p class="text-muted mb-0">Quản lý tài khoản và phân quyền người dùng</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-admin-primary">
        <i class="fas fa-user-plus me-2"></i>Thêm người dùng mới
    </a>
</div>

{{-- Toast notifications sẽ được hiển thị tự động từ layout --}}

<!-- Stats Cards -->
<div class="stats-grid">
    @include('components.admin.stat-card', [
        'type' => 'primary',
        'value' => $users->total(),
        'label' => 'Tổng người dùng',
        'icon' => 'fas fa-users'
    ])
    
    @include('components.admin.stat-card', [
        'type' => 'success',
        'value' => $users->where('email_verified_at', '!=', null)->count(),
        'label' => 'Đã xác thực',
        'icon' => 'fas fa-user-check'
    ])
    
    @include('components.admin.stat-card', [
        'type' => 'warning',
        'value' => $users->where('email_verified_at', null)->count(),
        'label' => 'Chờ xác thực',
        'icon' => 'fas fa-user-clock'
    ])
    
    @include('components.admin.stat-card', [
        'type' => 'danger',
        'value' => $users->where('role', 'admin')->count(),
        'label' => 'Administrator',
        'icon' => 'fas fa-crown'
    ])
</div>

<!-- Users Table -->
<div class="admin-card">
    <div class="admin-card-header">
        <h5 class="admin-card-title">
            <i class="fas fa-users me-2"></i>
            Danh sách người dùng
        </h5>
    </div>
    <div class="admin-card-body p-0">
        @if($users->count() > 0)
            <div class="admin-table">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="border-0">ID</th>
                            <th class="border-0">Thông tin</th>
                            <th class="border-0">Email</th>
                            <th class="border-0">Vai trò</th>
                            <th class="border-0">Trạng thái</th>
                            <th class="border-0">Ngày tham gia</th>
                            <th class="border-0 text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <span class="badge bg-light text-dark">#{{ $user->id }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-3" style="width: 40px; height: 40px;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $user->name }}</div>
                                        <small class="text-muted">ID: {{ $user->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div class="fw-medium">{{ $user->email }}</div>
                                    @if($user->email_verified_at)
                                        <small class="text-success">
                                            <i class="fas fa-check-circle me-1"></i>Đã xác thực
                                        </small>
                                    @else
                                        <small class="text-warning">
                                            <i class="fas fa-exclamation-circle me-1"></i>Chưa xác thực
                                        </small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($user->role == 'admin')
                                    <span class="badge-admin bg-primary">
                                        <i class="fas fa-crown me-1"></i>Admin
                                    </span>
                                @else
                                    <span class="badge-admin bg-secondary">
                                        <i class="fas fa-user me-1"></i>Customer
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($user->email_verified_at)
                                    <span class="badge bg-success">Hoạt động</span>
                                @else
                                    <span class="badge bg-warning">Chờ xác thực</span>
                                @endif
                            </td>
                            <td>
                                <div>
                                    <div>{{ $user->created_at->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ $user->created_at->format('H:i') }}</small>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                       class="btn btn-sm btn-outline-primary" 
                                       title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" 
                                              method="POST" 
                                              class="d-inline" 
                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng này? Thao tác này không thể hoàn tác.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-sm btn-outline-secondary" disabled title="Không thể xóa chính mình">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <div class="empty-state">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Chưa có người dùng nào</h4>
                    <p class="text-muted mb-4">Hãy tạo người dùng đầu tiên để bắt đầu quản lý hệ thống</p>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-admin-primary">
                        <i class="fas fa-user-plus me-2"></i>Tạo người dùng đầu tiên
                    </a>
                </div>
            </div>
        @endif
    </div>
    
    @if($users->count() > 0)
        <div class="admin-card-body border-top">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Hiển thị {{ $users->firstItem() }} - {{ $users->lastItem() }} 
                    trong tổng số {{ $users->total() }} người dùng
                </div>
                <div>
                    {!! $users->links() !!}
                </div>
            </div>
        </div>
    @endif
</div>

@endsection