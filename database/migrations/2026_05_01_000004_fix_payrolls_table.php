<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Bước 1: Xóa foreign key trước (riêng block)
        Schema::table('payrolls', function (Blueprint $table) {
            if (Schema::hasColumn('payrolls', 'reviewed_by_manager')) {
                $table->dropForeign('payrolls_reviewed_by_manager_foreign');
            }
            if (Schema::hasColumn('payrolls', 'approved_by_admin')) {
                $table->dropForeign('payrolls_approved_by_admin_foreign');
            }
        });

        // Bước 2: Xóa các cột cũ (riêng block)
        Schema::table('payrolls', function (Blueprint $table) {
            $drop = [
                'reviewed_by_manager', 'approved_by_admin',
                'manager_reviewed_at', 'admin_approved_at',
                'manager_note', 'admin_note', 'reject_reason',
            ];
            foreach ($drop as $col) {
                if (Schema::hasColumn('payrolls', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        // Bước 3: Thêm cột mới (riêng block)
        Schema::table('payrolls', function (Blueprint $table) {
            if (!Schema::hasColumn('payrolls', 'approved_by')) {
                $table->foreignId('approved_by')
                    ->nullable()
                    ->constrained('users')
                    ->onDelete('set null')
                    ->after('status');
            }

            if (!Schema::hasColumn('payrolls', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('approved_by');
            }

            if (!Schema::hasColumn('payrolls', 'note')) {
                $table->text('note')->nullable()->after('approved_at');
            }
        });

        // Bước 4: Sửa enum status
        DB::statement("ALTER TABLE payrolls MODIFY COLUMN status ENUM('draft','approved') NOT NULL DEFAULT 'draft'");
    }

    public function down(): void
    {
        // Không rollback để tránh mất dữ liệu
    }
};