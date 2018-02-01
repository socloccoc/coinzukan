<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\MarketCapNewCurrency;
use Goutte;
use Helper;

class GetNewCurrencyMarketCap extends Command
{
    protected $signature = 'getNewCurrencyMarketcap:Start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command line will get new currency from coinmarketcap';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(){
        $data = [];
        $this->info('Start : '. Carbon::now());
        $crawler = Goutte::request('GET', 'https://coinmarketcap.com/new/');
        $crawler->filterXPath('//table[@class="table"]/tbody/tr')->each(function ($node) use (&$data, &$name, &$symbol, &$added, &$marketcap, &$price, &$circulating_supply, &$volume_24h, &$percent_change_24h) {
            $node->filter('td')->each(function ($item, $index) use (&$data, &$name, &$symbol, &$added, &$marketcap, &$price, &$circulating_supply, &$volume_24h, &$percent_change_24h) {
                if ($index == 0) {
                    $item->filter('.currency-name')->each(function ($text) use (&$data, &$name) {
                        $name = preg_replace('/\s/u', '', $text->text());
                    });
                }

                if ($index == 1) {
                    $symbol = preg_replace('/\s/u', '', $item->text());

                }
                if ($index == 2) {
                    $added = preg_replace('/\s/u', '', $item->text());
                }
                if ($index == 3) {
                    $item->filter('.market-cap')->each(function ($attr) use (&$data, &$marketcap){
                        $marketcap = $attr->attr('data-usd');
                    });

                }
                if ($index == 4) {
                    $item->filter('.price')->each(function ($attr) use (&$data, &$price){
                        $price = $attr->attr('data-usd');
                    });
                }

                if ($index == 5) {
                    $item->filter('a')->each(function ($attr) use (&$data, &$circulating_supply){
                        $circulating_supply = $attr->attr('data-supply');
                    });
                }
                if ($index == 6) {
                    $item->filter('.volume')->each(function ($attr) use (&$data, &$volume_24h){
                        $volume_24h = $attr->attr('data-usd');
                    });
                }
                if ($index == 7) {
                    $item->filter('.negative_change')->each(function ($attr) use (&$data, &$percent_change_24h){
                        $percent_change_24h = $attr->attr('data-usd');
                    });

                    $data[] = [
                        'name' => $name,
                        'symbol' => $symbol,
                        'added' =>  $added,
                        'marketcap' =>  $marketcap,
                        'price' =>  $price,
                        'circulating_supply'    =>  $circulating_supply,
                        'volume_24h'    =>  $volume_24h,
                        'percent_change_24h'    =>  $percent_change_24h
                    ];
                }
            });
        });
        
        MarketCapNewCurrency::truncate();
        MarketCapNewCurrency::insert($data);
        $this->info('End : '. Carbon::now());
    }

}