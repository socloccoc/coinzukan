<?php $i = 0 ?>
@forelse($listCryptocurrencies as $row)
    <?php $i++ ?>
    <tr id="id-bitcoin" class="odd" role="row">
        <td class="text-center sorting_1">
            {!! $i !!}
        </td>

        <td class="no-wrap currency-name">
            <?php
            if (Route::currentRouteName() == 'coin-all' || Route::currentRouteName() == 'filterCurrencies') {
                $url = isset($row->coins_images) && (file_exists(base_path() . "/public_html" . $row->coins_images) || file_exists(public_path($row->coins_images))) ? $row->coins_images : '../images/coin_icon/icon_coin_default.png';
            } else {
                $url = isset($row->coins_images) && (file_exists(base_path() . "/public_html" . $row->coins_images) || file_exists(public_path($row->coins_images))) ? $row->coins_images : 'images/coin_icon/icon_coin_default.png';
            }
            ?>
            <img src="{{ $url }}" class="currency-logo">
            <a href="{{ route('detail.coin', $row->coin_name) }}" title="{!! isset($row->coin_name) ? $row->coin_name : 'N/A' !!}">
                {!! isset($row->coin_name) ? str_limit($row->coin_name, 17) : '' !!}
            </a>
        </td>

        <td class="no-wrap market-cap text-left">
            {!!
                isset($row->symbol) ? $row->symbol : ''
            !!}
        </td>

        <td class="no-wrap market-cap text-right">
            {!!
                isset($row->market_cap_usd) ? number_format(($row->market_cap_usd) , 0). $unit : '0$'
            !!}
        </td>

        <td class="no-wrap market-cap text-right">
            <a href="currencies/{{ $row->coin_name }}/#markets_cap">
                {!! $exchange == 'USD' ? number_format($row->price_usd / $rate, 3).$unit : ($exchange == 'BTC' ? number_format($row->price_btc , 8). $unit : number_format($row->price_usd/$rate, 8). $unit)  !!}
            </a>
        </td>

        <td class="no-wrap text-right">
            <a href="currencies/{{ $row->coin_name }}/#markets_cap" class="volume">
                {!! isset($row->volume_24h) ? number_format($row->volume_24h, 0) . $unit : '0$'  !!}
            </a>
        </td>

        <td class="no-wrap text-right">
            <a href="{!! isset($row->circulatingUrl) ? $row->circulatingUrl : '' !!}">
                {!!  isset($row->available_supply) ? number_format($row->available_supply) : 0 !!}
            </a>
        </td>

        <td class="no-wrap percent-24h  {{ isset($row->percent_1h) && $row->percent_1h > 0 ? 'positive_change' : 'negative_change' }} text-right"
            data-usd="-10.39" data-btc="0.00">
            {!! isset($row->percent_1h) ? number_format($row->percent_1h, 2) . '%' : 0 !!}
        </td>

        <td class="no-wrap percent-24h  {{ isset($row->percent_24h) && $row->percent_24h > 0 ? 'positive_change' : 'negative_change' }} text-right"
            data-usd="-10.39" data-btc="0.00">
            {!! isset($row->percent_24h) ? number_format($row->percent_24h, 2) . '%' : 0 !!}
        </td>

        <td class="no-wrap percent-7d  {{ isset($row->percent_7d) && $row->percent_7d > 0 ? 'positive_change' : 'negative_change' }} text-right"
            data-usd="-10.39" data-btc="0.00">
            {!! isset($row->percent_7d) ? number_format($row->percent_7d, 2) . '%' : 0 !!}
        </td>
    </tr>

@empty
    <tr>
        <td colspan="8">
            No data
        </td>
    </tr>
@endforelse