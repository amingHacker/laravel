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
<script type="text/javascript" src="{{asset('js/chart/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/chart/Chart.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/chart/utils.js')}}"></script>
{{-- 圖表生成 Chart.js End --}}

{{-- RightClick Action Start--}}
<script type="text/javascript" src="{{asset('js/RightClick/RightClick.js')}}"></script>
{{-- RightClick Action End--}}

{{-- CSS設定 Start--}}
<style type="text/css">
    .ui-jqgrid-hdiv { overflow-y: hidden; }
    .ui-tabs
    {
        width:72%;
    }
    .text-break {
        white-space: normal !important;
        height:auto;
        vertical-align:text-top;
        padding-top:2px;
    }
</style>

{{-- CSS設定 End --}}

{{-- Data資料呈現 Start --}}
<script type="text/javascript">
    
    var todosampling_records_abnormalevent = @json($sampling_records_abnormalevent);
    var combobox_items = [];
   
    var _todoList = {
            sampling_records_abnormalevent: todosampling_records_abnormalevent
        };
    $(document).ready(function () {      
        var i = 0;
        for(var _todoP in _todoList ){       
            ShowTable(_todoP, i);
            i++;
        }
        setTimeout(Showtab,1000);
        getAuthority();
        //獲得combobox的內容
        combobox_items = getComboboxItem();         
    });
    
    /*****修改GridView欄位字體顏色*****/
    function addCellAttrUrgent(rowId, val, rawObject, cm, rdata) {
        
        if ( rdata["Status"] == "待解決")
        {
            var sty = "style='font-size:14px; background-color:#FF7777'"
            return sty;
        }
        else if ( rdata["Status"] == "已解決")
        {
            var sty = "style='font-size:14px; background-color:#77FF77'"
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
        $( "#tabs" ).tabs();
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
                else if (colName === 'Status')
                {
                    colModel.push(
                        {
                            name:colName, index:colName, width:100, align:"center",sortable:true, editable:true, cellattr: addCellAttrUrgent,
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
                
                else if (colName === 'Happened_time')
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
                else if (colName === 'QC_USER'|| colName === 'PD_USER') 
                {
                    colModel.push(
                        {
                            name:colName, index:colName, width:100, align:"center",sortable:true, editable:true, cellattr: addCellAttr,
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
                else if (colName === 'SamplingRecords_ID')
                {
                    colModel.push({name:colName, index:colName, align:"center", width:128, editable:true, cellattr: addCellAttr});
                }
                else if (colName === 'QC_Comment' || colName === 'PD_Comment')
                {
                    colModel.push({name:colName, index:colName, align:"left", width:400, editable:true, cellattr: addCellAttr});
                }
                else
                {
                    colModel.push({name:colName, index:colName, align:"left", width:200, editable:true, cellattr: addCellAttr});
                }
            }
            var table = "dg" + _todoP ;
            var jqgridWidth = parseInt($(window).width()) * 0.7;
            // 準備資料           
            $("#" + table).jqGrid({
                url:"AbnormalEvent/show/"+_todoP,
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
                caption: _todoP,
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
                onRightClickRow:function(rowid, irow, icol, e){
                    var item_data = [];
                    item_data.push(rowid);
                    $.ajax({
                                async:false,
                                url: "AbnormalEvent/GetDataFromID",//路徑
                                type: "Post",
                                data:
                                    {
                                        "postData": item_data,
                                    },
                            }).done(function(data){
                                var abnormalEvent = data.success[0];
                               
                                showRightClick(abnormalEvent["SamplingRecords_ID"], e);
                            
                            });
                    
                    
                },
                onSelectRow:function(rowid,status,e){
                    handleClickMouseDown(e);
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
                if (Authority["Add"] == 1)
                {     
                    document.getElementById("New").style.display="";
                    document.getElementById("Save").style.display="";
                    document.getElementById("Cancel").style.display="";        
                    document.getElementById("Edit").style.display=""; 
                    document.getElementById("Import").style.display="";
                    document.getElementById("ExportExcel").style.display="";
                }
                if (Authority["ProductSPEC"] == 1)
                {     
                    document.getElementById("New").style.display="";
                    document.getElementById("Save").style.display="";
                    document.getElementById("Cancel").style.display="";        
                    document.getElementById("Edit").style.display="";
                    document.getElementById("Delete").style.display=""; 
                    document.getElementById("Import").style.display="";
                    document.getElementById("ExportExcel").style.display="";
                }            
            }
        });
    }

    /*獲得item內容包含的方法*/
    var selectItemJson; //用來存放item包含的值
    function getComboboxItem(){     
        $.ajax({
            async:false,
            url: "AbnormalEvent/GetComboboxItem",//路徑
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

        if (width < 0 ){width = 90;}

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


    /*初始化選單*/
    $(function() 
    {
        $( "#RightClickmenu" ).menu();
    });
</script>

{{-- Data資料呈現 End --}}
 
<meta name="csrf-token" content="{{ csrf_token() }}"> 
    <h1 class="my-2"></h1>
    <div style = "margin:0px auto;"  >
        <img class=" img-responsive" src="img/Logo_AbnormalEvent.png" >   
    </div>  

    <div align="center">
        <div id="tabs"  >
            <ul class = "row justify-content-center">
              <li><a href="#tabs-1">sampling_records_abnormalevent</a></li>      
            </ul>
            <div id = "tabs-1" >
                <div class = "row justify-content-center">
                <table id="dgsampling_records_abnormalevent" ></table> 
                <div id="dgsampling_records_abnormaleventpager"></div>
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
</div>

{{-- RightClick選單 Start --}}
<ul id="RightClickmenu" style="display:none;" >
    <li><a href="#" onclick="viewChartData();return false;"><span class="ui-icon ui-icon-document"></span>View Records</a></li>
</ul>
{{-- RightClick選單 End --}}

<h1 class="my-4"></h1>

{{-- 表單送出方法 inline Start --}}
<script type="text/javascript">
    var target_id = 'none'; //紀錄目前要修改的列id
    var selectRowData = []; //紀錄選擇的目前的rowdata
    
    $("#New").click( function(){
        //var selected = $('#tabs').tabs('option', 'selected'); // selected tab index integer
        var table = "dg" + $("#tabs .ui-tabs-active").text(); //呈現此table的title
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
        var table = "dg" + $("#tabs .ui-tabs-active").text(); //呈現此table的title
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
        var table = "dg" + $("#tabs .ui-tabs-active").text(); //呈現此table的title
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
                        "url" : 'AbnormalEvent/AddandUpdate/'+0,
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
                                "url" : 'AbnormalEvent/AddandUpdate/'+ret.id,
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
        var table = "dg" + $("#tabs .ui-tabs-active").text(); //呈現此table的title
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
        var table = "dg" + $("#tabs .ui-tabs-active").text(); //呈現此table的title 
        var caption = $('#' + table ).jqGrid("getGridParam", "caption");
         var s = $("#" + table ).jqGrid('getGridParam','selrow');      
         if (s)	{
             var ret = $("#" + table ).jqGrid('getRowData',s);
             console.log(ret);           
             var answer = window.confirm("確認刪除此筆資料?");
             if (answer)
             {
                $.ajax({
                    url: "AbnormalEvent/delete/" + ret.id ,//路徑
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
    
        var table = "dg" + $("#tabs .ui-tabs-active").text(); //呈現此table的title
        
        var o = $("#" + table);
        
        var columnNames = o.jqGrid('getGridParam', 'colNames');//從grid獲得colnames

        var rowNumber = o.jqGrid('getGridParam', 'records');//獲得搜尋後的紀錄筆數
        
        var postData = o.jqGrid('getGridParam', 'postData');//獲得搜尋條件

        var getData = o.jqGrid('getGridParam', 'data');//獲得所有jqgrid的資料
        
        //var lastSearchData = o.jqGrid('getGridParam', 'lastSelected'); //獲得最後一次搜尋的資料
        
        //o.jqGrid('setGridParam', { rowNum: rowNumber }).trigger('reloadGrid', [{current:true}]);//此方式可能會lag                  
        
        var rowData = o.jqGrid('getRowData');//獲得目前顯示在表格上的資料

        var caption = o.jqGrid("getGridParam", "caption");

        $.ajax({
                async:false,
                url: "AbnormalEvent/export" ,//路徑
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
                    var filename = myDate + '-' + $("#tabs .ui-tabs-active").text()+ '-'+ 'AbnormalEventSPEC.xlsx';

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
                            var table = "dg" + $("#tabs .ui-tabs-active").text(); //呈現此table的title

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
                                            url: 'AbnormalEvent/FileUpload/' + data[i].id,
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
                                                    $('#dg').trigger( 'reloadGrid' );
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

{{-- 得到Sampling Record的資料 Start --}}
<script type="text/javascript">
/*得到Chart上的data*/
/*輸入Database ColumnName 輸出中文 ColumnName*/
function getColumnNameFromDatabaseToChinese(ColumnName)
    {
        var Result = '';
         //舊key到新key的映射，colName的轉換
        var oldkey = {
            id: "編號",
            urgent: "急件",  
            sampling_date: "取樣日期",
            product_name: "品名",
            level: "等級",
            bottle_number: "瓶號",
            batch_number: "批號",
            Assay: "Assay (Purity)",
            sampler: "取樣者",
            sample_source: "樣品來源",
            analytical_item: "分析項目",
            analyst: "分析者",
            completion_date: "完成日",
            determination: "判定",
            remarks: "備註",
            Parameter_A: "Parameter A",
            Impurity_A: "Impurity A",
            Impurity_B: "Impurity B",
            Impurity_C: "Impurity C",
            Impurity_D: "Impurity D",
            Impurity_E: "Impurity E",
            Impurity_F: "Impurity F",
            "1H_NMR": "1H NMR",
            Other_Metals: "Other Metals",
            Parameter_B: "Parameter B",
            Parameter_C: "Parameter C",
            Parameter_D: "Parameter D",
            Organic_impurity: "Organic impurity",
            "0_0ppm":"[δ0.0ppm]",
            "2_2ppm":"[δ2.2ppm]",
            "3_8ppm":"[δ3.8ppm]",
            "4_0ppm":"[δ4.0ppm]",
            Sum223840:"Sum[2.2+3.8+4.0]",
            IR_A:"IR A",
            "equipment_name":"設備名稱",
            "standard_solution":"標準液批號", 
            "sampling_kind": "取樣類別",
            "Quattro_id" : "Quattro編號",
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


function viewChartData(){
    var $menu = $('#RightClickmenu');
    $menu.hide();
    var outlier = sessionStorage.getItem('RightClickID');;
    var outlier_data = [];
    outlier_data.push(outlier);
  
    $.ajax({
            async:false,
            url: "SamplingRecord/GetDataFromID" ,//路徑
            type: "POST",           
            data:{
                "postData": outlier_data,
            },
            success: function (DownLoadValue){
                var data = DownLoadValue.success;
                //產生要寫入excel的data
                var table = "import_preview";
                var pcontent = '<span style="font-weight:bold; color:#2e6e9e;">《  Sampling Records 資料  》</span><br /><br />' + '<table id= '+ table + '></table><div id="import_previewPager"></div>';
                
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
                    caption: "Sampling Records 資料", 
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
{{-- 得到Sampling Record的資料 End --}}
@endsection
