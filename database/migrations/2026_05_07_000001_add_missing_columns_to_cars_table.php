<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            if (!Schema::hasColumn('cars', 'content')) {
                $table->longText('content')->nullable()->after('description');
            }
            if (!Schema::hasColumn('cars', 'tagline')) {
                $table->string('tagline', 255)->nullable()->after('name');
            }
            if (!Schema::hasColumn('cars', 'model')) {
                $table->string('model', 255)->nullable()->after('name');
            }
            if (!Schema::hasColumn('cars', 'cost_price')) {
                $table->decimal('cost_price', 15, 2)->nullable()->after('price_per_day');
            }
            if (!Schema::hasColumn('cars', 'sale_price')) {
                $table->decimal('sale_price', 15, 2)->nullable()->after('cost_price');
            }
            if (!Schema::hasColumn('cars', 'mileage')) {
                $table->unsignedInteger('mileage')->nullable()->after('seats');
            }
            if (!Schema::hasColumn('cars', 'condition')) {
                $table->string('condition', 50)->nullable()->after('mileage');
            }
            if (!Schema::hasColumn('cars', 'year')) {
                $table->unsignedSmallInteger('year')->nullable()->after('condition');
            }
            if (!Schema::hasColumn('cars', 'horsepower')) {
                $table->unsignedInteger('horsepower')->nullable()->after('year');
            }
            if (!Schema::hasColumn('cars', 'fuel_consumption')) {
                $table->string('fuel_consumption', 20)->nullable()->after('horsepower');
            }
            if (!Schema::hasColumn('cars', 'hero_image')) {
                $table->string('hero_image', 500)->nullable()->after('image_url');
            }
            if (!Schema::hasColumn('cars', 'badge_label')) {
                $table->string('badge_label', 50)->nullable();
            }
            if (!Schema::hasColumn('cars', 'image_360_prefix')) {
                $table->string('image_360_prefix', 100)->nullable();
            }
            if (!Schema::hasColumn('cars', 'image_360_frames')) {
                $table->unsignedTinyInteger('image_360_frames')->nullable();
            }
            if (!Schema::hasColumn('cars', 'slug')) {
                $table->string('slug', 255)->nullable()->unique();
            }
            if (!Schema::hasColumn('cars', 'meta_description')) {
                $table->string('meta_description', 500)->nullable();
            }
            if (!Schema::hasColumn('cars', 'is_featured')) {
                $table->boolean('is_featured')->default(false);
            }
            if (!Schema::hasColumn('cars', 'is_available')) {
                $table->boolean('is_available')->default(true);
            }
        });
    }

    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $cols = [
                'content','tagline','model','cost_price','sale_price',
                'mileage','condition','year','horsepower','fuel_consumption',
                'hero_image','badge_label','image_360_prefix','image_360_frames',
                'slug','meta_description','is_featured','is_available',
            ];
            foreach ($cols as $col) {
                if (Schema::hasColumn('cars', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
