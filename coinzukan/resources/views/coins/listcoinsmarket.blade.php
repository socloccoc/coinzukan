<?php
$i = 1;
?>
@foreach($listCoinFromCoinMarket as $row)
    <tr id="id-bitcoin" class="odd" role="row">
        <td class="text-center sorting_1">
            {!! $row->rank !!}
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
            <a href="{{ route('detail.coin', $row->coins_name) }}"
               title="{!! isset($row->coins_name) ? $row->coins_name : 'N/A' !!}">
                {!! isset($row->coins_name) ? str_limit($row->coins_name, 17) : '' !!}
            </a>
        </td>

        <td class="no-wrap market-cap text-right price" price="{{ isset($row->market_cap_usd) ? $row->market_cap_usd : 0 }}" >
            {!! isset($row->market_cap_usd) ? number_format(($row->market_cap_usd / $rate), 0) . ' ' . $unit : '0$'  !!}
        </td>

        <td class="no-wrap text-right">
            <a href="currencies/{{ $row->coins_name }}/#markets_cap" price="{{ isset($row->price) ? $row->price : 0 }}" class="price">
                <?php
                    $fomat = $unit == '$' ? 2 : 8
                ?>
                {{ isset($row->price) ? number_format($row->price / $rate, $fomat) . ' '. $unit : '0$' }}
            </a>
        </td>

        <td class="no-wrap text-right">
            <a href="currencies/{{ $row->coins_name }}/#markets_cap" class="volume price" price="{{ isset($row->volume) ? $row->volume : 0 }}">
                {!! isset($row->volume) ? number_format($row->volume / $rate) . ' '. $unit : '0$'  !!}
            </a>
        </td>

        <td class="no-wrap text-right">
            <a href="{!!  isset($row->circulatingUrl) ? $row->circulatingUrl : '' !!}">
                @if(Route::currentRouteName() == 'all.coins.marketcap')
                    {!!  isset($row->total_supply) ? number_format($row->total_supply) : 0 !!}
                @else
                    {!!  isset($row->available_supply) ? number_format($row->available_supply) : 0 !!}
                @endif
            </a>
        </td>

        <td class="no-wrap percent-24h  {{isset($row->percent_change_24h) && $row->percent_change_24h > 0 ? 'positive_change' : 'negative_change' }} text-right"
            data-usd="-10.39" data-btc="0.00">
            {!! isset($row->percent_change_24h) ? number_format($row->percent_change_24h, 2) . '%' : 0 !!}
        </td>

        <td>
            <a href="#">
                <img {{ isset($row->imageChart) ? 'src='.$row->imageChart : '' }}
                     style="width: 166px; height: 50px; border: 1px solid #000000"/>
            </a>
        </td>
    </tr>

    <?php $i++ ?>
@endforeach
