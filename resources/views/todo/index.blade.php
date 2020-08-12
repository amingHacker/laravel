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
            font-size: 1em;
        }
    .ui-jqgrid .ui-jqgrid-title{font-size:1em;}    /*修改grid標題字體大小*/
    
    .ui-jqgrid .ui-jqgrid-htable th {
            height: 2em !important;
    }
    .ui-jqgrid tr.jqgrow td{
            height: 2em !important;
            font-family:"Times New Roman", 微軟正黑體;
    }

    
</style>

{{-- CSS設定 End --}}

{{-- 響應式 Start --}}
<script type="text/javascript">
    // $(function(){

    //     const grid_selector = "#grid-table";
    //     const pager_selector = grid_selector + "_toppager";  
    //     const $grid = jQuery(grid_selector);


    //     function reSizejqGridWidth()
    //         { 
    //             //重新抓jqGrid容器的新width
    //             let newWidth = $grid.closest(".ui-jqgrid").parent().width();
    //             //是否縮齊column(相當於shrinkToFit)
    //             let shrinkToFit = true;
    //             $grid.jqGrid("setGridWidth", newWidth, shrinkToFit);
    //         }

    //     //初始化jqGrid
    //     $grid.jqGrid({ 
    //         datatype: "local",//小技巧，初始化jqGrid時，datatype設為local可以避免網頁一載入jqGrid就馬上對後端發出ajax request  
    //         toppager: true,
    //         pager: pager_selector,  
    //         loadComplete: function () {
    //              //Load完資料也要重新改變寬度才保險 
    //             reSizejqGridWidth();
    //         },
    //         height: "100%",//個人習慣把height設為auto或100%，資料多少筆高度就多少，如果height設為固定高度的話
    //         //資料一多，jqGrid會出現直的捲軸
    //         //autowidth: true,//autowidth有時候會造成破版或放在tab pane裡不會滿版，廢code得拿掉，由以下的parent_dom.width()取代
    //     });
 
    
    //     //setTimeout is for webkit only to give time for DOM changes and then redraw!!!
    //     //本範例先執行jqGrid初始化，所以可不用setTimeout，否則有時候setTimeout還是必須的
    //     //setTimeout(function () {
    //         reSizejqGridWidth(); 
    //     //}, 20);//end setTimeout

    //     //當使用者改變瀏覽器視窗大小時
    //     //resize to fit page size 
    //     $(window).on("resize", reSizejqGridWidth);
        
    // });
</script>
{{-- 響應式 End --}}

{{-- Data資料呈現 Start --}}
<script type="text/javascript">

    var _todos = @json($todos);
    var combobox_items = [];  //用來儲存colName內容選項
        
    // 先將傳回來的data存在前端陣列中
    var data = [];
    
    for( var i = 0; i < _todos.length; i++ ) {            
    data.push({
            "urgent":_todos[i].urgent,
            "id" : _todos[i].id,
            "start_at":_todos[i].start_at,
            "title" : _todos[i].title,       
            "created_at":_todos[i].created_at,
            "updated_at":_todos[i].updated_at,
            "item":_todos[i].item,        
        });
    }


    //console.log(data);
    
    /*****建立文件的方法*****/
    $(document).ready(function () {
        
        //建立動態表格
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
                colModel.push(
                        {name:colName, index:colName, width:100, align:"center",sortable:true, sorttype:"int", editable:false, cellattr: addCellAttrT}
                    );
            }
            else if (colName === 'start_at' || colName === 'created_at' || colName === 'updated_at')
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
                                    //showButtonPanel: true,
                                    showOn: 'focus',
                                    //format: "yyyy-mm-dd",
                                    autoclose:1
                                });
                            }
                        },                                   
                    }
                );
            }
            else if (colName === 'item')
            {
                colModel.push(
                    {
                        name:colName, index:colName, width:200, align:"center",sortable:false, editable:true, cellattr: addCellAttr,
                        //sorttype: "text", search:true,
                        //edittype:'select', editoptions:{value: getSelectItem()},
                        stype:'text',
                        edittype:'custom', editoptions:
                        {
                            custom_element: combobox_elem, custom_value:combobox_value
                        }, 
                        //searchoptions:{value: getSelectItem('item')}, stype:'select',
                        stype:'custom', searchoptions:
                        {
                            custom_element: combobox_elem, custom_value:combobox_value                   
                        },
                    }
                );
            }
            else if (colName === 'urgent')
            {
                colModel.push({name:colName, index:colName, width:50, sortable:false, align:"center", editable:false, cellattr: addCellAttr});
            }
            else
            {
                colModel.push({name:colName, index:colName, align:"center", width:112, editable:true});
            }

            //{name:'created_at',index:'created_at', width:200, align:"center",sortable:true, sorttype:"date", editable:false,cellattr: addCellAttr},
            //{name:'updated_at',index:'updated_at', width:200, align:"center",sortable:true, sorttype:"date", editable:false,cellattr: addCellAttr},
        }

        //舊key到新key的映射，colName的轉換
        var oldkey = {
                urgent: "急件",
                id: "編號",
                start_at: "開始時間",
                title: "名稱",                
                created_at: "建立時間",
                updated_at: "更新時間",
                item: "物件"
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
            url:'todo',
            altrows:true,
            datatype: "local",
            height:'100%',
            colNames:colNames,
            colModel:colModel,
            multiselect:false,
            rowNum:10,
            rowList:[10,20,50],
            pager: '#dgPager',
            sortname: '0',
            viewrecords: true,
            gridview: true,
            // sortorder: "desc",
            caption:"取樣紀錄 Sampling Records",
            shrinkToFit :false,
            //loadComplete: function (){ fixPositionsOfFrozenDivs.call(this); }, // Fix column's height are different after enable frozen column feature                                                  
        });
        
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
            
            $("#load_dg").show();
        });
       
        //重新Load Data
        $("#dg").jqGrid('setGridParam',
                    {
                        datatype: 'local',
                        data:data
                    }).trigger("reloadGrid");
        
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
            url: "todo/GetComboboxItem",//路徑
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
            items.push(combobox_items[i].item)
            // if (combobox_items[i].colName == name)
            // {
            //     items.push(combobox_items[i].kind)
            // }

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


  
</script>
{{-- Data資料呈現 End --}}

<script>
    $( function() {
        $('#datepicker').datetimepicker({
            dateFormat: 'yy-mm-dd', 
            timeFormat: 'HH:mm:ss'
        });
       
    });
</script>
 
<meta name="csrf-token" content="{{ csrf_token() }}"> 
<div class = "container">
    <h1 class="my-5"></h1>
    <div style = "margin:0px auto;">
        <img class=" img-responsive" src="img/Logo.png" >   
    </div>

    <div class = "row justify-content-center"> 
        
        <table id="dg" class = "row justify-content-center"></table>    
        <div id="dgPager"></div>                         
    </div>
    
    <div class = "row justify-content-center">
        <input type="BUTTON" class="btn btn-outline-info" id="Newtest"  value="新增" />
        <input type="BUTTON" class="btn btn-outline-info" id="Edittest"  value="編輯" />
        <input type="BUTTON" class="btn btn-outline-info" id="Savetest"  disabled="true" value="儲存" />
        <input type="BUTTON" class="btn btn-outline-info" id="Canceltest"  disabled="true" value="取消" />       
        <input type="BUTTON" class="btn btn-outline-info" id="Deletetest" value="刪除" />
        <input type="BUTTON" class="btn btn-outline-info" id="Exporttest" value="下載" />
        
        <div>
            <input id="file" type="file" onchange="Import(this)" style="display: none" />
            <input type="button" onclick="file.click()" class="btn btn-outline-info" id="Import" value="上傳" />
        </div>

        {{-- <input type="BUTTON" class="btn btn-outline-info" id="BackFill" value="回填" /> --}}
        {{-- <input type="BUTTON" class="btn btn-outline-info" id="ExportChart" value="圖表" /> --}}

        <div id="confirmDialog" title="Comfirm Information">
            <p></p>
        </div>
        <div id="warningDialog" title="Warning Information">
            <p></p>
        </div>     
        
        <div id="jqxToolBar">
        </div>
        {{-- Chart Start --}}
        <div id = canvas_div style="width:70%; margin:0px auto; display: none;" >
        <canvas id="canvas" ></canvas>
        </div>
        {{-- Chart End --}}     
    </div>
    
    
</div>
  
    <h1 class="my-4"></h1>
{{-- 表單送出方法 Start --}}
<script type="text/javascript">
    var token = $("meta[name='csrf-token']").attr("content");
    $("#Edit").click( function(){      
        var s = $("#dg").jqGrid('getGridParam','selrow');
         if (s)	{
            var ret = $("#dg").jqGrid('getRowData',s);
            //console.log(ret);           
            alert("id="+ret.id+ " title= "+ret.title+"...");  

            var gr = $("#dg").jqGrid('editGridRow', s, 
                {
                    height:280,
                    width:300,    
                
                    reloadAfterSubmit:false,
                    closeAfterEdit:true,
                    align:"center",
                    loadonce: true,
                    recreateForm: false,
                    repeatitems: false,
            
                    url: "/todo/" + ret.id,//路徑
                    mtype: "POST",
                    datatype: "json",
                    editData:{                   
                        "_token": token,
                        "id":ret.id
                    },
                    editurl:"/todo/"+ ret._id,
                    afterSubmit: function(response, postdata)
                    {
                        //console.log(editData);
                        location.reload(true);
                    }
                    
            
                }
            );     
         }
         else
             alert("Please select row...");
     });

    $("#New").click(function(){
        var token = $("meta[name='csrf-token']").attr("content");
        var s = $("#dg").jqGrid('editGridRow',"new",{
            width:300,    
            height:280,
            reloadAfterSubmit:true,
            closeAfterAdd:true,
            align:"center",
            loadonce: true,
            recreateForm: true,
           
            url: "/todo",//路徑
            mtype: "POST",
            datatype: "json",
            editData:{                   
                "_token": token,
                // "title" : '_title',
            },
            editurl:"/todo",
            afterSubmit: function(){
                location.reload(true);
            }
                         
                             
        });
    });

</script>
{{-- 表單送出方法 End--}}

{{-- 表單送出方法 inline Start --}}
<script type="text/javascript">

    var target_id = 'none'; //紀錄目前要修改的列id
    var selectRowData = []; //紀錄選擇的目前的rowdata

    $("#Newtest").click( function(){
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
    
     $("#Edittest").click( function(){
        var token = $("meta[name='csrf-token']").attr("content");     
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
             alert("Please select row...");
     });

     $("#Savetest").click( function(){
       
        var token = $("meta[name='csrf-token']").attr("content");
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
                        "url" : 'todo/AddandUpdate/'+0,
                        "extraparam" : {
                            "oper": oper
                        },
                        "aftersavefunc" : function( response ) {
                                            //alert('saved');
                                            window.location.reload()  //重新整理頁面
                                        },
                        "errorfunc": null,
                        "afterrestorefunc" : null,
                        "restoreAfterError" : true,
                        "mtype" : "POST"
                }
                $("#dg").jqGrid('saveRow', 0, saveparameters);
        }
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
                //edit_statement += result[key] + "：\"" + value_before + "\" to \"" + value_after + "\", ";
                
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
                                "url" : 'todo/AddandUpdate/'+ret.id,
                                //"url":'clientArray',
                                "extraparam" : {                                   
                                    "id" : ret.id,
                                    "oper" : "edit",                                  
                                },
                                "aftersavefunc" : function( response ) {
                                                    //alert('saved');
                                                    //window.location.reload();  //重新整理頁面
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

     $("#Canceltest").click( function(){
        target_id = 'none';
        var rowIds = $('#dg').jqGrid('getDataIDs'); 
        for(idIndex = 0; idIndex < rowIds.length; ++idIndex){           
            $("#dg").jqGrid('restoreRow',rowIds[idIndex], true); 
        }
        button_Control('after_Cancel');    
     });

      //獲取目前選取的資料    
      $("#Deletetest").click( function() {
        //  var token = $("meta[name='csrf-token']").attr("content");
         var s = $("#dg").jqGrid('getGridParam','selrow');      
         if (s)	{
             var ret = $("#dg").jqGrid('getRowData',s);
             console.log(ret);           
             var answer = window.confirm("確認刪除此筆資料?");
             if (answer)
             {
                $.ajax({
                    url: "todo/delete/" + ret.id ,//路徑
                    type: "DELETE",
                   
                    data:{
                        "id": ret.id,
                        //"_token": token,
                    },
                    success: function (){
                        console.log("it Works");
                        //window.location.reload()  //重新整理頁面
                    }                               
                });
             }        
         }
         else        
             alert("Please select row...");     
        });  


     // Buttons control function
    function button_Control(state)
    {
        switch (state)
        {
            case "after_Add":          
                $("#Savetest").attr("disabled",false);
                $("#Canceltest").attr("disabled",false);                   
                $("#Newtest").attr("disabled",true);
                $("#Edittest").attr("disabled",true);
                $("#Deletetest").attr("disabled",false);
                break;
            case "after_Delete":               
                $("#Newtest").attr("disabled",false);
                $("#Edittest").attr("disabled",false);
                $("#Savetest").attr("disabled",true);
                $("#Canceltest").attr("disabled",true);                                  
                $("#Deletetest").attr("disabled",false);
                break;
            case "after_Edit":
                $("#Savetest").attr("disabled",false);
                $("#Canceltest").attr("disabled",false);
                $("#Newtest").attr("disabled",true);
                $("#Edittest").attr("disabled",true);
                $("#Deletetest").attr("disabled",true);
                break;
            case "after_Cancel":
                $("#Newtest").attr("disabled",false);
                $("#Edittest").attr("disabled",false);
                $("#Savetest").attr("disabled",true);
                $("#Canceltest").attr("disabled",true);                                  
                $("#Deletetest").attr("disabled",false);
                break;
            case "after_Save":
                $("#Newtest").attr("disabled",false);
                $("#Edittest").attr("disabled",false);
                $("#Savetest").attr("disabled",true);
                $("#Canceltest").attr("disabled",true);                                  
                $("#Deletetest").attr("disabled",false);
                break;
        }    
    }

</script>
{{-- 表單送出方法 inline End --}}



{{-- 表單輸出、輸入功能 Start--}}
<script type="text/javascript">
     $("#Exporttest").click(function(){
        
        var o = $("#dg");
        // var rowNumber = o.jqGrid('getGridParam', 'records');
        // console.log(rowNumber);
        // o.jqGrid('setGridParam', { rowNum: rowNumber }).trigger('reloadGrid');     
        // var i;
        // for (i = 0; i < columnNames.length; i++)
        // {
        //     console.log(columnNames[i]);
        // }
         var columnNames = o.jqGrid('getGridParam', 'colNames');
         //console.log(columnNames);      
         //console.log(columnNames.length);

         var ccc = o.jqGrid('getGridParam', 'data');


        var dataLo = o.jqGrid('getRowData');
        // console.log(dataLo);     

        //產生要寫入excel的data
        var i = 1;
        var dataToExcel = [];    
        //dataToExcel[0] = columnNames;
        //console.log(dataToExcel[0]);
        dataToExcel.push(columnNames);

        for(var key in dataLo)
        {
            console.log(dataLo[key]);
            var tmp = [];
            for (var p in dataLo[key])
            {
                console.log(dataLo[key][p]);
                tmp.push(dataLo[key][p]);
            }
            dataToExcel.push(tmp);
        }
      
        // for(i = 1; i <= dataLo.length; i++)
        // {            
        //     dataToExcel[i] = dataLo[i-1];
        //     dataToExcel[i] = [
        //         dataLo[i-1]['_checked'], dataLo[i-1]['_id'], dataLo[i-1]['start_at'], dataLo[i-1]['title'], 
        //     dataLo[i-1]['created_at'], dataLo[i-1]['updated_at'], dataLo[i-1]['item']
        //     ];
        //     //console.log(dataToExcel[i]);
        // };     

        //檔名
        var filename = 'SamplingRecord.xlsx';

        //表名
        var sheetname = 'Sheet';

        //下載
        downloadxlsx(filename, sheetname, dataToExcel);       
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
                急件: "urgent",
                編號: "id",
                開始時間: "start_at",
                名稱: "title",                
                建立時間: "created_at",
                更新時間: "updated_at",
                物件: "item"

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
                colNames: colNames,
                colModel: colModel,
                width: 896,
                height: '100%',
                sortname: '編號',
                sortorder: "desc",
                hidegrid: false,
                cmTemplate: { title: false },   // Hide Tooltip
                gridview: true,
                shrinkToFit: false
            });
            //$("#import_preview").jqGrid('setFrozenColumns');
        
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
                                            url: 'todo/FileUpload/' + data[i].編號,
                                            method: 'post',
                                            async: false,//同步請求資料
                                            //datatype:"json",
                                            data: {
                                                UploadData:_upLoadData[i]
                                                //"id": data[i].編號,
                                                //"title": data[i].名稱,
                                                //"item": data[i].物件,                                
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
    $(document).ready(function () {
        $("#jqxToolBar").jqxToolBar({ width: "100%", height: 35, tools: "button | dropdownlist combobox | input",
            initTools: function (type, index, tool, menuToolIninitialization) {
                switch (index) {
                    case 0:
                        tool.text("Button");
                        break;
                    case 1:
                        tool.jqxDropDownList({ width: 130, source: ["Affogato", "Breve", "Café Crema"], selectedIndex: 1 });
                        break;
                    case 2:
                        tool.jqxComboBox({ width: 50, source: [8, 9, 10, 11, 12, 14, 16, 18, 20], selectedIndex: 3 });
                        break;
                    case 3:
                        tool.jqxInput({ width: 200, placeHolder: "Type here..." });
                        break;
                }
            }
        });
    });
</script>

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
