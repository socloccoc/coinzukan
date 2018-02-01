@extends('layout.FrontMaster')
@section('icon')
    <link rel="icon" type="image/png" href="https://coinmarketcap.com/static/img/CoinMarketCap.png" sizes="16x16"/>
@stop
@section('title')
    {{ trans('content.HOME_PAGE.historical_snapshots') }} | {{ trans('content.HOME_PAGE.coinmarketcap') }}
@stop
@section('content')
    <div class="col-xs-12 text-center">
        <h1 class="bottom-margin-1x">{{ trans('content.HOME_PAGE.historical_snapshots') }} - {{ isset($dateConvert) ? $dateConvert : '' }}</h1>
        <br>
    </div>


    <div class="col-xs-12">
        <div class="row">

            <div class="hidden-xs hidden-sm col-md-4 text-left">
                {!! Form::open(array('method'=>'get', 'id' => 'form_exchange_rate')) !!}
                <div id="currency-switch" class="btn-group">
                    {!! Form::select('exchange', ['USD'=>'USD', 'BTC' => 'BTC'], ' ',['class'=>'btn btn-primary', 'onchange' => 'this.form.submit()'])!!}
                </div>
                {!! Form::close() !!}
            </div>

            <div class="col-xs-8 text-right">
                <div class="clear"></div>
                <div class="pull-right">
                    <ul class="pagination top-paginator">
                        <li><a href="/historical/">{{ trans('pagination.view_all') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="table-responsive compact-name-column">
            <div id="currencies-all_wrapper" class="dataTables_wrapper no-footer">
                <table class="table js-summary-table dataTable no-footer" id="dataTable" style="font-size: 14px; width: 100%;" role="grid">
                    <thead>
                    <tr role="row">
                        <th class="text-center" rowspan="1" colspan="1" aria-label="#" style="width: 18px;">#</th>
                        <th id="th-name" class="sortable sorting" tabindex="0" aria-controls="currencies-all" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 148px;">
                            {{ trans('content.HOME_PAGE.name') }}
                        </th>
                        <th id="th-symbol" class="sortable col-symbol sorting" tabindex="0" aria-controls="currencies-all" rowspan="1" colspan="1" aria-label="Symbol: activate to sort column ascending" style="width: 84px;">
                            {{ trans('content.HOME_PAGE.symbol') }}
                        </th>
                        <th id="th-marketcap" class="sortable text-right sorting" data-mobile-text="M. Cap" tabindex="0" aria-controls="currencies-all" rowspan="1" colspan="1" aria-label="Market Cap: activate to sort column descending" style="width: 138px;">
                            {{ trans('content.HOME_PAGE.market_cap') }}
                        </th>
                        <th id="th-price" class="sortable text-right sorting" tabindex="0" aria-controls="currencies-all" rowspan="1" colspan="1" aria-label="Price: activate to sort column descending" style="width: 94px;">
                            {{ trans('content.HOME_PAGE.price') }}
                        </th>
                        <th id="th-totalsupply" class="sortable text-right sorting" title="The number of coins in existence available to the public" data-mobile-text="Supply" tabindex="0" aria-controls="currencies-all" rowspan="1" colspan="1" aria-label="Circulating Supply: activate to sort column descending" style="width: 200px;">
                            {{ trans('content.HOME_PAGE.circulating_supply') }}
                        </th>
                        <th id="th-change1h" class="sortable text-right sorting" tabindex="0" aria-controls="currencies-all" rowspan="1" colspan="1" aria-label="% 1h: activate to sort column descending" style="width: 60px;">
                            {{ trans('content.HOME_PAGE.1h') }}
                        </th>
                        <th id="th-change24h" class="sortable text-right sorting" tabindex="0" aria-controls="currencies-all" rowspan="1" colspan="1" aria-label="% 24h: activate to sort column descending" style="width: 73px;">
                            {{ trans('content.HOME_PAGE.24h') }}
                        </th>
                        <th id="th-change7d" class="sortable text-right sorting" tabindex="0" aria-controls="currencies-all" rowspan="1" colspan="1" aria-label="% 7d: activate to sort column descending" style="width: 62px;">
                            {{ trans('content.HOME_PAGE.7d') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0 ?>
                    @forelse($listCoinSnapShots as $listCoinSnapShot)
                        <?php $i++ ?>
                        <tr id="id-bitcoin" class="low-volume  odd" role="row">
                            <td class="text-center sorting_1">
                                {{ $i }}
                            </td>
                            <td class="no-wrap currency-name">
                                <?php
                                $url = isset($listCoinSnapShot->coins_images) && !empty($listCoinSnapShot->coins_images) && (file_exists(base_path() . "/public_html" . $listCoinSnapShot->coins_images) || file_exists(public_path($listCoinSnapShot->coins_images))) ? $listCoinSnapShot->coins_images : 'images/coin_icon/icon_coin_default.png';
                                ?>
                                <img src="{{ $url }}" class="currency-logo" alt="{{ isset($listCoinSnapShot->name) && !empty($listCoinSnapShot->name) ? $listCoinSnapShot->name : ''}}">
                                <a class="currency-name-container" href="/currencies/{{ isset($listCoinSnapShot->name) && !empty($listCoinSnapShot->name) ? $listCoinSnapShot->name : ''}}/">
                                    {{ isset($listCoinSnapShot->name) && !empty($listCoinSnapShot->name) ? $listCoinSnapShot->name : ''}}
                                </a>
                            </td>
                            <td class="text-left col-symbol">
                                {{ isset($listCoinSnapShot->symbol) && !empty($listCoinSnapShot->symbol) ? $listCoinSnapShot->symbol : ''}}
                            </td>
                            <td class="no-wrap market-cap text-right" data-usd="{{ isset($listCoinSnapShot->marketcap_usd) && !empty($listCoinSnapShot->marketcap_usd) ? $listCoinSnapShot->marketcap_usd : ''}}">
                                {{ $exchange == 'USD' && isset($listCoinSnapShot->marketcap_usd) && !empty($listCoinSnapShot->marketcap_usd) ? $unit.number_format($listCoinSnapShot->marketcap_usd, 3) : (isset($listCoinSnapShot->marketcap_btc ) && !empty($listCoinSnapShot->marketcap_btc) ? number_format($listCoinSnapShot->marketcap_btc, 3). ' ' . $unit : '?') }}
                            </td>
                            <td class="no-wrap text-right">
                                <a href="#" class="price" data-usd="{{ isset($listCoinSnapShot->price) && !empty($listCoinSnapShot->price) ? $listCoinSnapShot->price : ''}}">
                                    {{ $exchange == 'USD' && isset($listCoinSnapShot->price_usd) && !empty($listCoinSnapShot->price_usd) ? $unit . number_format($listCoinSnapShot->price_usd, 6) : (isset($listCoinSnapShot->price_btc) && !empty($listCoinSnapShot->price_btc) ? number_format($listCoinSnapShot->price_btc, 8). ' ' . $unit : '?' )  }}
                                </a>
                            </td>
                            <td class="no-wrap text-right circulating-supply">
                                <a href="#" data-supply="{{ isset($listCoinSnapShot->circulating_supply) && !empty($listCoinSnapShot->circulating_supply) ? number_format($listCoinSnapShot->circulating_supply, 0) : ''}}" data-supply-container="">
                                    {{ isset($listCoinSnapShot->circulating_supply) && !empty($listCoinSnapShot->circulating_supply) ? number_format($listCoinSnapShot->circulating_supply, 0) : ''}}
                                </a>
                            </td>
                            <td class="no-wrap percent-1h  text-right {{ isset($listCoinSnapShot->percent_1h_usd) && !empty($listCoinSnapShot->percent_1h_usd)  && $listCoinSnapShot->percent_1h_usd > 0 ? 'positive_change' : 'negative_change'  }}" data-usd="{{ isset($listCoinSnapShot->percent_1h_usd) && !empty($listCoinSnapShot->percent_1h_usd) ? number_format($listCoinSnapShot->percent_1h_usd, 2). ' %' : '?' }}" >
                                {{ $exchange == 'USD' && isset($listCoinSnapShot->percent_7d_usd) && !empty($listCoinSnapShot->percent_1h_usd) ? number_format($listCoinSnapShot->percent_1h_usd, 2). ' %' : (isset($listCoinSnapShot->percent_1h_btc) && !empty($listCoinSnapShot->percent_1h_btc) ? number_format($listCoinSnapShot->percent_1h_btc, 2). ' %' : '?')  }}
                            </td>
                            <td class="text-right {{ isset($listCoinSnapShot->percent_24h_usd) && !empty($listCoinSnapShot->percent_24h_usd)  && $listCoinSnapShot->percent_24h_usd > 0 ? 'positive_change' : 'negative_change'  }} ">
                                {{ $exchange == 'USD' && isset($listCoinSnapShot->percent_24h_usd) && !empty($listCoinSnapShot->percent_24h_usd) ? number_format($listCoinSnapShot->percent_24h_usd, 2). ' %' : (isset($listCoinSnapShot->percent_24h_btc) && !empty($listCoinSnapShot->percent_24h_btc) ? number_format($listCoinSnapShot->percent_24h_btc, 2). ' %' : '?')  }}
                            </td>
                            <td class="text-right {{ isset($listCoinSnapShot->percent_7d_usd ) && !empty($listCoinSnapShot->percent_7d_usd)  && $listCoinSnapShot->percent_7d_usd > 0 ? 'positive_change' : 'negative_change'  }}">
                                {{ $exchange == 'USD' && isset($listCoinSnapShot->percent_7d_usd) && !empty($listCoinSnapShot->percent_7d_usd) ? number_format($listCoinSnapShot->percent_7d_usd, 2). ' %' : (isset($listCoinSnapShot->percent_7d_btc) && !empty($listCoinSnapShot->percent_7d_btc) ? number_format($listCoinSnapShot->percent_7d_btc, 2). ' %' : '?')  }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td col-span="9">
                                No data
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="pull-right">
            <ul class="pagination bottom-paginator">
                <li><a href="{{ route('historical.snapshots') }}">{{ trans('pagination.view_all') }}</a></li>
            </ul>
        </div>
    </div>

@stop