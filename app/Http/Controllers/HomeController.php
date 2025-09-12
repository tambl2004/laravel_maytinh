<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\News;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy sản phẩm nổi bật
        $featuredProducts = Product::latest()->take(8)->get();
        
        // Lấy tin tức nổi bật
        $featuredNews = News::published()
            ->featured()
            ->latest()
            ->take(3)
            ->get();
        
        return view('customer.home', compact('featuredProducts', 'featuredNews'));
    }
}