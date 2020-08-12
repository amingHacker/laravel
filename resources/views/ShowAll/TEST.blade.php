@extends('mainlayout.layouts.master')

@section('content')  



{{-- Data資料呈現 Start --}}
<script type="text/javascript">

    var myList = @json($todos);


    
</script>
{{$todos}}

@endsection
<script type="text/javascript">
    //直線圖
    // var config = {
    //     type: 'line',
    //     data: {
    //         datasets: _dataset
    //         // [
    //         // {
    //         //     label: dataGroup[0],
    //         //     backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
    //         //     borderColor: window.chartColors.red,
    //         //     fill: false,
    //         //     data: dataToChart[0]
    //         // }, 
    //         // {
    //         //     label: dataGroup[1],
    //         //     backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
    //         //     borderColor: window.chartColors.blue,
    //         //     fill: false,
    //         //     data: dataToChart[1]
    //         // }
    //         // ]
    //     },
    //     options: {
    //         responsive: true,
    //         title: {
    //             display: true,
    //             text: 'Solvent Removal'
    //         },
    //         scales: {
    //             xAxes: [{
    //                 type: 'time',
    //                 display: true,
    //                 scaleLabel: {
    //                     display: true,
    //                     labelString: 'Date'
    //                 },
    //                 ticks: {
    //                     major: {
    //                         fontStyle: 'bold',
    //                         fontColor: '#FF0000'
    //                     }
    //                 }
    //             }],
    //             yAxes: [{
    //                 display: true,
    //                 scaleLabel: {
    //                     display: true,
    //                     labelString: 'value'
    //                 }
    //             }]
    //         }
    //     }
    // };

    //window.myLine = new Chart(ctx, config);

    //tool bar 動態產生按鈕
    //tool.jqxDropDownList({ width: 130, source: _groupSource, selectedIndex:  -1});
    //tool.jqxComboBox({ width: 130, source: _groupSource, selectedIndex: 0 });
    //tool.on("change", function (event) 
    // {   
        
    //     var _tmptoolsCount = $("#jqxToolBar").jqxToolBar("getTools").length
    //     if (_tmptoolsCount > itemCount)
    //     {
    //         for (var index = _tmptoolsCount; index > itemCount; index--)
    //         {
    //             $("#jqxToolBar").jqxToolBar("destroyTool", index - 1);
    //         }
            
    //     }

    //     var args = event.args;
    //     if (args) {
    //         var label = args.item.label;
    //         //獲得資料
    //         var o = $("#dg");
    //         var lastSearchData = o.jqGrid('getGridParam', 'lastSelected'); //獲得最後一次搜尋的資料    
    //         var getData = o.jqGrid('getGridParam', 'data');
    //         var dataLo = (lastSearchData == null)? getData: lastSearchData; 

    //         var dataToChartX = [];

    //         for (var key in dataLo)
    //         {
    //             for (var p in dataLo[key])
    //             {
    //                 if (p == label)
    //                 {
    //                     dataToChartX.push(dataLo[key][p]); 
    //                 }      
    //             }     
    //         }

    //         //刪除重複元素
    //         _dataSource = dataToChartX.filter(function (el, i, arr) {
    //                 return arr.indexOf(el) === i;
    //         });
            
    //         var position = "last";
    //         $("#jqxToolBar").jqxToolBar("addTool", "dropdownlist", position, false, function (type, tool, menuToolIninitialization) 
    //         {
    //             var width;
    //             if (menuToolIninitialization) {
    //                 // specific setting for minimized tool
    //                 width = "100%";
    //             } else {
    //                 width = 50;
    //             }
    //             //tool.jqxComboBox({ width: 130, source: _dataSource, selectedIndex: 0 });
    //             tool.jqxDropDownList({ width: 130, source: _dataSource, selectedIndex: -1 });

    //             tool.on("change", function (event) {          
    //             var args = event.args;
    //                 if (args) {
    //                     var position = "last";
    //                     $("#jqxToolBar").jqxToolBar("addTool", "toggleButton", position, false, function (type, tool, menuToolIninitialization) {          
    //                         var width;
    //                         if (menuToolIninitialization) {
    //                         // specific setting for minimized tool
    //                             width = "100%";
    //                         } else {
    //                             width = 100;
    //                         }
    //                         var label = args.item.label;
    //                         tool.jqxToggleButton({ width: width, toggled: false });
    //                         tool.text(label);
    //                         tool.on("click", function () 
    //                         {
    //                             var toolsCount = $("#jqxToolBar").jqxToolBar("getTools").length - 1;
    //                             var toggled = tool.jqxToggleButton("toggled");
    //                             if (toggled) {
    //                                 $("#jqxToolBar").jqxToolBar("destroyTool", toolsCount );
    //                             } 
    //                         });    
    //                     });                                 
    //                 }
    //             });
    //         });                        
    //     }
    // });
    
    //toolbar 尋找toolbar上的item
    //把不屬於X axis, Y axis, Group的這些toggle文字記錄下來, 因這是代表組別
            // for (var key in tools)
            // {
            //     for (var p in tools[key])
            //     {  
            //         if (p == "type" && tools[key][p] == "input")
            //         {                   
            //             dataGroup.push(tools[key].tool[0].value);       
            //         }          
                
            //     }
            // }
    
      // $(document).ready(function () {
    //     var _ChartTypeSource = ["Scatter Chart", "Control Chart"];
    //     var _xAxisSource = ["sampling_date", "次數"];
    //     var _yAxisSource = ["MeO", "Assay", "HC", "Si", "Sn", "Al", "I", "Fe", "Zn", "Ag", "As", "Au", "B", "Ba",
    //                         "Be", "Bi", "Ca", "Cd", "Ce", "Co", "Cr", "Cs", "Cu", "Ga", "Ge", "Hg", "In", "K",
    //                         "La", "Li", "Mg", "Mn", "Mo", "Na", "Nb", "Ni", "P", "Pb", "Pd", "Pt", "Rb", "Re", "Rh", 
    //                         "Ru", "S", "Sb", "Se", "Sr", "Ta", "Tb", "Te", "Th", "Ti", "Tl", "U", "V", "W", "Y", "Zr", 
    //                         "F", "Cl", "Parameter_A", "Parameter_B", "Parameter_C", "Parameter_D", "Impurity_A","Impurity_B", 
    //                         "Impurity_C", "Impurity_D", "Impurity_E", "Impurity_F", "1H_NMR", "Other_Metals", "Organic_impurity",
    //                         "2_2ppm", "3_8ppm", "4_0ppm", "Sum223840"
    //                     ];
    //     var _GroupSource = ["product_name","level", "bottle_number","batch_number", "sampler", "sample_source", 
    //         "analytical_item","analyst","determination", "remarks", 
    //         "MeO", "Assay", "HC", "Si", "Sn", "Al", "I", "Fe", "Zn", "Ag", "As", "Au", "B", "Ba",
    //         "Be", "Bi", "Ca", "Cd", "Ce", "Co", "Cr", "Cs", "Cu", "Ga", "Ge", "Hg", "In", "K",
    //         "La", "Li", "Mg", "Mn", "Mo", "Na", "Nb", "Ni", "P", "Pb", "Pd", "Pt", "Rb", "Re", "Rh", 
    //         "Ru", "S", "Sb", "Se", "Sr", "Ta", "Tb", "Te", "Th", "Ti", "Tl", "U", "V", "W", "Y", "Zr", 
    //         "F", "Cl", "Parameter_A", "Parameter_B", "Parameter_C", "Parameter_D", "Impurity_A","Impurity_B", 
    //         "Impurity_C", "Impurity_D", "Impurity_E", "Impurity_F", "1H_NMR", "Other_Metals", "Organic_impurity",
    //         "2_2ppm", "3_8ppm", "4_0ppm", "Sum223840"
    //     ];
    //     // var _groupSource = ["product_name",  "level", "analytical_item"];
    //     var _dataSource = [];  //用來保存
    //     // var itemCount = 7; // The item count of Toolbar.

    //     $("#jqxToolBar").jqxToolBar({ 
    //         width: "80%", height: '35', 
    //         tools: "toggleButton dropdownlist | toggleButton dropdownlist | toggleButton combobox | toggleButton | button  button  ",
    //         //tools: "toggleButton toggleButton toggleButton | dropdownlist combobox | input",
    //         initTools: function (type, index, tool, menuToolIninitialization) 
    //         {
    //             switch (index) 
    //             {
    //                 case 0:
    //                     tool.jqxToggleButton({ width: 80, toggled: true });
    //                     tool.text("Chart:");
    //                     break;
    //                 case 1:
    //                     tool.jqxDropDownList({ width: 120, source: _ChartTypeSource, selectedIndex: -1});
    //                     //tool.jqxComboBox({ width: 130, source: _xAxisSource, selectedIndex: 0 });
    //                     break;  
    //                 case 2:
    //                     tool.jqxToggleButton({ width: 80, toggled: true });
    //                     tool.text("X axis:");
    //                     break;
    //                 case 3:
    //                     tool.jqxDropDownList({ width: 120, source: _xAxisSource, selectedIndex: -1});
    //                     //tool.jqxComboBox({ width: 130, source: _xAxisSource, selectedIndex: 0 });
    //                     break;  
    //                 case 4:
    //                     tool.jqxToggleButton({ width: 80, toggled: true });
    //                     tool.text("Y axis:");
    //                     break;                 
    //                 case 5:
    //                     //     tool.jqxDropDownList({ width: 130, source: _yAxisSource, selectedIndex:  -1});
    //                     tool.jqxComboBox({ width: 120, source: _yAxisSource, selectedIndex: -1, searchMode: 'containsignorecase', autoComplete: true });
    //                     break;
    //                 case 6:
    //                     tool.jqxToggleButton({ width: 80, toggled: true });
    //                     tool.text("Group:");
    //                     break;
    //                 // case 7:
    //                 //     //     tool.jqxDropDownList({ width: 130, source: _yAxisSource, selectedIndex:  -1});
    //                 //     tool.jqxComboBox({ width: 120, source: _GroupSource, selectedIndex: -1, searchMode: 'containsignorecase', autoComplete: true });
    //                 //     break;
    //                 // case 8:
    //                 //     tool.jqxInput({ width: 120, placeHolder: "Type here..." })
    //                 //     break;
    //                 case 7:
    //                     tool.text("＋");
    //                     tool.on("click", function (event) {                            
    //                                     var position = "last";

    //                                     $("#jqxToolBar").jqxToolBar("addTool", "combobox", position, false, function (type, tool, menuToolIninitialization) 
    //                                     {
    //                                         var width;
    //                                         if (menuToolIninitialization) {
    //                                             // specific setting for minimized tool
    //                                             width = "100%";
    //                                         } else {
    //                                             width = 120;
    //                                         }
    //                                         tool.jqxComboBox({ width: width, source: _GroupSource, selectedIndex: -1, searchMode: 'containsignorecase', autoComplete: true});
    //                                         //tool.jqxDropDownList({ width: 130, source: _dataSource, selectedIndex: -1 });
    //                                     });

    //                                     $("#jqxToolBar").jqxToolBar("addTool", "input", position, false, function (type, tool, menuToolIninitialization) 
    //                                     {          
    //                                         var width;
    //                                         if (menuToolIninitialization) {
    //                                             // specific setting for minimized tool
    //                                             width = "100%";
    //                                         } else {
    //                                             width = 120;
    //                                         }
                                            
    //                                         tool.jqxInput({ width: width, placeHolder: "Type here..." })
    
    //                                     });                                 
                                        
    //                                 });
    //                     break;
    //                 case 8:
    //                     tool.text("－");
    //                     tool.on("click", function (event) 
    //                         {                            
    //                             var position = "last";
    //                             var toolsCount = $("#jqxToolBar").jqxToolBar("getTools").length - 1;
    //                             if (toolsCount > 9)
    //                             {
    //                                 $("#jqxToolBar").jqxToolBar("destroyTool", toolsCount );
    //                             }             
    //                         });                    
    //                     break;           
    //             }
    //         }
    //     });

    //     $("#jqxToolBarConChart").jqxToolBar({ 
    //         width: "80%", height: '35', 
    //         tools: "toggleButton input | toggleButton input | toggleButton input | toggleButton input ",
    //         //tools: "toggleButton toggleButton toggleButton | dropdownlist combobox | input",
    //         initTools: function (type, index, tool, menuToolIninitialization) 
    //         {
    //             switch (index) 
    //             {
    //                 case 0:
    //                     tool.jqxToggleButton({ width: 80, toggled: true });
    //                     tool.text("USL:");
    //                     break;
    //                 case 1:
    //                     tool.jqxInput({ width: 120, placeHolder: "Type here..." })
    //                     break;  
    //                 case 2:
    //                     tool.jqxToggleButton({ width: 80, toggled: true });
    //                     tool.text("LSL:");
    //                     break;
    //                 case 3:
    //                     tool.jqxInput({ width: 120, placeHolder: "Type here..." })
    //                     break;
    //                 case 4:
    //                     tool.jqxToggleButton({ width: 80, toggled: true });
    //                     tool.text("UCL:");
    //                     break;
    //                 case 5:
    //                     tool.jqxInput({ width: 120, placeHolder: "Type here..." })
    //                     break;
    //                 case 6:
    //                     tool.jqxToggleButton({ width: 80, toggled: true });
    //                     tool.text("LCL:");
    //                     break;
    //                 case 7:
    //                     tool.jqxInput({ width: 120, placeHolder: "Type here..." })
    //                     break;  
    //             }
    //         }
    //     });

    // });
</script>