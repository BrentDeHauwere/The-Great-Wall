<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollChoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poll_choices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('poll_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->longText('text');
            $table->integer('count')->unsigned()->default(0);
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
        Schema::drop('poll_choices');
    }
}
