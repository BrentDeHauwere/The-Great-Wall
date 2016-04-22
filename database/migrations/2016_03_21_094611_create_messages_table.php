<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('question_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('moderator_id')->unsigned()->nullable();
            $table->integer('wall_id')->unsigned();
            $table->integer('channel_id')->unsigned();
            $table->longText('text');
            $table->dateTime('created_at');
            $table->boolean('anonymous');
            // Moderation_level: 0 = Accepted, 1 = Declined, 2 = User blokked
            $table->tinyInteger('moderation_level')->default(0);
            $table->integer('count')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('messages');
    }
}
