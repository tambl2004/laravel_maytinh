<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        return view('customer.cart.index', compact('cart'));
    }

    public function add(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
        $quantity = $request->input('quantity', 1);

        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->price,
                "image" => $product->image
            ];
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    // --- HÀM MỚI: Cập nhật số lượng ---
    public function update(Request $request, Product $product)
    {
        $cart = session()->get('cart');
        $quantity = $request->input('quantity');

        if(isset($cart[$product->id]) && $quantity > 0) {
            $cart[$product->id]['quantity'] = $quantity;
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được cập nhật!');
        }
        return redirect()->route('cart.index')->with('error', 'Cập nhật giỏ hàng thất bại!');
    }

    // --- HÀM MỚI: Xóa sản phẩm ---
    public function remove(Product $product)
    {
        $cart = session()->get('cart');
        if(isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
        }
        return redirect()->route('cart.index')->with('error', 'Xóa sản phẩm thất bại!');
    }
}