<?php

namespace App\Http\Controllers;

use Request;
use App\Models\Coin;
use App\Models\CoinConvertMarkets;
use App\Models\CoinConvert;
use App\Models\Ohlc;
use App\Models\Pair;
use App\Models\Markets;
use App\Models\PriceHistorical;
use App\Models\Coinmarketcap;
use App\Models\CoinmarketcapHistoryChartOfDetailPage;
use App\Models\CoinmarketcapsGlobalHistorical;

class AjaxController extends Controller
{

  public function searchCurrencies()
  {
    if (Request::ajax()) {
      $coins = Coin::where('name', 'like', '%' . Request::get('value') . '%')->get();;
      return view('ajax.searchCurrencies', compact('coins'));
    }
  }

  public function getDataChart()
  {
    if (Request::ajax()) {

      $coinConvert = explode("-", Request::get('coin_convert'));

      if (Request::has('market_id')) {
        $market_id = Request::get('market_id');
      } else {
        $market = Markets::where('market_name', Request::get('market_name'))->first();
        $market_id = $market['id'];
      }

      $markets = Pair::where('base', $coinConvert[0])
        ->where('target', $coinConvert[1])
        ->join('markets', 'pair.market_id', '=', 'markets.id')
        ->select('markets.id', 'markets.market_name')
        ->groupBy('markets.id')
        ->get();

      $pair = Pair::where('base', $coinConvert[0])
        ->where('target', $coinConvert[1])
        ->where('market_id', $market_id)->first();

      Request::has('btn-time') ? $timekey = Request::get('btn-time') : $timekey = 0;

      $ohlc = Ohlc::where('market_id', $market_id)
        ->where('pair_id', $pair['id'])
        ->where('key', $timekey)
        ->get();

      switch ($timekey) {
        case 0:
        case 1:
        case 2:
          foreach ($ohlc as $key => $item) {
            $ohlc[$key]['date'] = date('H:i', $item['date']);
          }
          break;
        case 3:
          foreach ($ohlc as $key => $item) {
            $ohlc[$key]['date'] = date('d H:i', $item['date']);
          }
          break;
        case 4:
        case 5:
        case 6:
        case 7:
          foreach ($ohlc as $key => $item) {
            $ohlc[$key]['date'] = date('M-d H:i', $item['date']);
          }
          break;
        case 8:
          foreach ($ohlc as $key => $item) {
            $ohlc[$key]['date'] = date('Y-M-d H:i', $item['date']);
          }
          break;

          break;
        default:
          break;

      }
      return [$markets, $ohlc];
    }
  }

  public function getDataChartImage()
  {
    if (Request::ajax()) {
      if (Request::get('market') == null && Request::get('target') == null) {
        $market = Markets::first();
        $market_id = $market['id'];
        $target = 'btc';
      } else {
        $market = Markets::where('market_name', Request::get('market'))->first();
        $market_id = $market['id'];
        $target = Request::get('target');
      }

      $segments = Request::get('segments');

      $priceHistory = Ohlc::select('ohlc.market_id', 'ohlc.pair_id', 'ohlc.close as price', 'ohlc.date')
        ->join('markets', 'markets.id', '=', 'ohlc.market_id')
        ->join('pair', 'pair.id', '=', 'ohlc.pair_id')
        ->where(function ($que) use ($target, $market_id, $segments) {
          if ($segments != 'all') {
            $que->where('pair.target', '=', $target);
            $que->where('markets.id', '=', $market_id);
          }
          $que->where('ohlc.key', '=', 4);
        })
        ->get();
      $count = count($priceHistory);
      $data = [];
      $market_pair = [];
      for ($i = 0; $i < $count; $i++) {
        $subData[] = [(int)$priceHistory[$i]['date'], (float)$priceHistory[$i]['price']];
        if ($i < $count - 1) {
          if ($priceHistory[$i]['market_id'] != $priceHistory[$i + 1]['market_id'] || $priceHistory[$i]['pair_id'] != $priceHistory[$i + 1]['pair_id']) {
            $market_pair[] = [$priceHistory[$i]['market_id'], $priceHistory[$i]['pair_id']];
            $data[] = $subData;
            $subData = [];
          }
        } else {
          $market_pair[] = [$priceHistory[$i]['market_id'], $priceHistory[$i]['pair_id']];
          $subData[] = [(int)$priceHistory[$i]['date'], (float)$priceHistory[$i]['price']];
          $data[] = $subData;
        }
      }
      return [$market_pair, $data];
    }
  }

  /**
   * Description : get data to draw a chart from detailpage
   *
   * Returns a arrays
   */
  public function chartOfMarketCapDetailPage()
  {
    if (Request::ajax()) {

      $data = CoinmarketcapHistoryChartOfDetailPage::where('coinmarketcap_history_chart_of_detail_pages.name', Request::get('coinName'))
          ->select('coinmarketcap_history_chart_of_detail_pages.*')
          ->orderBy('coinmarketcap_history_chart_of_detail_pages.id', 'ASC')
          ->get();

      foreach ($data as $item) {
        $marketcap[] = [(int)$item['last_updated']*1000, (float)$item['market_cap_usd']];
        $priceUsd[] = [(int)$item['last_updated']*1000, (float)$item['price_usd']];
        $priceBtc[] = [(int)$item['last_updated']*1000, (float)$item['price_btc']];
        $volume24h[] = [(int)$item['last_updated']*1000, (float)$item['24h_volume_usd']];
      }

      return [$marketcap, $priceUsd, $priceBtc, $volume24h];

    }
  }

  public function marketcapGlobalChartData(){
    if (Request::ajax()) {
      $data = CoinmarketcapsGlobalHistorical::all();
      foreach ($data as $item){
        $totalMarketcap[] = [(int)$item['last_updated']*1000,(float)$item['total_market_cap']];
        $total24hvolume[] = [(int)$item['last_updated']*1000,(float)$item['total_24h_volume']];
        $totalExcludingBitcoin[] = [(int)$item['last_updated']*1000,(float)$item['total_market_cap_excluding_bitcoin']];
        $total24hvolumeExcludingBitcoin[] = [(int)$item['last_updated']*1000,(float)$item['total_24h_volume_excluding_bitcoin']];
        $percentage_btc[] = [(int)$item['last_updated']*1000,(float)$item['percentage_btc']];
        $percentage_eth[] = [(int)$item['last_updated']*1000,(float)$item['percentage_eth']];
        $percentage_bch[] = [(int)$item['last_updated']*1000,(float)$item['percentage_bch']];
        $percentage_ltc[] = [(int)$item['last_updated']*1000,(float)$item['percentage_ltc']];
        $percentage_xrp[] = [(int)$item['last_updated']*1000,(float)$item['percentage_xrp']];
        $percentage_dash[] = [(int)$item['last_updated']*1000,(float)$item['percentage_dash']];
        $percentage_xmr[] = [(int)$item['last_updated']*1000,(float)$item['percentage_xmr']];
        $percentage_xem[] = [(int)$item['last_updated']*1000,(float)$item['percentage_xem']];
        $percentage_miota[] = [(int)$item['last_updated']*1000,(float)$item['percentage_miota']];
        $percentage_neo[] = [(int)$item['last_updated']*1000,(float)$item['percentage_neo']];
        $percentage_others[] = [(int)$item['last_updated']*1000,(float)$item['percentage_others']];
      }
      return [[$totalMarketcap, $total24hvolume],[$totalExcludingBitcoin,$total24hvolumeExcludingBitcoin],[$percentage_btc,$percentage_eth,$percentage_bch,$percentage_ltc,$percentage_xrp,$percentage_dash,$percentage_xmr,$percentage_xem,$percentage_miota,$percentage_neo,$percentage_others]];
    }
  }
}
