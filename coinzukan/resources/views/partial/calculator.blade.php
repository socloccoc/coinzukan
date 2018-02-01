@extends('layout.FrontMaster')
@section('icon')
    <link rel="icon" type="image/png" href="https://coinmarketcap.com/static/img/CoinMarketCap.png" sizes="16x16"/>
@stop
@section('title')
    {{ trans('content.HOME_PAGE.currency_converter_calculator') }} | {{ trans('content.HOME_PAGE.coinmarketcap') }}
@stop
@section('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
@stop
@section('script_footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
@stop
@section('content')
    <h1 class="text-center">{{ trans('content.HOME_PAGE.currency_converter_calculator') }}</h1>
    <br/>
    <div class="row">
        <div id="calculator" class="form-group well well-lg col-md-8 col-md-offset-2 col-xs-12" style="visibility: visible; padding: 40px;">
            <div class="row">
                <div class="col-xs-5" style="">
                    <input name="conversion-amount" type="number" class="form-control " id="conversion-amount" placeholder="Enter Amount to Convert">
                </div>
            </div>
            <div class="vertical-spacer"></div>
            <div class="row">
                <div class="col-xs-5">
                    {{Form::select('from_currency',['Cryptocurrencies'=> $primary, 'Fiat Currencies'   => $second], '', ['id' => 'from_currency', 'class'   =>  'form-control' ])}}
                </div>
                <div class="col-xs-2 text-center" style="">
                    <button type="button" id="swap-button" class="btn btn-sm btn-primary">
                        <span class="glyphicon glyphicon-transfer"></span>
                    </button>
                </div>
                <div class="col-xs-5">
                    {{Form::select('to_currency',['Fiat Currencies'   => $second, 'Cryptocurrencies'=> $primary], '', ['id' => 'to_currency', 'class'   =>  'form-control' ])}}
                </div>
            </div>
            <div class="vertical-spacer"></div>
            <div class="row" id="result_calculator" style="display: none">
                <div id="conversion-result-left" class="col-xs-5 text-right" style=""></div>
                <div id="conversion-result-middle" class="col-xs-2  text-center" style=""> = </div>
                <div id="conversion-result-right" class="col-xs-5">
                    <span id="conversion-result-value"></span>
                    <span id="conversion-result-value-currency">Bitcoin (BTC)</span>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#from_currency').select2();
            $('#to_currency').select2();
        });

        $("#conversion-amount").on("change paste keyup", function() {
            var amount = $(this).val();
            var primary = $( "#from_currency option:selected" ).text();
            var secondary = $( "#to_currency option:selected" ).text();
            getRateByAmountPriAndSecond(amount, primary, secondary);

        });
        $('#from_currency').on('change', function (e) {
            var amount = $("input[name=conversion-amount]").val();
            var primary = $( "#from_currency option:selected" ).text();
            var secondary = $( "#to_currency option:selected" ).text();
            getRateByAmountPriAndSecond(amount, primary, secondary);
        });
        $('#to_currency').on('change', function (e) {
            var amount = $("input[name=conversion-amount]").val();
            var primary = $( "#from_currency option:selected" ).text();
            var secondary = $( "#to_currency option:selected" ).text();
            getRateByAmountPriAndSecond(amount, primary, secondary);
        });
        function getRateByAmountPriAndSecond(amount, primary, secondary){
            var url  = '{{ route('calculator.currency.post') }}';
            $.ajax({
                url : url,
                type : 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    amount: amount,
                    primary: primary,
                    secondary: secondary,
                },
                success: function (result) {
                    $('#result_calculator').css('display', 'block');
                    $('#conversion-result-left').html(amount + ' ' + primary);
                    $('#conversion-result-value-currency').html(result + ' ' + secondary);
                }
            });
        }

    </script>
@stop
