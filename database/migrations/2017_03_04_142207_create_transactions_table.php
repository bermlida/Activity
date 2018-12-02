<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id')->unsigned()->nullable();
            $table->string('serial_number')->unique();
            $table->string('order_serial_number');
            $table->integer('amount')->unsigned();
            // $table->integer('apply_fee')->unsigned();
            // $table->integer('sponsorship_amount')->unsigned();
            $table->json('payment_info')->nullable();
            $table->json('payment_result')->nullable();
            $table->integer('status');
            $table->string('status_info')->nullable();

            $table
                ->foreign('order_serial_number')
                ->references('serial_number')->on('orders')
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
        Schema::drop('transactions');
    }
}
