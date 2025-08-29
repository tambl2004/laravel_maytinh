<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        // --- Dữ liệu nguồn để tạo sản phẩm thực tế ---
        $brands = ['Apple', 'Samsung', 'Xiaomi', 'Lenovo', 'Microsoft'];
        $models = [
            'Apple' => ['iPad Pro 12.9 inch', 'iPad Air 5', 'iPad Mini 6', 'iPad 10.9 inch'],
            'Samsung' => ['Galaxy Tab S9 Ultra', 'Galaxy Tab S9 FE', 'Galaxy Tab A9+'],
            'Xiaomi' => ['Pad 6 Pro', 'Pad 6', 'Redmi Pad SE'],
            'Lenovo' => ['Tab P12', 'Legion Tab', 'Xiaoxin Pad Pro'],
            'Microsoft' => ['Surface Pro 9', 'Surface Go 3'],
        ];
        $specs = ['(128GB, Wifi)', '(256GB, Wifi + 5G)', '(512GB, Wifi)', '(64GB, Wifi)'];
        $colors = ['Xám Không Gian', 'Bạc', 'Vàng Hồng', 'Xanh Dương', 'Đen'];

        // --- Logic tạo sản phẩm ---
        $brand = Arr::random($brands);
        $model = Arr::random($models[$brand]);
        $spec = Arr::random($specs);
        $color = Arr::random($colors);

        $productName = "{$model} {$spec} - {$color}";
        
        $priceRanges = [
            'iPad Pro' => [25000000, 40000000],
            'iPad Air' => [15000000, 22000000],
            'iPad Mini' => [12000000, 18000000],
            'Galaxy Tab S' => [20000000, 35000000],
            'Surface Pro' => [22000000, 45000000],
            'default' => [5000000, 15000000]
        ];

        $priceKey = 'default';
        if (str_contains($model, 'iPad Pro')) $priceKey = 'iPad Pro';
        elseif (str_contains($model, 'iPad Air')) $priceKey = 'iPad Air';
        elseif (str_contains($model, 'iPad Mini')) $priceKey = 'iPad Mini';
        elseif (str_contains($model, 'Galaxy Tab S')) $priceKey = 'Galaxy Tab S';
        elseif (str_contains($model, 'Surface Pro')) $priceKey = 'Surface Pro';

        $price = fake()->numberBetween($priceRanges[$priceKey][0], $priceRanges[$priceKey][1]);


        return [
            'name' => $productName,
            'description' => "Trải nghiệm sức mạnh đỉnh cao với {$productName}. Thiết kế sang trọng, màn hình sắc nét và hiệu năng vượt trội cho mọi tác vụ từ làm việc chuyên nghiệp đến giải trí đỉnh cao. Sản phẩm chính hãng, bảo hành 12 tháng.",
            'price' => $price,
            'stock' => fake()->numberBetween(10, 100),
        ];
    }
}