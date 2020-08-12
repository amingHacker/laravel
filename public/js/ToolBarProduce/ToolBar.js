/*
@author Aming
@version 20200807
@aim Check Data to Chart
*/

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
            $("#jqxToolBar" + num_tabs).jqxToolBar('render');

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
    var _xAxisSource = ["sampling_date", "次數", "批號"];
    var _yAxisSource = ["MeO", "Assay", "HC", "Si", "Sn", "Al", "I", "Fe", "Zn", "Ag", "As", "Au", "B", "Ba",
                        "Be", "Bi", "Ca", "Cd", "Ce", "Co", "Cr", "Cs", "Cu", "Ga", "Ge", "Hg", "In", "K",
                        "La", "Li", "Mg", "Mn", "Mo", "Na", "Nb", "Ni", "P", "Pb", "Pd", "Pt", "Rb", "Re", "Rh", 
                        "Ru", "S", "Sb", "Se", "Sr", "Ta", "Tb", "Te", "Th", "Ti", "Tl", "U", "V", "W", "Y", "Zr", 
                        "F", "Cl", "Parameter A", "Parameter B", "Parameter C", "Parameter D", "Impurity A","Impurity B", 
                        "Impurity C", "Impurity D", "Impurity E", "Impurity F", "1H NMR", "Other Metals", "Organic impurity",
                        "[δ2.2ppm]", "[δ3.8ppm]", "[δ4.0ppm]", "Sum[2.2+3.8+4.0]"
                    ];
    var _GroupSource = ["品名","等級", "瓶號","批號", "取樣者", "樣品來源", 
        "分析項目","分析者", "完成日","判定", "備註", 
        "MeO", "Assay", "HC", "Si", "Sn", "Al", "I", "Fe", "Zn", "Ag", "As", "Au", "B", "Ba",
        "Be", "Bi", "Ca", "Cd", "Ce", "Co", "Cr", "Cs", "Cu", "Ga", "Ge", "Hg", "In", "K",
        "La", "Li", "Mg", "Mn", "Mo", "Na", "Nb", "Ni", "P", "Pb", "Pd", "Pt", "Rb", "Re", "Rh", 
        "Ru", "S", "Sb", "Se", "Sr", "Ta", "Tb", "Te", "Th", "Ti", "Tl", "U", "V", "W", "Y", "Zr", 
        "F", "Cl", "Parameter A", "Parameter B", "Parameter C", "Parameter D", "Impurity A","Impurity B", 
        "Impurity C", "Impurity D", "Impurity E", "Impurity F", "1H NMR", "Other Metals", "Organic impurity",
        "[δ2.2ppm]", "[δ3.8ppm]", "[δ4.0ppm]", "Sum[2.2+3.8+4.0]"
    ];



    var _dataSource = [];  //用來保存
    // var itemCount = 7; // The item count of Toolbar.
    $("#jqxToolBar" + num_tabs).jqxToolBar({ 
        width: "1000", height: '35', 
        tools: "toggleButton dropdownlist | toggleButton dropdownlist | toggleButton combobox | toggleButton combobox input  ",
       
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
                    tool.text("Column:");
                    break;                    
                case 7:    
                    tool.jqxComboBox({ width: 120, source:_GroupSource, selectedIndex: -1, searchMode: 'containsignorecase', autoComplete: true });
                    
                    break;
                case 8:
                    tool.jqxInput({ width: 120, placeHolder: "Type here..." });
                    
                    break;      
            }
        }
    });

    $("#jqxToolBarConChart" + num_tabs).jqxToolBar({ 
        width: "1000", height: '35', 
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