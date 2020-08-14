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
}




// $.ajax({
//     async:false,
//     url: "SamplingRecord/GetDataFromID" ,//路徑
//     type: "POST",           
//     data:{
//         "postData": _rightClickID,
//     },
//     success: function (DownLoadValue){
//         var data = DownLoadValue.success;
//         //產生要寫入excel的data
//         var jqgridWidth = parseInt($(window).width()) * 0.7;
        
//         var pcontent = '<span style="font-weight:bold; color:#2e6e9e;">《 客戶規格表 Customer SPEC  》</span><br /><br />' + '<div id="pdfDisplay"></div>'
//          +
//         '<object id="pdfObject" type="application/pdf" data="pdf/TMAL.pdf" width="100%" height="100%" />';
//         //PDFObject.embed("/pdf/TMAL.pdf", "#pdfDisplay");

//         //建立動態表格
//         $("#confirmDialog").html(pcontent);
       
//         $("#confirmDialog").dialog({
//             width:800, height:600, autoResize:true, modal:false, closeText:"關閉", 
//             resizable:true, closeOnEscape:true, dialogClass:'top-dialog',position:['center',168],
//             show:{effect: "fade", duration: 140},
//             hide:{effect: "clip", duration: 140},
//             focus: function() { $(".ui-dialog").focus(); }, // Unfocus the default focus elem
//             buttons : {
//                 "關閉" : function() {
//                     $(this).dialog("close");
                                                                       
//                 },
//             }
//         });                                 
        
        
//     }                               
// });  