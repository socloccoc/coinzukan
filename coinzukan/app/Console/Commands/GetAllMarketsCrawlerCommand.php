<?php

namespace App\Console\Commands;

use App\Models\Pair;
use App\Models\Orderbook;
use App\Models\Trades;
use App\Models\Ohlc;
use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Markets;
use Illuminate\Support\Facades\DB;
use App\Models\PushNotify;
use App\Models\PriceHistorical;

class GetAllMarketsCrawlerCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'GetAllMarketsCrawler:GetAllMarkets';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'get all markets';

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

    echo Carbon::now() . "\n";
    $this->checkPushNotify();

    $jsonMarket = crawlUrl('https://api.cryptowat.ch/markets');
    if (isset($jsonMarket['result']) && count($jsonMarket['result']) > 0) {
      foreach ($jsonMarket['result'] as $item) {
        $record = Markets::where('market_name', $item['exchange'])->first();
        $checkUpdate = false;
        if ($item['active'] == true && preg_match('/-/', $item['pair']) == false) {
          if (is_null($record)) {
            $market_id = DB::table('markets')->insertGetId([
              'market_name' => $item['exchange']
            ]);
          } else {
            $checkUpdate = true;
            $market_id = $record['id'];
          }

          /**
           *  Pair + Price + summary
           *
           * return [ Pair, vase, target, Price, Last, high, low, change, volue ]
           */

          $jsonPair = crawlUrl($item['route']);
          $this->info($item['route']);
          if (isset($jsonPair['result']['routes']['price']) && isset($jsonPair['result']['routes']['summary'])) {
            $price = crawlUrl($jsonPair['result']['routes']['price']);
            $summary = crawlUrl($jsonPair['result']['routes']['summary']);
            $coinConvert = crawlUrl("https://api.cryptowat.ch/pairs/" . $item['pair']);
            $this->info("https://api.cryptowat.ch/pairs/" . $item['pair']);
            $pair = Pair::where('market_id', $market_id)->where('name', $item['pair'])->first();
            $checkPairUpdate = false;
            is_null($pair) ? $pair = new Pair() : $checkPairUpdate = true;
            $priceHistorical = new PriceHistorical();
            $pair->name = isset($item['pair']) ? $item['pair'] : '';
            $pair->base = isset($coinConvert['result']['base']['symbol']) ? $coinConvert['result']['base']['symbol'] : '';
            $pair->target = isset($coinConvert['result']['quote']['symbol']) ? $coinConvert['result']['quote']['symbol'] : '';
            $pair->market_id = $market_id;
            $pair->price = $priceHistorical->price = isset($price['result']['price']) ? $price['result']['price'] : '';
            $pair->last24hr = isset($summary['result']['price']['last']) ? $summary['result']['price']['last'] : '';
            $pair->high24hr = isset($summary['result']['price']['high']) ? $summary['result']['price']['high'] : '';
            $pair->low24hr = isset($summary['result']['price']['low']) ? $summary['result']['price']['low'] : '';
            $pair->baseVolume = isset($summary['result']['volume']) ? $summary['result']['volume'] : '';
            $pair->percentChange24hr = isset($summary['result']['price']['change']['percentage']) ? $summary['result']['price']['change']['percentage'] : '';
            $pair->changeAbsolute24hr = isset($summary['result']['price']['change']['absolute']) ? $summary['result']['price']['change']['absolute'] : '';
            $pair->save();
            $priceHistorical->pair_id = $pair->id;
            $priceHistorical->market_id = $market_id;
            $priceHistorical->date = Carbon::now()->timestamp;
            $priceHistorical->save();
          }
          /**
           *  OrderBook
           * Returns a market’s order book
           *
           * Orders are lists of numbers in this order: [ Price, Amount ]
           */
          if (isset($jsonPair['result']['routes']['orderbook'])) {
            if ($checkUpdate == true && $checkPairUpdate == true) {
              DB::table('order_book')->where('market_id', $market_id)->where('pair_id', $pair->id)->delete();
            }
            $orderbookJson = crawlUrl($jsonPair['result']['routes']['orderbook']);
            $arr = [];
            if (isset($orderbookJson['result']) && count($orderbookJson['result']) > 0) {
              foreach ($orderbookJson['result'] as $key => $order) {
                if (isset($order) && count($order) > 0) {
                  foreach ($order as $index => $orderItem) {
                    $orderBook['market_id'] = $market_id;
                    $orderBook['pair_id'] = $pair->id;
                    $orderBook['type'] = $key;
                    $orderBook['price'] = $orderItem['0'];
                    $orderBook['amount'] = $orderItem['1'];
                    array_push($arr, $orderBook);
                    if ($index == 99) {
                      break;
                    }
                  }
                }
              }
              Orderbook::insert($arr);
            }
          }

          /**
           *  Trades
           * Returns a market’s most recent trades, incrementing chronologically
           *
           * Trades are lists of numbers in this order [ ID, Timestamp, Price, Amount ]
           */
          if ($checkUpdate == true && $checkPairUpdate == true) {
            DB::table('trades')->where('market_id', $market_id)->where('pair_id', $pair->id)->delete();
          }
          $tradesJson = crawlUrl($jsonPair['result']['routes']['trades']);
          $arr = [];
          if (isset($tradesJson['result']) && count($tradesJson['result']) > 0) {
            foreach ($tradesJson['result'] as $key => $stradeItem) {
              $trades['market_id'] = $market_id;
              $trades['pair_id'] = $pair->id;
              $trades['trades_id'] = $stradeItem[0];
              $trades['date'] = $stradeItem[1];
              $trades['rate'] = $stradeItem[2];
              $trades['amount'] = $stradeItem[3];
              array_push($arr, $trades);
              if ($key > 100) {
                break;
              }
            }
            Trades::insert($arr);
          }

          /**
           *  OHLC
           * Returns a market’s OHLC candlestick data. Returns data as lists of lists of numbers for each time period integer
           *
           * The values are in this order: [ CloseTime, OpenPrice, HighPrice, LowPrice, ClosePrice, Volume ]
           */

          if (isset($jsonPair['result']['routes']['ohlc'])) {
            if ($checkUpdate == true && $checkPairUpdate == true) {
              DB::table('ohlc')->where('market_id', $market_id)->where('pair_id', $pair->id)->delete();
            }
            $current_end_time = Carbon::now();
            $arr = [];

            foreach (config('constants.timeChart') as $key => $time) {
              switch ($key) {
                case 0:
                  $current_start_time = Carbon::now()->subHour(1);
                  break;
                case 1:
                  $current_start_time = Carbon::now()->subHours(12);
                  break;
                case 2:
                  $current_start_time = Carbon::now()->subDay(1);
                  break;
                case 3:
                  $current_start_time = Carbon::now()->subDays(3);
                  break;
                case 4:
                  $current_start_time = Carbon::now()->subDays(7);
                  break;
                case 5:
                  $current_start_time = Carbon::now()->subMonth(1);
                  break;
                case 6:
                  $current_start_time = Carbon::now()->subMonths(3);
                  break;
                case 7:
                  $current_start_time = Carbon::now()->subMonths(6);
                  break;
                case 8:
                  $current_start_time = Carbon::now()->subYear(1);
                  break;
                default:
              }

              $ohlcJson = crawlUrl($jsonPair['result']['routes']['ohlc'] . "?periods=" . $time . "&before=" . $current_end_time->timestamp . "&after=" . $current_start_time->timestamp);
             // $this->info("https://api.cryptowat.ch/markets/quoine/btcidr/ohlc" . "?periods=" . $time . "&before=" . $current_end_time->timestamp . "&after=" . $current_start_time->timestamp);
              if (isset($ohlcJson['result'][$time]) && count($ohlcJson['result'][$time]) > 0) {
                for ($i = 0; $i < count($ohlcJson['result'][$time]); $i++) {
                  $ohlc['market_id'] = $market_id;
                  $ohlc['pair_id'] = $pair->id;
                  $ohlc['key'] = $key;
                  $ohlc['date'] = isset($ohlcJson['result'][$time][$i][0]) ? $ohlcJson['result'][$time][$i][0] : '';
                  $ohlc['open'] = isset($ohlcJson['result'][$time][$i][1]) ? $ohlcJson['result'][$time][$i][1] : '';
                  $ohlc['high'] = isset($ohlcJson['result'][$time][$i][2]) ? $ohlcJson['result'][$time][$i][2] : '';
                  $ohlc['low'] = isset($ohlcJson['result'][$time][$i][3]) ? $ohlcJson['result'][$time][$i][3] : '';
                  $ohlc['close'] = isset($ohlcJson['result'][$time][$i][4]) ? $ohlcJson['result'][$time][$i][4] : '';
                  $ohlc['volume'] = isset($ohlcJson['result'][$time][$i][5]) ? $ohlcJson['result'][$time][$i][5] : '';
                  array_push($arr, $ohlc);
                  if ($i > 199) {
                    break;
                  }
                }
              }

            }

            Ohlc::insert($arr);

          }
        }
        echo Carbon::now();

      }

      echo Carbon::now();


    }
    $this->checkPushNotify();
  }

  private static function sendNotification($listDevicesId, $body)
  {
    $title = 'Push Notify For Coin Zukain';
    $action = 'Push';
    $data = array
    (
      'title' => $title,
      'body' => $body,
      'action' => $action
    );


    $fields = array
    (
      'registration_ids' => $listDevicesId,
      'data' => $data,
    );


    $headers = array
    (
      'Authorization: key=' . 'AAAA_nv-G5A:APA91bEhKN7btHrkBQkKp48tJdJI751iHz-VujFi6T_srGyc3yp7qRvY91YNh-dPqTdqb6pBOGhNoku3AszWYXujTb-doxH1USQHsnpMwLqfg24qrOg-eCfqoGxS5Zd1J5n7-9YyDGia',
      'Content-Type: application/json'
    );

    #Send Reponse To FireBase Server
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
  }

  public function checkPushNotify()
  {
    $pushNotifyData = PushNotify::where('status', 0)
      ->get(['id', 'market_id', 'token', 'base_target', 'value_above', 'value_below', 'type_push']);

      // dd([$pushNotifyData]);
    foreach ($pushNotifyData as $valueNotifyItem) {
      $listDevicesId = [];
      $base_target = explode("_", $valueNotifyItem->base_target);
      $pair = Pair::select('pair.id')
        ->where('base', $base_target[0])
        ->where('target', $base_target[1])
        ->where('market_id', $valueNotifyItem->market_id)->first();
      $valueItem = $pair->price;

      $valueAbove = '';
      if ($valueNotifyItem->value_above > 0) {
        $isAbove = true;
        if ($valueItem > $valueNotifyItem->value_above)
          $valueAbove = 'value above ' . $valueNotifyItem->value_above;
        else
          $valueAbove = '';
      } else
        $isAbove = false;

      if ($valueNotifyItem->value_below > 0) {
        $isBelow = true;
        if ($valueItem < $valueNotifyItem->value_above)
          $valueBelow = 'value below ' . $valueNotifyItem->value_below;
        else
          $valueBelow = '';
      } else
        $isBelow = false;

      $body = $valueAbove . $valueBelow;
      if ($valueNotifyItem->type_push == 0) {
        $valueNotifyItem->status = 1;
        $valueNotifyItem->save();
      }
      array_push($listDevicesId,$valueNotifyItem->token);
      $this->sendNotification([$valueNotifyItem->token],$body);
    }
  }
}