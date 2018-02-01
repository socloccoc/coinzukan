@forelse($historyDatas as $row)
    <tr>
        <?php
        $date = date("F d, Y", strtotime($row->date));
        $arrayDate = explode(" ",$date);
        $newDate = substr($arrayDate[0],0,3)." ".$arrayDate[1]." ".$arrayDate[2];
        ?>
        <td>{!! date('m/d/Y', $row->date) !!}</td>
        <td>{!! isset($row->open) ? (number_format($row->open, 2)) : 'N/A' !!}</td>
        <td>{!! isset($row->high) ? number_format($row->high, 2) : 'N/A' !!}</td>
        <td>{!! isset($row->low) ? number_format($row->low, 2) : 0 !!}</td>
        <td>{!! isset($row->close) ? number_format($row->close, 2) : 0 !!}</td>
        <td>{!! isset($row->volume) ? number_format($row->volume, 2) : 0 !!}</td>
    </tr>
@empty
    <tr>
        <td colspan="6">No Data</td>
    </tr>
@endforelse