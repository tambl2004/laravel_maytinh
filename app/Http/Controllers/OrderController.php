<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    // Hủy đơn hàng
    public function cancel(Order $order)
    {
        // Chính sách bảo mật: Đảm bảo user chỉ hủy được đơn hàng của chính mình
        if ($order->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền hủy đơn hàng này.'
            ], 403);
        }

        // Chỉ cho phép hủy đơn hàng có trạng thái 'pending'
        if ($order->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Chỉ có thể hủy đơn hàng đang chờ xử lý.'
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Cập nhật trạng thái đơn hàng thành 'cancelled'
            $order->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancel_reason' => 'Khách hàng hủy đơn hàng'
            ]);

            // Khôi phục số lượng tồn kho cho các sản phẩm trong đơn hàng
            foreach ($order->items as $item) {
                $product = $item->product;
                if ($product) {
                    $product->increment('stock', $item->quantity);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Đơn hàng đã được hủy thành công!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi hủy đơn hàng. Vui lòng thử lại sau.'
            ], 500);
        }
    }
}