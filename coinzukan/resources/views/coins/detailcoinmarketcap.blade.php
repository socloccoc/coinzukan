
@extends('layout.FrontMaster')
@section('icon')
    <link rel="icon" type="image/png" href="{{ asset(''. isset ($inforBaseTarget->icon_url) && file_exists(public_path($inforBaseTarget->icon_url)) ? $inforBaseTarget->icon_url : 'images/coin_icon/icon_coin_default.png') }}"/>
@stop
@section('title')
    {{ isset($infoCoin->coin_name) ? $infoCoin->coin_name. ' ( ' . $infoCoin->symbol .' ) $' . $infoCoin->price_usd : '' }}
@stop
@section('content')
    <style>
        .dataTables_paginate  { display: none; }
        .sorting, .sorting_asc, .sorting_desc {
            background : none;
        }
    </style>

    <div class="row bottom-margin-1x">
        <div class="col-xs-6 col-sm-4 col-md-4">
            <h1 class="text-large">
                <img style="max-width: 32px" src="{{ isset($infoCoin->coins_images) ? $infoCoin->coins_images : 'images/coin_icon/icon_coin_default.png' }}" class="currency-logo-32x32" alt="{{ isset($infoCoin->coin_name) && !empty($infoCoin->coin_name) ? $infoCoin->coin_name : '' }}">
                <small class="bold hidden-sm hidden-md hidden-lg">({{ isset($infoCoin->symbol) ? $infoCoin->symbol : '' }})</small>
                {{ isset($infoCoin->coin_name) ? $infoCoin->coin_name : '' }}
                <small class="bold hidden-xs">
                    ({{ isset($infoCoin->symbol) ? $infoCoin->symbol : '' }})
                </small>
            </h1>
        </div>
        <div class="col-xs-6 col-sm-8 col-md-4 text-left">
            <span class="text-large" id="quote_price">
                {{ isset($infoCoin->price_usd) ? '$ '. $infoCoin->price_usd : '' }}
            </span>
            <span class="text-large  {{ isset($infoCoin->percent_24h) && $infoCoin->percent_24h > 0 ? 'positive_change ' : 'negative_change' }}">
                ({{ isset($infoCoin->percent_24h) ? $infoCoin->percent_24h . '%' : '' }})
            </span>
            <br>
            <small class="text-gray">
                {{ isset($infoCoin->price_btc) ? number_format($infoCoin->price_btc, 8). ' BTC' : '' }}
            </small>
            <div class="row">
                <div class="col-xs-12 col-sm-12 hidden-md hidden-lg text-left">
                    <!-- Mobile Button -->
                    <a href="https://changelly.com/exchange/USD/BTC/50?ref_id=coinmarketcap" target="_blank" rel="nofollow">
                        <div class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-flash"></span> Buy / Sell Instantly</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <input hidden name="locale_name" value="{{ Config::get('app.locale') }}">
    <input hidden name="market_cap" value="{{ trans('content.HOME_PAGE.market_cap') }}">
    <input hidden name="24h_volume" value="{{ trans('content.HOME_PAGE.24h_vol') }}">
    <input hidden name="price" value="{{ trans('content.HOME_PAGE.price') }}">

    <div class="row bottom-margin-2x">
        <div class="col-sm-8 col-sm-push-4">
            <div class="coin-summary-item col-xs-6  col-md-3">
                <div class="coin-summary-item-header">
                    <h3 class="details-text-medium">{{ trans('content.HOME_PAGE.market_cap') }}</h3>
                </div>
                <div class="coin-summary-item-detail">
                    {{ isset($infoCoin->market_cap_usd) ? '$ '. number_format($infoCoin->market_cap_usd) : '' }}
                    <br>
                    <span class="text-gray">
                        {{ isset($infoCoin->available_supply) ? number_format($infoCoin->available_supply*$infoCoin->price_btc). ' BTC' : '' }}
                    </span>
                    <br>
                </div>
            </div>
            <div class="coin-summary-item col-xs-6  col-md-3">
                <div class="coin-summary-item-header">
                    <h3 class="details-text-medium">{{ trans('content.HOME_PAGE.volume_24h') }}</h3>
                </div>
                <div class="coin-summary-item-detail">
                    {{ isset($infoCoin->volume_24h) ? '$ '. number_format($infoCoin->volume_24h) : '' }}
                    <br>
                    <span class="text-gray">
                        {{ isset($infoCoin->volume_24h) ? number_format($infoCoin->volume_24h / Helper::getPriceUsdBySymbol('BTC')) . ' BTC ' : '' }}
                    </span>
                </div>
            </div>
            <div class="vertical-spacer col-xs-12 hidden-md hidden-lg"></div>
            <div class="coin-summary-item col-xs-6  col-md-3">
                <div class="coin-summary-item-header">
                    <h3 class="details-text-medium">{{ trans('content.HOME_PAGE.circulating_supply') }}</h3>
                </div>
                <div class="coin-summary-item-detail">
                    {{ isset($infoCoin->available_supply) ? number_format($infoCoin->available_supply) . ' '. $infoCoin->symbol : '' }}
                </div>
            </div>
            <div class="coin-summary-item col-xs-6  col-md-3 ">
                <div class="coin-summary-item-header">
                    <h3 class="details-text-medium">{{ trans('content.HOME_PAGE.max_supply') }}</h3>
                </div>
                <div class="coin-summary-item-detail">
                    {{ isset($infoCoin->max_supply) ? number_format($infoCoin->max_supply).' '.(isset($infoCoin->symbol) ? $infoCoin->symbol : '') : '?' }}
                </div>
            </div>
            <div class="clearfix visible-xs"></div>
        </div>
        <div class="col-sm-4 col-sm-pull-8">
            <ul class="list-unstyled">
                @for($i = 1; $i <= 15 ; $i++)

                    @if($listUnstyled['glyphicon'.$i] == 'glyphicon glyphicon glyphicon-star text-gray')
                        <li>
                            <span class="{{ $listUnstyled['glyphicon'.$i] }}" title="{{ $listUnstyled['title'.$i] }}"></span>
                            <small>
                                <span class="label label-success">
                                   {{ trans('content.HOME_PAGE.rank').$infoCoin->rank }}
                                </span>
                            </small>
                        </li>
                    @elseif($listUnstyled['glyphicon'.$i] == 'glyphicon glyphicon glyphicon-tag text-gray')
                        <li>
                            <span class="{{ $listUnstyled['glyphicon'.$i] }}" title="{{ $listUnstyled['title'.$i] }}"></span>
                            <small><span class="label label-warning">{{ $listUnstyled['label1'] }}</span></small>
                            <small><span class="label label-warning">{{ $listUnstyled['label2'] }}</span></small>
                        </li>
                    @else
                        <li><span class="{{ $listUnstyled['glyphicon'.$i] }}" title="{{ $listUnstyled['title'.$i] }}"></span> <a href="{{ $listUnstyled['link'.$i] }}" target="_blank">{{ $listUnstyled['title'.$i] }}</a></li>
                    @endif

                @endfor

            </ul>

        </div>
    </div>

    <div class="row bottom-margin-1x">
        <div class="col-xs-12">
            <ul class="nav nav-tabs text-left" role="tablist">
                <li class="active">
                    <a href="#charts_cap" role="tab" data-toggle="tab" class="active">
                        <span class="glyphicon glyphicon-stats text-gray"></span>
                        {{ trans('content.HOME_PAGE.charts') }}
                    </a>
                </li>
                <li class="">
                    <a href="#markets_cap" role="tab" data-toggle="tab">
                        <span class="glyphicon glyphicon-transfer text-gray"></span>
                        {{ trans('content.HOME_PAGE.markets') }}
                    </a>
                </li>
                @if(isset($pairId) && !empty($pairId))
                <li class="">
                    <a href="#list_data_history" role="tab" data-toggle="tab">
                        <span class="glyphicon glyphicon-globe text-gray"></span>
                        {{ trans('content.HOME_PAGE.historical_data') }}
                    </a>
                </li>
                @endif
            </ul>
        </div>
        <div class="col-xs-12 tab-content">
            <div id="charts_cap" class="tab-pane active">
                <div class="tab-header">
                    <h1 style="padding: 15px">{{ isset($infoCoin->coin_name) && !empty($infoCoin->coin_name) ? $infoCoin->coin_name.' '.trans('content.HOME_PAGE.charts') : '' }}</h1>
                    <div id="divchart" style="height: 450px; min-width: 410px"></div>
                </div>
            </div>
            <div id="markets_cap" class="tab-pane">
                <div class="tab-header">
                    <h2 class="pull-left">
                        {{ isset($infoCoin->coin_name) && !empty($infoCoin->coin_name) ? $infoCoin->coin_name .' '. trans('content.HOME_PAGE.market') : '' }}
                    </h2>
                    <div class="table-responsive" style="width: 100%;">
                        <table id="listDataMarkets" class="display" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('content.HOME_PAGE.source') }}</th>
                                <th>{{ trans('content.HOME_PAGE.pair') }}</th>
                                <th>{{ trans('content.HOME_PAGE.volume_24h') }}</th>
                                <th>{{ trans('content.HOME_PAGE.price') }}</th>
                                <th>{{ trans('content.HOME_PAGE.volume_percent') }}</th>
                                <th>{{ trans('content.HOME_PAGE.update') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0 ?>
                            @foreach($listMarkets as $listMarket)
                                <?php $i++ ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ isset($listMarket->name_market) && !empty($listMarket->name_market) ? ucfirst($listMarket->name_market) : '' }}</td>
                                    <td>{{ isset($listMarket->base) && !empty($listMarket->base) ? strtoupper($listMarket->base . '/'.$listMarket->target)  : '' }}</td>
                                    <td>{{ isset($listMarket->volume) && !empty($listMarket->volume) ? number_format($listMarket->volume, 1) : '' }}</td>
                                    <td>{{ isset($listMarket->price) && !empty($listMarket->price) ? number_format($listMarket->price, 8) : '' }}</td>
                                    <td>{{ isset($listMarket->percent_24h) && !empty($listMarket->percent_24h) ? number_format($listMarket->percent_24h, 2) . '%' : '' }}</td>
                                    <td>Recently</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            @if(isset($pairId) && !empty($pairId))
            <div id="list_data_history" class="tab-pane">
                <div id="charts" class="tab-pane active">
                    <div class="tab-header">
                        <h2 class="pull-left bottom-margin-2x">
                            {{ isset($infoCoin->coin_name) && !empty($infoCoin->coin_name) ? ( Config::get('app.locale') == 'en' ? trans('content.HOME_PAGE.historical_data_for'). $infoCoin->coin_name : $infoCoin->coin_name.trans('content.HOME_PAGE.historical_data_for'))  : '' }}
                        </h2>
                        <div class="clear"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-left">
                                    <small>{{ trans('content.HOME_PAGE.currency_in_usd') }}</small>
                                    <br>
                                    <small>Open/Close in UTC time</small>
                                </div>
                                <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                    <span></span> <b class="caret"></b>
                                </div>
                                <input type="hidden" name="pair_id_coin" value="{{ isset($pairId) && !empty($pairId) ? $pairId : '' }}">
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>{{ trans('content.HOME_PAGE.date') }}</th>
                                        <th>{{ trans('content.HOME_PAGE.open') }}</th>
                                        <th>{{ trans('content.HOME_PAGE.high') }}</th>
                                        <th>{{ trans('content.HOME_PAGE.low') }}</th>
                                        <th>{{ trans('content.HOME_PAGE.close') }}</th>
                                        <th>{{ trans('content.HOME_PAGE.volume') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="dataHistoryCoin">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

@stop
@section('script_footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.jqueryui.min.js"></script>
    <script src="js/chartOfMarketCapDetailPage.js"></script>
    <script>
        $( document ).ready(function() {
            var url = window.location.href;
            var result = url.split('#');
            if(jQuery.type(result[1]) !== "undefined" && result[1] == 'markets_cap'){
               $('.nav-tabs li:nth-child(1), #charts_cap').removeClass('active');
               $('.nav-tabs li:nth-child(2), #markets_cap').addClass('active');
            }

            $('#listDataMarkets').DataTable({
                "bLengthChange": false,
                "bInfo": false,
                "bPaginate": true,
                responsive: true,
                "pageLength": 100,
                "pagingType": "simple",
                searching: false,
            });
        });
    </script>

    <script type="text/javascript">
        $(function() {

            var start = moment().subtract(29, 'days');
            var end = moment();
            function cb(start, end) {
                $('#reportrange span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
                var timeStart = start.format('YYYY-MM-D');
                var timeEnd = end.format('YYYY-MM-D');
                $.post('/history/data', {
                    _token: "{{ csrf_token() }}",
                    start: timeStart,
                    end: timeEnd,
                    pairId: $("input[name=pair_id_coin]").val(),
                }, function (result) {
                    $('#dataHistoryCoin').html(result)
                });
            }
            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);
        });

    </script>

@stop
