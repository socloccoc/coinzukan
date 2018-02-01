@extends('layout.FrontMaster')
@section('icon')
    <link rel="icon" type="image/png" href="https://coinmarketcap.com/static/img/CoinMarketCap.png" sizes="16x16"/>
@stop
@section('title')
    Coinzukan
@stop
@section('content')
    <div class="row">
        <div class="col-xs-12 text-center">
            <div class="row">
                <h1>{{ trans('content.HOME_PAGE.recently_added') }}</h1>
            </div>
        </div>
        <div class="col-xs-12">
            {!! Form::open(array('route' => 'new.currency','method'=>'get', 'id' => 'form_exchange_rate')) !!}
                <div class="row">
                    <div class="hidden-xs hidden-sm col-md-12 text-right">
                        <div id="currency-switch" class="btn-group">
                            {!! Form::select('exchange', ['USD'=>'USD', 'BTC' => 'BTC', 'ETH' => 'ETH'] , ' ',['class'=>'btn btn-primary', 'onchange' => 'this.form.submit()'])!!}
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
            <div class="table-responsive">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th id="th-name">
                                {{ trans('content.HOME_PAGE.name') }}
                            </th>
                            <th id="th-symbol">
                                {{ trans('content.HOME_PAGE.symbol') }}
                            </th>
                            <th id="th-added" class="text-right">
                                {{ trans('content.HOME_PAGE.added') }}
                            </th>
                            <th id="th-marketcap" class="text-right">
                                {{ trans('content.HOME_PAGE.market_cap') }}
                            </th>
                            <th id="th-price" class="text-right">
                                {{ trans('content.HOME_PAGE.price') }}
                            </th>
                            <th id="th-totalsupply" class="text-right" title="The number of coins in existence available to the public">
                                {{ trans('content.HOME_PAGE.circulating_supply') }}
                            </th>
                            <th id="th-volume" class="text-right">
                                {{ trans('content.HOME_PAGE.volume_24h') }}
                            </th>
                            <th id="th-change24h" class="text-right">
                                {{ trans('content.HOME_PAGE.24h') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($listNewCoins as $listNewCoin)
                        <tr id="id-{{ isset($listNewCoin->symbol) && !empty($listNewCoin->symbol) ? $listNewCoin->symbol : '' }}">
                            <td class="no-wrap currency-name">
                                <?php $url = isset($listNewCoin->coin_images) && !empty($listNewCoin->coin_images) && (file_exists(base_path() . "/public_html" . $listNewCoin->coin_images) || file_exists(public_path($listNewCoin->coin_images))) ? $listNewCoin->coin_images : 'images/coin_icon/icon_coin_default.png'; ?>
                                <img src="{{ $url  }}" class="currency-logo">
                                <a href="{{ route('detail.coin', $listNewCoin->name) }}">
                                    {{ isset($listNewCoin->name) && !empty($listNewCoin->name) ? $listNewCoin->name : '' }}
                                </a>
                            </td>
                            <td class="text-left">
                                {{ isset($listNewCoin->symbol) && !empty($listNewCoin->symbol) ? $listNewCoin->symbol : '' }}
                            </td>
                            <td class="text-right">
                                {{ isset($listNewCoin->added) && !empty($listNewCoin->added) ? $listNewCoin->added : '' }}
                            </td>
                            <td class="no-wrap market-cap text-right" data-usd="{{ isset($listNewCoin->marketcap) && !empty($listNewCoin->marketcap) ? number_format($listNewCoin->marketcap, 2) : '?' }}" data-btc="?">
                                {{ isset($listNewCoin->marketcap) && !empty($listNewCoin->marketcap) ? number_format($listNewCoin->marketcap, 2) : '?' }}
                            </td>
                            <td class="no-wrap text-right">
                                <a href="#" class="price" data-usd=" {{ isset($listNewCoin->price) && !empty($listNewCoin->price) ? number_format($listNewCoin->price, 6) . $unit : '?' }}" data-btc="3.5265e-06">
                                    {{ isset($listNewCoin->price) && !empty($listNewCoin->price) ? number_format($listNewCoin->price / $rate, 6) . $unit : '?' }}
                                </a>
                            </td>
                            <td class="no-wrap text-right circulating-supply">
                                <a href="#" target="_blank" data-supply-container="" data-supply="{{ isset($listNewCoin->circulating_supply) && !empty($listNewCoin->circulating_supply) ? number_format($listNewCoin->circulating_supply, 6) : '?' }}">
                                    {{ isset($listNewCoin->circulating_supply) && !empty($listNewCoin->circulating_supply) ? number_format($listNewCoin->circulating_supply / $rate) . $unit : '?' }}
                                </a>
                            </td>
                            <td class="no-wrap text-right ">
                                <a href="#" class="volume" data-usd="{{ isset($listNewCoin->volume_24h) && !empty($listNewCoin->volume_24h) ?  number_format($listNewCoin->volume_24h, 0) : '?' }}" data-btc="228.305">
                                    {{ isset($listNewCoin->volume_24h) && !empty($listNewCoin->volume_24h) ? number_format($listNewCoin->volume_24h / $rate, 0) . $unit : '?' }}
                                </a>
                            </td>
                            <td class="text-right {{isset($listNewCoin->percent_change_24h) && !empty($listNewCoin->percent_change_24h) && $listNewCoin->percent_change_24h > 0 ? 'positive_change' : 'negative_change' }} ">
                                {{ isset($listNewCoin->percent_change_24h) && !empty($listNewCoin->percent_change_24h) ?  number_format($listNewCoin->percent_change_24h, 2) . '%' : '?' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">No data</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@stop