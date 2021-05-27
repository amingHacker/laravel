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
<script type="text/javascript" src="{{asset('js/bluebird/bluebird.min.js')}}"></script>


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

{{-- Judge Color Start--}}
<script type="text/javascript" src="{{asset('js/JudgeColor/JudgeColor.js')}}"></script>
{{-- Judge Color End--}}


{{-- CSS設定 Start--}}
<style>
    .text-break {
        white-space: normal !important;
        height:auto;
        vertical-align:text-top;
        padding-top:2px;
    }
    .ui-jqgrid-hdiv { overflow-y: hidden; }
</style>

{{-- CSS設定 End --}}

{{-- Data資料呈現 Start --}}
<script type="text/javascript">
    
    var _todos = @json($todos);
    var combobox_items = [];  //用來儲存colName內容選項
    var productSpec = []; //用來儲存productSpec資訊
    
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

            else if (colName === 'Sampling_date')
            {
                colModel.push(
                    {
                        name:colName, index:colName, width: 150, align:"center",sortable:true, editable:true, cellattr: addCellAttr,
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
                                    autoclose:1
                                });
                            }
                        },                                   
                    }
                );
            }
            else if (colName === 'created_at' || colName === 'updated_at')
            {
                colModel.push(
                    {
                        name:colName, index:colName, width: 150, align:"center",sortable:true, editable:false, cellattr: addCellAttr,
                        sorttype: "date",
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
            else if (colName === 'Equipment'|| colName === 'ProductName' || colName === 'Operator') 
            {
                colModel.push(
                    {
                        name:colName, index:colName, width:100, align:"left",sortable:true, editable:true, cellattr: addCellAttr,
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
            else if (colName === 'Remark')
            {
                colModel.push({name:colName, index:colName, width:350, align:"left", editable:true, cellattr: addCellAttr});
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
            url:"Container_GdSp/show",
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
            gridview: false,
            sortorder: "desc",
            caption:"鋼瓶 Golden Sample",
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
            onRightClickRow:function(rowid, irow, icol, e){
                    
                // showRightClick(rowid, e);
            },
            onSelectRow:function(rowid,status,e){
                // handleClickMouseDown(e);
            },
            rowattr: function (rd){if (rd.determination === 'Fail'){ return {"class": "failRow"};}}                                                            
        }).jqGrid('setFrozenColumns'); 
        
        //增加Tool bar        
        $("#dg").jqGrid('navGrid','#dgPager', { 
                search:true, edit:false, add:false, del:false, refresh:true,
            } 
        );
                
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
                $("#dg").jqGrid('columnChooser');
                }
            });     
        //重新整理功能
        $('.ui-icon-refresh').click(function(){
            lastSearchData = null;
        });

        
            
        //獲得combobox的內容
        combobox_items = getComboboxItem();

        //獲得product SPEC
        // productSpec = getproductSPEC();

        //獲得權限設定
        getAuthority();

        var _ChartTypeSource = ["Scatter Chart", "Control Chart"];
        var _xAxisSource = ["取樣日期", "次數"];
        var _yAxisSource = ["左顯示器(A3)", "右顯示器(A3)", "A3", "左顯示器(Body)", "右顯示器(Body)", "Body",
                            "原始數據(管路)", "原始數據(A3)", "原始數據(Body)", "左顯示器(管路校正)",
                            "右顯示器(管路校正)", "管路校正", "Outlet"
                        ];
        var _GroupSource = ["品名", "標準瓶", "設備", "ALL"
        ];
        
        //建立ToolBar
        var SPCSource = ['A1.超過3個標準差', 'A2.連續九點在中線同一側', 'A3.連續六點呈現上升或下降',
                    'A4.連續三點中的兩點落在2個標準差之外', 'A5.連續五點中的四點落在1個標準差之外',
                ];
        PrepareToToolbar(_ChartTypeSource, _xAxisSource, _yAxisSource, _GroupSource, SPCSource);
        

    });

    /*輸入Database ColumnName 輸出中文 ColumnName*/
    function getColumnNameFromDatabaseToChinese(ColumnName)
    {
        var Result = '';
         //舊key到新key的映射，colName的轉換
        var oldkey = {
            id: "編號",
            Sampling_date: "取樣日期",
            Equipment: "設備",
            StandardBottle: "標準瓶",
            OriginalPipe: "原始數據(管路)",
            OriginalA3: "原始數據(A3)",
            OriginalBody: "原始數據(Body)",
            ProductName: "品名",
            LeftMonitor_PipeCorrection: "左顯示器(管路校正)",	
            RightMonitor_PipeCorrection: "右顯示器(管路校正)",	
            PipeCorrection: "管路校正",
            LeftMonitor_A3: "左顯示器(A3)",
            RightMonitor_A3: "右顯示器(A3)",
            A3: "A3",
            LeftMonitor_Body: "左顯示器(Body)",
            RightMonitor_Body: "右顯示器(Body)",
            Body: "Body",
            Outlet: "Outlet",
            Remark: "備註",
            Operator: "操作人員",
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
            "編號": "id",
            "取樣日期": "Sampling_date", 
            "設備" : "Equipment",
            "標準瓶" : "StandardBottle",
            "原始數據(管路)" : "OriginalPipe",
            "原始數據(A3)" : "OriginalA3",
            "原始數據(Body)" : "OriginalBody",
            "品名" : "ProductName",
            "左顯示器(管路校正)" : "LeftMonitor_PipeCorrection",	
            "右顯示器(管路校正)" : "RightMonitor_PipeCorrection",	
            "管路校正" : "PipeCorrection",
            "左顯示器(A3)" : "LeftMonitor_A3",
            "右顯示器(A3)" : "RightMonitor_A3",
            "A3" : "A3",
            "左顯示器(Body)" : "LeftMonitor_Body",
            "右顯示器(Body)" : "RightMonitor_Body",
            "Body" : "Body",
            "Outlet" : "Outlet",
            "備註" : "Remark",
            "操作人員" : "Operator",
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
    
    /*修改GridView欄位字體顏色*/
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


    /*獲得item內容包含的方法*/
    var selectItemJson; //用來存放item包含的值
    function getComboboxItem(){     
        $.ajax({
            async:false,
            url: "Container_GdSp/GetComboboxItem",//路徑
            type: "Get",
        }).done(function(data){
            selectItemJson = data;
        });
        return selectItemJson;
    }

    /*設定欄位為combobox的方法*/
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

        // Get items from combobox_items array 
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
        
        // Set initial value as original value
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

    /*****獲得產品規格的方法*****/
    var _productSPEC; //用來存放產品規格包含的值
    function getproductSPEC(){     
        $.ajax({
            async:false,
            url: "SamplingRecord/GetproductSPEC",//路徑
            type: "Get",
        }).done(function(data){
            _productSPEC = data;
        });
        return _productSPEC;
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
            if (Authority == undefined)
            {
               
            }
            else
            {
                if (Authority["Add"] == '1')
                { 
                    document.getElementById("New").style.display="";
                    document.getElementById("Save").style.display="";
                    document.getElementById("Cancel").style.display="";
                }
                if (Authority["Edit"] == '1'){ 
                    document.getElementById("Edit").style.display="";
                    document.getElementById("Save").style.display="";
                    document.getElementById("Cancel").style.display="";
                }
                if (Authority["Delete"] == '1'){ 
                    document.getElementById("Delete").style.display="";
                }
                if (Authority["Import"] == '1'){ 
                    document.getElementById("Import").style.display="";
                }
                if (Authority["Export"] == '1'){ 
                    document.getElementById("ExportExcel").style.display="";
                }
                // if (Authority["View_Log"] == '1'){ 
                //     document.getElementById("ViewLog").style.display="";
                // }
                if (Authority["ProductSPEC"] == '1'){
                    sessionStorage.setItem('QC_USER' , "true"); 
                }
            }
        });
    }

    /*初始化選單*/
    $(function() 
    {
        $( "#Chartmenu" ).menu();
        $( "#RightClickmenu" ).menu();
    });

   
</script>
{{-- Data資料呈現 End --}}
 
<meta name="csrf-token" content="{{ csrf_token() }}"> 
    
    <h1 class="my-2"></h1>
  
    <div style = "margin:0px auto;"  >
        <img class=" img-responsive" src="img/Logo_Container_GdSp.png" >   
    </div>
            
    <div align="center">
        <table id="dg" ></table> 
        <div id="dgPager"></div>
    </div>                             

    <div align="center">
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="New" style="display: none"  value="新增" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="Edit" style="display: none" value="編輯" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="Save" style="display: none" disabled="true" value="儲存" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="Cancel" style="display: none" disabled="true" value="取消" />       
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="Delete" style="display: none" value="刪除" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="ExportExcel" style="display: none" value="下載" />
        
        {{-- <div> --}}
        <input id="file" type="file" onchange="Import(this)" style="display: none" />
        <input type="button" onclick="file.click()" class="btn btn-outline-info btn-space" id="Import" style="display: none" value="上傳" />
        {{-- </div> --}}

        <input type="BUTTON" class="btn btn-outline-info btn-space" id="ExportChart" value="圖表" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="CloseChart" value="收合" />
        {{-- <input type="BUTTON" class="btn btn-outline-info btn-space" id="ViewLog" style="display: none" value="紀錄" />    --}}
    
    </div>

    <div id="noChangeDialog" title="No change">
        <p></p>
    </div>

    <div id="warningDialog" title="Warning Information">
        <p></p>
    </div>

    <div id="confirmDialog" title="Comfirm Information">
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

    /*新增列*/
    $("#New").click( function(){
        var ret = $("#dg").jqGrid('getRowData',1);    
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
    
     /*修改列*/
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

     /*儲存列*/
     $("#Save").click( function(){
        var rowIds = $('#dg').jqGrid('getDataIDs');
        var oper = "edit";
        var tJudgeComment = '';
        var tJudgeIncludeFail = 'false';
        //判斷目前是新增或是修改
        for(idIndex = 0; idIndex < rowIds.length; ++idIndex){
           if (rowIds[idIndex] == "0"){oper = "add";}
        }
        //新增
        if (oper == 'add')
        {   
            // Get grid's all columns title and added row data
            var colNames = $("#dg").jqGrid('getGridParam','colNames');
            
            // Get grid's "name" property from colModel for data keys
            var rowKeys = [];
            var colModel = $("#dg").jqGrid("getGridParam", "colModel");
            for (var count = 0; count < colModel.length; count++)
            {
                rowKeys.push(colModel[count]["name"]);
            }
            
            // Fill added row title:data into add_statement
            var add_statement = '';
            var cellvalue = '';
            
            for (var count = 0; count < rowKeys.length; count++)
            {
                // Get key value from rowKeys array
                var key = rowKeys[count];
                
                // Define columns elem by key
                var elem = $("#" + 0 + "_" + key);
                
                // Check if elem type is Checkbox and fill value as True or False
                if (elem.is(':checkbox'))
                {
                    cellvalue = elem.is(':checked') ? 'True' : 'False';
                }
                // Check if column data type is Select and display value as text
                else if (elem.is('select'))
                {
                    cellvalue = elem.find(":selected").text();
                }
                else
                {
                    cellvalue = elem.val();
                }
                
                // Skip uneditable and non-value columns
                if (cellvalue !== undefined && cellvalue !== '')
                {
                    add_statement += colNames[count] + "：" + cellvalue + ", ";
                }
            }
            
            // Remove last 2 character ", "
            add_statement = add_statement.slice(0, -2);
            
            saveparameters = {
                        "successfunc" : null,
                        "url" : 'Container_GdSp/AddandUpdate/'+0,
                        "extraparam" : {
                            "oper": oper,
                            "oper_log":add_statement,
                        },
                        "aftersavefunc" : function( response ) { 
                            $('#dg').trigger( 'reloadGrid' );
                            button_Control('after_Save'); 
                            //window.location.reload(); 
                        }, //重新整理頁面    
                        "errorfunc": null,
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
            var empty_result = true;
            var edit_statement = '';
            sessionStorage.setItem('CustomerSPEC_table_name', '');
            sessionStorage.setItem('CustomerSPEC_table_col_name', '');
          
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
                    if (cellvalue == 'Fail')
                    {   
                        tJudgeIncludeFail = 'true';      
                    }               
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
                    empty_result = false;
                }
            }

            // If nothing changed
            if (empty_result === true)
            {
                $("#noChangeDialog").dialog({modal:true, focus: function() { $(".ui-dialog").focus(); }, buttons : {"返回" : function() {$(this).dialog("close");}}});
            }     
            else
            {
                if (tJudgeIncludeFail == 'true' && sessionStorage.getItem('QC_USER') == 'true')
                {
                    //SamplingRecord_ReadyToDataBase(result, edit_statement, tJudgeComment, target_id, ret, oper);
                    var tmp = judgeFailEvent(ret.id); // JudgeColor/JudgeColor.js
                    sessionStorage.setItem('judgeComment', '');  //初始這些Session
                    sessionStorage.setItem('CustomerSPEC_table_name' ,''); //初始這些Session
                    sessionStorage.setItem('CustomerSPEC_table_col_name' , ''); //初始這些Session
                    sessionStorage.setItem('MailToMember' , ''); //初始這些Session
                    var dataImport; //用來承接promise方法的回傳參數
                    tmp.then(function (dataImport) 
                    {   
                        
                        tJudgeComment = dataImport["judgeComment"];
                        sessionStorage.setItem('MailToMember' , dataImport["MailTo"]); 
                        SamplingRecord_ReadyToDataBase(result, edit_statement, tJudgeComment, target_id, ret, oper);                                         
                    })           
                }
                else
                {
                    SamplingRecord_ReadyToDataBase(result, edit_statement, tJudgeComment, target_id, ret, oper);
                }
            }                                     
        }
     });

     function SamplingRecord_ReadyToDataBase(result, edit_statement, tJudgeComment, target_id, ret, oper){
        var htmlStr = "<br />您變更的值如下：<br /><br />";     
        var addstring = "";    
        // Display changed title:value in confirm dialog
        for (var key in result)
        {
            
            // Transform Null values to 'Empty' string for display
            var value_before = (result[key][1] === "") ? 'Null' : result[key][1];
            var value_after = (result[key][2] === "") ? 'Null' : result[key][2];
            
            // Generate log statement with changed values
            edit_statement += result[key][0] + "：\"" + value_before + "\" to \"" + value_after + "\", ";
            
            // Generate dialog html to display
            addString = "<strong>" + result[key][0] + "</strong>" + "：變更 " + "<strong>" + value_before + "</strong>" + " 為 " + "<strong>" + value_after + "</strong><br />";
            htmlStr += addString;
        }
        
        edit_statement = '[ ' + '編號' + '：' + target_id + ' ] ' + edit_statement;
        edit_statement = edit_statement.slice(0, -2);
        htmlStr += "<br />確定要修改所選的資料嗎?<br /><br />";
        if (tJudgeComment != '')
        {     
            htmlStr += "異常事件:" + tJudgeComment;
        }
        

        $("#confirmDialog").html(htmlStr);
        $("#confirmDialog").dialog({
            width:'auto', height:'auto', autoResize:true, modal:true, closeText:"關閉", resizable:false,
            show:{effect: "fade", duration: 140},
            hide:{effect: "clip", duration: 140},
            focus: function() { $(".ui-dialog").focus(); }, // Unfocus the default focus elem
            buttons : {
                "確認" : function() {
                        $(this).dialog("close");
                        saveparameters = 
                        {
                            "successfunc" : function( response ) {
                                            $('#dg').trigger( 'reloadGrid' );
                                            if (response["responseJSON"]["success"]["determination"]=='Fail')
                                            {
                                                $.ajax({
                                                    url: "/AbnormalEventMail",//路徑
                                                    type: "post",           
                                                    data:{
                                                        "id": response["responseJSON"]["success"]["id"],
                                                        "product_name": response["responseJSON"]["success"]["product_name"],
                                                        "level": response["responseJSON"]["success"]["level"],
                                                        "batch_number": response["responseJSON"]["success"]["batch_number"],
                                                        "equipment_name": response["responseJSON"]["success"]["equipment_name"],
                                                        "remarks": response["responseJSON"]["success"]["remarks"],
                                                        "JudgeComment": response["responseJSON"]["success"]["JudgeComment"],
                                                        "MailToMember": sessionStorage.getItem('MailToMember'), 
                                                    },
                                                    success: function (response){
                                                        var aaa = response;
                                                    }                               
                                                }); 
                                            }
                                        },
                            "url" : 'Container_GdSp/AddandUpdate/'+ret.id,
                            "extraparam" : {                                   
                                "id" : ret.id,
                                "oper" : oper,
                                "oper_log": edit_statement,
                                "JudgeComment":tJudgeComment,
                                "ProductSPEC_Table" : sessionStorage.getItem('CustomerSPEC_table_name'),
                                "ProductSPEC_Table_Col": sessionStorage.getItem('CustomerSPEC_table_col_name'),                             
                                },
                            "aftersavefunc" :function( response ) {
                                            
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

     $("#Cancel").click( function(){
        target_id = 'none';
        var rowIds = $('#dg').jqGrid('getDataIDs'); 
        for(idIndex = 0; idIndex < rowIds.length; ++idIndex){           
            $("#dg").jqGrid('restoreRow',rowIds[idIndex], true); 
        }
        button_Control('after_Cancel');    
     });

      /*刪除列*/    
      $("#Delete").click( function() { 
         var s = $("#dg").jqGrid('getGridParam','selrow');      
         if (s)	{
             var ret = $("#dg").jqGrid('getRowData',s);        
             var answer = window.confirm("確認刪除此筆資料?");
             if (answer)
             {
                // Get grid's all column names (title) and selected row data for delete_statement
                var colNames = $("#dg").jqGrid('getGridParam', 'colNames');
                var rowData = $("#dg").jqGrid('getRowData', s);
                    
                // Fill added row title:data into delete_statement
                var delete_statement = '';
                var i = 0;
                for (key in rowData)
                {
                    var cellvalue = rowData[key];
                    
                    // Insert [ ] charateer for id column
                    if (key === 'id')
                        delete_statement = '[ ' + colNames[i] + '：' + cellvalue + ' ] ' + delete_statement;
                    else
                        delete_statement += colNames[i] + "：" + cellvalue + ", ";
                        
                    i++;
                }
                    
                // Remove last 2 character ", "
                delete_statement = delete_statement.slice(0, -2);

                $.ajax({
                    url: "Container_GdSp/delete/" + ret.id ,//路徑
                    type: "post",           
                    data:{
                        "id": ret.id,
                        "oper_log": delete_statement,
              
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

    /*Buttons control function*/
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

    /*顯示Log紀錄*/
    $("#ViewLog").click( function() {
        var table = "viewLog";
        var pcontent = '<span style="font-weight:bold; color:#2e6e9e;">《 資料處理紀錄 Data Log 》</span><br /><br />' + '<table id= '+ table + '></table><div id="viewLogPager"></div>';
        
        //建立動態表格
        $("#confirmDialog").html(pcontent);
        
        var colNames = [];
        var colModel = [];
        colNames = ['時間','使用者','動作','描述'];
        colModel = 
        [
            {
                name:'added_on', index:'added_on', align:"center", width:140, frozen:false, sortable:true,
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
            },
            {name:'user', align:"center", width:120, index:'user', classes: "text-break", search:true, searchoptions:{sopt:['cn','nc','eq']}},
            {name:'action', align:"center", width:70, index:'action', search:true, searchoptions:{sopt:['cn','nc','eq']}},
            {name:'description', width:520, index:'description', classes: "text-break", search:true, searchoptions:{sopt:['cn','nc','eq']}}
        ];
        

         // 準備資料           
         $("#" + table).jqGrid({
            url:"SamplingRecord/showOperLog",
            mtype : "GET",
            datatype: "json",        
            altrows:false,
            width: 890,
            height:'100%',
            colNames:colNames,
            colModel:colModel,
            multiselect:false,
            rowNum:10,
            rowList:[10,20,50],
            pager: '#viewLogPager',
            sortname: 'id',
            viewrecords: true,
            gridview: false,
            sortorder: "desc",
            caption:"紀錄 Log",
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
                            order: "order"
                        },

            loadComplete: function (){ 
                fixPositionsOfFrozenDivs.call(this);
            }, // Fix column's height are different after enable frozen column feature                                                           
        }).jqGrid('setFrozenColumns'); 
        
        
        $("#" + table).jqGrid('setFrozenColumns');
        //增加Tool bar        
        $("#" + table).jqGrid('navGrid','#viewLogPager', { search:true, edit:false, add:false, del:false, refresh:true } );
            
        $("#confirmDialog").dialog({
            width:'auto', height:'600', autoResize:true, modal:true, closeText:"關閉", 
            resizable:true, closeOnEscape:true, dialogClass:'top-dialog',position:['center',168],
            show:{effect: "blind", duration: 300},
            hide:{effect: "blind", duration: 300},
           
            focus: function() { $(".ui-dialog").focus(); }, // Unfocus the default focus elem
            buttons : {
                "確認" : function() {   
                    $(this).dialog("close");        
                },       
            }
        });  
    });

</script>
{{-- 表單送出方法 inline End --}}


{{-- 表單輸出、輸入功能 Start--}}
<script type="text/javascript">
    
    /*產生Excel檔案*/
    $("#ExportExcel").click(function(){        
        
        var o = $("#dg");
        
        var columnNames = o.jqGrid('getGridParam', 'colNames');//從grid獲得colnames

        var rowNumber = o.jqGrid('getGridParam', 'records');//獲得搜尋後的紀錄筆數
        
        var postData = o.jqGrid('getGridParam', 'postData');//獲得搜尋條件

        var getData = o.jqGrid('getGridParam', 'data');//獲得所有jqgrid的資料
        
        //o.jqGrid('setGridParam', { rowNum: rowNumber }).trigger('reloadGrid', [{current:true}]);//此方式可能會lag                  
        
        var rowData = o.jqGrid('getRowData');//獲得目前顯示在表格上的資料

        if(rowNumber > 10000){
            alert("下載筆數超過10000筆，請重新縮小範圍再進行下載。(The record is more than 10000, please smaller the range and download again.) ");
            return;
        }

        $.ajax({
                async:false,
                url: "Container_GdSp/export" ,//路徑
                type: "POST",           
                data:{
                    "postData": postData,
                },
                success: function (DownLoadValue){
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
                    var filename = myDate + '-' + 'Container_GdSp.xlsx';

                    //表名
                    var sheetname = 'Sheet';

                    //下載
                    downloadxlsx(filename, sheetname, dataToExcel);                                     
                    }                               
                });    
    });

    /*上傳資料*/
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
                "編號": "id",             
                "取樣日期": "Sampling_date",
                "設備": "Equipment",
                "標準瓶": "StandardBottle",
                "原始數據(管路)" : "OriginalPipe",
                "原始數據(A3)" : "OriginalA3",
                "原始數據(Body)" : "OriginalBody",
                "品名" : "ProductName",
                "左顯示器(管路校正)" : "LeftMonitor_PipeCorrection",	
                "右顯示器(管路校正)" : "RightMonitor_PipeCorrection",	
                "管路校正" : "PipeCorrection",
                "左顯示器(A3)": "LeftMonitor_A3",
                "右顯示器(A3)": "RightMonitor_A3",                
                "左顯示器(Body)": "LeftMonitor_Body",
                "右顯示器(Body)": "RightMonitor_Body",     
                "操作人員" : "Operator",                
                "備註" : "Remark", 
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
                height: 'auto',
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
                gridComplete: function() { $("#" + table).jqGrid('setFrozenColumns');}
            });
            
            //增加Tool bar        
            $("#" + table).jqGrid('navGrid','#import_previewPager', { search:true, edit:false, add:false, del:false, refresh:true } );
        
            $("#confirmDialog").dialog({
                width:'auto', height:'auto', autoResize:true, modal:true, closeText:"關閉", 
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
                            $("#confirmDialog").html('<span style="font-weight:bold; color:#2e6e9e;">《 上傳進度 》</span><br /><br /><div id="progressbar"></div>');                                                                                                        
                            $("#confirmDialog").next(".ui-dialog-buttonpane button:contains('確定')").attr("disabled", true);
                            $("#button-OK").button("disable");
                            $("#button-cancel").button("disable");
                            for (var i = 0; i < data.length; i++) 
                            {                              
                                setTimeout((function (i) {                      
                                    return function () {                                                                       

                                        $.ajax({
                                            url: 'Container_GdSp/FileUpload/' + data[i].編號,
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
                                                        {                                                                                                                    //window.location.reload();
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
            LabelItem.push("StandardBottle");
            DateItem.push("Sampling_date");
            
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
        var o = $("#dg");

        var columnNames = o.jqGrid('getGridParam', 'colNames');//從grid獲得colnames

        var rowNumber = o.jqGrid('getGridParam', 'records');//獲得搜尋後的紀錄筆數

        var postData = o.jqGrid('getGridParam', 'postData');//獲得搜尋條件

        $.ajax({
                async:false,
                url: "Container_GdSp/export" ,//路徑
                type: "POST",           
                data:{
                    "postData": postData,
                },
                success: function (DownLoadValue){
                    var dataLo = DownLoadValue.success;
                    //產生要寫入excel的data
                    //參數格式: original data -> toolbar data -> toolbar control data 
                        DrowChart( 'Golden Sample', dataLo, 
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

        
        $.ajax({
                async:false,
                url: "Container_GdSp/GetDataFromID" ,//路徑
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
  
    $.ajax({
            async:false,
            url: "Container_GdSp/GetDataFromID" ,//路徑
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
</script>

{{-- Show outlier Log End --}}


@endsection
