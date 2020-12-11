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

{{-- CSS設定 Start--}}
<style type="text/css">
    .ui-jqgrid-hdiv { overflow-y: hidden; }
    .ui-tabs
    {
        width:72%;
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

    var Clean = @json($todosClean);
    var Assemblingtest = @json($todosAssemblingtest);
    var Outbound = @json($todosOutbound);
    var CPD = @json($todosCPD);
    var Inbound = @json($todosInbound);
    var Pumppurgetest = @json($todosPumppurgetest);
    var RGAtest = @json($todosRGAtest);
    var Hotn2 = @json($todosHotn2);
    var _todoList = {
            Clean: Clean,
            Assemblingtest: Assemblingtest, 
            Outbound: Outbound, 
            CPD: CPD, 
            Inbound: Inbound,
            Pumppurgetest: Pumppurgetest,
            RGAtest: RGAtest,
            Hotn2: Hotn2
        };
    var combobox_items = [];  //用來儲存colName內容選項

    $(document).ready(function () {      
        var i = 0;
        for(var _todoP in _todoList ){       
            ShowTable(_todoP, i);
            i++;
        }
        setTimeout(Showtab,1000);
        getAuthority();
        //test
        var _ChartTypeSource = ["Scatter Chart", "Control Chart"];
        var _xAxisSource = ["日期", "次數", "型號", "瓶號"];
        var _yAxisSource = ["導電度"];
        var _GroupSource = ["型號", "瓶號", "ALL"];
        //建立ToolBar
        var SPCSource = ['A1.超過3個標準差', 'A2.連續九點在中線同一側', 'A3.連續六點呈現上升或下降',
                            'A4.連續三點中的兩點落在2個標準差之外', 'A5.連續五點中的四點落在1個標準差之外',
                            'A6.區間最大最小值',
                        ];
        PrepareToToolbar(_ChartTypeSource, _xAxisSource, _yAxisSource, _GroupSource, SPCSource); 
        
        //獲得combobox的內容
        combobox_items = getComboboxItem();
    });
    
    /*****修改GridView欄位字體顏色*****/
    function addCellAttrUrgent(rowId, val, rawObject, cm, rdata) {
        
        if ( rdata["urgent"] == "TRUE")
        {
            var sty = "style='font-size:14px; background-color:#FF7777'"
            return sty;
        }
    }
    function addCellAttrID(rowId, val, rawObject, cm, rdata) {
        if(rawObject.planId == null )
        {
            var sty = "style='font-size:14px; color:blue'"
            return sty;
        }
    }
    function addCellAttr(rowId, val, rawObject, cm, rdata) {
        if(rawObject.planId == null )
        {
            var sty = "style='font-size:14px'"
            return sty;
        }
    }
    function Showtab () {
        $( "#Gridtabs" ).tabs();
    }

    function ShowTable(_todoP, i){
        setTimeout(function(){
        var colNames = [];
        var colModel = [];
        for ( var colName in _todoList[_todoP])
        {
            colNames.push(colName);
        }
    
        for ( var colName in _todoList[_todoP])
        {           
            if (colName === 'id')
            {           
                colModel.push(
                        {name:colName, index:colName, width:80, align:"center",sortable:true, sorttype:"int", frozen: true, editable:false, cellattr: addCellAttrID}
                    );
            }
            else if (colName === 'container_model' || colName === 'bottle_number')
            {
                colModel.push(
                    {
                        name:colName, index:colName, width:150, align:"center",sortable:true, editable:true, cellattr: addCellAttr, frozen: true,
                        stype:'text',
                        edittype:'custom', editoptions:
                        {
                            custom_element: combobox_elem, custom_value:combobox_value
                        }, 
                        stype:'custom', searchoptions:
                        {
                            custom_element: combobox_elem, custom_value:combobox_value                   
                        },
                    }
                );
            }
            else if (colName === 'working_date' || colName === 'start_time' || colName === 'end_time')
            {
                colModel.push(
                    {
                        name:colName, index:colName, width: 150, align:"center",sortable:true, editable:true, cellattr: addCellAttr,frozen: true,
                        sorttype: "date", edittype:'text', 
                        editoptions: 
                        {                       
                            dataInit: function (elem) 
                            {                                                                 
                                $(elem).datetimepicker(
                                    {
                                        autoclose:true,
                                        dateFormat: 'yy-mm-dd', 
                                        timeFormat: 'HH:mm:ss',                         
                                    }                             
                                );
                            },      
                        },
                        search:true,
                        searchoptions: {
                            sopt: ['eq','le','ge'],
                            dataInit : function (elem) 
                            {
                                var self = this;
                                $(elem).datepicker({
                                    dateFormat: 'yy-mm-dd',                                 
                                    changeYear: true,
                                    changeMonth: true,
                                    showOn: 'focus',
                                    autoclose:1
                                });
                            }
                        },                                   
                    }
                );
            }
            else if (colName === 'created_at' || colName === 'updated_at')
            {
                colModel.push({name:colName, index:colName, width:150, align:"center", editable:false, cellattr: addCellAttr});
            }
            else
            {
                colModel.push({name:colName, index:colName, align:"center", width:120, editable:true, cellattr: addCellAttr});
            }
        }

        for(var index in colNames)
        {     
            colNames[index] = getColumnNameFromDatabaseToChinese(colNames[index]);                
        }

        var table = "dg" + _todoP ;
        var jqgridWidth = parseInt($(window).width()) * 0.7;
        var gridCaption = getColumnNameFromDatabaseToChinese(_todoP);
        // 準備資料           
        $("#" + table).jqGrid({
            url:"ContainerRecord/show/"+_todoP,
            datatype: "json",        
            altrows:false,
            width: jqgridWidth,
            height:'100%',
            colNames:colNames,
            colModel:colModel,
            multiselect:false,
            rowNum:10,
            rowList:[10,20,50],
            pager: '#' + table + "pager",
            sortname: 'id',
            viewrecords: true,
            gridview: false,
            sortorder: "desc",
            caption: gridCaption,
            shrinkToFit :false,
            loadonce: false,          
            jsonReader : {
                            root: "dataList",
                            page: "currPage",
                            total: "totalPages",
                            records: "totalCount"                     
                        },
            prmNames : {
                            page:"pageNum", 
                            rows:"limit", 
                            order: "order",
                        },

            loadComplete: function (){ 
                fixPositionsOfFrozenDivs.call(this);
                
            }, // Fix column's height are different after enable frozen column feature
            gridComplete: function(){
                //根據瀏覽器寬度動態改變
                $(window).resize(function(){ 
                    var winwidth= parseInt($(window).width()) * 0.7;     
                    $("#" + table).jqGrid('setGridWidth', winwidth);
                });
            },                                                           
        }).jqGrid('setFrozenColumns'); 


        //增加Tool bar        
        $("#" + table).jqGrid('navGrid','#' + table + "pager", { search:true, edit:false, add:false, del:false, refresh:true } );
                
        //增加更多的搜尋條件
        $.extend($.jgrid.search, {
                    multipleSearch: true,
                    recreateFilter: true,
                    closeOnEscape: true,
                    searchOnEnter: true,
                    overlay: 1,
                    closeAfterSearch:true
                });
        //表格排序或隱藏       
        $("#" + table).jqGrid('navButtonAdd','#' + table + "pager",{
                caption: "",
                title: "表格排序",
                onClickButton : function (){
                $("#" + table).jqGrid('columnChooser');
                }
            });     
        //重新整理功能
        $('.ui-icon-refresh').click(function(){
            lastSearchData = null;
            //$("#load_" + table).show();
        });
    
        },i * 20);  
    }

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
                // if (Authority["ProductSPEC"] == 1)
                // {     
                    document.getElementById("New").style.display="";
                    document.getElementById("Save").style.display="";
                    document.getElementById("Cancel").style.display="";        
                    document.getElementById("Edit").style.display="";
                    document.getElementById("Delete").style.display=""; 
                    document.getElementById("Import").style.display="";
                    document.getElementById("ExportExcel").style.display="";
                //}            
            }
        });
    }

    /*初始化選單*/
    $(function() 
    {
        $( "#Chartmenu" ).menu();
        $( "#RightClickmenu" ).menu();

        $("#Gridtabs").tabs({
            select: function(event, ui) {
                //alert(ui.tab.innerHTML);
                ChangeToolbar(ui.tab.innerHTML);
                refreshGrid(ui.tab.innerHTML);
            }
        });
    });

    /*動態修改toolbar source*/
    function ChangeToolbar(process) {
        
        var SourceY = [], SourceCol = ["型號", "瓶號", "ALL"];
        switch (process) {
            case "清洗":
                SourceY = ["導電度"];
                break;
            case "組裝測試":
                SourceY = ["烘箱溫度", "烘箱時間"];
                break;
            case "Outbound":
                SourceY = ["M1", "M2", "A1", "A2", "A3", "M1-Fail紀錄", "M2-Fail紀錄", "A1-Fail紀錄", 
                "A2-Fail紀錄", "A3-Fail紀錄"];
                break;
            case "壓降測漏":
                SourceY = ["管路校正", "管路校正-Fail紀錄", "By pass-1", "By pass-2", "By pass-Fail紀錄", 
                "Body-1", "Body-2", "Body-Fail紀錄"];
                break;
            case "Inbound":
                SourceY = ["VCR", "Fill Port", "VCR-Fail紀錄", "Fill Port-Fail紀錄", "M1", "M2", 
                "A1", "A2", "A3", "M1-Fail紀錄", "M2-Fail紀錄", "A1-Fail紀錄", "A2-Fail紀錄",
                "A3-Fail紀錄", "M1 Valve", "M2 Valve", "A1 Valve", "A2 Valve", "A3 Valve",
                "M1 Valve-Fail紀錄", "M2 Valve-Fail紀錄", "A1 Valve-Fail紀錄", "A2 Valve-Fail紀錄", 
                "A3 Valve-Fail紀錄", "In-1", "In-2", "OUT", "In-1-Fail紀錄", "In-2-Fail紀錄", 
                "OUT-Fail紀錄"];
                break;
            case "PP測試":
                SourceY = ["Pump", "花費時間"];
                break;
            case "RGA測試":
                SourceY = ["真空值", "H2O", "N2", "O2", "CO2", "戊烷", "He"];
                break;
            case "熱氮氣":
                SourceY = ["露點值", "含水量"];
                break;
        }
        //修改ToolBary source
        var num_tabs = $("#tabs ul li").length + 1;
        for(var i = 1; i < num_tabs; i++)
        {
            destoryToolbar("jqxToolBar" + i, 8);
            destoryToolbar("jqxToolBar" + i, 7);
            destoryToolbar("jqxToolBar" + i, 6);
            destoryToolbar("jqxToolBar" + i, 5);
            
            addToolbar("jqxToolBar" + i, "combobox", "last", SourceY, true);
            addToolbar("jqxToolBar" + i, "toggle", "last", "Column:", false);
            addToolbar("jqxToolBar" + i, "combobox", "last", SourceCol, false);
            addToolbar("jqxToolBar" + i, "input", "last", "", false); 
        }
        
    }

    /*****切換tab標籤時重新整理Grid*****/
    function refreshGrid(process){
        var table = "dg" + getColumnNameFromChineseToDatabase(process) ;
        $('#' + table ).trigger( 'reloadGrid' );
    }

    /*****獲得item內容包含的方法*****/
    var selectItemJson; //用來存放item包含的值
    function getComboboxItem(){
        
        $.ajax({
            async:false,
            url: "ContainerRecord/GetComboboxItem",//路徑
            type: "Get",
            data:{    
            },

        }).done(function(data){
            selectItemJson = data;
        });
        
        return selectItemJson;
    }
    
    /*****設定欄位為combobox的方法*****/
    function combobox_elem(value, options)
    {   

        //value :目前cell裡的值
        //options : 此column的資訊
        
        // Create JQWidgets combobox
        var elem = $('<div id="' + (options.id) + '"></div>');
        
        // Calculate the "rowid" string length and remove "rowid" and "_" to get name
        //var name = options.id.substr(options.id.split("_")[0].length + 1);
        
        var name = options.name; //獲得column name

        if (name == undefined){name = options.searchColName;}
        
        // Get column width value and calculate for JQWidgets combobox
        var width = $("#dg_" + name).width() - 2;       
        
        // Get column width value and calculate for JQWidgets combobox
        var height = $("#dg_" + name).height() - 2;       

        if (width < 0 ){width = 120;}

        //Get items from combobox_items array 
        //獲得預選值的陣列
        var items = [];
        for (var i in combobox_items)
        {
            if(i == name)
            for(var j in combobox_items[i])
            {
                items.push(combobox_items[i][j][i])
            }
        }  
        // Get items amount to decide dropdown height to avoid autoDropDownHeight making list too long
        if (items.length > 7)
        {
            elem.jqxComboBox({source:items, searchMode: 'containsignorecase', width:width, height:20, theme:"energyblue", autoOpen:false, dropDownWidth:width, 
                dropDownHeight:210, autoComplete: true, openDelay:210, closeDelay:140});
        }
        else
        {     
            elem.jqxComboBox({source:items, searchMode: 'containsignorecase', width:width, height:20, theme:"energyblue", autoOpen:false, dropDownWidth:width, 
                autoDropDownHeight:true, autoComplete: true, openDelay:210, closeDelay:140});
        }
        
        //Set initial value as original value
        elem.jqxComboBox('val', value);
        
        return elem;
    }

    // jqGrid custom edit function to get Flexbox combobox value
    function combobox_value(elem)
    {
        // Check if elem is jqxComboBox and get value from input inside div
        // Because if jqxComboBox autoComplete set to true, it will not fill Null when input value wiped after selected items (forced to select first item)
        return elem.find("input").val();
    }

</script>

{{-- Data資料呈現 End --}}
 
<meta name="csrf-token" content="{{ csrf_token() }}"> 
    <h1 class="my-2"></h1>
    <div style = "margin:0px auto;"  >
        <img class=" img-responsive" src="img/Logo_ContainerRecords.png" >   
    </div>  
    <div align="center">
        <div id="Gridtabs"  >
            <ul class = "row justify-content-center">
              <li><a href="#Gridtabs-1">清洗</a></li>
              <li><a href="#Gridtabs-2">組裝測試</a></li>
              <li><a href="#Gridtabs-3">Outbound</a></li>
              <li><a href="#Gridtabs-4">壓降測漏</a></li>
              <li><a href="#Gridtabs-5">Inbound</a></li>
              <li><a href="#Gridtabs-6">PP測試</a></li>
              <li><a href="#Gridtabs-7">RGA測試</a></li>
              <li><a href="#Gridtabs-8">熱氮氣</a></li>
            </ul>
            <div id = "Gridtabs-1" >
                <div class = "row justify-content-center">
                <table id="dgClean" ></table> 
                <div id="dgCleanpager"></div>
                </div>                             
            </div>
            <div id = "Gridtabs-2" >
                <div class = "row justify-content-center">     
                <table id="dgAssemblingtest" ></table> 
                <div id="dgAssemblingtestpager"></div>
                </div>                             
            </div>
            <div id="Gridtabs-3">
                <div class = "row justify-content-center">     
                <table id="dgOutbound" ></table> 
                <div id="dgOutboundpager"></div>
                </div>        
            </div>
            <div id="Gridtabs-4">
                <div class = "row justify-content-center">  
                <table id="dgCPD" ></table> 
                <div id="dgCPDpager"></div>
                </div>     
            </div>
            <div id="Gridtabs-5" >
                <div class = "row justify-content-center">
                <table id="dgInbound" ></table> 
                <div id="dgInboundpager"></div>
                </div>        
            </div>
            <div id = "Gridtabs-6" >
                <div class = "row justify-content-center">     
                <table id="dgPumppurgetest" ></table> 
                <div id="dgPumppurgetestpager"></div>
                </div>                             
            </div>
            <div id="Gridtabs-7" >
                <div class = "row justify-content-center">
                <table id="dgRGAtest" ></table> 
                <div id="dgRGAtestpager"></div>
                </div>        
            </div>
            <div id = "Gridtabs-8" >
                <div class = "row justify-content-center">     
                <table id="dgHotn2" ></table> 
                <div id="dgHotn2pager"></div>
                </div>                             
            </div>
        </div>

        <div id="warningDialog" title="Warning Information">
            <p></p>
        </div>

        <div id="confirmDialog" title="Comfirm Information">
            <p></p>
        </div>
    </div>

    
<div align = "center">
    <input type="BUTTON" class="btn btn-outline-info btn-space" id="New" style="display: none" value="新增" />
    <input type="BUTTON" class="btn btn-outline-info btn-space" id="Edit" style="display: none" value="編輯" />
    <input type="BUTTON" class="btn btn-outline-info btn-space" id="Save" style="display: none" disabled="true" value="儲存" />
    <input type="BUTTON" class="btn btn-outline-info btn-space" id="Cancel" style="display: none" disabled="true" value="取消" />       
    <input type="BUTTON" class="btn btn-outline-info btn-space" id="Delete" style="display: none" value="刪除" />
    <input type="BUTTON" class="btn btn-outline-info btn-space" id="ExportExcel" style="display: none" value="下載" />   
    {{-- <div> --}}
        <input id="file" type="file" onchange="Import(this)" style="display: none" />
        <input type="button" onclick="file.click()" class="btn btn-outline-info btn-space" id="Import" style="display: none" value="上傳" />
    {{-- </div>     --}}
    <input type="BUTTON" class="btn btn-outline-info btn-space" id="ExportChart" value="圖表" />
    <input type="BUTTON" class="btn btn-outline-info btn-space" id="CloseChart" value="收合" />
</div>
<h1 class="my-4"></h1>


{{-- Tab ToolBar Start --}}
<h1 class="my-4"></h1>
<div id='tabs' style = 'width: 1200px; margin:0px auto; text-align:justify; display:none' >
    <button id='add-tab' class="btn btn-outline-info btn-space">＋ Groups</button>
    <button id='remove-tab' class="btn btn-outline-info btn-space">－ Groups</button>
    <button id='view-outlier' class="btn btn-outline-info btn-space">View Outlier</button>
    <ul>
        <li><a href='#tab1'>Group 1</a></li>
    </ul>
    <div id='tab1' style='background-color:powderblue;'>
        <span style='font-weight:bold; color:#2e6e9e; display:block; text-align:center'>《 Group 1 》</span> <br />
        <div id="jqxToolBar1" style = "margin:0px auto; text-align:justify" ></div>
        <h1 class="my-1"></h1>
        <div id="jqxToolBarConChart1" style = " margin:0px auto; text-align:justify" ></div>
        <h1 class="my-1"></h1>
        <div id="jqxToolBarChartRange1" style = " margin:0px auto; text-align:justify" ></div>
    </div>
</div>
{{-- Tab ToolBar End --}}    

{{-- Chart Start --}}
<div id = canvas_div style="width:70%; margin:0px auto; display: none;" >
    <canvas id="canvas" ></canvas>
</div>
{{-- Chart End --}}


{{-- Chart選單 Start --}}
<ul id="Chartmenu" style="display:none;" >
<li><a href="#" onclick="saveoutlierChartData();return false;"><span class="ui-icon ui-icon-disk"></span>Save</a></li>
<li><a href="#" onclick="removeChartData();return false;"><span class="ui-icon ui-icon-trash"></span>Delete</a></li>
<li><a href="#" onclick="viewChartData();return false;"><span class="ui-icon ui-icon-search"></span>View</a></li>
</ul>
{{-- Chart選單 End --}}

{{-- RightClick選單 Start --}}
<ul id="RightClickmenu" style="display:none;" >
<li><a href="#" onclick="showSelectSPEC();return false;"><span class="ui-icon ui-icon-document"></span>View SPEC</a></li>
</ul>
{{-- RightClick選單 End --}}


{{-- 表單送出方法 inline Start --}}
<script type="text/javascript">
    var target_id = 'none'; //紀錄目前要修改的列id
    var selectRowData = []; //紀錄選擇的目前的rowdata
    
    $("#New").click( function(){
        //var selected = $('#tabs').tabs('option', 'selected'); // selected tab index integer
    
        var table = "dg" +  getColumnNameFromChineseToDatabase($("#Gridtabs .ui-tabs-active").text()); //呈現此table的title
        var ret = $("#" + table).jqGrid('getRowData',1);    
        var newparameter =  
        {
            ker:true,
            rowID: "0",
            position: "first",
            initdata : {
                _id:parseInt(ret.id,10)+1, 
                _checked:false,
            },
            useDefValues: false,
            useFormatter: false,
            addRowParams: { extraparam: {} }
        };
        $("#" + table ).jqGrid('addRow', newparameter);
        $("#" + table).jqGrid('destroyFrozenColumns');   
        button_Control('after_Add');
     });
    
     $("#Edit").click( function(){
        var table = "dg" +  getColumnNameFromChineseToDatabase($("#Gridtabs .ui-tabs-active").text()); //呈現此table的title
        $("#" + table).jqGrid('destroyFrozenColumns');
        var s = $("#" + table).jqGrid('getGridParam','selrow');
        target_id = s;
         if (s)	{
            var ret = $("#" + table ).jqGrid('getRowData',s);
            var i = 0;
            var colNames = $("#" + table ).jqGrid('getGridParam','colNames');       
            for (key in ret)
            {
                // Fill (column name, column value) from target row data into array
                selectRowData[key] = Array(colNames[i], ret[key]);
                i++;         
            }

            $("#" + table ).jqGrid('editRow', s);
            button_Control('after_Edit');    
         }
         else
             alert("Please select a row...");
     });

     //儲存
     $("#Save").click( function(){
        var table = "dg" +  getColumnNameFromChineseToDatabase($("#Gridtabs .ui-tabs-active").text()); //呈現此table的title
        var rowIds = $('#' + table ).jqGrid('getDataIDs');
        var oper = "edit";
        var caption = $('#' + table ).jqGrid("getGridParam", "caption");
        
        $("#" + table).jqGrid('setFrozenColumns');   
        //判斷目前是新增或是修改
        for(idIndex = 0; idIndex < rowIds.length; ++idIndex){
           if (rowIds[idIndex] == "0"){oper = "add";}
        }
        //新增
        if (oper == 'add')
        {     
            saveparameters = {
                        "successfunc" : null,
                        "url" : 'ContainerRecord/AddandUpdate/'+0,
                        "extraparam" : {
                            "oper": oper,
                            "table": table,
                            "caption": caption,
                        },
                        "aftersavefunc" : function( response ) { window.location.reload() }, //重新整理頁面    
                        "errorfunc": null,
                        "afterrestorefunc" : null,
                        "restoreAfterError" : true,
                        "mtype" : "POST"
                }
                $("#" + table ).jqGrid('saveRow', 0, saveparameters);
        }
        //修改
        else
        {                   
            var result = [];               
            var ret = $("#" + table ).jqGrid('getRowData',target_id);
            var cellvalue='';
          
            for(var key in selectRowData )
            {
                var elem = $("#" + target_id + "_" + key);
                   
                if (elem.is(':checkbox'))
                {
                    cellvalue = elem.is(':checked') ? 'TRUE' : 'FALSE';
                }
                // Check if elem type is Select and display value as text
                else if (elem.is('select'))
                {
                    cellvalue = elem.find(":selected").text();
                   
                }
                // Check if elem is jqxComboBox and get value from input inside div
                // Because if jqxComboBox autoComplete set to true, it will not fill Null when input value wiped after selected items (forced to select first item)
                else if (elem.attr('role') === 'combobox')
                {
                    cellvalue = elem.find("input").val();               
                }
                else
                {
                    cellvalue = elem.val();       
                }
               
                // Check if column value is not undefined (editable input) and if value was changed by user
                // Also use .trim() to avoid jqGrid display Null as " " and cause a mistaken compare result
                if (cellvalue !== undefined && cellvalue !== selectRowData[key][1].trim())
                {
                    // Fill (column name, column original value, column changed vaue) into array
                    result[key] = Array(selectRowData[key][0], selectRowData[key][1], cellvalue);
                    // Set boolean to false if there are results
                    // empty_result = false;
                }


            }
           
            var htmlStr = "<br />您變更的值如下：<br /><br />";
            var addstring = "";    
            // Display changed title:value in confirm dialog
            for (var key in result)
            {
                
                // Transform Null values to 'Empty' string for display
                var value_before = (result[key][1] === "") ? 'Null' : result[key][1];
                var value_after = (result[key][2] === "") ? 'Null' : result[key][2];
                
                // Generate log statement with changed values
                // edit_statement += result[key] + "：\"" + value_before + "\" to \"" + value_after + "\", ";
                
                // Generate dialog html to display
                addString = "<strong>" + result[key][0] + "</strong>" + "：變更 " + "<strong>" + value_before + "</strong>" + " 為 " + "<strong>" + value_after + "</strong><br />";
                htmlStr += addString;
            }
                
            htmlStr += "<br />確定要修改所選的資料嗎?<br /><br />";

            $("#confirmDialog").html(htmlStr);
            $("#confirmDialog").dialog({
                width:'auto', height:'auto', autoResize:true, modal:true, closeText:"關閉", resizable:false,
                show:{effect: "fade", duration: 140},
                hide:{effect: "clip", duration: 140},
                focus: function() { $(".ui-dialog").focus(); }, // Unfocus the default focus elem
                buttons : {
                    "確認" : function() {
                                $(this).dialog("close");
                                saveparameters = {
                                "successfunc" : null,
                                "url" : 'ContainerRecord/AddandUpdate/'+ret.id,
                                "extraparam" : {                                   
                                    "id" : ret.id,
                                    "oper" : oper,
                                    "table": table,
                                    "caption": caption,                                 
                                },
                                "aftersavefunc" : function( response ) {
                                                },
                                "errorfunc": null,
                                "afterrestorefunc" : null,
                                "restoreAfterError" : true,
                                "mtype" : "POST"
                        }
                        $("#" + table ).jqGrid('saveRow',target_id, saveparameters);
                        target_id = 'none';
                        $("#" + table ).jqGrid('resetSelection');
                        button_Control('after_Save');                                            
                    },
                    "取消" : function() {
                        $(this).dialog("close");                     
                        target_id = 'none';
                        var rowIds = $('#' + table ).jqGrid('getDataIDs'); 
                        for(idIndex = 0; idIndex < rowIds.length; ++idIndex){
                            $("#" + table).jqGrid('restoreRow',rowIds[idIndex], true); 
                        }
                        button_Control('after_Cancel');
                    }
                }
            });                                      
        }
     });

     $("#Cancel").click( function(){
        var table = "dg" +  getColumnNameFromChineseToDatabase($("#Gridtabs .ui-tabs-active").text()); //呈現此table的title
        $("#" + table).jqGrid('setFrozenColumns');   
        target_id = 'none';
        var rowIds = $('#' + table ).jqGrid('getDataIDs'); 
        for(idIndex = 0; idIndex < rowIds.length; ++idIndex){           
            $("#" + table ).jqGrid('restoreRow',rowIds[idIndex], true); 
        }
        button_Control('after_Cancel');    
     });

      //獲取目前選取的資料    
      $("#Delete").click( function() {
        var table = "dg" +  getColumnNameFromChineseToDatabase($("#Gridtabs .ui-tabs-active").text()); //呈現此table的title
        var caption = $('#' + table ).jqGrid("getGridParam", "caption");
         var s = $("#" + table ).jqGrid('getGridParam','selrow');      
         if (s)	{
             var ret = $("#" + table ).jqGrid('getRowData',s);
             console.log(ret);           
             var answer = window.confirm("確認刪除此筆資料?");
             if (answer)
             {
                $.ajax({
                    url: "ContainerRecord/delete/" + ret.id ,//路徑
                    type: "DELETE",           
                    data:{
                        "id": ret.id,
                        "table": table,
                        "caption": caption,
                    },
                    success: function (){
                        $('#' + table ).trigger( 'reloadGrid' );
                    }                               
                });
             }        
         }
         else        
             alert("Please select a row...");     
        });  
    //Buttons control function
    function button_Control(state)
    {
        switch (state)
        {
            case "after_Add":          
                $("#Save").attr("disabled",false);
                $("#Cancel").attr("disabled",false);                   
                $("#New").attr("disabled",true);
                $("#Edit").attr("disabled",true);
                $("#Delete").attr("disabled",true);
                $("#ExportExcel").attr("disabled",true);
                $("#Import").attr("disabled",true);
                break;
            case "after_Delete":               
                $("#New").attr("disabled",false);
                $("#Edit").attr("disabled",false);
                $("#Save").attr("disabled",true);
                $("#Cancel").attr("disabled",true);                                  
                $("#Delete").attr("disabled",false);
                $("#ExportExcel").attr("disabled",false);
                $("#Import").attr("disabled",false);
                break;
            case "after_Edit":
                $("#Save").attr("disabled",false);
                $("#Cancel").attr("disabled",false);
                $("#New").attr("disabled",true);
                $("#Edit").attr("disabled",true);
                $("#Delete").attr("disabled",true);
                $("#ExportExcel").attr("disabled",true);
                $("#Import").attr("disabled",true);
                break;
            case "after_Cancel":
                $("#New").attr("disabled",false);
                $("#Edit").attr("disabled",false);
                $("#Save").attr("disabled",true);
                $("#Cancel").attr("disabled",true);                                  
                $("#Delete").attr("disabled",false);
                $("#ExportExcel").attr("disabled",false);
                $("#Import").attr("disabled",false);
                break;
            case "after_Save":
                $("#New").attr("disabled",false);
                $("#Edit").attr("disabled",false);
                $("#Save").attr("disabled",true);
                $("#Cancel").attr("disabled",true);                                  
                $("#Delete").attr("disabled",false);
                $("#ExportExcel").attr("disabled",false);
                $("#Import").attr("disabled",false);
                break;
        }    
    }

</script>
{{-- 表單送出方法 inline End --}}


{{-- 表單輸出、輸入功能 Start--}}
<script type="text/javascript">
    $("#ExportExcel").click(function(){        
    
        var table = "dg" +  getColumnNameFromChineseToDatabase($("#Gridtabs .ui-tabs-active").text()); //呈現此table的title
        
        var o = $("#" + table);
        
        var columnNames = o.jqGrid('getGridParam', 'colNames');//從grid獲得colnames

        var rowNumber = o.jqGrid('getGridParam', 'records');//獲得搜尋後的紀錄筆數
        
        var postData = o.jqGrid('getGridParam', 'postData');//獲得搜尋條件

        var getData = o.jqGrid('getGridParam', 'data');//獲得所有jqgrid的資料
        
        var rowData = o.jqGrid('getRowData');//獲得目前顯示在表格上的資料

        var caption = o.jqGrid("getGridParam", "caption");

        $.ajax({
                async:false,
                url: "ContainerRecord/export" ,//路徑
                type: "POST",           
                data:{
                    "postData": postData,
                    "table":table,
                    "caption": caption,
                },
                success: function (DownLoadValue){
                    console.log(DownLoadValue);
                    var dataExport = DownLoadValue.success;
                    //產生要寫入excel的data
                    var i = 1;
                    var dataToExcel = [];    
                    dataToExcel.push(columnNames);

                    for(var key in dataExport)
                    {
                        var tmp = [];
                        for (var p in dataExport[key])
                        {
                            tmp.push(dataExport[key][p]);
                        }
                        dataToExcel.push(tmp);
                    }
                    
                    var myDate = new Date().toISOString().slice(0,10); 

                    //檔名
                    var filename = myDate + '-' + $("#Gridtabs .ui-tabs-active").text()+ '-'+ 'ContainerRecord.xlsx';

                    //表名
                    var sheetname = 'Sheet';

                    //下載
                    downloadxlsx(filename, sheetname, dataToExcel);
                                            
                    }                               
                });    
       
    });

    function Import(e) {         
        if (e.files.length  ==  0 ){return;} //檢查是否有輸入資料
        
        var fileType = e.files[0].name.split('.').pop();
        var fileName = e.files[0].name;     
        var allowdtypes = 'xls,xlsx';
        if (allowdtypes.indexOf(fileType) < 0) 
        {          
            $("#warningDialog").html('<br />檔案格式錯誤！<br /><br />匯入之檔案必須為：<strong>Excel 2003 (.xls) </strong> 或 <strong>Excel 2007-2010 (.xlsx)</strong><br /><br />');
            $("#warningDialog").dialog({
                width:'auto', height:'auto', autoResize:true, modal:true, closeText:"關閉", 
                resizable:false, closeOnEscape:true, dialogClass:'top-dialog',
                show:{effect: "clip", duration: 140},
                hide:{effect: "clip", duration: 140},
                buttons:{
                    "關閉 Close":function() {
                        $(this).dialog("close");
                    }
                }
            });
            return false;
        }

        var dataFromImportf = ExcelImportf(e); //
        var dataImport; //用來承接promise方法的回傳參數
        
        dataFromImportf.then(function (dataImport) 
        {   
            var _upLoadData = JSON.parse(dataImport);
            var jsonKey=[];
            for (var jsonVal in _upLoadData[0]) {
                jsonKey.push(jsonVal);
            }

            //舊key到新key的映射
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
                "建立時間":"created_at",
                "更新時間":"updated_at",       
            };
            //新物件被刪除時，對應的物件也會一起刪掉，並產生新物件
            for(var i = 0;i < _upLoadData.length; i++){
                var obj =  _upLoadData[i];
                for(var key in obj){
                        var newKey = oldkey[key];
                        if(newKey){
                            obj[newKey] = obj[key];
                            delete obj[key];
                        }
                    }
            }


            var data = JSON.parse(dataImport);  //解析為Json對象   

            //建立動態表格
            $("#confirmDialog").html('<span style="font-weight:bold; color:#2e6e9e;">《 檔案資料預覽 File data preview 》</span><br /><br /><table id="import_preview"></table><div id="import_previewPager"></div>');
            var colNames = [];
            var colModel = [];
            
            for ( var colName in data[0])
            {
                colNames.push(colName);
            }

            for ( var colName in data[0])
            {
                
                if (colName === 'id')
                {
                    colModel.push({name:colName, index:colName, align:"center", width:84, frozen:true, sortable:true, sorttype:"int"});
                }
                else
                {
                    colModel.push({name:colName, index:colName, align:"center", width:112});
                }
            }
            
            $("#import_preview").jqGrid({      
                datatype: "local",
                data:data,
                colNames: colNames,
                colModel: colModel,
                width: 896,
                height: 'auto',
                sortname: 'id',
                sortorder: "asc",
                hidegrid: false,
                cmTemplate: { title: false },   // Hide Tooltip
                gridview: true,
                shrinkToFit: false,
                rowNum:10,
                rowList:[10,20,50],
                pager: '#import_previewPager',
                caption: fileName, 
    
                loadComplete: function (){ fixPositionsOfFrozenDivs.call(this); }, // Fix column's height are different after enable frozen column feature 
            });
            
            $("#import_preview").jqGrid('setFrozenColumns');
             //增加Tool bar        
            $("#import_preview").jqGrid('navGrid','#import_previewPager', { search:true, edit:false, add:false, del:false, refresh:true } );


            $("#confirmDialog").dialog({
                width:'900', height:'auto', autoResize:true, modal:true, closeText:"關閉", 
                resizable:true, closeOnEscape:true, dialogClass:'top-dialog',position:['center',168],
                show:{effect: "fade", duration: 140},
                hide:{effect: "clip", duration: 140},
                focus: function() { $(".ui-dialog").focus(); }, // Unfocus the default focus elem
                buttons : [
                    {
                        id:"button-OK",
                        text:"確認",
                        click:function()
                        { 
                            //$(this).dialog("close");
                            var table = "dg" +  getColumnNameFromChineseToDatabase($("#Gridtabs .ui-tabs-active").text()); //呈現此table的title

                            var o = $("#" + table);

                            var caption = o.jqGrid("getGridParam", "caption");
                        
                            $("#confirmDialog").html('<span style="font-weight:bold; color:#2e6e9e;">《 上傳進度 》</span><br /><br /><div id="progressbar"></div>');                                                                                                        
                            $("#confirmDialog").next(".ui-dialog-buttonpane button:contains('確定')").attr("disabled", true);
                            $("#button-OK").button("disable");
                            $("#button-cancel").button("disable");
                            for (var i = 0; i < data.length; i++) 
                            {                              
                                setTimeout((function (i) {                      
                                    return function () {                                                                       

                                        $.ajax({
                                            url: 'ContainerRecord/FileUpload/' + data[i].id,
                                            method: 'post',
                                            async: false,//同步請求資料
                                            //datatype:"json",
                                            data: {
                                                UploadData:_upLoadData[i],
                                                table:table,
                                                caption: caption                              
                                            },
                                            success: function (response) {                                                   
                                                $( function() 
                                                    {
                                                        $( "#progressbar" ).progressbar
                                                        ({
                                                            value: (i/data.length) * 100
                                                        });
                                                    });      
                                                if (response.success == data[data.length-1].id){                                                    
                                                    $(confirmDialog).dialog("close");
                                                    $("#progressbar").remove();
                                                    o.trigger( 'reloadGrid' );
                                                }
                                            },
                                            failure: function (response) {                              
                                            }
                                        });
                                    }
                                })(i), 10);
                            }
                        }                                                        
                    },
                    {
                        id: "button-cancel",
                        text: "取消",
                        click: function() {
                            $(this).dialog("close");
                        }
                    }
                ]
            });                                       
        })
    }
</script>
{{-- 表單輸出、輸入功能 End--}}

{{-- Chart.js Start --}}
<script>
    /*關閉Chart*/
    $("#CloseChart").click( function(){
        document.getElementById("canvas_div").style.display="none"; //關閉Chart
        document.getElementById("tabs").style.display="none"; //關閉Chart tab
    })

    /*產生圖表*/
   $("#ExportChart").click( function(){
       //初始圖表時不產生"無資料"的提醒
       var initial = 'false';
       if(document.getElementById("tabs").style.display =='none')
       {
           initial = 'true'; 
       }  
       document.getElementById("canvas_div").style.display=""; //顯示Chart
       document.getElementById("tabs").style.display=""; //顯示Control Toolbar
       var num_tabs = $("#tabs ul li").length; //Group 組數
       
       if (initial == 'true')
       {
           return;
       }

       //分組的分組資料
       var dataXaxisGroup = [];     //紀錄Group X軸資料 
       var dataYaxisGroup = [];     //紀錄Group Y軸資料 
       var chartTypeGroup = [];     //紀錄Group Chart Type資料
       var columnNameGroup = [];    //紀錄Group 欄位名稱
       var itemGroup = [];      //紀錄Group Item名稱
       var USLGroup = [], LSLGroup = [], UCLGroup = [], LCLGroup = [];  //紀錄Group control line資料
       var LabelItem = [];  //紀錄要在圖面呈現的欄位資訊
       var DateItem = [];  //紀錄data日期資訊
       var YaxisMax = [], YaxisMin = [];  //紀錄Y軸的最大值與最小值
       var SPCRule = [];  //紀錄Y軸的最大值與最小值 

       for(var j = 0; j < num_tabs; j++)
       {
         
           //獲得Toolbar的資料
           var tools = $("#jqxToolBar" + ( j + 1 )).jqxToolBar("getTools");
           var chartType = tools[1].tool[0].textContent; 
           var dataXaxis = getColumnNameFromChineseToDatabase(tools[3].tool[0].textContent);        
           var dataYaxis = getColumnNameFromChineseToDatabase(tools[5].tool[0].lastChild.value);
           var columnName = getColumnNameFromChineseToDatabase(tools[7].tool[0].lastChild.value);
           var item = tools[8].tool[0].value;

           chartTypeGroup.push(chartType);
           dataXaxisGroup.push(dataXaxis);
           dataYaxisGroup.push(dataYaxis);
           columnNameGroup.push(columnName);
           itemGroup.push(item);

           //獲得Toolbar的資料
           var toolsConChart = $("#jqxToolBarConChart" + ( j + 1 )).jqxToolBar("getTools");
           var tUSL = toolsConChart[1].tool[0].value;
           var tLSL = toolsConChart[3].tool[0].value;
           var tUCL = toolsConChart[5].tool[0].value;
           var tLCL = toolsConChart[7].tool[0].value;
           USLGroup.push(tUSL);
           LSLGroup.push(tLSL);
           UCLGroup.push(tUCL);
           LCLGroup.push(tLCL);
           LabelItem.push("bottle_number");
           DateItem.push("working_date");
           
           //獲得Toolbar的資料 
           var toolsBarChartRange = $("#jqxToolBarChartRange" + ( j + 1 )).jqxToolBar("getTools");
           var tYaxisMax = toolsBarChartRange[1].tool[0].value;
           var tYaxisMin = toolsBarChartRange[3].tool[0].value;
           var tSPCRule = toolsBarChartRange[5].tool[0].lastChild.value;
           
           YaxisMax.push(tYaxisMax);
           YaxisMin.push(tYaxisMin);
           SPCRule.push(tSPCRule);
       }
       
        //檢查選擇Control Chart時，Group 不能大於1組以上，UCL 或LCL需同時為空或有值避免Center Line計算錯誤
        //檢查選擇Scatter Chart時，Group 不能有值沒有選擇，避免無法產生圖表
        var _checkChartWithGroup = checkChartWithGroup(chartTypeGroup, UCLGroup, LCLGroup); 
        if (_checkChartWithGroup !==''){alert(_checkChartWithGroup); return;}

       //獲得資料

        var table = "dg" +  getColumnNameFromChineseToDatabase($("#Gridtabs .ui-tabs-active").text()); //呈現此table的title
        
        var o = $("#" + table);
        
        var columnNames = o.jqGrid('getGridParam', 'colNames');//從grid獲得colnames

        var rowNumber = o.jqGrid('getGridParam', 'records');//獲得搜尋後的紀錄筆數
        
        var postData = o.jqGrid('getGridParam', 'postData');//獲得搜尋條件

        var getData = o.jqGrid('getGridParam', 'data');//獲得所有jqgrid的資料
        
        var rowData = o.jqGrid('getRowData');//獲得目前顯示在表格上的資料

        var caption = o.jqGrid("getGridParam", "caption");
       

       $.ajax({
               async:false,
               url: "ContainerRecord/export" ,//路徑
               type: "POST",           
               data:{
                    "postData": postData,
                    "table":table,
                    "caption": caption,
               },
               success: function (DownLoadValue){
                   var dataLo = DownLoadValue.success;
                 //產生要寫入excel的data
                   //參數格式: original data -> toolbar data -> toolbar control data 
                   DrowChart( 'Container Record', dataLo, 
                           chartTypeGroup, dataXaxisGroup, dataYaxisGroup, 
                           columnNameGroup, itemGroup, 
                           USLGroup, LSLGroup, UCLGroup, LCLGroup, LabelItem, DateItem,
                           YaxisMax, YaxisMin, SPCRule
                       );
                   }                                  
               });    
             
   })
</script>
{{-- Chart.js End --}}

{{-- Show outlier Log Start --}}
<script type="text/javascript">

$("button#view-outlier").click(
    function() 
    {
        var outlier_data = [];
        for(var i=0;i<sessionStorage.length;i++){
            var key=sessionStorage.key(i);
            var value=sessionStorage[key];
            if(key.indexOf("restoreID") != -1)
            {
                outlier_data.push(value);
            }
        }

        if(outlier_data.length == 0)
        {
            alert("There is no outlier data.");
            return;
        }

        var table = getColumnNameFromChineseToDatabase($("#Gridtabs .ui-tabs-active").text()); //呈現此table的title
        
        
        $.ajax({
                async:false,
                url: "ContainerRecord/GetDataFromID/"+table ,//路徑
                type: "POST",           
                data:{
                    "postData": outlier_data,
                },
                success: function (DownLoadValue){
                    var data = DownLoadValue.success;
                    //產生要寫入excel的data
                    var table = "import_preview";
                    var pcontent = '<span style="font-weight:bold; color:#2e6e9e;">《 極端值 view outlier  》</span><br /><br />' + '<table id= '+ table + '></table><div id="import_previewPager"></div>';
                    
                    //建立動態表格
                    $("#confirmDialog").html(pcontent);
                    var colNames = [];
                    var colModel = [];
                    
                    for ( var colName in data[0])
                    {
                        colNames.push(getColumnNameFromDatabaseToChinese(colName));
                    }

                    for ( var colName in data[0])
                    {           
                        if (colName === 'id')
                        {
                            colModel.push({name:colName, index:colName, align:"center", width:84, frozen:true, sortable:true, sorttype:"int"});
                        }
                        else
                        {
                            colModel.push({name:colName, index:colName, align:"center", width:112});
                        }
                    }
                    
                    $("#" + table).jqGrid({      
                        datatype: "local",
                        data:data,
                        colNames: colNames,
                        colModel: colModel,
                        width: 896,
                        height: 'auto',
                        sortname: 'id',
                        sortorder: "asc",
                        hidegrid: false,
                        cmTemplate: { title: false },   // Hide Tooltip
                        gridview: true,
                        shrinkToFit: false,
                        rowNum:10,
                        rowList:[10,20,50],
                        pager: '#import_previewPager',
                        caption: "極端值紀錄 Outlier Log", 
                        loadComplete: function (){ fixPositionsOfFrozenDivs.call(this); }, // Fix column's height are different after enable frozen column feature 
                        gridComplete: function() { $("#" + table).jqGrid('setFrozenColumns');}
                    });
                    
                    
                    //$("#" + table).jqGrid('setFrozenColumns');
                    //增加Tool bar        
                    $("#" + table).jqGrid('navGrid','#import_previewPager', { search:true, edit:false, add:false, del:false, refresh:true } );
                        

                    $("#confirmDialog").dialog({
                        width:'auto', height:'auto', autoResize:true, modal:true, closeText:"關閉", 
                        resizable:true, closeOnEscape:true, dialogClass:'top-dialog',position:['center',168],
                        show:{effect: "fade", duration: 140},
                        hide:{effect: "clip", duration: 140},
                        focus: function() { $(".ui-dialog").focus(); }, // Unfocus the default focus elem
                        buttons : {
                            "關閉" : function() {
                                $(this).dialog("close");
                                                                                    
                            },
                            "清除極端值" : function() {
                                var answer = window.confirm("確認清除極端值?");
                                if (answer)
                                {
                                    clearoutlierChartData();
                                    $(this).dialog("close");
                                }
                                                                                    
                            },
                            "下載": function(){
                                var dataExport = DownLoadValue.success;
                                //產生要寫入excel的data
                                var i = 1;
                                var dataToExcel = [];    
                                dataToExcel.push(colNames);

                                for(var key in dataExport)
                                {
                                    var tmp = [];
                                    for (var p in dataExport[key])
                                    {
                                        tmp.push(dataExport[key][p]);
                                    }
                                    dataToExcel.push(tmp);
                                }
                                
                                var myDate = new Date().toISOString().slice(0,10); 

                                //檔名
                                var filename = myDate + '-' + 'OutlierLog.xlsx';

                                //表名
                                var sheetname = 'Sheet';

                                //下載
                                downloadxlsx(filename, sheetname, dataToExcel);             
                                        }
                        }
                    });                                                   
                }                               
            });     
    }
);
/*得到Chart上的data*/ 
function viewChartData( ){
    var $menu = $('#Chartmenu');
    $menu.hide();
    var dataSetIndex = sessionStorage.getItem('operatingChartDataSetIndex');
    var index= sessionStorage.getItem('operatingChartIndex');
    var outlier = window.myLine.data.datasets[dataSetIndex].data[index];
    var outlier_data = [];
    outlier_data.push(outlier["id"]);

    var table = getColumnNameFromChineseToDatabase($("#Gridtabs .ui-tabs-active").text()); //呈現此table的title
  
    $.ajax({
            async:false,
            url: "ContainerRecord/GetDataFromID/"+table ,//路徑
            type: "POST",           
            data:{
                "postData": outlier_data,
            },
            success: function (DownLoadValue){
                var data = DownLoadValue.success;
                //產生要寫入excel的data
                var table = "import_preview";
                var pcontent = '<span style="font-weight:bold; color:#2e6e9e;">《 極端值 view outlier  》</span><br /><br />' + '<table id= '+ table + '></table><div id="import_previewPager"></div>';
                
                //建立動態表格
                $("#confirmDialog").html(pcontent);
                var colNames = [];
                var colModel = [];
                
                for ( var colName in data[0])
                {
                    colNames.push(getColumnNameFromDatabaseToChinese(colName));
                }

                for ( var colName in data[0])
                {           
                    if (colName === 'id')
                    {
                        colModel.push({name:colName, index:colName, align:"center", width:84, frozen:true, sortable:true, sorttype:"int"});
                    }
                    else
                    {
                        colModel.push({name:colName, index:colName, align:"center", width:112});
                    }
                }
                
                $("#" + table).jqGrid({      
                    datatype: "local",
                    data:data,
                    colNames: colNames,
                    colModel: colModel,
                    width: 896,
                    height: 'auto',
                    sortname: 'id',
                    sortorder: "desc",
                    hidegrid: false,
                    cmTemplate: { title: false },   // Hide Tooltip
                    gridview: true,
                    shrinkToFit: false,
                    rowNum:10,
                    rowList:[10,20,50],
                    pager: '#import_previewPager',
                    caption: "極端值紀錄 Outlier Log", 
                    loadComplete: function (){ fixPositionsOfFrozenDivs.call(this); }, // Fix column's height are different after enable frozen column feature 
                    gridComplete: function() { $("#" + table).jqGrid('setFrozenColumns');}
                });
                
                
                //$("#" + table).jqGrid('setFrozenColumns');
                //增加Tool bar        
                $("#" + table).jqGrid('navGrid','#import_previewPager', { search:true, edit:false, add:false, del:false, refresh:true } );
                    

                $("#confirmDialog").dialog({
                    width:'auto', height:'auto', autoResize:true, modal:true, closeText:"關閉", 
                    resizable:true, closeOnEscape:true, dialogClass:'top-dialog',position:['center',168],
                    show:{effect: "fade", duration: 140},
                    hide:{effect: "clip", duration: 140},
                    focus: function() { $(".ui-dialog").focus(); }, // Unfocus the default focus elem
                    buttons : {
                        "關閉" : function() {
                            $(this).dialog("close");
                                                                               
                        },
                        "清除極端值" : function() {
                            var answer = window.confirm("確認清除極端值?");
                            if (answer)
                            {
                                clearoutlierChartData();
                                $(this).dialog("close");
                            }
                                                                               
                        },
                        "下載": function(){
                            var dataExport = DownLoadValue.success;
                            //產生要寫入excel的data
                            var i = 1;
                            var dataToExcel = [];    
                            dataToExcel.push(colNames);

                            for(var key in dataExport)
                            {
                                var tmp = [];
                                for (var p in dataExport[key])
                                {
                                    tmp.push(dataExport[key][p]);
                                }
                                dataToExcel.push(tmp);
                            }
                            
                            var myDate = new Date().toISOString().slice(0,10); 

                            //檔名
                            var filename = myDate + '-' + 'OutlierLog.xlsx';

                            //表名
                            var sheetname = 'Sheet';

                            //下載
                            downloadxlsx(filename, sheetname, dataToExcel);             
                                    }
                    }
                });                                                   
            }                               
        });     
}      
    </script>
    
    {{-- Show outlier Log End --}}

@endsection
