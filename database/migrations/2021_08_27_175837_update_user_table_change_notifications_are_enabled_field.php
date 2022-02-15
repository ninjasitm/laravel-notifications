<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserTableChangeNotificationsAreEnabledField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            \DB::table('users')->update(['notifications_are_all_silent' => true]);
            $table->boolean('notifications_are_all_silent')->default(true)->change();
            $table->renameColumn('notifications_are_all_silent', 'notifications_are_enabled');
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
            \DB::table('users')->update(['notifications_are_enabled' => false]);
            $table->boolean('notifications_are_enabled')->default(false)->change();
            $table->renameColumn('notifications_are_enabled', 'notifications_are_all_silent');
        });
    }
}