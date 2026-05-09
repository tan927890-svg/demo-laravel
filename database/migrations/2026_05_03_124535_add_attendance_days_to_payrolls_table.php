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
    Schema::table('payrolls', function (Blueprint $table) {
        $table->unsignedTinyInteger('valid_days')->default(0)->after('kpi_percent');
        $table->unsignedTinyInteger('working_days')->default(30)->after('valid_days');
    });
}

public function down(): void
{
    Schema::table('payrolls', function (Blueprint $table) {
        $table->dropColumn(['valid_days', 'working_days']);
    });
}
};
