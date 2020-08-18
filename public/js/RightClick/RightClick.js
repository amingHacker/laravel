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
    
            //產生要寫入excel的data
            var table = "import_preview";
            var pcontent = '<span style="font-weight:bold; color:#2e6e9e;">《 產品規格 ProductSPEC 》</span><br /><br />'
            + '<div id="jqxcombobox_SPEC" ></div>' 
            + '<div id="jqxToolBar_SPEC" style = margin:0px auto; text-align:justify ></div>'
            + '<table id= '+ table + '></table>';
           
                
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
                alert('Selected: ' + item.label);
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
            CreateToolBar(source)
        }                                   
    });  
}

function CreateToolBar(source)
{
    $("#jqxToolBar_SPEC").jqxToolBar("destroyTool", 2 );
    $("#jqxToolBar_SPEC").jqxToolBar('render');

    $("#jqxToolBar_SPEC").jqxToolBar({ 
        width: "400", height: '35', 
        tools: "toggleButton dropdownlist ",
       
        initTools: function (type, index, tool, menuToolIninitialization) 
        {
            switch (index) 
            {
                case 0:
                    tool.jqxToggleButton({ width: 80, toggled: true });
                    tool.text("Customer:");
                    break;
                case 1:
                    tool.jqxDropDownList({ width: 200, source: source, selectedIndex: -1});
                    //tool.jqxComboBox({ width: 130, source: _xAxisSource, selectedIndex: 0 });
                    break;  
            }
        }
    });
}
