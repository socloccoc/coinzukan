<div class="row text-center">
    <strong>
        {{ trans('content.HOME_PAGE.total_market_cap') }}:
        <span id="total-marketcap" data-usd="144,155,082,194" data-btc="34,617,091">${{ isset($marketCap) ? number_format($marketCap['total_market_cap']) : 0 }}</span>
    </strong>
</div>

<div id="leaderboard-bottom" class="row text-center"> </div>

<div class="row">
    <div class="col-xs-12">
        <p class="small">{{ trans('content.HOME_PAGE.last_updated') }}: {{ date("M j, Y H:i A ", $marketCap['last_updated']).' UTC' }}</p>
    </div>
</div>

<hr>

<div id="footer" class="row">
    <div class="col-xs-12 col-md-5">
        <div>
            © 2018 <a href="#">Coinzukan</a> |
            <a href="/advertising/" target="_blank">{{ trans('content.HOME_PAGE.advertise') }}</a> |
            <a href="/api/">{{ trans('content.HOME_PAGE.api') }}</a> |
            <a href="/disclaimer/">{{ trans('content.HOME_PAGE.disclaimer') }}</a> |
            <a href="/faq/">{{ trans('content.HOME_PAGE.faq') }}</a> |
            <a href="/request/" target="_blank">{{ trans('content.HOME_PAGE.request_form') }}</a>
        </div>
        <br>
        <div>
            Night Mode:
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-default btn-sm active" data-night-mode-off="">
                    <input type="radio"> Off
                </label>
                <label class="btn btn-default btn-sm" data-night-mode-on="">
                    <input type="radio"> On
                </label>
            </div>
        </div>
        <div class="visible-sm visible-xs"><br></div>
    </div>
    <div class="clearfix visible-sm visible-xs"></div>
    <div class="col-md-1 text-center">
        <a href="https://www.facebook.com/CoinMarketCap" target="_blank"><img src="https://s2.coinmarketcap.com/static/cloud/img/facebook_logo.png" alt="twitter" class="icon-social"></a>
        <a href="https://twitter.com/CoinMarketCap" target="_blank"><img src="https://s2.coinmarketcap.com/static/cloud/img/twitter_logo.png" alt="twitter" class="icon-social"></a>
    </div>
    <div class="clearfix visible-sm visible-xs"><br></div>
    <div class="col-xs-12 col-md-6 text-right">
        {{ trans('content.HOME_PAGE.donate_btc') }}: <a class="pointer" data-toggle="modal" data-target="#donate_btc">3CMCRgEm8HVz3DrWaCCid3vAANE42jcEv9</a><br>
        {{ trans('content.HOME_PAGE.donate_ltc') }}: <a class="pointer" data-toggle="modal" data-target="#donate_ltc">LTdsVS8VDw6syvfQADdhf2PHAm3rMGJvPX</a><br>
        {{ trans('content.HOME_PAGE.donate_eth') }}: <a class="pointer" data-toggle="modal" data-target="#donate_eth">0x0074709077B8AE5a245E4ED161C971Dc4c3C8E2B</a>
    </div>
</div>