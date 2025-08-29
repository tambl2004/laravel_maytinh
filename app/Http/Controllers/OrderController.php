<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Hiển thị danh sách đơn hàng của user đang đăng nhập
    public function index()
    {
        $orders = Auth::user()->orders()->withCount('items')->latest()->paginate(10);
        return view('customer.orders.index', compact('orders'));
    }

    // Hiển thị chi tiết một đơn hàng
    public function show(Order $order)
    {
        // Chính sách bảo mật: Đảm bảo user chỉ xem được đơn hàng của chính mình
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        return view('customer.orders.show', compact('order'));
    }
}