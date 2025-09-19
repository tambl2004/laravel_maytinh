<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'type', 'value', 'start_date', 'end_date', 'active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'active' => 'boolean',
        'value' => 'decimal:2',
    ];

    public function products()
    {
        // Sử dụng đúng tên bảng pivot đã tạo trong migration
        return $this->belongsToMany(Product::class, 'promotion_product');
    }

    public function isRunning(): bool
    {
        $today = now()->startOfDay();
        return $this->active
            && $this->start_date->startOfDay() <= $today
            && (is_null($this->end_date) || $this->end_date->endOfDay() >= $today);
    }

    public function applyToPrice(float $original): float
    {
        if (!$this->isRunning()) return $original;
        if ($this->type === 'percent') {
            $discount = $original * (float)$this->value / 100.0;
            return max(0, $original - $discount);
        }
        return max(0, $original - (float)$this->value);
    }
}


