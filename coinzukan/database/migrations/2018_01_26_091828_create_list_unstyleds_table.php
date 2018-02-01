<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListUnstyledsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_unstyleds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coin_name');
            $table->string('glyphicon1');
            $table->string('title1');
            $table->string('link1');
            $table->string('glyphicon2');
            $table->string('title2');
            $table->string('link2');
            $table->string('glyphicon3');
            $table->string('title3');
            $table->string('link3');
            $table->string('glyphicon4');
            $table->string('title4');
            $table->string('link4');
            $table->string('glyphicon5');
            $table->string('title5');
            $table->string('link5');
            $table->string('glyphicon6');
            $table->string('title6');
            $table->string('link6');
            $table->string('glyphicon7');
            $table->string('title7');
            $table->string('link7');
            $table->string('glyphicon8');
            $table->string('title8');
            $table->string('link8');
            $table->string('glyphicon9');
            $table->string('title9');
            $table->string('link9');
            $table->string('glyphicon10');
            $table->string('title10');
            $table->string('link10');
            $table->string('glyphicon11');
            $table->string('title11');
            $table->string('link11');
            $table->string('glyphicon12');
            $table->string('title12');
            $table->string('link12');
            $table->string('glyphicon13');
            $table->string('title13');
            $table->string('link13');
            $table->string('glyphicon14');
            $table->string('title14');
            $table->string('link14');
            $table->string('glyphicon15');
            $table->string('title15');
            $table->string('link15');
            $table->string('rank');
            $table->string('label1');
            $table->string('label2');
            $table->string('label3');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('list_unstyleds');
    }
}
