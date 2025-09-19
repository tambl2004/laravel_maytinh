<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Product;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::latest()->paginate(12);
        return view('admin.promotions.index', compact('promotions'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        return view('admin.promotions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d|after_or_equal:start_date',
            'active' => 'sometimes|boolean',
            'products' => 'array',
            'products.*' => 'integer|exists:products,id',
        ]);

        $promotion = Promotion::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'type' => $data['type'],
            'value' => $data['value'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'] ?? null,
            'active' => $request->boolean('active'),
        ]);

        $promotion->products()->sync($data['products'] ?? []);

        return redirect()->route('admin.promotions.index')->with('success', 'Tạo khuyến mãi thành công');
    }

    public function edit(Promotion $promotion)
    {
        $products = Product::orderBy('name')->get();
        $selected = $promotion->products()->pluck('product_id')->toArray();
        return view('admin.promotions.edit', compact('promotion', 'products', 'selected'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d|after_or_equal:start_date',
            'active' => 'sometimes|boolean',
            'products' => 'array',
            'products.*' => 'integer|exists:products,id',
        ]);

        $promotion->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'type' => $data['type'],
            'value' => $data['value'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'] ?? null,
            'active' => $request->boolean('active'),
        ]);
        $promotion->products()->sync($data['products'] ?? []);
        return redirect()->route('admin.promotions.index')->with('success', 'Cập nhật khuyến mãi thành công');
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
        return redirect()->route('admin.promotions.index')->with('success', 'Đã xóa khuyến mãi');
    }
}


