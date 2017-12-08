// https://www.amcharts.com/kbase/dynamically-loading-chart-datasets/
console.log("chart start");

//var dataurl = "ttnlora_env_chartdata.php?id=" + filter_id;
var dataurl = "ttnlora_env_chartdata.php?id=" + filter_id + "&from=" + filter_from + "&to=" + filter_to;

var chart = AmCharts.makeChart("chartdiv", {
    "type": "serial",
    "theme": "light",
    "legend": {
       "horizontalGap": 10,
       "useGraphSettings": true,
       "markerSize": 10,
       "clickMarker": handleLegendClick,
       "clickLabel": handleLegendClick
    },
    "marginRight": 80,
    "autoMarginOffset": 20,
    "marginTop": 7,
    "dataLoader":  { "url" : dataurl },
    "valueAxes": [
	{
		"id" : "temperature",
		"title" : "Temp C",
        	"axisAlpha": 0.2,
        	"dashLength": 1,
		"minMaxMultiplier": 2,
        	"position": "left",
    	},
	{
		"id" : "humidity",
		"title" : "Humidity %",
        	"axisAlpha": 0.2,
        	"dashLength": 1,
        	"position": "left",
		"minimum": 0,
		"maximum": 100,
		"offset": 60
    	},
	{
		"id" : "pressure",
		"title" : "Pressure (mBar)",
        	"axisAlpha": 0.2,
        	"dashLength": 1,
        	"position": "left",
		"minimum": 800,
		"maximum": 1100,
		"offset": 120
    	},
	{
		"id" : "rssi",
		"title" : "RSSI",
        	"axisAlpha": 0.2,
        	"dashLength": 1,
		"minimum": -130,
		"maximum": 20,
        	"position": "right",
    	},
	{
		"id" : "batt",
		"title" : "Batt (V)",
        	"axisAlpha": 0.2,
        	"dashLength": 1,
        	"position": "right",
		"minimum": 0,
		"maximum": 5,
		"offset": 60
    	}
    ],
    "mouseWheelZoomEnabled": true,
    "graphs": [
	{
        	"id": "temperature",
        	"balloonText": "[[value]] C",
        	"bullet": "round",
        	"bulletBorderAlpha": 1,
        	"bulletColor": "#FFFFFF",
        	"hideBulletsCount": 50,
        	"title": "Temperature",
        	"valueField": "temperature",
        	"useLineColorForBulletBorder": true,
 		"type": "smoothedLine",
		"valueAxis": "temperature",
        	"balloon":{
			"fixedPosition":true
        	}
    	},
	{
        	"id": "humidity",
        	"balloonText": "[[value]] %",
        	"bullet": "round",
        	"bulletBorderAlpha": 1,
        	"bulletColor": "#FFFFFF",
        	"hideBulletsCount": 50,
        	"title": "Humidity",
        	"valueField": "humidity",
        	"useLineColorForBulletBorder": true,
 		"type": "smoothedLine",
		"valueAxis": "humidity",
        	"balloon":{
			"fixedPosition":true
        	}
    	},
	{
        	"id": "pressure",
        	"balloonText": "[[value]] mBar",
        	"bullet": "round",
        	"bulletBorderAlpha": 1,
        	"bulletColor": "#FFFFFF",
        	"hideBulletsCount": 50,
        	"title": "Pressure",
        	"valueField": "pressure",
        	"useLineColorForBulletBorder": true,
 		"type": "smoothedLine",
		"valueAxis": "pressure",
        	"balloon":{
			"fixedPosition":true
        	}
    	},
	{
        	"id": "rssi",
        	"balloonText": "[[value]]",
        	"bullet": "round",
        	"bulletBorderAlpha": 1,
        	"bulletColor": "#FFFFFF",
        	"hideBulletsCount": 50,
        	"title": "RSSI",
        	"valueField": "rssi",
        	"useLineColorForBulletBorder": true,
 		"type": "smoothedLine",
		"valueAxis": "rssi",
        	"balloon":{
			"fixedPosition":true
        	}
    	},
	{
        	"id": "batt",
        	"balloonText": "[[value]] V",
        	"bullet": "round",
        	"bulletBorderAlpha": 1,
        	"bulletColor": "#FFFFFF",
        	"hideBulletsCount": 50,
        	"title": "Batt",
        	"valueField": "batt",
        	"useLineColorForBulletBorder": true,
 		"type": "smoothedLine",
		"valueAxis": "batt",
        	"balloon":{
			"fixedPosition":true
        	}
    	}
    ],
    "chartScrollbar": {
        "autoGridCount": true,
        "graph": "temperature",
        "scrollbarHeight": 40
    },
    "chartCursor": {
       "limitToGraph":"g1"
    },
    //dataDateFormat: "YYYY-MM-DD JJ:NN:SS",
    "categoryField": "time",
    "categoryAxis": {
        //"parseDates": true,
        //"equalSpacing": false,
	"minPeriod": "DD",
        "axisColor": "#DADADA",
	"labelFrequency": 10,
        "dashLength": 1,
        "minorGridEnabled": true
	//,"labelFunction": function(valueText, date, categoryAxis) { return date.toLocaleDateString() + ' ' + date.toLocaleTimeString(); }
    }
	//, "export": { "enabled": true }
});

chart.addListener("rendered", zoomChart);
if(chart.zoomChart){
	chart.zoomChart();
}

function zoomChart(){
    chart.zoomToIndexes(Math.round(chart.dataProvider.length * 0.4), Math.round(chart.dataProvider.length * 0.55));
}


function handleLegendClick( graph ) 
{
   var chart = graph.chart;

   if ( graph.hidden)
     chart.showGraph(graph);
   else
     chart.hideGraph(graph);
  
  // return false so that default action is canceled
  return false;
}
console.log("chart done");

