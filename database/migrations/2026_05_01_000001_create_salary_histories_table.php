<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salary_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Lương cứng theo tháng (thay vì để thẳng trên users)
            $table->decimal('base_salary', 20, 0);

            // Có hiệu lực từ tháng/năm nào
            $table->tinyInteger('effective_month'); // 1–12
            $table->year('effective_year');

            // Ai thay đổi, ghi chú
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('note')->nullable();

            $table->timestamps();

            // Mỗi nhân viên chỉ có 1 mức lương mỗi tháng
            $table->unique(['user_id', 'effective_year', 'effective_month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salary_histories');
    }
};
