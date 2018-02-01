<!Doctype html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>
  <base href="{{ asset('') }}">
  <link rel="shortcut icon" type="image/png" href="/images/favicon.png"/>
{{--@yield('icon')--}}
<!-- Fonts -->
  <script src="js/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="css/jquery-ui.css" rel="stylesheet">
  <link href="css/base.min.css" rel="stylesheet">
  @yield('style')
  <link href="css/home.css" rel="stylesheet">
  <!--Dynamic StyleSheets added from a view would be pasted here-->
  <!-- Styles -->
  <style>

    svg {
      width: 100%;
      height: 100%;
    }

    #chartdiv {
      width: 100%;
      height: 500px;
    }

    .chart-header .form-group {
      margin-top: 15px;
      margin-bottom: 0px;
      padding: 0px;
    }

    .time-active {
      background: #ccc;
    }

    #chartdiv > div > div > a {
      display: none !important;
    }

    #total_market_cap {
      display: none !important;
    }

    .ui-widget.ui-widget-content {
      display: block;
      top: 148.4px;
      left: 865.15px;
      width: 310px;
      border: 1px solid #c5c5c5;
      background: #ffffff;
      color: #333333;
      border: 0;
    }

    .ui-menu .ui-menu-item-wrapper {
      padding: 0px;
    }

    .ui-widget-content a {
      color: #333333;
    }

    li.ui-menu-item a {
      display: block;
      text-decoration: none;
    }

    .pagination {
      margin: 0;
    }
  </style>
  <link rel="stylesheet" href="css/export.css" type="text/css" media="all"/>
  <!-- Resources -->
</head>
<body>
<div class="outer-container global-stats desktop hidden-xs">
  <div class="container global-stats desktop">
    <div class="row">
      <div class="col-sm-3">
        <ul class="list-inline stat-counters" data-global-stats-container="">
          <li>{{ trans('content.HOME_PAGE.cryptocurrencies') }}: <strong><a
                  href="{{ route('all.coins.marketcap') }}">{!! isset($marketCap['active_currencies']) ? ($marketCap['active_currencies'] + $marketCap['active_assets']) : '' !!}</a></strong>
          </li>
          <li>/ {{ trans('content.HOME_PAGE.markets') }}: <strong><a
                  href="{{ route('currencies.volume.marketcap') }}">{!! isset($marketCap['active_markets']) ? $marketCap['active_markets'] : '' !!}</a></strong>
          </li>
        </ul>
      </div>
      <div class="col-sm-6 text-center">
        <ul class="list-inline stat-counters" data-global-stats-container="">
          <li>{{ trans('content.HOME_PAGE.market_cap') }}: <strong><a
                  href="{{ route('charts') }}">${{ isset($marketCap['total_market_cap']) ? number_format($marketCap['total_market_cap']) : 0 }}</a></strong>
          </li>
          <li> / {{ trans('content.HOME_PAGE.24h_vol') }}: <strong><a
                  href="{{ route('charts') }}">${{ isset($marketCap['total_24h_volume']) ? number_format($marketCap['total_24h_volume']) : 0 }}</a></strong>
            / {{ trans('content.HOME_PAGE.btc_dominance') }}: <strong><a
                  href="/charts/#dominance-percentage">{{ isset($marketCap['percentage_btc']) ? $marketCap['percentage_btc'] : 0 }}
                % </a></strong></li>
        </ul>
      </div>
      <div class="col-sm-3 text-right">
        <div class="btn-group">
          <button type="button" class="btn btn-xs dropdown-toggle language-dropdown" data-toggle="dropdown">
            <span
                data-language-dropdown="">@if(Config::get('app.locale') == 'en') {{ 'English' }} @else {{ '简体中文' }} @endif</span>
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu text-center" role="menu">
            <li class="pointer"><a href="{!! route('user.change-language', ['en']) !!}" data-language-toggle="en">English</a>
            </li>
            <li class="pointer"><a href="{!! route('user.change-language', ['jp']) !!}"
                                   data-language-toggle="zh">简体中文</a></li>
          </ul>
        </div>
        <div data-global-currency-switch="" class="btn-group global-currency-dropdown-container">
          <button type="button" class="btn btn-xs dropdown-toggle global-currency-dropdown" data-toggle="dropdown">
            <span data-currency-display="" class="current-money">USD</span> <span class="caret"></span>
          </button>
          <ul class="dropdown-menu global-currency-dropdown-menu text-center" role="menu">
            <li rate="1" symbol="$" class="pointer monney-switch"><a data-currency-toggle="">USD</a></li>

            @foreach($listMoney as $item)
              <li rate="{{ $item['exchange_rate'] }}" symbol="{{ $item['symbol'] }}" class="pointer monney-switch"><a
                    data-currency-toggle="">{{ $item['name'] }}</a></li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
      <h1 id="title" class="page-header text-overflow"><a href="/">Coins Zukan</a></h1>
      @include('layout.FrontNavigation')

      @yield('content')

      @include('layout.FrontFooter')
    </div>
  </div>

</div>
<div class="modalLoading"><!-- Place at bottom of page --></div>
<script src="js/highstock.js"></script>
<script src="js/exporting.js"></script>
<script src="js/globalChartsOfMarketCap.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="js/jquery.number.min.js"></script>

<script>
    //delete_cookie('rate');
    function getCookie(c_name) {
        var i, x, y, ARRcookies = document.cookie.split(";");
        for (i = 0; i < ARRcookies.length; i++) {
            x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
            y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
            x = x.replace(/^\s+|\s+$/g, "");
            if (x == c_name) {
                return unescape(y);
            }
        }
    }

    function setCookie(c_name, value, exdays) {
        var exdate = new Date();
        exdate.setDate(exdate.getDate() + exdays);
        var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
        document.cookie = c_name + "=" + c_value;
    }

    function delete_cookie(name) {
        document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    }

    function setCurrentMoney(money) {
        $('.current-money').html(money);
    }

    function setCurrentExchange(money, symbol , rate) {
        $("#currency-switch ul li:eq(0)").before('<li class="pointer monney-switch" rate="'+rate+'" symbol="'+symbol+'"><a data-currency-toggle="">' + money + '</a></li><li class="divider"></li>');
    }

    $(document).ready(function () {

        $('#dataTable').DataTable({
                "bPaginate": false,
                "bLengthChange": false,
                "bFilter": false,
                "bInfo": false,
                "bAutoWidth": false,
            }
        );

        if (getCookie('rate') != null) {
            $('.price').each(function () {
                var price = $(this).attr('price');
                $(this).html(getCookie('symbol') + ' ' + $.number(price * getCookie('rate'), 2));
            });
            setCurrentMoney(getCookie('money'));
            if (getCookie('money') != 'USD') {
                setCurrentExchange(getCookie('money'),getCookie('symbol'),getCookie('rate'));
            }
            $('.current-exchange').html(getCookie('money'));
        }

        var rate = 0;
        var money = 'USD';
        var symbol = '$';
        $('.monney-switch').each(function () {
            $(this).click(function () {
                rate = $(this).attr('rate');
                money = $(this).find('a').html();
                symbol = $(this).attr('symbol');
                setCookie('rate', rate, 1);
                setCookie('money', money, 1);
                setCookie('symbol', symbol, 1);

                $('.price').each(function () {
                    var price = $(this).attr('price');
                    $(this).html(symbol + ' ' + $.number(price * rate, 2));
                });

                $('.current-exchange').html(money);

                setCurrentMoney(money);
                if ($("#currency-switch ul li a").length > 3) {
                    $("#currency-switch ul li").first().remove();
                    $("#currency-switch ul .divider").first().remove();
                }
                if (money != 'USD') {
                    setCurrentExchange(money,symbol,rate);
                }

            });
        });

        $('.exchange-switch').each(function () {
            $(this).click(function () {
                rate = $(this).attr('rate');
                symbol = $(this).text();
                $('.price').each(function () {
                    var price = $(this).attr('price');
                    $(this).html($.number(price / rate, 2) + ' ' + symbol);
                });
                $('.current-exchange').html(symbol);
            });
        });
    });

    var currentRoute = '{!! Route::currentRouteName() !!}';
    if (currentRoute == 'home') {
        var source = "{!!URL::route('cryptocurrencies.search.autocomplete')!!}";
    } else {
        source = "{!!URL::route('cryptocurrencies.search.autocomplete.marketcap')!!}";
    }
    $(function () {
        $("#quick-search-box").autocomplete({
            source: source,
            minLength: 3
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            if (currentRoute == 'home') {
                var html = "<a href=\'/market/" + item.market_name + "/" + item.base + "-" + item.target + "\'><li class=\'list-group-item\'><img width=\'30px\' src=\'" + item.images + "\'> " + item.coin_name + " ( " + item.market_name + ": " + item.name + " ) " + "</li></a>";
            } else {
                html = "<a href=\'/currencies/" + item.coin_name + "\'><li class=\'list-group-item\'><img width=\'30px\' src=\'" + item.images + "\'> " + item.coin_name + "</li></a>";
            }
            return $("<li>")
                .data("ui-autocomplete-item", item)
                .append(html)
                .appendTo(ul);
        };
    });

</script>
<!-- Chart code -->
@yield('script_footer')

</body>
</html>