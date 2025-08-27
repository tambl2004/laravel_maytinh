<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
     // Thêm dòng này
     protected $fillable = ['name', 'description', 'price', 'stock', 'image'];
}
