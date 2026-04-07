<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('car_galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('file_path');                              // đường dẫn ảnh/video
            $table->enum('type', ['image', 'video'])->default('image');
            $table->string('thumbnail')->nullable();                  // thumbnail riêng cho video
            $table->string('caption')->nullable();                    // chú thích ảnh
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_galleries');
    }
};