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
    Schema::create('kpis', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->decimal('target_revenue', 20, 2);   // mục tiêu doanh thu
        $table->decimal('actual_revenue', 20, 2)->default(0);
        $table->integer('target_orders')->default(0);
        $table->integer('actual_orders')->default(0);
        $table->year('year');
        $table->tinyInteger('month');               // 1–12
        $table->timestamps();

        $table->unique(['user_id', 'year', 'month']);
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpis');
    }
};
