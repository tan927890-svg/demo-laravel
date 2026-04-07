<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('car_specs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Nếu spec chỉ thuộc 1 phiên bản cụ thể → set variant_id
            // Nếu spec chung cho tất cả phiên bản → để null
            $table->foreignId('variant_id')
                  ->nullable()
                  ->constrained('car_variants')
                  ->nullOnDelete();

            $table->string('category');       // "ĐỘNG CƠ/HỘP SỐ", "KÍCH THƯỚC/TRỌNG LƯỢNG"
            $table->string('spec_key');       // "Kiểu động cơ", "Hộp số", "Số chỗ ngồi"
            $table->string('spec_value');     // "1.5L DOHC i-VTEC, 4 xi lanh thẳng hàng, 16 van"
            $table->integer('category_order')->default(0); // thứ tự nhóm
            $table->integer('sort_order')->default(0);     // thứ tự trong nhóm
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_specs');
    }
};