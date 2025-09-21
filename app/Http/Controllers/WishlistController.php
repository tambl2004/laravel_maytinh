<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class WishlistController extends Controller
{
    // Hiển thị danh sách yêu thích từ session
    public function index(Request $request)
    {
        $wishlistIds = collect($request->session()->get('wishlist', []))->unique()->values();
        $products = Product::whereIn('id', $wishlistIds)->withCount(['approvedReviews as review_count'])
            ->withAvg('approvedReviews as average_rating', 'rating')->get();

        return view('customer.wishlist.index', compact('products'));
    }

    // Thêm sản phẩm vào yêu thích (session)
    public function add(Request $request, Product $product)
    {
        $wishlist = collect($request->session()->get('wishlist', []));
        
        // Kiểm tra xem sản phẩm đã có trong wishlist chưa
        if ($wishlist->contains($product->id)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Sản phẩm đã có trong danh sách yêu thích!'
                ]);
            }
            return back()->with('warning', 'Sản phẩm đã có trong danh sách yêu thích!');
        }
        
        $wishlist->push($product->id);
        $request->session()->put('wishlist', $wishlist->unique()->values()->all());

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true, 
                'message' => 'Đã thêm vào danh sách yêu thích!',
                'added' => true, 
                'count' => $wishlist->unique()->count()
            ]);
        }

        return back()->with('success', 'Đã thêm vào danh sách yêu thích!');
    }

    // Xóa sản phẩm khỏi yêu thích
    public function remove(Request $request, Product $product)
    {
        $wishlist = collect($request->session()->get('wishlist', []))
            ->reject(fn ($id) => (int)$id === (int)$product->id)
            ->values();
        $request->session()->put('wishlist', $wishlist->all());

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true, 
                'message' => 'Đã xóa khỏi danh sách yêu thích!',
                'removed' => true, 
                'count' => $wishlist->count()
            ]);
        }

        return back()->with('success', 'Đã xóa khỏi danh sách yêu thích!');
    }

    // Xóa tất cả yêu thích
    public function clear(Request $request)
    {
        $request->session()->forget('wishlist');
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true, 
                'message' => 'Đã xóa tất cả sản phẩm yêu thích!'
            ]);
        }
        return back()->with('success', 'Đã xóa tất cả sản phẩm yêu thích!');
    }
    
    // Lấy số lượng sản phẩm trong wishlist
    public function count(Request $request)
    {
        $count = count($request->session()->get('wishlist', []));
        return response()->json(['count' => $count]);
    }
}


