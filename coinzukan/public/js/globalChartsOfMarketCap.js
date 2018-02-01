$(document).ready(function () {
  var locale = $('input[name="locale_name"]').val();
  var market_cap_text = $('input[name="market_cap"]').val();
  var volume_24h_text = $('input[name="24h_volume"]').val();
  var percentage_of_total_market_cap = $('input[name="percentage_of_total_market_cap"]').val();
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

    var url = "/ajax/marketcapGlobalChartData";

    $.ajax({
        url: url,
        type: "GET",
        cache: false,
        data: {"coinName": "Bitcoin"},
        success: function (data) {
            createTotalMarketCapitalizationChart(data[0]);
            createExcludingBitcoinChart(data[1]);
            createTotalMarketCapitalizationDominanceChart(data[2]);
        }
    });

    /**
     * Create the chart when all data is loaded
     * param data = [marketcap, price_usd, price_btc, volume24h]
     * @returns {undefined}
     */
    function createTotalMarketCapitalizationChart(data) {
        Highcharts.stockChart('total-market-capitalization', {

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

            },{
                marginRight: 80,
                type: 'column',
                name: '24h Vol ',
                data: data[1],
                yAxis: 1,
                color: '#333'

            }]

        });
    }

    function createExcludingBitcoinChart(data) {
        Highcharts.stockChart('excluding-bitcoin', {

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

            },{
                marginRight: 80,
                type: 'column',
                name: '24h Vol ',
                data: data[1],
                yAxis: 1,
                color: '#333'

            }]

        });
    }

    function createTotalMarketCapitalizationDominanceChart(data) {
        Highcharts.stockChart('total-market-capitalization-dominance', {

            legend: {
                enabled: true
            },

            yAxis: {
                labels: {
                    formatter: function () {
                        return (this.value > 0 ? ' + ' : '') + this.value + '%';
                    }
                },

                title: {
                    text: percentage_of_total_market_cap,
                    style: {
                        color: '#7cb5ec'
                    }
                },

                opposite: false,
            },

            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.change}%)<br/>',
                valueDecimals: 2,
                split: false,
                shared: true
            },

            series: [{
                type:'area',
                name: 'Bitcoin',
                data: data[0],

            },{
                type:'area',
                name: 'Ethereum',
                data: data[1],

            },{
                type:'area',
                name: 'Bitcoin Cash',
                data: data[2],
                yAxis: 0

            },{
                type:'area',
                name: 'Litecoin',
                data: data[3],
                yAxis: 0

            },{
                type:'area',
                name: 'Ripple',
                data: data[4],
                yAxis: 0

            },{
                type:'area',
                name: 'Dash',
                data: data[5],
                yAxis: 0

            },{
                type:'area',
                name: 'Donero',
                data: data[6],
                yAxis: 0

            },{
                type:'area',
                name: 'Nem',
                data: data[7],
                yAxis: 0

            },{
                type:'area',
                name: 'Iota',
                data: data[8],
                yAxis: 0

            },{
                type:'area',
                name: 'Neo',
                data: data[9],
                yAxis: 0

            },{
                type:'area',
                name: 'Others',
                data: data[10],
                yAxis: 0

            }]

        });
    }



});