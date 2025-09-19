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
        $wishlist->push($product->id);
        $request->session()->put('wishlist', $wishlist->unique()->values()->all());

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'added' => true, 'count' => $wishlist->unique()->count()]);
        }

        return back();
    }

    // Xóa sản phẩm khỏi yêu thích
    public function remove(Request $request, Product $product)
    {
        $wishlist = collect($request->session()->get('wishlist', []))
            ->reject(fn ($id) => (int)$id === (int)$product->id)
            ->values();
        $request->session()->put('wishlist', $wishlist->all());

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'removed' => true, 'count' => $wishlist->count()]);
        }

        return back();
    }

    // Xóa tất cả yêu thích
    public function clear(Request $request)
    {
        $request->session()->forget('wishlist');
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return back();
    }
}


