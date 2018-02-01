<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Coin extends Model
{

    public function findCoinsByCode($code){
        return DB::table('coins')
             ->where('code', $code)
             ->select('coins.id');
    }

    public function arrayCoins(){
        $query = DB::table('coins')
                ->select('coins.id', 'coins.code')
                ->pluck('id', 'code')->toArray();
        return $query;
    }

    public function insert($data){
        return Coin::insertGetId($data);
    }

}