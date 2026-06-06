<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained()->onDelete('cascade');

            // Thông tin khách hàng
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone', 20);
            $table->string('customer_address')->nullable();
            $table->string('customer_id_card', 20)->nullable()->comment('CCCD/CMND');

            // Thông tin đặt cọc
            $table->decimal('deposit_amount', 15, 0)->default(10000000); // 10 triệu
            $table->string('payment_method')->default('bank_transfer'); // bank_transfer, cash, momo, vnpay
            $table->string('transaction_code')->nullable()->unique();
            $table->string('status')->default('pending'); // pending, confirmed, cancelled, refunded

            // Ghi chú
            $table->text('note')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
