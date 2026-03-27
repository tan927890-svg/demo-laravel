<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('brand');
            $table->string('model')->nullable();
            $table->integer('year');
            $table->decimal('price', 15, 0);
            $table->string('color')->nullable();
            $table->integer('mileage')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('transmission')->nullable();
            $table->string('condition')->nullable();
            $table->string('engine')->nullable();
            $table->integer('seats')->nullable();
            $table->text('description')->nullable();
            $table->json('images')->nullable();
            $table->enum('status', ['available', 'reserved', 'sold'])->default('available');
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};