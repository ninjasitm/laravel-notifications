<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'notifications', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('created_by')->nullable();
                $table->string('icon', 50)->nullable();
                $table->text('body');
                $table->string('action_text')->nullable();
                $table->text('action_url')->nullable();
                $table->tinyInteger('read')->default(0);
                $table->timestamps();

                $table->index(['user_id', 'created_at']);
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('notifications');
    }
}