<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOhlc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ohlc',function (Blueprint $table){
            $table->increments('id');
            $table->integer('market_id');
            $table->integer('pair_id');
            $table->integer('key');
            $table->string('date');
            $table->double('open',20,8);
            $table->double('high',20,8);
            $table->double('low',20,8);
            $table->double('close',20,8);
            $table->double('volume',25,10);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ohlc');
    }
}
