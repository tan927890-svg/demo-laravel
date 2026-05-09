<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Bảng cấu hình bậc thưởng — Admin/Manager tự cài đặt
        // VD: 80–99% → thưởng 1tr, 100–119% → thưởng 3tr, 120%+ → thưởng 6tr
        Schema::create('kpi_tiers', function (Blueprint $table) {
            $table->id();

            // Ngưỡng % KPI (so với target_revenue)
            $table->decimal('min_percent', 5, 1);           // VD: 80.0
            $table->decimal('max_percent', 5, 1)->nullable(); // VD: 99.9 | null = không giới hạn trên

            // Mức thưởng cố định (VNĐ)
            $table->decimal('bonus_amount', 20, 0)->default(0);

            // Hoặc thưởng theo % vượt chỉ tiêu (linh hoạt hơn)
            // VD: 2% của phần doanh thu vượt target
            $table->decimal('bonus_over_target_percent', 5, 2)->default(0);

            $table->text('label')->nullable(); // "Đạt một nửa", "Đạt chỉ tiêu", "Vượt trội"
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Seed dữ liệu mặc định phù hợp thực tế đại lý xe
        DB::table('kpi_tiers')->insert([
            [
                'min_percent'               => 0,
                'max_percent'               => 79.9,
                'bonus_amount'              => 0,
                'bonus_over_target_percent' => 0,
                'label'                     => 'Chưa đạt (dưới 80%)',
                'is_active'                 => true,
                'created_at'                => now(),
                'updated_at'                => now(),
            ],
            [
                'min_percent'               => 80,
                'max_percent'               => 99.9,
                'bonus_amount'              => 1_000_000,
                'bonus_over_target_percent' => 0,
                'label'                     => 'Đạt một nửa (80–99%)',
                'is_active'                 => true,
                'created_at'                => now(),
                'updated_at'                => now(),
            ],
            [
                'min_percent'               => 100,
                'max_percent'               => 119.9,
                'bonus_amount'              => 3_000_000,
                'bonus_over_target_percent' => 0,
                'label'                     => 'Đạt chỉ tiêu (100–119%)',
                'is_active'                 => true,
                'created_at'                => now(),
                'updated_at'                => now(),
            ],
            [
                'min_percent'               => 120,
                'max_percent'               => null, // Không giới hạn trên
                'bonus_amount'              => 3_000_000,
                'bonus_over_target_percent' => 2.0, // +2% phần vượt
                'label'                     => 'Vượt trội (từ 120%)',
                'is_active'                 => true,
                'created_at'                => now(),
                'updated_at'                => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('kpi_tiers');
    }
};
