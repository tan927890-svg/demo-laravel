<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('car_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('name');                       // "G", "L", "RS", "E"
            $table->decimal('price', 15, 0);              // 569000000
            $table->integer('sort_order')->default(0);    // thứ tự hiển thị
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_variants');
    }
};