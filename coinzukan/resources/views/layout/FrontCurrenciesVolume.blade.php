@extends('layout.FrontMaster')
@section('icon')
    <link rel="icon" type="image/png" href="https://coinmarketcap.com/static/img/CoinMarketCap.png" sizes="16x16"/>
@stop
@section('title')
    Coinzukan
@stop
@section('content')
    <div class="row subheader">
        <div class="col-xs-12 text-center">
            <h1>{{ trans('content.HOME_PAGE.24_hour_volume_rankings_currency') }}</h1>
        </div>
    </div>
    <?php
        $i = 0;
    ?>
    <div class="row">
        <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="table-responsive">
                <table class="table no-border table-condensed">
                    <tbody>
                    @foreach($listCoins as $listCoin)
                        <tr id="bitcoin">
                            <td colspan="6" class="volume-header-container">
                                <h3 class="volume-header">1.
                                    <a href="">
                                        {{ isset($listCoin->coins_name) && !empty($listCoin->coins_name) ? $listCoin->coins_name : '' }}
                                    </a>
                                </h3>
                            </td>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('content.HOME_PAGE.source') }}</th>
                            <th>{{ trans('content.HOME_PAGE.pair') }}</th>
                            <th class="text-right">{{ trans('content.HOME_PAGE.volume_24h') }}</th>
                            <th class="text-right">{{ trans('content.HOME_PAGE.price') }}</th>
                            <th class="text-right">{{ trans('content.HOME_PAGE.volume_percent') }}</th>
                        </tr>
                        {!! App::make('App\Http\Controllers\FrontEnd\HomeCustomController')->getMarketByCode($listCoin->coins_code)!!}
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="clear"></div>
            * {{ trans('content.HOME_PAGE.price_excluded') }}
        </div>
    </div>
@stop