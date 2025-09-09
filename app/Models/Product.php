<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
     // Cho phép gán giá trị hàng loạt cho các cột chính của sản phẩm
     protected $fillable = ['name', 'description', 'price', 'stock', 'image', 'category_id'];
     // Thêm vào trong class Product
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
