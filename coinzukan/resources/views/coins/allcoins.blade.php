
@extends('layout.FrontMaster')
@section('icon')
    <link rel="icon" type="image/png" href="https://coinmarketcap.com/static/img/CoinMarketCap.png" sizes="16x16"/>
@stop
@section('title')
    CryptoCurrency Market Capitalizations
@stop
@section('content')
    <div class="row">
        <div class="col-xs-12">
            @if(Route::currentRouteName() != 'cryptocurrencies.all')
            <div class="row">
                <div class="col-xs-12 text-left bottom-margin-2x">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            Market Cap:
                            <select class="form-control" id="filter_marketcap" name="filter_marketcap">
                                <option value="0">All</option>
                                <option value="1000000000">$1 Billion+</option>
                                <option value="100000000-1000000000">$100 Million - $1 Billion </option>
                                <option value="10000000-100000000">$10 Million - $100 Million </option>
                                <option value="1000000-10000000">$1 Million - $10 Million </option>
                                <option value="100000-1000000">$100k - $1 Million </option>
                                <option value="0-100000">$0 - $100k</option>
                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            Price:
                            <select class="form-control" id="filter_price" name="filter_price">
                                <option value="0">All</option>
                                <option value="100">$100+</option>
                                <option value="1-100">$1 - $100 </option>
                                <option value="0.01-1.00">$0.01 - $1.00 </option>
                                <option value="0.0001-0.01">$0.0001 - $0.01</option>
                                <option value="0-0.0001">$0 - $0.0001 </option>
                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            Volume (24h):
                            <select class="form-control" id="filter_volume" name="filter_volume">
                                <option value="0">All</option>
                                <option value="100000000">$10 Million+</option>
                                <option value="1000000-10000000">$1 Million+ </option>
                                <option value="100000-1000000">$100k+ </option>
                                <option value="10000-100000">$10k+ </option>
                                <option value="1000-10000">$1k+ </option>
                            </select>
                        </div>
                            <input type="hidden" id="market_id" value="{!! $market_id !!}">
                    </div>
                </div>
            </div>
            @endif
            <div id="currencies_wrapper" class="dataTables_wrapper no-footer">
                <table class="table dataTable no-footer" id="currencies" role="grid">
                    <thead>
                    <tr role="row">
                        <th style="width: 23px;">#
                        </th>
                        <th style="width: 166px;">
                            {!! $columns['coins_name'] !!}
                        </th>
                        @if(Route::currentRouteName() == 'cryptocurrencies.all')
                            <th>
                                {!! $columns['market_name'] !!}
                            </th>
                        @endif
                        <th style="width: 115px; color: #428bca">
                            @lang('home.TABLE_LIST_COINS.market_cap')
                            {{--{!! $columns['market.cap'] !!}--}}
                        </th>
                        <th style="width: 73px;">
                            {{--<a href="{{URL::route('coin-convert2',array($row->market_name, $row->base, $row->target))}}">--}}
                            {!! $columns['price'] !!}
                            {{--</a>--}}
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
                    <tbody class="listCoins" id="listCoins">
                    @include('coins.partial.coinsall')
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@stop
@section('script_footer')
    <script>
        $('#filter_marketcap').on('change', function() {
            var market_id = $('#market_id').val();
            var value_marketcap =  this.value ;
            var value_price = $('select[name=filter_price]').val();
            var value_volume = $('select[name=filter_volume]').val();

            filterMarketCap(market_id, value_marketcap, value_price, value_volume);
        });
        $('#filter_price').on('change', function() {
            var market_id = $('#market_id').val();
            var value_marketcap =  $('select[name=filter_marketcap]').val() ;
            var value_price = this.value;
            var value_volume = $('select[name=filter_volume]').val();

            filterMarketCap(market_id, value_marketcap, value_price, value_volume);
        });
        $('#filter_volume').on('change', function() {
            var market_id = $('#market_id').val();
            var value_marketcap =  $('select[name=filter_marketcap]').val() ;
            var value_price = $('select[name=filter_price]').val();
            var value_volume = this.value;

            filterMarketCap(market_id, value_marketcap, value_price, value_volume);
        });
        function filterMarketCap(market_id, value_marketcap, value_price, value_volume) {
            $.ajax({
                type: "POST",
                url: "{{URL::route('filterCurrencies')}}",
                data: {market_id: market_id, value_marketcap: value_marketcap, value_price: value_price, value_volume: value_volume},
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}'
                },
                success: function(result) {
                    $('#listCoins').html(result);
                }
            });
        };

    </script>

@stop