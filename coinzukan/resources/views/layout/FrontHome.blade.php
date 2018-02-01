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
                {!! Form::open(array('route' => 'market','method'=>'get', 'id' => 'form_market_target')) !!}
                <div class="col-xs-6 hidden-sm col-md-4">
                    <ul id="category-tabs" class="nav nav-tabs text-left" role="tablist">
                        <li>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                Currencies <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Top 100</a></li>
                                <li><a href="#">Full List</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Market Cap by Circulating Supply</a></li>
                                <li><a href="#">Market Cap by Total Supply</a></li>
                                <li><a href="#">Filter Non-Mineable</a></li>
                                <li><a href="#">Filter Premined</a></li>
                                <li><a href="#">Filter Non-Mineable and Premined</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                Assets <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Top 100</a></li>
                                <li><a href="#">Full List</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Market Cap by Circulating Supply</a></li>
                                <li><a href="#">Market Cap by Total Supply</a></li>
                            </ul>
                        </li>
                        <li>
                            @if(count($listMarkets) > 0)
                                <select name="market" onchange="this.form.submit()" class="market-select">
                                    @foreach ($listMarkets as $key => $value)
                                        <option value="{{ $key }}" {{ isset($marketName) && $marketName == $key ? 'selected' : ''}} >
                                            {{ ucwords(Helper::renderNameMarketById($value)) }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                        </li>
                    </ul>
                </div>
                <div class="col-xs-6 col-md-4 text-left">
                    <div class="styled-select">
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <select name="target" onchange="this.form.submit()" class="btn btn-primary">
                                    @foreach ($currencies as $key1 => $value1)
                                        <option value="{{ $key1 }}" {{ isset($target) && $target == $key1 ? 'selected' : ''}} >
                                            {{ strtoupper(Helper::renderNameTargetById($value1)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
                <div class="col-xs-12 col-md-4 text-right">
                    <div class="clear"></div>
                    <div class="pull-right" id="paginator">
                        @include('partial.paginate_header')
                    </div>
                </div>
            </div>
            <div id="currencies_wrapper" class="dataTables_wrapper no-footer">
                <table class="table dataTable no-footer" id="currencies">
                    <thead>
                    <tr role="row">
                        <th style="width: 23px;">#
                        </th>
                        <th style="width: 166px;">
                            {!! $columns['coins_name'] !!}
                        </th>
                        <th style="width: 115px; color: #428bca">
                            @lang('home.TABLE_LIST_COINS.market_cap')
                        </th>
                        <th style="width: 73px;">
                            {!! $columns['price'] !!}
                        </th>
                        <th style="width: 170px; color: #428bca">
                            {!! $columns['supply'] !!}
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
                        @if (count($data) > 0)
                            @include('coins.listcoins')
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="pull-right" id="paginator">
                @include('partial.paginate_bottom')
            </div>
        </div>
    </div>
@stop
@section('script_footer')
    <script>
        $(document).ready(function () {
            var market_name = $('select[name="market"]').val();
            var href = "/cryptocurrencies/" + market_name + "/all";
            $("li.disabled").remove();
            var btn_view_all = '<li><a href=' + href + '><span class="tab">View All</span></a></li>';
            $("#paginator ul").append(btn_view_all);
            $(".pagination ").addClass('top-paginator');

        });
    </script>
@stop