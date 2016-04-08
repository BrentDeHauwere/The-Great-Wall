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
            $table->foreign('choice_id')->references('id')->on('poll_choices')->onDelete('cascade');
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
            $table->dropForeign('poll_votes_choice_id_foreign');
        });
    }
}
