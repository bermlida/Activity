<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApplyColumnsToActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activities', function ($table) {
            $table->dateTime('apply_start_time');
            $table->dateTime('apply_end_time');
            $table->integer('apply_fee');
            $table->boolean('can_sponsored');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activities', function ($table) {
            $table->dropColumn('apply_start_time');
            $table->dropColumn('apply_end_time');
            $table->dropColumn('apply_fee');
            $table->dropColumn('can_sponsored');
        });
    }
}
