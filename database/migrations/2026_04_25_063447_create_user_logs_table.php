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
    Schema::create('user_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->foreignId('causer_id')->nullable()->constrained('users')->nullOnDelete();
        $table->string('action'); // 'updated', 'password_reset_by_admin', 'password_reset_self'
        $table->json('changes')->nullable(); // [{field, old, new}]
        $table->timestamps();
    });
}
};
