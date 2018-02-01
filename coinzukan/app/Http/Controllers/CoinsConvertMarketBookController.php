<?php

namespace App\Http\Controllers;

use App\Models\Pair;
use Illuminate\Http\Request;
use App\Models\Orderbook;
class CoinsConvertMarketBookController extends Controller
{

    public function getOrderByMarket($base,$target,$market_id,$type){

        try {
         $pair = Pair::select('pair.id')->where('base',$base)->where('target',$target)->where('market_id',$market_id)->first();
            $dataSellItem = Orderbook::select('order_book.pair_id','order_book.price','order_book.amount')
                         ->where('order_book.market_id',$market_id)
                         ->where('order_book.pair_id',$pair['id'])
                         ->where('order_book.type',$type)
                         ->get();

                foreach ($dataSellItem as $item){
                  $item['pair_id'] = floatval($item['pair_id']);
                  $item['price'] = floatval($item['price']);
                  $item['amount'] = floatval($item['amount']);
                }

                return $dataSellItem;

        } catch (Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());

        } catch (PDOException $e) {
            dd($e);
        }         
    }

}
