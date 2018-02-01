<?php
namespace App\Repositories\Eloquents;

use App\Models\Markets;
use App\Repositories\Contracts\MarketsRepositoryInterface;
use App\Models\Pair;
use DB;

class MarketsRepository implements MarketsRepositoryInterface
{

    public function insert($data){

    }

    public function update($data, $id){

    }

    public function delete($id){

    }

    public function find($id){

    }

    public function getListMarkets(){
        return Markets::pluck('id', 'market_name')->toArray();
    }

    public function findMarketByName($id){
        return Markets::where('market_name', $id)->first();
    }

    public function getAllMarket(){
        return Markets::all();
    }
}
