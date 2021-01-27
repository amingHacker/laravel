/*Show Container Input Information*/
function ShowContainerSelect(label){
    var tmp = document.getElementById("InputForm");
    var ptt = document.getElementById("InputFormTable");
    if (ptt != null)
    {
        tmp.removeChild(ptt);
    }
    
    var _id = [1]; //取表的第一筆資料，得到其欄位，須以陣列型態傳遞參數
    $.ajax({
        async:false,
        url: "/ContainerRecord/GetDataFromID/" + label,//路徑
        type: "POST",
        data:{
            "postData": _id,   
        },

    }).done(function(data){
        var success = data.success[0];
        var key = Object.keys(success);
        var c, r, _table;
        _table = document.createElement('table');
        _table.setAttribute("id", "InputFormTable");
        _table.setAttribute("style", "border:3px #cccccc solid");
        _table.setAttribute("cellpadding", "10");
        _table.setAttribute("border", "1");
        for(var i = 0; i < key.length; i++)
        {
            var row = 0;
            if ( 
                key[i] == "id" || key[i] == "working_date" 
                || key[i] == "container_model" || key[i] == "bottle_number"
                || key[i] == "work_id" || key[i] == "table_id" 
                || key[i] == "created_at" || key[i] == "updated_at"
                || key[i] == "equipment_limit" || key[i] == "spec"
                || key[i] == "dew_point_equipment_spec_trans"  || key[i] == "dew_point_equipment_spec" 
                || key[i] == "dew_point_equipment_limit" || key[i] == "dew_point_equipment_limit_trans"  
            )
            {
                continue;
            }
            else
            {
                r = _table.insertRow(row); 
                c = r.insertCell(0);
                c.innerHTML = getColumnNameFromDatabaseToChinese(key[i]);
                c = r.insertCell(1);
                c.innerHTML = '<input type="text" style="width: 150px;" >';
                row++;
            }     
        }
        
        document.getElementById("InputForm").appendChild(_table);
    });
    
    
    
} 