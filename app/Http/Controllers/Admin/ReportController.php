<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Hiển thị trang báo cáo thống kê
     */
    public function index(Request $request)
    {
        // Lấy tham số thời gian từ request
        $period = $request->get('period', '30'); // Mặc định 30 ngày
        $startDate = Carbon::now()->subDays($period);
        $endDate = Carbon::now();

        // Thống kê tổng quan
        $totalRevenue = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_amount');

        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])->count();
        $totalCustomers = User::where('role', 'user')->count(); // Fix: changed from 'customer' to 'user'
        $totalProducts = Product::count();

        // Thống kê theo ngày (cho biểu đồ)
        $dailyStats = $this->getDailyStats($startDate, $endDate);
        
        // Thống kê theo danh mục
        $categoryStats = $this->getCategoryStats($startDate, $endDate);
        
        // Thống kê trạng thái đơn hàng
        $orderStatusStats = $this->getOrderStatusStats($startDate, $endDate);
        
        // Top sản phẩm bán chạy
        $topProducts = $this->getTopProducts($startDate, $endDate);

        return view('admin.reports.index', compact(
            'totalRevenue',
            'totalOrders', 
            'totalCustomers',
            'totalProducts',
            'dailyStats',
            'categoryStats',
            'orderStatusStats',
            'topProducts',
            'period'
        ));
    }

    /**
     * Lấy thống kê theo ngày
     */
    private function getDailyStats($startDate, $endDate)
    {
        $stats = [];
        $current = $startDate->copy();

        while ($current->lte($endDate)) {
            $dayStart = $current->copy()->startOfDay();
            $dayEnd = $current->copy()->endOfDay();

            $revenue = Order::where('status', 'completed')
                ->whereBetween('created_at', [$dayStart, $dayEnd])
                ->sum('total_amount');

            $orders = Order::whereBetween('created_at', [$dayStart, $dayEnd])->count();

            $stats[] = [
                'date' => $current->format('d/m'),
                'revenue' => $revenue,
                'orders' => $orders
            ];

            $current->addDay();
        }

        return $stats;
    }

    /**
     * Lấy thống kê theo danh mục
     */
    private function getCategoryStats($startDate, $endDate)
    {
        return Category::withCount(['products' => function($query) use ($startDate, $endDate) {
            $query->whereHas('orderItems', function($q) use ($startDate, $endDate) {
                $q->whereHas('order', function($orderQuery) use ($startDate, $endDate) {
                    $orderQuery->whereBetween('created_at', [$startDate, $endDate]);
                });
            });
        }])
        ->with(['products' => function($query) use ($startDate, $endDate) {
            $query->whereHas('orderItems', function($q) use ($startDate, $endDate) {
                $q->whereHas('order', function($orderQuery) use ($startDate, $endDate) {
                    $orderQuery->whereBetween('created_at', [$startDate, $endDate]);
                });
            });
        }])
        ->get()
        ->map(function($category) {
            $totalRevenue = $category->products->sum(function($product) {
                return $product->orderItems->sum(function($item) {
                    return $item->quantity * $item->price;
                });
            });

            return [
                'name' => $category->name,
                'products_count' => $category->products_count,
                'revenue' => $totalRevenue
            ];
        });
    }

    /**
     * Lấy thống kê trạng thái đơn hàng
     */
    private function getOrderStatusStats($startDate, $endDate)
    {
        $statuses = ['pending', 'processing', 'completed', 'cancelled'];
        $stats = [];

        foreach ($statuses as $status) {
            $count = Order::where('status', $status)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();
            
            $stats[] = [
                'status' => ucfirst($status),
                'count' => $count
            ];
        }

        return $stats;
    }

    /**
     * Lấy top sản phẩm bán chạy
     */
    private function getTopProducts($startDate, $endDate)
    {
        return Product::withCount(['orderItems' => function($query) use ($startDate, $endDate) {
            $query->whereHas('order', function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            });
        }])
        ->with(['orderItems' => function($query) use ($startDate, $endDate) {
            $query->whereHas('order', function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            });
        }])
        ->orderBy('order_items_count', 'desc')
        ->limit(10)
        ->get()
        ->map(function($product) {
            $totalSold = $product->orderItems->sum('quantity');
            $totalRevenue = $product->orderItems->sum(function($item) {
                return $item->quantity * $item->price;
            });

            return [
                'name' => $product->name,
                'sold' => $totalSold,
                'revenue' => $totalRevenue,
                'image' => $product->image
            ];
        });
    }

    /**
     * API endpoint để lấy dữ liệu cho biểu đồ
     */
    public function getChartData(Request $request)
    {
        $period = $request->get('period', '30');
        $startDate = Carbon::now()->subDays($period);
        $endDate = Carbon::now();

        $dailyStats = $this->getDailyStats($startDate, $endDate);

        return response()->json([
            'labels' => collect($dailyStats)->pluck('date'),
            'revenue' => collect($dailyStats)->pluck('revenue'),
            'orders' => collect($dailyStats)->pluck('orders')
        ]);
    }
}
