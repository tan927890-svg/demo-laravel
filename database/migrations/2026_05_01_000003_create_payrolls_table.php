<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Kỳ lương
            $table->tinyInteger('month'); // 1–12
            $table->year('year');

            // ── Các thành phần lương ──

            // 1. Lương cứng (snapshot từ salary_histories tại thời điểm tính)
            $table->decimal('base_salary', 20, 0)->default(0);

            // 2. Tổng hoa hồng từ đơn hàng da_chot_don trong tháng
            $table->decimal('total_commission', 20, 0)->default(0);

            // 3. Thưởng KPI
            $table->decimal('kpi_bonus', 20, 0)->default(0);

            // Lưu % KPI đạt được để tra cứu (tránh tính lại)
            $table->decimal('kpi_percent', 5, 1)->default(0);

            // ── Tổng lương thực nhận ──
            $table->decimal('total_salary', 20, 0)->default(0);
            // total_salary = base_salary + total_commission + kpi_bonus

            // ── Quy trình duyệt 2 cấp ──
            $table->enum('status', [
                'draft',            // Hệ thống vừa tính, chưa gửi
                'pending_manager',  // Gửi lên Manager duyệt
                'pending_admin',    // Manager đã duyệt, chờ Admin chốt
                'approved',         // Admin đã chốt, khóa
                'rejected',         // Bị từ chối (kèm lý do)
            ])->default('draft');

            // Ghi chú duyệt
            $table->text('manager_note')->nullable();
            $table->text('admin_note')->nullable();
            $table->text('reject_reason')->nullable();

            // Ai duyệt, khi nào
            $table->foreignId('reviewed_by_manager')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('approved_by_admin')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('manager_reviewed_at')->nullable();
            $table->timestamp('admin_approved_at')->nullable();

            $table->timestamps();

            // Mỗi nhân viên chỉ có 1 bảng lương mỗi tháng
            $table->unique(['user_id', 'year', 'month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
