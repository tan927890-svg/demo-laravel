<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Nhân viên tư vấn (staff) phụ trách
            $table->foreignId('assigned_to')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null')
                  ->after('user_id');

            // Trạng thái tư vấn của Staff
            $table->enum('consultation_status', [
                'chua_tu_van',   // Chưa tư vấn
                'da_tu_van',     // Đã tư vấn
                'da_chot_don',   // Đã chốt đơn (Manager xác nhận)
            ])->default('chua_tu_van')->after('status');

            // Giá bán cuối (Manager nhập khi chốt đơn)
            $table->decimal('sale_price', 20, 0)->nullable()->after('consultation_status');

            // Phần trăm hoa hồng (Manager nhập)
            $table->decimal('commission_rate', 5, 2)->nullable()->after('sale_price');

            // Hoa hồng tính được = sale_price * commission_rate / 100
            $table->decimal('commission_amount', 20, 0)->nullable()->after('commission_rate');

            // Ghi chú của Manager khi chốt
            $table->text('manager_note')->nullable()->after('commission_amount');

            // Thời gian tư vấn
            $table->timestamp('consulted_at')->nullable()->after('manager_note');

            // Thời gian chốt đơn
            $table->timestamp('closed_at')->nullable()->after('consulted_at');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['assigned_to']);
            $table->dropColumn([
                'assigned_to',
                'consultation_status',
                'sale_price',
                'commission_rate',
                'commission_amount',
                'manager_note',
                'consulted_at',
                'closed_at',
            ]);
        });
    }
};
