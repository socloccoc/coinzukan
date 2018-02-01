<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class CoinConvertMarketTradeHistory extends Model
{
    protected $table="coin_convert_market_trade_history";

    /**
     * Function get list History Trade with param base and target
     * @param $base
     * @param $target
     * @param $start
     * @param $end
     * @return mixed
     */
    public function getListHistoryTradeByBaseTarget($base, $target, $start, $end){
        $query = DB::table('coin_convert_market_trade_history as history')
                        ->join('coin_convert_markets as market_convert', 'market_convert.id', '=', 'history.markets_id')
                        ->join('coin_convert as coin_convert', 'coin_convert.id', '=', 'market_convert.coin_convert_id')
                        ->where('coin_convert.base', $base)
                        ->where('coin_convert.target', $target)
                        ->where(function ($que) use($start, $end){
                            $que->where('history.date', '>=', $start);
                            if(isset($end)){
                                $que->where('history.date', '<=', $end);
                            }
                        })
                        ->groupBy('history.id')
                        ->orderBy('date', 'DESC');
        return $query;
    }
}