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
        Schema::table('addresses', function (Blueprint $table) {
            // Thêm các trường tỉnh thành, quận huyện, phường xã
            $table->string('province_id')->nullable()->after('address'); // ID tỉnh thành
            $table->string('province_name')->nullable()->after('province_id'); // Tên tỉnh thành
            $table->string('district_id')->nullable()->after('province_name'); // ID quận huyện
            $table->string('district_name')->nullable()->after('district_id'); // Tên quận huyện
            $table->string('ward_id')->nullable()->after('district_name'); // ID phường xã
            $table->string('ward_name')->nullable()->after('ward_id'); // Tên phường xã
            $table->text('detail_address')->nullable()->after('ward_name'); // Địa chỉ chi tiết (số nhà, tên đường)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn([
                'province_id', 'province_name', 
                'district_id', 'district_name', 
                'ward_id', 'ward_name', 
                'detail_address'
            ]);
        });
    }
};
