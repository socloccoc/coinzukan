<?php
$startYear = \Config::get('constants.yeart_start_historical_snap');
$countYearSnap = ((date('Y') + 1) - $startYear);
?>
@extends('layout.FrontMaster')
@section('icon')
    <link rel="icon" type="image/png" href="https://coinmarketcap.com/static/img/CoinMarketCap.png" sizes="16x16"/>
@stop
@section('title')
    {{ trans('content.HOME_PAGE.historical_snapshots') }} | {{ trans('content.HOME_PAGE.coinmarketcap') }}
@stop
@section('content')
    <h1 class="text-center">{{ trans('content.HOME_PAGE.historical_snapshots') }}</h1>
    @foreach($data as $year=>$month)
        <div class="row">
            <div class="vertical-spacer"></div>
            <hr>
            <h2>{{ $year }}</h2>
            <hr>
            <?php
            $break = 1;
            ?>
            @foreach($month[0] as $month=>$day)
                <div class="col-sm-4 col-xs-6">
                    <h3 class="text-center">{{ Helper::convertNumberToMonthString($month) }}</h3>
                    <ul class="list-unstyled">
                        @forelse($day[0] as $day)
                            <li class="text-center">
                                <a href="{{ route('historical.get.snapshots', $year.$month.$day) }}">
                                    {{ $day }}
                                </a>
                            </li>
                        @empty
                        @endforelse
                    </ul>
                </div>
                @if($break % 3 == 0)
                    <div class="clearfix"></div>
                @endif
                <?php
                $break++;
                ?>
            @endforeach
        </div>
    @endforeach


@stop