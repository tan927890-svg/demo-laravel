<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            if (!Schema::hasColumn('cars', 'tagline')) {
                $table->string('tagline')->nullable()->after('name');
            }
            if (!Schema::hasColumn('cars', 'hero_image')) {
                $table->string('hero_image')->nullable()->after('image_url');
            }
            if (!Schema::hasColumn('cars', 'description')) {
                $table->text('description')->nullable()->after('hero_image');
            }
            if (!Schema::hasColumn('cars', 'status')) {
                $table->string('status')->default('available')->after('description');
            }
            if (!Schema::hasColumn('cars', 'fuel_type')) {
                $table->string('fuel_type')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $cols = ['tagline', 'hero_image', 'description', 'status', 'fuel_type'];
            $existing = array_filter($cols, fn($c) => Schema::hasColumn('cars', $c));
            if ($existing) $table->dropColumn(array_values($existing));
        });
    }
};