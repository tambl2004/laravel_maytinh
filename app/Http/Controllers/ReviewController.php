<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Lưu đánh giá mới của khách hàng
     */
    public function store(Request $request, Product $product)
    {
        // Kiểm tra xem user đã mua sản phẩm này chưa
        $hasPurchased = OrderItem::whereHas('order', function($query) {
            $query->where('user_id', Auth::id())
                  ->whereIn('status', ['completed', 'processing']);
        })->where('product_id', $product->id)->exists();
        
        if (!$hasPurchased) {
            return redirect()->back()->with('error', 'Bạn chỉ có thể đánh giá sản phẩm đã mua!');
        }
        
        // Kiểm tra xem user đã đánh giá sản phẩm này chưa
        $existingReview = Review::where('user_id', Auth::id())
                               ->where('product_id', $product->id)
                               ->first();
        
        if ($existingReview) {
            return redirect()->back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi!');
        }
        
        // Validate dữ liệu
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ], [
            'rating.required' => 'Vui lòng chọn số sao đánh giá',
            'rating.min' => 'Số sao tối thiểu là 1',
            'rating.max' => 'Số sao tối đa là 5',
            'comment.max' => 'Bình luận không được vượt quá 1000 ký tự'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }
        
        // Lấy order item để liên kết với đánh giá
        $orderItem = OrderItem::whereHas('order', function($query) {
            $query->where('user_id', Auth::id())
                  ->whereIn('status', ['completed', 'processing']);
        })->where('product_id', $product->id)->first();
        
        // Tạo đánh giá mới
        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'order_id' => $orderItem->order_id,
            'order_item_id' => $orderItem->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => true // Tự động duyệt (có thể thay đổi)
        ]);
        
        return redirect()->back()->with('success', 'Đánh giá của bạn đã được gửi thành công!');
    }
    
    /**
     * Cập nhật đánh giá
     */
    public function update(Request $request, Review $review)
    {
        // Kiểm tra quyền sửa đánh giá
        if ($review->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Bản không có quyền sửa đánh giá này!');
        }
        
        // Validate dữ liệu
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }
        
        // Cập nhật đánh giá
        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => true // Đặt lại trạng thái duyệt
        ]);
        
        return redirect()->back()->with('success', 'Đánh giá đã được cập nhật!');
    }
    
    /**
     * Xóa đánh giá
     */
    public function destroy(Review $review)
    {
        // Kiểm tra quyền xóa đánh giá
        if ($review->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Bản không có quyền xóa đánh giá này!');
        }
        
        $review->delete();
        
        return redirect()->back()->with('success', 'Đánh giá đã được xóa!');
    }
    
    /**
     * Kiểm tra trạng thái đánh giá của sản phẩm trong đơn hàng
     */
    public function getReviewStatus($orderId, $productId)
    {
        $order = Order::where('id', $orderId)
                     ->where('user_id', Auth::id())
                     ->first();
        
        if (!$order) {
            return response()->json(['error' => 'Không tìm thấy đơn hàng'], 404);
        }
        
        $orderItem = OrderItem::where('order_id', $orderId)
                             ->where('product_id', $productId)
                             ->first();
        
        if (!$orderItem) {
            return response()->json(['error' => 'Không tìm thấy sản phẩm trong đơn hàng'], 404);
        }
        
        $review = Review::where('user_id', Auth::id())
                        ->where('product_id', $productId)
                        ->where('order_id', $orderId)
                        ->first();
        
        return response()->json([
            'has_reviewed' => $review ? true : false,
            'review' => $review,
            'can_review' => in_array($order->status, ['completed', 'processing'])
        ]);
    }
}
