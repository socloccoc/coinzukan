<?php namespace App\Http\Controllers\FrontEnd;

use App\Models\Coins as Coins;
use App\Http\Requests;
use App\Models\Markets;
use Input;
use Helper;
use Response;
use DB;
use DateTime;
use Illuminate\Http\Request;

class PairController extends BaseController
{
    public function index()
    {

          $market = Markets::first();
          $market_id = $market['id'];
          $currencies = $this->pairRepository->getListTargetByMarketId($market_id);
          $target = 'btc';
          $sortInfo = array();
          if (Input::has('sort') && Input::has('dir')) {
            $sortInfo['column'] = Input::get('sort');
            $sortInfo['order'] = Input::get('dir');
          }
          $query = $this->pairRepository->getBaseByTarget($market_id, $target, null, $sortInfo);
          $pagination = $query->simplePaginate('50')->appends(Input::except('page') + $sortInfo)->render();
          $columns = $this->getSortableColumns();
          $data = $query->get();
          return view('layout.FrontHome', compact('pagination', 'columns', 'data', 'currencies'));

    }

    /**
     * function get sort
     * @return mixed
     */
    public function getSortableColumns(){
        $columns = array(
            'coins_name' => 'Name',
            'market.cap' => 'Market Cap',
            'price' => 'Price',
            'supply' => 'Circulating Supply',
            'volume' => 'Volume (24h)',
            'change_24h' => 'Change 24h',
            'image' =>  'Price Graph',
            'market_name'   =>  'Market'
        );
        return Helper::getSortableColumnOnArrayHomeCustom($columns);
    }

    /** Function get coins by target
     * @param $target
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCoinsByTarget($target){
        $market = 1;
        $coin = Coins::where('code', $target)
            ->get();
        if(empty($coin[0])){
            abort('404');
        }else{
            $sortInfo = array();
            if (Input::has('sort') && Input::has('dir')) {
                $sortInfo['column'] = Input::get('sort');
                $sortInfo['order'] = Input::get('dir');
            }
            $query = $this->pairRepository->getBaseByTarget($market, $target, null, $sortInfo);
            $pagination = $query->simplePaginate('50')->render();
            $columns = $this->getSortableColumns();
            $data = $query->get();
            return view('layout.FrontHome', compact( 'data', 'pagination', 'columns'));
        }
    }

    /**
     * Function get coins by market name
     * Default target = btc
     * Default market_id = 1 (bitfinex)
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function getCoinsByMarket(){
        $marketName = Input::get('market');
        $targetName = Input::get('target');
        $findMarket = $this->marketsRepository->findMarketByName($marketName);
        $marketId = isset($findMarket) && !empty($findMarket) ? $findMarket->id : 1 ;
        $currencies = $this->pairRepository->getListTargetByMarketId($marketId);
        $target = array_key_exists($targetName, $currencies) ? $targetName : array_keys($currencies)[0];
        $sortInfo = array();
        if (Input::has('sort') && Input::has('dir')) {
            $sortInfo['column'] = Input::get('sort');
            $sortInfo['order'] = Input::get('dir');
        }
        $query = $this->pairRepository->getBaseByTarget($marketId, $target, null, $sortInfo);
        $pagination = $query->simplePaginate('50')->appends(Input::except('page'))->render();
        $columns = $this->getSortableColumns();
        $data = $query->get();
        return view('layout.FrontHome', compact( 'data', 'pagination', 'columns', 'currencies', 'marketName', 'target'));
    }

    /**
     * This function get detail Cryptocurrencies Base Target
     * @param $base
     * @param $target
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detailsBaseTarget($market_name, $base, $target){
        $market = $this->marketsRepository->findMarketByName($market_name);
        $market_id = isset($market) && !empty($market) ? $market->id : 1;
        $inforBaseTarget =  $this->pairRepository->findBaseTarget($market_id, $base, $target);
        if(!empty($inforBaseTarget)){
            $coins = Coins::where('code', $base)->get();
            if(isset($coins) && count($coins) > 0 && isset($coins[0])){
                $queryHistory = $this->pairRepository->getListHistoryTradeByBaseTarget($market_name,$base, $target);
                $listHistory = $queryHistory->get();
                $queryListMarkets = $this->pairRepository->getListMarketsByBase($base);
                $listMarkets = $queryListMarkets->get();
                $markets = Markets::all();
                return view('coins.details', compact('inforBaseTarget', 'listMarkets', 'markets','listHistory'));
            }
            return abort('404');
        }
        return abort('404');
    }

    /**
     * Get list history by base - target
     * @param Request $request
     * @return string
     */
//    public function getHistoryBaseTarGet(Request $request){
//        $base = $request->base;
//        $target = $request->target;
//        $dateStart = new DateTime($request->start);
//        $newStart  =  $dateStart->getTimestamp();
//        $dateEnd = new DateTime($request->end);
//        $newEnd = $dateEnd->getTimestamp();
//        $queryHistory = $this->pairRepository->getListHistoryTradeByBaseTarget($base, $target, $newStart, $newEnd);
//        $listHistory = $queryHistory->get();
//        return $this->renderHtmlHistoryBaseTarget($listHistory);
//    }

    /**
     * HTML list history
     * @param $listHistory
     * @return string
     */
    public function renderHtmlHistoryBaseTarget($listHistory){
        return view ('coins.partial.history', compact('listHistory'))->render();
    }

    /**
     * This function get base - target by market name
     * @param $market
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allCurrencies($market){
        $market = $this->marketsRepository->findMarketByName($market);
        $market_id = isset($market) && !empty($market) ? $market->id : 1;
        $sortInfo = array();
        if (Input::has('sort') && Input::has('dir')) {
            $sortInfo['column'] = Input::get('sort');
            $sortInfo['order'] = Input::get('dir');
        }
        $columns = $this->getSortableColumns();
        $query = $this->pairRepository->getBaseByTarget($market_id, null, null, $sortInfo);
        $data = $query->get();
        return view('coins.allcoins', compact('data', 'columns', 'market_id'));

    }

    /**
     * This function get coin filter select
     * @param Request $request
     * @return string
     */
    public function getCoinsByFilter(Request $request){

        $value_market = $request->value_marketcap;
        $value_price = $request->value_price;
        $value_volume = $request->value_volume;
        $marketId = $request->market_id;

        $newValueMarket = explode('-', $value_market) ;
        $newValuePrice  = explode('-', $value_price) ;
        $newValueVolume = explode('-', $value_volume) ;
        $filter = array (
            'market'    => $newValueMarket,
            'price'      =>  $newValuePrice,
            'volume'    => $newValueVolume
        );
        $query = $this->pairRepository->getBaseByTarget($marketId, null, $filter, null);
        $data = $query->get();
        return $this->renderHtmlFilter($data, $filter);
    }

    /**
     * HTML list coins filter
     * @param $data
     * @param $filter
     * @return string
     */
    public function renderHtmlFilter($data, $filter){
        return view('coins.partial.coinsall', compact('data', 'filter'))->render();
    }

    /**
     * Function return data search
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchCurrencies(){
        $sortInfo = array();
        if (Input::has('sort') && Input::has('dir')) {
            $sortInfo['column'] = Input::get('sort');
            $sortInfo['order'] = Input::get('dir');
        }
        $Keyword = Input::get('keyword');
        $filters = array(
            'Keyword' => trim($Keyword),
        );
        $query = $this->pairRepository->getBaseByTarget(null, null, $filters, $sortInfo);
        $pagination = $query->simplePaginate('50')->appends(Input::except('page'))->render();
        $columns = $this->getColumnsSearch();
        $listCoinConverts = $query->get();
        return view('coins.search', compact('filters','listCoinConverts', 'columns', 'pagination'));
    }

    public function getColumnsSearch(){
        $columns = array(
            'name' => 'Name',
            'market_cap'    =>  'Market Cap',
            'price' => 'Price',
            'supply' => 'Circulating Supply',
            'volume' => 'Volume (24h)',
            'change_24h' => 'Change 24h',
            'image' =>  'Price Graph',
            'market_name'    =>  'Market'
        );
        return Helper::getSortableColumnOnArray($columns);
    }

    /**
     * This function return data auto complete search
     * @return mixed
     */
    public function autoCompleteSearch(){
        $term = Input::get('term');
        $results = array();
        $queries = $this->pairRepository->getCoinConvertSearchAutoComplete($term);
        foreach ($queries as $query)
        {
            $results[] =
                [
                    'id' => $query->id,
                    'name' => $query->name,
                    'base' => $query->base,
                    'target' => $query->target,
                    'images' => $query->images,
                    'market_name'   => $query->market_name,
                    'coin_name'   => $query->coinname
                ];
        }
        return Response::json($results);
    }


    public function autoCompleteSearchMarketCap(){
        $term = Input::get('term');
        $results = array();
        $queries = $this->pairRepository->getCoinMarketCapAutoComplete($term);
        foreach ($queries as $query)
        {
            $results[] =
                [
                    'id' => $query->id,
                    'name' => $query->name,
                    'images' => $query->images,
                    'coin_name'   => $query->coinname
                ];
        }
        return Response::json($results);
    }

    /**
     * This function get all Cryptocurrencies
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAllCryptocurrencies(){

        $sortInfo = array();
        if (Input::has('sort') && Input::has('dir')) {
            $sortInfo['column'] = Input::get('sort');
            $sortInfo['order'] = Input::get('dir');
        }
        $columns = $this->getSortableColumns();
        $query = $this->pairRepository->getBaseByTarget(null, null, null, $sortInfo);
        $data = $query->get();
        return view('coins.allcoins', compact('data', 'columns', 'market_id'));
    }
}