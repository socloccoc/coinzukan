<?php $i = 1 ?>
<table id="listDataMarkets" class="display" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>#</th>
        <th>@lang('detailcoin.TAB_MARKETS.source')</th>
        <th>@lang('detailcoin.TAB_MARKETS.pair')</th>
        <th>@lang('detailcoin.TAB_MARKETS.base')</th>
    </tr>
    </thead>
    <tbody>
    @forelse($listMarkets as $row)
        <tr>
            <td>{!! $i !!}</td>
            <td>{!! isset($row->name_market) ? $row->name_market : 'N/A'  !!}</td>
            <td>{!! isset($row->base) && isset($row->target) ?  $row->base .'/'. $row->target : 'N/A' !!}</td>
            <td>{!! isset($row->base_volume) ? number_format($row->base_volume, 8) : 0 !!}</td>
        </tr>
        <?php $i++ ?>
    @empty
        <tr>
            <td colspan="4">No Data</td>
        </tr>
    @endforelse
    </tbody>
</table>