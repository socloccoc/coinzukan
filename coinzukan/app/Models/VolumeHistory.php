<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class VolumeHistory extends Authenticatable
{
    use Notifiable;

    protected $table = 'volume_history';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'symbol', 'volume_24h_usd', 'volume_7d_usd', 'volume_30d_usd', 'created_at', 'updated_at'
    ];
}
