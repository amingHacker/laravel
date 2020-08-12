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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
<script src="https://www.chartjs.org/dist/2.9.3/Chart.min.js"></script>
<script src="https://www.chartjs.org/samples/latest/utils.js"></script>
{{-- 圖表生成 Chart.js End --}}

{{-- CSS設定 Start--}}
{{-- <style type="text/css">
    /*預設已是overflow:auto，寫在網頁裡再次確保會出現scroller*/
     .ui-jqgrid .ui-jqgrid-bdiv {
       overflow:auto; 
     }
</style> --}}


<style>
    .text-break {
       white-space: normal !important;
       height:auto;
       vertical-align:text-top;
       padding-top:2px;
     }
</style>

{{-- CSS設定 End --}}



<div id='tabs' style = 'width: 90% ;margin:0px auto; text-align:justify' >
    <button id='add-tab'>＋ Tabs</button>
    <button id='remove-tab'>－ Tabs</button>
    <ul>
        <li><a href='#tab1'>Group 1</a></li>
    </ul>
    <div id='tab1' style='background-color:powderblue;'>
        <span style='font-weight:bold; color:#2e6e9e; display:block; text-align:center'>《 Group 1 》</span> <br />
        <div id="jqxToolBar1" style = "margin:0px auto; text-align:justify" ></div>
        <h1 class="my-1"></h1>
        <div id="jqxToolBarConChart1" style = " margin:0px auto; text-align:justify" ></div>
    </div>
</div>


<script type="text/javascript">
$(document).ready(function() {
    $("#tabs").tabs();
    createToolbar(1);
    $("button#add-tab").click(
        function() 
        {
            var tabs =  $("#tabs").tabs();
            var num_tabs = $("#tabs ul li").length + 1;
            $("#tabs ul").append(
                "<li><a href='#tab" + num_tabs + "'>Group " + num_tabs + "</a></li>"
            );

            $("#tabs").append("<div id='tab"+ num_tabs+ "' style='background-color:powderblue;'>"
                + "<span style='font-weight:bold; color:#2e6e9e; display:block; text-align:center'>《 Group " + num_tabs + " 》</span> <br />"       
                + "<div id='jqxToolBar" + num_tabs + "' style = 'margin:0px auto; text-align:justify' ></div>" 
                + "<h1 class ='my-1'></h1>"
                + "<div id='jqxToolBarConChart" + num_tabs + "' style = 'margin:0px auto; text-align:justify' ></div>"
                + "</div>");
            
            createToolbar(num_tabs);

            $("#tabs").tabs("refresh");
        }
    );
    
    $("button#remove-tab").click(
        function() 
        {
            var tabs =  $("#tabs").tabs();
            var num_tabs = $("#tabs ul li").length;

            $('#tabs').tabs('remove', num_tabs - 1);

            $("#tabs").tabs("refresh");
        }
    );               
});

    function createToolbar(num_tabs){
        var _ChartTypeSource = ["Scatter Chart", "Control Chart"];
        var _xAxisSource = ["sampling_date", "次數"];
        var _yAxisSource = ["MeO", "Assay", "HC", "Si", "Sn", "Al", "I", "Fe", "Zn", "Ag", "As", "Au", "B", "Ba",
                            "Be", "Bi", "Ca", "Cd", "Ce", "Co", "Cr", "Cs", "Cu", "Ga", "Ge", "Hg", "In", "K",
                            "La", "Li", "Mg", "Mn", "Mo", "Na", "Nb", "Ni", "P", "Pb", "Pd", "Pt", "Rb", "Re", "Rh", 
                            "Ru", "S", "Sb", "Se", "Sr", "Ta", "Tb", "Te", "Th", "Ti", "Tl", "U", "V", "W", "Y", "Zr", 
                            "F", "Cl", "Parameter_A", "Parameter_B", "Parameter_C", "Parameter_D", "Impurity_A","Impurity_B", 
                            "Impurity_C", "Impurity_D", "Impurity_E", "Impurity_F", "1H_NMR", "Other_Metals", "Organic_impurity",
                            "2_2ppm", "3_8ppm", "4_0ppm", "Sum223840"
                        ];
        var _GroupSource = ["product_name","level", "bottle_number","batch_number", "sampler", "sample_source", 
            "analytical_item","analyst","determination", "remarks", 
            "MeO", "Assay", "HC", "Si", "Sn", "Al", "I", "Fe", "Zn", "Ag", "As", "Au", "B", "Ba",
            "Be", "Bi", "Ca", "Cd", "Ce", "Co", "Cr", "Cs", "Cu", "Ga", "Ge", "Hg", "In", "K",
            "La", "Li", "Mg", "Mn", "Mo", "Na", "Nb", "Ni", "P", "Pb", "Pd", "Pt", "Rb", "Re", "Rh", 
            "Ru", "S", "Sb", "Se", "Sr", "Ta", "Tb", "Te", "Th", "Ti", "Tl", "U", "V", "W", "Y", "Zr", 
            "F", "Cl", "Parameter_A", "Parameter_B", "Parameter_C", "Parameter_D", "Impurity_A","Impurity_B", 
            "Impurity_C", "Impurity_D", "Impurity_E", "Impurity_F", "1H_NMR", "Other_Metals", "Organic_impurity",
            "2_2ppm", "3_8ppm", "4_0ppm", "Sum223840"
        ];
        // var _groupSource = ["product_name",  "level", "analytical_item"];
        var _dataSource = [];  //用來保存
        // var itemCount = 7; // The item count of Toolbar.
        $("#jqxToolBar" + num_tabs).jqxToolBar({ 
            width: "80%", height: '35', 
            tools: "toggleButton dropdownlist | toggleButton dropdownlist | toggleButton combobox | toggleButton | button  button  ",
            //tools: "toggleButton toggleButton toggleButton | dropdownlist combobox | input",
            initTools: function (type, index, tool, menuToolIninitialization) 
            {
                switch (index) 
                {
                    case 0:
                        tool.jqxToggleButton({ width: 80, toggled: true });
                        tool.text("Chart:");
                        break;
                    case 1:
                        tool.jqxDropDownList({ width: 120, source: _ChartTypeSource, selectedIndex: -1});
                        //tool.jqxComboBox({ width: 130, source: _xAxisSource, selectedIndex: 0 });
                        break;  
                    case 2:
                        tool.jqxToggleButton({ width: 80, toggled: true });
                        tool.text("X axis:");
                        break;
                    case 3:
                        tool.jqxDropDownList({ width: 120, source: _xAxisSource, selectedIndex: -1});
                        //tool.jqxComboBox({ width: 130, source: _xAxisSource, selectedIndex: 0 });
                        break;  
                    case 4:
                        tool.jqxToggleButton({ width: 80, toggled: true });
                        tool.text("Y axis:");
                        break;                 
                    case 5:
                        //     tool.jqxDropDownList({ width: 130, source: _yAxisSource, selectedIndex:  -1});
                        tool.jqxComboBox({ width: 120, source: _yAxisSource, selectedIndex: -1, searchMode: 'containsignorecase', autoComplete: true });
                        break;
                    case 6:
                        tool.jqxToggleButton({ width: 80, toggled: true });
                        tool.text("Group:");
                        break;
                    case 7:
                        tool.text("＋");
                        tool.on("click", function (event) {                            
                                        var position = "last";

                                        $("#jqxToolBar"+ num_tabs).jqxToolBar("addTool", "combobox", position, false, function (type, tool, menuToolIninitialization) 
                                        {
                                            var width;
                                            if (menuToolIninitialization) {
                                                // specific setting for minimized tool
                                                width = "100%";
                                            } else {
                                                width = 120;
                                            }
                                            tool.jqxComboBox({ width: width, source: _GroupSource, selectedIndex: -1, searchMode: 'containsignorecase', autoComplete: true});
                                            //tool.jqxDropDownList({ width: 130, source: _dataSource, selectedIndex: -1 });
                                        });

                                        $("#jqxToolBar"+ num_tabs).jqxToolBar("addTool", "input", position, false, function (type, tool, menuToolIninitialization) 
                                        {          
                                            var width;
                                            if (menuToolIninitialization) {
                                                // specific setting for minimized tool
                                                width = "100%";
                                            } else {
                                                width = 120;
                                            }
                                            
                                            tool.jqxInput({ width: width, placeHolder: "Type here..." })
    
                                        });                                 
                                        
                                    });
                        break;
                    case 8:
                        tool.text("－");
                        tool.on("click", function (event) 
                            {                            
                                var position = "last";
                                var toolsCount = $("#jqxToolBar"+ num_tabs).jqxToolBar("getTools").length - 1;
                                if (toolsCount > 8)
                                {
                                    $("#jqxToolBar"+ num_tabs).jqxToolBar("destroyTool", toolsCount );
                                }             
                            });                    
                        break;           
                }
            }
        });

        $("#jqxToolBarConChart" + num_tabs).jqxToolBar({ 
            width: "80%", height: '35', 
            tools: "toggleButton input | toggleButton input | toggleButton input | toggleButton input ",
            //tools: "toggleButton toggleButton toggleButton | dropdownlist combobox | input",
            initTools: function (type, index, tool, menuToolIninitialization) 
            {
                switch (index) 
                {
                    case 0:
                        tool.jqxToggleButton({ width: 80, toggled: true });
                        tool.text("USL:");
                        break;
                    case 1:
                        tool.jqxInput({ width: 120, placeHolder: "Type here..." })
                        break;  
                    case 2:
                        tool.jqxToggleButton({ width: 80, toggled: true });
                        tool.text("LSL:");
                        break;
                    case 3:
                        tool.jqxInput({ width: 120, placeHolder: "Type here..." })
                        break;
                    case 4:
                        tool.jqxToggleButton({ width: 80, toggled: true });
                        tool.text("UCL:");
                        break;
                    case 5:
                        tool.jqxInput({ width: 120, placeHolder: "Type here..." })
                        break;
                    case 6:
                        tool.jqxToggleButton({ width: 80, toggled: true });
                        tool.text("LCL:");
                        break;
                    case 7:
                        tool.jqxInput({ width: 120, placeHolder: "Type here..." })
                        break;  
                }
            }
        });
    }        

</script>




@endsection


