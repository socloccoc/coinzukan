$(document).ready(function () {
  var url_string = window.location.href;
  var url = new URL(url_string);
  var market = url.searchParams.get("market");
  var target = url.searchParams.get("target")

  var segments = location.href.split( '/' );

  var url = "/ajax/getDataChartImage";
  $.ajax({
    url: url,
    type: "GET",
    cache: false,
    data: {'market': market, 'target' : target,'segments':segments[4]},
    success: function (data) {
      console.log(data);
      data[1].forEach(function (element, index) {
        if ($('#container_' + data[0][index][0] + '_' + data[0][index][1]).length > 0) {
          createChart(element, data[0][index][0], data[0][index][1]);
        }
      });
    }
  });

  function createChart(data, market_id, pair_id) {
    Highcharts.stockChart('container_' + market_id + '_' + pair_id, {

      chart: {
        type: 'spline'
      },

      xAxis: {
        type: 'datetime',
        labels: {
          enabled: false
        }
      },

      yAxis: {
        labels: {
          enabled: false
        },
        title: {
          text: ''
        }
      },

      scrollbar: {
        enabled: false
      },

      navigator: {
        enabled: false
      },

      title: {
        text: ''
      },

      rangeSelector: {
        enabled: false
      },

      credits: {
        enabled: false
      },

      series: [{
        name: ' ',
        data: data,
        tooltip: {
          valueDecimals: 2
        }
      }],

      plotOptions: {
        spline: {
          lineWidth: 20
        }
      }

    });

    var chart = $('#container_' + market_id + '_' + pair_id).highcharts();
    svg = chart.getSVG({chart: {width: chart.chartWidth, height: chart.chartHeight}});
    svg = "data:image/svg+xml,"+svg;
    var base_image = new Image();
    base_image.src = svg;
    $('#image_' + market_id + '_' + pair_id).attr('src',svg);

  }

});