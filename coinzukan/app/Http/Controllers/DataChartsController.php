<?php

namespace App\Http\Controllers;

use App\Models\Ohlc;
use App\Models\Pair;
use Illuminate\Http\Request;
class DataChartsController extends Controller
{

    public function getDataChart($base,$target,$market_id,$key){
        try {

            $pair = Pair::select('pair.id')->where('base',$base)->where('target',$target)->where('market_id',$market_id)->first();
            $dataChartItem = Ohlc::where('ohlc.pair_id',$pair['id'])
                                ->where('ohlc.market_id',$market_id)
                                ->where('ohlc.key',$key)
                                ->get();

            foreach ($dataChartItem as $item){
                $item['market_id'] = floatval($item['market_id']);
                $item['pair_id'] = intval($item['pair_id']);
                $item['key'] = intval($item['key']);                
                $item['open'] = floatval($item['open']);
                $item['high'] = floatval($item['high']);
                $item['low'] = floatval($item['low']);
                $item['close'] = floatval($item['close']);
                $item['volume'] = floatval($item['volume']);
                }
                        
            return $dataChartItem;
        } catch (Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());

        } catch (PDOException $e) {
            dd($e);
        }         
    }

}
