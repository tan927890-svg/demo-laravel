<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            // Thêm brand_id liên kết với bảng brands
            $table->foreignId('brand_id')
                  ->nullable()
                  ->after('brand')
                  ->constrained('brands')
                  ->onDelete('set null');

            // Thêm price_per_day cho thuê xe
            $table->decimal('price_per_day', 15, 0)
                  ->nullable()
                  ->after('price');

            // Thêm is_available
            $table->boolean('is_available')
                  ->default(true)
                  ->after('status');

            // Thêm image (single) nếu chưa có
            $table->string('image')->nullable()->after('images');
        });
    }

    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);
            $table->dropColumn(['brand_id', 'price_per_day', 'is_available', 'image']);
        });
    }
};