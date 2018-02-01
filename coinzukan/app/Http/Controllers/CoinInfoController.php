<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\CoinInfo;

class CoinInfoController extends Controller
{
    public function index() {
        return CoinInfo::all();
    }

    public function getInfoByCodeString($target, $code_string) {
        // validate $code_string
        if (trim($code_string) == '' || trim($target) == '') {
            return null;
        }

        // get the list of code
        $codeList = explode(':::', $code_string);
        $codeList = array_map('strtolower', $codeList);

        return CoinInfo::where('target', $target)
                        ->whereIn('base', $codeList)
                        ->get();
    }
}
