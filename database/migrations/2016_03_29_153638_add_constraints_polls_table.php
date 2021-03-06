<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConstraintsPollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('polls', function (Blueprint $table) {
            $table->foreign('wall_id')->references('id')->on('walls')->onDelete('cascade');
            $table->foreign('channel_id')->references('id')->on('channels')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('moderator_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('polls', function (Blueprint $table) {
            $table->dropForeign('polls_wall_id_foreign');
            $table->dropForeign('polls_channel_id_foreign');
            $table->dropForeign('polls_user_id_foreign');
            $table->dropForeign('polls_moderator_id_foreign');
        });
    }
}
