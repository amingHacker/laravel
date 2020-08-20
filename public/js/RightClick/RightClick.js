/*Show Right Click Information*/
function showRightClick(rowid, e){
        
    var _rightClickID = [];
    _rightClickID.push(rowid);

    sessionStorage.setItem('RightClickID', rowid);

    e.preventDefault();
    var menuleft = e.pageX;
    var menutop = e.pageY;

    var $menu = $('#RightClickmenu');
    $menu.css({left:menuleft, top: menutop});
    $menu.show();    
}

function handleClickMouseDown(e)
{
    var $menu = $('#RightClickmenu');
    $menu.hide();
}

function showSelectSPEC()
{
    var $menu = $('#RightClickmenu');
    $menu.hide();
    var rowID = sessionStorage.getItem('RightClickID');
    var item_data = [];
    item_data.push(rowID);
      
    $.ajax({
        async:false,
        url: "SamplingRecord/GetDataFromID" ,//路徑
        type: "POST",           
        data:{
            "postData": item_data,
        },
        success: function (DownLoadValue){
            var data = DownLoadValue.success;
            sessionStorage.setItem('CustomerItem' , JSON.stringify(DownLoadValue.success));
            
            //產生要寫入excel的data
            var table = "import_preview";
            var pcontent = '<span style="font-weight:bold; color:#2e6e9e;">《 產品規格 ProductSPEC 》</span><br /><br />'
            + '<div id="jqxcombobox_SPEC" ></div>' 
            + '<div id="jqxToolBar_SPEC" style = margin:0px auto; text-align:justify ></div>'
            + '</br>'
            + '<table id= "ProductSPEC"></table>'
            + '<div id= "ProductSPECPager"></div>'
            + '</br>'
            + '<table id= '+ table + '></table>'
            + '</br></br>';
           
           
            
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
                caption: "產品 Product", 
                loadComplete: function (){ fixPositionsOfFrozenDivs.call(this); }, // Fix column's height are different after enable frozen column feature 
                gridComplete: function() { $("#" + table).jqGrid('setFrozenColumns');}
            });
               
            $("#confirmDialog").dialog({
                width:'auto', height:'auto', autoResize:true, modal:false, closeText:"關閉", 
                resizable:true, closeOnEscape:true, dialogClass:'top-dialog',position:['center',168],
                show:{effect: "fade", duration: 140},
                hide:{effect: "clip", duration: 140},
                focus: function() { $(".ui-dialog").focus(); }, // Unfocus the default focus elem
                buttons : {
                    "關閉" : function() {
                        $(this).dialog("close");
                                                                        
                    },
            
                }
            });
            
            var source_TMAL = [
                "TMAL",
                "TMALEG",
                "TMALTW",
                "TMALUM",
                    ];
            var source_CCTBA = [
                "CCTBA",
                "CCTBA-447FN-200G",
            ];
            var source_ALEXA = [
                "ALEXA",
                "ALEXA-447FN",
            ];
            var dictionary ={
                "TMALEG": "TMAL_EG",
                "TMALTW": "TMAL_TW",
                "TMALUM": "TMAL_UM",
                "TMAL": "TMAL",
                "CCTBA":"CCTBA",
                "CCTBA-447FN-200G":"CCTBA_447FN_200G",
                "ALEXA":"ALEXA",
                "ALEXA-447FN": "ALEXA_447FN"
            };

            var sourceSPEC;
            switch (data[0]["product_name"])
            {
                case "TMAL":
                    sourceSPEC = source_TMAL;
                    break;
                case "CCTBA":
                    sourceSPEC = source_CCTBA;
                    break;
                case "ALEXA":
                    sourceSPEC = source_ALEXA;
                    break;
            }

            $("#jqxcombobox_SPEC").jqxComboBox({ source: sourceSPEC, selectedIndex: -1, width: '200px', height: '25' });
        
            $('#jqxcombobox_SPEC').bind('select', function (event) {
                var args = event.args;
                var item = $('#jqxcombobox_SPEC').jqxComboBox('getItem', args.index);
                ShowTableDynamic(dictionary[item.label]);  
            });  
        }                                   
    });  
}


function ShowTableDynamic(label)
{
    var _todoP = label;
    $.ajax({
        async:false,
        url:"ProductSPEC/GetTable/"+_todoP,
        type: "GET",           
        data:{
            //"postData": item_data,
        },
        success: function (DownLoadValue){
            var data = DownLoadValue.product_SPEC[0];
            var source = [];
            for( var i in data )
            {       
                if ( i != "ELEMENT" && i != "id" && i != "created_at" && i != "updated_at")
                {
                    source.push(i);
                }
            }
            sessionStorage.setItem('CustomerSPEC' , JSON.stringify(DownLoadValue.product_SPEC));
            CreateToolBar(source);
        }                                   
    });  
}

function CreateToolBar(source)
{
    $("#jqxToolBar_SPEC").jqxToolBar("destroyTool", 1 );
    $("#jqxToolBar_SPEC").jqxToolBar('render');

    $("#jqxToolBar_SPEC").jqxToolBar({ 
        width: "400", height: '35', 
        tools: "toggleButton",
       
        initTools: function (type, index, tool, menuToolIninitialization) 
        {
            switch (index) 
            {
                case 0:
                    tool.jqxToggleButton({ width: 80, toggled: true });
                    tool.text("Customer:");
                    break;
            }
        }
    });

    var position = "last";

    $("#jqxToolBar_SPEC").jqxToolBar("addTool", "combobox", position, false, function (type, tool, menuToolIninitialization) 
    {
        var width;
        if (menuToolIninitialization) {
            // specific setting for minimized tool
            width = "100%";
        } else {
            width = 200;
        }
        tool.jqxComboBox({ width: width, source: source, selectedIndex: -1, searchMode: 'containsignorecase', autoComplete: true});
        tool.on("change", function (event) {          
            var args = event.args;
                if (args) {
                    var label = args.item["label"]
                    var data =  JSON.parse(sessionStorage.getItem('CustomerSPEC'));
                    var _compare = [] ;  //獲得SPEC資料
                    for(var i in data)
                    {
                        var tmp = {
                            ELEMENT : data[i]["ELEMENT"],
                            SPEC : data[i][label],
                        }
                        _compare.push (tmp)

                    }

                    CompareItemWithSPEC(_compare);
                }
            });
    
    });
}

function CompareItemWithSPEC(_compare) 
{
    sessionStorage.setItem('_CompareSource', JSON.stringify(_compare));
    var data =  JSON.parse(sessionStorage.getItem('CustomerItem'));
    var table = "import_preview";
    var colNames = [];
    var colModel = [];
    
    $("#import_preview").jqGrid('GridUnload');
    $("#ProductSPEC").jqGrid('GridUnload'); 

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
            colModel.push({name:colName, index:colName, align:"center", width:112, cellattr: compareCellAttr});
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
        caption: "產品 Product", 
        loadComplete: function (){ fixPositionsOfFrozenDivs.call(this); }, // Fix column's height are different after enable frozen column feature 
        gridComplete: function() { $("#" + table).jqGrid('setFrozenColumns');}
    });

    var LineData = [];
    var LineKey = [];
    var LineValue = [];
    var json = { };
    for(var tmp in _compare)
    {
        LineKey.push(_compare[tmp]["ELEMENT"]);
        LineValue.push(_compare[tmp]["SPEC"]);
    }
    for(var i = 0, l = LineKey.length; i < l; i++) {
        json[LineKey[i]] = LineValue[i];
    }

    LineData.push(json);

    var colNamesSPEC = [];
    var colModelSPEC = [];
    for ( var colName in  LineData[0])
    {
        colNamesSPEC.push(getColumnNameFromDatabaseToChinese(colName));
    }

    for ( var colName in  LineData[0])
    {           
        if (colName === 'id')
        {
            colModelSPEC.push({name:colName, index:colName, align:"center", width:84, frozen:false, sortable:true, sorttype:"int"});
        }
        else
        {
            colModelSPEC.push({name:colName, index:colName, align:"center", width:112});
        }
    }
    
    $("#ProductSPEC").jqGrid({      
        datatype: "local",
        data: LineData,
        colNames: colNamesSPEC,
        colModel: colModelSPEC,
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
        pager:'#ProductSPECPager',
        caption: "客戶 SPEC", 
        loadComplete: function (){ fixPositionsOfFrozenDivs.call(this); }, // Fix column's height are different after enable frozen column feature 
        gridComplete: function() { $("#" + table).jqGrid('setFrozenColumns');}
    });

    
}

function compareCellAttr(rowId, val, rawObject, cm, rdata)
{
    var data = JSON.parse(sessionStorage.getItem('_CompareSource'));
    var product = '';
    var product_level = '';
    var cloumnName = getColumnNameFromDatabaseToChinese(cm["name"]);
    var sty = "style='font-size:14px'";

    var value = val.split("<");
            
    val = value[value.length - 1];
   
    for(var j in data)
    {
        var _productS = data[j]["SPEC"];
        if ( data[j]["ELEMENT"] == cloumnName &&  (parseFloat(_productS) <  parseFloat(val)) && _productS != '-')
        {
            sty = "style='font-size:14px; background-color:#9dbcfa'" ;
        }
    }

    return sty;

}
