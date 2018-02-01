$( document ).ready(function() {
    $('#listDataHistory').DataTable({
        "bLengthChange": false,
        "bInfo": false,
        "bPaginate": false,
        responsive: true,
        "pageLength": 10,
        "pagingType": "simple",
        searching: false,
        "ordering": false
    });
    $('#listDataMarkets').DataTable({
        "bLengthChange": false,
        "bInfo": false,
        "bPaginate": true,
        responsive: true,
        "pageLength": 10,
        "pagingType": "simple",
        searching: false,
    });
});

/*----Create Chart-----*/

var segments = location.href.split( '/' );
var url = "/ajax/getDataChart";

$.ajax({
    url: url,
    type: "GET",
    cache:false,
    data: {"market_id" : $("#makets").val(), "coin_convert": segments[5]},
    beforeSend: function () {
        $("#chartdiv").addClass("loadingchart");
    },
    success: function (data){

        if(data.length == 0){
            $("#chartdiv").html("No Data !").css({"color":"red","text-align":"center"});
        }else{
            createChart(data);
        }

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
            data: {"market_id" : $("#makets").val(), "coin_convert": segments[5],'btn-time':$(this).val()},
            success: function (data){
                if(data.length == 0){
                    $("#chartdiv").html("No Data !").css({"color":"red","text-align":"center"});
                }else{
                    createChart(data);
                }
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
        success: function (data){
            if(data.length == 0){
                $("#chartdiv").html("No Data !").css({"color":"red","text-align":"center"});
            }else{
                createChart(data);
            }
        }
    });
});

function createChart(data) {
    var chart = AmCharts.makeChart("chartdiv", {
        "type": "serial",
        "theme": "light",
        "precision": 2,
        "valueAxes": [{
            "id": "v1",
            // "title": "Volume",
            "position": "left",
            "autoGridCount": false

        }, {
            "id": "v2",
            //"title": "Market Days",
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
            "legendValueText": "$[[value]]M",
            "balloonText": "[[title]]<br /><b style='font-size: 130%'>[[value]]</b>"
        }, {
            "id": "g1",
            "balloonText": "Open:<b>[[open]]</b><br>Low:<b>[[low]]</b><br>High:<b>[[high]]</b><br>Close:<b>[[close]]</b><br>",
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
            "valueField": "close"
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

};



