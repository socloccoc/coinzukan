$(document).ready(function () {
  var locale = $('input[name="locale_name"]').val();
  var market_cap_text = $('input[name="market_cap"]').val();
  var volume_24h_text = $('input[name="24h_volume"]').val();
  var price_text = $('input[name="price"]').val();
  if(locale == 'jp') {
    Highcharts.setOptions({
      lang: {
        shortMonths: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
        printChart: "打印图表",
        downloadPNG: '下载PNG图片',
        downloadJPEG: '下载JPEG图片',
        downloadPDF: '下载PDF文件',
        downloadSVG: '下载SVG矢量图',
        numericSymbols: ["k", "M", "十亿", "T", "P", "E"],
        thousandsSep: "",
        decimalPoint: ','
      },
      rangeSelector: {
        buttons: [
          {count: 1, type: 'day', text: '1 天'},
          {count: 7, type: 'day', text: '7 天'},
          {count: 1, type: 'month', text: '1个月'},
          {count: 3, type: 'month', text: '3个月'},
          {count: 1, type: 'year', text: '1年'},
          {count: 1, type: 'ytd', text: '至今'},
          {type: 'all', text: '全部'}
        ]
      }
    });
  }

  Highcharts.setOptions({
    rangeSelector: {
      buttons: [
        {count: 1, type: 'day', text: '1d'},
        {count: 7, type: 'day', text: '7d'},
        {count: 1, type: 'month', text: '1m'},
        {count: 3, type: 'month', text: '3m'},
        {count: 1, type: 'year', text: '1y'},
        {count: 1, type: 'ytd', text: 'YTD'},
        {type: 'all', text: 'ALL'}
      ]
    }
  });

  var segments = location.href.split('/');
  var url = "/ajax/chartOfMarketCapDetailPage";

  $.ajax({
    url: url,
    type: "GET",
    cache: false,
    data: {"coinName": segments[4].replace("%20", " ")},
    beforeSend: function () {
      $("#chartdiv").addClass("loadingchart");
    },

    success: function (data) {
      createChart(data);
    },

    complete: function () {
      $("#chartdiv").removeClass("loadingchart");
    }
  });

  /**
   * Create the chart when all data is loaded
   * param data = [marketcap, price_usd, price_btc, volume24h]
   * @returns {undefined}
   */
  function createChart(data) {
    enabled: true

    Highcharts.stockChart('divchart', {

      legend: {
        enabled: true
      },

      yAxis: [{

        title: {
          text: market_cap_text,
          style: {
            color: '#7cb5ec'
          }
        },

        opposite: false,
        height: '60%'
      }, {
        title: {
          text: price_text+' (USD) ',
          style: {
            color: '#009933'
          }
        },
        labels: {
          style: {
            color: '#009933'
          }
        },
        opposite: true,
        height: '60%'
      },
        {
          //gridLineWidth: 0,
          title: {
            text: price_text+' (BTC) ',
            style: {
              color: '#f7931a'
            }
          },
          labels: {
            style: {
              color: '#f7931a'
            }
          },
          opposite: true,
          height: '60%'

        },
        { // Tertiary yAxis
          gridLineWidth: 0,
          title: {
            text: volume_24h_text,
            style: {
              color: Highcharts.getOptions().colors[1]

            },
            x: 20
          },

          labels: {
            enabled: false
          },

          opposite: false,
          top: '65%',
          height: '35%'

        }],

      tooltip: {
        pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b><br/>',
        valueDecimals: 2,
        split: false,
        shared: true
      },

      series: [{
        name: market_cap_text,
        data: data[0],
        color: '#7cb5ec',
        yAxis: 0

      }, {
        name: price_text+' (USD) ',
        data: data[1],
        color: '#009933',
        yAxis: 1

      }, {
        name: price_text+' (BTC) ',
        data: data[2],
        color: '#f7931a',
        yAxis: 2

      }, {
        marginRight: 80,
        type: 'column',
        name: volume_24h_text,
        data: data[3],
        yAxis: 3,
        color: '#333'

      }]

    });
  }

});