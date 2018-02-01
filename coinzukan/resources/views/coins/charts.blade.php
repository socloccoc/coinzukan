
@extends('layout.FrontMaster')
@section('icon')
    <link rel="icon" type="image/png" href="{{ asset(''. isset ($inforBaseTarget->icon_url) && !empty($inforBaseTarget->icon_url) && file_exists(public_path($inforBaseTarget->icon_url)) ? $inforBaseTarget->icon_url : 'images/coin_icon/icon_coin_default.png') }}"/>
@stop
@section('title')
    {{ isset($infoCoin->coin_name) && !empty($infoCoin->coin_name) ? $infoCoin->coin_name. ' ( ' . $infoCoin->symbol .' ) $' . $infoCoin->price_usd : '' }}
@stop
@section('content')
    <h1 class="text-center">{{ trans('content.HOME_PAGE.global_charts') }}</h1>
    <div class="vertical-spacer"></div>
    <h2 id="total-market-cap">{{ trans('content.HOME_PAGE.total_market_capitalization') }}</h2>
    <div id="total-market-capitalization" style="height: 450px; min-width: 410px"></div>
    <div class="vertical-spacer"></div>
    <h2 id="altcoin-market-cap">{{ trans('content.HOME_PAGE.total_market_capitalization_excluding_bitcoin') }}</h2>
    <div id="excluding-bitcoin" style="height: 450px; min-width: 410px"></div>
    <div id="btc-percentage"></div>
    <a href="#dominance-percentage"></a>
    <h2 id="dominance-percentage">{{ trans('content.HOME_PAGE.percentage_of_total_market_capitalization_dominance') }}</h2>
    <div id="total-market-capitalization-dominance" style="height: 450px; min-width: 410px"></div>
    <div id="btc-percentage"></div>
    <input hidden name="locale_name" value="{{ Config::get('app.locale') }}">
    <input hidden name="market_cap" value="{{ trans('content.HOME_PAGE.market_cap') }}">
    <input hidden name="24h_volume" value="{{ trans('content.HOME_PAGE.24h_vol') }}">
    <input hidden name="price" value="{{ trans('content.HOME_PAGE.price') }}">
    <input hidden name="percentage_of_total_market_cap" value="{{ trans('content.HOME_PAGE.percentage_of_total_market_cap') }}">
@stop

@section('script_footer')

@stop