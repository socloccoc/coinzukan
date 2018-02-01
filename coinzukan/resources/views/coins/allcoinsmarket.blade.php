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
            <a href="{{ route('detail.coin', $row->coins_name) }}" title="{!! isset($row->coins_name) ? $row->coins_name : 'N/A' !!}">
                {!! isset($row->coins_name) ? str_limit($row->coins_name, 17) : '' !!}
            </a>
        </td>

        <td class="no-wrap market-cap text-left">
            {!! isset($row->code) ? $row->code : ''  !!}
        </td>

        <td class="no-wrap market-cap text-right price" price="{{ isset($row->market_cap_usd) ? $row->market_cap_usd : 0 }}">
            {!! isset($row->market_cap_usd) ? number_format(($row->market_cap_usd / $rate), 0) . ' ' . $unit : '0$'  !!}
        </td>

        <td class="no-wrap text-right">
            <a href="#" class="price" price="{{ isset($row->price) ? $row->price : 0 }}">
                <?php
                $fomat = $unit == '$' ? 2 : 8
                ?>
                {{ isset($row->price) ? number_format($row->price / $rate, $fomat) . ' '. $unit : '0$' }}
            </a>
        </td>

        <td class="no-wrap text-right">
            <a href="#">
                {!!  isset($row->available_supply) ? number_format($row->available_supply) : 0 !!}
            </a>
        </td>

        <td class="no-wrap text-right">
            <a href="#" class="volume price" price="{{ isset($row->volume) ? $row->volume : 0 }}">
                {!! isset($row->volume) ? number_format($row->volume / $rate, $fomat) : '0$'  !!}
            </a>
        </td>

        <td class="{{isset($row->percent_change_1h) && $row->percent_change_1h > 0 ? 'positive_change' : 'negative_change'}} text-right ">
            {!! isset($row->percent_change_1h) ? number_format($row->percent_change_1h, 2) . '%' : 0 !!}
        </td>

        <td class="{{isset($row->percent_change_24h) && $row->percent_change_24h > 0 ? 'positive_change' : 'negative_change'}} text-right ">
            {!! isset($row->percent_change_24h) ? number_format($row->percent_change_24h, 2) . '%' : 0 !!}
        </td>

        <td class="{{isset($row->percent_change_7d) && $row->percent_change_7d > 0 ? 'positive_change' : 'negative_change'}} text-right ">
            {!! isset($row->percent_change_7d) ? number_format($row->percent_change_7d, 2) . '%' : 0 !!}
        </td>

    </tr>

    <?php $i++ ?>
@endforeach
