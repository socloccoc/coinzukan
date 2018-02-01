<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Trades extends Model
{
    protected $table = 'trades';
    public $timestamps = false;

    public function getListMarketsByBase($base){
        return DB::table('coin_convert as coin_convert')
                    ->join('coin_convert_markets as coin_markets', 'coin_markets.coin_convert_id', '=', 'coin_convert.id')
                    ->join('market as market', 'market.id', '=', 'coin_markets.market_id')
                    ->select('coin_convert.base as base', 'coin_convert.target as target', 'market.name as name_market', 'coin_markets.id as id_convert_markets', 'coin_markets.baseVolume as base_volume', 'coin_markets.quoteVolume as qoute_volume')
                    ->where(function($que) use ($base) {
                        $que->where('coin_convert.base', $base)
                            ->orWhere('coin_convert.target', $base);
                    })
                    ->groupBy('coin_convert.id')
                    ->orderBy('base_volume', 'DESC');
    }
}
