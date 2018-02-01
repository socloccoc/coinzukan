<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trades',function (Blueprint $table){
            $table->increments('id');
            $table->integer('market_id');
            $table->integer('trades_id');
            $table->integer('pair_id');
            $table->string('date');
            $table->double('rate');
            $table->double('amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trades');
    }
}
