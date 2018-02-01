<?php $i = 1;
?>
@foreach($data as $row)
  <tr id="id-bitcoin" class="odd" role="row">
    <td class="text-center sorting_1">
      {!! $i !!}
    </td>

    <td class="no-wrap currency-name">
      <?php
      if (Route::currentRouteName() == 'coin-all' || Route::currentRouteName() == 'filterCurrencies') {
        $url = isset($row->coins_images) && !empty($row->coins_images) && (file_exists(base_path() . "/public_html" . $row->coins_images) || file_exists(public_path($row->coins_images))) ? $row->coins_images : '../images/coin_icon/icon_coin_default.png';
      } else {
        $url = isset($row->coins_images) && !empty($row->coins_images) && (file_exists(base_path() . "/public_html" . $row->coins_images) || file_exists(public_path($row->coins_images))) ? $row->coins_images : 'images/coin_icon/icon_coin_default.png';
      }
      ?>
      <img src="{{ $url }}" class="currency-logo">
      <a href="{{URL::route('coin-convert',array($row->market_name, $row->base, $row->target))}}"
         title="{!! isset($row->coins_name) ? $row->coins_name : 'N/A' !!}">{!! isset($row->coins_name) ? str_limit($row->coins_name, 17) : '' !!}</a>
    </td>

    <td class="no-wrap market-cap text-right">
      {!! isset($row->price) && !empty($row->price) && isset($row->circulating_supply) && !empty($row->circulating_supply) ? number_format($row->price*$row->circulating_supply) : 0 !!}
    </td>
    <td class="no-wrap text-right">
      <?php
      $price = isset($row->price) && $row->price < 0.01 ? $price = number_format($row->price, 6) : $price = number_format($row->price, 2);
      ?>
      <a href="{{URL::route('coin-convert2',array($row->market_name, $row->base, $row->target))}}" class="price">
        {{ isset($price) && !empty($price) ? $price. ' '.strtoupper($row->target) : 0 }}
      </a>
    </td>
    <td class="no-wrap text-right">
      <a href="#">
        {!!  isset($row->circulating_supply) ? number_format($row->circulating_supply). ' '.strtoupper($row->base) : 0 !!}
      </a>
    </td>
    <td class="no-wrap text-right">
      <a href="#" class="volume">
        {!! isset($row->volume) && !empty ($row->volume) ? number_format($row->volume, 4). ' '. strtoupper($row->target) : ''  !!}
      </a>
    </td>

    <td class="no-wrap percent-24h  {{isset($row->change_24h) && !empty($row->change_24h) && $row->change_24h > 0 ? 'positive_change' : 'negative_change' }} text-right"
        data-usd="-10.39" data-btc="0.00">
      {!! isset($row->change_24h) && !empty($row->change_24h) ? number_format($row->change_24h, 2) . '%' : 0 !!}
    </td>

    <td>
      <a href="{{URL::route('coin-convert',array($row->market_name, $row->base, $row->target))}}">
        <img id="{{'image_'.$row->market_id.'_'.$row->pair_id}}"
             style="width: 166px; height: 50px; border: 1px solid #000000"/>
      </a>
    </td>
  </tr>
  <div style="position: fixed; width: 2490px; height: 750px; left: 0px" hidden
       id="{{'container_'.$row->market_id.'_'.$row->pair_id}}"></div>
  <?php $i++ ?>
@endforeach
@section('script_footer')
  <script src="js/chartImage.js"></script>
@stop

