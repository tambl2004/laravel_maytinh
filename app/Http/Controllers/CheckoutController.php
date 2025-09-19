<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address; // Thêm model Address
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        $addresses = Auth::user()->addresses()->latest()->get();

        // Luôn hiển thị trang checkout, không chuyển hướng nữa
        return view('customer.checkout.index', compact('cart', 'addresses'));
    }

    public function store(Request $request)
    {
        // Validate rằng người dùng đã chọn một địa chỉ
        try {
            $request->validate([
                'address_id' => 'required|exists:addresses,id',
                'payment_method' => 'required|in:cod,momo'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson() || $request->ajax() || $request->wantsJson() || $request->header('Accept') === 'application/json') {
                return response()->json([
                    'success' => false,
                    'message' => 'Dữ liệu không hợp lệ: ' . $e->getMessage(),
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }

        $cart = session()->get('cart', []);
        $address = Address::find($request->address_id);

        // Đảm bảo địa chỉ được chọn thuộc về user đang đăng nhập
        if ($address->user_id !== Auth::id()) {
            abort(403, 'Hành động không được phép.');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        DB::beginTransaction();
        try {
            // Tạo đơn hàng với thông tin từ địa chỉ đã chọn
            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $address->name,
                'customer_email' => Auth::user()->email,
                'customer_phone' => $address->phone,
                'customer_address' => $address->address,
                'total_amount' => $total,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'momo' ? 'pending' : 'pending'
            ]);

            foreach ($cart as $id => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'product_name' => $details['name'],
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                ]);
            }

            DB::commit();
            session()->forget('cart');

            // Handle different payment methods
            if ($request->payment_method === 'momo') {
                // Return JSON for MoMo payment (for AJAX requests)
                if ($request->expectsJson() || $request->ajax() || $request->wantsJson() || $request->header('Accept') === 'application/json') {
                    return response()->json([
                        'success' => true,
                        'order_id' => $order->id,
                        'message' => 'Đơn hàng đã được tạo thành công'
                    ]);
                }
                // Fallback redirect for non-AJAX requests
                return redirect()->route('orders.show', $order->id)
                    ->with('info', 'Đơn hàng đã được tạo. Vui lòng hoàn tất thanh toán MoMo.');
            } else {
                // COD payment - redirect to success page
                return redirect()->route('checkout.success', $order);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log the error for debugging
            \Log::error('Checkout Error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'payment_method' => $request->payment_method ?? 'unknown',
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($request->expectsJson() || $request->ajax() || $request->wantsJson() || $request->header('Accept') === 'application/json') {
                return response()->json([
                    'success' => false,
                    'message' => 'Đã có lỗi xảy ra khi tạo đơn hàng. Vui lòng thử lại.'
                ], 500);
            }
            
            return back()->with('error', 'Đã có lỗi xảy ra, vui lòng thử lại.');
        }
    }

    public function success(Order $order)
    {
        return view('customer.checkout.success', compact('order'));
    }
}