/*
@author Aming
@version 20200807
@aim Check Data to Chart
*/
/*翻譯X軸的資料*/ 
function XAxisDataTransLate(data) 
{
    var XAxisData = {
        "sampling_date" : "typeDate",
        "次數" : "typeCount",
        "batch_number" : "typeLabel",
        "solid_Started" : "typeDate",
        "tank_batch" : "typeLabel",
        "crude_batch" : "typeLabel",
        "bulk_started" : "typeDate",
        "1st_crude_batch" : "typeLabel",
        "1st_tank_batch" : "typeLabel",
        "2nd_crude_batch" : "typeLabel",
        "2nd_tank_batch" : "typeLabel",
        "3rd_crude_batch" : "typeLabel",
        "3rd_tank_batch" : "typeLabel",
        "bulk_batch" : "typeLabel",
        "glove_box" : "typeLabel",
        "sap_batch" : "typeLabel",
        "serial_number" : "typeLabel",
        "Main_bubbler_tank" : "typeLabel",
        "1st_bulk_batch" : "typeLabel",
        "1st_tank_batch" : "typeLabel",
        "2nd_bulk_batch" : "typeLabel",
        "2nd_tank_batch" : "typeLabel",
        "3rd_bulk_batch" : "typeLabel",
        "3rd_tank_batch" : "typeLabel",
        "Oven" : "typeLabel",
        "Material" : "typeLabel",
        "Sampling_date" : "typeDate", 
    };

    return XAxisData[data];

}

/*產生圖表*/
function DrowChart( ChartTitle, dataLo, chartTypeGroup, dataXaxisGroup, dataYaxisGroup,  
    columnNameGroup, itemGroup, USLGroup, LSLGroup, UCLGroup, LCLGroup, LabelItem, DateItem, YaxisMax, YaxisMin)
{         
    //實際產生Chart資料的陣列
    var dataToChartXGroup = [], dataToChartYGroup = []; 
    var dataToChartIDGroup = [], dataToChartLabelItemGroup = [], dataToChartSampleTimeGroup = [];  //label上的資料 

    //宣告Chart 會使用到的資訊
    for(var j = 0; j < chartTypeGroup.length; j++)
    {
        dataToChartXGroup[j] = new Array();
        dataToChartYGroup[j] = new Array();
        dataToChartIDGroup[j] = new Array();
        dataToChartLabelItemGroup[j] = new Array();
        dataToChartSampleTimeGroup[j] = new Array();                
    }

    //分組資料
    for(var i = 0 ; i < chartTypeGroup.length ; i++)
    {    
        for( var key in dataLo)
        {
            for( var p in dataLo[key])
            {
                if (p == columnNameGroup[i])
                {
                    if (itemGroup[i] == dataLo[key][p])
                    {
                        var tmX = '', tmY ='';
                        var tID = '', tLabelItem = '', tSamplingTime;

                        //判斷目前此筆資料是否需要過濾，因資料來源有可能包含"<",">"符號，所以必須過濾

                        var tmyRevpatern = [];
                        if (dataLo[key][dataYaxisGroup[i]].indexOf("<")!= -1)
                        {
                            tmyRevpatern = dataLo[key][dataYaxisGroup[i]].split("<");
                        }
                        else if (dataLo[key][dataYaxisGroup[i]].indexOf(">")!= -1)
                        {
                            tmyRevpatern = dataLo[key][dataYaxisGroup[i]].split(">");
                        }
                        else 
                        {
                            tmyRevpatern = dataLo[key][dataYaxisGroup[i]].split("<");
                        }
                        
                        dataLo[key][dataYaxisGroup[i]] = parseFloat(tmyRevpatern[tmyRevpatern.length - 1]);
                        if(dataLo[key][dataYaxisGroup[i]] > parseFloat(YaxisMax[0]))
                        {
                            
                            continue;
                        }
                        if(dataLo[key][dataYaxisGroup[i]] < parseFloat(YaxisMin[0]))
                        {
                            continue;
                        }
                        
                        if (XAxisDataTransLate(dataXaxisGroup[i]) == 'typeDate')
                        {
                            tmX = dataLo[key][dataXaxisGroup[i]];
                            tmY = dataLo[key][dataYaxisGroup[i]];
                            tID = dataLo[key]["id"];
                            tLabelItem = dataLo[key][LabelItem[0]];
                            tSamplingTime = dataLo[key][DateItem[0]];
                        }
                        else if(XAxisDataTransLate(dataXaxisGroup[i]) == 'typeLabel')
                        {       
                            tmX = dataLo[key][dataXaxisGroup[i]];       
                            tmY = dataLo[key][dataYaxisGroup[i]];
                            tID = dataLo[key]["id"];
                            tLabelItem = dataLo[key][LabelItem[0]];
                            tSamplingTime = dataLo[key][DateItem[0]];
                        }
                        else //次數
                        {
                            tmX = dataToChartXGroup[i].length;                           
                            tmY = dataLo[key][dataYaxisGroup[i]];
                            tID = dataLo[key]["id"];
                            tLabelItem = dataLo[key][LabelItem[0]];
                            tSamplingTime = dataLo[key][DateItem[0]];
                        }

                        // var tmyRevpatern = [];
                        // if (tmY.indexOf("<")!= -1)
                        // {
                        //     tmyRevpatern = tmY.split("<");
                        // }
                        // else if (tmY.indexOf(">")!= -1)
                        // {
                        //     tmyRevpatern = tmY.split(">");
                        // }
                        // else 
                        // {
                        //     tmyRevpatern = tmY.split("<");
                        // }
                        
                        // tmY = parseFloat(tmyRevpatern[tmyRevpatern.length - 1]);

                        dataToChartXGroup[i].push(tmX);
                        dataToChartYGroup[i].push(tmY);
                        dataToChartIDGroup[i].push(tID);
                        dataToChartLabelItemGroup[i].push(tLabelItem);
                        dataToChartSampleTimeGroup[i].push(tSamplingTime);
                    }
                }     
            }           
        }
    }

    //檢查Data是否正確
    var check = checkDataToChart( dataToChartYGroup, dataToChartIDGroup);
    if (check == "There is no data!")
    {
        alert(check);
        return;
    }
    if (check != "OK")
    {       
        var answer = window.confirm(check + "是否繼續進行畫圖? (可能無法正常顯示) ");
        if(!answer){return;}
    }

    //取得UCL LCL計算值
    var UpandDown = [];
    for(var key in dataToChartYGroup)
    {
        UpandDown[key] = getDeviation(dataToChartYGroup[key], USLGroup[0], LSLGroup[0]);
    }

    var color = Chart.helpers.color;
    var _dataset = []; //暫存在scatterChartData的資料
    var horizontalLineScales = []; //紀錄UCL LCL的資料 

    var pointBackgroundColors = []; //紀錄點的背景顏色
    var pointBorderColors = [];     //紀錄點的外圍顏色

    //定義scatter chart使用的顏色
    var _chartcolor = [window.chartColors.red, window.chartColors.blue, window.chartColors.green, window.chartColors.yellow, window.chartColors.purple];


    var dataToChart = [];
    for (var i in dataToChartXGroup)
    {
        var tmp = [];
        for(var value in dataToChartXGroup[i])
        {
            var dataxy;
            if (XAxisDataTransLate(dataXaxisGroup[i]) == 'typeLabel')
            {
                dataxy = { 
                    x: dataToChartXGroup[0].indexOf(dataToChartXGroup[i][value]),
                    y: dataToChartYGroup[i][value],
                    id: dataToChartIDGroup[i][value],
                    labelitem : dataToChartLabelItemGroup[i][value],
                    sampling_date : dataToChartSampleTimeGroup[i][value]
                }
            }
            else
            {
                dataxy = { 
                    x: dataToChartXGroup[i][value],
                    y: dataToChartYGroup[i][value],
                    id: dataToChartIDGroup[i][value],
                    labelitem : dataToChartLabelItemGroup[i][value],
                    sampling_date : dataToChartSampleTimeGroup[i][value]
                }
            }   
            
            if (dataxy.x != -1)
            {
                tmp.push(dataxy);
            }
                    
            
        }
        dataToChart.push(tmp);               
    }


    for (var i in dataToChart)
    {
        var datatmp;
        if (chartTypeGroup[i] == "Scatter Chart" )
        {
            datatmp = {
                label: itemGroup[i],
                borderColor: _chartcolor[i],
                backgroundColor: color(_chartcolor[i]).alpha(0.2).rgbString(),
                data:dataToChart[i],
                fill:false
            }
        }
        else
        {
            datatmp = {
                label: itemGroup[i],
                borderColor: _chartcolor[i],
                backgroundColor: color(_chartcolor[i]).alpha(0.2).rgbString(),
                data:dataToChart[i],
                pointBackgroundColor: pointBackgroundColors,
                pointBorderColor: pointBackgroundColors,
                fill:false
            }
        }
        _dataset.push(datatmp);

        var horizontalLinetmp = [
            {
                "y": (UCLGroup[i] != '')? parseFloat(UCLGroup[i]) : UpandDown[i]["UCL"],
                "style": "#FF0000",
                "text": "UCL=" + ((UCLGroup[i] != '')? UCLGroup[i] : UpandDown[i]["UCL"].toString())
            }, 
            {
                "y": (UCLGroup[i] != '' && LCLGroup[i] != '')?((parseFloat(UCLGroup[i]) + parseFloat(LCLGroup[i])) / 2).toFixed(2) : UpandDown[i]["Mean"],
                "style": "#0000FF",
                "text": "Center=" + ((UCLGroup[i] != '' && LCLGroup[i] != '')?((parseFloat(UCLGroup[i]) + parseFloat(LCLGroup[i])) / 2).toFixed(2).toString() : UpandDown[i]["Mean"].toString()),
            }, 
            {
                "y": (LCLGroup[i] != '')? parseFloat(LCLGroup[i]) : UpandDown[i]["LCL"],
                "style": "#FF0000",
                "text":"LCL=" + ((LCLGroup[i] != '')? LCLGroup[i] : UpandDown[i]["LCL"].toString()),
            },

        ]            
        
        for(var j in horizontalLinetmp)
        {
            horizontalLineScales.push(horizontalLinetmp[j]);
        }
        
        //單邊規格
        if(UCLGroup[i] == '' && LCLGroup[i] != ''){horizontalLineScales[0] = null;}
        if(LCLGroup[i] == '' && UCLGroup[i] != ''){horizontalLineScales[2] = null;} 
    }

    var scatterChartData = {
        datasets: _dataset,
        //labels: dataToChartXGroup[0]
    };

    for (var i in dataToChart)
    {
        //判斷是否為 Scatter圖 USL LSL UCL LCL線段
        if (chartTypeGroup[i] != 'Scatter Chart')
        {
            if (USLGroup[i] != ''){
                var horizontalLinetmp = 
                {
                    "y": parseFloat(USLGroup[i]),
                    "style": "#cd6ade",
                    "text":USLGroup[i],
                    "name":"USL",         
                } 
                horizontalLineScales.push(horizontalLinetmp);
            }

            if (LSLGroup[i] != ''){
                    var horizontalLinetmp = 
                    {     
                        "y": parseFloat(LSLGroup[i]),
                        "style": "#cd6ade",
                        "text":LSLGroup[i],
                        "name":"LSL",
                        
                    }                 
                horizontalLineScales.push(horizontalLinetmp);
            }
        }
        else
        {
            horizontalLineScales = [];
        }
    }

    //設定度量的標準
    var Scales = designScale(chartTypeGroup, dataXaxisGroup, UpandDown, horizontalLineScales, dataToChartXGroup);


    //產生新圖
    if (window.myLine !== undefined && window.myLine !== null) 
    {
        window.myLine.destroy();
    }

    var ctx = document.getElementById('canvas').getContext('2d');

    var horizonalLinePlugin = 
    {
        afterDraw: function(chartInstance) 
        {
            var yScale = chartInstance.scales["y-axis-1"];
            var canvas = chartInstance.chart;
            var ctx = canvas.ctx;
            var index;
            var line;
            var style;


            if (chartInstance.options.horizontalLine) {
                for (index = 0; index < chartInstance.options.horizontalLine.length; index++) {
                    if(chartInstance.options.horizontalLine[index] == null){continue;}
                    line = chartInstance.options.horizontalLine[index];
                    if (!line.style) {
                        style = "rgba(169,169,169, .6)";
                    } else {
                        style = line.style;
                    }

                    if (line.y.toString()) {
                        yValue = yScale.getPixelForValue(line.y);
                    } else {
                        yValue = 0;
                    }

                    ctx.lineWidth = 1;

                    if (yValue) {
                        ctx.beginPath();
                        ctx.moveTo(70, yValue);
                        ctx.lineTo(canvas.width - 10, yValue);
                        ctx.setLineDash([10,10]);
                        ctx.strokeStyle = style;
                        ctx.stroke();
                    }

                    if (line.text) {
                        ctx.fillStyle = style;
                        ctx.fillText(line.text, canvas.width - 100, yValue + ctx.lineWidth+5);
                    }
                    if(line.name)
                    {
                        ctx.fillStyle = style;
                        ctx.fillText(line.name, 0, yValue + ctx.lineWidth);
                    }
                }
                return;
            };
        }
    };
    Chart.pluginService.register(horizonalLinePlugin);

    var addTextOnChartPlugin = {
        afterDraw: function (chart) {
            var width = chart.chart.width,
                height = chart.chart.height,
                ctx = chart.chart.ctx;
            //ctx.font = "0.5em sans-serif";
            ctx.textAlign = "left";
            ctx.textBaseline = "middle";
            ctx.fillStyle = "black";
            for(var i = 0; i < chart.options.addTextOnChart.length; i ++)
            {
                var widthbais = 0.6 + 0.2 * i ;
                ctx.fillText("count: " + chart.options.addTextOnChart[i]["Item"], width * widthbais, height * .03);
                ctx.fillText("average: " + chart.options.addTextOnChart[i]["Mean"], width * widthbais, height * .05);
                ctx.fillText("S.D.(σ): " + chart.options.addTextOnChart[i]["Stddev"], width * widthbais, height * .07);
                ctx.fillText("Cpu: " + chart.options.addTextOnChart[i]["Cpu"], width * (widthbais + 0.1) , height * .03);
                ctx.fillText("Cpl: " + chart.options.addTextOnChart[i]["Cpl"], width * (widthbais + 0.1), height * .05);
                ctx.fillText("Cpk: " + chart.options.addTextOnChart[i]["Cpk"], width * (widthbais + 0.1), height * .07);
                ctx.fillText("Outlier: " + chart.options.addTextOnChart[i]["Outlier"], width * (widthbais + 0.1), height * .09);
            }               
            return;
        }
    };
    Chart.plugins.register(addTextOnChartPlugin);


    window.myLine = new Chart.Scatter(ctx,
        {
            data: scatterChartData,
            options: {
                title: {
                    display: true,
                    text: ChartTitle
                },
                scales: Scales,
                    
                tooltips: {
                    callbacks: {
                        // afterBody: function(t, d) {
                        //     return 'loss 15%'; //return a string that you wish to append
                        label: function(tooltipItem, data) 
                        {
                            var dataInf = 'X:' + data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index].x + 
                                        ' Y:' + data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index].y +
                                        ' 取樣日期: ' + data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index].sampling_date+ 
                                        ' ID:' + data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index].id +
                                        ' Label: ' + data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index].labelitem;
                                        
                            return dataInf;
                        
                        }                    
                    }
                },

                // tension: 0,
                // showLine: true,
                onClick: graphClickEvent,
                "horizontalLine": horizontalLineScales,
                "addTextOnChart": UpandDown,
            }

        }  
    );

    for (i = 0; i < window.myLine.data.datasets[0].data.length; i++) 
    {
        if (
            (parseFloat(window.myLine .data.datasets[0].data[i]["y"]) <= ((UCLGroup[0] != '')? parseFloat(UCLGroup[0]) : parseFloat(UpandDown[0]["UCL"]))) && 
            (parseFloat(window.myLine .data.datasets[0].data[i]["y"]) >= ((LCLGroup[0] != '')? parseFloat(LCLGroup[0]) : parseFloat(UpandDown[0]["LCL"])))
        ) 
        {
            // pointBackgroundColors.push("rgba(255, 99, 132, .2)");
            pointBackgroundColors.push("#00c434");
            pointBorderColors.push("#00c434");
        } 
        else {
            pointBackgroundColors.push("#FF0000");
            pointBorderColors.push("#FF0000");
            window.myLine.data.datasets[0].data._chartjs.listeners[0].chart.options.addTextOnChart[0]["Outlier"] = parseInt(window.myLine.data.datasets[0].data._chartjs.listeners[0].chart.options.addTextOnChart[0]["Outlier"]) + 1;
        }
    }

    window.myLine.update();
}

/*點擊Chart產生的事件*/
function graphClickEvent(event, array){
    if(array[0])
    {
        operatingChartData(event, array);
    }
}

/*操作圖表Data*/
function operatingChartData(event, array) 
{
    var canvas = document.getElementById('canvas');
    canvas.addEventListener('mousedown', handleMouseDown, false);
    var BB = canvas.getBoundingClientRect(),
            offsetX = BB.left,
            offsetY = BB.top; 
    var operatingChartDataSetIndex = array[0]._datasetIndex;//圖表上的排序組別
    var operatingChartIndex = array[0]._index; //data第幾筆資料
    var Height = getScrollTop();

    var menuleft = array[0]._model["x"] + BB.left;
    var menutop = array[0]._model["y"] + BB.top + Height;

    var $menu = $('#Chartmenu');
    $menu.css({left:menuleft, top: menutop});
    $menu.show();

    sessionStorage.setItem('operatingChartDataSetIndex', operatingChartDataSetIndex);
    sessionStorage.setItem('operatingChartIndex', operatingChartIndex);           
}

/*Menu關閉*/
function handleMouseDown(e)
{
    var $menu = $('#Chartmenu');
    $menu.hide();
}

/*獲得瀏覽器卷軸高度*/
function getScrollTop()
{
    var bodyTop = 0;
    if (typeof window.pageYOffset != "undefined") {
        bodyTop = window.pageYOffset;
    } 
    else if (typeof document.compatMode != "undefined"&& document.compatMode != "BackCompat") 
    {
        bodyTop = document.documentElement.scrollTop;
    } 
    else if (typeof document.body != "undefined") {
        bodyTop = document.body.scrollTop;
    }
    /*顯示出捲動後的高度值*/
    return bodyTop;
}

/*記錄到outlier data*/
function saveoutlierChartData()
{
    var dataSetIndex = sessionStorage.getItem('operatingChartDataSetIndex');
    var index= sessionStorage.getItem('operatingChartIndex');
    var outlier = window.myLine.data.datasets[dataSetIndex].data[index];
    sessionStorage.setItem('restoreID'+ outlier["id"] , outlier["id"]);
    var $menu = $('#Chartmenu');
    $menu.hide();
    alert("OK! " + "Save ID: " + outlier["id"]);   
}

function clearoutlierChartData() 
{ 
    //sessionStorage.removeItem('key');
    //刪除SessionSrotage所有保存數據
    sessionStorage.clear();
}

/*移除Chart Data*/
function removeChartData()
{
    var removeDataSetIndex = sessionStorage.getItem('operatingChartDataSetIndex');
    var removeIndex = sessionStorage.getItem('operatingChartIndex');
    var answer = window.confirm("確認在圖面刪除此筆資料?");
        if (answer)
        {   
            window.myLine.data.labels.splice(removeIndex, 1);
            window.myLine.data.datasets[removeDataSetIndex].data.splice(removeIndex, 1);

            //Control Chart
            if(window.myLine.data.datasets[removeDataSetIndex].pointBackgroundColor != undefined)
            {
                var toolsConChart = $("#jqxToolBarConChart1").jqxToolBar("getTools");
                var tUSL = toolsConChart[1].tool[0].value;
                var tLSL = toolsConChart[3].tool[0].value;
                var tUCL = toolsConChart[5].tool[0].value;
                var tLCL = toolsConChart[7].tool[0].value;
                
                
                window.myLine.data.datasets[removeDataSetIndex].pointBackgroundColor.splice(removeIndex, 1);
                //window.myLine.data.datasets[removeDataSetIndex].pointBorderColor.splice(removeIndex, 1); //border 與 background 有連動
                var _newYdata = getDataYFromChart(window.myLine.data.datasets[removeDataSetIndex].data);
                var result = getDeviation(_newYdata, tUSL, tLSL);
                if (tUCL == '' || tLCL == '') //Aming
                {
                    //重新計算UCL LCL
                    for (var i = 0; i < window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.horizontalLine.length; i++)
                    {
                        //若沒有這條線，就跳過
                        if(window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.horizontalLine[i] == null)
                        {
                            continue;
                        }
                        if(window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.horizontalLine[i].text.indexOf("UCL") != -1 && tUCL =='')
                        {
                            window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.horizontalLine[i].y = result["UCL"];
                            window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.horizontalLine[i].text = "UCL=" + result["UCL"];
                        }
                        if(window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.horizontalLine[i].text.indexOf("Center") != -1 && (tUCL == '' || tLCL == ''))
                        {
                            window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.horizontalLine[i].y = result["Mean"];
                            window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.horizontalLine[i].text = "Center=" + result["Mean"];
                        }
                        if(window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.horizontalLine[i].text.indexOf("LCL") != -1 && tLCL =='')
                        {
                            window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.horizontalLine[i].y = result["LCL"];
                            window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.horizontalLine[i].text = "LCL=" + result["LCL"];
                        }
                    }
                    //重新給予Y軸Data顏色
                    
                    changeBorderColor(_newYdata,  result["UCL"],  result["LCL"]);

                    window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.addTextOnChart[removeDataSetIndex]["Item"] = result["Item"];
                    window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.addTextOnChart[removeDataSetIndex]["Mean"] = result["Mean"];
                    window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.addTextOnChart[removeDataSetIndex]["Stddev"] = result["Stddev"];
                    window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.addTextOnChart[removeDataSetIndex]["Cpu"] = result["Cpu"];
                    window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.addTextOnChart[removeDataSetIndex]["Cpl"] = result["Cpl"];
                    window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.addTextOnChart[removeDataSetIndex]["Cpk"] = result["Cpk"];
                }       
            }
            
            //Scatter Chart
            else
            {
                var _newYdata = getDataYFromChart(window.myLine.data.datasets[removeDataSetIndex].data);
                var result = getDeviation(_newYdata, tUSL, tLSL);
                window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.addTextOnChart[removeDataSetIndex]["Item"] = result["Item"];
                window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.addTextOnChart[removeDataSetIndex]["Mean"] = result["Mean"];
                window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.addTextOnChart[removeDataSetIndex]["Stddev"] = result["Stddev"];
                window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.addTextOnChart[removeDataSetIndex]["Cpu"] = result["Cpu"];
                window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.addTextOnChart[removeDataSetIndex]["Cpl"] = result["Cpl"];
                window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.addTextOnChart[removeDataSetIndex]["Cpk"] = result["Cpk"];
            }

            window.myLine.update();
            sessionStorage.removeItem('operatingChartDataSetIndex');
            sessionStorage.removeItem('operatingChartIndex');
            var $menu = $('#Chartmenu');
            $menu.hide();
        }   
}

/**/ 
function viewChartData( ){
    var $menu = $('#Chartmenu');
    $menu.hide();
    var dataSetIndex = sessionStorage.getItem('operatingChartDataSetIndex');
    var index= sessionStorage.getItem('operatingChartIndex');
    var outlier = window.myLine.data.datasets[dataSetIndex].data[index];
    var outlier_data = [];
    outlier_data.push(outlier["id"]);
  
    $.ajax({
            async:false,
            url: "SamplingRecord/GetDataFromID" ,//路徑
            type: "POST",           
            data:{
                "postData": outlier_data,
            },
            success: function (DownLoadValue){
                var data = DownLoadValue.success;
                //產生要寫入excel的data
                var table = "import_preview";
                var pcontent = '<span style="font-weight:bold; color:#2e6e9e;">《 極端值 view outlier  》</span><br /><br />' + '<table id= '+ table + '></table><div id="import_previewPager"></div>';
                
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
                    caption: "極端值紀錄 Outlier Log", 
                    loadComplete: function (){ fixPositionsOfFrozenDivs.call(this); }, // Fix column's height are different after enable frozen column feature 
                    gridComplete: function() { $("#" + table).jqGrid('setFrozenColumns');}
                });
                
                
                //$("#" + table).jqGrid('setFrozenColumns');
                //增加Tool bar        
                $("#" + table).jqGrid('navGrid','#import_previewPager', { search:true, edit:false, add:false, del:false, refresh:true } );
                    

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
                        "清除極端值" : function() {
                            var answer = window.confirm("確認清除極端值?");
                            if (answer)
                            {
                                clearoutlierChartData();
                                $(this).dialog("close");
                            }
                                                                               
                        },
                        "下載": function(){
                            var dataExport = DownLoadValue.success;
                            //產生要寫入excel的data
                            var i = 1;
                            var dataToExcel = [];    
                            dataToExcel.push(colNames);

                            for(var key in dataExport)
                            {
                                var tmp = [];
                                for (var p in dataExport[key])
                                {
                                    tmp.push(dataExport[key][p]);
                                }
                                dataToExcel.push(tmp);
                            }
                            
                            var myDate = new Date().toISOString().slice(0,10); 

                            //檔名
                            var filename = myDate + '-' + 'OutlierLog.xlsx';

                            //表名
                            var sheetname = 'Sheet';

                            //下載
                            downloadxlsx(filename, sheetname, dataToExcel);             
                                    }
                    }
                });                                                   
            }                               
        });     
}

/*獲得標準差, UCL, LCL*/
function getDeviation(data, tUSL, tLSL)
{   
    var result = json2array(data);
    var tCpu = '', tCpl = '', tCpk = '';
    //var result = [1,1,3,5,5];
    var sum = function(x, y){ return x + y; };　　
    var square = function(x){ return x * x; };　　
    　
    var mean =  result.reduce(sum)/result.length;
    var deviations = result.map(function(x){return x-mean;});
    var stddev = Math.sqrt(deviations.map(square).reduce(sum)/(result.length-1));
    //console.log("平均值："+mean);
    //console.log("偏差："+deviations);
    //console.log("標準差："+stddev);
    if (tUSL != ''){tCpu = Math.abs((tUSL - mean) / ( 3 * stddev.toFixed(2))).toFixed(2);}
    if (tLSL != ''){tCpl = Math.abs((mean - tLSL) / ( 3 * stddev.toFixed(2))).toFixed(2);}
    if (tUSL != '' && tLSL == ''){ tCpk = tCpu; }
    if (tUSL == '' && tLSL != ''){ tCpk = tCpl; }
    if (tUSL != '' && tLSL != ''){ tCpk = Math.min(tCpu, tCpl);}
    
    var Result = {
        Mean: mean.toFixed(2),
        Stddev: stddev.toFixed(2),
        UCL: (mean + 3 * stddev).toFixed(2),
        LCL: (mean - 3 * stddev).toFixed(2),
        Item: data.length,
        Cpu: tCpu,
        Cpl: tCpl,
        Cpk: tCpk,
        Outlier:0,
    };
    return Result;
}

/* json to array */
function json2array(json)
{      
    var result = [];
    var keys = Object.keys(json);
    keys.forEach(function(key){
        result.push(parseFloat(json[key]));
    });
    return result;
}

/*獲取Chart中的Y值*/ 
function getDataYFromChart(data)
{
    var result = [];
    for(var i in data)
    {
        result.push(data[i].y);
    }
    return result;
}

/*更改BorderColor*/
function changeBorderColor(data, UCL, LCL)
{
    window.myLine.data.datasets[0].data._chartjs.listeners[0].chart.options.addTextOnChart[0]["Outlier"] = 0;
    for(var i = 0 ; i < data.length; i++)
    {
        
        if (
            parseFloat(data[i]) <  parseFloat(UCL) && parseFloat(data[i]) >  parseFloat(LCL)
        ) 
         {
            window.myLine.data.datasets[0].pointBackgroundColor[i] = '#00c434';
            window.myLine.data.datasets[0].pointBorderColor[i] = '#00c434';
         } 
        else {
            window.myLine.data.datasets[0].pointBackgroundColor[i] = '#FF0000';
            window.myLine.data.datasets[0].pointBorderColor[i] = '#FF0000';
            window.myLine.data.datasets[0].data._chartjs.listeners[0].chart.options.addTextOnChart[0]["Outlier"] = parseInt(window.myLine.data.datasets[0].data._chartjs.listeners[0].chart.options.addTextOnChart[0]["Outlier"]) + 1;
        }
    }
}

/*設定Scale方法*/
function designScale(chartTypeGroup, dataXaxisGroup, UpandDown, horizontalLineScales, dataToChartXGroup)
{
    var Scales;
    var SuggestMax, SuggestMin;
    var tmp = [];

    for(var i in horizontalLineScales)
    {
        if (horizontalLineScales[i]!=null) 
        {
            tmp.push(parseFloat(horizontalLineScales[i].y));   
        }
        
    }
    SuggestMax = Math.max.apply(Math,tmp);
    SuggestMin = Math.min.apply(Math,tmp);

    if (chartTypeGroup[0] != 'Scatter Chart')
    {
        Scales = (XAxisDataTransLate(dataXaxisGroup[0]) == 'typeCount' || XAxisDataTransLate(dataXaxisGroup[0]) == 'typeLabel')? {
            xAxes: [{
                type: 'linear',
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Value'+'(' + dataXaxisGroup[0] + ')'
                },
                position: 'bottom',
                gridLines: {
                    display: false,
                    drawBorder: false,
                },
                ticks: {
                    stepSize: 1,
                    major: {
                        fontStyle: 'bold',
                        fontColor: '#FF0000'
                    },
                    min: 0,
                    max: dataToChartXGroup[0].length -1,
                    callback:function(value, index, values){
                        return dataToChartXGroup[0][value];
                    },
                }
            }],
            yAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'value(Unit)'
                },
                gridLines: {
                            drawBorder: false,
                        },
                ticks: {
                            suggestedMin: SuggestMin,
                            suggestedMax: SuggestMax,
                            stepSize: (SuggestMax - SuggestMin)/6
                    }
            }]
        }:{
            xAxes: [{
                type: 'time',
                time: {
                    unit: 'day',
                    displayFormats: {
                        'day': 'YYYY-MM-DD'
                    }
                },
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Value'+'(' + dataXaxisGroup[0] + ')'
                },
                gridLines: {
                    display: false,
                    drawBorder: false,
                },
                ticks: {
                    major: {
                        fontStyle: 'bold',
                        fontColor: '#FF0000'
                    },
                }
            }],
            yAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'value(Unit)'
                },
                gridLines: {
                            drawBorder: false,
                        },
                ticks: {
                            suggestedMin: SuggestMin,
                            suggestedMax: SuggestMax,
                            stepSize: (SuggestMax - SuggestMin)/6
                    }
            }]
        }
    }
    else
    {
        Scales = (XAxisDataTransLate(dataXaxisGroup[0]) == 'typeCount' || XAxisDataTransLate(dataXaxisGroup[0]) == 'typeLabel')? {
            xAxes: [{
                type: 'linear',
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Value'+'(' + dataXaxisGroup[0] + ')'
                },
                position: 'bottom',
                gridLines: {
                    display: false,
                    drawBorder: false,
                },
                ticks: {
                    stepSize: 1,
                    major: {
                        fontStyle: 'bold',
                        fontColor: '#FF0000'
                    },
                    min: 0,
                    max: dataToChartXGroup[0].length -1,
                    callback:function(value, index, values){
                        return dataToChartXGroup[0][value];
                    },
                }
            }],
            yAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'value(Unit)'
                },
            }]
        }:{
            xAxes: [{
                type: 'time',
                time: {
                    unit: 'day',
                    displayFormats: {
                        'day': 'YYYY-MM-DD'
                    }
                },
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Value'+'(' + dataXaxisGroup[0] + ')'
                },
                gridLines: {
                    display: false,
                    drawBorder: false,
                },
                ticks: {
                    major: {
                        fontStyle: 'bold',
                        fontColor: '#FF0000'
                    }
                }
            }],
            yAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'value(Unit)'
                },
            }]
        }
    }
    return Scales;
}

/*檢查Data是否有誤*/
function checkDataToChart( dataToChartYGroup, dataToChartIDGroup )
{    
    if (Array.prototype.isPrototypeOf(dataToChartYGroup[0]) && dataToChartYGroup[0].length === 0)
    {
        return "There is no data!";
    }
    
    var checkStatus = "OK";
    var checkstring = '資料有誤(非數字或空值)，請檢查:';
    for(var i in dataToChartYGroup)
    {
        for(var data in dataToChartYGroup[i])
        {
             if (isNaN(dataToChartYGroup[i][data]))
             {
                checkStatus = "Fail"; 
                checkstring += "ID:" + dataToChartIDGroup[i][data] + ",";
             }
        }
    }
    if(checkStatus == "Fail")
    {
        return checkstring;
    }
    else
    {
        return checkStatus;
    }

}

/*檢查UCL LCL是否有誤*/
function checkChartWithGroup(chartTypeGroup, UCLGroup, LCLGroup)
{
    var result = '';
    
    if (chartTypeGroup[0] == 'Control Chart')
    {
        if(chartTypeGroup.length > 1)
        {
            result = 'In control chart, there should not exceed 1 group.';
        }

        // if ((UCLGroup[0] !=='' && LCLGroup[0] === '') || (UCLGroup[0] ==='' && LCLGroup[0] !== '')) 
        // {
        //     result = 'To prevent wrong center line, please fill in both UCL and LCL or leave both of blank.';
        // }

    }

    if (chartTypeGroup[0] == 'Scatter Chart')
    {
        if(chartTypeGroup.length > 1)
        {
            for(var i = 0 ; i < chartTypeGroup.length ; i++)
            {
                if (chartTypeGroup[i] == 'Please Choose:' ) 
                {
                    result = 'There is no data in Group ' + ( i + 1 ) + '.';
                }
            }
        }    
    }

    return result;
}
