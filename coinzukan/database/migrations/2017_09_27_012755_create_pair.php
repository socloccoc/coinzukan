<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePair extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('pair',function(Blueprint $table){
            $table->increments('id');
            $table->integer('market_id');
            $table->string('name');
            $table->string('base');
            $table->string('target');
            $table->double('price',20,8);
            $table->double('last24hr',20,8);
            $table->double('high24hr',20,8);
            $table->double('low24hr',20,8);
            $table->double('baseVolume',20,8);
            $table->double('percentChange24hr',20,8);
            $table->double('changeAbsolute24hr',20,8);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('pair');
    }
}
