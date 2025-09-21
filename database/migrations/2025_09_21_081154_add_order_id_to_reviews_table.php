<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Thêm cột order_id để liên kết với đơn hàng
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('cascade');
            
            // Thêm cột order_item_id để liên kết với sản phẩm cụ thể trong đơn hàng
            $table->foreignId('order_item_id')->nullable()->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['order_item_id']);
            $table->dropColumn(['order_id', 'order_item_id']);
        });
    }
};
