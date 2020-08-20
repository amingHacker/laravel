@extends('mainlayout.layouts.master-fixbar')

@section('content')  

{{-- Include CSS Start --}}
{{-- <link rel="stylesheet" type="text/css" media="screen" href="http://trirand.com/blog/jqgrid/themes/redmond/jquery-ui-custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="http://trirand.com/blog/jqgrid/themes/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="http://trirand.com/blog/jqgrid/themes/ui.multiselect.css" /> --}}
    {{-- Local Source  --}}
<link rel="stylesheet" type="text/css" href="{{asset('css/jqgrid/jquery-ui-custom.css')}}" >
<link rel="stylesheet" type="text/css" href="{{asset('css/jqgrid/ui.jqgrid.css')}}" >
<link rel="stylesheet" type="text/css" href="{{asset('css/jqgrid/ui.multiselect.css')}}" >
{{-- Include CSS End --}}


{{-- Include JavaScript Start --}}
 <!--使用jQuery操作dom-->
{{-- <script src="http://trirand.com/blog/jqgrid/js/jquery.js" type="text/javascript"></script> --}}
{{-- <script src="http://trirand.com/blog/jqgrid/js/jquery-ui-custom.min.js" type="text/javascript"></script> --}}
{{-- <script src="http://trirand.com/blog/jqgrid/js/jquery.layout.js" type="text/javascript"></script> --}}
{{-- <script src="http://www.ytjh.ylc.edu.tw/language/tw/plugins/jqgrid/js/i18n/grid.locale-tw.js" type="text/javascript"></script> --}}
{{-- <script type="text/javascript">
	$.jgrid.no_legacy_api = true;
	$.jgrid.useJSON = true;
</script> --}}
{{-- <script src="http://trirand.com/blog/jqgrid/js/ui.multiselect.js" type="text/javascript"></script> --}}
{{-- <script src="http://trirand.com/blog/jqgrid/js/jquery.jqGrid.js" type="text/javascript"></script> --}}
{{-- <script src="http://trirand.com/blog/jqgrid/js/jquery.tablednd.js" type="text/javascript"></script> --}}
{{-- <script src="http://trirand.com/blog/jqgrid/js/jquery.contextmenu.js" type="text/javascript"></script> --}}

    {{-- Local Source --}}
<script type="text/javascript" src="{{asset('js/jqgrid/jquery.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jqgrid/jquery-ui-custom.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jqgrid/jquery.layout.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jqgrid/grid.locale-tw.js')}}"></script>
<script type="text/javascript">$.jgrid.no_legacy_api = true;$.jgrid.useJSON = true;</script>
<script type="text/javascript" src="{{asset('js/jqgrid/ui.multiselect.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jqgrid/jquery.jqGrid.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jqgrid/jquery.tablednd.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jqgrid/jquery.contextmenu.js')}}"></script>
{{-- Include JavaScript End --}}

{{-- Include excelExport --}}

    <!--使用JS-XLSX操作xlsx-->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.2/xlsx.full.min.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.2/xlsx.core.min.js"></script> --}}
<script type="text/javascript" src="{{asset('js/tableexport/xlsx.core.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/tableexport/xlsxStyle.core.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/tableexport/xlsxStyle.utils.js')}}"></script>
<script type="text/javascript" src="{{asset('js/tableexport/xlsxImport.js')}}"></script>
<script type="text/javascript" src="{{asset('js/tableexport/xlsxExport.js')}}"></script>

    <!--使用FileSaver下載資料成為檔案-->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.3/FileSaver.min.js"></script> --}}
<script type="text/javascript" src="{{asset('js/tableexport/FileSaver.min.js')}}"></script>
{{-- include end --}}


{{-- 圖表生成 Chart.js Start--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
<script src="https://www.chartjs.org/dist/2.9.3/Chart.min.js"></script>
<script src="https://www.chartjs.org/samples/latest/utils.js"></script>
{{-- 圖表生成 Chart.js End --}}

<style type="text/css">
    /*預設已是overflow:auto，寫在網頁裡再次確保會出現scroller*/
     .ui-jqgrid .ui-jqgrid-bdiv {
       overflow:auto; 
     }
</style>
{{-- CSS設定 Start--}}

    <style>
         img { 
             max-width: 100%; 
             height: auto; 
             margin:auto; 
             display: block; 
         }  
         body,button, input, select, textarea,h1 ,h2, h3, h4, h5, h6 
         { font-family:  微軟正黑體, Tahoma, Helvetica, Arial, "\5b8b\4f53", sans-serif;}
        .ui-jqgrid {
            font-size: 1em;
        }
        .ui-jqgrid .ui-jqgrid-title{font-size:1.2em;}    /*修改grid標題字體大小*/
        
        .ui-jqgrid .ui-jqgrid-htable th {
                height: 2em !important;
        }
        .ui-jqgrid tr.jqgrow td{
                height: 2em !important;
                font-family:"Times New Roman", 微軟正黑體;
        }

    </style>

{{-- CSS設定 End --}}

<div style="width:75%;">
    <canvas id="canvas"></canvas>
</div>
<br>
<br>
<button id="randomizeData">Randomize Data</button>
<button id="addData">Add Data</button>
<button id="removeData">Remove Data</button>


<script>

    //var ctx = document.getElementById('canvas').getContext('2d');
    var xMap = ["January", "February", "March", "April", "May", "June", "July"];
    var yMap = ['Request Added', 'Request Viewed', 'Request Accepted', 'Request Solved', 'Solving Confirmed'];

    var mapDataPoint = function(xValue, yValue) {
        return {
            x: xMap.indexOf(xValue),
            y: yMap.indexOf(yValue)
        };
    };

    var ctx2 = document.getElementById("canvas").getContext("2d");
    var myLine2 = new Chart(ctx2, {
    type: 'line',
        data: {
            datasets: [{
            label: "My First dataset",
            data: [
                mapDataPoint("January", "Request Added"),
                mapDataPoint("February", "Request Viewed"),
                mapDataPoint("February", "Request Accepted"),
                mapDataPoint("March", "Request Added"),
                mapDataPoint("March", "Request Accepted"),
            ],
            fill: false,
            showLine: false,
            borderColor: chartColors.red,
            backgroundColor: chartColors.red
            }]
        },
        options: {
            responsive: true,
            title: {
            display: true,
            text: 'Chart.js - Scatter Chart Mapping X and Y to Non Numeric'
            },
            legend: {
            display: false
            },
            scales: {
            xAxes: [{
                type: 'linear',
                position: 'bottom',
                scaleLabel: {
                display: true,
                labelString: 'Month'
                },
                ticks: {
                min: 0,
                max: xMap.length - 1,
                callback: function(value) {
                        return xMap[value];
                    },
                },
            }],
            yAxes: [{
                scaleLabel: {
                display: true,
                labelString: 'Request State'
                },
                ticks: {
                reverse: true,
                min: 0,
                max: yMap.length - 1,
                callback: function(value) {
                    return yMap[value];
                },
                },
            }]
            }
        }
    });

    var ppp = 0;
    // var horizonalLinePlugin = {
    //     afterDraw: function(chartInstance) 
    //     {
    //         var yScale = chartInstance.scales["y-axis-0"];
    //         var canvas = chartInstance.chart;
    //         var ctx = canvas.ctx;
    //         var index;
    //         var line;
    //         var style;

    //         if (chartInstance.options.horizontalLine) {
    //         for (index = 0; index < chartInstance.options.horizontalLine.length; index++) {
    //             line = chartInstance.options.horizontalLine[index];

    //             if (!line.style) {
    //             style = "rgba(169,169,169, .6)";
    //             } else {
    //             style = line.style;
    //             }

    //             if (line.y) {
    //             yValue = yScale.getPixelForValue(line.y);
    //             } else {
    //             yValue = 0;
    //             }

    //             ctx.lineWidth = 3;

    //             if (yValue) {
    //             ctx.beginPath();
    //             ctx.moveTo(0, yValue);
    //             ctx.lineTo(canvas.width, yValue);
    //             ctx.strokeStyle = style;
    //             ctx.stroke();
    //             }

    //             if (line.text) {
    //             ctx.fillStyle = style;
    //             ctx.fillText(line.text, 0, yValue + ctx.lineWidth);
    //             }
    //         }
    //         return;
    //         };
    //     }
    // };
    //     Chart.pluginService.register(horizonalLinePlugin);

    //     var data = {
    //         labels: ["January", "February", "March", "April", "May", "June", "July"],
    //         datasets: [{
    //             label: "My First dataset",
    //             fill: false,
    //             lineTension: 0.1,
    //             backgroundColor: "rgba(75,192,192,0.4)",
    //             borderColor: "rgba(75,192,192,1)",
    //             borderCapStyle: 'butt',
    //             borderDash: [],
    //             borderDashOffset: 0.0,
    //             borderJoinStyle: 'miter',
    //             pointBorderColor: "rgba(75,192,192,1)",
    //             pointBackgroundColor: "#fff",
    //             pointBorderWidth: 1,
    //             pointHoverRadius: 5,
    //             pointHoverBackgroundColor: "rgba(75,192,192,1)",
    //             pointHoverBorderColor: "rgba(220,220,220,1)",
    //             pointHoverBorderWidth: 2,
    //             pointRadius: 1,
    //             pointHitRadius: 10,
    //             data: [65, 59, 80, 81, 56, 55, 40],
    //         }]
    //     };

    //     var myChart = new Chart(ctx, {
    //         type: 'line',
    //         data: data,
    //         options: {
    //             "horizontalLine": 
    //             [
    //                 {
    //                     "y": 99.7,
    //                     "style": "rgba(255, 0, 0, .4)",
    //                     "text": "max"
    //                 }, 
    //                 {
    //                     "y": 99.6,
    //                     "style": "#00ffff",
    //                 }, 
    //                 {
    //                     "y": 99.3,
    //                     "text": "min"
    //                 }
    //             ]
    //         }
    //     });



    // function newDate(days) {
    //     return moment().add(days, 'd').toDate();
    // }

    // function newDateString(days) {
    //     return moment().add(days, 'd').format();
    // }

    // var color = Chart.helpers.color;
    // var config = {
    //     type: 'line',
    //     data: {
    //         datasets: [{
    //             label: 'Dataset with string point data',
    //             backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
    //             borderColor: window.chartColors.red,
    //             fill: false,
    //             data: [{
    //                 x: newDateString(0),
    //                 y: randomScalingFactor()
    //             }, {
    //                 x: newDateString(2),
    //                 y: randomScalingFactor()
    //             }, {
    //                 x: newDateString(4),
    //                 y: randomScalingFactor()
    //             }, {
    //                 x: newDateString(5),
    //                 y: randomScalingFactor()
    //             }],
    //         }, {
    //             label: 'Dataset with date object point data',
    //             backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
    //             borderColor: window.chartColors.blue,
    //             fill: false,
    //             data: [{
    //                 x: newDate(0),
    //                 y: randomScalingFactor()
    //             }, {
    //                 x: newDate(2),
    //                 y: randomScalingFactor()
    //             }, {
    //                 x: newDate(4),
    //                 y: randomScalingFactor()
    //             }, {
    //                 x: newDate(5),
    //                 y: randomScalingFactor()
    //             }]
    //         }]
    //     },
    //     options: {
    //         responsive: true,
    //         title: {
    //             display: true,
    //             text: 'Chart.js Time Point Data'
    //         },
    //         scales: {
    //             xAxes: [{
    //                 type: 'time',
    //                 display: true,
    //                 scaleLabel: {
    //                     display: true,
    //                     labelString: 'Date'
    //                 },
    //                 ticks: {
    //                     major: {
    //                         fontStyle: 'bold',
    //                         fontColor: '#FF0000'
    //                     }
    //                 }
    //             }],
    //             yAxes: [{
    //                 display: true,
    //                 scaleLabel: {
    //                     display: true,
    //                     labelString: 'value'
    //                 }
    //             }]
    //         }
    //     }
    // };

    // window.onload = function() {
    //     var ctx = document.getElementById('canvas').getContext('2d');
    //     window.myLine = new Chart(ctx, config);
    // };

    // document.getElementById('randomizeData').addEventListener('click', function() {
    //     config.data.datasets.forEach(function(dataset) {
    //         dataset.data.forEach(function(dataObj) {
    //             dataObj.y = randomScalingFactor();
    //         });
    //     });

    //     window.myLine.update();
    // });
    // document.getElementById('addData').addEventListener('click', function() {
    //     if (config.data.datasets.length > 0) {
    //         config.data.datasets[0].data.push({
    //             x: newDateString(config.data.datasets[0].data.length + 2),
    //             y: randomScalingFactor()
    //         });
    //         config.data.datasets[1].data.push({
    //             x: newDate(config.data.datasets[1].data.length + 2),
    //             y: randomScalingFactor()
    //         });

    //         window.myLine.update();
    //     }
    // });

    // document.getElementById('removeData').addEventListener('click', function() {
    //     config.data.datasets.forEach(function(dataset) {
    //         dataset.data.pop();
    //     });

    //     window.myLine.update();
    // });
</script>
    

@endsection
