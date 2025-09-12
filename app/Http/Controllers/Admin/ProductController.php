<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product; // <--- DÒNG QUAN TRỌNG BẠN ĐÃ NÓI
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|url|max:500',
        ]);

        // Lưu trực tiếp URL ảnh từ internet
        if ($request->filled('image')) {
            $validated['image'] = $request->image;
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Sản phẩm đã được tạo thành công!');
    }

    // --- HÀM MỚI ---
    // Hiển thị form để sửa sản phẩm
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
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
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|url|max:500',
        ]);

        // Lưu trực tiếp URL ảnh từ internet
        if ($request->filled('image')) {
            $validated['image'] = $request->image;
        }

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