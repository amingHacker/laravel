/*
@author Aming
@version 20200425
@aim 利用xlsx.utils功能對EXCEL進行讀檔(csv,xlsx)
*/

//這個方法是用來轉換UTF8
function isUTF8(bytes) {
    var i = 0;
    while (i < bytes.length) {
        if ((// ASCII
            bytes[i] == 0x09 ||
            bytes[i] == 0x0A ||
            bytes[i] == 0x0D ||
            (0x20 <= bytes[i] && bytes[i] <= 0x7E)
        )
        ) {
            i += 1;
            continue;
        }

        if ((// non-overlong 2-byte
            (0xC2 <= bytes[i] && bytes[i] <= 0xDF) &&
            (0x80 <= bytes[i + 1] && bytes[i + 1] <= 0xBF)
        )
        ) {
            i += 2;
            continue;
        }

        if ((// excluding overlongs
            bytes[i] == 0xE0 &&
            (0xA0 <= bytes[i + 1] && bytes[i + 1] <= 0xBF) &&
            (0x80 <= bytes[i + 2] && bytes[i + 2] <= 0xBF)
        ) ||
            (// straight 3-byte
                ((0xE1 <= bytes[i] && bytes[i] <= 0xEC) ||
                    bytes[i] == 0xEE ||
                    bytes[i] == 0xEF) &&
                (0x80 <= bytes[i + 1] && bytes[i + 1] <= 0xBF) &&
                (0x80 <= bytes[i + 2] && bytes[i + 2] <= 0xBF)
            ) ||
            (// excluding surrogates
                bytes[i] == 0xED &&
                (0x80 <= bytes[i + 1] && bytes[i + 1] <= 0x9F) &&
                (0x80 <= bytes[i + 2] && bytes[i + 2] <= 0xBF)
            )
        ) {
            i += 3;
            continue;
        }

        if ((// planes 1-3
            bytes[i] == 0xF0 &&
            (0x90 <= bytes[i + 1] && bytes[i + 1] <= 0xBF) &&
            (0x80 <= bytes[i + 2] && bytes[i + 2] <= 0xBF) &&
            (0x80 <= bytes[i + 3] && bytes[i + 3] <= 0xBF)
        ) ||
            (// planes 4-15
                (0xF1 <= bytes[i] && bytes[i] <= 0xF3) &&
                (0x80 <= bytes[i + 1] && bytes[i + 1] <= 0xBF) &&
                (0x80 <= bytes[i + 2] && bytes[i + 2] <= 0xBF) &&
                (0x80 <= bytes[i + 3] && bytes[i + 3] <= 0xBF)
            ) ||
            (// plane 16
                bytes[i] == 0xF4 &&
                (0x80 <= bytes[i + 1] && bytes[i + 1] <= 0x8F) &&
                (0x80 <= bytes[i + 2] && bytes[i + 2] <= 0xBF) &&
                (0x80 <= bytes[i + 3] && bytes[i + 3] <= 0xBF)
            )
        ) {
            i += 4;
            continue;
        }
        return false;
    }
    return true;
}

//文件轉換為BinaryString
function fixdata(data) { 
	var o = "",
		l = 0,
		w = 10240;
	for (; l < data.byteLength / w; ++l) o += String.fromCharCode.apply(null, new Uint8Array(data.slice(l * w, l * w + w)));
	o += String.fromCharCode.apply(null, new Uint8Array(data.slice(l * w)));
	return o;
}

//重新改寫readAsBinaryString(因ie11不支援html5讀檔，需要先將資料轉成readArrayBuffer)
FileReader.prototype.readAsBinaryString = function (fileData) {
    var binary = "";
    var pt = this;
    var reader = new FileReader();
    reader.onload = function () {
        var bytes = new Uint8Array(reader.result);
        var length = bytes.byteLength;
        for (var i = 0; i < length; i++) {
            binary += String.fromCharCode(bytes[i]);
        }
        pt.content = binary;
        pt.onload(pt); //頁面內data取pt.content文件內容 
    };
    reader.readAsArrayBuffer(fileData);
};

var wb; //讀取完成的數據
var rABS; //是否將文件讀取為二進制字串符
var isCSV; //是否為csv檔
//輸入資料
function ExcelImportf(obj) {
    if (!obj.files) return;
    //return new Promise((resolve, reject) => //因es5不支援html文本讀取
    return new Promise( function(resolve) 
    {
			var f = obj.files[0];
            var reader = new FileReader();          
            
			reader.onload = function (e) {
                 //var data = e.target.result;
                //console.log(e);
                var data;             
                data = reader.content;
				wb = null;
				if (isCSV) {
                    
					data = new Uint8Array(data);
					var f = isUTF8(data);
					//document.getElementById("ff").innerHTML = "是csv文件" + (f ? "是" : "不是") + "UTF-8";
					if (f) {
						data = e.target.result;
					} else {
						var str = cptable.utils.decode(950, data);
						wb = XLSX.read(str, { type: "string" });
					}
				}else{
					//document.getElementById("ff").innerHTML ="不是csv文件"
				}
				if (!wb) {
					wb = rABS|| isCSV ? XLSX.read(btoa(fixdata(data)), { type: 'base64' }) : XLSX.read(data, { type: 'binary', cellDates:true,  cellText:false, cellNF:false });  //cellNF: "yyyy-mm-dd hh:mm:ss",
				}      
                
                //wb.SheetNames[0]是獲取Sheets中第一個Sheet的名字
				//wb.Sheets[Sheet名]獲取第一個Sheet的數據
				//document.getElementById("demo").innerHTML = JSON.stringify(XLSX.utils.sheet_to_json(wb.Sheets[wb.SheetNames[0]]));                                        
                

                //因從excel讀出來的值有可能有設定空格，所以必須重新把這個json檔案去除頭尾空白
                var _datatotrim =  XLSX.utils.sheet_to_json(  
                    wb.Sheets[wb.SheetNames[0]],{header:0, defval:"",raw :false, dateNF:"yyyy-mm-dd hh:mm:ss"}
                );
                
                for (var tmp in _datatotrim)
                {                  
                   for (var key in _datatotrim[tmp])
                   {
                        if (typeof(_datatotrim[tmp][key]) == 'string')
                        {
                            _datatotrim[tmp][key] = _datatotrim[tmp][key].trim();
                        }


                   }               
                }
                const ReturnData = JSON.stringify( _datatotrim ) ;
                //console.log(ReturnData)
                
                // const _ReturnData = JSON.stringify(
                //     XLSX.utils.sheet_to_json(  
                //             wb.Sheets[wb.SheetNames[0]],{header:0, defval:""}
                //         )
                //     );                
                // console.log(_ReturnData);

                resolve(  ReturnData );
               
			};

			reader.onerror = function(e) {
				reject(e);
			};
			
			isCSV = f.name.split(".").reverse()[0] == "csv";//判斷是否為csv檔
			if (rABS || isCSV) {             
				reader.readAsArrayBuffer(f);
			} else {                           
                reader.readAsBinaryString(f);            
			}
            obj.value = "";           
           
    });
    
   
}

//轉換為json
function to_json(workbook) {
    var result = {};
    // workbook.SheetNames.forEach(function(sheetName) {
    //     var roa = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
    //     if(roa.length >= 0){
    //         result[sheetName] = roa;
    //     }
        
    // });


    workbook.SheetNames.forEach(function (sheetName) {
        // Get headers.
        var headers = [];
        var sheet = workbook.Sheets[sheetName];
        var range = XLSX.utils.decode_range(sheet['!ref']);
        var C, R = range.s.r;
        /* start in the first row */
        /* walk every column in the range */
        for (C = range.s.c; C <= range.e.c; ++C) {
            var cell = sheet[XLSX.utils.encode_cell({c: C, r: R})];
            /* find the cell in the first row */

            var hdr = "UNKNOWN " + C; // <-- replace with your desired default
            if (cell && cell.t) {
                hdr = XLSX.utils.format_cell(cell);
            }
            headers.push(hdr);
        }
        result["ColName"] = headers;
        // For each sheets, convert to json.
        var roa = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName]);
        
        if (roa.length > 0) {
            roa.forEach(function (row) {
                // Set empty cell to ''.
                headers.forEach(function (hd) {
                    if (row[hd] == undefined) {
                        row[hd] = "";
                    }
                });
            });
            //result[sheetName] = roa;
            result[sheetName] = roa;        
        }
    });


    return result;
}
