<?php

namespace App\Http\Controllers;

use App\Models\Trades;
use Illuminate\Http\Request;
use App\Models\Pair;
class CoinConvertMarketTradeHistoryController extends Controller
{
    public function getTradeHistry($base,$target,$market_id = 0){
        $pair = Pair::select('pair.id')->where('base',$base)->where('target',$target)->where('market_id',$market_id)->first();
        $dataItem = Trades::where('pair_id',$pair['id'])
                            ->where('market_id',$market_id)
                            ->select('id','market_id','pair_id','trades_id','date','rate','amount')
                            ->get();
        foreach ($dataItem as $item){
            $item['market_id'] = intval($item['market_id']);
            $item['pair_id'] = floatval($item['pair_id']);
            $item['trades_id'] = floatval($item['trades_id']);
            $item['rate'] = floatval($item['rate']);
            $item['amount'] = floatval($item['amount']);
            }
                        
        return $dataItem;

    }
}
