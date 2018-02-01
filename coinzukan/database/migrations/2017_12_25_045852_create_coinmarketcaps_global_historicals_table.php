<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoinmarketcapsGlobalHistoricalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coinmarketcaps_global_historicals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('total_market_cap', 20);
            $table->string('total_24h_volume', 20);
            $table->string('total_market_cap_excluding_bitcoin', 20);
            $table->string('total_24h_volume_excluding_bitcoin', 20);
            $table->double('percentage_btc', 8,2);
            $table->double('percentage_eth', 8,2);
            $table->double('percentage_bch', 8,2);
            $table->double('percentage_ltc', 8,2);
            $table->double('percentage_xrp', 8,2);
            $table->double('percentage_dash', 8,2);
            $table->double('percentage_xmr', 8,2);
            $table->double('percentage_xem', 8,2);
            $table->double('percentage_miota', 8,2);
            $table->double('percentage_neo', 8,2);
            $table->double('percentage_others', 8,2);
            $table->double('bitcoin_percentage_of_market_cap', 8, 2);
            $table->integer('active_currencies');
            $table->integer('active_assets');
            $table->integer('active_markets');
            $table->string('last_updated', 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coinmarketcaps_global_historicals');
    }
}
