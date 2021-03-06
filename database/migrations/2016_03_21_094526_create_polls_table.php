<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polls', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wall_id')->unsigned();
            // Moderation_level: 0 = Accepted, 1 = Declined, 2 = User blokked
            $table->integer('user_id')->unsigned();
            $table->integer('moderator_id')->unsigned()->nullable();
            $table->integer('channel_id')->unsigned();
            $table->longText('question');
            $table->boolean('addable');
            $table->tinyInteger('moderation_level')->default(0);
            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('polls');
    }
}
