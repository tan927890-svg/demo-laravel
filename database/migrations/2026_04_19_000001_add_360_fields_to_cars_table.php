<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            // Số frame ảnh 360 (mặc định 8)
            if (!Schema::hasColumn('cars', 'image_360_frames')) {
                $table->unsignedTinyInteger('image_360_frames')->default(8)->after('image_360_prefix');
            }
            // badge_label: badge hiển thị trên card nổi bật (Flagship, Biểu tượng, ...)
            // Tên trường khớp với $fillable trong Car model
            if (!Schema::hasColumn('cars', 'badge_label')) {
                $table->string('badge_label', 60)->nullable()->after('image_360_frames');
            }
        });
    }

    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            if (Schema::hasColumn('cars', 'image_360_frames')) {
                $table->dropColumn('image_360_frames');
            }
            if (Schema::hasColumn('cars', 'badge_label')) {
                $table->dropColumn('badge_label');
            }
        });
    }
};