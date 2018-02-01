<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Coinmarketcap;
use App\Models\MarketCapCoinConvert;
use App\Models\Tokens;
use App\Models\CoinmarketcapPriceHistoricals;
use App\Models\CoinmarketcapHistoryChartOfDetailPage;
use App\Models\ImageOfChart;
use Carbon\Carbon;
use Goutte;
use Response;

class CoinmarketcapsCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'CoinmarketcapsCommand:Coinmarketcaps';

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
    $this->info(Carbon::now());
    $this->getALlChart();
    $this->crawlTokents();
    $marketcapGlobal = crawlUrl('https://api.coinmarketcap.com/v1/global/');
    $totalMarketcap = $marketcapGlobal['total_market_cap_usd'];
    $data = crawlUrl('https://api.coinmarketcap.com/v1/ticker/?start=0&limit=10000');
    foreach ($data as $item) {
      $listCoin[] = [
        'name' => isset($item['name']) ? $item['name'] : '',
        'symbol' => isset($item['symbol']) ? $item['symbol'] : '',
        'rank' => isset($item['rank']) ? $item['rank'] : '',
        'price_usd' => isset($item['price_usd']) ? $item['price_usd'] : '',
        'price_btc' => isset($item['price_btc']) ? $item['price_btc'] : '',
        '24h_volume_usd' => isset($item['24h_volume_usd']) ? $item['24h_volume_usd'] : '',
        'market_cap_usd' => isset($item['market_cap_usd']) ? $item['market_cap_usd'] : '',
        'available_supply' => isset($item['available_supply']) ? $item['available_supply'] : '',
        'total_supply' => isset($item['total_supply']) ? $item['total_supply'] : '',
        'max_supply' => isset($item['max_supply']) ? $item['max_supply'] : '',
        'percent_change_1h' => isset($item['percent_change_1h']) ? $item['percent_change_1h'] : '',
        'percent_change_24h' => isset($item['percent_change_24h']) ? $item['percent_change_24h'] : '',
        'percent_change_7d' => isset($item['percent_change_7d']) ? $item['percent_change_7d'] : '',
        'last_updated' => isset($item['last_updated']) ? $item['last_updated'] : ''
      ];
      $priceHistory[] = [
        'name' => isset($item['name']) ? $item['name'] : '',
        'price' => isset($item['price_usd']) ? $item['price_usd'] : '',
        'percent_of_total_market' => isset($item['market_cap_usd']) ? round(((float)$item['market_cap_usd']/(float)$totalMarketcap)*100,2) : 0,
        'date' => isset($item['last_updated']) ? $item['last_updated'] : '',
      ];
    }
    Coinmarketcap::truncate();
    Coinmarketcap::insert($listCoin);
    CoinmarketcapHistoryChartOfDetailPage::insert($listCoin);
    $checkSavePriceHistoricals = file_get_contents('public/test.txt');
    if($checkSavePriceHistoricals % 60 == 0) {
        CoinmarketcapPriceHistoricals::insert($priceHistory);
    }
    file_put_contents('public/test.txt',$checkSavePriceHistoricals+1);
    $this->info(Carbon::now());
  }

  public function crawlTokents(){
    $data = [];
    $name = '';

    $crawler = Goutte::request('GET', 'https://coinmarketcap.com/tokens/views/all/');
    $crawler->filterXPath('//table[@id="assets-all"]/tbody/tr')->each(function ($node) use (&$data, &$name, &$platform) {
      $node->filter('td')->each(function ($item, $index) use (&$data, &$name, &$platform) {
        if ($index == 1) {
          $item->filter('.currency-name-container')->each(function ($text) use (&$data, &$name) {
            $name = preg_replace('/\s/u', '', $text->text());
          });
        }
        if ($index == 2) {
          $platForm = preg_replace('/\s/u', '', $item->text()) . "\n";
          $data[] = [
            'name' => $name,
            'platform' => $platForm
          ];
        }
      });
    });
    Tokens::truncate();
    Tokens::insert($data);
  }

  public function getALlChart(){
    $name = '';
    $image = '';
    $circulatingUrl = '';
    $data = [];
    $dataGlobal = crawlUrl('https://api.coinmarketcap.com/v1/global/');
    $totalCurrencies = $dataGlobal['active_currencies'] + $dataGlobal['active_assets'];
    for($i = 1; $i <= ceil($totalCurrencies/100) ; $i++) {
      $crawler = Goutte::request('GET', 'https://coinmarketcap.com/'.$i);
      $crawler->filterXPath('//table[@id="currencies"]/tbody/tr')->each(function ($node) use (&$name, &$image, &$data , &$circulatingUrl) {
        $node->filter('td')->each(function ($item, $index) use (&$name, &$image, &$data, &$circulatingUrl) {
          if ($index == 1) {
            $item->filter('.currency-name-container')->each(function ($text) use (&$name, &$image) {
              $name = $text->text();
            });
          }

          if($index == 5){
              $item->filter('a')->each(function ($text) use (&$circulatingUrl) {
                  $circulatingUrl = $text->attr('href');
              });
          }

          if ($index == 7) {
            $item->filter('img')->each(function ($text) use (&$name, &$image) {
              file_put_contents('public/images/charts/' . preg_replace('/[~%&\\;:"\',\/<>?#\s]/', '', $name) . '.png', file_get_contents($text->attr('src')));
            });
          }
        });

        $data[] = [
            'name' => $name,
            'circulatingUrl' => $circulatingUrl,
            'image' => 'images/charts/' . preg_replace('/[~%&\\;:"\',\/<>?#\s]/', '', $name) . '.png'
        ];
      });
    }

    ImageOfChart::truncate();
    ImageOfChart::insert($data);

  }

}
