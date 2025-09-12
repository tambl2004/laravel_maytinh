<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'phone', 'address', 'is_default',
        'province_id', 'province_name', 'district_id', 'district_name', 
        'ward_id', 'ward_name', 'detail_address'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Lấy địa chỉ đầy đủ với tỉnh thành, quận huyện, phường xã
     */
    public function getFullAddressAttribute()
    {
        $parts = [];
        
        if ($this->detail_address) {
            $parts[] = $this->detail_address;
        }
        
        if ($this->ward_name) {
            $parts[] = $this->ward_name;
        }
        
        if ($this->district_name) {
            $parts[] = $this->district_name;
        }
        
        if ($this->province_name) {
            $parts[] = $this->province_name;
        }
        
        return implode(', ', $parts);
    }
}