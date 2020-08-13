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
{{-- Include combobox, DatePicker End --}}

{{-- ajax同步 This is for es5 (ie11)--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.4/bluebird.min.js"></script>


{{-- 圖表生成 Chart.js Start--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
<script src="https://www.chartjs.org/dist/2.9.3/Chart.min.js"></script>
<script src="https://www.chartjs.org/samples/latest/utils.js"></script>
{{-- 圖表生成 Chart.js End --}}

{{-- CSS設定 Start--}}
<style type="text/css">
    /*預設已是overflow:auto，寫在網頁裡再次確保會出現scroller*/
     .ui-jqgrid .ui-jqgrid-bdiv {
       overflow:auto; 
     }
</style>
{{-- <style type="text/css">
    img { 
            max-width: 100%; 
            height: auto; 
            margin:auto; 
            display: block; 
    }  
    body,button, input, select, textarea,h1 ,h2, h3, h4, h5, h6 
        { font-family:  微軟正黑體, Tahoma, Helvetica, Arial, "\5b8b\4f53", sans-serif;}
    .ui-jqgrid {
            font-size: 2em;
    }
    /* 修改grid標題字體大小 */
    .ui-jqgrid .ui-jqgrid-title{
            font-size:1em;
            text-align: "center";
            font-family:  微軟正黑體;
            height:auto;
    }  
    
    .ui-jqgrid .ui-jqgrid-htable th {
            height:2em;
            font-family:  微軟正黑體;
            font-size: 1em;
    }
    .ui-jqgrid tr.jqgrow td{
            height: 1em !important;
            /* font-family:"Times New Roman", 微軟正黑體; */
            font-size: 1em;
    }
</style> --}}

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
                        {name:colName, index:colName, width:80, align:"center",sortable:true, frozen: true, sorttype:"int", editable:false, cellattr: addCellAttrID}
                    );
            }
            else if (colName === 'Filling_Date')
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
            else if (colName === 'Op' || colName === 'glove_box' || colName === 'Oven' || colName === 'Material')
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
            else
            {
                colModel.push({name:colName, index:colName, align:"center", width:120, editable:true, cellattr: addCellAttr});
            }
        }

        //舊key到新key的映射，colName的轉換
        var oldkey = {
                id: "編號",
                Filling_Date: "Filling Date",
                sap_batch: "sap batch",
                sap_batch_actual_assay: "sap batch actual assay",
                sap_batch_actual_meo: "sap batch actual meo",
                Op: "Op.",
                serial_number: "serial number",
                Main_bubbler_tank: "Main bubbler tank",
                "1st_bulk_batch": "1st bulk batch",
                "1st_bulk_wt": "1st bulk wt.",
                "1st_tank_batch": "1st tank batch",
                "2nd_bulk_batch": "2nd bulk batch",
                "2nd_bulk_wt": "2nd bulk wt.",
                "2nd_tank_batch": "2nd tank batch",
                "3rd_bulk_batch": "3rd bulk batch",
                "3rd_bulk_wt": "3rd bulk wt.",
                "3rd_tank_batch": "3rd tank batch",
                "1st_bulk_assay": "1st bulk assay",
                "1st_bulk_meo": "1st bulk meo",
                "2nd_bulk_assay": "2nd bulk assay",
                "2nd_bulk_meo": "2nd bulk meo",
                "3rd_bulk_assay": "3rd bulk assay",
                "3rd_bulk_meo": "3rd bulk meo",
                expect_assay: "expect assay",
                expect_meo:"expect meo",
                PDMAT_g:"PDMAT (g)",
                s_75um:"<75um (%)",
                grinding_time_h:"grinding time (h)",
                glove_box:"glove box",
                input_system_oxygen:"input system oxygen",
                output_system_oxygen:"output_system_oxygen",
                input_system_moisture:"input system moisture",
                output_system_moisture:"output system moisture",
                Q_Time:"Q Time", 
                Oven:"Oven",
                anneal_seat:"anneal seat",
                "0_0_ppm": "0.0 ppm",
                Remark:"Remark",
                Material:"Material",
                pressure_Drop_Via_bypass: "pressure Drop Via bypass",
                pressure_Drop_Via_body: "pressure Drop Via body",
                created_at: "建立時間",
                updated_at: "更新時間",
            };

        for(var index in colNames)
        {
            for(var key in oldkey)
            {        
                if (colNames[index] == key)
                {
                    colNames[index] = oldkey[key];
                }
            }
        }
        var jqgridWidth = parseInt($(window).width()) * 0.7;

        // 準備資料           
        $("#dg").jqGrid({
            url:'GrindingOven/show',
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
            caption:"Grinding & Oven",
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
                this.p.lastSelected = lastSelected; 
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
        
        //獲得最後一次搜尋的資料
        var oldFrom = $.jgrid.from,
            lastSelected;

        $.jgrid.from = function (source, initalQuery) {
            var result = oldFrom.call(this, source, initalQuery),
                old_select = result.select;
                result.select = function (f) {
                    lastSelected = old_select.call(this, f);
                    return lastSelected;
                };
            return result;
        };
    });
    

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
            url: "GrindingOven/GetComboboxItem",//路徑
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
</script>
{{-- Data資料呈現 End --}}
 
<meta name="csrf-token" content="{{ csrf_token() }}"> 
{{-- <div class = "container"> --}}
    <h1 class="my-2"></h1>
    <div style = "margin:0px auto;" >
        <img class=" img-responsive" src="img/Logo_Grinding.png" >   
    </div>

    <div class = "row justify-content-center" >
        <table id="dg" ></table> 
        <div id="dgPager"></div>                         
    </div>
<div class = "container">
    <div class = "row justify-content-center">
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="New"  value="新增" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="Edit"  value="編輯" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="Save"  disabled="true" value="儲存" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="Cancel"  disabled="true" value="取消" />       
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="Delete" value="刪除" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="ExportExcel" value="下載" />
        
        <div>
            <input id="file" type="file" onchange="Import(this)" style="display: none" />
            <input type="button" onclick="file.click()" class="btn btn-outline-info btn-space" id="Import" value="上傳" />
        </div>

        <div id="confirmDialog" title="Comfirm Information">
            <p></p>
        </div>
        <div id="warningDialog" title="Warning Information">
            <p></p>
        </div>
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="BackFill" value="回填" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="ExportChart" value="圖表" />
    </div>
</div>
    <h1 class="my-4"></h1>
    {{-- Chart Start --}}
    <div id = canvas_div style="width:70%; margin:0px auto; display: none;" >
        <canvas id="canvas" ></canvas>
    </div>
    {{-- Chart End --}}           


{{-- 表單送出方法 inline Start --}}
<script type="text/javascript">

    var target_id = 'none'; //紀錄目前要修改的列id
    var selectRowData = []; //紀錄選擇的目前的rowdata

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
                        "url":'GrindingOven/AddandUpdate/'+0,
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
                    cellvalue = elem.is(':checked') ? 'True' : 'False';
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
                                "url" : 'GrindingOven/AddandUpdate/'+ret.id,
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
                    url: "GrindingOven/delete/" + ret.id ,//路徑
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
                    url: "GrindingOven/BackFill/" + ret.id ,//路徑
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
        
        var lastSearchData = o.jqGrid('getGridParam', 'lastSelected'); //獲得最後一次搜尋的資料
        
        //o.jqGrid('setGridParam', { rowNum: rowNumber }).trigger('reloadGrid', [{current:true}]);//此方式可能會lag                  
        
        var rowData = o.jqGrid('getRowData');//獲得目前顯示在表格上的資料

        $.ajax({
                async:false,
                url: "GrindingOven/export" ,//路徑
                type: "POST",           
                data:{
                    "postData": postData,
                },
                success: function (DownLoadValue){
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
                    var filename = myDate + '-' + 'GrindingOven.xlsx';

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
     
            //舊key到新key的映射   //同樣字符不須寫兩次，會被刪除
            var oldkey = {
                編號: "id",      
                "Filling Date": "Filling_Date",                
                "sap batch": "sap_batch", 
                "sap batch actual assay": "sap_batch_actual_assay",
                "sap batch actual meo": "sap_batch_actual_meo",
                "Op.": "Op",
                "serial number": "serial_number",
                "Main bubbler tank": "Main_bubbler_tank",
                "1st bulk batch": "1st_bulk_batch",
                "1st bulk wt.": "1st_bulk_wt",
                "1st tank batch": "1st_tank_batch",
                "2nd bulk batch": "2nd_bulk_batch",
                "2nd bulk wt.": "2nd_bulk_wt",
                "2nd tank batch": "2nd_tank_batch",
                "3rd bulk batch": "3rd_bulk_batch",
                "3rd bulk wt.": "3rd_bulk_wt",
                "3rd tank batch": "3rd_tank_batch",
                "1st bulk assay": "1st_bulk_assay",              
                "1st bulk meo": "1st_bulk_meo",
                "2nd bulk assay": "2nd_bulk_assay",              
                "2nd bulk meo": "2nd_bulk_meo",
                "3rd bulk assay": "3rd_bulk_assay",              
                "3rd bulk meo": "3rd_bulk_meo",                
                "expect assay": "expect_assay",
                "expect meo": "expect_meo",             
                "PDMAT (g)": "PDMAT_g",
                "<75um (%)": "s_75um",
                "grinding time (h)": "grinding_time_h",
                "glove box": "glove_box",
                "input system oxygen": "input_system_oxygen",
                "output system oxygen": "output_system_oxygen",
                "input system moisture": "input_system_moisture",
                "output system moisture": "output_system_moisture",               
                "Q Time": "Q_Time",
                //"Oven": "Oven",
                "anneal seat": "anneal_seat",
                "0.0 ppm": "0_0_ppm",
                //"Remark": "Remark",
                //"Material": "Material",
                "pressure Drop Via bypass": "pressure_Drop_Via_bypass",
                "pressure Drop Via body": "pressure_Drop_Via_body",
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

            // for(var i=0; i < data.length; i++)
            // {
            //     $("#import_preview").jqGrid('addRowData', i+1, data[i]);
            // }    

            $("#confirmDialog").dialog({
                width:'auto', height:'auto', autoResize:true, modal:true, closeText:"關閉", 
                resizable:true, closeOnEscape:true, dialogClass:'top-dialog',
                //width:'auto', height:'auto', autoResize:true, modal:true, closeText:"關閉", resizable:true,
                show:{effect: "fade", duration: 140},
                hide:{effect: "clip", duration: 140},
                focus: function() { $(".ui-dialog").focus(); }, // Unfocus the default focus elem
                buttons : {
                    "確認" : function() {
                        //$(this).dialog("close");
                        $("#confirmDialog").html('<span style="font-weight:bold; color:#2e6e9e;">《 上傳進度 》</span><br /><br /><div id="progressbar"></div>');                                                                                                        
                        
                        for (var i = 0; i < data.length; i++) {                              
                                setTimeout((function (i) {                      
                                    return function () {                                                                       

                                        $.ajax({
                                            url: 'GrindingOven/FileUpload/' + data[i].編號,
                                            method: 'post',
                                            async: false,//同步請求資料
                                            //datatype:"json",
                                            data: {
                                                UploadData:_upLoadData[i]                              
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
                                                        if (response.success == data[data.length-1].編號)
                                                        {                                                    
                                                            window.location.reload();
                                                        }
                                                    }
                                                }                                    
                                            },
                                        });
                                    }
                                })(i), 2);
                            }                                                        
                    },
                    "取消" : function() {
                        $(this).dialog("close");                     
                    }
                }
            });                                       
        })
    }
</script>
{{-- 表單輸出、輸入功能 End--}}

{{-- Chart.js Start --}}
<script>
    $("#ExportChart").click( function(){
        
        document.getElementById("canvas_div").style.display="";//顯示
        //獲得資料
        var o = $("#dg");
        var rowNumber = o.jqGrid('getGridParam', 'records');
         //console.log(rowNumber);
        o.jqGrid('setGridParam', { rowNum: rowNumber }).trigger('reloadGrid');     
        var columnNames = o.jqGrid('getGridParam', 'colNames');
        //console.log(columnNames);      
        //console.log(columnNames.length);

        var ccc = o.jqGrid('getGridParam', 'data');

        var dataLo = o.jqGrid('getRowData');

        var dataToChartX = [], dataToChartY = [];

        for (var key in dataLo)
        {
            for (var p in dataLo[key])
            {
                if (p == 'solid_Started')
                {
                    dataToChartX.push(dataLo[key][p]); 
                }
                if( p == 'solid_output')
                {
                    dataToChartY.push( parseInt(dataLo[key][p])); 
                }        
            }     
        }

        var test1 = [];
        for (var i in dataToChartX)
        {
            var dataxy = { 
                x: dataToChartX[i],
                y: dataToChartY[i]
            }
            test1.push(dataxy);
        }

        var test2 = [];
        for (var i in dataToChartX)
        {
            var dataxy = { 
                x: dataToChartX[i],
                y: dataToChartY[i] -100
            }
            test2.push(dataxy);
        }
         
        var color = Chart.helpers.color;
        var config = {
            type: 'line',
            data: {
                datasets: [
                {
                    label: 'solid_output',
                    backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
                    borderColor: window.chartColors.red,
                    fill: false,
                    data: test1
                }, 
                {
                    label: 'solid_output -100',
                    backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
                    borderColor: window.chartColors.blue,
                    fill: false,
                    data: test2
                }
                ]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: 'Solvent Removal'
                },
                scales: {
                    xAxes: [{
                        type: 'time',
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Date'
                        },
                        ticks: {
                            major: {
                                fontStyle: 'bold',
                                fontColor: '#FF0000'
                            }
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'value'
                        }
                    }]
                }
            }
        };

        if (window.myLine !== undefined && window.myLine !== null) 
        {
            window.myLine.destroy();
        }

        var ctx = document.getElementById('canvas').getContext('2d');

        window.myLine = new Chart(ctx, config);

        o.jqGrid('setGridParam', { rowNum: 10 }).trigger('reloadGrid');             
    })

    function newDate(days) {
        return moment().add(days, 'd').toDate();
    }

    function newDateString(days) {
        return moment().add(days, 'd').format();
    }

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

{{-- Chart.js End --}}

@endsection
