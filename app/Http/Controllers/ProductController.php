<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Quan trọng: Import Model Product vào
use App\Models\Category; // Import Category model

class ProductController extends Controller
{
    // Tạo một hàm để hiển thị danh sách sản phẩm
    public function index(Request $request)
    {
        $query = Product::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        
        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        // Sorting
        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }
        
        // Paginate results (12 products per page)
        $products = $query->paginate(12);
        
        // Get all categories for filter dropdown
        $categories = Category::orderBy('name')->get();

        // 2. Trả về một view và gửi kèm biến $products qua view đó
        return view('customer.products.index', compact('products', 'categories'));
    }
     // THÊM PHƯƠNG THỨC MỚI NÀY VÀO
     public function show(Product $product)
     {
         // Lấy 4 sản phẩm liên quan (cùng danh mục, trừ sản phẩm hiện tại)
         $relatedProducts = Product::where('category_id', $product->category_id)
                                   ->where('id', '!=', $product->id)
                                   ->limit(4)
                                   ->get();
     
         return view('customer.products.show', [
             'product' => $product,
             'relatedProducts' => $relatedProducts
         ]);
     }
}