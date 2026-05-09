<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            if (!Schema::hasColumn('cars', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('status');
            }
            if (!Schema::hasColumn('cars', 'badge_label')) {
                $table->string('badge_label')->nullable()->after('is_featured');
            }
        });
    }

    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn(
                array_filter(
                    ['is_featured', 'badge_label'],
                    fn($col) => Schema::hasColumn('cars', $col)
                )
            );
        });
    }
};