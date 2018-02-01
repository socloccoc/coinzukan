
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
              <input type="hidden" id="market_id">
            </div>
          </div>
        </div>
      @endif
      <div id="currencies_wrapper" class="dataTables_wrapper no-footer">
        {{ $coins->links() }} <button class="btn btn-default"><a href="/all">ALL</a></button>
        <table class="table dataTable no-footer" id="currencies" role="grid">
          <thead>
          <tr role="row">
            <th style="width: 23px;">#
            </th>
            <th style="width: 166px;">
              Name
            </th>
              <th>
                Market Cap
              </th>
            <th style="width: 115px">
              Price
            </th>
            <th style="width: 73px;">
              Volume (24h)
            </th>
            <th style="width: 170px">
              Circulating Supply
            </th>
            <th style="width: 110px;">
              Change (24h)
            </th>
            <th style="width: 115px;">
              Price Graph (7d)
            </th>

          </tr>
          </thead>
          <tbody class="listCoins" id="listCoins">
          @foreach($coins as $index=>$tk)
          <tr>
            <td style="width: 23px;">{{ $index+1  }}</td>
            <td style="width: 166px;">{{ $tk['name'] }}</td>
            <td>{{ $tk['market_cap_usd'] }}</td>
            <td style="width: 115px">{{ $tk['price_usd'] }}</td>
            <td style="width: 73px;">{{ $tk['24h_volume_usd'] }}</td>
            <td style="width: 170px">{{ $tk['total_supply'] }}</td>
            <td style="width: 110px;">{{ $tk['percent_change_24h'] }}</td>
            <td></td>
          </tr>
          @endforeach
          </tbody>
        </table>
        {{ $coins->links() }}
      </div>

    </div>
  </div>
@stop
@section('script_footer')
  <script>

  </script>

@stop