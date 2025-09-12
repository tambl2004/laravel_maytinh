<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        // --- Dữ liệu nguồn để tạo sản phẩm laptop ---
        $brands = ['Dell', 'HP', 'Lenovo', 'Asus', 'Acer', 'MSI', 'MacBook'];
        $models = [
            'Dell' => ['Inspiron 15', 'XPS 13', 'Latitude 14', 'Precision 15', 'Vostro 15'],
            'HP' => ['Pavilion 15', 'EliteBook 14', 'ProBook 15', 'Envy 13', 'Spectre x360'],
            'Lenovo' => ['ThinkPad E15', 'IdeaPad 3', 'Yoga 7i', 'Legion 5', 'ThinkBook 15'],
            'Asus' => ['VivoBook 15', 'ZenBook 14', 'ROG Strix G15', 'TUF Gaming A15', 'ExpertBook B9'],
            'Acer' => ['Aspire 5', 'Swift 3', 'Nitro 5', 'Predator Helios', 'TravelMate P2'],
            'MSI' => ['Modern 15', 'Prestige 14', 'GF63 Thin', 'Creator 15', 'Stealth 15M'],
            'MacBook' => ['MacBook Air M2', 'MacBook Pro 13', 'MacBook Pro 14', 'MacBook Pro 16']
        ];
        $specs = ['8GB RAM/256GB SSD', '16GB RAM/512GB SSD', '8GB RAM/512GB SSD', '16GB RAM/1TB SSD', '32GB RAM/1TB SSD'];
        $colors = ['Đen', 'Bạc', 'Xám', 'Vàng', 'Xanh'];

        // --- Logic tạo sản phẩm ---
        $brand = Arr::random($brands);
        $model = Arr::random($models[$brand]);
        $spec = Arr::random($specs);
        $color = Arr::random($colors);

        $productName = "Laptop {$brand} {$model} {$spec} - {$color}";
        
        $priceRanges = [
            'MacBook' => [25000000, 45000000],
            'Dell' => [15000000, 35000000],
            'HP' => [12000000, 30000000],
            'Lenovo' => [10000000, 28000000],
            'Asus' => [8000000, 25000000],
            'MSI' => [18000000, 40000000],
            'Acer' => [7000000, 20000000],
            'default' => [5000000, 15000000]
        ];

        $priceKey = $brand;
        if (!array_key_exists($brand, $priceRanges)) {
            $priceKey = 'default';
        }

        $price = fake()->numberBetween($priceRanges[$priceKey][0], $priceRanges[$priceKey][1]);

        // Generate laptop images using Unsplash
        $laptopImages = [
            'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&h=400&fit=crop&crop=center',
            'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=400&h=400&fit=crop&crop=center',
            'https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?w=400&h=400&fit=crop&crop=center',
            'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=400&h=400&fit=crop&crop=center',
            'https://images.unsplash.com/photo-1587831990711-23ca6441447b?w=400&h=400&fit=crop&crop=center',
            'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?w=400&h=400&fit=crop&crop=center',
            'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=400&h=400&fit=crop&crop=center',
            'https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?w=400&h=400&fit=crop&crop=center'
        ];
        $imageUrl = Arr::random($laptopImages);

        return [
            'name' => $productName,
            'description' => "Trải nghiệm hiệu suất vượt trội với {$productName}. Thiết kế hiện đại, cấu hình mạnh mẽ và hiệu năng cao phù hợp cho công việc, học tập và giải trí. Sản phẩm chính hãng, bảo hành 24 tháng.",
            'price' => $price,
            'stock' => fake()->numberBetween(5, 50),
            'image' => $imageUrl,
        ];
    }
}