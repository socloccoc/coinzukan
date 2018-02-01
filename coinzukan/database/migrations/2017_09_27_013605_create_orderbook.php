<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderbook extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_book',function (Blueprint $table){
           $table->increments('id');
            $table->integer('market_id');
            $table->integer('pair_id');
            $table->string('type');
            $table->double('price');
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
        //
        Schema::dropIfExists('order_book');
    }
}
