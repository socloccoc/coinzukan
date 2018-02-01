$(document).ready(function(){

    /*----Create Chart-----*/

    var segments = location.href.split( '/' );
    var url = "/ajax/getDataChart";
    var markets = '';
    $.ajax({
        url: url,
        type: "GET",
        cache:false,
        data: {"market_name":segments[4], "coin_convert": segments[5]},
        beforeSend: function () {
            $("#chartdiv").addClass("loadingchart");
        },
        success: function (data){
            data[0].forEach(function (element) {
                markets += '<option value="'+element['id']+'">'+element['market_name']+'</option>';
            });
            $("#makets").html(markets);
            if(data[1].length == 0){
                $("#chartdiv").html("No Data !").css({"color":"red","text-align":"center"});
            }else{
                createChart(data[1]);
            }
        },
        complete: function() {
            $("#chartdiv").removeClass("loadingchart");
        }

    });

    $('.btn-time-chart').each(function () {
        $(this).click(function () {
            $(this).addClass("time-active");
            $.ajax({
                url: url,
                type: "GET",
                cache:false,
                data: {"market_id" : $("#makets").val(), "coin_convert": segments[5],'btn-time':$(this).attr('keyChart')},
                beforeSend: function () {
                    $('#chartdiv').html('');
                    $('#chartdiv').addClass('loadingchart');
                },
                success: function (data){
                    if(data[1].length == 0){
                        $("#chartdiv").html(" No Data ! ").css({"color":"red","text-align":"center"});
                    }else{
                        createChart(data[1]);
                    }
                },
                complete: function() {
                    $("#chartdiv").removeClass("loadingchart");
                }
            });

            $('.btn-time-chart').not(this).each(function () {
                $(this).removeClass("time-active");
            });

        });
    });

    $('#makets').on('change',function () {
        $.ajax({
            url: url,
            type: "GET",
            cache:false,
            data: {"market_id" : $(this).val(), "coin_convert": segments[5],'btn-time':$("input.time-active").val()},
            beforeSend: function () {
                $('#chartdiv').html('');
                $('#chartdiv').addClass('loadingchart');
            },
            success: function (data){
                if(data[1].length == 0){
                    $("#chartdiv").html(" No Data ! ").css({"color":"red","text-align":"center"});
                }else{
                    createChart(data[1]);
                }
            },
            complete: function() {
                $("#chartdiv").removeClass("loadingchart");
            }
        });
    });

  function sleep(milliseconds) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
      if ((new Date().getTime() - start) > milliseconds){
        break;
      }
    }
  }

    function createChart(data) {
        var chart = AmCharts.makeChart("chartdiv", {
            "type": "serial",
            "theme": "light",
            "precision": 2,
            "valueAxes": [{
                "id": "v1",
                "title": "Volume",
                "position": "left",
                "autoGridCount": false

            }, {
                "id": "v2",
                "title": "Price",
                "gridAlpha": 0,
                "position": "right",
                "autoGridCount": false
            }],

            "graphs": [{
                "id": "g3",
                "lineColor": "#e1ede9",
                "fillColors": "#e1ede9",
                "fillAlphas": 1,
                "type": "column",
                "title": "Volume",
                "valueField": "volume",
                "clustered": false,
                "columnWidth": 0.5,
                "legendValueText": "[[value]]",
                "balloonText": "[[title]]<br /><b style='font-size: 130%'>[[value]]</b>"
            }, {
                "id": "g1",
                "balloonFunction": function (graphDataItem,graph) {
                    return 'Open:<b>'+graphDataItem.values.open+'</b><br>Low:<b>'+graphDataItem.values.low+'</b><br>High:<b>'+graphDataItem.values.high+'</b><br>Close:<b>'+graphDataItem.values.close+'</b><br>';
                },
                "closeField": "close",
                "valueAxis": "v2",
                "fillColors": "#7f8da9",
                "highField": "high",
                "lineColor": "#7f8da9",
                "lineAlpha": 1,
                "lowField": "low",
                "fillAlphas": 0.9,
                "negativeFillColors": "#db4c3c",
                "negativeLineColor": "#db4c3c",
                "openField": "open",
                "title": "Price:",
                "type": "candlestick",
                "valueField": 'close',
                "numberFormatter":{precision:-1, decimalSeparator:'.', thousandsSeparator:''}
            }],

            "chartScrollbar": {
                "graph": "g1",
                "graphType": "line",
                "scrollbarHeight": 10,
                "oppositeAxis": true,
            },
            "chartCursor": {
                "pan": true,
                "valueLineEnabled": true,
                "valueLineBalloonEnabled": true,
                "cursorAlpha": 0,
                "valueLineAlpha": 0.2
            },

            "categoryField": "date",
            "categoryAxis": {
                "dashLength": 1,
                "minorGridEnabled": true
            },

            "legend": {
                "useGraphSettings": true,
                "position": "bottom"
            },

            "balloon": {
                "borderThickness": 1,
                "shadowAlpha": 0
            },

            "export": {
                "enabled": true
            },

            "dataProvider": data
        });


    }


});