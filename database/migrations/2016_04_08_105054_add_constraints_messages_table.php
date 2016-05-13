<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConstraintsMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->foreign('question_id')->references('id')->on('messages')->onDelete('cascade');
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
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign('messages_question_id_foreign');
            $table->dropForeign('messages_wall_id_foreign');
            $table->dropForeign('messages_channel_id_foreign');
            $table->dropForeign('messages_user_id_foreign');
            $table->dropForeign('messages_moderator_id_foreign');
        });
    }
}
