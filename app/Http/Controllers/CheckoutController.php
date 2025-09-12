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
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
        ]);

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
                'customer_email' => Auth::user()->email, // Lấy email từ user đang đăng nhập
                'customer_phone' => $address->phone,
                'customer_address' => $address->address,
                'total_amount' => $total,
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

            return redirect()->route('checkout.success', $order);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Đã có lỗi xảy ra, vui lòng thử lại.');
        }
    }

    public function success(Order $order)
    {
        return view('customer.checkout.success', compact('order'));
    }
}