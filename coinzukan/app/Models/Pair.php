<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pair extends Model
{
    protected $table = 'pair';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'base',
        'target',
        'price',
        'last24hr',
        'low24hr',
        'baseVolume',
        'percenChange24hr',
        'changeAbsolute24hr'
    ];
}
