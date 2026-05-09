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
        $table->decimal('overtime_hours', 5, 1)->default(0)->after('working_days');
        $table->unsignedInteger('overtime_rate')->default(0)->after('overtime_hours');
        $table->unsignedInteger('overtime_allowance')->default(0)->after('overtime_rate');
    });
}

public function down(): void
{
    Schema::table('payrolls', function (Blueprint $table) {
        $table->dropColumn(['overtime_hours', 'overtime_rate', 'overtime_allowance']);
    });
}
};
