<?php namespace App\Http\Controllers\FrontEnd;

use App\Models\Coins as Coins;
use App\Http\Requests;
use App\Models\Markets;
use App\Models\ImageOfChart;
use App\Models\ListUnstyled;
use App\Models\ListUnstyledJapan;
use Input;
use Helper;
use Response;
use DB;
use DateTime;
use Illuminate\Http\Request;
use Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

class HomeCustomController extends BaseController {

    public function index(){
        $exchange = Input::has('exchange') ? Input::get('exchange') : 'USD';
        $rateByExchange = $this->marketCapRepository->getRateByExchange($exchange);
        $rate = $exchange == 'USD' ? 1 : $rateByExchange->rate;
        $unit = $exchange == 'USD' ? '$' : $rateByExchange->unit;
        $sortInfo = array();
        if (Input::has('sort') && Input::has('dir')) {
            $sortInfo['column'] = Input::get('sort');
            $sortInfo['order'] = Input::get('dir');
        }

        $query = $this->marketCapRepository->listCoinFromCoinMarket($sortInfo);
        $pagination = $query->simplePaginate('99')->appends(Input::except('page') + $sortInfo)->render();
        $listCoinFromCoinMarket = $query->get();

        $listExchanges = $this->marketCapRepository->getListExchanges();

        return view('layout.MarketCapHome', compact('pagination', 'listCoinFromCoinMarket', 'listExchanges', 'rate', 'unit'));
    }

    /**
     * function get sort
     * @return mixed
     */
    public function getSortableColumns(){
        $columns = array(
            'coins_name' => trans('content.HOME_PAGE.name'),
            'symbol' => trans('content.HOME_PAGE.symbol'),
            'market_cap_usd' => trans('content.HOME_PAGE.market_cap'),
            'price' => trans('content.HOME_PAGE.price'),
            'available_supply' => trans('content.HOME_PAGE.circulating_supply'),
            'volume' => trans('content.HOME_PAGE.volume_24h'),
            'percent_change_24h' => trans('content.HOME_PAGE.change_24h'),
            'percent_change_1h' => trans('content.HOME_PAGE.1h'),
            'percent_change_7d' => trans('content.HOME_PAGE.7d'),
            'image' =>  trans('content.HOME_PAGE.price_graph'),
            'market_name'   =>  trans('content.HOME_PAGE.markets')
        );
        return Helper::getSortableColumnOnArrayHome($columns);
    }

    /**
     * This function get all coin crawl from  coinmarketcap.com
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View

     */
    public function getAllCoinMarketCap(){
        $exchange = Input::has('exchange') ? Input::get('exchange') : 'USD';
        $rateByExchange = $this->marketCapRepository->getRateByExchange($exchange);
        $rate = $exchange == 'USD' ? 1 : $rateByExchange->rate;
        $unit = $exchange== 'USD' ? '$' : $rateByExchange->unit;
        $sortInfo = array();
        if (Input::has('sort') && Input::has('dir')) {
            $sortInfo['column'] = Input::get('sort');
            $sortInfo['order'] = Input::get('dir');
        }
        $query = $this->marketCapRepository->listCoinFromCoinMarket($sortInfo);
        $listCoinFromCoinMarket = $query->get();

        $listExchanges = $this->marketCapRepository->getListExchanges();

        return view('layout.MarketCapHome', compact('listCoinFromCoinMarket', 'listExchanges', 'rate', 'unit'));
    }

    public function allCoins(){
        $exchange = Input::has('exchange') ? Input::get('exchange') : 'USD';
        $rateByExchange = $this->marketCapRepository->getRateByExchange($exchange);
        $rate = $exchange == 'USD' ? 1 : $rateByExchange->rate;
        $unit = $exchange == 'USD' ? '$' : $rateByExchange->unit;
        $sortInfo = array();

        if (Input::has('sort') && Input::has('dir')) {
            $sortInfo['column'] = Input::get('sort');
            $sortInfo['order'] = Input::get('dir');
        }

        // get list coins tokens
        $listTokens = $this->marketCapRepository->getListNameTokens();
        // get list coins chính thống not where coins tokens
        $query = $this->marketCapRepository->getListCryptocurrencies($listTokens, $sortInfo);
        $listCryptocurrencies = $query->get();
        return view('coins.currencies.FrontCoins', compact('listCryptocurrencies', 'exchange', 'rate', 'unit'));
    }

    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function currenciesVolume(){
        $listCoins  = $this->marketCapRepository->getListCoins()->get();
        return view('layout.FrontCurrenciesVolume', compact('listCoins'));
    }

    /**
     * This function get list markets of coin by coin symbol
     * @param $code
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getMarketByCode($code){
        $listMarkets =  $this->marketCapRepository->getListPairByCode($code)->get();
        return view('coins.partial.listpairbymarket', compact('listMarkets'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View

     */
    public function exchangesVolume(){
        $listMarkets = $this->marketsRepository->getAllMarket();
        return view('layout.FrontExchangesVolume', compact('listMarkets'));
    }

    /**
     * This function get list pairs of market by id market
     * @param $market_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View

     */
    public function getListPairByMarketId($market_id){
        $listPairs = $this->pairRepository->getListPairByMarketId($market_id)->get();
        return view('coins.partial.listmarketpair', compact('listPairs'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View

     */
    public function volumeHistory(){
        $exchange = Input::has('exchange') ? Input::get('exchange') : 'USD';
        $rateByExchange = $this->marketCapRepository->getRateByExchange($exchange);
        $rate = $exchange == 'USD' ? 1 : $rateByExchange->rate;
        $unit = $exchange == 'USD' ? '$' : $rateByExchange->unit;
        $sortInfo = array();
        if (Input::has('sort') && Input::has('dir')) {
            $sortInfo['column'] = Input::get('sort');
            $sortInfo['order'] = Input::get('dir');
        }
        $query = $this->marketCapRepository->getVolumeHistory($sortInfo);
        $historyVolumes = $query->get();
        //dd($historyVolumes);
        $listExchanges = $this->marketCapRepository->getListExchanges();
        $columns = $this->getSortableColumnsHistoryVolume();
        return view('layout.FrontVolumeHistory', compact('listExchanges', 'historyVolumes', 'rate', 'unit', 'columns'));
    }

    /**
     * function get sort
     * @return mixed

     */
    public function getSortableColumnsHistoryVolume()
    {
        $columns = array(
            'name' => trans('content.HOME_PAGE.name'),
            'symbol' => trans('content.HOME_PAGE.symbol'),
            'volume_24h' => trans('content.HOME_PAGE.volume_1d'),
            'volume_7d' => trans('content.HOME_PAGE.volume_7d'),
            'volume_30d' => trans('content.HOME_PAGE.volume_30d')
        );

        return Helper::getSortableColumnsHistoryVolume($columns);
    }

    /**
     * This function get detail coin
     * @param $coins

     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDetailCoin($coins){
        $coinConvert = str_replace("%20"," ",$coins);
        if(Config::get('app.locale') == 'en'){
          $listUnstyled = ListUnstyled::where('coin_name','=',$coinConvert)->first();
        }else{
          $listUnstyled = ListUnstyledJapan::where('coin_name','=',$coinConvert)->first();
        }
        $infoCoin = $this->marketCapRepository->findCoinByName($coins);
        if($infoCoin){
            $listMarkets = $this->marketCapRepository->getMarketBySymbol($infoCoin->symbol)->get();
            $getPairId = $this->marketCapRepository->getPairIdBySymbol($infoCoin->symbol);
            $pairId = isset($getPairId) ? $getPairId->id : '';
            return view('coins.detailcoinmarketcap', compact('infoCoin', 'listMarkets', 'pairId','listUnstyled'));
        }else{
            abort('404');
        }

    }

    /**
     * this function get list data history coin
     * @param Request $request

     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getHistoryDataCoin(Request $request){
        $pairId = $request->pairId;
        $dateStart = new DateTime($request->start);
        $dateStart =  $dateStart->getTimestamp();
        $dateEnd = new DateTime($request->end);
        $dateEnd =  $dateEnd->getTimestamp();
        $historyDatas = $this->marketCapRepository->getHistoryDataByPairId($pairId, $dateStart, $dateEnd)->get();
        return view('coins.partial.historymarketcap', compact('historyDatas'));

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View

     */
    public function getNewCoins(){
        $exchange = Input::has('exchange') ? Input::get('exchange') : 'USD';
        $rateByExchange = $this->marketCapRepository->getRateByExchange($exchange);
        $rate = $exchange == 'USD' ? 1 : $rateByExchange->rate;
        $unit = $exchange == 'USD' ? '$' : $rateByExchange->unit;
        $sortInfo = array();
        if (Input::has('sort') && Input::has('dir')) {
            $sortInfo['column'] = Input::get('sort');
            $sortInfo['order'] = Input::get('dir');
        }

        $listNewCoins = $this->marketCapRepository->getListNewCoin($sortInfo)->get();
        return view('layout.NewCoinMarketCap', compact('listNewCoins', 'exchange', 'rate', 'unit'));
    }


    public function calculatorCurrency(){
        $primary = $this->marketCapRepository->getListPrimary();
        $second = $this->marketCapRepository->getListExchanges();
        array_push($second,"USD");
        return view('partial.calculator', compact('primary', 'second'));
    }

    /**
     * This function convert from coin to other coin
     * @param Request $request
     * @return float|int
     */
    public function convertPrimaryToSecondaryByAmount(Request $request){
        $amount = $request->amount;
        $pattern = '/\((.+)\)/';
        $primary = preg_match($pattern, $request->primary, $matches) ? $matches[1] : $request->primary;
        $second = preg_match($pattern, $request->secondary, $matches) ? $matches[1] : $request->secondary;
        $rateFromInExchange = $this->marketCapRepository->getRateByPrimary($primary);
        $rateFromInOther = $this->marketCapRepository->findExchange($primary);
        $findRateByPrimary = $primary == "USD" ? 1 : (isset($rateFromInExchange) && !empty ($rateFromInExchange) ? $rateFromInExchange->rate : $rateFromInOther->rate);
        $rateToInExchange = $this->marketCapRepository->getRateByPrimary($second);
        $rateToOther = $this->marketCapRepository->findExchange($second);
        $findRateBySecond = $second == "USD" ? 1 : ($findRateBySecond = isset($rateToInExchange) && !empty ($rateToInExchange) ? $rateToInExchange->rate : $rateToOther->rate);
        $result = ($findRateByPrimary*$amount)/$findRateBySecond;
        return $result;
    }

    // coins chính thống
    public function coins($isTotalSupply = ''){
        $exchange = Input::has('exchange') ? Input::get('exchange') : 'USD';
        $rateByExchange = $this->marketCapRepository->getRateByExchange($exchange);
        $rate = $exchange == 'USD' ? 1 : $rateByExchange->rate;
        $unit = $exchange == 'USD' ? '$' : $rateByExchange->unit;
        $sortInfo = array();
        if (Input::has('sort') && Input::has('dir')) {
            $sortInfo['column'] = Input::get('sort');
            $sortInfo['order'] = Input::get('dir');
        }

        // get list coins tokens
        $listTokens = $this->marketCapRepository->getListNameTokens();
        // get list coins chính thống not where coins tokens
        $query = $this->marketCapRepository->getListCryptocurrencies($listTokens, $sortInfo);
        $pagination = $query->simplePaginate('99')->appends(Input::except('page') + $sortInfo)->render();
        $listCryptocurrencies = $query->get();
        return view('coins.currencies.FrontCoins', compact('listCryptocurrencies', 'exchange', 'rate', 'unit', 'pagination','isTotalSupply'));
    }

    public function CoinsByTotalSupply(){
        $exchange = Input::has('exchange') ? Input::get('exchange') : 'USD';
        $rateByExchange = $this->marketCapRepository->getRateByExchange($exchange);
        $rate = $exchange == 'USD' ? 1 : $rateByExchange->rate;
        $unit = $exchange == 'USD' ? '$' : $rateByExchange->unit;
        $sortInfo = array();
        if (Input::has('sort') && Input::has('dir')) {
            $sortInfo['column'] = Input::get('sort');
            $sortInfo['order'] = Input::get('dir');
        }
        // get list coins tokens
        $listTokens = $this->marketCapRepository->getListNameTokens();
        // get list coins chính thống not where coins tokens
        $query = $this->marketCapRepository->getListCryptocurrencies($listTokens, $sortInfo);
        $pagination = $query->simplePaginate('99')->appends(Input::except('page') + $sortInfo)->render();
        $listCryptocurrencies = $query->get();
        return view('coins.currencies.FrontCoins', compact('listCryptocurrencies', 'exchange', 'rate', 'unit', 'pagination'));
    }

    public function getSortableColumnsCoins($exchange){
        $price = $exchange == 'USD' ? 'price_usd' : 'price_btc';
        $columns = array(
            'coin_name' => trans('content.HOME_PAGE.name'),
            'symbol'    =>  trans('content.HOME_PAGE.symbol'),
            'market_cap_usd' => trans('content.HOME_PAGE.market_cap'),
            $price => trans('content.HOME_PAGE.price'),
            'volume_24h' => trans('content.HOME_PAGE.volume_24h'),
            'available_supply' => trans('content.HOME_PAGE.circulating_supply'),
            'total_supply' => trans('content.HOME_PAGE.total_supply'),
            'percent_1h'    =>  trans('content.HOME_PAGE.1h'),
            'percent_24h'   =>  trans('content.HOME_PAGE.change_24h'),
            'percent_7d'    =>  trans('content.HOME_PAGE.7d')
        );

        return Helper::getSortableColumnOnArrayCoins($columns);
    }

    public function charts(){
        return view('coins.charts');
    }

    public function tokens(){
        $exchange = Input::has('exchange') ? Input::get('exchange') : 'USD';
        $rateByExchange = $this->marketCapRepository->getRateByExchange($exchange);
        $rate = $exchange == 'USD' ? 1 : $rateByExchange->rate;
        $unit = $exchange == 'USD' ? '$' : $rateByExchange->unit;
        $sortInfo = array();
        if (Input::has('sort') && Input::has('dir')) {
            $sortInfo['column'] = Input::get('sort');
            $sortInfo['order'] = Input::get('dir');
        }
        $query = $this->marketCapRepository->getListTokens($sortInfo);
        $pagination = $query->simplePaginate('99')->appends(Input::except('page') + $sortInfo)->render();
        $listTokens = $query->get();

        return view('coins.tokens.FrontTokens', compact('listTokens', 'rate', 'unit', 'exchange', 'pagination'));
    }

    public function getSortableColumnsTokens($exchange){
        $price = $exchange == 'USD' ? 'price_usd' : 'price_btc';
        $supply = Route::currentRouteName() == 'tokens.totalSupply' ? trans('content.HOME_PAGE.total_supply') : trans('content.HOME_PAGE.circulating_supply');
        $columns = array(
            'coin_name' => trans('content.HOME_PAGE.name'),
            'platform' => trans('content.HOME_PAGE.platform'),
            'market_cap' => trans('content.HOME_PAGE.market_cap'),
            $price => trans('content.HOME_PAGE.price'),
            'volume_24h' => trans('content.HOME_PAGE.volume_24h'),
            'available_supply' => $supply,
            'percent_1h'   =>  trans('content.HOME_PAGE.1h'),
            'percent_24h'   =>  trans('content.HOME_PAGE.change_24h'),
            'percent_7d'    =>  trans('content.HOME_PAGE.7d')
        );

        return Helper::getSortableColumnOnArrayTokens($columns);
    }

    public function allTokens(){
        $exchange = Input::has('exchange') ? Input::get('exchange') : 'USD';
        $rateByExchange = $this->marketCapRepository->getRateByExchange($exchange);
        $rate = $exchange == 'USD' ? 1 : $rateByExchange->rate;
        $unit = $exchange == 'USD' ? '$' : $rateByExchange->unit;
        $sortInfo = array();
        if (Input::has('sort') && Input::has('dir')) {
            $sortInfo['column'] = Input::get('sort');
            $sortInfo['order'] = Input::get('dir');
        }
        $query = $this->marketCapRepository->getListTokens($sortInfo);
        $listTokens = $query->get();

        return view('coins.tokens.FrontTokens', compact('listTokens','rate', 'unit', 'exchange'));
    }

    public function TokensTotalSupply(){
        $exchange = Input::has('exchange') ? Input::get('exchange') : 'USD';
        $rateByExchange = $this->marketCapRepository->getRateByExchange($exchange);
        $rate = $exchange == 'USD' ? 1 : $rateByExchange->rate;
        $unit = $exchange == 'USD' ? '$' : $rateByExchange->unit;
        $sortInfo = array();
        if (Input::has('sort') && Input::has('dir')) {
            $sortInfo['column'] = Input::get('sort');
            $sortInfo['order'] = Input::get('dir');
        }
        $query = $this->marketCapRepository->getListTokens($sortInfo);
        $pagination = $query->simplePaginate('99')->appends(Input::except('page') + $sortInfo)->render();
        $listTokens = $query->get();

        return view('coins.tokens.FrontTokens', compact('listTokens', 'rate', 'unit', 'exchange', 'pagination'));
    }

    /**
     * This function get list history data from 2013
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function historicalSnapshots()
    {
        // get all date
        $dates = $this->marketCapRepository->getDateSnap()->get();
        $data = [];
        $month = [];

        $count = count($dates);
        for ($i = 0; $i < $count; $i++) {
            // get year from $date
            $year = substr($dates[$i]->date, 0, 4);
            // get month from $date
            $m = substr($dates[$i]->date, 4, 2);
            // get day from $date
            $day[] = substr($dates[$i]->date, 6, 2);
            if ($i < $count - 1) {
                // add days to month
                if ((int)substr($dates[$i]->date, 4, 2) != (int)substr($dates[$i + 1]->date, 4, 2)) {
                    $month['' . $m][] = $day;
                    $day = [];
                }
                // add months to year
                if (substr($dates[$i]->date, 0, 4) != substr($dates[$i + 1]->date, 0, 4)) {
                    $data['' . $year][] = $month;
                    $day = [];
                    $month = [];
                }

            } else {
                // add days to month
                $month['' . $m][] = $day;
                // add months to year
                $data['' . $year][] = $month;
            }

        }

        return view('partial.historicalsnapshots', compact('data'));
    }

    public function getHistoricalSnapshots($date){
        $dateConvert = date('m/d, Y', $date);
        $exchange = Input::has('exchange') ? Input::get('exchange') : 'USD';
        $rateByExchange = $this->marketCapRepository->getRateByExchange($exchange);
        $rate = $exchange == 'USD' ? 1 : $rateByExchange->rate;
        $unit = $exchange == 'USD' ? '$' : $rateByExchange->unit;
        $sortInfo = array();
        if (Input::has('sort') && Input::has('dir')) {
            $sortInfo['column'] = Input::get('sort');
            $sortInfo['order'] = Input::get('dir');
        }
        $listCoinSnapShots = $this->marketCapRepository->getCoinsSnapShotsByDate($date, $sortInfo)->get();
        $columns = $this->getSortableColumnsSnapShots($date, $exchange);
        return view('coins.partial.listcoinsnapshots', compact('listCoinSnapShots', 'exchange', 'rate', 'unit', 'columns','dateConvert'));
    }


    /**
     * function get sort
     * @return mixed
     */
    public function getSortableColumnsSnapShots($date, $exchange)
    {
        $market_cap = $exchange == 'USD' ? 'marketcap_usd' : 'marketcap_btc';
        $price = $exchange == 'USD' ? 'price_usd' : 'price_btc';
        $percent_1h = $exchange == 'USD' ? 'percent_1h_usd' : 'percent_1h_btc';
        $percent_24h = $exchange == 'USD' ? 'percent_24h_usd' : 'percent_24h_btc';
        $percent_7d = $exchange == 'USD' ? 'percent_7d_usd' : 'percent_7d_btc';
        $columns = array(
            'name' => 'Name',
            'symbol' => 'Symbol',
            $market_cap => 'Market Cap',
            $price => 'Price',
            'circulating_supply' => 'Circulating Supply',
            $percent_1h => '% 1h',
            $percent_24h => '% 24h',
            $percent_7d => '% 7d',
        );
        return Helper::getSortableColumnsSnapShots($columns, '', $date, $exchange);
    }

    public function changeLanguage($language){
      \Session::put('website_language', $language);
      return redirect()->back();
    }

}