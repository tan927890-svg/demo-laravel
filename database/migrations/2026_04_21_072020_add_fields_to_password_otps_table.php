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
    Schema::table('password_otps', function (Blueprint $table) {
        $table->string('email')->index()->after('id');
        $table->string('otp')->after('email');
        $table->string('ip_address')->nullable()->after('otp');
        $table->boolean('used')->default(false)->after('ip_address');
        $table->timestamp('expires_at')->nullable()->after('used');
    });
}

public function down(): void
{
    Schema::table('password_otps', function (Blueprint $table) {
        $table->dropColumn(['email', 'otp', 'ip_address', 'used', 'expires_at']);
    });
}
};
