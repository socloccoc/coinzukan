<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class HistorySnapShoot extends Model
{
    protected $table = 'coinmarketcap_history_snap';

    protected $fillable = [
        'date',
        'name',
        'symbol',
        'marketcap_usd',
        'marketcap_btc',
        'price_usd',
        'price_btc',
        'circulating_supply',
        'percent_1h_usd',
        'percent_1h_btc',
        'percent_24h_usd',
        'percent_24h_btc',
        'percent_7d_usd',
        'percent_7d_btc'
    ];


}