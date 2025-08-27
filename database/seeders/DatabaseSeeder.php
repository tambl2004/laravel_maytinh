<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(1)->create(); // Tạo 1 user thường
    
        // Bỏ user 'test@example.com' cũ đi và thay bằng admin
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'role' => 'admin', // Gán quyền admin
        ]);
    
        $this->call([
            ProductSeeder::class,
        ]);
    }
}
