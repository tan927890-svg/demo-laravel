<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'assigned_to')) {
                $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('orders', 'consultation_status')) {
                $table->string('consultation_status')->default('chua_tu_van');
            }
            if (!Schema::hasColumn('orders', 'consulted_at')) {
                $table->timestamp('consulted_at')->nullable();
            }
            if (!Schema::hasColumn('orders', 'sale_price')) {
                $table->decimal('sale_price', 15, 0)->nullable();
            }
            if (!Schema::hasColumn('orders', 'commission_rate')) {
                $table->decimal('commission_rate', 5, 2)->nullable();
            }
            if (!Schema::hasColumn('orders', 'commission_amount')) {
                $table->decimal('commission_amount', 15, 0)->nullable();
            }
            if (!Schema::hasColumn('orders', 'closed_at')) {
                $table->timestamp('closed_at')->nullable();
            }
            if (!Schema::hasColumn('orders', 'manager_note')) {
                $table->text('manager_note')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $columns = [
                'assigned_to', 'consultation_status', 'consulted_at',
                'sale_price', 'commission_rate', 'commission_amount',
                'closed_at', 'manager_note',
            ];
            $existing = array_filter($columns, fn($c) => Schema::hasColumn('orders', $c));
            if ($existing) {
                $table->dropColumn(array_values($existing));
            }
        });
    }
};