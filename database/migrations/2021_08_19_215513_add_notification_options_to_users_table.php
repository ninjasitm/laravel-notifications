<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotificationOptionsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('notifications_are_all_silent')->default(false);
            $table->time('notifications_silent_from')->nullable();
            $table->time('notifications_silent_to')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('notifications_are_all_silent');
            $table->dropColumn('notifications_silent_from');
            $table->dropColumn('notifications_silent_to');
        });
    }
}