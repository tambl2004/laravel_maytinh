<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Cho phép gán giá trị hàng loạt cho các cột này
    protected $fillable = ['name', 'slug'];

    // Định nghĩa mối quan hệ với Product
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}