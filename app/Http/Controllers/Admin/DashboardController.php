<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Thống kê tổng quan
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        $totalOrders = Order::count();
        $totalCustomers = User::where('role', 'user')->count(); // Fix: changed from 'customer' to 'user'
        $totalProducts = Product::count();

        // Thống kê hôm nay
        $todayOrders = Order::whereDate('created_at', Carbon::today())->count();
        $todayRevenue = Order::where('status', 'completed')
            ->whereDate('created_at', Carbon::today())
            ->sum('total_amount');

        // Lấy 5 đơn hàng mới nhất
        $latestOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'totalCustomers',
            'totalProducts',
            'todayOrders',
            'todayRevenue',
            'latestOrders'
        ));
    }
}