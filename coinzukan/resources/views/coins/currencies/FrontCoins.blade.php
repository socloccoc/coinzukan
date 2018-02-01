@extends('layout.FrontMaster')
@section('icon')
    <link rel="icon" type="image/png" href="https://coinmarketcap.com/static/img/CoinMarketCap.png" sizes="16x16"/>
@stop
@section('title')
    Coinzukan
@stop
@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                @if( Route::currentRouteName() != 'all.coins')
                    {!! Form::open(array('route' => 'coins','method'=>'get', 'id' => 'form_exchange_rate')) !!}
                @else
                    {!! Form::open(array('route' => 'all.coins','method'=>'get', 'id' => 'form_exchange_rate')) !!}
                @endif
                @include('partial.navigationBody')
                <div class="col-xs-6 col-md-4 text-left">
                    <div class="styled-select">
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                {!! Form::select('exchange', ['USD'=>'USD', 'BTC' => 'BTC', 'ETH' => 'ETH'] , ' ',['class'=>'btn btn-primary', 'onchange' => 'this.form.submit()'])!!}
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
                <div class="col-xs-12 col-md-4 text-right">
                    <div class="clear"></div>
                    @if( Route::currentRouteName() != 'all.coins')
                        <div class="pull-right" id="paginator">
                            @include('partial.paginate_header')
                        </div>
                    @else
                        <div class="pull-right" id="paginator" style="margin-right: -70px">
                            <ul class="pagination top-paginator">
                                <li>
                                    <a href="/">{{ trans('pagination.back_to_top_100') }}</a>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            <div id="currencies_wrapper" class="dataTables_wrapper no-footer">
                <table class="table dataTable no-footer" id="dataTable">
                    <thead>
                    <tr role="row">
                        <th style="width: 23px;">#
                        </th>

                        <th style="width: 150px;">
                            {{ trans('content.HOME_PAGE.name') }}
                        </th>
                        @if(Route::currentRouteName() == 'all.coins')
                            <th style="width: 75px;" class="text-left">
                                {{ trans('content.HOME_PAGE.symbol') }}
                            </th>
                            <th style="width: 115px;" class="text-right">
                                {{ trans('content.HOME_PAGE.market_cap') }}
                            </th>
                            <th style="width: 73px;" class="text-right">
                                {{ trans('content.HOME_PAGE.price') }}
                            </th>
                            <th style="width: 170px;" class="text-right">
                                {{ trans('content.HOME_PAGE.volume_24h') }}
                            </th>
                            <th style="width: 110px;" class="text-right">
                                {{ trans('content.HOME_PAGE.circulating_supply') }}
                            </th>
                            <th style="width: 162px;" class="text-right">
                                {{ trans('content.HOME_PAGE.1h') }}
                            </th>
                            <th style="width: 162px;" class="text-right">
                                {{ trans('content.HOME_PAGE.24h') }}
                            </th>
                            <th style="width: 162px;" class="text-right">
                                {{ trans('content.HOME_PAGE.7d') }}
                            </th>
                        @else
                            <th style="width: 115px;" class="text-right">
                                {{ trans('content.HOME_PAGE.market_cap') }}
                            </th>
                            <th style="width: 73px;" class="text-right">
                                {{ trans('content.HOME_PAGE.price') }}
                            </th>
                            <th style="width: 110px;" class="text-right">
                                {{ trans('content.HOME_PAGE.volume_24h') }}
                            </th>
                            <th style="width: 110px;" class="text-right">
                                @if(!empty($isTotalSupply))
                                    {{ trans('content.HOME_PAGE.total_supply') }}
                                @else
                                    {{ trans('content.HOME_PAGE.circulating_supply') }}
                                @endif
                            </th>
                            <th style="width: 115px;" class="text-right">
                                {{ trans('content.HOME_PAGE.change_24h') }}
                            </th>
                            <th style="width: 162px;">
                                {{ trans('content.HOME_PAGE.price_graph_7d') }}
                            </th>
                        @endif
                    </tr>
                    </thead>
                    <tbody class="listCoins">
                    @if ( isset($listCryptocurrencies) && count($listCryptocurrencies) > 0)
                        @if( Route::currentRouteName() == 'all.coins')
                            @include('coins.currencies.allCurrencies')
                        @else
                            @include('coins.currencies.listCurrencies')
                        @endif
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="pull-right" id="paginator">
                @if( Route::currentRouteName() != 'all.coins' )
                    @include('partial.paginate_bottom')
                @else
                    <div class="pull-right" id="paginator" style="margin-right: -70px">
                        <ul class="pagination top-paginator">
                            <li>
                                <a href="/">{{ trans('pagination.back_to_top_100') }}</a>
                            </li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop