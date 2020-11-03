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
    var SearchCondition = @json($SearchCondition);
    var combobox_items = [];  //用來儲存colName內容選項
    var productSpec = []; //用來儲存productSpec資訊

    var filter = (SearchCondition!=null)?SearchCondition["filters"]:'';
   
    
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

            else if (colName === 'sampling_date' || colName === 'completion_date')
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
            else if (colName === 'product_name'|| colName === 'level' || colName === 'sampler' 
            || colName === 'sample_source' || colName === 'analytical_item' || colName === 'analyst' 
            || colName === 'determination' || colName === 'sampling_kind' || colName == 'equipment_name') 
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
            else if (colName === 'urgent')
            {
                colModel.push({
                    name:colName, index:colName, width:60, align:"center", editable:true, cellattr: addCellAttrUrgent,
                    edittype: "checkbox", editoptions: { value: "TRUE:FALSE", defaultValue:"FALSE" }, 
                    formatter: "checkbox", formatoptions: { disabled: true} ,
                    search:true,
                    stype: "select",
                        searchoptions: {
                            sopt: ['eq','ne'],
                            value:"TRUE:TRUE",
                        },                
                });
            }
            else if (colName === 'remarks')
            {
                colModel.push({name:colName, index:colName, width:250, align:"left", editable:true, cellattr: addCellAttr});
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
        var jqgridWidth = parseInt($(window).width()) * 0.7;
        
        // 準備資料           
        $("#dg").jqGrid({
            url:"MyCharts/show",
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
            caption:"取樣紀錄 Sampling Records",
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
            postData: {
                    filters: filter
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
                    
                showRightClick(rowid, e);
            },
            onSelectRow:function(rowid,status,e){
                handleClickMouseDown(e);
            },
            rowattr: function (rd){if (rd.determination === 'Fail'){ return {"class": "failRow"};}}                                                            
        }).jqGrid('setFrozenColumns'); 
        
        //增加Tool bar        
        $("#dg").jqGrid('navGrid','#dgPager', { 
                search:true, edit:false, add:false, del:false, refresh:true,
                
            } 
        );
        
        var SearchCaption = (filter =='')? '搜尋...(未儲存)':'搜尋...(已儲存)';
        
        //增加更多的搜尋條件
        $.extend($.jgrid.search, {
                    multipleSearch: true,
                    recreateFilter: true,
                    closeOnEscape: true,
                    searchOnEnter: true,
                    overlay: 1,
                    closeAfterSearch:true,
                    caption: SearchCaption,
                    onReset : function() {
                        $("#load_dg").show();
                        $.ajax({
                                async:false,
                                url: "MyCharts/ResetMyChartCondition" ,//路徑
                                type: "POST",           
                                data:{
                                    
                                },
                                success: function (DownLoadValue)
                                        {
                                            $("#dg").jqGrid('setGridParam',{search:false});
                                            $('#dg').trigger( 'reloadGrid' );
                                            $.extend($.jgrid.search, {             
                                                    caption: '搜尋...(未儲存)',                 
                                            });
                                        }                               
                            });       
                            return true;
                        },
                   
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
            $("#load_dg").show();
            $.ajax({
                    async:false,
                    url: "MyCharts/ResetMyChartCondition" ,//路徑
                    type: "POST",           
                    data:{
                        
                    },
                    success: function (DownLoadValue){
                            $("#dg").jqGrid('setGridParam',{search:false});
                            $('#dg').trigger( 'reloadGrid' );
                            $.extend($.jgrid.search, {             
                                    caption: '搜尋...(未儲存)',                 
                            });              
                        }                               
                    });                         
        });

   
        //獲得combobox的內容
        combobox_items = getComboboxItem();

        //獲得product SPEC
        productSpec = getproductSPEC();

        //獲得權限設定
        getAuthority();

        var _ChartTypeSource = ["Scatter Chart", "Control Chart"];
        var _xAxisSource = ["取樣日期", "次數", "批號"];
        var _yAxisSource = ["MeO", "Assay (Purity)", "HC", "Si", "Sn", "Al", "I", "Fe", "Zn", "Ag", "As", "Au", "B", "Ba",
                            "Be", "Bi", "Ca", "Cd", "Ce", "Co", "Cr", "Cs", "Cu", "Ga", "Ge", "Hg", "In", "K",
                            "La", "Li", "Mg", "Mn", "Mo", "Na", "Nb", "Ni", "P", "Pb", "Pd", "Pt", "Rb", "Re", "Rh", 
                            "Ru", "S", "Sb", "Se", "Sr", "Ta", "Tb", "Te", "Th", "Ti", "Tl", "U", "V", "W", "Y", "Zr", 
                            "F", "Cl", "Hf", "H2O","Parameter A", "Parameter B", "Parameter C", "Parameter D", "Impurity A","Impurity B", 
                            "Impurity C", "Impurity D", "Impurity E", "Impurity F", "1H NMR", "Other Metals", "Organic impurity",
                            "[δ0.0ppm]", "[δ2.2ppm]", "[δ3.8ppm]", "[δ4.0ppm]", "Sum[2.2+3.8+4.0]", "IR A", "DMAH"
                        ];
        var _GroupSource = ["品名","等級", "瓶號","批號", "取樣者", "樣品來源", 
            "分析項目","分析者", "完成日","判定", "備註", "設備名稱", 
            "MeO", "Assay (Purity)", "HC", "Si", "Sn", "Al", "I", "Fe", "Zn", "Ag", "As", "Au", "B", "Ba",
            "Be", "Bi", "Ca", "Cd", "Ce", "Co", "Cr", "Cs", "Cu", "Ga", "Ge", "Hg", "In", "K",
            "La", "Li", "Mg", "Mn", "Mo", "Na", "Nb", "Ni", "P", "Pb", "Pd", "Pt", "Rb", "Re", "Rh", 
            "Ru", "S", "Sb", "Se", "Sr", "Ta", "Tb", "Te", "Th", "Ti", "Tl", "U", "V", "W", "Y", "Zr", 
            "F", "Cl", "Hf", "H2O", "Parameter A", "Parameter B", "Parameter C", "Parameter D", "Impurity A","Impurity B", 
            "Impurity C", "Impurity D", "Impurity E", "Impurity F", "1H NMR", "Other Metals", "Organic impurity",
            "[δ0.0ppm]", "[δ2.2ppm]", "[δ3.8ppm]", "[δ4.0ppm]", "Sum[2.2+3.8+4.0]", "IR A", "DMAH"
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
            "急件": "urgent",  
            "取樣日期": "sampling_date",
            "品名": "product_name",
            "等級": "level",
            "瓶號": "bottle_number",
            "批號":"batch_number",
            "Assay (Purity)": "Assay",
            "取樣者": "sampler",
            "樣品來源": "sample_source",
            "分析項目" : "analytical_item",
            "分析者" : "analyst",
            "完成日" : "completion_date",
            "判定" : "determination",
            "備註" : "remarks",
            "Parameter A" : "Parameter_A",
            "Impurity A" : "Impurity_A",
            "Impurity B" : "Impurity_B",
            "Impurity C" : "Impurity_C",
            "Impurity D" : "Impurity_D",
            "Impurity E" : "Impurity_E",
            "Impurity F" : "Impurity_F",
            "1H NMR" : "1H_NMR",
            "Other Metals" : "Other_Metals",
            "Parameter B" : "Parameter_B",
            "Parameter C" : "Parameter_C",
            "Parameter D" : "Parameter_D" ,
            "Organic impurity" : "Organic_impurity",
            "[δ0.0ppm]" : "0_0ppm",
            "[δ2.2ppm]" : "2_2ppm",
            "[δ3.8ppm]" : "3_8ppm",
            "[δ4.0ppm]" : "4_0ppm",
            "Sum[2.2+3.8+4.0]" : "Sum223840",
            "IR A" : "IR_A",
            "設備名稱" : "equipment_name",
            "標準液批號" : "standard_solution", 
            "取樣類別" : "sampling_kind",
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
            url: "SamplingRecord/GetComboboxItem",//路徑
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
                // if (Authority["View_Log"] == '1'){ 
                //     document.getElementById("ViewLog").style.display="";
                // }
                // if (Authority["ProductSPEC"] == '1'){
                //     sessionStorage.setItem('QC_USER' , "true"); 
                // }
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
        <img class=" img-responsive" src="img/Logo_MyCharts.png" >   
    </div>
    
    <div align="center">
        <table id="dg" ></table> 
        <div id="dgPager"></div>
    </div>                             

    <div align="center">
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="ResetSetting" style="display: " value="重新設定" />   
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="SaveSetting" style="display: " value="儲存設定" />       
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="ExportChart" value="圖表" />
        <input type="BUTTON" class="btn btn-outline-info btn-space" id="CloseChart" value="收合" />
    
    
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

    $("#SaveSetting").click( function(){
    $.extend($.jgrid.search, {             
            caption: '搜尋...(已儲存)',                 
        });
    var o = $("#dg");
    var postData = o.jqGrid('getGridParam', 'postData');//獲得搜尋條件
    
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
    
    for(var j = 0; j < 1; j++)
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
        LabelItem.push("batch_number");
        DateItem.push("sampling_date");
        
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

    var ToolBarData = {
        chartType : chartTypeGroup[0],
        dataXaxis : dataXaxisGroup[0],
        dataYaxis : dataYaxisGroup[0],
        columnName : columnNameGroup[0],
        item : itemGroup[0],
        USL : USLGroup[0],
        LSL : LSLGroup[0],
        UCL : UCLGroup[0],
        LCL : LCLGroup[0],
        YaxisMax : YaxisMax[0],
        YaxisMin : YaxisMin[0],
    }

    var ToolBarDataString = JSON.stringify(ToolBarData); 

    $.ajax({
            async:false,
            url: "MyCharts/SaveMyChartCondition" ,//路徑
            type: "POST",           
            data:{
                "postData" : postData,
                "ToolBarDataString" : ToolBarDataString,
            },
            success: function (DownLoadValue){
                var dataLo = DownLoadValue.success;                
                }                               
            });                 

    });

    $("#ResetSetting").click( function(){ 
    $.ajax({
            async:false,
            url: "MyCharts/ResetMyChartCondition" ,//路徑
            type: "POST",           
            data:{
                
            },
            success: function (DownLoadValue){
                    $("#dg").jqGrid('setGridParam',{search:false});
                    $('#dg').trigger( 'reloadGrid' );
                    $.extend($.jgrid.search, {             
                            caption: '搜尋...(未儲存)',                 
                    });              
                }                               
            });                 

    });

   

</script>
{{-- 表單送出方法 inline End --}}


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
        
        $.ajax({
                async:false,
                url: "MyCharts/GetMyChartCondition" ,//路徑
                type: "GET",           
                data:{
                    
                },
                success: function (DownLoadValue)
                {
                    var SearchCondition = DownLoadValue.SearchCondition;
                    if (SearchCondition!=null && SearchCondition["ChartCondition"]!= '')
                    {
                        initial = 'false';
                        var ToolBarData = (SearchCondition!=null)?JSON.parse(SearchCondition["ChartCondition"]):'';
                        for(var j = 0; j < 1; j++)
                        {
                        
                            //取得資料庫的Toolbar的資料
                            var tools = $("#jqxToolBar" + ( j + 1 )).jqxToolBar("getTools");
                            $(tools[1].tool[0]).jqxDropDownList('val', ToolBarData["chartType"]);
                            $(tools[3].tool[0]).jqxDropDownList('val', getColumnNameFromDatabaseToChinese(ToolBarData["dataXaxis"]));
                            $(tools[5].tool[0]).jqxComboBox('val', getColumnNameFromDatabaseToChinese(ToolBarData["dataYaxis"]));
                            $(tools[7].tool[0]).jqxComboBox('val', getColumnNameFromDatabaseToChinese(ToolBarData["columnName"]));
                            $(tools[8].tool[0]).jqxInput('val', ToolBarData["item"]);
                        
                            //取得資料庫的Toolbar的資料
                            var toolsConChart = $("#jqxToolBarConChart" + ( j + 1 )).jqxToolBar("getTools");
                            $(toolsConChart[1].tool[0]).jqxInput('val', ToolBarData["USL"]);
                            $(toolsConChart[3].tool[0]).jqxInput('val', ToolBarData["LSL"]);
                            $(toolsConChart[5].tool[0]).jqxInput('val', ToolBarData["UCL"]);
                            $(toolsConChart[7].tool[0]).jqxInput('val', ToolBarData["LCL"]);
                        
                            //取得資料庫的Toolbar的資料 
                            var toolsBarChartRange = $("#jqxToolBarChartRange" + ( j + 1 )).jqxToolBar("getTools");
                            $(toolsBarChartRange[1].tool[0]).jqxInput('val', ToolBarData["YaxisMax"]);
                            $(toolsBarChartRange[3].tool[0]).jqxInput('val', ToolBarData["YaxisMin"]);                          
                        }
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
                        LabelItem.push("batch_number");
                        DateItem.push("sampling_date");
                        
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

                    // var SearchCondition = @json($SearchCondition);

                    var postData = o.jqGrid('getGridParam', 'postData');//獲得搜尋條件

                    $.ajax({
                            async:false,
                            url: "MyCharts/MyChartExport" ,//路徑
                            type: "POST",           
                            data:{
                                "postData": postData,
                            },
                            success: function (DownLoadValue){
                                var dataLo = DownLoadValue.success;
                                //產生要寫入excel的data
                                //參數格式: original data -> toolbar data -> toolbar control data 
                                    DrowChart( 'Sampling Records', dataLo, 
                                        chartTypeGroup, dataXaxisGroup, dataYaxisGroup, 
                                        columnNameGroup, itemGroup, 
                                        USLGroup, LSLGroup, UCLGroup, LCLGroup, LabelItem, DateItem,
                                        YaxisMax, YaxisMin, SPCRule
                                    );                  
                                }                               
                            });                 
                                   
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
                url: "SamplingRecord/GetDataFromID" ,//路徑
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
            url: "SamplingRecord/GetDataFromID" ,//路徑
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
