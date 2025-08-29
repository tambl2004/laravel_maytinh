<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Quan trọng: Import Model Product vào

class ProductController extends Controller
{
    // Tạo một hàm để hiển thị danh sách sản phẩm
    public function index()
    {
        // 1. Dùng Model Product để lấy tất cả sản phẩm từ database
        $products = Product::all();

        // 2. Trả về một view và gửi kèm biến $products qua view đó
        return view('customer.products.index', ['products' => $products]);
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