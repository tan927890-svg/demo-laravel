<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('bao_gia_nhanh', function (Blueprint $table) {
        $table->id();
        $table->string('ten');
        $table->string('so_dien_thoai');
        $table->string('dong_xe')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bao_gia_nhanh');
    }
};
