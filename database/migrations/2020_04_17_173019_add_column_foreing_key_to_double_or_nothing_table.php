<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnForeingKeyToDoubleOrNothingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('double_or_nothing', function (Blueprint $table) {
            $table->foreign('duel_id')->references('id')->on('duels');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('double_or_nothing', function (Blueprint $table) {
            //
        });
    }
}
