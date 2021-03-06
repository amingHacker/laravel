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
        "Sampling_date" : "typeDate", 
        "working_date" : "typeDate",
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
        "container_model": "typeLabel",
        "bottle_number": "typeLabel",
    };

    return XAxisData[data];

}

/*產生圖表*/
function DrowChart( ChartTitle, dataLo, chartTypeGroup, dataXaxisGroup, dataYaxisGroup,  
    columnNameGroup, itemGroup, USLGroup, LSLGroup, UCLGroup, LCLGroup, LabelItem, DateItem, YaxisMax, YaxisMin, SPCRule)
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
            // for( var p in dataLo[key])
            // {
                //if (p == columnNameGroup[i])
                //{
                    if ((itemGroup[i] != '' && itemGroup[i] == dataLo[key][columnNameGroup[i]]) || (itemGroup[i] == '' && columnNameGroup[i] == "ALL"))
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

                        dataToChartXGroup[i].push(tmX);
                        dataToChartYGroup[i].push(tmY);
                        dataToChartIDGroup[i].push(tID);
                        dataToChartLabelItemGroup[i].push(tLabelItem);
                        dataToChartSampleTimeGroup[i].push(tSamplingTime);
                    }

                    
                //}
            //}           
        }
    }

    //

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
    var pointStyles = [];  //紀錄點的外框形狀

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
                pointStyle:pointStyles,
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
                "y": (UCLGroup[i] != '' && LCLGroup[i] != '')?((parseFloat(UCLGroup[i]) + parseFloat(LCLGroup[i])) / 2).toFixed(4) : UpandDown[i]["Mean"],
                "style": "#0000FF",
                "text": "Center=" + ((UCLGroup[i] != '' && LCLGroup[i] != '')?((parseFloat(UCLGroup[i]) + parseFloat(LCLGroup[i])) / 2).toFixed(4).toString() : UpandDown[i]["Mean"].toString()),
            }, 
            {
                "y": (LCLGroup[i] != '')? parseFloat(LCLGroup[i]) : UpandDown[i]["LCL"],
                "style": "#FF0000",
                "text":"LCL=" + ((LCLGroup[i] != '')? LCLGroup[i] : UpandDown[i]["LCL"].toString()),
            },

        ]
        
        //UCL LCL Mean值的變更
        UpandDown[i]["UCL"] = horizontalLinetmp[0]["y"];
        UpandDown[i]["Mean"] = horizontalLinetmp[1]["y"];
        UpandDown[i]["LCL"] = horizontalLinetmp[2]["y"];
        

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

    //找尋資料中的最高值與最低值
    var maxIndex = 0, minIndex = 0;
    var arr = Array.from(window.myLine.data.datasets[0].data, c => c.y);
    maxIndex = arr.indexOf(Math.max.apply(null,arr));
    minIndex = arr.indexOf(Math.min.apply(null,arr));

    var tSPCRule = SPCRule[0].split(",");
    //產生SPC圖表
    for (i = 0; i < window.myLine.data.datasets[0].data.length; i++) 
    {
        var judgeColor = 'normal';

        // 1.超過三個標準差
        if (tSPCRule.find(element => element == 'A1.超過3個標準差') != undefined)
        {
            if (
                !(
                    (parseFloat(window.myLine .data.datasets[0].data[i]["y"]) <= ((UCLGroup[0] != '')? parseFloat(UCLGroup[0]) : parseFloat(UpandDown[0]["UCL"]))) && 
                    (parseFloat(window.myLine .data.datasets[0].data[i]["y"]) >= ((LCLGroup[0] != '')? parseFloat(LCLGroup[0]) : parseFloat(UpandDown[0]["LCL"])))
                )
            )
                {
                    judgeColor = 'abnormal';
                }
        }

        // 1-1.超過規格(OOS)
        if (tSPCRule.find(element => element == 'A1-1.超過規格(OOS)') != undefined)
        {
            if (
                !(
                    (parseFloat(window.myLine .data.datasets[0].data[i]["y"]) <= ((USLGroup[0] != '')? parseFloat(USLGroup[0]) : parseFloat(UpandDown[0]["UCL"]))) && 
                    (parseFloat(window.myLine .data.datasets[0].data[i]["y"]) >= ((LSLGroup[0] != '')? parseFloat(LSLGroup[0]) : parseFloat(UpandDown[0]["LCL"])))
                )
            )
                {
                    judgeColor = 'abnormal';
                }
        }
        
        // 2.連續九點在中線同一側
        if (tSPCRule.find(element => element == 'A2.連續九點在中線同一側') != undefined)
        {  
            if ( JudgeSPCRule(i, window.myLine .data.datasets[0].data[i]["y"], window.myLine.data.datasets[0].data, window.myLine.data.datasets[0].data._chartjs.listeners[0].chart.options, 'PointOnSameSide') == 'true')
            {
                judgeColor = 'abnormal';
            }
        }
        
        // 3.連續六點呈現上升或下降
        if (tSPCRule.find(element => element == 'A3.連續六點呈現上升或下降') != undefined)
        {  
            if ( JudgeSPCRule(i, window.myLine .data.datasets[0].data[i]["y"], window.myLine.data.datasets[0].data, window.myLine.data.datasets[0].data._chartjs.listeners[0].chart.options, 'PointIncrease') == 'true')
            {
                judgeColor = 'abnormal';
            }
        }
        
        // 4.連續三點中的兩點落在2個標準差之外
        if (tSPCRule.find(element => element == 'A4.連續三點中的兩點落在2個標準差之外') != undefined)
        {  
            if ( JudgeSPCRule(i, window.myLine .data.datasets[0].data[i]["y"], window.myLine.data.datasets[0].data, window.myLine.data.datasets[0].data._chartjs.listeners[0].chart.options, 'PointOut2Sigma') == 'true')
            {
                judgeColor = 'abnormal';
            }
        }
        // 5.連續五點中的四點落在1個標準差之外
        if (tSPCRule.find(element => element == 'A5.連續五點中的四點落在1個標準差之外') != undefined)
        {
            if ( JudgeSPCRule(i, window.myLine .data.datasets[0].data[i]["y"], window.myLine.data.datasets[0].data, window.myLine.data.datasets[0].data._chartjs.listeners[0].chart.options, 'PointOut1Sigma') == 'true')
            {
                judgeColor = 'abnormal';
            }
        }

        // 6.中位數偏移(近7天中位數-前90天中位數 / 前90天標準差 > 0.9 )
        if (tSPCRule.find(element => element == 'B1.中位數偏移') != undefined)
        {
            if (
                parseFloat(window.myLine .data.datasets[0].data[i]["y"]) > 0.9     
            )
                {
                    judgeColor = 'abnormal';
                }
        }

        // 7.標準差偏移(近7天標準差 / 前90天標準差 > 3 )
        if (tSPCRule.find(element => element == 'B2.標準差偏移') != undefined)
        {
            if (
                parseFloat(window.myLine .data.datasets[0].data[i]["y"]) > 3     
            )
                {
                    judgeColor = 'abnormal';
                }
        }

        if (judgeColor == 'abnormal') 
        {
            pointBackgroundColors.push("#FF0000");
            pointBorderColors.push("#FF0000");
            pointStyles.push("circle");
            window.myLine.data.datasets[0].data._chartjs.listeners[0].chart.options.addTextOnChart[0]["Outlier"] = parseInt(window.myLine.data.datasets[0].data._chartjs.listeners[0].chart.options.addTextOnChart[0]["Outlier"]) + 1;
        } 
        else {
            // pointBackgroundColors.push("rgba(255, 99, 132, .2)");
            pointBackgroundColors.push("#00c434");
            pointBorderColors.push("#00c434");
            pointStyles.push("circle");
        }
    }

    // 8.區間最大最小值
    if (tSPCRule.find(element => element == 'A6.區間最大最小值') != undefined)
    {
        pointStyles[maxIndex] = "triangle";
        pointStyles[minIndex] = "triangle";
        pointBackgroundColors[maxIndex] = window.chartColors.purple;
        pointBackgroundColors[minIndex] = window.chartColors.purple;
        pointBorderColors[maxIndex] = window.chartColors.purple;;
        pointBorderColors[minIndex] = window.chartColors.purple;
    }

    window.myLine.update();
}


/*產生圖表*/
function DrowInventoryBarChart( ChartTitle, dataLo, dataXaxisGroup, dataYaxisGroup, columnNameGroup, itemGroup)
{   
    //產生新圖
    if (window.myBarChart !== undefined && window.myBarChart !== null) 
    {
        window.myBarChart.destroy();
    }

    //計算可用量、檢驗中, 根據勾選的選擇加總
    var _sumUnrestricted = [];
    var _sumIn_Quality_Insp = [];
    var _sumDataY = [];

    //Chart顏色
    var _ChartbackgroundColor = [];
    var _ChartborderColor = [];

    
    for(var i = 0 ; i < dataXaxisGroup.length ; i++)
    {
        _sumUnrestricted.push(0);
        _sumIn_Quality_Insp.push(0);
        _sumDataY.push(0);
        _ChartbackgroundColor.push('rgba(75, 192, 192, 0.2)');
        _ChartborderColor.push('rgb(75, 192, 192)');
    }

   

    
    //根據選擇的Y值計算
    for(var i = 0 ; i < dataXaxisGroup.length ; i++)
    {   
        //分組資料
        var dataX = dataXaxisGroup[i].split(",");
        var dataY = dataYaxisGroup[i].split(",");
        var columnName = columnNameGroup[i];
        var item = itemGroup[i].split(","); 
        for( var key in dataLo)
        {
            //根據dataX(加總所有產品的值)
            for(var j = 0; j < dataX.length; j++)
            {
                for(var q = 0; q < item.length; q++)
                {
                    if(dataLo[key][getColumnNameFromChineseToDatabase(columnName)] == item[q] 
                    && dataLo[key]["Material_Description"] == dataX[j])
                    {
                        _sumUnrestricted[i] += parseFloat(dataLo[key]["Unrestricted"]);
                        _sumIn_Quality_Insp[i] += parseFloat(dataLo[key]["In_Quality_Insp"]);
                    }
                }     
            } 
        }

        //將分組資料根據dataY值填入呈現的圖資料中
        for(var j = 0 ; j < dataY.length; j++)
        {
            switch(dataY[j])
            {
                case '可用量':
                    _sumDataY[i] += _sumUnrestricted[i];
                    break;
                case '檢驗中':
                    _sumDataY[i] += _sumIn_Quality_Insp[i];
                    break;
            }
        }
        
    }

    var opt = {
        events: false,
        tooltips: {
            enabled: false
        },
        hover: {
            animationDuration: 0
        },
        animation: {
            duration: 1,
            onComplete: function () {
                var chartInstance = this.chart,
                    ctx = chartInstance.ctx;
                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';
    
                this.data.datasets.forEach(function (dataset, i) {
                    var meta = chartInstance.controller.getDatasetMeta(i);
                    meta.data.forEach(function (bar, index) {
                        var data = dataset.data[index];                            
                        ctx.fillText(data, bar._model.x, bar._model.y - 5);
                    });
                });
            }
        }
    };

    var ctx = document.getElementById('canvas').getContext('2d');
    window.myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels:dataXaxisGroup,
            // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: ChartTitle,
                // data: [12, 19, 3, 5, 2, 3],
                data: _sumDataY,
                backgroundColor:_ChartbackgroundColor,
                // backgroundColor: [
                //     'rgba(255, 99, 132, 0.2)',
                //     'rgba(54, 162, 235, 0.2)',
                //     'rgba(255, 206, 86, 0.2)',
                //     'rgba(75, 192, 192, 0.2)',
                //     'rgba(153, 102, 255, 0.2)',
                //     'rgba(255, 159, 64, 0.2)'
                // ],
                borderColor:_ChartborderColor,
                // borderColor: [
                //     'rgba(255, 99, 132, 1)',
                //     'rgba(54, 162, 235, 1)'
                //     'rgba(255, 206, 86, 1)',
                //     'rgba(75, 192, 192, 1)',
                //     'rgba(153, 102, 255, 1)',
                //     'rgba(255, 159, 64, 1)'
                // ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            events: false,
            tooltips: {
                enabled: false
            },
            hover: {
                animationDuration: 0
            },
            animation: {
                duration: 1,
                onComplete: function () {
                    var chartInstance = this.chart,
                        ctx = chartInstance.ctx;
                    ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'bottom';

                    this.data.datasets.forEach(function (dataset, i) {
                        var meta = chartInstance.controller.getDatasetMeta(i);
                        meta.data.forEach(function (bar, index) {
                            var data = dataset.data[index];                            
                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
                        });
                    });
                }
            }
        }
    });
}

/*產生圖表*/
function DrowShipmentBarChart( ChartTitle, dataLo, dataXaxisGroup, dataYaxisGroup, columnNameGroup, itemGroup)
{   
    //產生新圖
    if (window.myBarChart !== undefined && window.myBarChart !== null) 
    {
        window.myBarChart.destroy();
    }

    //計算可用量、檢驗中, 根據勾選的選擇加總
    var _sumDataY = [];

    //Chart顏色
    var _ChartbackgroundColor = [];
    var _ChartborderColor = [];

    
    for(var i = 0 ; i < dataXaxisGroup.length ; i++)
    {
        _sumDataY.push(0);
        _ChartbackgroundColor.push('rgba(75, 192, 192, 0.2)');
        _ChartborderColor.push('rgb(75, 192, 192)');
    }

   

    
    //根據選擇的Y值計算
    for(var i = 0 ; i < dataXaxisGroup.length ; i++)
    {   
        //分組資料
        var dataX = dataXaxisGroup[i];
        var dataY = dataYaxisGroup[i];
        var columnName = columnNameGroup[i];
        var item = itemGroup[i]; 
        for( var key in dataLo)
        {
                
            if(dataLo[key][columnName] == dataX)
            {
                _sumDataY[i] += parseFloat(dataLo[key][dataY]);
            
            }
                     
        }
        
    }

    var opt = {
        events: false,
        tooltips: {
            enabled: false
        },
        hover: {
            animationDuration: 0
        },
        animation: {
            duration: 1,
            onComplete: function () {
                var chartInstance = this.chart,
                    ctx = chartInstance.ctx;
                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';
    
                this.data.datasets.forEach(function (dataset, i) {
                    var meta = chartInstance.controller.getDatasetMeta(i);
                    meta.data.forEach(function (bar, index) {
                        var data = dataset.data[index];                            
                        ctx.fillText(data, bar._model.x, bar._model.y - 5);
                    });
                });
            }
        }
    };

    var ctx = document.getElementById('canvas').getContext('2d');
    window.myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels:dataXaxisGroup,
            // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: ChartTitle,
                // data: [12, 19, 3, 5, 2, 3],
                data: _sumDataY,
                backgroundColor:_ChartbackgroundColor,
                // backgroundColor: [
                //     'rgba(255, 99, 132, 0.2)',
                //     'rgba(54, 162, 235, 0.2)',
                //     'rgba(255, 206, 86, 0.2)',
                //     'rgba(75, 192, 192, 0.2)',
                //     'rgba(153, 102, 255, 0.2)',
                //     'rgba(255, 159, 64, 0.2)'
                // ],
                borderColor:_ChartborderColor,
                // borderColor: [
                //     'rgba(255, 99, 132, 1)',
                //     'rgba(54, 162, 235, 1)'
                //     'rgba(255, 206, 86, 1)',
                //     'rgba(75, 192, 192, 1)',
                //     'rgba(153, 102, 255, 1)',
                //     'rgba(255, 159, 64, 1)'
                // ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            events: false,
            tooltips: {
                enabled: false
            },
            hover: {
                animationDuration: 0
            },
            animation: {
                duration: 1,
                onComplete: function () {
                    var chartInstance = this.chart,
                        ctx = chartInstance.ctx;
                    ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'bottom';

                    this.data.datasets.forEach(function (dataset, i) {
                        var meta = chartInstance.controller.getDatasetMeta(i);
                        meta.data.forEach(function (bar, index) {
                            var data = dataset.data[index];                            
                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
                        });
                    });
                }
            }
        }
    });
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

                var toolsBarChartRange = $("#jqxToolBarChartRange1").jqxToolBar("getTools");
                var tSPCRule = toolsBarChartRange[5].tool[0].lastChild.value;
                
                
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
                    //若有指定UCL or LCL 則須將原本的UCL LCL設定回去
                    if( tUCL != ""){result["UCL"] = tUCL;}
                    if( tLCL != ""){result["UCL"] = tLCL;}
        
                    //重新給予Y軸Data顏色
                    changeBorderColor(_newYdata,  result["UCL"],  result["LCL"], tUSL, tLSL, tSPCRule);

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
    if (tUSL != ''){tCpu = Math.abs((tUSL - mean) / ( 3 * stddev.toFixed(20))).toFixed(20);}
    if (tLSL != ''){tCpl = Math.abs((mean - tLSL) / ( 3 * stddev.toFixed(20))).toFixed(20);}
    if (tUSL != '' && tLSL == ''){ tCpk = tCpu; }
    if (tUSL == '' && tLSL != ''){ tCpk = tCpl; }
    if (tUSL != '' && tLSL != ''){ tCpk = Math.min(tCpu, tCpl);}

    var tUCL = parseFloat((mean + 3 * stddev).toFixed(20));
    var tLCL = parseFloat((mean - 3 * stddev).toFixed(20));
    
    var Result = {
        Mean: parseFloat(mean.toFixed(20)) > 0.0001? mean.toFixed(4):parseFloat(mean.toFixed(20)).toExponential(2),
        Stddev: parseFloat(stddev.toFixed(20)) > 0.0001? stddev.toFixed(4):parseFloat(stddev.toFixed(20)).toExponential(2),
        UCL: tUCL > 0? (tUCL > 0.0001? tUCL.toFixed(4):parseFloat(tUCL).toExponential(2)): (tUCL < -0.0001? tUCL.toFixed(4):parseFloat(tUCL).toExponential(2)),
        LCL: tLCL > 0? (tLCL > 0.0001? tLCL.toFixed(4):parseFloat(tLCL).toExponential(2)): (tLCL < -0.0001? tLCL.toFixed(4):parseFloat(tLCL).toExponential(2)),
        Item: data.length,
        Cpu: (tCpu == '')? tCpu:tCpu > 0.0001? parseFloat(tCpu).toFixed(4):parseFloat(tCpu).toExponential(2),
        Cpl: (tCpl == '')? tCpl:tCpl > 0.0001? parseFloat(tCpl).toFixed(4):parseFloat(tCpl).toExponential(2),
        Cpk: (tCpk == '')? tCpk:tCpk > 0.0001? parseFloat(tCpk).toFixed(4):parseFloat(tCpk).toExponential(2),
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
function changeBorderColor(data, UCL, LCL, USL, LSL, SPCRule)
{
    window.myLine.data.datasets[0].data._chartjs.listeners[0].chart.options.addTextOnChart[0]["Outlier"] = 0;
    var tSPCRule = SPCRule.split(",");

    //找尋資料中的最高值與最低值
    var maxIndex = 0, minIndex = 0;
    maxIndex = data.indexOf(Math.max.apply(null,data));
    minIndex = data.indexOf(Math.min.apply(null,data));

    for(var i = 0 ; i < data.length; i++)
    {

        var judgeColor = 'normal';

        // 1.超過三個標準差
        if (tSPCRule.find(element => element == 'A1.超過3個標準差') != undefined)
        {
            if (
                !(
                    parseFloat(data[i]) <  parseFloat(UCL) && parseFloat(data[i]) >  parseFloat(LCL)
                )
            )
                {
                    judgeColor = 'abnormal';
                }
        }

        // 1-1. 超過規格(OOS)
        if (tSPCRule.find(element => element == 'A1-1.超過規格(OOS)') != undefined)
        {
            if(USL == '' && LSL != ''){
                if (
                    !(
                        parseFloat(data[i]) >=  parseFloat(LSL)
                    )
                )
                    {
                        judgeColor = 'abnormal';
                    }
            }
            else if (USL != '' && LSL == '')
            {
                if (
                    !(
                        parseFloat(data[i]) <=  parseFloat(USL)
                    )
                )
                    {
                        judgeColor = 'abnormal';
                    }
            }
            else
            {
                if (
                    !(
                        parseFloat(data[i]) <  parseFloat(USL) && parseFloat(data[i]) >  parseFloat(LSL)
                    )
                )
                    {
                        judgeColor = 'abnormal';
                    }
            }
            
        }
        
        // 2.連續九點在中線同一側
        if (tSPCRule.find(element => element == 'A2.連續九點在中線同一側') != undefined)
        {  
            if ( JudgeSPCRule(i, data[i], window.myLine.data.datasets[0].data, window.myLine.data.datasets[0].data._chartjs.listeners[0].chart.options, 'PointOnSameSide') == 'true')
            {
                judgeColor = 'abnormal';
            }
        }
        
        // 3.連續六點呈現上升或下降
        if (tSPCRule.find(element => element == 'A3.連續六點呈現上升或下降') != undefined)
        {  
            if ( JudgeSPCRule(i, data[i], window.myLine.data.datasets[0].data, window.myLine.data.datasets[0].data._chartjs.listeners[0].chart.options, 'PointIncrease') == 'true')
            {
                judgeColor = 'abnormal';
            }
        }
        
        // 4.連續三點中的兩點落在2個標準差之外
        if (tSPCRule.find(element => element == 'A4.連續三點中的兩點落在2個標準差之外') != undefined)
        {  
            if ( JudgeSPCRule(i, data[i], window.myLine.data.datasets[0].data, window.myLine.data.datasets[0].data._chartjs.listeners[0].chart.options, 'PointOut2Sigma') == 'true')
            {
                judgeColor = 'abnormal';
            }
        }
        // 5.連續五點中的四點落在1個標準差之外
        if (tSPCRule.find(element => element == 'A5.連續五點中的四點落在1個標準差之外') != undefined)
        {
            if ( JudgeSPCRule(i, data[i], window.myLine.data.datasets[0].data, window.myLine.data.datasets[0].data._chartjs.listeners[0].chart.options, 'PointOut1Sigma') == 'true')
            {
                judgeColor = 'abnormal';
            }
        }

        // 6.中位數偏移(近7天中位數-前90天中位數 / 前90天標準差 > 0.9 )
        if (tSPCRule.find(element => element == 'B1.中位數偏移') != undefined)
        {
            if (
                parseFloat(data[i]) > 0.9     
            )
                {
                    judgeColor = 'abnormal';
                }
        }

        // 7.標準差偏移(近7天標準差 / 前90天標準差 > 3 )
        if (tSPCRule.find(element => element == 'B2.標準差偏移') != undefined)
        {
            if (
                parseFloat(data[i]) > 3     
            )
                {
                    judgeColor = 'abnormal';
                }
        }

        if (judgeColor == 'abnormal') 
        {   
            window.myLine.data.datasets[0].pointBackgroundColor[i] = '#FF0000';
            window.myLine.data.datasets[0].pointBorderColor[i] = '#FF0000';
            window.myLine.data.datasets[0].data._chartjs.listeners[0].chart.options.addTextOnChart[0]["Outlier"] = parseInt(window.myLine.data.datasets[0].data._chartjs.listeners[0].chart.options.addTextOnChart[0]["Outlier"]) + 1; 
         
        } 
        else {
            window.myLine.data.datasets[0].pointBackgroundColor[i] = '#00c434';
            window.myLine.data.datasets[0].pointBorderColor[i] = '#00c434';
        }
    }

    // 8.區間最大最小值
    if (tSPCRule.find(element => element == 'A6.區間最大最小值') != undefined)
    {
        window.myLine.data.datasets[0].pointStyle[maxIndex] = "triangle";
        window.myLine.data.datasets[0].pointStyle[minIndex] = "triangle";
        window.myLine.data.datasets[0].pointBackgroundColor[maxIndex] = window.chartColors.purple;
        window.myLine.data.datasets[0].pointBackgroundColor[minIndex] = window.chartColors.purple;
        window.myLine.data.datasets[0].pointBorderColor[maxIndex] = window.chartColors.purple;;
        window.myLine.data.datasets[0].pointBorderColor[minIndex] = window.chartColors.purple;
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
function checkChartWithGroup(chartTypeGroup, UCLGroup, LCLGroup, SPCRule)
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

    if (SPCRule[0].indexOf("A")>= 0)
    {   
        if(SPCRule[0].indexOf("B") >= 0)
        {
            result = 'A and B Group should not appear in the same time!';
        }                
    }
    
    if (SPCRule[0].indexOf("B1")>= 0)
    {   
        if(SPCRule[0].indexOf("B2") >= 0)
        {
            result = 'B1 and B2 Group should not appear in the same time!';
        }                
    }

    return result;
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


// JudgeSPCRule(i, window.myLine .data.datasets[0].data[i]["y"], window.myLine.data.datasets[0].data, UpandDown[0], 'PointOnSameSide')
/*判斷SPC Rule */
function JudgeSPCRule( index, point, OriginalData, condition, type )
{
    var result = 'false';
    
    switch (type){
        //2.連續九點在中線同一側
        case 'PointOnSameSide': 
                if (index < 8 ){result = 'false'; break;}
                else{ 
                    var Center = condition.addTextOnChart[0]["Mean"];
                    var side = Math.sign(point - Center); //判斷此點在中線的上或下
                    for(var i = index - 1; i >= index - 8; i--)
                    {
                       if ( Math.sign(OriginalData[i]["y"] - Center) != side )
                       {
                            return result = 'false';
                       } 
                    }
                    result = 'true';
                }
                break;
        
        //3.連續六點呈現上升或下降
        case 'PointIncrease':

                if (index < 5 ){result = 'false'; break;}
                else{
                    var side = Math.sign(point - OriginalData[index - 1]["y"]); //判斷此點是否大於或小於上一點
                    if (side == 0){ return result = 'false';}
                    for(var i = index -1; i > index - 5; i--)
                    {   
                        if (  Math.sign(OriginalData[i]["y"] - OriginalData[i - 1]["y"]) != side )
                        {
                            return result = 'false';
                        } 
                    }
                    result = 'true';
                }
                break;
        
        //4.連續三點中的兩點落在2個標準差之外
        case 'PointOut2Sigma':
                
                if (index < 2){result = 'false'; break;}
                else
                {
                    var sigma2Positive = parseFloat(condition.addTextOnChart[0]["Mean"]) + 2 * parseFloat(condition.addTextOnChart[0]["Stddev"]);
                    var sigma2Negative = parseFloat(condition.addTextOnChart[0]["Mean"]) - 2 * parseFloat(condition.addTextOnChart[0]["Stddev"]);
                    //大於兩個標準差
                    if (point > sigma2Positive){
                        for(var i = index -1; i >= index - 2; i--)
                        {
                            if(OriginalData[i]["y"] > sigma2Positive)
                            {
                                return result = 'true';
                            }
                        }
                    }
                    //小於兩個標準差
                    else if (point < sigma2Negative)
                    {
                        for(var i = index -1 ; i >= index - 2; i--)
                        {
                            if(OriginalData[i]["y"] < sigma2Negative)
                            {
                                return result = 'true';
                            }
                        }
                    }
                    //其他
                    else
                    {
                        return result = 'false';
                    }
                }
            break;
        //5.連續五點中的四點落在1個標準差之外
        case 'PointOut1Sigma':
                
                if (index < 4){result = 'false'; break;}
                else
                {
                    var sigma1Positive = parseFloat(condition.addTextOnChart[0]["Mean"]) + 1 * parseFloat(condition.addTextOnChart[0]["Stddev"]);
                    var sigma1Negative = parseFloat(condition.addTextOnChart[0]["Mean"]) - 1 * parseFloat(condition.addTextOnChart[0]["Stddev"]);
                    //大於1個標準差
                    if (point > sigma1Positive){
                        var count = 0;
                        for(var i = index -1; i >= index - 4; i--)
                        {
                            if(OriginalData[i]["y"] > sigma1Positive)
                            {
                                count++;
                            }
                        }
                        if (count >= 3){
                            result = 'true';
                        }
                    }
                    //小於1個標準差
                    else if (point < sigma1Negative)
                    {
                        var count = 0;
                        for(var i = index -1; i >= index - 4; i--)
                        {
                            if(OriginalData[i]["y"] < sigma1Negative)
                            {
                                count++;
                            }
                        }
                        if (count >= 3){
                            result = 'true';
                        }
                    }
                    //其他
                    else
                    {
                        return result = 'false';
                    }
                }
            break;                       
    }
    return result;
}

//用來找尋偏移(中位數偏移、標準差偏移)，採用後台執行方式，避免等待太久
function FindShift(url, postData, type, DataY){
    return new Promise( function(resolve) 
    {
        $.ajax({
                    async:false,
                    url: url ,//路徑
                    type: "POST",           
                    data:{
                        "postData": postData,
                        "type":type,
                        "DataY": DataY
                    },
                success: function (DownLoadValue){
                    var dataLo = DownLoadValue.success;
                        resolve(dataLo);   
                            
                    }                               
                }); 
    });  
}
