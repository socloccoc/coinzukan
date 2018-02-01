<?php $i = 0 ?>
@forelse($listPairs as $listPair)
    <?php $i++ ?>
    <tr>
        <td>{{ $i }}</td>
        <td>
            <a href="{{ route('detail.coin', Helper::renderNameCoinByCode($listPair->base)) }}">
                {{ Helper::renderNameCoinByCode($listPair->base) }}
            </a>
        </td>
        <td>
            <a href="" target="_blank">
                {{ isset($listPair->name) && !empty($listPair->name) ? ucwords($listPair->name) : '' }}
            </a>
        </td>
        <td class="text-right volume">
            {{ isset($listPair->baseVolume) && !empty($listPair->baseVolume) ? number_format($listPair->baseVolume) : '' }}
        </td>
        <td class="text-right">
            <span class="price">
                {{ isset($listPair->price) && !empty($listPair->price) ? number_format($listPair->price) : '' }}
            </span>
        </td>
        <td class="text-right">
            {{ isset($listPair->percentChange24hr) && !empty($listPair->percentChange24hr) ? number_format($listPair->percentChange24hr, 2) . '%' : '' }}
        </td>
    </tr>
@empty

@endforelse