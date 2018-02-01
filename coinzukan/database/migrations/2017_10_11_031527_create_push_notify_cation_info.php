<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePushNotifyCationInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('push_notfication', function (Blueprint $table) {
            $table->increments('id');
            // foreign key to `coin_convert_id` table
            $table->integer('market_id')->unsigned();
            $table->string('token');
            $table->string('uuid');
            $table->string('device_os')->comment('and: Android ,ios: IOS');            
            $table->string('base_target');
            $table->double('value_above');
            $table->double('value_below');
            $table->boolean('status')->comment('0: ON ,1: OFF');
            $table->boolean('type_push')->comment('0: one time ,1: presistent');
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
        Schema::dropIfExists('push_notfication');
    }
}
