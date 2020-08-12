/*
@author Aming
@version 20200425
@aim 利用xlsx.utils功能對EXCEL進行寫檔(csv,xlsx)
*/
function downloadxlsx(filename, sheetname, data) {
    //儲存xlsx檔
    //參數
    //filename為要下載儲存之xlsx檔名，，sheetname為資料表名，data為要下載之資料，需為二維陣列。以下為使用範例：
    //var filename = 'download.xlsx';
    //var sheetname = 'test';
    //var data = [
    //    ['name', 'number', 'date'],
    //    ['abc', 1, new Date().toLocaleString()],
    //    ['def', 123.456, new Date('2015-03-25T13:30:12Z')],
    //];
    //downloadxlsx(filename, sheetname, data);

    //說明
    //所使用函式可參考js-xlsx的GitHub文件[https://github.com/SheetJS/js-xlsx]


    //datenum
    function datenum(v, date1904) {
        if (date1904) v += 1462;
        var epoch = Date.parse(v);
        return (epoch - new Date(Date.UTC(1899, 11, 30))) / (24 * 60 * 60 * 1000);
    }


    //sheet_from_array_of_arrays
    function sheet_from_array_of_arrays(data) {
        var ws = {};

        var range = { s: { c: 10000000, r: 10000000 }, e: { c: 0, r: 0 } };
        for (var R = 0; R != data.length; ++R) {
            for (var C = 0; C != data[R].length; ++C) {
                if (range.s.r > R) range.s.r = R;
                if (range.s.c > C) range.s.c = C;
                if (range.e.r < R) range.e.r = R;
                if (range.e.c < C) range.e.c = C;
                var cell = { v: data[R][C] };
                //var cell = { v: data[R][C], s: styles };
                
                if (cell.v == null) continue;
                var cell_ref = XLSX.utils.encode_cell({ c: C, r: R });

                if (typeof cell.v === 'number') cell.t = 'n';
                else if (typeof cell.v === 'boolean') cell.t = 'b';
                else if (cell.v instanceof Date) {
                    cell.t = 'n'; cell.z = XLSX.SSF._table[14];
                    cell.v = datenum(cell.v);
                }
                else cell.t = 's';

                ws[cell_ref] = cell;
            }
        }
        if (range.s.c < 10000000) ws['!ref'] = XLSX.utils.encode_range(range);
        return ws;
    }


    //s2ab
    function s2ab(s) {
        var buf = new ArrayBuffer(s.length);
        var view = new Uint8Array(buf);
        for (var i = 0; i != s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
        return buf;
    }
    //Workbook
    function Workbook() {
        if (!(this instanceof Workbook)) return new Workbook();
        this.SheetNames = [];
        this.Sheets = {};
    }
    //write
    var wb = new Workbook();
    var ws = sheet_from_array_of_arrays(data);
    wb.SheetNames.push(sheetname);
    wb.Sheets[sheetname] = ws;

    var sheetName = wb.SheetNames[0];
    utilsTest(wb);
    function utilsTest(wb){
        // XSU.setFontColorRGB(wb, sheetName,"B2","00BFFF");
        // XSU.setFontBold(wb, sheetName,"B3",true);
        // XSU.setAlignmentVertical(wb,sheetName,"B4","top");
        // XSU.setBorderDefaultAll(wb,sheetName);
        //XSU.setTitleStylesDefault(wb,sheetName);
        console.log(wb);
    }


    //var wbout = XLSX.write(wb, { bookType: 'xlsx', type: 'binary' });
    var wbout = xlsxStyle.write(wb, { bookType: 'xlsx', type: 'binary'});

    //saveAs
    // saveAs(new Blob([s2ab(wbout)], { 
    //     type: "application/octet-stream"}), filename);

    //var wbout = xlsxStyle.write(wb,wopts);
    //保存，使用FileSaver.js
     saveAs(new Blob([XSU.s2ab(wbout)],{type:""}), filename);
}