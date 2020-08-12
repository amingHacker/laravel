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
<style type="text/css">
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
        
        for ( var colName in _todos[0])
        {
            colNames.push(colName);
        }
        
        for ( var colName in _todos[0])
        {           
            if (colName === 'id')
            {           
                colModel.push(
                        {name:colName, index:colName, width:80, align:"center",sortable:true, sorttype:"int", frozen: true, editable:false, cellattr: addCellAttrT}
                    );
            }

            else if (colName === 'sampling_date' || colName === 'completion_date')
            {
                colModel.push(
                    {
                        name:colName, index:colName, width:200, align:"center",sortable:true, editable:true, cellattr: addCellAttr,
                        sorttype: "date", edittype:'text', 
                        // editoptions: 
                        // {                       
                        //     dataInit: function (elem) 
                        //     {                                                                 
                        //         $(elem).datetimepicker(
                        //             {
                        //                 autoclose:true,
                        //                 dateFormat: 'yy-mm-dd', 
                        //                 timeFormat: 'HH:mm:ss',                         
                        //             }                             
                        //         );
                        //     },      
                        // },
                        //editrules:{date:true, required:false}, //formateter:fixDate, 
                        //formatter: "date",
                        //formatoption:{srcformat:'Y-m-d', newformat:'Y-m-d'},
                        // search:true,
                        // searchoptions: {
                        //     sopt: ['eq','le','ge'],
                        //     dataInit : function (elem) 
                        //     {
                        //         var self = this;
                        //         $(elem).datepicker({
                        //             dateFormat: 'yy-mm-dd',                                 
                        //             changeYear: true,
                        //             changeMonth: true,
                        //             //showButtonPanel: true,
                        //             showOn: 'focus',
                        //             //format: "yyyy-mm-dd",
                        //             autoclose:1
                        //         });
                        //     }
                        // },                                   
                    }
                );
            }
            else if (colName === 'item')
            {
                colModel.push(
                    {
                        name:colName, index:colName, width:200, align:"center",sortable:true, editable:true, cellattr: addCellAttr,
                        //sorttype: "text", search:true,
                        //edittype:'select', editoptions:{value: getSelectItem()},
                        // stype:'text',
                        // edittype:'custom', editoptions:
                        // {
                        //     custom_element: combobox_elem, custom_value:combobox_value
                        // }, 
                        // //searchoptions:{value: getSelectItem('item')}, stype:'select',
                        // stype:'custom', searchoptions:
                        // {
                        //     custom_element: combobox_elem, custom_value:combobox_value                   
                        // },
                    }
                );
            }
            else if (colName === 'urgent')
            {
                colModel.push({name:colName, index:colName, width:60, align:"center", editable:true, cellattr: addCellAttr});
            }
            else if (colName === 'remarks')
            {
                colModel.push({name:colName, index:colName, width:350, align:"center", editable:true, cellattr: addCellAttr});
            }
            else
            {
                colModel.push({name:colName, index:colName, align:"center", width:120, editable:true});
            }

            //{name:'created_at',index:'created_at', width:200, align:"center",sortable:true, sorttype:"date", editable:false,cellattr: addCellAttr},
            //{name:'updated_at',index:'updated_at', width:200, align:"center",sortable:true, sorttype:"date", editable:false,cellattr: addCellAttr},
        }

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
                "2_2ppm":"[δ2.2ppm]",
                "3_8ppm":"[δ3.8ppm]",
                "4_0ppm":"[δ4.0ppm]",
                Sum223840:"Sum[2.2+3.8+4.0]",
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

        // 準備資料           
        $("#dg").jqGrid({
            
            altrows:false,
            //autowidth:true,
            width: 1200,
            datatype: "local",
            data:_todos,
            height:'100%',
            colNames:colNames,
            colModel:colModel,
            multiselect:false,
            //rowNum:10,
            rowList:[10,20,50],
            pager: '#dgPager',
            //sortname: '0',
            viewrecords: true,
            gridview: true,
            //sortorder: "desc",
            caption:"ShowAll",
            shrinkToFit :false,
            loadComplete: function (){ 
                fixPositionsOfFrozenDivs.call(this);
            }, // Fix column's height are different after enable frozen column feature                                                            
        }); 
        
        //增加Tool bar        
        //$("#dg").jqGrid('navGrid','#dgPager', { search:true, edit:false, add:false, del:false, refresh:true } );
                
        var o = $("#dg");
        var rowNumber = o.jqGrid('getGridParam', 'records');//獲得搜尋後的紀錄筆數
        // console.log(rowNumber);
        //o.jqGrid('setGridParam', { rowNum: rowNumber }).trigger('reloadGrid');//重新設定表格為搜尋後的資料                
       

        //重新Load Data
        $("#dg").jqGrid('setGridParam',
                    {
                        datatype: 'local',
                        data:_todos,
                        rowNum: rowNumber
                    }).trigger("reloadGrid", [{current:true}]);

        
        //獲得combobox的內容
        combobox_items = getComboboxItem();
    });
    

    /*****修改GridView欄位字體顏色*****/
    function addCellAttr(rowId, val, rawObject, cm, rdata) {
            if(rawObject.planId == null ){
                var sty = "style='font-size:14px'"
                return sty;
           }
    }
    function addCellAttrT(rowId, val, rawObject, cm, rdata) {
            if(rawObject.planId == null ){
                var sty = "style='font-size:14px; color:blue'"
                return sty;
           }
    }

    /*****獲得item內容包含的方法*****/
    var selectItemJson; //用來存放item包含的值
    function getComboboxItem(){     
        $.ajax({
            async:false,
            url: "SamplingRecord/GetComboboxItem",//路徑
            type: "Get",
            data:{
        
            },

        }).done(function(data){
            selectItemJson = data;
        });
        var selectItem = "";
        //console.log(selectItemJson.success);
        for (var i = 0; i < selectItemJson.success.length; i++) {
            if (i < selectItemJson.success.length - 1)
                selectItem = selectItem + selectItemJson.success[i].kind + ":" + selectItemJson.success[i].kind + ";";
            else 
                selectItem = selectItem + selectItemJson.success[i].kind + ":" + selectItemJson.success[i].kind;
        }    
        //console.log(selectItem);
        //return selectItem;
        return selectItemJson.success;
    }

    /*****設定欄位為combobox的方法*****/
    function combobox_elem(value, options)
    {   

        //getSelectItem( options.name );
        //console.log(value);//目前cell裡的值
        //console.log(selectItemJson.success); //從後台回傳colNum的預選值
        //console.log(options); //此column的資訊
        
        // Create JQWidgets combobox
        var elem = $('<div id="' + (options.id) + '"></div>');
        
        // Calculate the "rowid" string length and remove "rowid" and "_" to get name
        //var name = options.id.substr(options.id.split("_")[0].length + 1);
        
        var name = options.name; //獲得column name
        //console.log(name);

        if (name == undefined){name = options.searchColName;}
        
        // Get column width value and calculate for JQWidgets combobox
        var width = $("#dg_" + name).width() - 2;       
        //console.log(width);

        // Get column width value and calculate for JQWidgets combobox
        var height = $("#dg_" + name).height() - 2;       
        //console.log(height);

        if (width < 0 ){width = 120;}

        //name = "item";

        //Get items from combobox_items array 
        //var items = combobox_items[name];
        //獲得預選值的陣列
        var items = [];
        for (var i in combobox_items)
        {
            if (combobox_items[i].colName == name)
            {
                items.push(combobox_items[i].kind)
            }

            //items[i] = combobox_items[i][name];
        }
        //console.log(items);
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
        //elem.jqxComboBox('val', value);
        
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
    <h1 class="my-5"></h1>
    <div style = "margin:0px auto;"  >
        <img class=" img-responsive" src="img/Logo_SamplingRecords.png" >   
    </div>

    <div class = "row justify-content-center">     
        <table id="dg" ></table> 
        <div id="dgPager"></div>                             
    </div>

<div class = "container">
    <div class = "row justify-content-center">
        <input type="BUTTON" class="btn btn-outline-info" id="New"  value="新增" />
        <input type="BUTTON" class="btn btn-outline-info" id="Edit"  value="編輯" />
        <input type="BUTTON" class="btn btn-outline-info" id="Save"  disabled="true" value="儲存" />
        <input type="BUTTON" class="btn btn-outline-info" id="Cancel"  disabled="true" value="取消" />       
        <input type="BUTTON" class="btn btn-outline-info" id="Delete" value="刪除" />
        <input type="BUTTON" class="btn btn-outline-info" id="ExportExcel" value="下載" />
        
        <div>
            <input id="file" type="file" onchange="Import(this)" style="display: none" />
            <input type="button" onclick="file.click()" class="btn btn-outline-info" id="Import" value="上傳" />
        </div>

      
        <div id="warningDialog" title="Warning Information">
            <p></p>
        </div>

        <div id="confirmDialog" title="Comfirm Information">
            <p></p>
        </div>
        {{-- <input type="BUTTON" class="btn btn-outline-info" id="BackFill" value="回填" />
        <input type="BUTTON" class="btn btn-outline-info" id="ExportChart" value="圖表" /> --}}
    </div>

</div> 
    {{-- Chart Start --}}
    <div id = canvas_div style="width:70%; margin:0px auto; display: none;" >
        <canvas id="canvas" ></canvas>
    </div>
    {{-- Chart End --}} 

   

    {{-- <h1 class="my-4"></h1> --}}

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
                        "successfunc" : null,
                        "url" : 'SamplingRecord/AddandUpdate/'+0,
                        "extraparam" : {
                            "oper": oper
                        },
                        "aftersavefunc" : function( response ) { window.location.reload() }, //重新整理頁面    
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
          
            for(var key in selectRowData )
            {
                var elem = $("#" + target_id + "_" + key);
                //console.log(elem);
                
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
                    //console.log(cellvalue);
                }
                else
                {
                    cellvalue = elem.val();
                    //console.log(cellvalue);
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
                                "url" : 'SamplingRecord/AddandUpdate/'+ret.id,
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

     $("#Cancel").click( function(){
        target_id = 'none';
        var rowIds = $('#dg').jqGrid('getDataIDs'); 
        for(idIndex = 0; idIndex < rowIds.length; ++idIndex){           
            $("#dg").jqGrid('restoreRow',rowIds[idIndex], true); 
        }
        button_Control('after_Cancel');    
     });

      //獲取目前選取的資料    
      $("#Delete").click( function() { 
         var s = $("#dg").jqGrid('getGridParam','selrow');      
         if (s)	{
             var ret = $("#dg").jqGrid('getRowData',s);
             console.log(ret);           
             var answer = window.confirm("確認刪除此筆資料?");
             if (answer)
             {
                $.ajax({
                    url: "SamplingRecord/delete/" + ret.id ,//路徑
                    type: "DELETE",           
                    data:{
                        "id": ret.id,
                    },
                    success: function (UpdateValue){
                        $("#dg").jqGrid('setGridParam',
                        {                 
                            datatype: "local",              
                            data:UpdateValue.success,                        
                        }).trigger("reloadGrid");
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
            console.log(ret);           
            var answer = window.confirm("確認回填此筆資料?");
            if (answer)
            {
                $.ajax({
                    async:false,
                    url: "SamplingRecord/BackFill/" + ret.id ,//路徑
                    type: "POST",             
                    data:{
                        "id": ret.id,
                    },
                    success: function (UpdateValue){
                        console.log(UpdateValue);                        
                        $("#dg").jqGrid('setGridParam',
                        {                 
                            datatype: "local",              
                            data:UpdateValue.success,                        
                        }).trigger("reloadGrid");
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
                $("#Delete").attr("disabled",false);
                break;
            case "after_Delete":               
                $("#New").attr("disabled",false);
                $("#Edit").attr("disabled",false);
                $("#Save").attr("disabled",true);
                $("#Cancel").attr("disabled",true);                                  
                $("#Delete").attr("disabled",false);
                break;
            case "after_Edit":
                $("#Save").attr("disabled",false);
                $("#Cancel").attr("disabled",false);
                $("#New").attr("disabled",true);
                $("#Edit").attr("disabled",true);
                $("#Delete").attr("disabled",true);
                break;
            case "after_Cancel":
                $("#New").attr("disabled",false);
                $("#Edit").attr("disabled",false);
                $("#Save").attr("disabled",true);
                $("#Cancel").attr("disabled",true);                                  
                $("#Delete").attr("disabled",false);
                break;
            case "after_Save":
                $("#New").attr("disabled",false);
                $("#Edit").attr("disabled",false);
                $("#Save").attr("disabled",true);
                $("#Cancel").attr("disabled",true);                                  
                $("#Delete").attr("disabled",false);
                break;
        }    
    }

</script>
{{-- 表單送出方法 inline End --}}

{{-- 表單輸出、輸入功能 Start--}}
<script type="text/javascript">
     $("#ExportExcel").click(function(){
        
        var o = $("#dg");
        var rowNumber = o.jqGrid('getGridParam', 'records');//獲得搜尋後的紀錄筆數
        // console.log(rowNumber);
        o.jqGrid('setGridParam', { rowNum: rowNumber }).trigger('reloadGrid');//重新設定表格為搜尋後的資料                
        var columnNames = o.jqGrid('getGridParam', 'colNames');//從grid獲得colnames
        //console.log(columnNames);      
        //console.log(columnNames.length);
        //var ccc = o.jqGrid('getGridParam', 'data');

        var dataLo = o.jqGrid('getRowData');//獲得目前顯示在表格上的資料  
        
        //產生要寫入excel的data
        var i = 1;
        var dataToExcel = [];    
        dataToExcel.push(columnNames);

        for(var key in dataLo)
        {
            //console.log(dataLo[key]);
            var tmp = [];
            for (var p in dataLo[key])
            {
                //console.log(dataLo[key][p]);
                tmp.push(dataLo[key][p]);
            }
            dataToExcel.push(tmp);
        }
         
        var myDate = new Date().toISOString().slice(0,10); 

        //檔名
        var filename = myDate + '-' + 'SamplingRecord.xlsx';

        //表名
        var sheetname = 'Sheet';

        //下載
        downloadxlsx(filename, sheetname, dataToExcel);

         o.jqGrid('setGridParam', { rowNum: 10 }).trigger('reloadGrid'); //重新設定回原本的樣子       
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
     
            //舊key到新key的映射
            var oldkey = {
                編號: "id",
                急件: "urgent",                
                取樣日期: "sampling_date",
                品名: "product_name",                
                等級: "level",
                瓶號: "bottle_number",
                批號: "batch_number",
                取樣者: "sampler",
                樣品來源: "sample_source",
                分析項目: "analytical_item",
                分析者: "analyst",
                完成日: "completion_date",
                判定: "determination",
                備註: "remarks",
                "Assay (Purity)": "Assay",                
                "Parameter A": "Parameter_A", 
                "Impurity A": "Impurity_A",
                "Impurity B": "Impurity_B",
                "Impurity C": "Impurity_C",
                "Impurity D": "Impurity_D",
                "Impurity E": "Impurity_E",
                "Impurity F": "Impurity_F",
                "1H NMR": "1H_NMR",
                "Other Metals": "Other_Metals",
                "Parameter B": "Parameter_B",
                "Parameter C": "Parameter_C",
                "Parameter D": "Parameter_D",
                "Organic impurity": "Organic_impurity",
                "[δ2.2ppm]": "2_2ppm",
                "[δ3.8ppm]": "3_8ppm",
                "[δ4.0ppm]": "4_0ppm",
                "Sum[2.2+3.8+4.0]": "Sum223840"

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

            //var data = _todos;
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
                
                if (colName === '編號')
                {
                    colModel.push({name:colName, index:colName, align:"center", width:84, frozen:true});
                }
                else
                {
                    colModel.push({name:colName, index:colName, align:"center", width:112});
                }
            }
            
            $("#import_preview").jqGrid({      

                datatype: "local",
                //data:data,
                colNames: colNames,
                colModel: colModel,
                width: 896,
                height: 'auto',
                sortname: '編號',
                sortorder: "desc",
                hidegrid: false,
                cmTemplate: { title: false },   // Hide Tooltip
                gridview: true,
                shrinkToFit: false,
                loadComplete: function (){ fixPositionsOfFrozenDivs.call(this); }, // Fix column's height are different after enable frozen column feature 
            });
            $("#import_preview").jqGrid('setFrozenColumns');

        
            // Hide caption
            $("#gview_import_preview > .ui-jqgrid-titlebar").hide();

            for(var i=0; i < data.length; i++)
            {
                $("#import_preview").jqGrid('addRowData', i+1, data[i]);
            }    

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
                                            url: 'SamplingRecord/FileUpload/' + data[i].編號,
                                            method: 'post',
                                            async: false,//同步請求資料
                                            //datatype:"json",
                                            data: {
                                                UploadData:_upLoadData[i]                               
                                            },
                                            success: function (response) {                                                   
                                                $( function() 
                                                    {
                                                        $( "#progressbar" ).progressbar
                                                        ({
                                                            value: (i/data.length) * 100
                                                        });
                                                    });      
                                                if (response.success == data[data.length-1].編號){                                                    
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


<script type="text/javascript">
//   $grid = $("#dg"),
//     resizeColumnHeader = function () {
//         var rowHight, resizeSpanHeight,
//             // get the header row which contains
//             headerRow = $(this).closest("div.ui-jqgrid-view")
//                 .find("table.ui-jqgrid-htable>thead>tr.ui-jqgrid-labels");

//         // reset column height
//         headerRow.find("span.ui-jqgrid-resize").each(function () {
//             this.style.height = '';
//         });

//         // increase the height of the resizing span
//         resizeSpanHeight = 'height: ' + headerRow.height() + 'px !important; cursor: col-resize;';
//         headerRow.find("span.ui-jqgrid-resize").each(function () {
//             this.style.cssText = resizeSpanHeight;
//         });

//         // set position of the dive with the column header text to the middle
//         rowHight = headerRow.height();
//         headerRow.find("div.ui-jqgrid-sortable").each(function () {
//             var $div = $(this);
//             $div.css('top', (rowHight - $div.outerHeight()) / 2 + 'px');
//         });
//     },
//     fixPositionsOfFrozenDivs = function () {
//         var $rows;
//         if (this.grid.fbDiv !== undefined) {
//             $rows = $('>div>table.ui-jqgrid-btable>tbody>tr', this.grid.bDiv);
//             $('>table.ui-jqgrid-btable>tbody>tr', this.grid.fbDiv).each(function (i) {
//                 var rowHight = $($rows[i]).height(), rowHightFrozen = $(this).height();
//                 if ($(this).hasClass("jqgrow")) {
//                     $(this).height(rowHight);
//                     rowHightFrozen = $(this).height();
//                     if (rowHight !== rowHightFrozen) {
//                         $(this).height(rowHight + (rowHight - rowHightFrozen));
//                     }
//                 }
//             });
//             $(this.grid.fbDiv).height(this.grid.bDiv.clientHeight);
//             $(this.grid.fbDiv).css($(this.grid.bDiv).position());
//         }
//         if (this.grid.fhDiv !== undefined) {
//             $rows = $('>div>table.ui-jqgrid-htable>thead>tr', this.grid.hDiv);
//             $('>table.ui-jqgrid-htable>thead>tr', this.grid.fhDiv).each(function (i) {
//                 var rowHight = $($rows[i]).height(), rowHightFrozen = $(this).height();
//                 $(this).height(rowHight);
//                 rowHightFrozen = $(this).height();
//                 if (rowHight !== rowHightFrozen) {
//                     $(this).height(rowHight + (rowHight - rowHightFrozen));
//                 }
//             });
//             $(this.grid.fhDiv).height(this.grid.hDiv.clientHeight);
//             $(this.grid.fhDiv).css($(this.grid.hDiv).position());
//         }
//     },
//     fixGboxHeight = function () {
//         var gviewHeight = $("#gview_" + $.jgrid.jqID(this.id)).outerHeight(),
//             pagerHeight = $(this.p.pager).outerHeight();

//         $("#gbox_" + $.jgrid.jqID(this.id)).height(gviewHeight + pagerHeight);
//         gviewHeight = $("#gview_" + $.jgrid.jqID(this.id)).outerHeight();
//         pagerHeight = $(this.p.pager).outerHeight();
//         $("#gbox_" + $.jgrid.jqID(this.id)).height(gviewHeight + pagerHeight);
//     };
</script>

@endsection
