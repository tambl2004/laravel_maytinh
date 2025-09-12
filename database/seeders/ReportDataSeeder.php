<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class ReportDataSeeder extends Seeder
{
    public function run()
    {
        // Tạo user test
        $user = User::firstOrCreate(['email' => 'test@example.com'], [
            'name' => 'Test User',
            'password' => bcrypt('password'),
            'role' => 'customer'
        ]);

        // Tạo thêm đơn hàng trong 7 ngày qua
        for ($i = 0; $i < 5; $i++) {
            $order = Order::create([
                'user_id' => $user->id,
                'customer_name' => 'Khách hàng ' . ($i + 1),
                'customer_email' => 'customer' . ($i + 1) . '@example.com',
                'customer_phone' => '012345678' . $i,
                'customer_address' => 'Địa chỉ ' . ($i + 1),
                'total_amount' => rand(1000000, 5000000),
                'status' => ['pending', 'processing', 'completed', 'cancelled'][rand(0, 3)],
                'created_at' => now()->subDays(rand(0, 7))
            ]);
            
            // Tạo order items
            $products = Product::inRandomOrder()->take(rand(1, 3))->get();
            foreach ($products as $product) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => rand(1, 3),
                    'price' => $product->price
                ]);
            }
        }

        echo "Đã tạo dữ liệu mẫu cho báo cáo\n";
    }
}