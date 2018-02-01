@forelse($listHistory as $row)
    <tr>
        <?php
            $date = date("F d, Y", strtotime($row->date));
            $arrayDate = explode(" ",$date);
            $newDate = substr($arrayDate[0],0,3)." ".$arrayDate[1]." ".$arrayDate[2];
        ?>
        <td>{!! date('m/d/Y', $row->date) !!}</td>
        <td>{!! isset($row->rate) ? (number_format($row->rate, 8)) : 'N/A' !!}</td>
        <td>{!! isset($row->amount) ? number_format($row->amount, 8) : 'N/A' !!}</td>
        <td>{!! isset($row->rate) ? number_format($row->rate * $row->amount, 8) : 0 !!}</td>
    </tr>
@empty
    <tr>
        <td colspan="5">No Data</td>
    </tr>
@endforelse
