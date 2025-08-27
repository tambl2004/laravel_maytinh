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
         // Laravel sẽ tự động tìm Product có ID tương ứng với {product} trên URL
         // Đây được gọi là "Route Model Binding"
         return view('customer.products.show', ['product' => $product]);
     }
}