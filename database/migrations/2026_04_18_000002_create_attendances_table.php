<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Check-in
            $table->timestamp('check_in_at')->nullable();
            $table->decimal('check_in_lat', 10, 7)->nullable();
            $table->decimal('check_in_lng', 10, 7)->nullable();
            $table->string('check_in_address')->nullable();

            // Check-out
            $table->timestamp('check_out_at')->nullable();
            $table->decimal('check_out_lat', 10, 7)->nullable();
            $table->decimal('check_out_lng', 10, 7)->nullable();
            $table->string('check_out_address')->nullable();

            // Ngày làm việc (date only để dễ query)
            $table->date('work_date');

            $table->timestamps();

            $table->unique(['user_id', 'work_date']); // mỗi nhân viên 1 record/ngày
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
