<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'product_id', 
        'rating',
        'comment',
        'is_approved'
    ];
    
    protected $casts = [
        'is_approved' => 'boolean',
        'rating' => 'integer'
    ];
    
    // Relationship với User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Relationship với Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    // Scope để lấy các review đã được duyệt
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }
    
    // Scope để lấy review theo rating
    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }
}
