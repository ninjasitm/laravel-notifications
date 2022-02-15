<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsForAdminsFieldToNotificationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notification_types', function (Blueprint $table) {
            $table->boolean('for_admin_only')->default(false);
            $table->boolean('for_mentors')->default(false);
            $table->text('group')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notification_types', function (Blueprint $table) {
            $table->dropColumn('for_admin_only');
            $table->dropColumn('for_mentors');
            $table->dropColumn('group');
        });
    }
}