/*
@author Aming
@version 20200807
@aim Check Data to Chart
*/

/*產生圖表*/
function DrowChart( dataLo, chartTypeGroup, dataXaxisGroup, dataYaxisGroup,  
    columnNameGroup, itemGroup, USLGroup, LSLGroup, UCLGroup, LCLGroup)
{         
    //實際產生Chart資料的陣列
    var dataToChartXGroup = [], dataToChartYGroup = []; 
    var dataToChartIDGroup = [], dataToChartBatchNumGroup = [], dataToChartSampleTimeGroup = [];  //label上的資料 

    //宣告Chart 會使用到的資訊
    for(var j = 0; j < chartTypeGroup.length; j++)
    {
        dataToChartXGroup[j] = new Array();
        dataToChartYGroup[j] = new Array();
        dataToChartIDGroup[j] = new Array();
        dataToChartBatchNumGroup[j] = new Array();
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
                        var tID = '', tBatchNum = '', tSamplingTime;
                        
                        if (dataXaxisGroup[i] == 'sampling_date')
                        {
                            tmX = dataLo[key][dataXaxisGroup[i]];
                            tmY = dataLo[key][dataYaxisGroup[i]];
                            tID = dataLo[key]["id"];
                            tBatchNum = dataLo[key]["batch_number"];
                            tSamplingTime = dataLo[key]["sampling_date"];
                        }
                        else if(dataXaxisGroup[i] == '批號')
                        {       
                            tmX = dataLo[key]["batch_number"];       
                            tmY = dataLo[key][dataYaxisGroup[i]];
                            tID = dataLo[key]["id"];
                            tBatchNum = dataLo[key]["batch_number"];
                            tSamplingTime = dataLo[key]["sampling_date"];
                        }
                        else //次數
                        {
                            tmX = dataToChartXGroup[i].length + 1;                           
                            tmY = dataLo[key][dataYaxisGroup[i]];
                            tID = dataLo[key]["id"];
                            tBatchNum = dataLo[key]["batch_number"];
                            tSamplingTime = dataLo[key]["sampling_date"];
                        }

                        var tmyRevpatern = [];
                        if (tmY.indexOf("<")!= -1)
                        {
                            tmyRevpatern = tmY.split("<");
                        }
                        else if (tmY.indexOf(">")!= -1)
                        {
                            tmyRevpatern = tmY.split(">");
                        }
                        else 
                        {
                            tmyRevpatern = tmY.split("<");
                        }
                        
                        tmY = parseFloat(tmyRevpatern[tmyRevpatern.length - 1]);

                        dataToChartXGroup[i].push(tmX);
                        dataToChartYGroup[i].push(tmY);
                        dataToChartIDGroup[i].push(tID);
                        dataToChartBatchNumGroup[i].push(tBatchNum);
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
        UpandDown[key] = getDeviation(dataToChartYGroup[key]);
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
            if (dataXaxisGroup[i] == '批號')
            {
                dataxy = { 
                    x: dataToChartXGroup[0].indexOf(dataToChartXGroup[i][value]),
                    y: dataToChartYGroup[i][value],
                    id: dataToChartIDGroup[i][value],
                    batch_number : dataToChartBatchNumGroup[i][value],
                    sampling_date : dataToChartSampleTimeGroup[i][value]
                }
            }
            else
            {
                dataxy = { 
                    x: dataToChartXGroup[i][value],
                    y: dataToChartYGroup[i][value],
                    id: dataToChartIDGroup[i][value],
                    batch_number : dataToChartBatchNumGroup[i][value],
                    sampling_date : dataToChartSampleTimeGroup[i][value]
                }
            }         
            tmp.push(dataxy);
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
    var Scales = designScale(chartTypeGroup, dataXaxisGroup, UpandDown, horizontalLineScales);


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
                        ctx.strokeStyle = style;
                        ctx.stroke();
                    }

                    if (line.text) {
                        ctx.fillStyle = style;
                        ctx.fillText(line.text, canvas.width - 70, yValue + ctx.lineWidth+5);
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

    window.myLine = new Chart.Scatter(ctx,
        {
            data: scatterChartData,
            options: {
                title: {
                    display: true,
                    text: 'Sampling Records'
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
                                        ' 批號: ' + data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index].batch_number;
                                        
                            return dataInf;
                        
                        }                    
                    }
                },

                // tension: 0,
                // showLine: true,
            
                onClick: graphClickEvent,
                "horizontalLine": horizontalLineScales,
            }

        }  
    );

    for (i = 0; i < window.myLine.data.datasets[0].data.length; i++) 
    {
        if (
            (parseFloat(window.myLine .data.datasets[0].data[i]["y"]) < ((UCLGroup[0] != '')? parseFloat(UCLGroup[0]) : parseFloat(UpandDown[0]["UCL"]))) && 
            (parseFloat(window.myLine .data.datasets[0].data[i]["y"]) > ((LCLGroup[0] != '')? parseFloat(LCLGroup[0]) : parseFloat(UpandDown[0]["LCL"])))
        ) 
        {
            // pointBackgroundColors.push("rgba(255, 99, 132, .2)");
            pointBackgroundColors.push("#00FF00");
            pointBorderColors.push("#00FF00");
        } 
        else {
            pointBackgroundColors.push("#FF0000");
            pointBorderColors.push("#FF0000");

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
            if(window.myLine.data.datasets[removeDataSetIndex].pointBackgroundColor != undefined)
            {
                var toolsConChart = $("#jqxToolBarConChart1").jqxToolBar("getTools");
                var tUCL = toolsConChart[5].tool[0].value;
                
                
                window.myLine.data.datasets[removeDataSetIndex].pointBackgroundColor.splice(removeIndex, 1);
                //window.myLine.data.datasets[removeDataSetIndex].pointBorderColor.splice(removeIndex, 1); //border 與 background 有連動
                var _newYdata = getDataYFromChart(window.myLine.data.datasets[removeDataSetIndex].data);
                var result = getDeviation(_newYdata);
                if (tUCL == '')
                {
                    //重新計算UCL LCL
                    for (var i = 0; i < window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.horizontalLine.length; i++)
                    {
                        if(window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.horizontalLine[i].text.indexOf("UCL") != -1)
                        {
                            window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.horizontalLine[i].y = result["UCL"];
                            window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.horizontalLine[i].text = "UCL=" + result["UCL"];
                        }
                        if(window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.horizontalLine[i].text.indexOf("Center") != -1)
                        {
                            window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.horizontalLine[i].y = result["Mean"];
                            window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.horizontalLine[i].text = "Center=" + result["Mean"];
                        }
                        if(window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.horizontalLine[i].text.indexOf("LCL") != -1)
                        {
                            window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.horizontalLine[i].y = result["LCL"];
                            window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.horizontalLine[i].text = "LCL=" + result["LCL"];
                        }
                    }
                    //重新給予Y軸Data顏色
                    
                    changeBorderColor(_newYdata,  result["UCL"],  result["LCL"]);
                    
                }     
            }
            

            //window.myLine.data.datasets[removeDataSetIndex].data._chartjs.listeners[0].chart.options.horizontalLine[]
           
            window.myLine.update();
            sessionStorage.removeItem('operatingChartDataSetIndex');
            sessionStorage.removeItem('operatingChartIndex');
            var $menu = $('#Chartmenu');
            $menu.hide();
        }   
}

/*獲得標準差, UCL, LCL*/
function getDeviation(data)
{
    var result = json2array(data);
    //var result = [1,1,3,5,5];
    var sum = function(x, y){ return x + y; };　　
    var square = function(x){ return x * x; };　　
    　
    var mean =  result.reduce(sum)/result.length;
    var deviations = result.map(function(x){return x-mean;});
    var stddev = Math.sqrt(deviations.map(square).reduce(sum)/(result.length-1));
    //console.log("平均值："+mean);
    //console.log("偏差："+deviations);
    //console.log("標準差："+stddev);
    var Result = {
        Mean: mean.toFixed(2),
        Stddev: stddev.toFixed(2),
        UCL: (mean + 3 * stddev).toFixed(2),
        LCL: (mean - 3 * stddev).toFixed(2) 
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
    for(var i = 0 ; i < data.length; i++)
    {
        
        if (
            parseFloat(data[i]) <  parseFloat(UCL) && parseFloat(data[i]) >  parseFloat(LCL)
        ) 
         {
            window.myLine.data.datasets[0].pointBackgroundColor[i] = '#00FF00';
            window.myLine.data.datasets[0].pointBorderColor[i] = '#00FF00';
         } 
        else {
            window.myLine.data.datasets[0].pointBackgroundColor[i] = '#FF0000';
            window.myLine.data.datasets[0].pointBorderColor[i] = '#FF0000';
        }
    }
}

/*設定Scale方法*/
function designScale(chartTypeGroup, dataXaxisGroup, UpandDown, horizontalLineScales)
{
    var Scales;
    var SuggestMax, SuggestMin;
    var tmp = [];

    for(var i in horizontalLineScales)
    { 
        tmp.push(parseFloat(horizontalLineScales[i].y));   
    }
    SuggestMax = Math.max.apply(Math,tmp);
    SuggestMin = Math.min.apply(Math,tmp);

    if (chartTypeGroup[0] != 'Scatter Chart')
    {
        Scales = (dataXaxisGroup[0] == '次數' || dataXaxisGroup[0] == '批號')? {
            xAxes: [{
                //type: 'time',
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Count'+'(' + dataXaxisGroup[0] + ')'
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
                    //labelString: 'value'+'(' + dataYaxisGroup[0] + ')'
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
                    displayFormats: {
                        'day': 'YYYY-MM-DD'
                    }
                },
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Date'+'(' + dataXaxisGroup[0] + ')'
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
                    //labelString: 'value'+'(' + dataYaxisGroup[0] + ')'
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
        Scales = (dataXaxisGroup[0] == '次數' || dataXaxisGroup[0] == '批號')? {
            xAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Count'+'(' + dataXaxisGroup[0] + ')'
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
                    //labelString: 'value'+'(' + dataYaxisGroup[0] + ')'
                    labelString: 'value(Unit)'
                },
            }]
        }:{
            xAxes: [{
                type: 'time',
                time: {
                    displayFormats: {
                        'day': 'YYYY-MM-DD'
                    }
                },
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Date'+'(' + dataXaxisGroup[0] + ')'
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
                    //labelString: 'value'+'(' + dataYaxisGroup[0] + ')'
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
function checkControlChartWithGroup(chartTypeGroup, UCLGroup, LCLGroup)
{
    var result = '';
    
    if (chartTypeGroup[0] == 'Control Chart')
    {
        if(chartTypeGroup.length > 1)
        {
            result = 'In control chart, there should not exceed 1 group.';
        }

        if ((UCLGroup[0] !=='' && LCLGroup[0] === '') || (UCLGroup[0] ==='' && LCLGroup[0] !== '')) 
        {
            result = 'To prevent wrong center line, please fill in both UCL and LCL or leave both of blank.';
        }

    }

    return result;
}
