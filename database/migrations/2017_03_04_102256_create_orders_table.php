<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('serial_number')->unique();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('activity_id')->unsigned();
            $table->integer('status');
            $table->string('status_info')->nullable();

            $table
                ->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
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
        Schema::drop('orders');
    }
}
