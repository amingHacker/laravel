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
    /* 預設已是overflow:auto，寫在網頁裡再次確保會出現scroller
     .ui-jqgrid .ui-jqgrid-bdiv {
       overflow:auto; 
     } */

    /* .container{
        width:1200px;
        margin:0 auto;
        padding:10px;
    } */
</style>

{{-- CSS設定 End --}}

{{-- Data資料呈現 Start --}}
<script type="text/javascript">
    
    var TMAL = @json($todosTMAL);
    var MO = @json($todosMO);
    var PDMAT = @json($todosPDMAT);
    var CCTBA = @json($todosCCTBA);
    var ALEXA = @json($todosALEXA);
    var _todoList = {
            TMAL: TMAL,
            MO: MO, 
            PDMAT: PDMAT, 
            CCTBA: CCTBA, 
            ALEXA: ALEXA
        };
    $(document).ready(function () {      
        var i = 0;
        for(var _todoP in _todoList ){       
            ShowTable(_todoP, i);
            i++;
        }
        setTimeout(Showtab,1000);
        getAuthority();       
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
            else if (colName === 'ELEMENT')
            {
                colModel.push({name:colName, index:colName, width:120, align:"center", editable:true, cellattr: addCellAttr, frozen: true});
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
        var table = "dg" + _todoP ;
        // 準備資料           
        $("#" + table).jqGrid({
            //url:"ProductSPEC/show/"+_todoP,
            url:"ProductSPEC/show/"+_todoP,
            datatype: "json",        
            altrows:false,
            width: 1200,
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
            sortorder: "asc",
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
            rowattr: function (rd){if (rd.determination === 'Fail'){ return {"class": "failRow"};}}                                                            
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
            $("#load_" + table).show();
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
</script>
{{-- Data資料呈現 End --}}
 
<meta name="csrf-token" content="{{ csrf_token() }}"> 
    <h1 class="my-2"></h1>
    <div style = "margin:0px auto;"  >
        <img class=" img-responsive" src="img/Logo_ProductSPEC.png" >   
    </div>  
<div class = "container-fluid" >
    <div class = "row justify-content-center">
        <div id="tabs"  >
            <ul class = "row justify-content-center">
              <li><a href="#tabs-1">TMAL</a></li>
              <li><a href="#tabs-2">MO</a></li>
              <li><a href="#tabs-3">PDMAT</a></li>
              <li><a href="#tabs-4">CCTBA</a></li>
              <li><a href="#tabs-5">ALEXA</a></li>
            </ul>
            <div id = "tabs-1" >
                <div class = "row justify-content-center">    
                <table id="dgTMAL" ></table> 
                <div id="dgTMALpager"></div>
                </div>                             
            </div>
            <div id = "tabs-2" >
                <div class = "row justify-content-center">     
                <table id="dgMO" ></table> 
                <div id="dgMOpager"></div>
                </div>                             
            </div>
            <div id="tabs-3">
                <div class = "row justify-content-center">     
                <table id="dgPDMAT" ></table> 
                <div id="dgPDMATpager"></div>
                </div>        
            </div>
            <div id="tabs-4">
                <div class = "row justify-content-center">  
                <table id="dgCCTBA" ></table> 
                <div id="dgCCTBApager"></div>
                </div>     
            </div>
            <div id="tabs-5" >
                <div class = "row justify-content-center">
                <table id="dgALEXA" ></table> 
                <div id="dgALEXApager"></div>
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
</div> 
    
<div class = "row justify-content-center">
      <input type="BUTTON" class="btn btn-outline-info btn-space" id="New" style="display: none" value="新增" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="Edit" style="display: none" value="編輯" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="Save" style="display: none" disabled="true" value="儲存" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="Cancel" style="display: none" disabled="true" value="取消" />       
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="Delete" style="display: none" value="刪除" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="ExportExcel" style="display: none" value="下載" />   
        <div>
            <input id="file" type="file" onchange="Import(this)" style="display: none" />
            <input type="button" onclick="file.click()" class="btn btn-outline-info btn-space" id="Import" style="display: none" value="上傳" />
        </div>    
</div>
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
                        "url" : 'ProductSPEC/AddandUpdate/'+0,
                        "extraparam" : {
                            "oper": oper,
                            "table": table,
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
                                "url" : 'ProductSPEC/AddandUpdate/'+ret.id,
                                "extraparam" : {                                   
                                    "id" : ret.id,
                                    "oper" : oper,
                                    "table": table,                                 
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
         var s = $("#" + table ).jqGrid('getGridParam','selrow');      
         if (s)	{
             var ret = $("#" + table ).jqGrid('getRowData',s);
             console.log(ret);           
             var answer = window.confirm("確認刪除此筆資料?");
             if (answer)
             {
                $.ajax({
                    url: "ProductSPEC/delete/" + ret.id ,//路徑
                    type: "DELETE",           
                    data:{
                        "id": ret.id,
                        "table": table,
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

        $.ajax({
                async:false,
                url: "ProductSPEC/export" ,//路徑
                type: "POST",           
                data:{
                    "postData": postData,
                    "table":table,
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
                    var filename = myDate + '-' + $("#tabs .ui-tabs-active").text()+ '-'+ 'ProductSPEC.xlsx';

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
            $("#confirmDialog").html('<span style="font-weight:bold; color:#2e6e9e;">《 檔案資料預覽 File data preview 》</span><br /><br /><table id="import_preview"></table>');
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
                sortname: '編號',
                sortorder: "asc",
                hidegrid: false,
                cmTemplate: { title: false },   // Hide Tooltip
                gridview: true,
                shrinkToFit: false,
    
                loadComplete: function (){ fixPositionsOfFrozenDivs.call(this); }, // Fix column's height are different after enable frozen column feature 
            });
            
            $("#import_preview").jqGrid('setFrozenColumns');


            $("#confirmDialog").dialog({
                width:'900', height:'auto', autoResize:true, modal:true, closeText:"關閉", 
                resizable:true, closeOnEscape:true, dialogClass:'top-dialog',position:['center',168],
                show:{effect: "fade", duration: 140},
                hide:{effect: "clip", duration: 140},
                focus: function() { $(".ui-dialog").focus(); }, // Unfocus the default focus elem
                buttons : {
                    "確認" : function() {
                        //$(this).dialog("close");
                        var table = "dg" + $("#tabs .ui-tabs-active").text(); //呈現此table的title
                        $("#confirmDialog").html('<span style="font-weight:bold; color:#2e6e9e;">《 上傳進度 》</span><br /><br /><div id="progressbar"></div>');                                                                                                        
                        
                        for (var i = 0; i < data.length; i++) 
                        {                              
                            setTimeout((function (i) {                      
                                return function () {                                                                       

                                    $.ajax({
                                        url: 'ProductSPEC/FileUpload/' + data[i].id,
                                        method: 'post',
                                        async: false,//同步請求資料
                                        //datatype:"json",
                                        data: {
                                            UploadData:_upLoadData[i],
                                            table:table                               
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
                                                window.location.reload()
                                            }
                                        },
                                        failure: function (response) {                              
                                        }
                                    });
                                }
                            })(i), 10);
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
@endsection
