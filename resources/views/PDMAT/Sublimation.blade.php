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
</style>
 
{{-- CSS設定 End --}}

{{-- Data資料呈現 Start --}}
<script type="text/javascript">

    var _todos = @json($todos);
    var combobox_items = [];  //用來儲存colName內容選項
    
    /*****建立文件的方法*****/
    $(document).ready(function () {
        
        //建立動態表格
        var colNames = [];
        var colModel = [];
   
        for ( var colName in _todos)
        {
            colNames.push(colName);
        }
        
        for ( var colName in _todos)
        {           
            if (colName === 'id')
            {           
                colModel.push(
                        {name:colName, index:colName, width:80, align:"center",sortable:true, sorttype:"int", frozen: true, editable:false, cellattr: addCellAttrID}
                    );
            }
            else if (colName === 'bulk_started')
            {
                colModel.push(
                    {
                        name:colName, index:colName, width:200, align:"center",sortable:true, editable:true, cellattr: addCellAttr,
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
                        //editrules:{date:true, required:false}, //formateter:fixDate, 
                        //formatter: "date",
                        //formatoption:{srcformat:'Y-m-d', newformat:'Y-m-d'},
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
                                    //format: "yyyy-mm-dd",
                                    autoclose:1
                                });
                            }
                        },                                   
                    }
                );
            }
            else if (colName === 'glove_box' || colName === 'PLC_status' || colName === 'input_op'||
                    colName === 'output_op'
                )
            {
                colModel.push(
                    {
                        name:colName, index:colName, width:150, align:"center",sortable:true, editable:true, cellattr: addCellAttr,
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
            else if (colName === 'urgent')
            {
                colModel.push({name:colName, index:colName, width:60, align:"center", editable:true, cellattr: addCellAttr});
            }
            else if (colName === 'remark')
            {
                colModel.push({name:colName, index:colName, width:250, align:"center", editable:true, cellattr: addCellAttr});
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

        var jqgridWidth = parseInt($(window).width()) * 0.7;

        // 準備資料           
        $("#dg").jqGrid({
            url:'Sublimation/show',
            datatype: "json",
            altrows:false,
            width: jqgridWidth,
            height:'100%',
            colNames:colNames,
            colModel:colModel,
            multiselect:false,
            rowNum:10,
            rowList:[10,20,50],
            pager: '#dgPager',
            sortname: 'id',
            viewrecords: true,
            gridview: true,
            sortorder: "desc",
            caption:"Sublimation 昇華",
            shrinkToFit :false,
            loadonce:false,
            jsonReader : {
                            root: "dataList",
                            page: "currPage",
                            total: "totalPages",
                            records: "totalCount"                     
                        },
            prmNames : {
                            page:"pageNum", 
                            rows:"limit", 
                            order: "order"
                        },
            loadComplete: function (){ 
                fixPositionsOfFrozenDivs.call(this);
            }, // Fix column's height are different after enable frozen column feature
            gridComplete: function(){
                //根據瀏覽器寬度動態改變
                $(window).resize(function(){ 
                    var winwidth= parseInt($(window).width()) * 0.7;     
                    $("#dg").jqGrid('setGridWidth', winwidth);
                });
            },
                                              
        }).jqGrid('setFrozenColumns');
        
        //增加Tool bar        
        $("#dg").jqGrid('navGrid','#dgPager', { search:true, edit:false, add:false, del:false, refresh:true } );
                
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
        $("#dg").jqGrid('navButtonAdd','#dgPager',{
                caption: "",
                title: "表格排序",
                onClickButton : function (){
                jQuery("#dg").jqGrid('columnChooser');
                }
            });

        //重新整理功能
        $('.ui-icon-refresh').click(function(){
            lastSearchData = null;
            $("#load_dg").show();
        });

        //獲得combobox的內容
        combobox_items = getComboboxItem();

        var _ChartTypeSource = ["Scatter Chart", "Control Chart"];
        var _xAxisSource = ["bulk started", "次數", "1st crude batch", "1st tank batch", "2nd crude batch", "2nd tank batch", "3rd crude batch", 
                            "3rd tank batch", "bulk batch", "glove box"];
        var _yAxisSource = ["1st crude wt.", "2nd crude wt.", "3rd crude wt.", "bulk actual assay", "bulk actual meo", "mantle", "solid input", 
                            "bulk output", "bulk yield", "input system oxygen", "pre system Pump", "pre system torr", 
                            "output system oxygen", "top Mantle (end)", "top Tapes (end)", "top Coolant (end)", "top Turbo (end)", "top Oxygen (end)", 
                            "man Tapes (end)", "main Coolant (end)", "main Turbo (end)", "main Oxygen (end)"
                        ];
        var _GroupSource = ["1st crude batch", "1st tank batch", "2nd crude batch", "2nd tank batch", "3rd crude batch", "3rd tank batch", "bulk batch", "judge", "glove box", 
                            "PLC status"
                        ];

        //建立ToolBar
        PrepareToToolbar(_ChartTypeSource, _xAxisSource, _yAxisSource, _GroupSource);
          
    });

     /*輸入Database ColumnName 輸出中文 ColumnName*/
     function getColumnNameFromDatabaseToChinese(ColumnName)
     {
        var Result = '';
        //舊key到新key的映射，colName的轉換
        var oldkey = {
            id: "編號",
            bulk_started: "bulk started",
            remark: "remark",
            "1st_crude_batch": "1st crude batch",
            "1st_crude_wt": "1st crude wt.",
            "1st_tank_batch": "1st tank batch",
            "2nd_crude_batch": "2nd crude batch",
            "2nd_crude_wt": "2nd crude wt.",
            "2nd_tank_batch": "2nd tank batch",
            "3rd_crude_batch": "3rd crude batch",
            "3rd_crude_wt": "3rd crude wt.",
            "3rd_tank_batch": "3rd tank batch",
            bulk_batch: "bulk batch",
            bulk_actual_assay: "bulk actual assay",
            bulk_actual_meo: "bulk actual meo",
            judge:"judge",
            glove_box: "glove box",
            mantle: "mantle",
            PLC_status: "PLC status",
            input_op: "input op.",
            solid_input: "solid input",
            output_op: "output op.",
            bulk_output: "bulk output",
            bulk_yield: "bulk yield",
            input_system_oxygen: "input system oxygen",
            pre_system_Pump: "pre system Pump",
            pre_system_torr: "pre system torr",
            output_system_oxygen: "output system oxygen",
            "top_Mantle_end": "top Mantle (end)",
            "top_Tapes_end": "top Tapes (end)",
            "top_Coolant_end": "top Coolant (end)",
            "top_Turbo_end": "top Turbo (end)",
            "top_Oxygen_end": "top Oxygen (end)",
            "main_Mantle_end": "main Mantle (end)",
            "main_Tapes_end": "main Tapes (end)",
            "main_Coolant_end": "main Coolant (end)",
            "main_Turbo_end": "main Turbo (end)",
            "main_Oxygen_end": "main Oxygen (end)",
            created_at: "建立時間",
            updated_at: "更新時間",
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
    /* 輸入中文 ColumnName 輸出Database ColumnName*/
    function getColumnNameFromChineseToDatabase(ColumnName)
    {
        var Result = '';
        //舊key到新key的映射，colName的轉換
        var oldkey = {
            "編號" : "id", 
            "bulk started" : "bulk_started",
            "remark" : "remark",
            "1st crude batch" : "1st_crude_batch",
            "1st crude wt." : "1st_crude_wt",
            "1st tank batch": "1st_tank_batch",
            "2nd crude batch" : "2nd_crude_batch",
            "2nd crude wt." : "2nd_crude_wt",
            "2nd tank batch" : "2nd_tank_batch",
            "3rd crude batch": "3rd_crude_batch",
            "3rd crude wt." : "3rd_crude_wt" ,
            "3rd tank batch" : "3rd_tank_batch" ,
            "bulk batch" : "bulk_batch",
            "bulk actual assay" : "bulk_actual_assay" ,
            "bulk actual meo" : "bulk_actual_meo" ,
            "judge" : "judge" ,
            "glove box" : "glove_box",
            "mantle" : "mantle",
            "PLC status" : "PLC_status",
            "input op." : "input_op",
            "solid input" : "solid_input",
            "output op." : "output_op",
            "bulk output" : "bulk_output",
            "bulk yield" : "bulk_yield",
            "input system oxygen" : "input_system_oxygen" ,
            "pre system Pump" : "pre_system_Pump",
            "pre system torr" : "pre_system_torr",
            "output system oxygen" : "output_system_oxygen",
            "top Mantle (end)" : "top_Mantle_end",
            "top Tapes (end)" : "top_Tapes_end",
            "top Coolant (end)" : "top_Coolant_end",
            "top Turbo (end)" : "top_Turbo_end",
            "top Oxygen (end)" : "top_Oxygen_end",
            "main Mantle (end)" : "main_Mantle_end",
            "main Tapes (end)" : "main_Tapes_end",
            "main Coolant (end)" : "main_Coolant_end",
            "main Turbo (end)" : "main_Turbo_end",
            "main Oxygen (end)" : "main_Oxygen_end",
            "建立時間" : "created_at",
            "更新時間" : "updated_at",
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
    
    /*****修改GridView欄位字體顏色*****/
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

    /*****獲得item內容包含的方法*****/
    var selectItemJson; //用來存放item包含的值
    function getComboboxItem(){
        
        $.ajax({
            async:false,
            url: "Sublimation/GetComboboxItem",//路徑
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

    //Datetime picker
    $( function() {
        $('#datepicker').datetimepicker({
            dateFormat: 'yy-mm-dd', 
            timeFormat: 'HH:mm:ss'
        });
       
    }); 
</script>
{{-- Data資料呈現 End --}}
 
<meta name="csrf-token" content="{{ csrf_token() }}"> 
{{-- <div class = "container"> --}}
    <h1 class="my-2"></h1>
    <div style = "margin:0px auto;">
        <img class=" img-responsive" src="img/Logo_Sublimation.png" >   
    </div>

    <div align="center">
        <table id="dg"></table>    
        <div id="dgPager"></div>                         
    </div>
{{-- <div class = "container">     --}}
    <div align="center">
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="New"  value="新增" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="Edit"  value="編輯" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="Save"  disabled="true" value="儲存" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="Cancel"  disabled="true" value="取消" />       
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="Delete" value="刪除" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="ExportExcel" value="下載" />
        
        {{-- <div> --}}
            <input id="file" type="file" onchange="Import(this)" style="display: none" />
            <input type="button" onclick="file.click()" class="btn btn-outline-info btn-space" id="Import" value="上傳" />
        {{-- </div> --}}
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="ExportChart" value="圖表" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="CloseChart" value="收合" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="BackFill" value="回填" />         
    </div>
    <div id="confirmDialog" title="Comfirm Information">
        <p></p>
    </div>
    <div id="warningDialog" title="Warning Information">
        <p></p>
    </div>  

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
    </ul>
    {{-- Chart選單 End --}}

{{-- 表單送出方法 inline Start --}}
<script type="text/javascript">

    var target_id = 'none'; //紀錄目前要修改的列id
    var selectRowData = []; //紀錄選擇的目前的rowdata

    $("#New").click( function(){
        var ret = $("#dg").jqGrid('getRowData',1);
        // console.log(ret);     
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
        $("#dg").jqGrid('addRow', newparameter);         
        button_Control('after_Add');
     });
    
    $("#Edit").click( function(){ 
        var s = $("#dg").jqGrid('getGridParam','selrow');
        target_id = s;
        if (s)	{
        var ret = $("#dg").jqGrid('getRowData',s);
        var i = 0;
        var colNames = $("#dg").jqGrid('getGridParam','colNames');       
        for (key in ret)
        {
            // Fill (column name, column value) from target row data into array
            selectRowData[key] = Array(colNames[i], ret[key]);
            i++;         
        }

        $("#dg").jqGrid('editRow', s);
        button_Control('after_Edit');    
        }
        else
            alert("Please select a row...");
    });

    //儲存
    $("#Save").click( function(){
        var rowIds = $('#dg').jqGrid('getDataIDs');
        var oper = "edit";
        //判斷目前是新增或是修改
        for(idIndex = 0; idIndex < rowIds.length; ++idIndex){
            if (rowIds[idIndex] == "0"){oper = "add";}
        }
        //新增
        if (oper == 'add')
        {     
            saveparameters = {
                        "successfunc":null,
                        "url":'Sublimation/AddandUpdate/'+0,
                        "extraparam" : {
                            "oper":oper
                        },
                        "aftersavefunc":function(){ window.location.reload() }, //重新整理頁面
                        "errorfunc":null,
                        "afterrestorefunc" : null,
                        "restoreAfterError" : true,
                        "mtype" : "POST"
                }
                $("#dg").jqGrid('saveRow', 0, saveparameters);
        }    
        //修改
        else
        {                   
            var result = [];               
            var ret = $("#dg").jqGrid('getRowData',target_id);
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
                    //empty_result = false;
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
                                "url" : 'Sublimation/AddandUpdate/'+ret.id,
                                "extraparam" : {                                   
                                    "id" : ret.id,
                                    "oper" : oper,                                  
                                },
                                "aftersavefunc" : function( response ) {
                                                },
                                "errorfunc": null,
                                "afterrestorefunc" : null,
                                "restoreAfterError" : true,
                                "mtype" : "POST"
                        }
                        $("#dg").jqGrid('saveRow',target_id, saveparameters);
                        target_id = 'none';
                        $("#dg").jqGrid('resetSelection');
                        button_Control('after_Save');                                            
                    },
                    "取消" : function() {
                        $(this).dialog("close");                     
                        target_id = 'none';
                        var rowIds = $('#dg').jqGrid('getDataIDs'); 
                        for(idIndex = 0; idIndex < rowIds.length; ++idIndex){
                            $("#dg").jqGrid('restoreRow',rowIds[idIndex], true); 
                        }
                        button_Control('after_Cancel');
                    }
                }
            });                                      
        }
    });

    //取消
    $("#Cancel").click( function(){
    target_id = 'none';
    var rowIds = $('#dg').jqGrid('getDataIDs'); 
    for(idIndex = 0; idIndex < rowIds.length; ++idIndex){           
        $("#dg").jqGrid('restoreRow',rowIds[idIndex], true); 
    }
    button_Control('after_Cancel');    
    });

    //刪除    
    $("#Delete").click( function() {
         var s = $("#dg").jqGrid('getGridParam','selrow');      
         if (s)	{
             var ret = $("#dg").jqGrid('getRowData',s);
             console.log(ret);           
             var answer = window.confirm("確認刪除此筆資料?");
             if (answer)
             {
                $.ajax({
                    url: "Sublimation/delete/" + ret.id ,//路徑
                    type: "DELETE",                   
                    data:{
                        "id": ret.id,
                    },
                    success: function (){                  
                        $('#dg').trigger( 'reloadGrid' );
                    }                                                  
                });
             }        
         }
         else        
             alert("Please select a row...");     
        });  
    
    //回填   
    $("#BackFill").click( function() {
        var s = $("#dg").jqGrid('getGridParam','selrow');      
        if (s)	{
            var ret = $("#dg").jqGrid('getRowData',s);        
            var answer = window.confirm("確認回填此筆資料?");
            if (answer)
            {
                $.ajax({
                    async:false,
                    url: "Sublimation/BackFill/" + ret.id ,//路徑
                    type: "POST",             
                    data:{
                        "id": ret.id,
                    },
                    success: function (){                       
                        $('#dg').trigger( 'reloadGrid' );
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
        
        var o = $("#dg");

        var columnNames = o.jqGrid('getGridParam', 'colNames');//從grid獲得colnames

        var rowNumber = o.jqGrid('getGridParam', 'records');//獲得搜尋後的紀錄筆數
        
        var postData = o.jqGrid('getGridParam', 'postData');//獲得搜尋條件

        var getData = o.jqGrid('getGridParam', 'data');//獲得所有jqgrid的資料
        
        //o.jqGrid('setGridParam', { rowNum: rowNumber }).trigger('reloadGrid', [{current:true}]);//此方式可能會lag                  
        
        var rowData = o.jqGrid('getRowData');//獲得目前顯示在表格上的資料
        
        $.ajax({
                async:false,
                url: "Sublimation/export" ,//路徑
                type: "POST",           
                data:{
                    "postData": postData,
                },
                success: function (DownLoadValue)
                {
                    //console.log(DownLoadValue);
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
                    var filename = myDate + '-' + 'Sublimation.xlsx';

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
                width:'auto', height:'auto', autoResize:true, modal:true, closeText:"正在上傳", 
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
                編號: "id",      
                "bulk started": "bulk_started",                
                //"remark": "remark", //同樣字符不須寫兩次，會被刪除
                "1st crude batch": "1st_crude_batch",
                "1st crude wt.": "1st_crude_wt",
                "1st tank batch": "1st_tank_batch",
                "2nd crude batch": "2nd_crude_batch",
                "2nd crude wt.": "2nd_crude_wt",
                "2nd tank batch": "2nd_tank_batch",
                "3rd crude batch": "3rd_crude_batch",
                "3rd crude wt.": "3rd_crude_wt",
                "3rd tank batch": "3rd_tank_batch",              
                "bulk batch": "bulk_batch",
                "bulk actual assay": "bulk_actual_assay",
                "bulk actual meo": "bulk_actual_meo",
                //"judge":"judge",             
                "glove box": "glove_box",
                //"mantle": "mantle",
                "PLC status": "PLC_status",
                "input op.": "input_op",
                "solid input": "solid_input",
                "output op.": "output_op",
                "bulk output": "bulk_output",
                "bulk yield": "bulk_yield",
                "input system oxygen": "input_system_oxygen",
                "pre system Pump": "pre_system_Pump",
                "pre system torr": "pre_system_torr",
                "output system oxygen": "output_system_oxygen",
                "top Mantle (end)": "top_Mantle_end",
                "top Tapes (end)": "top_Tapes_end",
                "top Coolant (end)": "top_Coolant_end",
                "top Turbo (end)": "top_Turbo_end",
                "top Oxygen (end)": "top_Oxygen_end",
                "main Mantle (end)": "main_Mantle_end",
                "main Tapes (end)": "main_Tapes_end",
                "main Coolant (end)": "main_Coolant_end",
                "main Turbo (end)": "main_Turbo_end",
                "main Oxygen (end)": "main_Oxygen_end",
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
            var table = "import_preview";
            var pcontent = '<span style="font-weight:bold; color:#2e6e9e;">《 檔案資料預覽 File data preview 》</span><br /><br />' + '<table id= '+ table + '></table><div id="import_previewPager"></div>';

            //建立動態表格
            $("#confirmDialog").html(pcontent);
            var colNames = [];
            var colModel = [];

            for ( var colName in data[0])
            {
                colNames.push(colName);
            }

            for ( var colName in data[0])
            {
                
                if (colName === '編號')
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
                height: '100%',
                sortname: '編號',
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
            $("#" + table).jqGrid('setFrozenColumns');
            //增加Tool bar        
            $("#" + table).jqGrid('navGrid','#import_previewPager', { search:true, edit:false, add:false, del:false, refresh:true } );
        
            // Hide caption
            // $("#gview_import_preview > .ui-jqgrid-titlebar").hide();
 
            $("#confirmDialog").dialog({
                width:'auto', height:'auto', autoResize:true, modal:true, closeText:"關閉", 
                resizable:true, closeOnEscape:true, dialogClass:'top-dialog',
                //width:'auto', height:'auto', autoResize:true, modal:true, closeText:"關閉", resizable:true,
                show:{effect: "fade", duration: 140},
                hide:{effect: "clip", duration: 140},
                focus: function() { $(".ui-dialog").focus(); }, // Unfocus the default focus elem
                buttons :[ 
                {
                    id:"button-OK",
                    text:"確認",
                    click:function()
                    {
                        //$(this).dialog("close");
                        $("#confirmDialog").html('<span style="font-weight:bold; color:#2e6e9e;">《 上傳進度 》</span><br /><br /><div id="progressbar"></div>');                                                                                                        
                        $("#confirmDialog").next(".ui-dialog-buttonpane button:contains('確定')").attr("disabled", true);
                        $("#button-OK").button("disable");
                        $("#button-cancel").button("disable");
                        for (var i = 0; i < data.length; i++) {                              
                                setTimeout((function (i) {                      
                                    return function () {                                                                       

                                        $.ajax({
                                            url: 'Sublimation/FileUpload/' + data[i].編號,
                                            method: 'post',
                                            async: false,//同步請求資料
                                            data: {
                                                UploadData:_upLoadData[i],
                                                count:i                              
                                            },
                                            success: function (response) {
                                                if (response.message != undefined && i == 0)
                                                {   
                                                    alert("Upload Fail!! Please check file: " + response.message);
                                                    
                                                    for(var j = 0; j < data.length; j++)
                                                    {
                                                        clearTimeout(j);
                                                    }                                           
                                                    window.location.reload();                                     
                                                }
                                                else
                                                {                
                                                    if(response.message == undefined ) 
                                                    {                                                                         
                                                        $(function() 
                                                            {
                                                                $( "#progressbar" ).progressbar
                                                                ({
                                                                    value: (i/data.length) * 100
                                                                });
                                                            });      
                                                        if (response.count == data.length - 1)
                                                        {                                                    
                                                            $(confirmDialog).dialog("close");
                                                            $("#progressbar").remove();
                                                            $('#dg').trigger( 'reloadGrid' );
                                                        }
                                                    }
                                                }                                            
                                            },
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
            LabelItem.push("bulk_batch");
            DateItem.push("bulk_started");
            
            //獲得Toolbar的資料 
            var toolsBarChartRange = $("#jqxToolBarChartRange" + ( j + 1 )).jqxToolBar("getTools");
            var tYaxisMax = toolsBarChartRange[1].tool[0].value;
            var tYaxisMin = toolsBarChartRange[3].tool[0].value;
            YaxisMax.push(tYaxisMax);
            YaxisMin.push(tYaxisMin);
        }
        
        //檢查選擇Control Chart時，Group 不能大於1組以上，UCL 或LCL需同時為空或有值避免Center Line計算錯誤
        //檢查選擇Scatter Chart時，Group 不能有值沒有選擇，避免無法產生圖表
        var _checkChartWithGroup = checkChartWithGroup(chartTypeGroup, UCLGroup, LCLGroup); 
        if (_checkChartWithGroup !==''){alert(_checkChartWithGroup); return;}

        //獲得資料
        var o = $("#dg");

        var columnNames = o.jqGrid('getGridParam', 'colNames');//從grid獲得colnames

        var rowNumber = o.jqGrid('getGridParam', 'records');//獲得搜尋後的紀錄筆數

        var postData = o.jqGrid('getGridParam', 'postData');//獲得搜尋條件

        // var getData = o.jqGrid('getGridParam', 'data');//獲得所有jqgrid的資料

        // var dataLo = (lastSearchData == null)? getData: lastSearchData;

        $.ajax({
                async:false,
                url: "Sublimation/export" ,//路徑
                type: "POST",           
                data:{
                    "postData": postData,
                },
                success: function (DownLoadValue){
                    var dataLo = DownLoadValue.success;
                  //產生要寫入excel的data
                    //參數格式: original data -> toolbar data -> toolbar control data 
                    DrowChart( dataLo, 
                            chartTypeGroup, dataXaxisGroup, dataYaxisGroup, 
                            columnNameGroup, itemGroup, 
                            USLGroup, LSLGroup, UCLGroup, LCLGroup, LabelItem, DateItem,
                            YaxisMax, YaxisMin
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
    
            
            $.ajax({
                    async:false,
                    url: "Sublimation/GetDataFromID" ,//路徑
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
    </script>
    
    {{-- Show outlier Log End --}}

@endsection

