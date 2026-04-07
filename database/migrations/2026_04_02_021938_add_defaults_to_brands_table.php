<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->decimal('default_price_per_day', 15, 0)->nullable()->after('country');
            $table->string('default_fuel_type')->nullable()->after('default_price_per_day');
            $table->string('default_transmission')->nullable()->after('default_fuel_type');
            $table->integer('default_seats')->nullable()->after('default_transmission');
        });
    }

    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn([
                'default_price_per_day',
                'default_fuel_type',
                'default_transmission',
                'default_seats',
            ]);
        });
    }
};