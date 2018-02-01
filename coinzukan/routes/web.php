<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'FrontEnd', 'middleware' => 'locale'], function () {

  Route::get('/home', [
    'as' => 'home',
    'uses' => 'PairController@index'
  ]);

  Route::get('/market/{market_name}/{base}-{target}/', [
    'as' => 'coin-convert',
    'uses' => 'PairController@detailsBaseTarget'
  ]);
  Route::get('/market/{market_name}/{base}-{target}/markets', [
    'as' => 'coin-convert2',
    'uses' => 'PairController@detailsBaseTarget'
  ]);

  Route::get('/option', [
    'as' => 'market',
    'uses' => 'PairController@getCoinsByMarket'
  ]);
  Route::get('/cryptocurrencies/{market}/all', [
    'as' => 'cryptocurrencies.market.all',
    'uses' => 'PairController@allCurrencies'
  ]);

  Route::post('/filterCurrencies', [
    'as' => 'filterCurrencies',
    'uses' => 'PairController@getCoinsByFilter'
  ]);
  Route::post('/getHistoryBaseTarGet', [
    'as' => 'getHistoryBaseTarGet',
    'uses' => 'PairController@getHistoryBaseTarGet'
  ]);
  Route::get('/cryptocurrencies/search', [
    'as' => 'cryptocurrencies.search',
    'uses' => 'PairController@searchCurrencies'
  ]);
  Route::get('/cryptocurrencies/search/autocomplete', [
    'as' => 'cryptocurrencies.search.autocomplete',
    'uses' => 'PairController@autoCompleteSearch'
  ]);

  Route::get('/cryptocurrencies/search/autocomplete/marketcap', [
    'as' => 'cryptocurrencies.search.autocomplete.marketcap',
    'uses' => 'PairController@autoCompleteSearchMarketCap'
  ]);

  Route::get('/cryptocurrencies/all', [
    'as' => 'cryptocurrencies.all',
    'uses' => 'PairController@getAllCryptocurrencies'
  ]);

  Route::get('/setting', [
    'as' => 'setting',
    'uses' => 'HomeController@setting'
  ]);

  Route::post('/setting', [
    'as' => 'post.setting',
    'uses' => 'HomeController@postSetting'
  ]);

  Route::get('/', [
    'as' => 'homeMarketCap',
    'uses' => 'HomeCustomController@index'
  ]);


  Route::get('/home/all', [
    'as' => 'all.coins.marketcap',
    'uses' => 'HomeCustomController@getAllCoinMarketCap'
  ]);

  Route::get('/currencies/volume', [
    'as' => 'currencies.volume.marketcap',
    'uses' => 'HomeCustomController@currenciesVolume'
  ]);

  Route::get('/exchanges/volume', [
    'as' => 'exchanges.volume.marketcap',
    'uses' => 'HomeCustomController@exchangesVolume'
  ]);

  Route::get('/currencies/volume/monthly', [
    'as' => 'currencies.volume.history',
    'uses' => 'HomeCustomController@volumeHistory'
  ]);

  Route::get('/currencies/{coins}', [
    'as' => 'detail.coin',
    'uses' => 'HomeCustomController@getDetailCoin'
  ]);

  Route::post('/history/data', [
    'as' => 'data.history.coin',
    'uses' => 'HomeCustomController@getHistoryDataCoin'
  ]);

  Route::get('/new', [
    'as' => 'new.currency',
    'uses' => 'HomeCustomController@getNewCoins'
  ]);

  Route::get('/calculator', [
    'as' => 'calculator.currency',
    'uses' => 'HomeCustomController@calculatorCurrency'
  ]);

  Route::post('/calculator', [
    'as' => 'calculator.currency.post',
    'uses' => 'HomeCustomController@convertPrimaryToSecondaryByAmount'
  ]);

  Route::get('/historical', [
    'as' => 'historical.snapshots',
    'uses' => 'HomeCustomController@historicalSnapshots'
  ]);

  Route::get('/historical/{date}', [
    'as' => 'historical.get.snapshots',
    'uses' => 'HomeCustomController@getHistoricalSnapshots'

  ]);

  Route::get('/charts', [
    'as' => 'charts',
    'uses' => 'HomeCustomController@charts'
  ]);

  Route::get('coins', [
    'as' => 'coins',
    'uses' => 'HomeCustomController@coins'
  ]);

  Route::get('coin/{totalSupply}', [
    'as' => 'coin.totalSupply',
    'uses' => 'HomeCustomController@coins'
  ]);

  Route::get('/coins/all', [
    'as' => 'all.coins',
    'uses' => 'HomeCustomController@allCoins'
  ]);

  Route::get('tokens', [
    'as' => 'tokens',
    'uses' => 'HomeCustomController@tokens'
  ]);

  Route::get('/tokens/all', [
    'as' => 'tokens.all',
    'uses' => 'HomeCustomController@allTokens'
  ]);

  Route::get('/tokens/totalSupply', [
    'as' => 'tokens.totalSupply',
    'uses' => 'HomeCustomController@TokensTotalSupply'
  ]);

  Route::get('change-language/{language}', 'HomeCustomController@changeLanguage')->name('user.change-language');

});

Route::group(['prefix' => 'ajax'], function () {

  Route::get('searchCurrencies', [
    'as' => 'searchCurrencies',
    'uses' => 'AjaxController@searchCurrencies'
  ]);

  Route::get('getDataChart', [
    'as' => 'getDataChart',
    'uses' => 'AjaxController@getDataChart'
  ]);

  Route::get('getDataChartImage', [
    'as' => 'getDataChartImage',
    'uses' => 'AjaxController@getDataChartImage'
  ]);

  Route::get('chartOfMarketCapHomepage', [
    'as' => 'chartOfMarketCapHomepage',
    'uses' => 'AjaxController@chartOfMarketCapHomepage'
  ]);

  Route::get('chartOfMarketCapDetailPage', [
    'as' => 'chartOfMarketCapDetailPage',
    'uses' => 'AjaxController@chartOfMarketCapDetailPage'
  ]);

  Route::get('marketcapGlobalChartData', [
    'as' => 'marketcapGlobalChartData',
    'uses' => 'AjaxController@marketcapGlobalChartData'
  ]);
});