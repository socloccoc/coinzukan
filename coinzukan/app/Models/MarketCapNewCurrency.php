<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MarketCapNewCurrency extends Authenticatable
{
    use Notifiable;

    protected $table = 'coinmarketcap_new_currencies';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'symbol', 'added', 'marketcap', 'price', 'circulating_supply', 'volume_24h', 'percent_change_24h'
    ];
}
