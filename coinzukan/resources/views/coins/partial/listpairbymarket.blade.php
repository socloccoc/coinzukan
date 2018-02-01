@forelse($listMarkets as $listMarket)
<tr>
    <td>9</td>
    <td>
        <a href="">
            {{ isset($listMarket->market_name) && !empty($listMarket->market_name) ? $listMarket->market_name : '' }}
        </a>
    </td>
    <td>
        <a href="" target="_blank">
            {{ isset($listMarket->name) && !empty($listMarket->name) ? $listMarket->name : '' }}
        </a>
    </td>
    <td class="text-right volume">
        {{ isset($listMarket->baseVolume) && !empty($listMarket->baseVolume) ? number_format($listMarket->baseVolume) : '' }}
    </td>
    <td class="text-right">
        <span class="price">
            {{ isset($listMarket->price) && !empty($listMarket->price) ? number_format($listMarket->price) : '' }}
        </span>
    </td>
    <td class="text-right">
        {{ isset($listMarket->percentChange24hr) && !empty($listMarket->percentChange24hr) ? number_format($listMarket->percentChange24hr, 2) . '%' : '' }}
    </td>
</tr>
@empty

@endforelse