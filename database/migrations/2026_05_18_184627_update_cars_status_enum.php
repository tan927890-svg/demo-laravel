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
    DB::statement("ALTER TABLE cars MODIFY COLUMN status ENUM('available','out_of_stock','coming_soon','sold') NOT NULL DEFAULT 'available'");
}

public function down(): void
{
    DB::statement("ALTER TABLE cars MODIFY COLUMN status ENUM('available','out_of_stock','coming_soon') NOT NULL DEFAULT 'available'");
}
};
