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
<script>
    var config = {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                label: 'My First dataset',
                backgroundColor: window.chartColors.red,
                borderColor: window.chartColors.red,
                data: [10, 30, 39, 20, 25, 34, -10],
                fill: false,
            }, {
                label: 'My Second dataset',
                fill: false,
                backgroundColor: window.chartColors.blue,
                borderColor: window.chartColors.blue,
                data: [18, 33, 22, 19, 11, 39, 30],
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Grid Line Settings'
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        drawBorder: false,
                        color: ['pink', 'red', 'orange', 'yellow', 'green', 'blue', 'indigo', 'purple']
                    },
                    ticks: {
                        min: 0,
                        max: 100,
                        stepSize: 10
                    }
                }]
            }
        }
    };

    window.onload = function() {
        var ctx = document.getElementById('canvas').getContext('2d');
        window.myLine = new Chart(ctx, config);
    };
</script>
    

@endsection
