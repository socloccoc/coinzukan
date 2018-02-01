<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoinConvert extends Model
{

    protected $table="coin_convert";

    /**
     * This function get coinconvert by target
     * @param null $target
     * @param array $sortInfo
     * @return mixed
     */

    public function getCoinsConvertByTarget($target = null, $filters = array(), $sortInfo = array()){
        return DB::table('coin_convert as coin_convert')
                    ->leftjoin('coins as coins', 'coins.code', '=', 'coin_convert.base')
                    ->leftjoin('coin_convert_markets as coin_market', 'coin_market.coin_convert_id', '=', 'coin_convert.id')
                    ->select('coin_convert.*', 'coins.id as coins_id', 'coins.name as coins_name', 'coins.icon_url as coins_images',
                            'coins.code as coins_code', 'coin_market.percentChange as change_24h', 'coin_market.baseVolume as volume',
                            'coin_market.last as price')
                    ->where(function ($que) use ($target, $filters) {
                        if(isset ($target) && !empty($target)){
                            $que->where('coin_convert.target', '=', $target);
                        }
                        /*if(isset ($filters['market']) && !empty($filters['market'])){
                            $que->where('convert_market.market_cap_target' , '>=', $filters['market'][0]);
                            if(isset( $filters['market'][1])){
                                $que->where('convert_market.market_cap_target', '<=', $filters['market'][1]);
                            }
                        }*/
                        if(isset ($filters['price']) && !empty($filters['price'])){
                            $que->where('coin_market.last' , '>=', $filters['price'][0]);
                            if(isset( $filters['price'][1])){
                                $que->where('coin_market.last', '<=', $filters['price'][1]);
                            }
                        }
                        if(isset ($filters['volume']) && !empty($filters['volume'])){
                            $que->where('coin_market.baseVolume' , '>=', $filters['volume'][0]);
                            if(isset( $filters['volume'][1])){
                                $que->where('coin_market.baseVolume', '<=', $filters['volume'][1]);
                            }
                        }
                    })
                    ->where('coins.name', '!=', '')
                    ->groupBy('coin_convert.id')
                    ->orderBy((isset($sortInfo['column']) && !empty($sortInfo['column'])) ?
                                $sortInfo['column'] :
                        'price', (isset($sortInfo['order']) && !empty($sortInfo['order'])) ? $sortInfo['order'] : 'DESC' );
    }

    /**
     * This function get list target ( id => name )
     * @return mixed
     */
    public function getListCurrencies(){
        return DB::table('coin_convert')
            ->select('coin_convert.target', 'coin_convert.id')
            ->groupBy('coin_convert.target')
            ->pluck('target', 'id')->toArray();
    }

    public function findDataByBaseTarget($base, $target){
        return DB::table('coin_convert')
                ->where(function ($que) use ($base, $target){
                    $que->where('coin_convert.base', $base)
                        ->where('coin_convert.target', $target);
                });
    }

    public function getCoinsConvert ( $filters = array(), $sortInfo = array() ){
        return DB::table('coin_convert as coin_convert')
                    ->join('coins as coins', 'coins.code', '=', 'coin_convert.base')
                    ->join('coin_convert_markets as convert_markets', 'convert_markets.coin_convert_id', '=', 'coin_convert.id')
                    ->select('coin_convert.base as base', 'coin_convert.target as target', 'coins.name as name', 'coins.icon_url as images',
                            'convert_markets.percentChange as change_24h', 'convert_markets.baseVolume as volume', 'convert_markets.last as price')
                    ->where(function ($que) use ($filters) {
                        if(isset ($filters['Keyword']) && !empty($filters['Keyword'])){
                            $que->orWhere('coin_convert.coin_convert_name', 'like', '%' . trim($filters['Keyword']) . '%');
                            $que->orWhere('coin_convert.base', 'like', '%' . trim($filters['Keyword']) . '%');
                            $que->orWhere('coin_convert.target', 'like', '%' . trim($filters['Keyword']) . '%');
                        }
                    })
                    ->groupBy('coin_convert.id')
                    ->orderBy( (isset($sortInfo['column']) && !empty($sortInfo['column']))?$sortInfo['column'] : 'coin_convert.coin_convert_name' , (isset($sortInfo['order']) && !empty($sortInfo['order']))?$sortInfo['order'] : 'desc' );
    }

    public function getCoinConvertSearchAutoComplete($term){
        return DB::table('coin_convert as coin_convert')
            ->join('coins as coins', 'coins.code', 'coin_convert.base')
            ->where('coin_convert.coin_convert_name', 'LIKE', '%'.$term.'%')
            ->orWhere('coin_convert.base', 'LIKE', '%'.$term.'%')
            ->orWhere('coin_convert.target', 'LIKE', '%'.$term.'%')
            ->select('coin_convert.*', 'coins.icon_url as images')
            ->take(8)->get();
    }

}
