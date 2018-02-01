<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('coins', 'CoinController@index');
Route::get('list_coin_pair','CoinConvertController@index');
Route::get('coin_infos/{base}-{target}','CoinConvertMarketsController@getCoinByMarket');
Route::get('coin_infos/{base}-{target}/market/{market_id}','CoinConvertMarketsController@getCoinByMarket');
Route::get('list_coins/{StyleCoinsInfo}','CoinConvertMarketsController@getListCoinAtHome');
Route::get('order_book/{base}-{target}/market/{market_id}/{type}','CoinsConvertMarketBookController@getOrderByMarket');
Route::get('tradehistory_list/{base}-{target}/market/{market_id}','CoinConvertMarketTradeHistoryController@getTradeHistry');
Route::get('get_data_chart/{base}-{target}/market/{market_id}/{key}','DataChartsController@getDataChart');
Route::get('exchangerates_moneys','ConvertMoneyController@index');
Route::post('registry_alert',['uses'=>'PushNotifyController@registryInfoDevice']);
Route::post('update_alert',['uses'=>'PushNotifyController@updateArlert']);
Route::get('get_alert',['uses'=>'PushNotifyController@getAlerByToken']);
Route::get('get_alert_in_detail',['uses'=>'PushNotifyController@getAlerByBaseTarget']);
Route::get('delete_alert',['uses'=>'PushNotifyController@deleteArlert']);
Route::get('change_status_all_alerts',['uses'=>'PushNotifyController@statusNotifys']);
Route::get('changeLog','Frontend\HomeController@getVersion');
Route::get('termsAndPrivacy','Frontend\HomeController@TermsAndPrivacy');
// Route::get('pushnotify_test','PushNotifyController@checkPushNotify');
Route::get('rss/list','Frontend\RssLinkController@getAllRssLink');

