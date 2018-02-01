<?php namespace App\Http\Controllers\FrontEnd;

use App\CoinConvert;
use App\CoinConvertMarkets;
use App\CoinConvertMarketTradeHistory;
use App\Http\Controllers\Controller;
use App\Coin;
use App\Market;
use Illuminate\Support\Facades\Session;
use Input;
use Illuminate\Http\Request;
use App\Http\Requests;
use Helper;
use Response;
use DB;
use App\Models\Setting;
use EnvatoUser;
use App\Models\Coinmarketcap;

Class HomeController extends BaseController {

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
            'image' =>  'Price Graph'
        );
        return Helper::getSortableColumnOnArray($columns);
    }

    /**
     * This function get detail Cryptocurrencies Base Target
     * @param $base
     * @param $target
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detailsBaseTarget($base, $target){

        $coinConvert = new CoinConvert();
        $query = $coinConvert->findDataByBaseTarget($base, $target);
        $data = $query->get();
        if(!empty($data[0])){
            $coins = Coin::where('code', $base)->get();
            if(isset($coins) && count($coins) > 0 && isset($coins[0]) ){
                $coinMarket = new CoinConvertMarkets();
                $query = $coinMarket->getInforByBaseTarget($base, $target);
                $inforBaseTarget = $query->get();

                $markets = new Market();
                $queryMarkets = $markets->getListMarketsByBase($base, $target);
                $listMarkets = $queryMarkets->get();
                $markets = Market::all();

                return view('coins.details', compact('inforBaseTarget', 'listMarkets', 'markets'));
            }else{
                abort('404');
            }
        }else{
            abort('404');
        }
    }

    /** Function get coins by target
     * @param $target
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCoinsByTarget($target){
        $coin = Coin::where('code', $target)
                    ->get();
        if(empty($coin[0])){
            abort('404');
        }else{
            $coinsConvertModels = new CoinConvert();
            $sortInfo = array();
            if (Input::has('sort') && Input::has('dir')) {
                $sortInfo['column'] = Input::get('sort');
                $sortInfo['order'] = Input::get('dir');
            }
            $query = $coinsConvertModels->getCoinsConvertByTarget($target, null, $sortInfo);
            $pagination = $query->simplePaginate('50')->render();
            $columns = $this->getSortableColumns();
            $data = $query->get();
            return view('layout.FrontHome', compact( 'data', 'pagination', 'columns'));
        }
    }

    /** This function get all Cryptocurrencies (Base - Target)
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAllCoins(){
        $coinsConvertModels = new CoinConvert();
        $sortInfo = array();
        if (Input::has('sort') && Input::has('dir')) {
            $sortInfo['column'] = Input::get('sort');
            $sortInfo['order'] = Input::get('dir');
        }
        $columns = $this->getSortableColumns();
        $query = $coinsConvertModels->getCoinsConvertByTarget(null, null, $sortInfo);
        $data = $query->get();
        return view('coins.allcoins', compact('data', 'columns'));

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

        $newValueMarket = explode('-', $value_market) ;
        $newValuePrice  = explode('-', $value_price) ;
        $newValueVolume = explode('-', $value_volume) ;
        $filter = array (
            'market'    => $newValueMarket,
            'price'      =>  $newValuePrice,
            'volume'    => $newValueVolume
        );
        $coinsConvertModels = new CoinConvert();
        $query = $coinsConvertModels->getCoinsConvertByTarget(null, $filter, null);
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
     * Get list history by base - target
     * @param Request $request
     * @return string
     */
    public function getHistoryBaseTarGet(Request $request){
        $base = $request->base;
        $target = $request->target;
        $start = $request->start;
        $end = $request->end;

        $tradeHistory = new CoinConvertMarketTradeHistory();
        $queryHistory = $tradeHistory->getListHistoryTradeByBaseTarget($base, $target, $start, $end);
        $listHistory = $queryHistory->get();
        return $this->renderHtmlHistoryBaseTarget($listHistory);
    }

    /**
     * HTML list history
     * @param $listHistory
     * @return string
     */
    public function renderHtmlHistoryBaseTarget($listHistory){
        return view ('coins.partial.history', compact('listHistory'))->render();
    }

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
        $coinConvert = new CoinConvert();
        $query = $coinConvert->getCoinsConvert($filters, $sortInfo);
        $pagination = $query->simplePaginate('50')->render();
        $columns = $this->getColumnsSearch();
        $listCoinConverts = $query->get();
        return view('coins.search', compact('filters','listCoinConverts', 'columns', 'pagination'));
    }

    public function autoCompleteSearch(){
        $term = Input::get('term');
        $results = array();
        $coinConvert = new CoinConvert();
        $queries = $coinConvert->getCoinConvertSearchAutoComplete($term);
        foreach ($queries as $query)
        {
            $results[] =
                [
                         'id' => $query->id,
                         'name' => $query->coin_convert_name,
                         'base' => $query->base,
                         'target' => $query->target,
                         'images' => $query->images
                ];
        }
        return Response::json($results);
    }

    public function getColumnsSearch(){
        $columns = array(
            'name' => 'Name',
            'market_cap'    =>  'Market Cap',
            'price' => 'Price',
            'supply' => 'Circulating Supply',
            'volume' => 'Volume (24h)',
            'change_24h' => 'Change 24h',
            'image' =>  'Price Graph'
        );
        return Helper::getSortableColumnOnArray($columns);
    }

    public function setting(){
        $setting = Setting::find(1);
        return view('layout.setting',compact('setting'));
    }

    public function postSetting(Request $request){
        $this->validate($request,[
            'version' => 'required',
            'messages' => 'required|max:191',
            'TermsAndPrivacy' => 'required'
        ]);
        $setting = Setting::find(1);
        $setting->version = $request->version;
        $setting->messages = $request->messages;
        $setting->TermsAndPrivacy = $request->TermsAndPrivacy;
        $setting->save();
        return redirect('setting')->with('messages','update success !');
    }

    public function getVersion(){
        $setting = Setting::orderBy('id', 'DESC')->select('version','messages')->first();
        if(is_null($setting))
            return $this->responseData('False','Not exits data','');
        else
            return  $this->responseData('True','Success',$setting);
    }

    public function TermsAndPrivacy(){
        $setting =Setting::orderBy('id', 'DESC')->select('TermsAndPrivacy')->first();
        if(is_null($setting))
            return $this->responseData('False','Not exits data','');
        else
            return  $this->responseData('True','Success',$setting);
    }
    private function responseData($status,$message,$data){
        return response()->json(['success' => $status,'message'=>$message,'data'=>$data], 200);
    }

}
