<?php
namespace App\Repositories\Eloquents;

use App\Models\Coinmarketcap;
use App\Repositories\Contracts\CoinMarketCapRepositoryInterface;
use App\Models\Pair;
use DB;
use App\Models\CirculatingSupply;
use App\Models\CoinmarketcapsGlobalHistorical;
use App\Models\ExchangeRateUsdMoneyOther;

class CoinMarketCapRepository implements CoinMarketCapRepositoryInterface
{

    public function insert($data){

    }

    public function update($data, $id){

    }

    public function delete($id){

    }

    public function find($id){

    }

    public function listCoinFromCoinMarket($sortInfo = array()){
        $query = DB::table('coinmarketcaps as coinsMar')
            ->leftjoin('coins as coins', 'coins.code', '=', 'coinsMar.symbol')
            ->join('image_of_charts as imageChart', 'imageChart.name', '=','coinsMar.name')
            ->select('coins.icon_url as coins_images', 'coinsMar.id as id', 'coinsMar.name as coins_name', 'coinsMar.symbol as code',
                'coinsMar.price_usd as price', 'coinsMar.24h_volume_usd as volume',
                'coinsMar.market_cap_usd as market_cap_usd', 'coinsMar.available_supply as available_supply',
                'coinsMar.total_supply as total_supply', 'coinsMar.percent_change_1h as percent_change_1h',
                'coinsMar.percent_change_24h as percent_change_24h',
                'coinsMar.percent_change_7d as percent_change_7d',
                'imageChart.image as imageChart','imageChart.circulatingUrl as circulatingUrl',
                'coinsMar.rank as rank')
            ->orderBy((isset($sortInfo['column']) && !empty($sortInfo['column'])) ?
                $sortInfo['column'] :
                'id', (isset($sortInfo['order']) && !empty($sortInfo['order'])) ? $sortInfo['order'] : 'ASC' );
        return $query;
    }

    public function getListExchanges(){
        $query = DB::table('exchange_rate_usd_money_other as exchange')
            ->pluck('name', 'name')
            ->toArray();
        return $query;
    }

    public function getRateByExchange($exchange){
        $findExchangeRate = $this->findExchange($exchange);
        if($findExchangeRate && !empty($findExchangeRate)){
            return $findExchangeRate;
        }else{
            return $this->findDefaultExchange($exchange);
        }

    }

    public function findExchange($exchange){
        $query = DB::table('exchange_rate_usd_money_other as exchange')
            ->where('exchange.name', '=', $exchange)
            ->select('exchange.exchange_rate as rate', 'exchange.name as unit')
            ->first();
        return $query;
    }

    public function findDefaultExchange($exchange){
        $query = DB::table('coinmarketcaps as coinsMar')
            ->where('coinsMar.symbol', '=', $exchange)
            ->select('coinsMar.price_usd as rate', 'coinsMar.symbol as unit')
            ->first();
        return $query;
    }


    public function getListCoins(){
        $query = DB::table('coins as coins')
            ->select('coins.name as coins_name', 'coins.code as coins_code')
            ->orderBy('coins.id', 'ASC');
        return $query;
    }

    public function getListPairByCode($code){
        $code = strtolower($code);
        $query = DB::table('pair as pair')
            ->join('markets as market', 'pair.market_id', 'market.id')
            ->where('pair.base', '=', $code)
            ->orWhere('pair.target', '=', $code)
            ->select('market.market_name as market_name', 'pair.*');
        return $query;
    }

    public function getVolumeHistory($sortInfo = array()){
        $query = DB::table('volume_history as historyVol')
            ->leftjoin('coins as coins', 'historyVol.symbol', '=', 'coins.code')
            ->select('historyVol.name as name', 'historyVol.symbol as symbol as name',
                'historyVol.volume_24h_usd as volume_24h', 'historyVol.volume_7d_usd as volume_7d',
                'historyVol.volume_30d_usd as volume_30d', 'coins.icon_url as coins_images')
            ->orderBy((isset($sortInfo['column']) && !empty($sortInfo['column'])) ?
                $sortInfo['column'] :
                'historyVol.id', (isset($sortInfo['order']) && !empty($sortInfo['order'])) ? $sortInfo['order'] : 'ASC' );;
        return $query;
    }


    public function findCoinByName($coin){
        $query = DB::table('coinmarketcaps as coinsMar')
            ->join('coins as coins', 'coins.code', '=', 'coinsMar.symbol')
            ->where('coinsMar.name', $coin)
            ->Select('coins.icon_url as coins_images','coinsMar.name as coin_name', 'coinsMar.symbol as symbol', 'coinsMar.rank as rank',
                'coinsMar.price_usd as price_usd', 'coinsMar.24h_volume_usd as volume_24h', 'coinsMar.market_cap_usd as market_cap_usd',
                'coinsMar.available_supply as available_supply', 'coinsMar.total_supply as supply','coinsMar.max_supply as max_supply', 'coinsMar.percent_change_1h as percent_1h',
                'coinsMar.percent_change_24h as percent_24h', 'coinsMar.percent_change_7d as percent_7d', 'coinsMar.market_cap_usd as market_cap_usd',
                'coinsMar.price_btc as price_btc')
            ->first();
        return $query;
    }

    public function getMarketBySymbol($symbol){
        $query = DB::table('pair as pair')
            ->join('markets as markets', 'pair.market_id', 'markets.id')
            ->where( function ($que) use ($symbol) {
                $que->where('pair.base', $symbol)
                    ->orWhere('pair.target', $symbol);

            })
            ->select('markets.market_name as name_market', 'pair.base as base', 'pair.target as target', 'pair.baseVolume as volume',
                'pair.price as price', 'pair.percentChange24hr as percent_24h');
        return $query;
    }

    public function getPairIdBySymbol($symbol){
        $query = DB::table('pair as pair')
            ->where( function ($que) use ($symbol) {
                $que->where('pair.base', strtoupper($symbol))
                    ->where('pair.target', 'usd');
            })
            ->select('pair.id as id')
            ->first();
        return $query;
    }

    public function getHistoryDataByPairId($pairId, $start, $end){
        $query = DB::table('ohlc as ohlc')
            ->where('ohlc.pair_id', $pairId)
            ->where('ohlc.date', '>=', $start)
            ->where('ohlc.date', '<=', $end)
            ->orderBy('ohlc.date', 'DESC');
        return $query;
    }


    public function getListNewCoin($sortInfo = array()){
        $query = DB::table('coinmarketcap_new_currencies as new_coin')
            ->leftjoin('coins as coins', 'new_coin.symbol', '=', 'coins.code')
            ->select('coins.icon_url as coin_images', 'new_coin.*')
            ->orderBy((isset($sortInfo['column']) && !empty($sortInfo['column'])) ?
                $sortInfo['column'] :
                'new_coin.id', (isset($sortInfo['order']) && !empty($sortInfo['order'])) ? $sortInfo['order'] : 'ASC' );
        return $query;
    }

    public function getListPrimary(){
        $query = DB::table('coin_exchange_rate as exchange_rate')
            ->join('coins as coins', 'exchange_rate.base', '=', 'coins.code')
            ->select(DB::raw('CONCAT(name, " (", code, ")") AS base'))
            ->pluck('base')
            ->toArray();
        return $query;
    }

    public function getRateByPrimary($primary){
        $query = DB::table('coin_exchange_rate as exChange')
            ->where('exChange.base', $primary)
            ->select('exChange.exchange_usd as rate')
            ->first();
        return $query;
    }

    public function getMarketCap(){
        return CoinmarketcapsGlobalHistorical::orderBy('id','DESC')->take(1);
    }

    public function getListMoney(){
        return ExchangeRateUsdMoneyOther::all();
    }

    public function getRateBtcAndEth(){
        return Coinmarketcap::where('name','=','Bitcoin')->orWhere('name','=','Ethereum')->select('price_usd','symbol')->get();
    }

    public function getListNameTokens(){
        $query = DB::table('tokens as tokens')
            ->select('tokens.name')
            ->pluck('token.name')
            ->toArray();
        return $query;
    }

    public function getListCryptocurrencies($list_token, $sortInfo = array()){
        $query = DB::table('coinmarketcaps as coinsMar')
            ->join('coins as coins', 'coins.name', '=', 'coinsMar.name')
            ->join('image_of_charts as imageChart', 'imageChart.name', '=', 'coinsMar.name')
            ->whereNotIn('coinsMar.name', $list_token)
            ->Select('coins.icon_url as coins_images','coinsMar.symbol as symbol','coinsMar.name as coin_name', 'coinsMar.symbol as symbol', 'coinsMar.rank as rank',
                'coinsMar.price_usd as price_usd', 'coinsMar.24h_volume_usd as volume_24h', 'coinsMar.market_cap_usd as market_cap_usd',
                'coinsMar.available_supply as available_supply', 'coinsMar.total_supply as total_supply', 'coinsMar.percent_change_1h as percent_1h',
                'coinsMar.percent_change_24h as percent_24h', 'coinsMar.percent_change_7d as percent_7d', 'coinsMar.market_cap_usd as market_cap_usd',
                'coinsMar.price_btc as price_btc','imageChart.image as imageChart','imageChart.circulatingUrl as circulatingUrl')
            ->orderBy((isset($sortInfo['column']) && !empty($sortInfo['column'])) ?
                $sortInfo['column'] :
                'coinsMar.id', (isset($sortInfo['order']) && !empty($sortInfo['order'])) ? $sortInfo['order'] : 'ASC' );
        return $query;
    }

    public function getListTokens($sortInfo = array()){
        $query = DB::table('tokens as tokens')
            ->join('coinmarketcaps as coinsMar', 'tokens.name', '=', 'coinsMar.name')
            ->join('coins as coins', 'coinsMar.symbol', '=', 'coins.code')
            ->join('image_of_charts as imageChart', 'imageChart.name', '=', 'coinsMar.name')
            ->select('coinsMar.name as coin_name', 'coinsMar.symbol as symbol', 'coinsMar.rank as rank',
                'coinsMar.price_usd as price_usd', 'coinsMar.24h_volume_usd as volume_24h', 'coinsMar.market_cap_usd as market_cap',
                'coinsMar.available_supply as available_supply', 'coinsMar.total_supply as total_supply', 'coinsMar.percent_change_1h as percent_1h',
                'coinsMar.percent_change_24h as percent_24h', 'coinsMar.percent_change_7d as percent_7d', 'coinsMar.market_cap_usd as market_cap_usd',
                'coinsMar.price_btc as price_btc', 'tokens.platform as platform', 'coins.icon_url as coins_images','imageChart.image as imageChart','imageChart.circulatingUrl as circulatingUrl')
            ->orderBy((isset($sortInfo['column']) && !empty($sortInfo['column'])) ?
                $sortInfo['column'] :
                'tokens.id', (isset($sortInfo['order']) && !empty($sortInfo['order'])) ? $sortInfo['order'] : 'ASC' );
        return $query;
    }


    public function getDateSnap(){
        $query = DB::table('coinmarketcap_history_snap as snap')
            ->select('snap.date')
            ->groupby('snap.date')
            ->orderBy('snap.date', 'ASC');
        return $query;
    }

    public function getCoinsSnapShotsByDate($date, $sortInfo = array()){
        $query = DB::table('coinmarketcap_history_snap as snap')
            ->leftJoin('coins', 'snap.symbol', '=', 'coins.code')
            ->select('snap.*', 'coins.icon_url as coins_images')
            ->where('snap.date', '=', $date)
            ->orderBy((isset($sortInfo['column']) && !empty($sortInfo['column'])) ?

                $sortInfo['column'] : 'snap.date', (isset($sortInfo['order']) && !empty($sortInfo['order'])) ? $sortInfo['order'] : 'ASC' );
        return $query;
    }
}