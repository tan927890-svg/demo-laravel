<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::table('car_variants', function (Blueprint $table) {
        $table->bigInteger('price_with_battery')->nullable()->after('price');
        $table->bigInteger('price_without_battery')->nullable()->after('price_with_battery');
    });
}

public function down(): void
{
    Schema::table('car_variants', function (Blueprint $table) {
        $table->dropColumn(['price_with_battery', 'price_without_battery']);
    });
}
};
