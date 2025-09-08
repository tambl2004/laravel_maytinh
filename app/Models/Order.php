<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'customer_name', 'customer_email', 'customer_phone',
        'customer_address', 'total_amount', 'status', 'cancelled_at', 'cancel_reason'
    ];
    
    protected $dates = [
        'created_at', 'updated_at', 'cancelled_at'
    ];
    
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
