<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        // --- Dữ liệu nguồn để tạo sản phẩm balo ---
        $brands = ['Nike', 'Adidas', 'The North Face', 'JanSport', 'Herschel'];
        $models = [
            'Nike' => ['Brasilia Backpack', 'Heritage Backpack', 'Academy Backpack', 'Elemental Backpack'],
            'Adidas' => ['Classic 3-Stripes', 'Originals Backpack', 'Power Backpack', 'Linear Core'],
            'The North Face' => ['Borealis Backpack', 'Jester Backpack', 'Recon Backpack', 'Vault Backpack'],
            'JanSport' => ['SuperBreak', 'Right Pack', 'High Stakes', 'Cool Student'],
            'Herschel' => ['Little America', 'Novel Duffle', 'Settlement Backpack', 'Pop Quiz'],
        ];
        $specs = ['(25L)', '(30L)', '(20L)', '(35L)'];
        $colors = ['Đen', 'Xanh Navy', 'Xám', 'Nâu', 'Xanh Dương'];

        // --- Logic tạo sản phẩm ---
        $brand = Arr::random($brands);
        $model = Arr::random($models[$brand]);
        $spec = Arr::random($specs);
        $color = Arr::random($colors);

        $productName = "Balo {$brand} {$model} {$spec} - {$color}";
        
        $priceRanges = [
            'The North Face' => [1500000, 3500000],
            'Herschel' => [1200000, 2800000],
            'Nike' => [800000, 2000000],
            'Adidas' => [700000, 1800000],
            'JanSport' => [500000, 1500000],
            'default' => [400000, 1200000]
        ];

        $priceKey = $brand;
        if (!array_key_exists($brand, $priceRanges)) {
            $priceKey = 'default';
        }

        $price = fake()->numberBetween($priceRanges[$priceKey][0], $priceRanges[$priceKey][1]);

        // Generate backpack images using Unsplash
        $imageKeywords = ['backpack', 'rucksack', 'schoolbag', 'hiking+backpack', 'travel+backpack'];
        $randomKeyword = Arr::random($imageKeywords);
        $imageUrl = "https://images.unsplash.com/photo-" . fake()->numberBetween(1500000000000, 1700000000000) . "?w=400&h=400&fit=crop&crop=center&q=80";
        
        // Alternative: Use a more reliable backpack image URL
        $backpackImages = [
            'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400&h=400&fit=crop&crop=center',
            'https://images.unsplash.com/photo-1622260614153-03223fb72052?w=400&h=400&fit=crop&crop=center',
            'https://images.unsplash.com/photo-1590736969955-71cc94901144?w=400&h=400&fit=crop&crop=center',
            'https://images.unsplash.com/photo-1581115293892-c5b2c71ccb7d?w=400&h=400&fit=crop&crop=center',
            'https://images.unsplash.com/photo-1570804881642-0ed475d2da2b?w=400&h=400&fit=crop&crop=center'
        ];
        $imageUrl = Arr::random($backpackImages);


        return [
            'name' => $productName,
            'description' => "Khám phá phong cách và tiện ích với {$productName}. Thiết kế hiện đại, chất liệu cao cấp và khả năng chứa đồ tối ưu cho mọi hoạt động từ học tập, làm việc đến du lịch. Sản phẩm chính hãng, bảo hành 12 tháng.",
            'price' => $price,
            'stock' => fake()->numberBetween(10, 100),
            'image' => $imageUrl,
        ];
    }
}