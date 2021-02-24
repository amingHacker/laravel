@extends('mainlayout.layouts.master')

@section('content')  

{{-- Include CSS Start --}}
{{-- Local Source  --}}
<link rel="stylesheet" type="text/css" href="{{asset('css/jqgrid/jquery-ui-custom.css')}}" >
<link rel="stylesheet" type="text/css" href="{{asset('css/jqgrid/ui.jqgrid.css')}}" >
<link rel="stylesheet" type="text/css" href="{{asset('css/jqgrid/ui.multiselect.css')}}" >
<link rel="stylesheet" type="text/css" href="{{asset('css/jqgrid/jquery-ui-timepicker-addon.css')}}" >
<link rel="stylesheet" type="text/css" href="{{asset('css/jQueryUI/Sampling_Records.css')}}" >
<link rel="stylesheet" type="text/css" href="{{asset('css/jQueryUI/Template.css')}}" >
{{-- Include CSS End --}}


{{-- Include Jqgrid Start --}}
    {{-- Local Source --}}
<script src="{{asset('js/jqgrid/jquery-1.11.3.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jqgrid/jquery-ui-custom.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jqgrid/jquery.layout.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jqgrid/grid.locale-tw.js')}}"></script>
<script type="text/javascript">$.jgrid.no_legacy_api = true;$.jgrid.useJSON = true;</script>
<script type="text/javascript" src="{{asset('js/jqgrid/ui.multiselect.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jqgrid/jquery.jqGrid.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jqgrid/jquery.tablednd.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jqgrid/jquery.contextmenu.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jqgrid/fixFrozenDivs.js')}}"></script>
{{-- Include Jqgrid End --}}


{{-- Include excelExport Start--}}
    <!--使用JS-XLSX操作xlsx-->
<script type="text/javascript" src="{{asset('js/tableexport/xlsx.core.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/tableexport/xlsxStyle.core.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/tableexport/xlsxStyle.utils.js')}}"></script>
<script type="text/javascript" src="{{asset('js/tableexport/xlsxImport.js')}}"></script>
<script type="text/javascript" src="{{asset('js/tableexport/xlsxExport.js')}}"></script>

    <!--使用FileSaver下載資料成為檔案-->
<script type="text/javascript" src="{{asset('js/tableexport/FileSaver.min.js')}}"></script>
{{-- Include excelExport End --}}

{{-- Include combobox, DatePicker Start --}}
    {{-- 使用擴充的datePicker --}}
<script type="text/javascript" src="{{asset('js/jqgrid/jquery-ui-timepicker-addon.js')}}"></script>  

    {{-- jQWidgets --}}
<link rel="stylesheet" type="text/css" href="{{asset('css/jQWidget/jqx.base.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('css/jQWidget/jqx.bootstrap.css')}}" />

<script type="text/javascript" src="{{asset('js/jQWidget/jqxcore.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jQWidget/jqxcombobox.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jQWidget/jqxscrollbar.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jQWidget/jqxlistbox.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jQWidget/jqxbuttons.js')}}"></script>

<script type="text/javascript" src="{{asset('js/jQWidget/jqxdropdownlist.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jQWidget/jqxinput.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jQWidget/jqxtoolbar.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jQWidget/jqxdata.js')}}"></script>

{{-- Include combobox, DatePicker End --}}

{{-- ajax同步 This is for es5 (ie11)--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.4/bluebird.min.js"></script>


{{-- 圖表生成 Chart.js Start--}}
<script type="text/javascript" src="{{asset('js/chart/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/chart/Chart.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/chart/utils.js')}}"></script>
{{-- 圖表生成 Chart.js End --}}

{{-- Data to Chart Start--}}
<script type="text/javascript" src="{{asset('js/ChartProduce/CheckChart.js')}}"></script>
{{-- Data to Chart End--}}

{{-- ToolBar Start--}}
<script type="text/javascript" src="{{asset('js/ToolBarProduce/ToolBar.js')}}"></script>
{{-- ToolBar End--}}

{{-- RightClick Action Start--}}
<script type="text/javascript" src="{{asset('js/RightClick/RightClick.js')}}"></script>
{{-- RightClick Action End--}}

{{-- ContainerInput Start--}}
<script type="text/javascript" src="{{asset('js/ContainerInput/ContainerInput.js')}}"></script>
{{-- ContainerInput End--}}

{{-- CSS設定 Start--}}
<style type="text/css">
    .ui-jqgrid-hdiv { overflow-y: hidden; }
    .ui-tabs
    {
        width:72%;
    }
    /* .img-responsive{
        width:100px;
    }
    @media screen and (min-width:900px){
        .img-responsive{
            width:768px;
        }
    } */

    .jqx-dropdownlist-content { font-size : 26px;}
    .jqx-listitem-state-selected { font-size : 26px; }
    .jqx-listitem-state-normal {font-size : 26px; }
    .btn-space{
        width:120px;
        height: 50px;

    }
</style>

{{-- CSS設定 End --}}
{{-- Translate --}}
<script type="text/javascript">
    
    /* 輸入中文 Name 輸出英文 Name*/
    function getColumnNameFromChineseToDatabase(ColumnName)
    {
        var Result = '';
         //舊key到新key的映射，colName的轉換
        var oldkey = {
            "清洗": "Clean",
            "組裝測試": "Assemblingtest",  
            "壓降測漏": "CPD",
            "PP測試": "Pumppurgetest",
            "RGA測試": "RGAtest",
            "熱氮氣": "Hotn2",
            "日期":"working_date",
            "型號":"container_model",
            "瓶號":"bottle_number",
            "導電度":"conductivity_test",
            "設備極限":"equipment_limit",
            "烘箱溫度":"oven_temperature",
            "烘箱時間":"oven_time",
            "開始時間":"start_time",
            "結束時間":"end_time",
            "M1-Fail紀錄":"M1_fail",
            "M2-Fail紀錄":"M2_fail",
            "A1-Fail紀錄":"A1_fail",
            "A2-Fail紀錄":"A2_fail",
            "A3-Fail紀錄":"A3_fail",
            "管路校正":"pipe_calibration",
            "管路校正-Fail紀錄":"calibration_fail",
            "By pass-1":"bypass_1",
            "By pass-2":"bypass_2",
            "By pass-Fail紀錄":"bypass_fail",
            "Body-1":"body_1",
            "Body-2":"body_2",
            "Body-Fail紀錄":"body_fail",
            "VCR":"vcr",
            "Fill Port":"fill_port",
            "VCR-Fail紀錄":"vcr_fail",
            "Fill Port-Fail紀錄":"fill_port_fail",
            "M1 Valve":"M1_valve",
            "M2 Valve":"M2_valve",
            "A1 Valve":"A1_valve",
            "A2 Valve":"A2_valve",
            "A3 Valve":"A3_valve",
            "M1 Valve-Fail紀錄":"M1_valve_fail",
            "M2 Valve-Fail紀錄":"M2_valve_fail",
            "A1 Valve-Fail紀錄":"A1_valve_fail",
            "A2 Valve-Fail紀錄":"A2_valve_fail",
            "A3 Valve-Fail紀錄":"A3_valve_fail", 
            "In-1":"IN_1",
            "In-2":"IN_2",
            "In-1-Fail紀錄":"IN_1_fail", 
            "In-2-Fail紀錄":"IN_2_fail",
            "OUT-Fail紀錄":"OUT_fail",
            "Pump":"pump",
            "花費時間":"spend_time",
            "循環":"cycle",
            "真空值":"vacuum_value",
            "真空極限":"vacuum_equipment_limit",
            "丙酮":"Acetone",
            "戊烷":"Pentane",
            "質譜儀極限":"spectro_equipment_limit",
            "質譜儀SPEC":"spectro_equipment_spec",
            "露點值":"dew_point",
            "露點計極限":"dew_point_equipment_limit",
            "露點計SPEC":"dew_point_equipment_spec",
            "含水量":"water_content",
            "露點計極限(轉換)":"dew_point_equipment_limit_trans",
            "露點計SPEC(轉換)":"dew_point_equipment_spec_trans",       
            "建立時間" : "created_at",
            "更新時間" : "updated_at" ,
        };
        for(var key in oldkey)
        {        
            if (ColumnName == key)
            {
                Result = oldkey[key];
            }
        }
        return Result = (Result == '')?  ColumnName : Result;
    }

    /* 輸入英文 Name 輸出中文 Name*/
    function getColumnNameFromDatabaseToChinese(ColumnName)
    {
        var Result = '';
         //舊key到新key的映射，colName的轉換
        var oldkey = {
            "Clean":"清洗",
            "Assemblingtest":"組裝測試",   
            "CPD":"壓降測漏",
            "Pumppurgetest":"PP測試",
            "RGAtest":"RGA測試",
            "Hotn2":"熱氮氣",
            "working_date": "日期",
            "container_model":"型號",
            "bottle_number":"瓶號",
            "conductivity_test":"導電度",
            "equipment_limit":"設備極限",
            "oven_temperature":"烘箱溫度",
            "oven_time":"烘箱時間",
            "start_time":"開始時間",
            "end_time":"結束時間",
            "M1_fail":"M1-Fail紀錄",
            "M2_fail":"M2-Fail紀錄",
            "A1_fail":"A1-Fail紀錄",
            "A2_fail":"A2-Fail紀錄",
            "A3_fail":"A3-Fail紀錄",
            "pipe_calibration":"管路校正",
            "calibration_fail":"管路校正-Fail紀錄",
            "bypass_1":"By pass-1",
            "bypass_2":"By pass-2",
            "bypass_fail":"By pass-Fail紀錄",
            "body_1":"Body-1",
            "body_2":"Body-2",
            "body_fail":"Body-Fail紀錄",
            "vcr":"VCR",
            "fill_port":"Fill Port",
            "vcr_fail":"VCR-Fail紀錄",
            "fill_port_fail":"Fill Port-Fail紀錄",
            "M1_valve":"M1 Valve",
            "M2_valve":"M2 Valve",
            "A1_valve":"A1 Valve",
            "A2_valve":"A2 Valve",
            "A3_valve":"A3 Valve",
            "M1_valve_fail":"M1 Valve-Fail紀錄",
            "M2_valve_fail":"M2 Valve-Fail紀錄",
            "A1_valve_fail":"A1 Valve-Fail紀錄",
            "A2_valve_fail":"A2 Valve-Fail紀錄",
            "A3_valve_fail":"A3 Valve-Fail紀錄", 
            "IN_1":"In-1",
            "IN_2":"In-2",
            "IN_1_fail":"In-1-Fail紀錄", 
            "IN_2_fail":"In-2-Fail紀錄",
            "OUT_fail":"OUT-Fail紀錄",
            "pump":"Pump",
            "spend_time":"花費時間",
            "cycle":"循環",
            "vacuum_value":"真空值",
            "vacuum_equipment_limit":"真空極限",
            "Acetone":"丙酮",
            "Pentane":"戊烷",
            "spectro_equipment_limit":"質譜儀極限",
            "spectro_equipment_spec":"質譜儀SPEC",
            "dew_point": "露點值",
            "dew_point_equipment_limit":"露點計極限",
            "dew_point_equipment_spec":"露點計SPEC",
            "water_content":"含水量",
            "dew_point_equipment_limit_trans":"露點計極限(轉換)",
            "dew_point_equipment_spec_trans":"露點計SPEC(轉換)",               
            "created_at":"建立時間",
            "updated_at":"更新時間",
        };
        for(var key in oldkey)
        {        
            if (ColumnName == key)
            {
                Result = oldkey[key];
            }
        }
        return Result = (Result == '')?  ColumnName : Result;
    }
</script>

{{-- Data資料呈現 Start --}}
<script type="text/javascript">


    $(document).ready(function () {      
      
        getAuthority();
        var _StationType = ["清洗", "PP測試", "熱氮氣"];
        //站別
        $("#jqxcombobox_Station").jqxComboBox({ source: _StationType, arrowSize: 50, selectedIndex: -1, 
            width: '50%', height: '50', autoDropDownHeight: true });
        $("#jqxcombobox_Station").bind('select', function (event) {
                var args = event.args;
                var item = $('#jqxcombobox_Station').jqxComboBox('getItem', args.index);
                ShowContainerSelect(getColumnNameFromChineseToDatabase(item.label));  
            });  
        jqxComboBox_font_size('Station', 26); // font-size: 26px;
        
        var _BottleNumber = ["X12345", "X54321", "X67890"];
        //瓶號
        $("#jqxcombobox_Bottle").jqxComboBox({ source: _BottleNumber, arrowSize: 50, selectedIndex: -1, width: '50%', height: '50' });
        jqxComboBox_font_size('Bottle', 26); // font-size: 26px;
        $("#jqxcombobox_Bottle").bind('select', function (event) {
                var args = event.args;
                var item = $('#jqxcombobox_Bottle').jqxComboBox('getItem', args.index);
                ShowContainerStatus(item.label);  
            });  
        
    });
    

    function getAuthority(){
        var User = "<?php echo $_SERVER['REMOTE_USER']; ?>";
        var Authority = '';
        $.ajax({
            async:false,
            url: "SamplingRecord/GetAuthority",//路徑
            type: "Get",
            data:
                {
                    "User": User,
                },
        }).done(function(data){
            Authority = data.success[0];
            if (Authority == undefined || Authority[""])
            {
               
            }
            else
            {
               
            }
        });
    }

    /*動態調整圖片大小*/
    function WinResize() { 
        var newWidth;
        //根據視窗大小調整圖片大小
        newWidth = document.documentElement.clientWidth;
        if (newWidth <= 0) {
            newWidth = 0;
        }
        //由於設定關係，寬度受到變動時，高度也會跟著改變
        // document.getElementById("pageImg").width = newWidth * 0.513;    
    }
    
    // $(function()
    //     {
    //         window.onresize = WinResize();
    //         window.onload= WinResize();
    //     }
    // );

    // function jqxComboBox_select() {
    //     $('#jqxcombobox_Station').parent().find('[type="textarea"]').select();
    // }
    function jqxComboBox_font_size(id, size) {
        $('#jqxcombobox_' + id).parent().find('[type="textarea"]').css('font-size', size + 'px');
    }
    // function jqxComboBox_font_family() {
    //     $('#jqxcombobox_Station').parent().find('[type="textarea"]').css('font-family', font);
    // } 

</script>

{{-- Data資料呈現 End --}}
 
<meta name="csrf-token" content="{{ csrf_token() }}"> 
    <h1 class="my-2"></h1>
    <div style = "margin:0px auto;"  >
        <img class="img-responsive" id = "pageImg" src="img/Logo_ContainerInput.png" >   
    </div>
   
    <div align="center">
        <input type="BUTTON" class="btn btn-outline-info btn-space" disabled="disabled" id="Station1" style="display: " value="1.維修室" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" disabled="disabled" id="Station2" style="display: " value="2.清洗室" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" disabled="disabled" id="Station3" style="display: " value="3.HF室" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" disabled="disabled" id="Station4" style="display: " value="4.無塵室" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" disabled="disabled" id="Station5" style="display: " value="5.無塵室" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" disabled="disabled" id="Station6" style="display: " value="6.無塵室" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" disabled="disabled" id="Station7" style="display: " value="7.無塵室" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" disabled="disabled" id="Station8" style="display: " value="8.無塵室" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" disabled="disabled" id="Station9" style="display: " value="9.無塵室" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" disabled="disabled" id="Station10" style="display: " value="10.無塵室" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" disabled="disabled" id="Station11" style="display: " value="11.無塵室" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" disabled="disabled" id="Station12" style="display: " value="12.無塵室" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" disabled="disabled" id="Station13" style="display: " value="13.無塵室" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" disabled="disabled" id="Station14" style="display: " value="14.分裝作業" />

        <div style = "margin:0px auto"><h3>瓶號:</h3></div>
        <div style = "margin:0px auto;" id="jqxcombobox_Bottle" ></div>
        <h1 class="my-4"></h1>

        <div style = "margin:0px auto"><h3>站別:</h3></div>
        <div style = "margin:0px auto;" id="jqxcombobox_Station" ></div>
        <h1 class="my-4"></h1>
        
        <div id = "InputForm"></div>
        <h1 class="my-4"></h1>
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="Sure" style="display: " value="確定" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="Cancel" style="display: " value="取消" />     
    </div>
    <h1 class="my-4"></h1>
@endsection
