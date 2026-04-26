<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_add_is_featured_to_cars_table.php
public function up(): void
{
    Schema::table('cars', function (Blueprint $table) {
        $table->boolean('is_featured')->default(false)->after('status');
        $table->string('badge_label')->nullable()->after('is_featured'); // "Flagship", "Bán chạy"...
    });
}
public function down(): void
{
    Schema::table('cars', function (Blueprint $table) {
        $table->dropColumn(['is_featured', 'badge_label']);
    });
}
};
