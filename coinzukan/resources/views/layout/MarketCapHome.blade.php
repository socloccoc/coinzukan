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
        @if( Route::currentRouteName() == 'all.coins.marketcap')
          {!! Form::open(array('route' => 'all.coins.marketcap','method'=>'get', 'id' => 'form_exchange_rate')) !!}
        @endif
        {!! Form::open(array('route' => 'homeMarketCap','method'=>'get', 'id' => 'form_exchange_rate')) !!}
        @include('partial.navigationBody')
        <div class="col-xs-6 col-md-4 text-left">
          <div id="currency-switch" class="btn-group">
            <button id="currency-switch-button" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="current-exchange money-switch">USD</span> <span class="caret"></span></button>
            <ul class="dropdown-menu text-center" role="menu">
              <li class="pointer"><a class="price-toggle exchange-switch" data-currency="usd" rate="1">USD</a></li>
              <li class="divider"></li>
              @foreach($rateBtcAndEth as $index=>$item)
                <li class="pointer"><a class="price-toggle exchange-switch" data-currency="btc" rate="{{ isset($item['price_usd']) ? $item['price_usd'] : 1 }}">{{ isset($item['symbol']) ? $item['symbol'] : '' }}</a></li>
                @if($index == 0)
                  <li class="divider"></li>
                @endif
              @endforeach
            </ul>
          </div>
        </div>
        {!! Form::close() !!}
        <div class="col-xs-12 col-md-4 text-right">

          @if( Route::currentRouteName() != 'all.coins.marketcap')
            <div class="pull-right" id="paginator">
              @include('partial.paginate_header')
            </div>
          @else
            <ul class="pagination top-paginator text-right" style="margin-right: -120px">
              <li><a href="/">{{ trans('pagination.back_to_top_100') }}</a></li>
            </ul>
          @endif

        </div>
      </div>
      <div id="currencies_wrapper" class="dataTables_wrapper no-footer">
        <table class="table dataTable no-footer" id="dataTable">
          <thead>
          <tr role="row">
            <th style="width: 23px;">#
            </th>
            <th style="width: 166px;">
              {{ trans('content.HOME_PAGE.name') }}
            </th>
            @if(Route::currentRouteName() == 'all.coins.marketcap')
              <th style="width: 70px;" class="text-left">
                {{ trans('content.HOME_PAGE.symbol') }}
              </th>
              <th style="width: 73px;" class="text-right">
                {{ trans('content.HOME_PAGE.market_cap') }}
              </th>
              <th style="width: 170px;" class="text-right">
                {{ trans('content.HOME_PAGE.price') }}
              </th>
              <th style="width: 115px;" class="text-right">
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
              <th style="width: 170px;" class="text-right">
                {{ trans('content.HOME_PAGE.circulating_supply') }}
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
          @if ( isset($listCoinFromCoinMarket) && count($listCoinFromCoinMarket) > 0)
            @if( Route::currentRouteName() == 'all.coins.marketcap')
              @include('coins.allcoinsmarket')
            @else
              @include('coins.listcoinsmarket')
            @endif
          @endif
          </tbody>
        </table>
      </div>
      @if( Route::currentRouteName() != 'all.coins.marketcap')
        <div class="pull-right" id="paginator">
          @include('partial.paginate_bottom')
        </div>
      @else
        <ul class="pagination top-paginator pull-right" style="margin-right: -120px">
          <li><a href="/">{{ trans('pagination.back_to_top_100') }}</a></li>
        </ul>
      @endif
    </div>
  </div>
  <input hidden name="view_all" value="{{ trans('pagination.view_all') }}">
@stop
@section('script_footer')
  <script>
    $(document).ready(function () {
      var market_name = $('select[name="market"]').val();
      var href = "/home/all";
      $("li.disabled").remove();
      var btn_view_all = '<li><a href=' + href + '><span class="tab">' + $('input[name="view_all"]').val() + '</span></a></li>';
      $("#paginator ul").append(btn_view_all);
      $(".pagination ").addClass('top-paginator');

    });
  </script>
@stop