
@extends('layout.FrontMaster')
@section('icon')
    <link rel="icon" type="image/png" href="https://coinmarketcap.com/static/img/CoinMarketCap.png" sizes="16x16"/>
@stop
@section('title')
    Coinzukan
@stop
@section('content')
    <div class="row subheader">
        <div class="col-xs-12 text-center">
            <h1>{{ trans('content.HOME_PAGE.monthly_volume_rankings_currency') }}</h1>
        </div>
    </div>
    {!! Form::open(array('route' => 'currencies.volume.history','method'=>'get', 'id' => 'form_exchange_rate')) !!}
    <div class="row">
        <div class="col-xs-6 text-left">
            <div class="clear"></div>
            <div id="currency-switch" class="btn-group">
                {!! Form::select('exchange', ['USD'=>'USD', 'BTC' => 'BTC', 'ETH' => 'ETH'] + $listExchanges, ' ',['class'=>'btn btn-primary', 'onchange' => 'this.form.submit()'])!!}
            </div>
        </div>
        <div class="clear"></div>
    </div>
    {!! Form::close() !!}
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <div id="currencies-volume_wrapper" class="dataTables_wrapper no-footer"><table class="table dataTable no-footer" id="currencies-volume" role="grid" style="width: 100%;">
                        <thead>
                        <tr role="row">
                            <th class="text-center sorting_disabled" rowspan="1" colspan="1" aria-label="#" style="width: 59px;">#</th>
                            <th id="th-name" class="sortable sorting" tabindex="0" aria-controls="currencies-volume" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 225px;">
                                {!! $columns['name'] !!}
                            </th>
                            <th id="th-symbol" class="sortable sorting" tabindex="0" aria-controls="currencies-volume" rowspan="1" colspan="1" aria-label="Symbol: activate to sort column ascending" style="width: 147px;">
                                {!! $columns['symbol'] !!}
                            </th>
                            </th>
                            <th id="th-volume" class="sortable text-right sorting" tabindex="0" aria-controls="currencies-volume" rowspan="1" colspan="1" aria-label="Volume (1d): activate to sort column descending" style="width: 160px;">
                                {!! $columns['volume_24h'] !!}
                            </th>
                            </th>
                            <th id="th-volume7d" class="sortable text-right sorting" tabindex="0" aria-controls="currencies-volume" rowspan="1" colspan="1" aria-label="Volume (7d): activate to sort column descending" style="width: 174px;">
                                {!! $columns['volume_7d'] !!}
                            </th>
                            </th>
                            <th id="th-volume30d" class="sortable text-right sorting" tabindex="0" aria-controls="currencies-volume" rowspan="1" colspan="1" aria-label="Volume (30d): activate to sort column descending" style="width: 187px;">
                                {!! $columns['volume_30d'] !!}
                            </th>
                        </tr>

                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @forelse($historyVolumes as $historyVolume)
                                <?php $i++; ?>
                                <tr id="id-bitcoin" role="row" class="odd">
                                    <td class="text-center">{{ $i }}</td>
                                    <td class="no-wrap currency-name">
                                        <?php
                                            $url = isset($historyVolume->coins_images) && !empty($historyVolume->coins_images) && (file_exists(base_path() . "/public_html" . $historyVolume->coins_images) || file_exists(public_path($historyVolume->coins_images))) ? $historyVolume->coins_images : 'images/coin_icon/icon_coin_default.png';
                                        ?>
                                        <img src="{{ $url }}" class="currency-logo"
                                             alt="{{ isset($historyVolume->name) && !empty ($historyVolume->name) ? $historyVolume->name : '' }}">
                                        <a href="#">{{ isset($historyVolume->name) && !empty($historyVolume->name) ? $historyVolume->name : '' }}</a>
                                    </td>
                                    <td class="text-left">{{ isset($historyVolume->symbol) && !empty($historyVolume->symbol) ? $historyVolume->symbol : '' }}</td>
                                    <td class="no-wrap text-right">
                                        <a href="#" class="volume"
                                                    data-usd="{{ isset($historyVolume->volume_24h) && !empty($historyVolume->volume_24h) ? $historyVolume->volume_24h : '' }}">
                                            {{  isset($historyVolume->volume_24h) && !empty($historyVolume->volume_24h) ? number_format($historyVolume->volume_24h / $rate). ' '. $unit : '' }}
                                        </a>
                                    </td>
                                    <td class="no-wrap text-right">
                                        <a href="#" class="volume"
                                           data-usd="22048873216.0"
                                           data-btc="2752802.9375">
                                            {{  isset($historyVolume->volume_7d) && !empty($historyVolume->volume_7d) ? number_format($historyVolume->volume_7d / $rate). ' '. $unit : '' }}
                                        </a>
                                    </td>
                                    <td class="no-wrap text-right">
                                        <a href="#" class="volume"
                                           data-usd="1.06770601344e+11"
                                           data-btc="15240598.7656">
                                            {{  isset($historyVolume->volume_30d) && !empty($historyVolume->volume_30d) ? number_format($historyVolume->volume_30d / $rate). ' '. $unit :'' }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6"> No data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table></div>
            </div>
        </div>
    </div>
@stop