<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssignFieldsToContactsTable extends Migration
{
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->unsignedBigInteger('assigned_to')->nullable()->after('is_read');
            $table->text('staff_note')->nullable()->after('assigned_to');
            $table->timestamp('assigned_at')->nullable()->after('staff_note');
            $table->string('assign_status')->default('new')->after('assigned_at');
            // new | assigned | done

            $table->foreign('assigned_to')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropForeign(['assigned_to']);
            $table->dropColumn(['assigned_to', 'staff_note', 'assigned_at', 'assign_status']);
        });
    }
}