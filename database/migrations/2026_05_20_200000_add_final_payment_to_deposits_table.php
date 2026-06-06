<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->decimal('final_amount', 15, 0)->nullable()->after('deposit_amount')
                  ->comment('Số tiền còn lại khách cần thanh toán');
            $table->string('final_payment_method')->nullable()->after('final_amount')
                  ->comment('Phương thức thanh toán phần còn lại');
            $table->text('final_payment_note')->nullable()->after('final_payment_method')
                  ->comment('Ghi chú khi hoàn tất thanh toán');
            $table->timestamp('final_paid_at')->nullable()->after('final_payment_note')
                  ->comment('Thời điểm nhân viên xác nhận đã nhận đủ tiền');
            $table->unsignedBigInteger('finalized_by')->nullable()->after('final_paid_at')
                  ->comment('Nhân viên xác nhận');
            $table->foreign('finalized_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropForeign(['finalized_by']);
            $table->dropColumn([
                'final_amount',
                'final_payment_method',
                'final_payment_note',
                'final_paid_at',
                'finalized_by',
            ]);
        });
    }
};