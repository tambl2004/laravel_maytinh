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
        // Check if product is in stock
        if ($product->stock <= 0) {
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm đã hết hàng!'
                ]);
            }
            return redirect()->back()->with('error', 'Sản phẩm đã hết hàng!');
        }

        $cart = session()->get('cart', []);
        $quantity = $request->input('quantity', 1);

        // Check if adding this quantity would exceed stock
        $currentQuantity = isset($cart[$product->id]) ? $cart[$product->id]['quantity'] : 0;
        if (($currentQuantity + $quantity) > $product->stock) {
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số lượng vượt quá tồn kho!'
                ]);
            }
            return redirect()->back()->with('error', 'Số lượng vượt quá tồn kho!');
        }

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
        
        // Calculate cart count
        $cartCount = array_sum(array_column($cart, 'quantity'));
        
        if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã thêm sản phẩm vào giỏ hàng!',
                'cartCount' => $cartCount,
                'product' => [
                    'name' => $product->name,
                    'price' => number_format($product->price, 0, ',', '.') . '₫'
                ]
            ]);
        }
        
        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    // --- HÀM MỚI: Cập nhật số lượng ---
    public function update(Request $request, Product $product)
    {
        $cart = session()->get('cart');
        $quantity = (int) $request->input('quantity');

        if(isset($cart[$product->id]) && $quantity > 0) {
            // Không cho vượt quá tồn kho
            if ($quantity > $product->stock) {
                if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                    return response()->json(['success' => false, 'message' => 'Số lượng vượt quá tồn kho!']);
                }
                return redirect()->route('cart.index')->with('error', 'Số lượng vượt quá tồn kho!');
            }

            $cart[$product->id]['quantity'] = $quantity;
            session()->put('cart', $cart);

            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Giỏ hàng đã được cập nhật!']);
            }
            return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được cập nhật!');
        }

        if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
            return response()->json(['success' => false, 'message' => 'Cập nhật giỏ hàng thất bại!']);
        }
        return redirect()->route('cart.index')->with('error', 'Cập nhật giỏ hàng thất bại!');
    }

    // --- HÀM MỚI: Xóa sản phẩm ---
    public function remove(Request $request, Product $product)
    {
        $cart = session()->get('cart');
        if(isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);

            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Đã xóa sản phẩm khỏi giỏ hàng!']);
            }
            return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
        }
        if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
            return response()->json(['success' => false, 'message' => 'Xóa sản phẩm thất bại!']);
        }
        return redirect()->route('cart.index')->with('error', 'Xóa sản phẩm thất bại!');
    }
}