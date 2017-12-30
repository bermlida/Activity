<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('venue', 512);
            $table->string('venue_intro')->nullable();
            $table->string('summary');
            $table->text('intro');

            $table->bigInteger('organizer_id')->unsigned();
            $table
                ->foreign('organizer_id')
                ->references('id')->on('organizers')
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
        Schema::drop('activities');
    }
}
