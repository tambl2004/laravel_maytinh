<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request, Product $product)
    {
        // 1. Lấy giỏ hàng hiện tại từ session, nếu chưa có thì tạo mảng rỗng
        $cart = session()->get('cart', []);

        // 2. Lấy số lượng từ form, mặc định là 1
        $quantity = $request->input('quantity', 1);

        // 3. Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        if (isset($cart[$product->id])) {
            // Nếu đã có, cộng dồn số lượng
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            // Nếu chưa có, thêm mới vào giỏ hàng với các thông tin cần thiết
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        // 4. Lưu giỏ hàng mới vào lại session
        session()->put('cart', $cart);

        // 5. Quay lại trang trước đó với một thông báo thành công
        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }
    public function index()
{
    // Lấy dữ liệu giỏ hàng từ session
    $cart = session()->get('cart', []);

    // Trả về view và truyền dữ liệu giỏ hàng qua
    return view('cart.index', ['cart' => $cart]);
}
}