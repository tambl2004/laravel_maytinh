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
            <div class="admin-card-header d-flex justify-content-between align-items-center">
                <h5 class="admin-card-title">
                    <i class="fas fa-chart-line me-2"></i>
                    Biểu đồ doanh thu và đơn hàng
                </h5>
                <div class="btn-group" role="group">
                    <input type="radio" class="btn-check" name="chartFilter" id="daily" value="daily" checked>
                    <label class="btn btn-outline-primary btn-sm" for="daily">Theo ngày</label>
                    
                    <input type="radio" class="btn-check" name="chartFilter" id="weekly" value="weekly">
                    <label class="btn btn-outline-primary btn-sm" for="weekly">Theo tuần</label>
                    
                    <input type="radio" class="btn-check" name="chartFilter" id="monthly" value="monthly">
                    <label class="btn btn-outline-primary btn-sm" for="monthly">Theo tháng</label>
                </div>
            </div>
            <div class="admin-card-body">
                <div id="revenueChart" class="chart-container"></div>
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
                <div id="statusChart" class="chart-container"></div>
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
                <div id="categoryChart" class="chart-container"></div>
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
<style>
/* CSS-based Chart Styles */
.chart-container {
    background: white;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    border: 1px solid #e5e7eb;
}

.bar-chart {
    display: flex;
    align-items: end;
    height: 200px;
    gap: 10px;
    padding: 20px 0;
}

.bar {
    background: linear-gradient(180deg, #3b82f6, #1e40af);
    border-radius: 6px 6px 0 0;
    min-width: 30px;
    position: relative;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
}

.bar:hover {
    opacity: 0.8;
    transform: translateY(-4px) scale(1.05);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
}

.bar-label {
    position: absolute;
    bottom: -25px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 11px;
    color: #666;
    width: 60px;
    text-align: center;
    font-weight: 500;
}

.bar-value {
    position: absolute;
    top: -25px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 11px;
    color: #333;
    font-weight: bold;
    white-space: nowrap;
}

.line-chart {
    position: relative;
    height: 200px;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-radius: 8px;
    padding: 20px;
    border: 1px solid #e2e8f0;
}

.line-chart svg {
    width: 100%;
    height: 100%;
}

.doughnut-chart {
    position: relative;
    width: 200px;
    height: 200px;
    margin: 0 auto;
}

.doughnut-chart svg {
    width: 100%;
    height: 100%;
    filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
}

.chart-legend {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    justify-content: center;
    margin-top: 15px;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 500;
    color: #374151;
    padding: 4px 8px;
    border-radius: 6px;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
}

.legend-color {
    width: 14px;
    height: 14px;
    border-radius: 3px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-item {
    background: white;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    text-align: center;
    border: 1px solid #e5e7eb;
    transition: all 0.2s ease;
}

.stat-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 16px -4px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.stat-value {
    font-size: 28px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 8px;
}

.stat-label {
    color: #6b7280;
    font-size: 14px;
    font-weight: 500;
}

.chart-title {
    font-size: 18px;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 20px;
    text-align: center;
    letter-spacing: -0.025em;
}

.no-data {
    text-align: center;
    color: #9ca3af;
    padding: 60px 20px;
    font-style: italic;
    font-size: 16px;
    background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
    border-radius: 8px;
    border: 2px dashed #d1d5db;
}

/* Filter Buttons Enhancement */
.btn-group .btn-outline-primary {
    border-color: #e5e7eb;
    color: #6b7280;
    font-weight: 500;
    font-size: 13px;
    transition: all 0.2s ease;
}

.btn-group .btn-outline-primary:hover {
    background-color: #f3f4f6;
    border-color: #d1d5db;
    color: #374151;
}

.btn-group .btn-check:checked + .btn-outline-primary {
    background-color: #3b82f6;
    border-color: #3b82f6;
    color: white;
    box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing custom charts...');
    
    // Get data from PHP
    const dailyStats = {!! json_encode($dailyStats ?? []) !!};
    const categoryStats = {!! json_encode($categoryStats ?? []) !!};
    const orderStatusStats = {!! json_encode($orderStatusStats ?? []) !!};
    
    console.log('Chart data:', { dailyStats, categoryStats, orderStatusStats });
    
    // Create charts
    createRevenueLineChart(dailyStats);
    createStatusDoughnutChart(orderStatusStats);
    createCategoryBarChart(categoryStats);
});

function createRevenueLineChart(data) {
    const container = document.getElementById('revenueChart');
    if (!container) return;
    
    if (!data || data.length === 0) {
        container.innerHTML = '<div class="no-data">Chưa có dữ liệu doanh thu</div>';
        return;
    }
    
    // Store original data for filtering
    window.originalRevenueData = data;
    
    // Initialize with daily view
    updateRevenueChart('daily');
    
    // Add event listeners for filter buttons
    document.querySelectorAll('input[name="chartFilter"]').forEach(radio => {
        radio.addEventListener('change', function() {
            updateRevenueChart(this.value);
        });
    });
}

function updateRevenueChart(filterType) {
    const container = document.getElementById('revenueChart');
    const data = window.originalRevenueData;
    
    if (!data || !container) return;
    
    let processedData = processDataByFilter(data, filterType);
    renderSimpleChart(container, processedData, filterType);
}

function processDataByFilter(data, filterType) {
    if (filterType === 'daily') {
        return data.slice(-7); // Show last 7 days
    } else if (filterType === 'weekly') {
        // Group by week (Monday to Sunday)
        const weeks = {};
        data.forEach(item => {
            // Parse Vietnamese date format (dd/mm)
            const [day, month] = item.date.split('/');
            const currentYear = new Date().getFullYear();
            const date = new Date(currentYear, parseInt(month) - 1, parseInt(day));
            
            // Get Monday of the week
            const dayOfWeek = date.getDay();
            const mondayOffset = dayOfWeek === 0 ? -6 : 1 - dayOfWeek; // Handle Sunday as 0
            const monday = new Date(date);
            monday.setDate(date.getDate() + mondayOffset);
            
            const weekKey = monday.toISOString().split('T')[0];
            
            if (!weeks[weekKey]) {
                weeks[weekKey] = { revenue: 0, orders: 0, count: 0, startDate: monday };
            }
            weeks[weekKey].revenue += parseFloat(item.revenue || 0);
            weeks[weekKey].orders += parseInt(item.orders || 0);
            weeks[weekKey].count++;
        });
        
        return Object.entries(weeks)
            .sort(([a], [b]) => new Date(a) - new Date(b))
            .map(([weekKey, values]) => {
                const startDate = values.startDate;
                const endDate = new Date(startDate);
                endDate.setDate(startDate.getDate() + 6);
                
                return {
                    date: `${startDate.getDate()}/${startDate.getMonth() + 1} - ${endDate.getDate()}/${endDate.getMonth() + 1}`,
                    revenue: values.revenue,
                    orders: values.orders
                };
            })
            .slice(-4); // Show last 4 weeks
    } else if (filterType === 'monthly') {
        // Group by month
        const months = {};
        data.forEach(item => {
            // Parse Vietnamese date format (dd/mm)
            const [day, month] = item.date.split('/');
            const currentYear = new Date().getFullYear();
            const monthKey = `${currentYear}-${month.padStart(2, '0')}`;
            
            if (!months[monthKey]) {
                months[monthKey] = { revenue: 0, orders: 0, count: 0, month: parseInt(month) };
            }
            months[monthKey].revenue += parseFloat(item.revenue || 0);
            months[monthKey].orders += parseInt(item.orders || 0);
            months[monthKey].count++;
        });
        
        const monthNames = [
            'T1', 'T2', 'T3', 'T4', 'T5', 'T6',
            'T7', 'T8', 'T9', 'T10', 'T11', 'T12'
        ];
        
        return Object.entries(months)
            .sort(([a], [b]) => a.localeCompare(b))
            .map(([monthKey, values]) => {
                const monthNum = parseInt(monthKey.split('-')[1]);
                return {
                    date: monthNames[monthNum - 1] + '/' + monthKey.split('-')[0].slice(-2),
                    revenue: values.revenue,
                    orders: values.orders
                };
            })
            .slice(-6); // Show last 6 months
    }
    return data;
}

function renderSimpleChart(container, data, filterType) {
    const maxRevenue = Math.max(...data.map(d => d.revenue));
    const maxOrders = Math.max(...data.map(d => d.orders));
    
    let periodText = {
        'daily': 'theo Ngày',
        'weekly': 'theo Tuần', 
        'monthly': 'theo Tháng'
    }[filterType];
    
    // Calculate chart dimensions based on data length
    const itemWidth = Math.min(80, Math.max(40, 400 / data.length));
    const chartHeight = 180;
    
    let html = `
        <div class="chart-title" style="font-size: 16px; font-weight: 600; color: #374151; margin-bottom: 20px;">Doanh thu ${periodText}</div>
        <div style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-radius: 12px; padding: 24px; margin: 20px 0; border: 1px solid #e2e8f0;">
            <div style="display: flex; align-items: end; height: ${chartHeight}px; gap: ${Math.max(8, (600 - data.length * itemWidth) / data.length)}px; justify-content: center; padding-bottom: 30px; overflow-x: auto;">`;
    
    data.forEach((item, index) => {
        const revenueHeight = Math.max((item.revenue / maxRevenue) * (chartHeight - 40), 8);
        const isHighValue = item.revenue > maxRevenue * 0.7;
        
        html += `
            <div style="display: flex; flex-direction: column; align-items: center; min-width: ${itemWidth}px; max-width: ${itemWidth}px;">
                <!-- Revenue Column -->
                <div style="
                    width: ${Math.max(32, itemWidth - 16)}px;
                    height: ${revenueHeight}px;
                    background: ${isHighValue ? 
                        'linear-gradient(to top, #059669, #10b981, #34d399)' : 
                        'linear-gradient(to top, #2563eb, #3b82f6, #60a5fa)'};
                    border-radius: 6px 6px 2px 2px;
                    cursor: pointer;
                    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                    position: relative;
                " 
                onmouseover="
                    this.style.transform='translateY(-4px) scale(1.02)';
                    this.style.boxShadow='0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)';
                    this.nextElementSibling.style.opacity='1';
                "
                onmouseout="
                    this.style.transform='translateY(0) scale(1)';
                    this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)';
                    this.nextElementSibling.style.opacity='0';
                ">
                </div>
                
                <!-- Value tooltip -->
                <div style="
                    position: absolute;
                    background: #1f2937;
                    color: white;
                    padding: 8px 12px;
                    border-radius: 6px;
                    font-size: 12px;
                    font-weight: 500;
                    white-space: nowrap;
                    opacity: 0;
                    transition: opacity 0.2s ease;
                    pointer-events: none;
                    transform: translateY(-${revenueHeight + 50}px);
                    z-index: 10;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                ">
                    <div>${formatCurrency(item.revenue)}</div>
                    <div style="color: #9ca3af; font-size: 10px;">${item.orders} đơn hàng</div>
                    <div style="position: absolute; bottom: -4px; left: 50%; transform: translateX(-50%); width: 0; height: 0; border-left: 4px solid transparent; border-right: 4px solid transparent; border-top: 4px solid #1f2937;"></div>
                </div>
                
                <!-- Label -->
                <div style="
                    font-size: 11px;
                    color: #6b7280;
                    text-align: center;
                    line-height: 1.3;
                    max-width: ${itemWidth}px;
                    word-wrap: break-word;
                    margin-top: 12px;
                    font-weight: 500;
                ">${item.date}</div>
            </div>`;
    });
    
    html += `
            </div>
            
            <!-- Enhanced Statistics Summary -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 16px; margin-top: 24px; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);">
                <div style="text-align: center; padding: 8px;">
                    <div style="font-size: 20px; font-weight: 700; color: #2563eb; margin-bottom: 4px;">${formatCurrencyShort(data.reduce((sum, item) => sum + item.revenue, 0))}</div>
                    <div style="font-size: 12px; color: #6b7280; font-weight: 500;">Tổng doanh thu</div>
                </div>
                <div style="text-align: center; padding: 8px;">
                    <div style="font-size: 20px; font-weight: 700; color: #059669; margin-bottom: 4px;">${data.reduce((sum, item) => sum + item.orders, 0)}</div>
                    <div style="font-size: 12px; color: #6b7280; font-weight: 500;">Tổng đơn hàng</div>
                </div>
                <div style="text-align: center; padding: 8px;">
                    <div style="font-size: 20px; font-weight: 700; color: #dc2626; margin-bottom: 4px;">${data.length > 0 ? formatCurrencyShort(data.reduce((sum, item) => sum + item.revenue, 0) / data.length) : '0₫'}</div>
                    <div style="font-size: 12px; color: #6b7280; font-weight: 500;">TB ${filterType === 'daily' ? '/ngày' : filterType === 'weekly' ? '/tuần' : '/tháng'}</div>
                </div>
                <div style="text-align: center; padding: 8px;">
                    <div style="font-size: 20px; font-weight: 700; color: #7c3aed; margin-bottom: 4px;">${data.length > 0 ? Math.round(data.reduce((sum, item) => sum + item.orders, 0) / data.length) : 0}</div>
                    <div style="font-size: 12px; color: #6b7280; font-weight: 500;">TB đơn hàng</div>
                </div>
            </div>
        </div>`;
    
    container.innerHTML = html;
}

function createStatusDoughnutChart(data) {
    const container = document.getElementById('statusChart');
    if (!container) return;
    
    const filteredData = data.filter(item => item.count > 0);
    
    if (!filteredData || filteredData.length === 0) {
        container.innerHTML = '<div class="no-data">Chưa có dữ liệu đơn hàng</div>';
        return;
    }
    
    const total = filteredData.reduce((sum, item) => sum + item.count, 0);
    const colors = ['#f59e0b', '#06b6d4', '#10b981', '#ef4444'];
    const statusMap = {
        'pending': 'Chờ xử lý',
        'processing': 'Đang xử lý',
        'completed': 'Hoàn thành',
        'cancelled': 'Đã hủy'
    };
    
    let currentAngle = 0;
    let svg = `
        <div class="chart-title">Phân bố Trạng thái Đơn hàng</div>
        <div class="doughnut-chart">
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">`;
    
    filteredData.forEach((item, index) => {
        const percentage = item.count / total;
        const angle = percentage * 360;
        const startAngle = currentAngle;
        const endAngle = currentAngle + angle;
        
        const x1 = 100 + 70 * Math.cos((startAngle - 90) * Math.PI / 180);
        const y1 = 100 + 70 * Math.sin((startAngle - 90) * Math.PI / 180);
        const x2 = 100 + 70 * Math.cos((endAngle - 90) * Math.PI / 180);
        const y2 = 100 + 70 * Math.sin((endAngle - 90) * Math.PI / 180);
        
        const largeArcFlag = angle > 180 ? 1 : 0;
        
        svg += `
            <path d="M 100 100 L ${x1} ${y1} A 70 70 0 ${largeArcFlag} 1 ${x2} ${y2} Z" 
                  fill="${colors[index % colors.length]}" 
                  stroke="white" 
                  stroke-width="2">
                <title>${statusMap[item.status.toLowerCase()] || item.status}: ${item.count} đơn (${(percentage * 100).toFixed(1)}%)</title>
            </path>`;
        
        currentAngle += angle;
    });
    
    svg += `
                <!-- Center circle -->
                <circle cx="100" cy="100" r="30" fill="white" stroke="#e5e7eb" stroke-width="2"/>
                <text x="100" y="95" text-anchor="middle" font-size="12" fill="#666">Tổng</text>
                <text x="100" y="110" text-anchor="middle" font-size="14" font-weight="bold" fill="#333">${total}</text>
            </svg>
        </div>
        <div class="chart-legend">`;
    
    filteredData.forEach((item, index) => {
        const percentage = (item.count / total * 100).toFixed(1);
        svg += `
            <div class="legend-item">
                <div class="legend-color" style="background: ${colors[index % colors.length]};"></div>
                <span>${statusMap[item.status.toLowerCase()] || item.status}: ${item.count} (${percentage}%)</span>
            </div>`;
    });
    
    svg += `</div>`;
    container.innerHTML = svg;
}

function createCategoryBarChart(data) {
    const container = document.getElementById('categoryChart');
    if (!container) return;
    
    const filteredData = data.filter(item => item.revenue > 0);
    
    if (!filteredData || filteredData.length === 0) {
        container.innerHTML = '<div class="no-data">Chưa có dữ liệu danh mục</div>';
        return;
    }
    
    const maxRevenue = Math.max(...filteredData.map(d => d.revenue));
    const colors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#06b6d4', '#8b5cf6'];
    
    let html = `
        <div class="chart-title">Doanh thu theo Danh mục</div>
        <div class="bar-chart">`;
    
    filteredData.forEach((item, index) => {
        const height = (item.revenue / maxRevenue) * 150;
        const color = colors[index % colors.length];
        
        html += `
            <div class="bar" 
                 style="height: ${height}px; background: ${color}; flex: 1;" 
                 title="${item.name}: ${formatCurrency(item.revenue)}">
                <div class="bar-value">${formatCurrency(item.revenue)}</div>
                <div class="bar-label">${truncateText(item.name, 8)}</div>
            </div>`;
    });
    
    html += `</div>`;
    container.innerHTML = html;
}

// Helper functions
function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
        minimumFractionDigits: 0
    }).format(amount).replace('₫', '') + '₫';
}

function formatCurrencyShort(amount) {
    if (amount >= 1000000000) {
        return (amount / 1000000000).toFixed(1) + 'B₫';
    } else if (amount >= 1000000) {
        return (amount / 1000000).toFixed(1) + 'M₫';
    } else if (amount >= 1000) {
        return (amount / 1000).toFixed(0) + 'K₫';
    }
    return amount.toLocaleString('vi-VN') + '₫';
}

function truncateText(text, maxLength) {
    if (text.length <= maxLength) return text;
    return text.substring(0, maxLength) + '...';
}

console.log('Custom charts initialized successfully');
</script>
@endsection
