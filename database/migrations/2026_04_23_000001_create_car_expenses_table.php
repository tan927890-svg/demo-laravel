<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->decimal('cost_price', 15, 0)->nullable()->after('price_per_day')
                  ->comment('Giá nhập xe');
        });

        Schema::create('car_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            $table->string('name');           // Tên chi phí: Vận chuyển, Thuế NK, ...
            $table->decimal('amount', 15, 0)->default(0);
            $table->string('category')->nullable(); // vận_chuyển | thuế | đăng_ký | sửa_chữa | marketing | hoa_hồng | khác
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_expenses');
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn('cost_price');
        });
    }
};
