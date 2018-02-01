<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CoinmarketcapsGlobalHistorical;

class CoinmarketcapsGlobalCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CoinmarketcapsGlobalCommand:CoinmarketcapsGlobal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $globalData = crawlUrl('https://api.coinmarketcap.com/v1/global/');
        $bitcoinData = crawlUrl('https://api.coinmarketcap.com/v1/ticker/bitcoin/');
        $ethereumData = crawlUrl('https://api.coinmarketcap.com/v1/ticker/ethereum/');
        $bitcoinCashData = crawlUrl('https://api.coinmarketcap.com/v1/ticker/bitcoin-cash/');
        $litecoinData = crawlUrl('https://api.coinmarketcap.com/v1/ticker/litecoin/');
        $rippleData = crawlUrl('https://api.coinmarketcap.com/v1/ticker/ripple/');
        $dashData = crawlUrl('https://api.coinmarketcap.com/v1/ticker/dash/');
        $moneroData = crawlUrl('https://api.coinmarketcap.com/v1/ticker/monero/');
        $nemData = crawlUrl('https://api.coinmarketcap.com/v1/ticker/nem/');
        $iotaData = crawlUrl('https://api.coinmarketcap.com/v1/ticker/iota/');
        $neoData = crawlUrl('https://api.coinmarketcap.com/v1/ticker/neo/');

        $coinMarketGlobal = new CoinmarketcapsGlobalHistorical();
        $coinMarketGlobal->total_market_cap = $globalData['total_market_cap_usd'];
        $coinMarketGlobal->total_24h_volume = $globalData['total_24h_volume_usd'];
        $coinMarketGlobal->total_market_cap_excluding_bitcoin = $globalData['total_market_cap_usd']-$bitcoinData[0]['market_cap_usd'];
        $coinMarketGlobal->total_24h_volume_excluding_bitcoin = $globalData['total_24h_volume_usd'] - $bitcoinData[0]['24h_volume_usd'];

        $coinMarketGlobal->percentage_btc = round(($bitcoinData[0]['market_cap_usd']/$globalData['total_market_cap_usd'])*100,2);
        $coinMarketGlobal->percentage_eth = round(($ethereumData[0]['market_cap_usd']/$globalData['total_market_cap_usd'])*100,2);
        $coinMarketGlobal->percentage_bch = round(($bitcoinCashData[0]['market_cap_usd']/$globalData['total_market_cap_usd'])*100,2);
        $coinMarketGlobal->percentage_ltc = round(($litecoinData[0]['market_cap_usd']/$globalData['total_market_cap_usd'])*100,2);
        $coinMarketGlobal->percentage_xrp = round(($rippleData[0]['market_cap_usd']/$globalData['total_market_cap_usd'])*100,2);
        $coinMarketGlobal->percentage_dash = round(($dashData[0]['market_cap_usd']/$globalData['total_market_cap_usd'])*100,2);
        $coinMarketGlobal->percentage_xmr = round(($moneroData[0]['market_cap_usd']/$globalData['total_market_cap_usd'])*100,2);
        $coinMarketGlobal->percentage_xem = round(($nemData[0]['market_cap_usd']/$globalData['total_market_cap_usd'])*100,2);
        $coinMarketGlobal->percentage_miota = round(($iotaData[0]['market_cap_usd']/$globalData['total_market_cap_usd'])*100,2);
        $coinMarketGlobal->percentage_neo = round(($neoData[0]['market_cap_usd']/$globalData['total_market_cap_usd'])*100,2);
        $coinMarketGlobal->percentage_others = 100 - ($coinMarketGlobal->percentage_btc + $coinMarketGlobal->percentage_eth + $coinMarketGlobal->percentage_bch + $coinMarketGlobal->percentage_ltc + $coinMarketGlobal->percentage_xrp + $coinMarketGlobal->percentage_dash + $coinMarketGlobal->percentage_xmr + $coinMarketGlobal->percentage_xem + $coinMarketGlobal->percentage_miota + $coinMarketGlobal->percentage_neo);

        $coinMarketGlobal->bitcoin_percentage_of_market_cap = $globalData['bitcoin_percentage_of_market_cap'];
        $coinMarketGlobal->active_currencies = $globalData['active_currencies'];
        $coinMarketGlobal->active_assets = $globalData['active_assets'];
        $coinMarketGlobal->active_markets = $globalData['active_markets'];
        $coinMarketGlobal->last_updated = $globalData['last_updated'];
        $coinMarketGlobal->save();
    }
}
