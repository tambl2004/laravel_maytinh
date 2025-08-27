<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company() . ' ' . fake()->randomElement(['Tab Pro', 'Tab Max', 'Tab Lite']),
            'description' => fake()->paragraph(5), // Tạo một đoạn văn mô tả gồm 5 câu
            'price' => fake()->numberBetween(5000000, 30000000), // Giá ngẫu nhiên từ 5 triệu đến 30 triệu
            'image' => 'https://via.placeholder.com/640x480.png/004466?text=product+image', // Một ảnh mẫu
            'stock' => fake()->numberBetween(10, 100), // Tồn kho từ 10 đến 100
        ];
    }
}
