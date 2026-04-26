<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('car_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Tính năng có thể khác nhau theo phiên bản (G vs L vs RS)
            $table->foreignId('variant_id')
                  ->nullable()
                  ->constrained('car_variants')
                  ->nullOnDelete();

            $table->string('title');            // "Honda SENSING", "Honda CONNECT"
            $table->text('description');        // mô tả chi tiết tính năng
            $table->string('image')->nullable(); // ảnh minh họa tính năng
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_features');
    }
};