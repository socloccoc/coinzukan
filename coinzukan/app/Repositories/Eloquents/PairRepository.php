<?php
namespace App\Repositories\Eloquents;

use App\Repositories\Contracts\PairRepositoryInterface;
use App\Models\Pair;
use DB;
use App\Models\CirculatingSupply;
class PairRepository implements PairRepositoryInterface
{

    /**
     * Function get target by market id
     * @param $marketId
     * @return mixed
     */
    public function getListTargetByMarketId($marketId){
        return DB::table('pair as pair')
            ->where('pair.market_id', $marketId)
            ->select('pair.target', 'pair.id')
            ->groupBy('pair.target')
            ->pluck('id', 'target')->toArray();
    }

    /**
     * Function get base by target with another param
     * @param null $market
     * @param null $target
     * @param array $filters
     * @param array $sortInfo
     * @return mixed
     */
    public function getBaseByTarget($market = null, $target = null, $filters = array(), $sortInfo = array()){
        return DB::table('pair as pair')
                ->join('coins as coins', 'coins.code', '=', 'pair.base')
                ->join('markets as markets', 'markets.id', 'pair.market_id')
                ->join('circulating_supplies as supplies', 'supplies.code', 'pair.base')
                ->select('pair.id as pair_id','coins.id as coins_id', 'coins.name as coins_name', 'coins.icon_url as coins_images',
                    'coins.code as coins_code', 'pair.percentChange24hr as change_24h', 'pair.baseVolume as volume',
                    'pair.price as price', 'pair.base as base', 'pair.target as target', 'pair.market_id as market_id',
                    'markets.market_name as market_name','supplies.supply as circulating_supply')
                ->where(function ($que) use ($market, $target, $filters) {
                    if(isset ($target) && !empty($target)){
                        $que->where('pair.target', '=', $target);
                    }
                    if(isset ($filters['price']) && !empty($filters['price'])){
                        $que->where('pair.price' , '>=', $filters['price'][0]);
                        if(isset( $filters['price'][1])){
                            $que->where('pair.price', '<=', $filters['price'][1]);
                        }
                    }
                    if(isset ($filters['volume']) && !empty($filters['volume'])){
                        $que->where('pair.baseVolume' , '>=', $filters['volume'][0]);
                        if(isset( $filters['volume'][1])){
                            $que->where('pair.baseVolume', '<=', $filters['volume'][1]);
                        }
                    }
                    if(isset ($filters['Keyword']) && !empty($filters['Keyword'])){
                        $que->orWhere('pair.name', 'like', '%' . trim($filters['Keyword']) . '%');
                        $que->orWhere('pair.base', 'like', '%' . trim($filters['Keyword']) . '%');
                        $que->orWhere('pair.target', 'like', '%' . trim($filters['Keyword']) . '%');
                        $que->orWhere('coins.name', 'like', '%' . trim($filters['Keyword']) . '%');
                        $que->orWhere('coins.code', 'like', '%' . trim($filters['Keyword']) . '%');
                    }
                    if(isset($market) && !empty($market)){
                        $que->where('pair.market_id', '=', $market);
                    }
                })
                ->orderBy((isset($sortInfo['column']) && !empty($sortInfo['column'])) ?
                $sortInfo['column'] :
                'price', (isset($sortInfo['order']) && !empty($sortInfo['order'])) ? $sortInfo['order'] : 'DESC' );
    }

    /**
     * check exists base and target
     * @param $market_id
     * @param $base
     * @param $target
     * @return mixed
     */
    public function findBaseTarget($market_id, $base, $target){
        return DB::table('pair as pair')
            ->join('coins as coins', 'coins.code', '=', 'pair.base')
            ->select('coins.name as name', 'coins.icon_url as icon_url',
                'pair.base as base', 'pair.target as target',
                'pair.percentChange24hr as change_24h', 'pair.baseVolume as volume',
                'pair.high24hr as high', 'pair.low24hr as low', 'pair.market_id as market_id')
            ->where(function ($que) use ($base, $target){
                $que->where('pair.base', $base)
                    ->where('pair.target', $target);
            })
            ->where('pair.market_id', $market_id)
            ->first();
    }

    /**
     * function get list market by base - details screen
     * @param $base
     * @return mixed
     */
    public function getListMarketsByBase($base){
        return DB::table('pair as pair')
            ->join('markets as markets', 'markets.id', '=', 'pair.market_id')
            ->select('pair.base as base', 'pair.target as target',
                'markets.market_name as name_market','pair.baseVolume as base_volume')
            ->where(function($que) use ($base) {
                $que->where('pair.base', $base)
                    ->orWhere('pair.target', $base);
            })
            ->orderBy('base_volume', 'DESC');
    }


    /**
     * Function get history trade beetween base and target
     * @param $base
     * @param $target
     * @param $start
     * @param $end
     * @return mixed
     */
    public function getListHistoryTradeByBaseTarget($market_name, $base, $target){
        $query = DB::table('trades as trades')
            ->join('pair as pair', 'pair.id', '=', 'trades.pair_id')
            ->join('markets as markets','markets.id','=','trades.market_id')
            ->where('pair.base', $base)
            ->where('pair.target', $target)
            ->where('markets.market_name', $market_name)
            ->orderBy('date', 'DESC');
        return $query;
    }

    /**
     * function return data with $term ( search auto complete)
     * @param $term
     * @return mixed
     */
    public function getCoinConvertSearchAutoComplete($term){
        return DB::table('pair as pair')
            ->join('coins as coins', 'coins.code', 'pair.base')
            ->join('markets as markets', 'markets.id', '=', 'pair.market_id')
            ->where('pair.name', 'LIKE', '%'.$term.'%')
            ->orWhere('pair.base', 'LIKE', '%'.$term.'%')
            ->orWhere('pair.target', 'LIKE', '%'.$term.'%')
            ->orWhere('coins.name', 'LIKE', '%'.$term.'%')
            ->orWhere('coins.code', 'LIKE', '%'.$term.'%')
            ->select('pair.*', 'coins.icon_url as images', 'markets.market_name as market_name','coins.name as coinname')
            ->take(8)->get();
    }

    public function getCoinMarketCapAutoComplete($term){
        return DB::table('coinmarketcaps as coinMarket')
                ->join('coins as coins', 'coins.code', 'coinMarket.symbol')
                ->where('coinMarket.name', 'LIKE', '%'.$term.'%')
                ->orWhere('coins.name', 'LIKE', '%'.$term.'%')
                ->orWhere('coins.code', 'LIKE', '%'.$term.'%')
                ->select('coinMarket.*', 'coins.icon_url as images','coins.name as coinname')
                ->take(8)->get();
    }

    public function getListPairByMarketId($market_id){
        return DB::table('pair as pair')
                    ->where('pair.market_id', $market_id);
    }

    /**
     * @param $data
     */
    public function insert($data)
    {

    }

    /**
     * @param $data
     * @param $id
     */
    public function update($data, $id)
    {

    }

    /**
     * @param $id
     */
    public function delete($id)
    {

    }

    /**
     * @param $id
     */
    public function find($id){

    }
}
