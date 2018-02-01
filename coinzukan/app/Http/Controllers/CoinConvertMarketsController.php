<?php

namespace App\Http\Controllers;

use App\Models\Orderbook;
use Illuminate\Http\Request;
use App\Models\CoinConvert;
use App\Models\CoinConvertMarkets;
use App\Models\Pair;
use Illuminate\Support\Facades\DB;

class CoinConvertMarketsController extends Controller
{

    public function getCoinByMarket($base,$target,$market_id = 0){

        if (trim($base) == '' || trim($target) == '' ) {
            return null;
        }

        if($market_id != 0){
            $pair = Pair::select('pair.id')->where('base',$base)->where('target',$target)->where('market_id',$market_id)->first();
            $asks = Orderbook::select('price')->where('pair_id',$pair['id'])->where('market_id',$market_id)->where('type','asks')->first();
            $bids = Orderbook::select('price')->where('pair_id',$pair['id'])->where('market_id',$market_id)->where('type','bids')->first();
            $data = Pair::select('pair.*','coin_convert.coin_convert_name','markets.market_name','markets.id','coins.icon_url')
                ->join('coin_convert', function($join) use ($base, $target){
                    $join->on('coin_convert.base', '=', 'pair.base');
                    $join->on('coin_convert.target', '=', 'pair.target');
                })
                ->join('markets','markets.id','=','pair.market_id')
                ->join('coins','coins.code','=','pair.base')
                ->where('pair.base',$base)
                ->where('pair.target',$target)
                ->where('markets.id',$market_id)
                ->first();
            if(!is_null($data)){
                $data['market_id'] = floatval($data['market_id']);
                $data['price'] = floatval($data['price']);
                $data['last24hr'] = floatval($data['last24hr']);
                $data['high24hr'] = floatval($data['high24hr']);
                $data['low24hr'] = floatval($data['low24hr']);
                $data['baseVolume'] = floatval($data['baseVolume']);
                $data['percentChange24hr'] = floatval($data['percentChange24hr']);
                $data['changeAbsolute24hr'] = floatval($data['changeAbsolute24hr']);
                $data['highestBid'] = floatval($bids['price']);
                $data['lowestAsk'] = floatval($asks['price']);
            }
//            foreach ($data as $item){
//            $item['']
//            }
            return $data;

        }else {
            $pair = Pair::select('pair.id')->where('base',$base)->where('target',$target)->get();
            $asksList = [];
            $bidsList = [];
            foreach ($pair as $item){
                $asks = Orderbook::select('price')->where('pair_id',$item['id'])->where('type','asks')->first();
                array_push($asksList,$asks['price']);
                $bids = Orderbook::select('price')->where('pair_id',$item['id'])->where('type','bids')->first();
                array_push($bidsList,$bids['price']);
            }
            $data = Pair::select('pair.*','coin_convert.coin_convert_name','markets.market_name','markets.id','coins.icon_url')
                ->join('coin_convert', function($join) use ($base, $target){
                    $join->on('coin_convert.base', '=', 'pair.base');
                    $join->on('coin_convert.target', '=', 'pair.target');
                })
                ->join('markets','markets.id','=','pair.market_id')
                ->join('coins','coins.code','=','pair.base')
                ->where('pair.base',$base)
                ->where('pair.target',$target)
                ->get();
            if(count($data) > 0){
                foreach ($data as $index=>$dt){
                    $dt['market_id'] = floatval($dt['market_id']);
                    $dt['price'] = floatval($dt['price']);
                    $dt['last24hr'] = floatval($dt['last24hr']);
                    $dt['high24hr'] = floatval($dt['high24hr']);
                    $dt['low24hr'] = floatval($dt['low24hr']);
                    $dt['baseVolume'] = floatval($dt['baseVolume']);
                    $dt['percentChange24hr'] = floatval($dt['percentChange24hr']);
                    $dt['changeAbsolute24hr'] = floatval($dt['changeAbsolute24hr']);
                    $dt['lowestAsk'] = floatval($asksList[$index]);
                    $dt['highestBid'] = floatval($bidsList[$index]);
                }
            }

            return $data;

            }

    }

    public function getListCoinAtHome($StyleCoinsInfo){
        $arrayResult = [];
        $arrayStyleCoin = explode(',', trim($StyleCoinsInfo));
        foreach($arrayStyleCoin as $valueCoin){
            $params =  explode('_', trim($valueCoin));
            $base = $params[0];
            $target = $params[1];
            $market_id = $params[2];
            $result = $this->getCoinByMarket($base, $target, $market_id);
            if(!is_null($result))
               array_push($arrayResult,$result);
        }
        return $arrayResult;
    }
    
}
