<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('car_colors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('name');                        // "Đen", "Đỏ", "Xám", "Titan", "Xanh", "Trắng"
            $table->string('hex_code', 10);               // "#1a1a1a"
            $table->string('image')->nullable();           // ảnh xe theo màu đó
            $table->decimal('price_addon', 15, 0)
                  ->default(0);                           // phụ thu thêm nếu có (thường = 0)
            $table->boolean('is_default')->default(false); // màu mặc định khi mở trang
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_colors');
    }
};