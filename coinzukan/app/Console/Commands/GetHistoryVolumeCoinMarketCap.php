<?php

namespace App\Console\Commands;

use App\Models\Pair;
use App\Models\Orderbook;
use App\Models\Trades;
use App\Models\Ohlc;
use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\VolumeHistory;
use Goutte;
use Helper;

class GetHistoryVolumeCoinMarketCap extends Command
{
    protected $signature = 'gethistoryvolumecoimarketcap:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command line will get history 1d, 7d, 30d volume from coinmarketcap';

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

    public function handle(){
        $data = [];
        $this->info('Start : '. Carbon::now());
        $crawler = Goutte::request('GET', 'https://coinmarketcap.com/currencies/volume/monthly/');
        $crawler->filterXPath('//table[@id="currencies-volume"]/tbody/tr')->each(function ($node) use (&$data, &$name, &$symbol, &$volume_24h_usd, &$volume_7d_usd, &$volume_30d_usd, &$volume_24h_btc, &$volume_7d_btc, &$volume_30d_btc) {
            $node->filter('td')->each(function ($item, $index) use (&$data, &$name, &$symbol, &$volume_24h_usd, &$volume_7d_usd, &$volume_30d_usd, &$volume_24h_btc, &$volume_7d_btc, &$volume_30d_btc) {
                if ($index == 1) {
                    $item->filter('.currency-name')->each(function ($text) use (&$data, &$name) {
                        $name = preg_replace('/\s/u', '', $text->text());
                    });
                }
                if ($index == 2) {
                    $symbol = preg_replace('/\s/u', '', $item->text());
                }
                if ($index == 3) {
                    $item->filter('.volume')->each(function ($attr) use (&$data, &$volume_24h_usd, &$volume_24h_btc){
                        $volume_24h_usd = $attr->attr('data-usd');
                        $volume_24h_btc = $attr->attr('data-btc');
                    });
                }
                if ($index == 4) {
                    $item->filter('.volume')->each(function ($attr) use (&$data, &$volume_7d_usd, &$volume_7d_btc){
                        $volume_7d_usd = $attr->attr('data-usd');
                        $volume_7d_btc = $attr->attr('data-btc');
                    });
                }
                if ($index == 5) {
                    $item->filter('.volume')->each(function ($dataUsd) use (&$data, &$volume_30d_usd, &$volume_30d_btc){
                        $volume_30d_usd = $dataUsd->attr('data-usd');
                        $volume_30d_btc = $dataUsd->attr('data-btc');
                    });
                    $data[] = [
                        'name' => $name,
                        'symbol' => $symbol,
                        'volume_24h_usd'    => $volume_24h_usd,
                        'volume_7d_usd'    => $volume_7d_usd,
                        'volume_30d_usd'    => $volume_30d_usd,
                        'volume_24h_btc'    => $volume_24h_btc,
                        'volume_7d_btc'    => $volume_7d_btc,
                        'volume_30d_btc'    => $volume_30d_btc,
                    ];
                }
            });
        });
        VolumeHistory::truncate();
        VolumeHistory::insert($data);
        $this->info('End : '. Carbon::now());
    }
}