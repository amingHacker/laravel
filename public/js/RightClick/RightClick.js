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
            
            var table = "import_preview";
            var pcontent = '<span style="font-weight:bold; color:#2e6e9e;">《 產品規格 ProductSPEC 》</span><br /><br />'
            + '<div id="jqxcombobox_SPEC" ></div>' 
            + '<div id="jqxToolBar_SPEC" style = margin:0px auto; text-align:justify ></div>'
            + '</br>'
            + '<table id= "ProductSPEC"></table>'
            + '</br>'
            + '<table id= '+ table + '></table>'
            +'</br>'
            + '<div id="judge_result" >判定: </div>' 
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
                caption: "Product", 
                loadComplete: function (){ fixPositionsOfFrozenDivs.call(this); }, // Fix column's height are different after enable frozen column feature 
                gridComplete: function() { $("#" + table).jqGrid('setFrozenColumns');}
            });
               
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
                }
            });

            var sourceSPEC = [
                "TMAL",
                "TMALEG",
                "TMALTW",
                "TMALUM",
                "TMALSH",
                "MO",
                "PDMAT",
                "CCTBA",
                "ALEXA",
                "AGATHOS",  
            ]
            var dictionary ={
                "TMALEG": "TMAL_EG",
                "TMALTW": "TMAL_TW",
                "TMALUM": "TMAL_UM",
                "TMALSH": "TMAL_SH",
                "TMAL": "TMAL",
                "MO":"MO",
                "PDMAT":"PDMAT",
                "CCTBA":"CCTBA",       
                "ALEXA":"ALEXA",
                "AGATHOS":"AGATHOS", 
            };

            $("#jqxcombobox_SPEC").jqxComboBox({ source: sourceSPEC, selectedIndex: -1, width: '200px', height: '25' });
        
            $('#jqxcombobox_SPEC').bind('select', function (event) {
                var args = event.args;
                var item = $('#jqxcombobox_SPEC').jqxComboBox('getItem', args.index);
                ShowTableDynamic(dictionary[item.label], 'true');  
            });  
        }                                   
    });  
}


function ShowTableDynamic(label, IsCompare)
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
            CreateToolBar(source, IsCompare);
        }                                   
    });  
}

function CreateToolBar(source, IsCompare)
{
    sessionStorage.setItem('judgeComment', "");  //清空judgeComment的值
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
            sessionStorage.setItem('judge_result', "");          
            var args = event.args;
                if (args) {
                    sessionStorage.setItem('CustomerSPEC_table_col_name' , args.item["label"]); 
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

                    CompareItemWithSPEC(_compare, label, IsCompare);
                    if (document.getElementById('judge_result') != null)
                    {       
                        if (sessionStorage.getItem('judge_result') == "Fail")
                        {
                            document.getElementById('judge_result').innerText='判定: Fail';
                            document.getElementById('judge_result').style.color='red';            
                        }
                        else
                        {
                            document.getElementById('judge_result').innerText='判定: Pass';
                            document.getElementById('judge_result').style.color='green';               
                        }
                    }
                    
                }
            });
    
    });   
}

function CompareItemWithSPEC(_compare, label, IsCompare) 
{
    sessionStorage.setItem('_CompareSource', JSON.stringify(_compare));
    var data =  JSON.parse(sessionStorage.getItem('CustomerItem'));
   
    $("#ProductSPEC").jqGrid('GridUnload'); 

    if (IsCompare == 'true')
    {
        var table = "import_preview";
        var colNames = [];
        var colModel = [];
        
        $("#import_preview").jqGrid('GridUnload');

        for ( var colName in data[0])
        {
            colNames.push(getColumnNameFromDatabaseToChinese(colName));  //getColumnNameFromDatabaseToChinese  path:SamplingRecord/blade
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
            caption: "Product", 
            loadComplete: function (){ fixPositionsOfFrozenDivs.call(this); }, // Fix column's height are different after enable frozen column feature 
            gridComplete: function() { $("#" + table).jqGrid('setFrozenColumns');}
        });
    }
   

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
        caption: "Customer SPEC" + '(' + label + ')', 
        loadComplete: function (){ fixPositionsOfFrozenDivs.call(this); }, // Fix column's height are different after enable frozen column feature 
        gridComplete: function() { $("#" + table).jqGrid('setFrozenColumns');}
    });

    
}

function compareCellAttr(rowId, val, rawObject, cm, rdata)
{
    var data = JSON.parse(sessionStorage.getItem('_CompareSource'));
    var cloumnName = getColumnNameFromDatabaseToChinese(cm["name"]);  // //getColumnNameFromDatabaseToChinese  path:SamplingRecord/blade
    var sty = "style='font-size:14px'";
    var judgeComment = sessionStorage.getItem('judgeComment');
    var value = val.split("<");
            
    val = value[value.length - 1];
   
    //val Product的值
    for(var j in data)
    {
        var _customerSPEC = data[j]["SPEC"];
        if ( data[j]["ELEMENT"] == cloumnName )
        {
            // Assay, Parameter A, Component A這些值小於SPEC 就是異常
            if (data[j]["ELEMENT"] == 'Assay (Purity)' || data[j]["ELEMENT"] == 'Component A' || data[j]["ELEMENT"] == 'Parameter A' || data[j]["ELEMENT"] == 'Impurity C')
            {
                if (parseFloat(_customerSPEC) >  parseFloat(val))
                {
                    sty = "style='font-size:14px; color:red; background-color:#9dbcfa'" ;
                    sessionStorage.setItem('judge_result', "Fail");
                    judgeComment += data[j]["ELEMENT"] +':' + parseFloat(val) + ',';
                    sessionStorage.setItem('judgeComment', judgeComment);
                }
            }
            //其他大於SPEC就是異常
            else
            {
                if ( parseFloat(_customerSPEC) <  parseFloat(val) )
                {
                    sty = "style='font-size:14px; color:red; background-color:#9dbcfa'" ;
                    sessionStorage.setItem('judge_result', "Fail");
                    judgeComment += data[j]["ELEMENT"] +':' + parseFloat(val) + ',';
                    sessionStorage.setItem('judgeComment', judgeComment);
                }
            }
        }
    }

    // if (judgeComment != '')
    // {
    //     judgeComment = judgeComment.slice(0,-2);   
    // }
    return sty;
}

function SearchContainer()
{
    var $menu = $('#RightClickmenu');
    $menu.hide();
    var pcontent = '<span style="font-weight:bold; color:#2e6e9e;">《  鋼瓶資訊 Container Information 》</span><br /><br />'
    + '<center><p>日期: <input type="text" id="dateStartFrom"> <input type="BUTTON"  onclick="ShowContainerComplete()" id="QueryContainer" value="確定" /></p></center>'
    + '</br>'
    + '<table id= "tb_ShowContainerComplete"></table><div id="tb_ShowContainerCompletePager"></div>'
    + '</br>'
    + '</br></br>';     
    
    //建立動態表格
    $("#confirmDialog").html(pcontent);

    var table = "tb_ShowContainerComplete";
    var colNames = [];
    var colModel = [];
    var data = [];
    
    $("#tb_ShowContainerComplete").jqGrid('GridUnload');

    // for ( var colName in data[0])
    // {
    //     colNames.push(colName);
    // }

    // for ( var colName in data[0])
    // {           
    //     if (colName === 'id')
    //     {
    //         colModel.push({name:colName, index:colName, align:"center", width:84, frozen:true, sortable:true, sorttype:"int"});
    //     }
    //     else
    //     {
    //         colModel.push({name:colName, index:colName, align:"center", width:112, cellattr: compareCellAttr});
    //     }
    // }
    
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
        pager: '#tb_ShowContainerCompletePager',
        caption: "流程進度", 
        loadComplete: function (){ fixPositionsOfFrozenDivs.call(this); }, // Fix column's height are different after enable frozen column feature 
        gridComplete: function() { $("#" + table).jqGrid('setFrozenColumns');}
    });
    

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
        }
    });

    $( "#dateStartFrom" ).datepicker(
        {
            dateFormat: 'yy-mm-dd',                                 
            changeYear: true,
            changeMonth: true,
            showOn: 'focus',
            autoclose:1
        }
    );
}

function ShowContainerComplete(){
    var _SelectDate =  document.getElementById('dateStartFrom').value;
    $.ajax({
        async:false,
        url:"/ContainerRecord/ContainerComplete",
        type: "Post",           
        data:{
            "postData": _SelectDate,
        },
        success: function (rga){
            var data = rga.success;

            var table = "tb_ShowContainerComplete";
            var colNames = [];
            var colModel = [];
            
            $("#tb_ShowContainerComplete").jqGrid('GridUnload');

            for ( var colName in data[0])
            {
                colNames.push(_CompleteContainerTrans(colName));
            }
        
            for ( var colName in data[0])
            {           
                if (colName === 'work_id')
                {
                    colModel.push({name:colName, index:colName, align:"center", width:120, frozen:true, sortable:true, sorttype:"int"});
                }
                else if (colName === 'working_date')
                {
                    colModel.push({name:colName, index:colName, align:"center", width:130, frozen:true, sortable:true, sorttype:"int"});
                }
                else
                {
                    colModel.push({name:colName, index:colName, align:"center", width:100, cellattr: compareCellAttr});
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
                pager: '#tb_ShowContainerCompletePager',
                caption: "流程進度", 
                loadComplete: function (){ fixPositionsOfFrozenDivs.call(this); }, // Fix column's height are different after enable frozen column feature 
                gridComplete: function() { $("#" + table).jqGrid('setFrozenColumns');}
            });
            
        
         
        }                                   
    });  
}

function _CompleteContainerTrans(ColumnName) {
    var Result = '';
     //舊key到新key的映射，colName的轉換
    var oldkey = {
        "working_date": "日期",
        "bottle_number":"瓶號",
        "assemblingtest":"組裝測試",
        "outbound":"Outbound",
        "CPD":"壓降測漏",
        "inbound":"Inbound",
        "RGA":"RGA測試",
        "work_id":"單號",    
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
