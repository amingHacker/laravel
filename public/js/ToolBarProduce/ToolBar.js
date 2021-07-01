/*
@author Aming
@version 20200807
@aim Check Data to Chart
*/
//$(document).ready(
function PrepareToToolbar(_ChartTypeSource, _xAxisSource, _yAxisSource, _GroupSource, SPCSource) {
    $("#tabs").tabs();
    createToolbar(1, _ChartTypeSource, _xAxisSource, _yAxisSource, _GroupSource, SPCSource);
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
                + "<h1 class ='my-1'></h1>"
                + "<div id='jqxToolBarChartRange" + num_tabs + "' style = 'margin:0px auto; text-align:justify' ></div>"
                + "</div>");
            createToolbar(num_tabs, _ChartTypeSource, _xAxisSource, _yAxisSource, _GroupSource);
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
}


function createToolbar(num_tabs, _ChartTypeSource, _xAxisSource, _yAxisSource, _GroupSource, _spcSource){
 
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
                    tool.jqxDropDownList({ width: 120, source: _xAxisSource, 
                        selectedIndex: -1,
                    });
                    //tool.jqxComboBox({ width: 130, source: _xAxisSource, selectedIndex: 0 });
                    break;  
                case 4:
                    tool.jqxToggleButton({ width: 80, toggled: true });
                    tool.text("Y axis:");
                    break;                 
                case 5:
                    //tool.jqxDropDownList({ width: 130, source: _yAxisSource, selectedIndex:  -1});
                    tool.jqxComboBox({ 
                        width: 120, source: _yAxisSource, selectedIndex: -1, 
                        searchMode: 'containsignorecase', autoComplete: true,
                    });
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

    $("#jqxToolBarChartRange" + num_tabs).jqxToolBar({ 
        width: "1000", height: '35', 
        // tools: "toggleButton input | toggleButton input",
        tools: "toggleButton input | toggleButton input | toggleButton dropdownlist",
        initTools: function (type, index, tool, menuToolIninitialization) 
        {
            switch (index) 
            {
                case 0:
                    tool.jqxToggleButton({ width: 80, toggled: true });
                    tool.text("Y軸Max:");
                    break;
                case 1:
                    tool.jqxInput({ width: 120, placeHolder: "Type here..." })
                    break;  
                case 2:
                    tool.jqxToggleButton({ width: 80, toggled: true });
                    tool.text("Y軸Min:");
                    break;
                case 3:
                    tool.jqxInput({ width: 120, placeHolder: "Type here..." })
                    break;
                case 4:
                    tool.jqxToggleButton({ width: 80, toggled: true });
                    tool.text("SPC規則:");
                    break;
                case 5:           
                    if (menuToolIninitialization === false) {
                        ddlistjobtype = tool;
                        } else {
                        ddlistjobtypeMin = tool;
                        }
                        jobtype_source = _spcSource;
                        // jobtype_source = ['A1.超過3個標準差', 'A2.連續九點在中線同一側', 'A3.連續六點呈現上升或下降',
                        //     'A4.連續三點中的兩點落在2個標準差之外', 'A5.連續五點中的四點落在1個標準差之外',
                        //     'B1.中位數偏移', 'B2.標準差偏移',
                        // ];
                        tool.jqxDropDownList({ width: 205, source: jobtype_source, checkboxes:true });
                        tool.jqxDropDownList( 'checkItem', 'A1.超過3個標準差' );
                       
                        break;
                   
                    break;
            }
        }
    });
}

function addToolbar(toolbarName, type, index, source, separator, selectedIndex){
    switch(type)
    {
        case "dropdownlist":
            $("#" + toolbarName).jqxToolBar("addTool", "dropdownlist", index, separator, 
                function (type, tool, menuToolIninitialization) {          
                {
                    var width;
                    if (menuToolIninitialization) {
                        // specific setting for minimized tool
                        width = "100%";
                    } else {
                        width = 120;
                    }
                    tool.jqxDropDownList({ width: 205, source: source, selectedIndex: selectedIndex, searchMode: 'containsignorecase',checkboxes:true });
                    
                    //tool.jqxComboBox({ width: width, source: source, selectedIndex: -1, searchMode: 'containsignorecase', autoComplete: true});
                }    
            });            
            break;

        case "combobox":
            $("#" + toolbarName).jqxToolBar("addTool", "combobox", index, separator, 
                function (type, tool, menuToolIninitialization) {          
                {
                    var width;
                    if (menuToolIninitialization) {
                        // specific setting for minimized tool
                        width = "100%";
                    } else {
                        width = 120;
                    }
                    tool.jqxComboBox({ width: width, source: source, selectedIndex: -1, searchMode: 'containsignorecase', autoComplete: true});
                }    
            });            
            break;
        case "toggle":
            $("#" + toolbarName).jqxToolBar("addTool", "toggleButton", index, separator, 
                function (type, tool, menuToolIninitialization) {          
                {
                    var width;
                    if (menuToolIninitialization) {
                        // specific setting for minimized tool
                        width = "100%";
                    } else {
                        width = 80;
                    }
                    tool.jqxToggleButton({ width: width, toggled: true });
                    tool.text(source);
                }    
            });            
            break;
        case "input":
            $("#" + toolbarName ).jqxToolBar("addTool", "input", index, separator, 
                function (type, tool, menuToolIninitialization) {          
                {
                    var width;
                    if (menuToolIninitialization) {
                        // specific setting for minimized tool
                        width = "100%";
                    } else {
                        width = 120;
                    }
                    tool.jqxInput({ width: 120, placeHolder: "Type here..." })
                }    
            });            
            break;
    }
}

function destoryToolbar( toolbarName, index) 
{
    $("#" + toolbarName).jqxToolBar("destroyTool", index);     
}


//*產生Bar Chart toolbar
//*Using in Inventory

function PrepareToInventoryToolbar(_todoP, _ChartTypeSource, _xAxisSource, _yAxisSource, _GroupSource, 
        item_Material, item_Storage_Location, item_Descr_of_Storage_Loc, item_Batch,
        item_Name_of_sold_to_party, item_Name_of_the_ship_to_party, item_Description, item_Sold_to_party, item_Ship_to_party,
        item_Ship_Batch, item_Ship_Material, item_Item_category, item_Ship_Storage_Location
    ) 
{
    $("#tabs").tabs();
    createInventoryInstockToolbar(_todoP, 1, _ChartTypeSource, _xAxisSource, _yAxisSource, _GroupSource, 
            item_Material, item_Storage_Location, item_Descr_of_Storage_Loc, item_Batch,
            item_Name_of_sold_to_party, item_Name_of_the_ship_to_party, item_Description, item_Sold_to_party, item_Ship_to_party,
            item_Ship_Batch, item_Ship_Material, item_Item_category, item_Ship_Storage_Location
        );
    createInventoryShipmentToolbar(_todoP, 1, _ChartTypeSource, _xAxisSource, _yAxisSource, _GroupSource, 
            item_Material, item_Storage_Location, item_Descr_of_Storage_Loc, item_Batch,
            item_Name_of_sold_to_party, item_Name_of_the_ship_to_party, item_Description, item_Sold_to_party, item_Ship_to_party,
            item_Ship_Batch, item_Ship_Material, item_Item_category, item_Ship_Storage_Location
        );
    $("button#add-tab").click(
        function() 
        {
            if( getColumnNameFromChineseToDatabase($("#Gridtabs .ui-tabs-active").text()) == "InventoryInstock" && _todoP == "InventoryInstock")
            {    
                var item_Material = sessionStorage.getItem('Material_Description');
                var item_Storage_Location = sessionStorage.getItem('Storage_Location');
                var item_Descr_of_Storage_Loc = sessionStorage.getItem('Descr_of_Storage_Loc');
                var item_Batch = sessionStorage.getItem('Batch');
                var _tmpxAxis = sessionStorage.getItem('_xAxis');
                var _xAxis = _tmpxAxis.split(",");
                var tabs =  $("#tabs").tabs();
                var num_tabs = $("#tabs ul li").length + 1;
                $("#tabs ul").append(
                    "<li><a href='#tab" + num_tabs + "'>Group " + num_tabs + "</a></li>"
                );

                $("#tabs").append("<div id='tab"+ num_tabs+ "' style='background-color:powderblue;'>"
                    + "<span style='font-weight:bold; color:#2e6e9e; display:block; text-align:center'>《 Group " + num_tabs + " 》</span> <br />"       
                    + "<div id='jqxInventoryToolBar" + num_tabs + "' style = 'margin:0px auto; text-align:justify' ></div>" 
                    + "</div>");


                createInventoryInstockToolbar(_todoP, num_tabs, _ChartTypeSource, _xAxis, _yAxisSource, _GroupSource, 
                    item_Material, item_Storage_Location, item_Descr_of_Storage_Loc, item_Batch, 
                    item_Name_of_sold_to_party, item_Name_of_the_ship_to_party, item_Description, item_Sold_to_party, item_Ship_to_party,
                    item_Ship_Batch, item_Ship_Material, item_Item_category, item_Ship_Storage_Location
                    );
            }
           
            if( getColumnNameFromChineseToDatabase($("#Gridtabs .ui-tabs-active").text()) == "InventoryShipment" && _todoP == "InventoryShipment")
            {

                combobox_items = getComboboxItem();

                var item_Name_of_sold_to_party = [];
                var item_Name_of_the_ship_to_party = [];
                var item_Description = [];
                var item_Sold_to_party = [];
                var item_Ship_to_party = [];
                var item_Ship_Batch = [];
                var item_Ship_Material = [];
                var item_Item_category = [];
                var item_Ship_Storage_Location = [];
                
                for (var i in combobox_items)
                {
                    if(i == "Name_of_sold_to_party")
                    {
                        for(var j in combobox_items[i])
                        {
                            item_Name_of_sold_to_party.push(combobox_items[i][j][i]);
                        }
                    }
                    if(i == "Name_of_the_ship_to_party")
                    {
                        for(var j in combobox_items[i])
                        {
                            item_Name_of_the_ship_to_party.push(combobox_items[i][j][i]);
                        }
                    }
                    if(i == "Description")
                    {
                        for(var j in combobox_items[i])
                        {
                            item_Description.push(combobox_items[i][j][i]);
                        }
                    }
                    if(i == "Sold_to_party")
                    {
                        for(var j in combobox_items[i])
                        {
                            item_Sold_to_party.push(combobox_items[i][j][i]);
                        }
                    }
                    if(i == "Ship_to_party")
                    {
                        for(var j in combobox_items[i])
                        {
                            item_Ship_to_party.push(combobox_items[i][j][i]);
                        }
                    }
                    if(i == "Ship_Batch")
                    {
                        for(var j in combobox_items[i])
                        {
                            item_Ship_Batch.push(combobox_items[i][j][i]);
                        }
                    }
                    if(i == "Ship_Material")
                    {
                        for(var j in combobox_items[i])
                        {
                            item_Ship_Material.push(combobox_items[i][j][i]);
                        }
                    }
                    if(i == "Item_category")
                    {
                        for(var j in combobox_items[i])
                        {
                            item_Item_category.push(combobox_items[i][j][i]);
                        }
                    }
                    if(i == "Ship_Storage_Location")
                    {
                        for(var j in combobox_items[i])
                        {
                            item_Ship_Storage_Location.push(combobox_items[i][j][i]);
                        }
                    }
                    
                }
                // var item_Name_of_sold_to_party = sessionStorage.getItem('Name_of_sold_to_party').split(",");
                // var item_Name_of_the_ship_to_party = sessionStorage.getItem('Name_of_the_ship_to_party').split(",");
                // var item_Description = sessionStorage.getItem('Description').split(",");
                // var item_Sold_to_party = sessionStorage.getItem('Sold_to_party').split(",");
                // var item_Ship_to_party = sessionStorage.getItem('Ship_to_party').split(",");
                // var item_Ship_Batch = sessionStorage.getItem('Ship_Batch').split(",");
                // var item_Ship_Material = sessionStorage.getItem('Ship_Material').split(",");
                // var item_Item_category = sessionStorage.getItem('Item_category').split(",");
                // var item_Ship_Storage_Location = sessionStorage.getItem('Ship_Storage_Location').split(",");



                var tabs =  $("#tabs").tabs();
                var num_tabs = $("#tabs ul li").length + 1;
                $("#tabs ul").append(
                    "<li><a href='#tab" + num_tabs + "'>Group " + num_tabs + "</a></li>"
                );

                $("#tabs").append("<div id='tab"+ num_tabs+ "' style='background-color:powderblue;'>"
                    + "<span style='font-weight:bold; color:#2e6e9e; display:block; text-align:center'>《 Group " + num_tabs + " 》</span> <br />"       
                    + "<div id='jqxShipmentToolBar" + num_tabs + "' style = 'margin:0px auto; text-align:justify' ></div>" 
                    + "</div>");


                createInventoryShipmentToolbar(_todoP, num_tabs, _ChartTypeSource, _xAxis, _yAxisSource, _GroupSource, 
                    item_Material, item_Storage_Location, item_Descr_of_Storage_Loc, item_Batch, 
                    item_Name_of_sold_to_party, item_Name_of_the_ship_to_party, item_Description, item_Sold_to_party, item_Ship_to_party,
                    item_Ship_Batch, item_Ship_Material, item_Item_category, item_Ship_Storage_Location
                    );
            }
            
            $("#tabs").tabs("refresh");
        }
    );
    
    $("button#remove-tab").click(
        function() 
        {
            if( getColumnNameFromChineseToDatabase($("#Gridtabs .ui-tabs-active").text()) == "InventoryInstock" && _todoP == "InventoryInstock")
            {
                var tabs =  $("#tabs").tabs();
                var num_tabs = $("#tabs ul li").length;
    
                $('#tabs').tabs('remove', num_tabs - 1);
    
                $("#tabs").tabs("refresh");
            }
            if( getColumnNameFromChineseToDatabase($("#Gridtabs .ui-tabs-active").text()) == "InventoryShipment" && _todoP == "InventoryShipment")
            {
                var tabs =  $("#tabs").tabs();
                var num_tabs = $("#tabs ul li").length;
    
                $('#tabs').tabs('remove', num_tabs - 1);
    
                $("#tabs").tabs("refresh");
            }
           
        }
    );               
}


function createInventoryInstockToolbar(_todoP, num_tabs, _ChartTypeSource, _xAxisSource, _yAxisSource, _GroupSource, 
    item_Material, item_Storage_Location, item_Descr_of_Storage_Loc, item_Batch,
    item_Name_of_sold_to_party, item_Name_of_the_ship_to_party, item_Description, item_Sold_to_party, item_Ship_to_party,
    item_Ship_Batch, item_Ship_Material, item_Item_category, item_Ship_Storage_Location
    )
{ 
    if (_todoP == "InventoryShipment"){return;}
    var _dataSource = [];  //用來保存
    // var itemCount = 7; // The item count of Toolbar.
    // 產生Material值、儲存位置、儲位名稱、批號

    $("#jqxInventoryToolBar" + num_tabs).jqxToolBar({ 
        width: "1000", height: '35', 
        tools: "toggleButton dropdownlist | toggleButton dropdownlist | toggleButton dropdownlist input  ",
        
        initTools: function (type, index, tool, menuToolIninitialization) 
        {
            switch (index) 
            {
                
                case 0:
                    tool.jqxToggleButton({ width: 80, toggled: true });
                    tool.text("X axis:");
                    break;

                case 1:
                    tool.jqxDropDownList({ width: 205, source: _xAxisSource, selectedIndex: -1, searchMode: 'containsignorecase',checkboxes:true });
                    //tool.jqxComboBox({ width: width, source: source, selectedIndex: -1, searchMode: 'containsignorecase', autoComplete: true});
                
                    break;  
                    
                case 2:
                    tool.jqxToggleButton({ width: 80, toggled: true });
                    tool.text("Y axis:");
                    break;                 
                case 3:
                    tool.jqxDropDownList({ width: 205, source: _yAxisSource, selectedIndex:  -1, searchMode: 'containsignorecase', checkboxes:true});
                    // tool.jqxComboBox({ 
                    //     width: 120, source: _yAxisSource, selectedIndex: -1, 
                    //     searchMode: 'containsignorecase', autoComplete: true,
                    // });
                    break;
                case 4:
                    tool.jqxToggleButton({ width: 80, toggled: true });
                    tool.text("Column:");
                    break;                    
                case 5:    
                    tool.jqxComboBox({ width: 120, source:_GroupSource, selectedIndex: -1, searchMode: 'containsignorecase', autoComplete: true });
                    
                    break;
                case 6:
                    tool.jqxInput({ width: 120, placeHolder: "Type here..." });
                    
                    break;      
            }
        }
    });
     
}

function createInventoryShipmentToolbar(_todoP, num_tabs, _ChartTypeSource, _xAxisSource, _yAxisSource, _GroupSource, 
    item_Material, item_Storage_Location, item_Descr_of_Storage_Loc, item_Batch,
    item_Name_of_sold_to_party, item_Name_of_the_ship_to_party, item_Description, item_Sold_to_party, item_Ship_to_party,
    item_Ship_Batch, item_Ship_Material, item_Item_category, item_Ship_Storage_Location
    )
{ 
    if (_todoP == "InventoryInstock"){return;}
    var _dataSource = [];  //用來保存
    // var itemCount = 7; // The item count of Toolbar.
    // 產生Material值、儲存位置、儲位名稱、批號

    $("#jqxShipmentToolBar" + num_tabs).jqxToolBar({ 
        width: "1000", height: '35', 
        tools: "toggleButton dropdownlist combobox | toggleButton dropdownlist  ",
        
        initTools: function (type, index, tool, menuToolIninitialization) 
        {
            switch (index) 
            {
                
                case 0:
                    tool.jqxToggleButton({ width: 80, toggled: true });
                    tool.text("X axis:");
                    break;
                    
                case 1:
                    var _source = ["Name_of_sold_to_party", "Name_of_the_ship_to_party", "Description", "Sold_to_party",
                        "Ship_to_party", "Ship_Batch", "Ship_Material", "Item_category"
                    ]
                    tool.jqxDropDownList({ width: 200, source: _source, selectedIndex: -1, searchMode: 'containsignorecase',checkboxes:false });
                    //tool.jqxComboBox({ width: width, source: source, selectedIndex: -1, searchMode: 'containsignorecase', autoComplete: true});
                    tool.on('change', function (event) {
                            var args = event.args;
                            if (args) {
                                // index represents the item's index.                          
                                var item = args.item;
                                
                                // get item's label and value.
                                var label = item.label;
                                var dynamicSource = [];
                                switch(label){
                                    case "Name_of_sold_to_party":
                                        dynamicSource = item_Name_of_sold_to_party;
                                        break;
                                    case "Name_of_the_ship_to_party":
                                        dynamicSource = item_Name_of_the_ship_to_party;
                                        break;
                                    case "Description":
                                        dynamicSource = item_Description;
                                        break;
                                    case "Sold_to_party":
                                        dynamicSource = item_Sold_to_party;
                                        break;
                                    case "Ship_to_party":
                                        dynamicSource = item_Ship_to_party;
                                        break;
                                    case "Ship_Batch":
                                        dynamicSource = item_Ship_Batch;
                                        break;
                                    case "Ship_Material":
                                        dynamicSource = item_Ship_Material;
                                        break;
                                    case "Item_category":
                                        dynamicSource = item_Item_category;
                                        break;    
                                }
                                
                                
                                var _tmpToolbar = $("#jqxShipmentToolBar" + num_tabs).jqxToolBar("getTools");
                                $(_tmpToolbar[2].tool[0]).jqxComboBox(
                                    {
                                        source:dynamicSource
                                    }
                                )
                            }
                        }
                    )
                    break;  
                case 2:
                    tool.jqxComboBox({ width: 250, source: item_Name_of_sold_to_party, selectedIndex: -1, searchMode: 'containsignorecase',autoComplete: true });
                    //tool.jqxComboBox({ width: width, source: source, selectedIndex: -1, searchMode: 'containsignorecase', autoComplete: true});
                
                    break;  
                    
                case 3:
                    tool.jqxToggleButton({ width: 80, toggled: true });
                    tool.text("Y axis:");
                    break;                 
                case 4:
                    tool.jqxDropDownList({ width: 150, source: _yAxisSource, selectedIndex:  -1, searchMode: 'containsignorecase', checkboxes:true});
                    // tool.jqxComboBox({ 
                    //     width: 120, source: _yAxisSource, selectedIndex: -1, 
                    //     searchMode: 'containsignorecase', autoComplete: true,
                    // });
                    break;    
            }
        }
    });
     
    
}


