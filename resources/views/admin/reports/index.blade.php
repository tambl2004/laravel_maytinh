@extends('layouts.admin.app')

@section('title', 'Báo cáo thống kê')
@section('page-title', 'Báo cáo thống kê')
@section('page-subtitle', 'Phân tích dữ liệu và hiệu suất kinh doanh')

@section('content')
<!-- Period Filter -->
<div class="admin-card mb-4">
    <div class="admin-card-body">
        <form method="GET" action="{{ route('admin.reports.index') }}" class="row align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold">Khoảng thời gian</label>
                <select name="period" class="form-select" onchange="this.form.submit()">
                    <option value="7" {{ $period == '7' ? 'selected' : '' }}>7 ngày qua</option>
                    <option value="30" {{ $period == '30' ? 'selected' : '' }}>30 ngày qua</option>
                    <option value="90" {{ $period == '90' ? 'selected' : '' }}>90 ngày qua</option>
                    <option value="365" {{ $period == '365' ? 'selected' : '' }}>1 năm qua</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-admin-primary">
                    <i class="fas fa-filter me-2"></i>Lọc dữ liệu
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Stats Overview -->
<div class="stats-grid mb-4">
    <div class="stat-card primary">
        <div class="stat-icon primary">
            <i class="fas fa-dollar-sign"></i>
        </div>
        <div class="stat-value">{{ number_format($totalRevenue, 0, ',', '.') }}₫</div>
        <div class="stat-label">Doanh thu {{ $period }} ngày qua</div>
    </div>
    
    <div class="stat-card success">
        <div class="stat-icon success">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div class="stat-value">{{ $totalOrders }}</div>
        <div class="stat-label">Tổng đơn hàng</div>
    </div>
    
    <div class="stat-card warning">
        <div class="stat-icon warning">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-value">{{ $totalCustomers }}</div>
        <div class="stat-label">Khách hàng</div>
    </div>
    
    <div class="stat-card danger">
        <div class="stat-icon danger">
            <i class="fas fa-laptop"></i>
        </div>
        <div class="stat-value">{{ $totalProducts }}</div>
        <div class="stat-label">Sản phẩm</div>
    </div>
</div>

<!-- Charts Section -->
<div class="row mb-4">
    <!-- Revenue & Orders Chart -->
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5 class="admin-card-title">
                    <i class="fas fa-chart-line me-2"></i>
                    Biểu đồ doanh thu và đơn hàng
                </h5>
            </div>
            <div class="admin-card-body">
                <canvas id="revenueChart" height="100"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Order Status Chart -->
    <div class="col-lg-4">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5 class="admin-card-title">
                    <i class="fas fa-chart-pie me-2"></i>
                    Trạng thái đơn hàng
                </h5>
            </div>
            <div class="admin-card-body">
                <canvas id="statusChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Category Revenue Chart -->
<div class="row mb-4">
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5 class="admin-card-title">
                    <i class="fas fa-chart-bar me-2"></i>
                    Doanh thu theo danh mục
                </h5>
            </div>
            <div class="admin-card-body">
                <canvas id="categoryChart" height="200"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Top Products -->
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5 class="admin-card-title">
                    <i class="fas fa-trophy me-2"></i>
                    Top sản phẩm bán chạy
                </h5>
            </div>
            <div class="admin-card-body">
                @if($topProducts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Đã bán</th>
                                    <th>Doanh thu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topProducts->take(5) as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" 
                                                     class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                                <div>
                                                    <div class="fw-semibold">{{ Str::limit($product['name'], 25) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $product['sold'] }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ number_format($product['revenue'], 0, ',', '.') }}₫</strong>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-chart-bar fa-2x mb-2"></i>
                        <div>Chưa có dữ liệu bán hàng</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Detailed Stats -->
<div class="row">
    <!-- Daily Revenue Table -->
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5 class="admin-card-title">
                    <i class="fas fa-calendar-day me-2"></i>
                    Doanh thu theo ngày
                </h5>
            </div>
            <div class="admin-card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Ngày</th>
                                <th>Doanh thu</th>
                                <th>Đơn hàng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(array_slice($dailyStats, -7) as $stat)
                                <tr>
                                    <td>{{ $stat['date'] }}</td>
                                    <td>
                                        <strong class="text-success">
                                            {{ number_format($stat['revenue'], 0, ',', '.') }}₫
                                        </strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $stat['orders'] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Category Stats -->
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5 class="admin-card-title">
                    <i class="fas fa-tags me-2"></i>
                    Thống kê danh mục
                </h5>
            </div>
            <div class="admin-card-body">
                @if($categoryStats->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Danh mục</th>
                                    <th>Sản phẩm</th>
                                    <th>Doanh thu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categoryStats as $category)
                                    <tr>
                                        <td>
                                            <span class="fw-semibold">{{ $category['name'] }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $category['products_count'] }}</span>
                                        </td>
                                        <td>
                                            <strong class="text-success">
                                                {{ number_format($category['revenue'], 0, ',', '.') }}₫
                                            </strong>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-tags fa-2x mb-2"></i>
                        <div>Chưa có dữ liệu danh mục</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.js"></script>
<script>
// Suppress console errors from browser extensions
window.addEventListener('error', function(e) {
    if (e.filename && e.filename.includes('share-modal.js')) {
        e.preventDefault();
        return false;
    }
});

// Wait for Chart.js to load
function waitForChart() {
    if (typeof Chart !== 'undefined') {
        initializeCharts();
    } else {
        setTimeout(waitForChart, 100);
    }
}

function initializeCharts() {
    console.log('Chart.js loaded successfully');
    
    // Get data from PHP
    const dailyStats = {!! json_encode($dailyStats) !!};
    const categoryStats = {!! json_encode($categoryStats) !!};
    const orderStatusStats = {!! json_encode($orderStatusStats) !!};
    
    console.log('Daily stats:', dailyStats);
    console.log('Category stats:', categoryStats);
    console.log('Order status stats:', orderStatusStats);
    
    // Chart colors
    const colors = {
        primary: '#2563eb',
        success: '#10b981',
        warning: '#f59e0b',
        danger: '#ef4444',
        info: '#06b6d4',
        purple: '#8b5cf6'
    };

    // Create Revenue Chart
    createRevenueChart(dailyStats);
    
    // Create Status Chart
    createStatusChart(orderStatusStats);
    
    // Create Category Chart
    createCategoryChart(categoryStats);
}

function createRevenueChart(dailyStats) {
    const canvas = document.getElementById('revenueChart');
    if (!canvas) {
        console.error('Revenue chart canvas not found');
        return;
    }
    
    const labels = dailyStats.map(item => item.date);
    const revenueData = dailyStats.map(item => item.revenue);
    const ordersData = dailyStats.map(item => item.orders);
    
    console.log('Creating revenue chart with data:', { labels, revenueData, ordersData });
    
    new Chart(canvas, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Doanh thu (₫)',
                data: revenueData,
                borderColor: '#2563eb',
                backgroundColor: '#2563eb20',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }, {
                label: 'Số đơn hàng',
                data: ordersData,
                borderColor: '#10b981',
                backgroundColor: '#10b98120',
                borderWidth: 2,
                fill: false,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });
}

function createStatusChart(orderStatusStats) {
    const canvas = document.getElementById('statusChart');
    if (!canvas) {
        console.error('Status chart canvas not found');
        return;
    }
    
    const labels = orderStatusStats.map(item => item.status);
    const data = orderStatusStats.map(item => item.count);
    
    console.log('Creating status chart with data:', { labels, data });
    
    new Chart(canvas, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: ['#f59e0b', '#06b6d4', '#10b981', '#ef4444'],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}

function createCategoryChart(categoryStats) {
    const canvas = document.getElementById('categoryChart');
    if (!canvas) {
        console.error('Category chart canvas not found');
        return;
    }
    
    const labels = categoryStats.map(item => item.name);
    const data = categoryStats.map(item => item.revenue);
    
    console.log('Creating category chart with data:', { labels, data });
    
    new Chart(canvas, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Doanh thu (₫)',
                data: data,
                backgroundColor: ['#2563eb', '#10b981', '#f59e0b', '#ef4444', '#06b6d4', '#8b5cf6'],
                borderWidth: 0,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
}

// Start the process
document.addEventListener('DOMContentLoaded', function() {
    waitForChart();
});
</script>
@endsection
