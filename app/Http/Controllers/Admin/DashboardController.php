<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Thống kê tổng quan
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        $totalOrders = Order::count();
        $totalCustomers = User::where('role', 'user')->count();

        // Lấy 5 đơn hàng mới nhất
        $latestOrders = Order::with('user')->latest()->take(5)->get();

        // Dữ liệu cho biểu đồ (Ví dụ: Doanh thu 7 ngày gần nhất)
        // Lưu ý: Phần này sẽ phức tạp hơn và cần thư viện biểu đồ, tạm thời chúng ta sẽ chuẩn bị dữ liệu
        $salesData = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
                            ->where('created_at', '>=', Carbon::now()->subDays(7))
                            ->groupBy('date')
                            ->orderBy('date', 'asc')
                            ->pluck('total', 'date');

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'totalCustomers',
            'latestOrders',
            'salesData'
        ));
    }
}