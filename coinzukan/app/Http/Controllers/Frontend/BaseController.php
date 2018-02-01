<?php namespace App\Http\Controllers\FrontEnd;

use App\CoinConvert;
use App\Http\Controllers\Controller;
use Input;
use Illuminate\Http\Request;
use App\Http\Requests;
use View;
use App\Repositories\Contracts\PairRepositoryInterface;
use App\Repositories\Contracts\MarketsRepositoryInterface;
use App\Repositories\Contracts\CoinMarketCapRepositoryInterface;

class BaseController extends Controller
{
    //Setting Default Values

    protected $pairRepository;
    protected $marketsRepository;
    protected $marketCapRepository;
    public function __construct(PairRepositoryInterface $pairRepository,
                                MarketsRepositoryInterface $marketsRepository,
                                CoinMarketCapRepositoryInterface $marketCapRepository)
    {
        $this->pairRepository = $pairRepository;
        $this->marketsRepository = $marketsRepository;
        $this->marketCapRepository = $marketCapRepository;
        $countTotalCurrencies = $this->countTotalCurrencies();
        $listMarkets = $this->getListMarkets();
        $marketCap = $this->getMarketcap();
        $listMoney = $this->marketCapRepository->getListMoney();
        $rateBtcAndEth = $this->marketCapRepository->getRateBtcAndEth();
        View::share('countTotalCurrencies', $countTotalCurrencies);
        View::share('listMarkets', $listMarkets);
        View::share('MarketNumber', count($listMarkets));
        View::share('marketCap', $marketCap);
        View::share('listMoney', $listMoney);
        View::share('rateBtcAndEth', $rateBtcAndEth);
    }

    /**
     * function count total Currencies
     * @return mixed
     */
    public function countTotalCurrencies(){
       return $coin = $this->pairRepository->getBaseByTarget(null, null, null, null)->count();
    }

    /**
     * function get list markets
     * @return mixed
     */
    public function getListMarkets(){
        return $markets = $this->marketsRepository->getListMarkets();
    }

    public function getMarketcap(){
        return $marketCap = $this->marketCapRepository->getMarketCap()->first();
    }
}