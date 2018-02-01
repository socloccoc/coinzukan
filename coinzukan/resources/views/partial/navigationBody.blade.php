<div class="col-xs-6 hidden-sm col-md-4">
    <ul id="category-tabs" class="nav nav-tabs text-left" role="tablist">
        <li>
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                {{ trans('content.HOME_PAGE.all') }} <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="/">{{ trans('content.HOME_PAGE.top_100') }}</a></li>
                <li><a href="{{ route('all.coins.marketcap') }}">{{ trans('content.HOME_PAGE.full_list') }}</a></li>
            </ul>
        </li>

        <li>
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                {{ trans('content.HOME_PAGE.coins') }} <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="{{ route('coins') }}">{{ trans('content.HOME_PAGE.top_100') }}</a></li>
                <li><a href="{{ route('all.coins') }}">{{ trans('content.HOME_PAGE.full_list') }}</a></li>
                <li class="divider"></li>
                <li><a href="{{ route('coins') }}">{{ trans('content.HOME_PAGE.market_cap_by_circulating_supply') }}</a></li>
                <li><a href="/coin/totalSupply">{{ trans('content.HOME_PAGE.market_cap_by_total_supply') }}</a></li>
            </ul>
        </li>
        <li>
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                {{ trans('content.HOME_PAGE.tokens') }} <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="{{ route('tokens') }}">{{ trans('content.HOME_PAGE.top_100') }}</a></li>
                <li><a href="{{ route('tokens.all') }}">{{ trans('content.HOME_PAGE.full_list') }}</a></li>
                <li class="divider"></li>
                <li><a href="{{ route('tokens') }}">{{ trans('content.HOME_PAGE.market_cap_by_circulating_supply') }}</a></li>
                <li><a href="{{ route('tokens.totalSupply') }}">{{ trans('content.HOME_PAGE.market_cap_by_total_supply') }}</a></li>
            </ul>
        </li>
    </ul>
</div>