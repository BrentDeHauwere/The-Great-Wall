<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConstraintsMessageVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('message_votes', function (Blueprint $table) {
            $table->foreign('message_id')->references('id')->on('messages')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
            $table->primary(['message_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('message_votes', function (Blueprint $table) {
            $table->dropForeign('message_votes_message_id_foreign');
            $table->dropForeign('message_votes_user_id_foreign');
            $table->dropPrimary('message_votes_message_id_user_id_primary');
        });
    }
}
