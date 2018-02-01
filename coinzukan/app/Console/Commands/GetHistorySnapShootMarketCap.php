<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\HistorySnapShoot;
use Goutte;
use Helper;

class GetHistorySnapShootMarketCap extends Command
{
    protected $signature = 'getSnapShootHistory:Start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command line will get history snapshoot from coinmarketcap';

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
     * This function start crawl data from https://coinmarketcap.com/historical/
     */
    public function handle(){
        //truncate data before crawl data
        HistorySnapShoot::truncate();
        $this->info('Start : '. Carbon::now());
        $crawler = Goutte::request('GET', 'https://coinmarketcap.com/historical/');
        // init name, symbol, marketcap_usd, marketcap_btc, price_usd, price_btc, circulating_supply, percent_1h_usd, percent_1h_btc, percent_24h_usd, percent_24h_btc, percent_7d_usd, percent_7d_btc
        // filler a in ul > li
        $crawler->filterXPath('//ul[@class="list-unstyled"]/li/a')->each(function ($node) use (&$name, &$symbol, &$marketcap_usd, &$marketcap_btc, &$price_usd, &$price_btc, &$circulating_supply, &$percent_1h_usd, &$percent_1h_btc, &$percent_24h_usd, &$percent_24h_btc, &$percent_7d_usd, &$percent_7d_btc){
            // get href
            $href = $node->attr('href');
            // $data['date']
            $date = explode('/', $href)[2];
            // start crawl data with href
            $crawlerLink = Goutte::request('GET', 'https://coinmarketcap.com'. $href);
            // fill table > tbody > tr
            $crawlerLink->filterXPath('//table[@id="currencies-all"]/tbody/tr')->each(function ($node) use (&$name, &$symbol, &$marketcap_usd, &$marketcap_btc, &$price_usd, &$price_btc, &$circulating_supply, &$percent_1h_usd, &$percent_1h_btc, &$percent_24h_usd, &$percent_24h_btc, &$percent_7d_usd, &$percent_7d_btc, &$date) {
                $data = [];
                $node->filter('td')->each(function ($item, $index) use (&$data, &$name, &$symbol, &$marketcap_usd, &$marketcap_btc, &$price_usd, &$price_btc, &$circulating_supply, &$percent_1h_usd, &$percent_1h_btc, &$percent_24h_usd, &$percent_24h_btc, &$percent_7d_usd, &$percent_7d_btc, &$date) {
                    // td first
                    if ($index == 1) {
                        $item->filter('img')->each(function ($text) use (&$data, &$name) {
                            $name = $text->attr('alt');
                        });
                    }
                    //td second
                    if ($index == 2) {
                        $symbol = preg_replace('/\s/u', '', $item->text());
                    }
                    // td third
                    if ($index == 3) {
                        $item->filter('.market-cap')->each(function ($attr) use (&$data, &$marketcap_usd, &$marketcap_btc){
                            $marketcap_usd = $attr->attr('data-usd');
                            $marketcap_btc = $attr->attr('data-btc');
                        });
                    }
                    // td fourth
                    if ($index == 4) {
                        $item->filter('.price')->each(function ($attr) use (&$data, &$price_usd, &$price_btc){
                            $price_usd = $attr->attr('data-usd');
                            $price_btc = $attr->attr('data-btc');
                        });
                    }
                    // td fifth
                    if ($index == 5) {
                        $item->filter('a')->each(function ($attr) use (&$data, &$circulating_supply){
                            $circulating_supply = $attr->attr('data-supply');
                        });
                    }
                    // td sixth
                    if ($index == 7) {
                        $percent_1h_usd = $item->attr('data-usd') != null ? $item->attr('data-usd') : '';
                        $percent_1h_btc = $item->attr('data-btc') != null ? $item->attr('data-btc') : '';
                    }
                    // td seventh
                    if ($index == 8) {
                        $percent_24h_usd = $item->attr('data-usd') != null ? $item->attr('data-usd') : '';
                        $percent_24h_btc = $item->attr('data-btc') != null ? $item->attr('data-btc') : '';
                    }
                    // td eighth
                    if ($index == 9) {
                        $percent_7d_usd = $item->attr('data-usd') != null ? $item->attr('data-usd') : '';
                        $percent_7d_btc = $item->attr('data-btc') != null ? $item->attr('data-btc') : '';
                        // Assign data
                        $data[] = [
                            'date' =>  $date,
                            'name' => $name,
                            'symbol' => $symbol,
                            'marketcap_usd' =>  $marketcap_usd,
                            'marketcap_btc' =>  $marketcap_btc,
                            'price_usd' =>  $price_usd,
                            'price_btc' =>  $price_btc,
                            'circulating_supply'    =>  $circulating_supply,
                            'percent_1h_usd'    =>  $percent_1h_usd,
                            'percent_1h_btc'    =>  $percent_1h_btc,
                            'percent_24h_usd'   =>  $percent_24h_usd,
                            'percent_7d_usd'    =>  $percent_7d_usd,
                            'percent_7d_btc'    =>  $percent_7d_btc
                        ];
                    }
                });
                // save data
                HistorySnapShoot::insert($data);
            });

        });

    }


}
