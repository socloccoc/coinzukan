<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CoinConvert;
class CoinConvertController extends Controller
{
    
    public function index() {
        return $coinConvert = CoinConvert::get(['id', 'coin_convert_name','base','target']);
    }

}
