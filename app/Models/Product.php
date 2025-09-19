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
    
    // Relationship với OrderItem
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    // Relationship với Review
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    // Lấy các review đã được duyệt
    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }
    
    // Tính điểm trung bình của sản phẩm
    public function getAverageRatingAttribute()
    {
        return $this->approvedReviews()->avg('rating') ?: 0;
    }
    
    // Đếm tổng số review
    public function getReviewCountAttribute()
    {
        return $this->approvedReviews()->count();
    }
    
    // Lấy phân bố sao (1-5 sao)
    public function getRatingDistributionAttribute()
    {
        $distribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $distribution[$i] = $this->approvedReviews()->where('rating', $i)->count();
        }
        return $distribution;
    }

    // Quan hệ khuyến mãi nhiều-nhiều
    public function promotions()
    {
        // Sử dụng đúng tên bảng pivot đã tạo: promotion_product
        return $this->belongsToMany(Promotion::class, 'promotion_product');
    }

    // Giá sau khuyến mãi hiện hành (nếu có)
    public function getDiscountedPriceAttribute()
    {
        $promotions = $this->relationLoaded('promotions') ? $this->promotions : $this->promotions()->get();
        $running = $promotions->first(function ($p) { return $p->isRunning(); });
        if (!$running) return (float) $this->price;
        return $running->applyToPrice((float) $this->price);
    }
}
