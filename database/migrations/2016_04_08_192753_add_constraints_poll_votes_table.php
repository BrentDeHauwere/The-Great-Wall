<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConstraintsPollVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('poll_votes', function (Blueprint $table) {
            $table->foreign('poll_choice_id')->references('id')->on('poll_choices')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
            $table->primary(['poll_choice_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('poll_votes', function (Blueprint $table) {
            $table->dropForeign('poll_votes_poll_choice_id_foreign');
            $table->dropForeign('poll_votes_user_id_foreign');
            $table->dropPrimary('poll_votes_choice_id_user_id_primary');
        });
    }
}
