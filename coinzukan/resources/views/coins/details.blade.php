@extends('layout.FrontMaster')
@section('icon')
    <link rel="icon" type="image/png" href="{{ asset(''. isset ($inforBaseTarget->icon_url) && !empty($inforBaseTarget->icon_url) && file_exists(public_path($inforBaseTarget->icon_url)) ? $inforBaseTarget->icon_url : 'images/coin_icon/icon_coin_default.png') }}"/>
@stop
@section('title')
    {!! isset($inforBaseTarget->name) ? $inforBaseTarget->name . ' ('.$inforBaseTarget->base. ')' . ' | ' : 'CoinMarket' !!}
@stop
@section('style')
    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.jqueryui.min.css" rel="stylesheet">
@stop
@section('content')
    <div class="row bottom-margin-1x">
        <div class="col-xs-6 col-sm-4 col-md-4">
            <h1 class="text-large">
                <img src="{{ asset(''. isset ($inforBaseTarget->icon_url) && !empty($inforBaseTarget->icon_url) && (file_exists(public_path($inforBaseTarget->icon_url)) || file_exists(base_path()."/public_html".$inforBaseTarget->icon_url)) ? $inforBaseTarget->icon_url : 'images/coin_icon/icon_coin_default.png') }}" style="width: 32px; height: 32px">
                {!! isset($inforBaseTarget->name) ? $inforBaseTarget->name : 'N/A' !!}
                <small class="bold">({!! isset($inforBaseTarget->base) ? $inforBaseTarget->base : 'N/A' !!})</small>
            </h1>
        </div>
        <div class="col-xs-6 col-sm-8 col-md-4 text-left">
            <span class="text-large2" id="quote_price"></span> <span
                    class="text-large2 {!! isset($inforBaseTarget->change_24h) && $inforBaseTarget->change_24h > 0 ? 'positive_change' : 'negative_change'  !!} "></span>
            <br>
            <div class="row">
                <div class="col-xs-12 col-sm-12 hidden-md hidden-lg text-left">
                    <!-- Mobile Button -->
                    <a href="https://changelly.com/exchange/USD/BTC/50?ref_id=coinmarketcap" target="_blank">
                        <div class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-flash"></span> Buy / Sell
                            Instantly
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="hidden-xs hidden-sm col-md-4 text-left">
            <a href="https://changelly.com/exchange/USD/BTC/50?ref_id=coinmarketcap" target="_blank">
                <div class="btn btn-primary"><span class="glyphicon glyphicon-flash"></span> Buy instantly with credit card
                </div>
            </a>
        </div>
    </div>

    <div class="row bottom-margin-2x">
        <div class="col-xs-4 col-sm-4">
            <ul class="list-unstyled">
                <li>
                    <span class="glyphicon glyphicon-link text-gray" title="Website"></span>
                    <a href="#">Website</a>
                </li>
                <li>
                    <span class="glyphicon glyphicon-link text-gray" title="Website"></span>
                    <a href="#" target="_blank">Website 2</a>
                </li>
                <li>
                    <span class="glyphicon glyphicon-search text-gray" title="Explorer"></span>
                    <a href="#">Explorer</a>
                </li>
                <li><span class="glyphicon glyphicon-search text-gray" title="Explorer"></span>
                    <a href="#">Explorer 2</a>
                </li>
                <li>
                    <span class="glyphicon glyphicon-list text-gray" title="Message Board"></span>
                    <a href="#">Message Board</a>
                </li>
                <li>
                    <span class="glyphicon glyphicon-list text-gray" title="Message Board"></span>
                    <a href="#">Message Board 2</a>
                </li>
                <li>
                    <span class="glyphicon glyphicon glyphicon-star text-gray" title="Rank"></span>
                    <span class="label label-success"> Rank {{--{!! isset($coinsInfor[0]->rank) ? $coinsInfor[0]->rank : 'N/A' !!}--}}</span>
                </li>
                <li>
                    <span class="glyphicon glyphicon glyphicon-tag text-gray" title="Tags"></span>
                    <span class="label label-warning">Mineable</span>
                    <span class="label label-warning">Currency</span>
                </li>
            </ul>
        </div>
        <div class="col-xs-8 col-sm-8">
            <div class="row">
                <div class="col-xs-12">
                    <div class="coin-summary-item col-xs-6  col-md-6">
                        <div class="coin-summary-item-header">
                            <h3>@lang('detailcoin.INFOR_DETAILS.high')</h3>
                        </div>
                        <div class="coin-summary-item-detail">
                            {!! isset($inforBaseTarget->high) ? number_format($inforBaseTarget->high, 8). ' $ ' : 0 !!}<br>
                        </div>
                    </div>
                    <div class="coin-summary-item col-xs-6  col-md-6">
                        <div class="coin-summary-item-header">
                            <h3>@lang('detailcoin.INFOR_DETAILS.volume')</h3>
                        </div>
                        <div class="coin-summary-item-detail">
                            {!! isset($inforBaseTarget->volume) ? number_format($inforBaseTarget->volume, 0). ' $ ' : 0 !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="coin-summary-item col-xs-6  col-md-6">
                        <div class="coin-summary-item-header">
                            <h3>@lang('detailcoin.INFOR_DETAILS.low')</h3>
                        </div>
                        <div class="coin-summary-item-detail">
                            {!! isset($inforBaseTarget->low) ? number_format($inforBaseTarget->low, 8). ' $ ' : 0 !!}
                        </div>
                    </div>
                    <div class="coin-summary-item col-xs-6  col-md-6">
                        <div class="coin-summary-item-header">
                            <h3>@lang('detailcoin.INFOR_DETAILS.change')</h3>
                        </div>
                        <div class="coin-summary-item-detail {!! isset($inforBaseTarget->change_24h) && $inforBaseTarget->change_24h > 0 ? 'positive_change' : 'negative_change'  !!}">
                            {!! isset($inforBaseTarget->change_24h) ? number_format($inforBaseTarget->change_24h, 2). '%' : 0 !!}
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
    <a name="markets"></a>
    <div class="row bottom-margin-1x">
        <ul class="nav nav-tabs">
            <li class="tab-chart active">
                <a data-toggle="tab" href="#charts1">
                    <span class="glyphicon glyphicon-stats text-gray"></span>
                    Charts
                </a>
            </li>
            <li class="tab-markets">
                <a data-toggle="tab" href="#markets">
                    <span class="glyphicon glyphicon-transfer text-gray"></span>
                    Markets
                </a>
            </li>
            <li class="active_history">
                <a data-toggle="tab" href="#historical">
                    <span class="glyphicon glyphicon-calendar text-gray"></span>
                    Historical Data
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <!-- Tab Charts -->
            <div id="charts1" class="tab-pane active">
                <div class="row chart-header">
                    <div class="form-group col-sm-2 col-sm-offset-1">
                        <select class="form-control" id="makets">
                        </select>
                    </div>
                    <div class="col-sm-5 col-sm-offset-4 form-group">
                        @foreach(config('constants.time') as $key=>$item)
                            <input type="button" value="{{ $item }}" keyChart="{{$key}}" class="btn-time-chart @if($key == 0){{ 'time-active' }} @endif">
                        @endforeach
                    </div>
                </div>
                <div id="chartdiv" style="height: 500px"></div>
            </div>
            <!-- Tab Markets -->
            <div id="markets" class="tab-pane fade">

                @include('coins.partial.market')
            </div>

            <!-- Tab History -->
            <div id="historical" class="tab-pane fade">
                <h2 class="pull-left bottom-margin-2x">Historical data for  {!! isset($inforBaseTarget->name) ? $inforBaseTarget->name : ' '  !!}</h2>
                <div class="clear"></div>
                <div class="table-responsive">
                    <table id="listDataHistory" class="display" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>@lang('detailcoin.TAB_HISTORY.date')</th>
                            <th>@lang('detailcoin.TAB_HISTORY.rate')</th>
                            <th>@lang('detailcoin.TAB_HISTORY.amount')</th>
                            <th>@lang('detailcoin.TAB_HISTORY.total')</th>
                        </tr>
                        </thead>
                        <tbody id="data_history">
                        @forelse($listHistory as $row)
                            <tr>
                              <?php
                              $date = date("F d, Y", strtotime($row->date));
                              $arrayDate = explode(" ",$date);
                              $newDate = substr($arrayDate[0],0,3)." ".$arrayDate[1]." ".$arrayDate[2];
                              ?>
                                <td>{!! date('m/d/Y', $row->date) !!}</td>
                                <td>{!! isset($row->rate) ? (number_format($row->rate, 8)) : 'N/A' !!}</td>
                                <td>{!! isset($row->amount) ? number_format($row->amount, 8) : 'N/A' !!}</td>
                                <td>{!! isset($row->rate) ? number_format($row->rate * $row->amount, 8) : 0 !!}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">No Data</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="hidden">
                <input type="hidden" name="base" value="{!! $inforBaseTarget->base !!}" id="base_name">
                <input type="hidden" name="base" value="{!! $inforBaseTarget->target !!}" id="target_name">
            </div>
        </div>

    </div>
@stop
@section('script_footer')
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.jqueryui.min.js"></script>
    <script type="text/javascript" src="{{asset('js/coin/coinsCustom.js')}}"></script>
    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="js/serial.js"></script>
    <script src="js/export.min.js"></script>
    <script src="js/light.js"></script>
    <script type="text/javascript" src="{{asset('js/home.js')}}"></script>
    <script type="text/javascript">
        $(function() {
            $(document).ready(function () {
                var segments = location.href.split( '/' );
                if(segments[6] == 'markets'){
                    $('.tab-markets').addClass('active');
                    $('#markets').addClass('active').removeClass('fade');
                    $('.tab-chart').removeClass('active');
                    $('#charts1').removeClass('active');
                    $('.active_history').removeClass('active');
                    $('#historical').removeClass('active');
                    $("html, body").animate({ scrollTop: "400px" }).promise();
                }
            });
        });
    </script>



@stop