<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class CoinConvertMarkets extends Model
{
    // table coin_convert_markets
    protected $table="coin_convert_markets";

    /**
     * This function get info Cryptocurrencies base target
     * @param $base
     * @param $target
     * @return mixed
     */
    public function getInforByBaseTarget($base, $target){
        return DB::table('coin_convert as coin_convert')
            ->join('coin_convert_markets as coin_market', 'coin_market.coin_convert_id', 'coin_convert.id')
            ->join('coins', 'coins.code', '=', 'coin_convert.base')
            ->select('coins.name as name', 'coins.icon_url as icon_url', 'coin_convert.id as coin_convert_id', 'coin_convert.base as base', 'coin_convert.target as target', 'coin_market.percentChange as change_24h', 'coin_market.baseVolume as volume', 'coin_market.baseVolume_usd as volume_usd', 'coin_market.high24hr as high', 'coin_market.high24hr_usd as high_usd', 'coin_market.low24hr as low', 'coin_market.low24hr_usd as low_usd', 'coin_market.lowestAsk as ask', 'coin_market.lowestAsk_usd as ask_usd', 'coin_market.highestBid as bid', 'coin_market.highestBid_usd as bid_usd')
            ->where(function($que) use ($base, $target) {
                $que->where('coin_convert.base', $base)
                    ->where('coin_convert.target', $target);
            })
            ->groupBy('coin_convert.id');
    }
}