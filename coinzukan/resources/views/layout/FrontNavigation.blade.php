<nav id="nav-main" class="navbar navbar-default">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <div class="collapse navbar-collapse top-menu" id="navbar-collapse-1">
        <ul class="nav navbar-nav">
            <li class="dropdown">
                <a href="/" class="dropdown-toggle" data-toggle="dropdown">{{ trans('content.HOME_PAGE.market_cap') }} <span
                            class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ route('homeMarketCap') }}">{{ trans('content.HOME_PAGE.all') }}</a></li>
                    <li><a href="{{ route('coins') }}">{{ trans('content.HOME_PAGE.coins') }}</a></li>
                    <li><a href="{{ route('tokens') }}">{{ trans('content.HOME_PAGE.tokens') }}</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ trans('content.HOME_PAGE.trade_volume') }} <span
                            class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="{{ route('currencies.volume.marketcap') }}">
                            {{ trans('content.HOME_PAGE.24_hour_volume_rankings_currency') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('exchanges.volume.marketcap') }}">
                            {{ trans('content.HOME_PAGE.24_hour_volume_rankings_exchange') }}
                        </a>
                    </li>
                    <li><a href="{{ route('currencies.volume.history') }}">{{ trans('content.HOME_PAGE.monthly_volume_rankings_currency') }}</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ trans('content.HOME_PAGE.trending') }} <span
                            class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ route('new.currency') }}">{{ trans('content.HOME_PAGE.recently_added') }}</a></li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ trans('content.HOME_PAGE.tools') }} <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ route('charts') }}">{{ trans('content.HOME_PAGE.global_charts') }}</a></li>
                    <li><a href="{{ route('historical.snapshots') }}">{{ trans('content.HOME_PAGE.historical_snapshots') }}</a></li>
                    <li><a href="{{ route('calculator.currency') }}">{{ trans('content.HOME_PAGE.currency_converter_calculator') }}</a></li>
                </ul>
            </li>
        </ul>
            {!! Form::open(array('route' => 'cryptocurrencies.search','method'=>'get','class'=>'navbar-form navbar-right')) !!}
                <div class="form-group" style="height: 32px;box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);">
                    {!! Form::text('keyword', isset($filters["Keyword"]) && $filters["Keyword"] != '' ? $filters["Keyword"] : '' , array('class'=>'form-control','placeholder'=>trans('content.HOME_PAGE.search_currencies'), 'id' => 'quick-search-box')) !!}
                    <button class="btn btn-primary hidden-xs" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                </div>
            {!! Form::close() !!}
        <div class="bottom-margin-1x hidden-sm hidden-md hidden-lg"></div>
    </div>
</nav>