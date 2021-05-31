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

{{-- Judge Color Start--}}
<script type="text/javascript" src="{{asset('js/JudgeColor/JudgeColor.js')}}"></script>
{{-- Judge Color End--}}

{{-- Google Font Start --}}
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
{{-- Google Font End --}}

{{-- CSS設定 Start--}}
<style type="text/css">
    .ui-jqgrid-hdiv { overflow-y: hidden; }
    .ui-tabs
    {
        width:72%;
    }
    section{
        /* background-color: #D1E4EE; */
        background-color: #D1E4EE;
        
        color: blue;
    }

    section article{
        height: 15eM;
        border: sold 1px black;
    }

    aside{
        background-color: #D1E4EE;
    }

    aside div{
        height: 5eM;
        background-color: #D1E4EE;
        color: black;
    }

    .Gridtabs{
        width: 82%;
        height: 90%;

    }
    .center{
        margin: 0 auto;
        float: none;
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
            "料號": "Material",
            "品名": "Material_Description",  
            "料號型別": "Material_Type",  
            "廠區": "Plant",
            "SAP位置":"Storage_Location",
            "料品狀態":"Descr_of_Storage_Loc",
            "批號":"Batch",
            "基礎單位":"Base_Unit_of_Measure",
            "可用量":"Unrestricted",
            "添加物批號":"additives_number",
            "幣別":"Currency",
            "Value未受限量":"Value_Unrestricted",
            "過渡":"Transit_and_Transfer",
            "過渡量":"Val_in_Trans_Tfr",
            "檢驗中":"In_Quality_Insp",
            "限制使用":"Restricted_Use_Stock",
            "VGRBS.":"Valuated_Goods_Receipt_Blocked_Stock",
            "Blocked":"不可用",
            "建立時間" : "created_at",
            "更新時間" : "updated_at" ,
            "庫存":"InventoryInstock",
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
            "Material":"料號",
            "Material_Description": "品名",  
            "Material_Type": "料號型別",  
            "Plant":"廠區",
            "Storage_Location":"SAP位置",
            "Descr_of_Storage_Loc":"料品狀態",
            "Batch":"批號",
            "Base_Unit_of_Measure":"基礎單位",
            "Unrestricted":"可用量",
            "additives_number":"添加物批號",
            "Currency":"幣別",
            "Value_Unrestricted":"Value未受限量",
            "Transit_and_Transfer":"過渡",
            "Val_in_Trans_Tfr":"過渡量",
            "In_Quality_Insp":"檢驗中",
            "Restricted_Use_Stock":"限制使用",
            "Valuated_Goods_Receipt_Blocked_Stock":"VGRBS.",
            "Blocked":"不可用",
            "created_at" : "建立時間" ,
            "updated_at" : "更新時間" ,
            "InventoryInstock": "庫存",
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

    var InventoryInstock = @json($todosInventoryInstock);

    var _todoList = {
            InventoryInstock: InventoryInstock,  
        };
    var combobox_items = [];  //用來儲存colName內容選項

    $(document).ready(function () {
        sessionStorage.setItem("Se_RawMaterial", ""); //初始化RawMaterial      
        var i = 0;
        for(var _todoP in _todoList ){       
            ShowTable(_todoP, i);
            i++;
        }
        setTimeout(Showtab,1000);
        getAuthority();

        //獲得combobox的內容
        combobox_items = getComboboxItem();

        //紀錄料號描述、儲位、，在產生toolbar時可以使用
        var item_Material = [];
        var item_Storage_Location = [];
        var item_Descr_of_Storage_Loc = [];
        var item_Batch = [];
        
        for (var i in combobox_items)
        {
            if(i == "Material_Description")
            {
                for(var j in combobox_items[i])
                {
                    item_Material.push(combobox_items[i][j][i]);
                }
            }
           

            if(i == "Storage_Location")
            {
                for(var j in combobox_items[i])
                {
                    item_Storage_Location.push(combobox_items[i][j][i]);
                }
            }

            if(i == "Descr_of_Storage_Loc")
            {
                for(var j in combobox_items[i])
                {
                    item_Descr_of_Storage_Loc.push(combobox_items[i][j][i]);
                }
            }

            if(i == "Batch")
            {
                for(var j in combobox_items[i])
                {
                    item_Batch.push(combobox_items[i][j][i]);
                }
            }
            
        }

        sessionStorage.setItem('Material_Description', item_Material);
        sessionStorage.setItem('Storage_Location', item_Storage_Location);
        sessionStorage.setItem('Descr_of_Storage_Loc', item_Descr_of_Storage_Loc);
        sessionStorage.setItem('Batch',  item_Batch);

        //test 建立ToolBar
        var _ChartTypeSource = ["Bar Chart"];
        var _xAxisSource = ["品名"];
        var _yAxisSource = ["可用量", "檢驗中"];
        var _GroupSource = ["SAP位置", "料品狀態", "批號", "ALL"];
    
        
        PrepareToInventoryToolbar(_ChartTypeSource, _xAxisSource, _yAxisSource, _GroupSource, item_Material, item_Storage_Location, item_Descr_of_Storage_Loc, item_Batch); 

       
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
            if (colName === 'Material')
            {           
                colModel.push(
                        {name:colName, index:colName, width:100, align:"center",sortable:true,  stype:'text', frozen: true, editable:false, cellattr: addCellAttrID}
                    );
            }
            else if (
                colName === 'Material_Description'
            )
            {
                colModel.push(
                    {
                        name:colName, index:colName, width:180, align:"center",sortable:true, editable:true, cellattr: addCellAttr, frozen: false,
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
            else if (
                colName === 'Storage_Location' || colName === 'Descr_of_Storage_Loc'
            
            )
            {
                colModel.push(
                    {
                        name:colName, index:colName, width:125, align:"center",sortable:true, editable:true, cellattr: addCellAttr, frozen: false,
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
            url:"InventoryInstock/show/"+_todoP,
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
            sortname: 'Material',
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
           
            postData:{
                    UserFilter:sessionStorage.getItem("Se_RawMaterial"),
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
                        url: "/InventoryInstock/export" ,//路徑
                        type: "POST",           
                        data:{
                                "postData": postData,
                                "table":table,
                                "caption": caption,
                                "UserFilter":sessionStorage.getItem("Se_RawMaterial"),
                        },
                        success: function (DownLoadValue){
                                
                                var dataLo = DownLoadValue.success;
                                var _xAxis = [];
                                
                                //紀錄Material_Description，寫到session中，用以產生選項。
                                for( var key in dataLo)
                                {
                                    if(_xAxis.indexOf(dataLo[key]["Material_Description"]) == -1)
                                    {
                                        _xAxis.push(dataLo[key]["Material_Description"]); 
                                    }
                                }

                                sessionStorage.setItem('_xAxis', _xAxis);

                                var item_Material = sessionStorage.getItem('Material_Description');
                                var item_Storage_Location = sessionStorage.getItem('Storage_Location');
                                var item_Descr_of_Storage_Loc = sessionStorage.getItem('Descr_of_Storage_Loc');
                                var item_Batch = sessionStorage.getItem('Batch');

                                //test 建立ToolBar
                                var _ChartTypeSource = ["Bar Chart"];
                                var _xAxisSource = ["品名"];
                                var _yAxisSource = ["可用量", "檢驗中"];
                                var _GroupSource = ["SAP位置", "料品狀態", "批號", "ALL"];
                                var num_tabs = $("#tabs ul li").length + 1;

                                //紀錄目前toolbar的資訊
                           
                                for(var i = 1; i < num_tabs; i++)
                                {
                                    //獲得Toolbar的資料
                                    var _xdataTmp = [];
                                    var _ydataTmp = [];
                                    var tools = $("#jqxInventoryToolBar" + (i)).jqxToolBar("getTools");
                                    
                                    var dataXaxis = $(tools[1].tool[0]).jqxDropDownList('getCheckedItems');
                                    for(var t = 0; t < dataXaxis.length; t++)
                                    {
                                        _xdataTmp.push(dataXaxis[t]["label"]);
                                    }         
                                    
                                    var dataYaxis = $(tools[3].tool[0]).jqxDropDownList('getCheckedItems');
                                    for(var t = 0; t < dataYaxis.length; t++)
                                    {
                                        _ydataTmp.push(dataYaxis[t]["label"]);
                                    }
                                    
                                    var columnNameIndex = $(tools[5].tool[0]).jqxComboBox('selectedIndex');
                                    var item = tools[6].tool[0].value;

                                    destoryToolbar("jqxInventoryToolBar" + i, 6);
                                    destoryToolbar("jqxInventoryToolBar" + i, 5);
                                    destoryToolbar("jqxInventoryToolBar" + i, 4);
                                    destoryToolbar("jqxInventoryToolBar" + i, 3);
                                    destoryToolbar("jqxInventoryToolBar" + i, 2);
                                    destoryToolbar("jqxInventoryToolBar" + i, 1);
                                    
                                    addToolbar("jqxInventoryToolBar" + i, "dropdownlist", "last", _xAxis, true);
                                    addToolbar("jqxInventoryToolBar" + i, "toggle", "last", "Y axis:", false);
                                    addToolbar("jqxInventoryToolBar" + i, "dropdownlist", "last", _yAxisSource, false);
                                    addToolbar("jqxInventoryToolBar" + i, "toggle", "last", "Column:", false);
                                    addToolbar("jqxInventoryToolBar" + i, "combobox", "last", _GroupSource, false);
                                    addToolbar("jqxInventoryToolBar" + i, "input", "last", "", false);
                                    
                                    //重新填入toolbar資訊
                                    var toolsNew = $("#jqxInventoryToolBar" + (i)).jqxToolBar("getTools");
                                    if(dataXaxis.length != 0)
                                    {
                                        for(var j = 0; j < _xdataTmp.length; j++)
                                        {
                                            $(toolsNew[1].tool[0]).jqxDropDownList('checkItem',_xdataTmp[j]);
                                        } 
                                    }
                                    if(dataYaxis.length != 0)
                                    {
                                        for(var j = 0; j < _ydataTmp.length; j++)
                                        {
                                            $(toolsNew[3].tool[0]).jqxDropDownList('checkItem',_ydataTmp[j]);
                                        }
                                    }
                                    
                                    $(toolsNew[5].tool[0]).jqxComboBox('selectedIndex', columnNameIndex);
                                    $(toolsNew[6].tool[0]).jqxInput('val', item );     
                                }
                            }                                  
                        });    

            },
            onRightClickRow:function(rowid, irow, icol, e){
                    
                //showRightClick(rowid, e);
            },
            onSelectRow:function(rowid,status,e){
                //handleClickMouseDown(e);
            },                                                          
        }); 


        //增加Tool bar        
        $("#" + table).jqGrid('navGrid','#' + table + "pager", { search:true, edit:false, add:false, del:false, refresh:true } );
                
        //增加更多的搜尋條件
        $.extend($.jgrid.search, {
                    multipleGroup:true,
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

        // //設定多層的標題檔
        // $("#" + table).jqGrid('setGroupHeaders', {
        //                 useColSpanStyle: true, 
        //                 groupHeaders:[
        //                     {startColumnName: 'founder', numberOfColumns: 6, titleText: '分裝人員填入'},
        //                     {startColumnName: 'product_batch_number', numberOfColumns: 2, titleText: '分裝人員填入'},
        //                     {startColumnName: 'container_base_weight_ideal', numberOfColumns: 3, titleText: '空重確認'},
        //                     {startColumnName: 'container_doing_weight_ideal', numberOfColumns: 4, titleText: '分裝後總重確認'},
        //                     {startColumnName: 'container_packaging_weight_ideal', numberOfColumns: 3, titleText: '包裝人員總重確認'},
        //                     {startColumnName: 'container_addpackaging_weight_ideal', numberOfColumns: 3, titleText: '加包材後總重'},
        //                 ]
        //             }); 
        $("#" + table).jqGrid('setFrozenColumns');


        },i * 20);  
    }

    function getAuthority(){
        var User = "<?php echo $_SERVER['REMOTE_USER']; ?>";
        var Authority = '';
        $.ajax({
            async:false,
            url: "BalanceAuthority/GetAuthority",//路徑
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
                // if (Authority["Add"] == '1')
                // { 
                //     document.getElementById("New").style.display="";
                //     document.getElementById("Save").style.display="";
                //     document.getElementById("Cancel").style.display="";
                // }
                // if (Authority["Edit"] == '1'){ 
                //     document.getElementById("Edit").style.display="";
                //     document.getElementById("Save").style.display="";
                //     document.getElementById("Cancel").style.display="";
                // }
                // if (Authority["Delete"] == '1'){ 
                //     document.getElementById("Delete").style.display="";
                // }
                // if (Authority["Import"] == '1'){ 
                //     document.getElementById("Import").style.display="";
                // }
                // if (Authority["Export"] == '1'){ 
                //     document.getElementById("ExportExcel").style.display="";
                // }        
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
                //ChangeToolbar(ui.tab.innerHTML);
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
        $('#' + table ).trigger( 'reloadGrid', [{current: true}] );   
    }

    /*****獲得item內容包含的方法*****/
    var selectItemJson; //用來存放item包含的值
    function getComboboxItem(){
        
        $.ajax({
            async:false,
            url: "InventoryInstock/GetComboboxItem",//路徑
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
        
        var table = getColumnNameFromChineseToDatabase($("#Gridtabs .ui-tabs-active").text()); //呈現此table的title

        var name = options.name; //獲得column name

        if (name == undefined){name = options.searchColName;}
        
        // Get column width value and calculate for JQWidgets combobox
        var width = $("#dg" + table + "_" + name).width() - 2;       
        
        // Get column width value and calculate for JQWidgets combobox
        var height = $("#dg" + table + "_" + name).height() - 2;       

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
<h1 class="my-4"></h1> 
<div class="container-fluid">
    <div class="row">
        <div class="col-md-1"> 
            <button class="btn btn-outline-info btn-space btn-block" type="button" id = "SearchInstock_RawMaterial" >
                <i class="material-icons">category</i>Raw
            </button>
            <button class="btn btn-outline-info btn-space btn-block" type="button" id = "SearchInstock_Finished" >
                <i class="material-icons">search</i>成品
            </button>
            <button class="btn btn-outline-info btn-space btn-block" type="button" id = "SearchInstock_Chemical" >
                <i class="material-icons">science</i>化學品
            </button>         
            <button class="btn btn-outline-info btn-space btn-block" type="button" id = "SearchContainer">
                <i class="material-icons">luggage</i>鋼瓶
            </button>         
       
        </div>
        <div class="col-md-10" id ="Gridtabs" class="Gridtabs"> 
            <ul class = "row ">
                <li><a href="#Gridtabs-1">庫存</a></li>
                <li><a href="#Gridtabs-2">RawMaterial</a></li>
                <li><a href="#Gridtabs-3">成品</a></li>
                <li><a href="#Gridtabs-4">化學品</a></li>
                <li><a href="#Gridtabs-5">鋼瓶</a></li>
            </ul>
            <div id = "Gridtabs-1" >
                <div class = "row">
                <table id="dgInventoryInstock" ></table> 
                <div id="dgInventoryInstockpager"></div>
                </div>                             
            </div>   
        </div>
    </div>
</div>

    <div align = "center">
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="ExportChart" value="圖表" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="CloseChart" value="收合" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="MyFavorite" value="我的最愛" />
    </div>  


    {{-- <h1 class="my-2"></h1> --}}
    {{-- <div style = "margin:0px auto;"  >
        <img class=" img-responsive" src="img/Logo_Container_Balance.png" >   
    </div>   --}}

    <div align="center">
        <div id="warningDialog" title="Warning Information">
            <p></p>
        </div>

        <div id="confirmDialog" title="Comfirm Information">
            <p></p>
        </div>
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
        <div id="jqxInventoryToolBar1" style = "margin:0px auto; text-align:justify" ></div>
        <h1 class="my-1"></h1>
        
    </div>
</div>
{{-- Tab ToolBar End --}}    

{{-- Chart Start --}}
<div id = canvas_div style="width:70%; margin:0px auto; display: none;" >
    <canvas id="canvas" ></canvas>
</div>
{{-- Chart End --}}


{{-- Chart選單 Start --}}
{{-- <ul id="Chartmenu" style="display:none;" >
<li><a href="#" onclick="saveoutlierChartData();return false;"><span class="ui-icon ui-icon-disk"></span>Save</a></li>
<li><a href="#" onclick="removeChartData();return false;"><span class="ui-icon ui-icon-trash"></span>Delete</a></li>
<li><a href="#" onclick="viewChartData();return false;"><span class="ui-icon ui-icon-search"></span>View</a></li>
</ul> --}}
{{-- Chart選單 End --}}

{{-- RightClick選單 Start --}}
{{-- <ul id="RightClickmenu" style="display:none;" >
<li><a href="#" onclick="SearchContainer();return false;"><span class="ui-icon ui-icon-document"></span>查詢</a></li>
</ul> --}}
{{-- RightClick選單 End --}}

{{-- 篩選條件 Start --}}
<script type="text/javascript">
/*顯示Log紀錄*/
    $("#SearchInstock_RawMaterial").click( function() {

        var pcontent = '';

        if (sessionStorage.getItem('Se_RawMaterial') != "" )
        {
            pcontent= '<span style="font-weight:bold; color:#2e6e9e;">《 篩選條件 》</span><br /><br />'
            + '<p>RawMaterial: <table><td><div id="jqxcbx_RawMaterial"></div></td><td><input type="BUTTON"  onclick="addToConfirm()" id="QueryContainer" value="確定" /></td></table></p>'
            + '</br>';
            var _tmp = sessionStorage.getItem('Se_RawMaterial').split(',');
        
            for(var key in _tmp)
            {        
                if (_tmp[key]!='')
                {
                    pcontent = pcontent + '<table><td>'+ _tmp[key]+ '</td><td>'+ '<input type="BUTTON" onclick= \'deleteFromConfirm("'+_tmp[key]+'")\' value="刪除" /></td></table>';
                }
            }
        }
        else
        {
            pcontent = '<span style="font-weight:bold; color:#2e6e9e;">《 篩選條件 》</span><br /><br />'
            + '<p>RawMaterial: <table><td><div id="jqxcbx_RawMaterial"></div></td><td><input type="BUTTON"  onclick="addToConfirm()" id="QueryContainer" value="確定" /></td></table></p>'
            + '</br>';
        }
        //sessionStorage.setItem('Se_RawMaterial', "");//清除RawMaterial session

      
        
        //建立動態表格
        $("#confirmDialog").html(pcontent);
        
            
        $("#confirmDialog").dialog({
            width:'auto', height:'auto', autoResize:true, modal:true, closeText:"關閉", 
            resizable:true, closeOnEscape:true, dialogClass:'top-dialog',position:['center',168],
            show:{effect: "blind", duration: 300},
            hide:{effect: "blind", duration: 300},
           
            focus: function() { $(".ui-dialog").focus(); }, // Unfocus the default focus elem
            buttons : {
                "確認" : function() {   
                    $(this).dialog("close");
                    var table = "dgInventoryInstock" ;
                    $('#' + table ).jqGrid('setGridParam', { 
                            postData: {"UserFilter":sessionStorage.getItem("Se_RawMaterial")},
                            
                    }).trigger('reloadGrid'); 
                },              
            }
        });


        $.ajax({
                async:false,
                url: "InventoryInstock/Get_Condition" ,//路徑
                type: "POST",           
                data:{
                    "table":"RawMaterial",
                },
                success: function (DownLoadValue)
                    {
                   
                        var sourceRawMaterial = DownLoadValue.success;
                        var _data = [];
                        for (var key in sourceRawMaterial)
                        {
                            _data.push(sourceRawMaterial[key]["Material_Description"]);
                        }

                        $("#jqxcbx_RawMaterial").jqxComboBox({ source:  _data , selectedIndex: -1, width: '200px', height: '25' });
                        
                    }                               
                });      
    
    });


    $("#SearchInstock_Finished").click( function() {
        var table = "viewLog";
    
        var pcontent = '<span style="font-weight:bold; color:#2e6e9e;">《 篩選條件 》</span><br /><br />'
        + '<p>成品: <input type="text" id="dateStartFrom"> <input type="BUTTON"  onclick="ShowContainerComplete()" id="QueryContainer" value="確定" /></p>'
        + '</br>'
        + '<table id= '+ table + '></table><div id="viewLogPager"></div>';
        
        //建立動態表格
        $("#confirmDialog").html(pcontent);
        
            
        $("#confirmDialog").dialog({
            width:'auto', height:'auto', autoResize:true, modal:true, closeText:"關閉", 
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

    $("#SearchInstock_Chemical").click( function() {
        var table = "viewLog";
    
        var pcontent = '<span style="font-weight:bold; color:#2e6e9e;">《 篩選條件 》</span><br /><br />'
        + '<p>化學: <input type="text" id="dateStartFrom"> <input type="BUTTON"  onclick="ShowContainerComplete()" id="QueryContainer" value="確定" /></p>'
        + '</br>'
        + '<table id= '+ table + '></table><div id="viewLogPager"></div>';
        
        //建立動態表格
        $("#confirmDialog").html(pcontent);
        
            
        $("#confirmDialog").dialog({
            width:'auto', height:'auto', autoResize:true, modal:true, closeText:"關閉", 
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

    $("#SearchContainer").click( function() {
        var table = "viewLog";
    
        var pcontent = '<span style="font-weight:bold; color:#2e6e9e;">《 篩選條件 》</span><br /><br />'
        + '<p>鋼瓶: <input type="text" id="dateStartFrom"> <input type="BUTTON"  onclick="ShowContainerComplete()" id="QueryContainer" value="確定" /></p>'
        + '</br>'
        + '<table id= '+ table + '></table><div id="viewLogPager"></div>';
        
        //建立動態表格
        $("#confirmDialog").html(pcontent);
        
            
        $("#confirmDialog").dialog({
            width:'auto', height:'auto', autoResize:true, modal:true, closeText:"關閉", 
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
{{-- 篩選條件 End --}}


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
                url: "/InventoryInstock/export" ,//路徑
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
                    var filename = myDate + '-' + $("#Gridtabs .ui-tabs-active").text()+ '-'+ 'ContainerBalance.xlsx';

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
                "鋼瓶秤重紀錄": "Container_Balance",
                "鋼瓶空重": "Container_Baseweight",  
                "料號重量": "Material_Order",  
                "包材重量": "Packaging_Weight",

                "日期":"working_date",
                "建立人":"founder",
                "料號":"material_number",
                "客戶名稱":"customer",
                "原料鋼瓶":"original_container",
                "添加物批號":"additives_number",
                "TSMC持壓":"TSMC_remark",
                "訂購重量(G)":"order_weight",
                "成品分裝批號":"product_batch_number",
                "瓶號":"bottle_number",
                "鋼瓶空重(G)":"container_base_weight_ideal",
                "實秤空重(G)":"container_base_weight_real",
                "實秤空重操作人員":"container_base_weight_operator",
                "總重量(G)":"container_doing_weight_ideal",
                "實秤總重量(G)":"container_doing_weight_real",
                "氣室重量(G)":"container_doing_weight_air",
                "實秤總重操作人員":"container_doing_weight_operator",

                "淨重(G)":"container_packaging_weight_ideal",
                "實秤總重量(包裝)(G)":"container_packaging_weight_real",
                "實秤總重操作人員(包裝)":"container_packaging_weight_operator",

                "包材重(G)":"container_addpackaging_weight_ideal",
                "實秤總重量(含包材)(G)":"container_addpackaging_weight_real",
                "實秤總重操作人員(包材)":"container_addpackaging_weight_operator",

                "鋼瓶基礎值":"bottle_weight",
                "包材基準值" :"packaging_weight",

                "備註":"remark",       
                "建立時間" : "created_at",
                "更新時間" : "updated_at" ,
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
                                            url: 'ContainerBalance/FileUpload/' + data[i].id,
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
       var columnNameGroup = [];    //紀錄Group 欄位名稱
       var itemGroup = [];    //紀錄Group 欄位名稱
       

       for(var j = 0; j < num_tabs; j++)
       {
         
           //獲得Toolbar的資料
           var tools = $("#jqxInventoryToolBar" + ( j + 1 )).jqxToolBar("getTools");
            
           var dataXaxis = tools[1].tool[0].textContent;        
           var dataYaxis = tools[3].tool[0].lastChild.value;
           var columnName = tools[5].tool[0].lastChild.value;
           var item = tools[6].tool[0].value;

           dataXaxisGroup.push(dataXaxis);
           dataYaxisGroup.push(dataYaxis);
           columnNameGroup.push(columnName);
           itemGroup.push(item);

       }
       
        // //檢查選擇Control Chart時，Group 不能大於1組以上，UCL 或LCL需同時為空或有值避免Center Line計算錯誤
        // //檢查選擇Scatter Chart時，Group 不能有值沒有選擇，避免無法產生圖表
        // var _checkChartWithGroup = checkChartWithGroup(chartTypeGroup, UCLGroup, LCLGroup); 
        // if (_checkChartWithGroup !==''){alert(_checkChartWithGroup); return;}

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
               url: "/InventoryInstock/export" ,//路徑
               type: "POST",           
               data:{
                    "postData": postData,
                    "table":table,
                    "caption": caption,
                    "UserFilter":sessionStorage.getItem("Se_RawMaterial"),
               },
               success: function (DownLoadValue){
                   var dataLo = DownLoadValue.success;
                 //產生要寫入excel的data
                   //參數格式: original data -> toolbar data -> toolbar control data 
                   DrowBarChart( 'Container Balance', dataLo, 
                            dataXaxisGroup, dataYaxisGroup, 
                           columnNameGroup, itemGroup 
                       );
                   }                                  
               });    
             
   })
</script>
{{-- Chart.js End --}}

{{-- MyFavorite Start--}}
<script type="text/javascript">
/*產生圖表*/
$("#MyFavorite").click( function(){
    var table = "viewLog";
    var pcontent = '<span style="font-weight:bold; color:#2e6e9e;">《 資料處理紀錄 Data Log 》</span><br /><br />' + '<table id= '+ table + '></table><div id="viewLogPager"></div>';
    
    //建立動態表格
    $("#confirmDialog").html(pcontent);
    
    var colNames = [];
    var colModel = [];
    colNames = ['ID','庫存','包含'];
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
            
})

</script>
{{-- MyFavorite End --}}

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
                url: "ContainerBalance/GetDataFromID/"+table ,//路徑
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
function viewChartData(){
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
            url: "ContainerBalance/GetDataFromID/"+table ,//路徑
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

    {{-- Add to Confirm Start--}}
<script type="">
    ///跳脫字元的用法，可以用來傳遞Onclick參數
    function addToConfirm()
    {
        var _getRawMaterial = sessionStorage.getItem('Se_RawMaterial');
        
        var item = $('#jqxcbx_RawMaterial').jqxComboBox('getItem',  args.selectedIndex);
        if(item == undefined){
            item = $('#jqxcbx_RawMaterial').jqxComboBox('getItem',  args.index)
        }
        sessionStorage.setItem('Se_RawMaterial', _getRawMaterial + item.label + ',');
        var original = document.getElementById('confirmDialog').innerHTML;
        var pcontent = original + '<table><td>'+ item.label + '</td><td>'+ '<input type="BUTTON" onclick= \'deleteFromConfirm("'+item.label+'")\' value="刪除" /></td></table>';
        $("#confirmDialog").html(pcontent);

        //重新呼叫ToolBar
        $.ajax({
                async:false,
                url: "InventoryInstock/Get_Condition" ,//路徑
                type: "POST",           
                data:{
                    "table":"RawMaterial",
                },
                success: function (DownLoadValue)
                    {
                   
                        var sourceRawMaterial = DownLoadValue.success;
                        var _data = [];
                        for (var key in sourceRawMaterial)
                        {
                            _data.push(sourceRawMaterial[key]["Material_Description"]);
                        }

                        $("#jqxcbx_RawMaterial").jqxComboBox({ source:  _data , selectedIndex: -1, width: '200px', height: '25' });
                        
                    }                               
                });      
    }

    function deleteFromConfirm(label)
    {
        //清除Session裡的label
        var _getRawMaterial = sessionStorage.getItem('Se_RawMaterial');
        _getRawMaterial = _getRawMaterial.replace( label + ',', '');
        sessionStorage.setItem('Se_RawMaterial', _getRawMaterial);
        reCreateConfirm(); 
    }

    function reCreateConfirm()
    {
        var original = '<span style="font-weight:bold; color:#2e6e9e;">《 篩選條件 》</span><br /><br />'
        + '<p>RawMaterial: <table><td><div id="jqxcbx_RawMaterial"></div></td><td><input type="BUTTON"  onclick="addToConfirm()" id="QueryContainer" value="確定" /></td></table></p>'
        + '</br>';
        var _tmp = sessionStorage.getItem('Se_RawMaterial').split(',');
      
        for(var key in _tmp)
        {        
            if (_tmp[key]!='')
            {
                original = original + '<table><td>'+ _tmp[key]+ '</td><td>'+ '<input type="BUTTON" onclick= \'deleteFromConfirm("'+_tmp[key]+'")\' value="刪除" /></td></table>';
            }
        }

        $("#confirmDialog").html(original);
          //重新呼叫ToolBar
        $.ajax({
                async:false,
                url: "InventoryInstock/Get_Condition" ,//路徑
                type: "POST",           
                data:{
                    "table":"RawMaterial",
                },
                success: function (DownLoadValue)
                    {
                   
                        var sourceRawMaterial = DownLoadValue.success;
                        var _data = [];
                        for (var key in sourceRawMaterial)
                        {
                            _data.push(sourceRawMaterial[key]["Material_Description"]);
                        }

                        $("#jqxcbx_RawMaterial").jqxComboBox({ source:  _data , selectedIndex: -1, width: '200px', height: '25' });
                        
                    }                               
                });   
    }
</script>
    {{-- Add to Confirm End --}}

@endsection
