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
        $cart = session()->get('selected_cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Vui lòng chọn sản phẩm để thanh toán!');
        }

        $addresses = Auth::user()->addresses()->latest()->get();

        // Luôn hiển thị trang checkout, không chuyển hướng nữa
        return view('customer.checkout.index', compact('cart', 'addresses'));
    }

    public function store(Request $request)
    {
        try {
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

        $cart = session()->get('selected_cart', []);
        if (empty($cart)) {
            if ($request->expectsJson() || $request->ajax() || $request->wantsJson() || $request->header('Accept') === 'application/json') {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có sản phẩm nào được chọn để thanh toán!'
                ], 400);
            }
            return redirect()->route('cart.index')->with('error', 'Không có sản phẩm nào được chọn để thanh toán!');
        }
        
        $address = Address::find($request->address_id);

        // Đảm bảo địa chỉ được chọn thuộc về user đang đăng nhập
        if ($address->user_id !== Auth::id()) {
            abort(403, 'Hành động không được phép.');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Handle different payment methods
        if ($request->payment_method === 'momo') {
            // For MoMo payment, store order data in session and return order info for payment processing
            $orderData = [
                'user_id' => Auth::id(),
                'customer_name' => $address->name,
                'customer_email' => Auth::user()->email,
                'customer_phone' => $address->phone,
                'customer_address' => $address->address,
                'total_amount' => $total,
                'payment_method' => 'momo',
                'payment_status' => 'pending',
                'status' => 'pending',
                'items' => $cart
            ];
            
            // Store order data in session for MoMo payment processing
            session()->put('pending_order', $orderData);
            
            // Return JSON for MoMo payment (for AJAX requests)
            if ($request->expectsJson() || $request->ajax() || $request->wantsJson() || $request->header('Accept') === 'application/json') {
                return response()->json([
                    'success' => true,
                    'order_data' => $orderData,
                    'message' => 'Dữ liệu đơn hàng đã được chuẩn bị. Vui lòng hoàn tất thanh toán MoMo.'
                ]);
            }
            // Fallback redirect for non-AJAX requests
            return redirect()->route('checkout.index')
                ->with('info', 'Dữ liệu đơn hàng đã được chuẩn bị. Vui lòng hoàn tất thanh toán MoMo.');
        } else {
            // COD payment - create order immediately
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
                    'payment_method' => 'cod',
                    'payment_status' => 'pending',
                    'status' => 'pending'
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
                
                // Xóa sản phẩm đã thanh toán khỏi giỏ hàng chính
                $mainCart = session()->get('cart', []);
                foreach ($cart as $id => $details) {
                    if (isset($mainCart[$id])) {
                        unset($mainCart[$id]);
                    }
                }
                session()->put('cart', $mainCart);
                session()->forget('selected_cart');

                // COD payment - redirect to success page
                return redirect()->route('checkout.success', $order);
                
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }
    } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Checkout Error: ' . $e->getMessage(), [
            'user_id' => Auth::id(),
            'payment_method' => $request->payment_method ?? 'unknown',
            'trace' => $e->getTraceAsString()
        ]);
        
        if ($request->expectsJson() || $request->ajax() || $request->wantsJson() || $request->header('Accept') === 'application/json') {
            return response()->json([
                'success' => false,
                'message' => 'Đã có lỗi xảy ra khi xử lý đơn hàng. Vui lòng thử lại.'
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
