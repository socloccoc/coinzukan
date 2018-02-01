<?php namespace App\Http\Controllers\FrontEnd;

use App\CoinConvert;
use App\Http\Controllers\Controller;
use Input;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\RssLink;
use Response;

class RssLinkController extends Controller
{
    public function getAllRssLink(){
        $rss = RssLink::all();
        return Response::json([
                'status' => 'success',
                'data' => $rss->toArray(),
            ],
            200
        );
    }
}