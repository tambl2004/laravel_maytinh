<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product; // <--- DÒNG QUAN TRỌNG BẠN ĐÃ NÓI
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|url',
        ]);

        Product::create($validated);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Sản phẩm đã được tạo thành công!');
    }

    // --- HÀM MỚI ---
    // Hiển thị form để sửa sản phẩm
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    // --- HÀM MỚI ---
    // Cập nhật sản phẩm trong database
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|url',
        ]);

        $product->update($validated);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }

    // --- HÀM MỚI ---
    // Xóa sản phẩm khỏi database
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')
                         ->with('success', 'Sản phẩm đã được xóa thành công!');
    }
}