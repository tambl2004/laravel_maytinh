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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('status');
            $table->string('payment_status')->default('pending')->after('payment_method');
            $table->string('momo_order_id')->nullable()->after('payment_status');
            $table->string('momo_request_id')->nullable()->after('momo_order_id');
            $table->string('momo_trans_id')->nullable()->after('momo_request_id');
            $table->text('payment_notes')->nullable()->after('momo_trans_id');
            $table->timestamp('paid_at')->nullable()->after('payment_notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_method',
                'payment_status',
                'momo_order_id',
                'momo_request_id',
                'momo_trans_id',
                'payment_notes',
                'paid_at'
            ]);
        });
    }
};
