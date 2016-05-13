<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConstraintsPollChoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('poll_choices', function (Blueprint $table) {
            $table->foreign('poll_id')->references('id')->on('polls')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('poll_choices', function (Blueprint $table) {
            $table->dropForeign('poll_choices_poll_id_foreign');
            $table->dropForeign('poll_choices_user_id_foreign');

        });
    }
}
