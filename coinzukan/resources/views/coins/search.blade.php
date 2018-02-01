@extends('layout.FrontMaster')
@section('icon')
    <link rel="icon" type="image/png" href="https://coinmarketcap.com/static/img/CoinMarketCap.png" sizes="16x16"/>
@stop
@section('title')
   Search Coinzukan
@stop
@section('content')
    <div class="row">
        <div class="col-xs-12">

            <div class="pull-right" id="paginator">
                @include('partial.paginate_header')
            </div>

            <div id="currencies_wrapper" class="dataTables_wrapper no-footer">
                <table class="table dataTable no-footer" id="currencies">
                    <thead>
                    <tr role="row">
                        <th style="width: 23px;">#
                        </th>
                        <th style="width: 166px;">
                            {!! $columns['name'] !!}
                        </th>
                        <th style="width: 166px;">
                            {!! $columns['market_name'] !!}
                        </th>
                        <th style="width: 115px; color: #428bca">
                            @lang('home.TABLE_LIST_COINS.market_cap')
                            {{--{!! $columns['market.cap'] !!}--}}
                        </th>
                        <th style="width: 73px;">
                            {!! $columns['price'] !!}
                        </th>
                        <th style="width: 170px; color: #428bca">
                            @lang('home.TABLE_LIST_COINS.cir_supply')
                            {{--{!! $columns['supply'] !!}--}}
                        </th>
                        <th style="width: 110px;">
                            {!! $columns['volume'] !!}
                        </th>
                        <th style="width: 115px;">
                            {!! $columns['change_24h'] !!}
                        </th>
                        <th style="width: 162px; color: #428bca">
                            @lang('home.TABLE_LIST_COINS.price_graph')
                        </th>
                    </tr>
                    </thead>
                    <tbody class="listCoins">
                    <?php $i = 0; ?>
                    @forelse($listCoinConverts as $listCoinConvert)
                        <?php $i++ ?>
                        <tr>

                            <td class="text-center sorting_1">
                                {!! $i !!}
                            </td>

                            <td class="no-wrap currency-name">
                                <?php
                                    $url = isset($listCoinConvert->coins_images) && !empty($listCoinConvert->coins_images) &&
                                    (file_exists(base_path()."/public_html".$listCoinConvert->coins_images) ||
                                    file_exists(public_path($listCoinConvert->coins_images))) ?
                                    $listCoinConvert->coins_images : 'images/coin_icon/icon_coin_default.png';
                                ?>
                                <img src="{{ $url }}" class="currency-logo">
                                <a href="{{URL::route('coin-convert',array($listCoinConvert->market_name, $listCoinConvert->base, $listCoinConvert->target))}}" title="{!! isset($listCoinConvert->coins_name) ? $listCoinConvert->coins_name : 'N/A' !!}">
                                    {!! isset($listCoinConvert->coins_name) ? $listCoinConvert->coins_name : '' !!}
                                </a>
                            </td>
                            <td>
                                <b>
                                    {!! isset($listCoinConvert->market_name) && !empty($listCoinConvert->market_name) ? ucfirst($listCoinConvert->market_name) : '' !!}
                                </b>
                            </td>
                            <td class="no-wrap market-cap text-right">
                                {!! isset($listCoinConvert->price) && !empty($listCoinConvert->price) && isset($listCoinConvert->circulating_supply) && !empty($listCoinConvert->circulating_supply) ? number_format($listCoinConvert->price*$listCoinConvert->circulating_supply). ' '.$listCoinConvert->target : 0 !!}
                            </td>

                            <td class="no-wrap text-right">
                                <?php
                                $price = isset($listCoinConvert->price) && $listCoinConvert->price < 0.00001 ? $price = number_format($listCoinConvert->price, 8) : $price = number_format($listCoinConvert->price, 8);
                                ?>
                                <a href="" class="price">{{ isset($price) && !empty($price) ? $price. ' '.strtoupper($listCoinConvert->target) : 0 }}</a>
                            </td>

                            <td class="no-wrap text-right">
                                <a href="#">
                                    {!!  isset($listCoinConvert->circulating_supply) ? number_format($listCoinConvert->circulating_supply, 0). ' '.$listCoinConvert->base : 0 !!}
                                </a>
                            </td>

                            <td class="no-wrap text-right">
                                <a href="#" class="volume">
                                    {!! isset($listCoinConvert->volume) && !empty ($listCoinConvert->volume) ? number_format($listCoinConvert->volume, 4). ' '. strtoupper($listCoinConvert->target) : ''  !!}
                                </a>
                            </td>

                            <td class="no-wrap percent-24h  {{isset($listCoinConvert->change_24h) && !empty($listCoinConvert->change_24h) && $listCoinConvert->change_24h > 0 ? 'positive_change' : 'negative_change' }} text-right" data-usd="-10.39" data-btc="0.00">
                                {!! isset($listCoinConvert->change_24h) && !empty($listCoinConvert->change_24h) ? number_format($listCoinConvert->change_24h, 2) . '%' : 0 !!}
                            </td>
                            <td>
                                <a href="#">
                                    <img class="sparkline" src="{!! asset('images/charts.png') !!}">
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <p class="alert alert-warning">No currency matched that search criteria.  Please try again.</p>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pull-right" id="paginator">
                @include('partial.paginate_bottom')
            </div>
        </div>
    </div>
@stop