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
            $table->bigIncrements('id');
            $table->bigInteger('activity_id')->unsigned();
            $table->string('subject');
            $table->text('content');
            $table->json('sending_method');
            $table->json('sending_target');
            $table->dateTime('sending_time');
            $table->integer('status');

            $table
                ->foreign('activity_id')
                ->references('id')->on('activities')
                ->onDelete('cascade');
            
            $table->timestamps();
            $table->softDeletes();
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
