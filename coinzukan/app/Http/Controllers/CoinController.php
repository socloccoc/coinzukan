<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coin;

class CoinController extends Controller
{
    public function index() {
        return Coin::all();
    }
}
