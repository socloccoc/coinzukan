<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ExchangeRateUsdMoneyOther;
use App\Models\CoinExchangeRate;
class ConvertMoneyController extends Controller
{
    //
    public function index() {
        $coinConvertUSD_OtherMoney = ExchangeRateUsdMoneyOther::get(['id', 'name','exchange_rate']);
        $coinConvertExchangeRateCoins_USD = CoinExchangeRate::get(['id', 'base','exchange_usd']);
        return  response()->json([ 'data' => [ 'exchange_rate_usd_other_money' => $coinConvertUSD_OtherMoney,
        'exchange_rate_coins_usd' => $coinConvertExchangeRateCoins_USD
            ]
        ]);

    }
}
