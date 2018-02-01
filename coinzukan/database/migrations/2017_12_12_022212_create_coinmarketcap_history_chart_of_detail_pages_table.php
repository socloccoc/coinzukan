<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoinmarketcapHistoryChartOfDetailPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coinmarketcap_history_chart_of_detail_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('symbol');
            $table->integer('rank')->unsigned();
            $table->double('price_usd',20,8);
            $table->double('price_btc',20,8);
            $table->double('24h_volume_usd',20,2);
            $table->double('market_cap_usd',20,2);
            $table->double('available_supply',20,2);
            $table->double('total_supply',20,2);
            $table->double('percent_change_1h',20,2);
            $table->double('percent_change_24h',20,2);
            $table->double('percent_change_7d',20,2);
            $table->double('percent_of_total_market',20,2);
            $table->string('last_updated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coinmarketcap_history_chart_of_detail_pages');
    }
}
