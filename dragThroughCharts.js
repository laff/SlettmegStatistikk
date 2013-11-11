// Global variables
var monthArr = [],
	jsonDir = "stat-json";

// Setting up array for converting Integers to its equivelent month
monthArr[1]="Januar";
monthArr[2]="Februar";
monthArr[3]="Mars";
monthArr[4]="April";
monthArr[5]="Mai";
monthArr[6]="Juni";
monthArr[7]="Juli";
monthArr[8]="August";
monthArr[9]="September";
monthArr[10]="Oktober";
monthArr[11]="November";
monthArr[12]="Desember";


// Get the folder and filenames from file.
window.onload = function()
	{
		$.getJSON('data.json', function(data) {
		   createChartDrag(data);
		});
	}


function createChartDrag(folderFiles) {

	// Create slider
	new Dragdealer('chartDrag',
	{
		steps: folderFiles.length,
		snap: true,
        x: 1,
		animationCallback: function(x, y)
		{
			var index = this.stepRatios.indexOf(x),
				folderFile = folderFiles[index];
				year = folderFiles[index][0],
				// Get month from filename "XX.json"
				month = monthArr[folderFiles[index][1].substr(0, folderFiles[index][1].indexOf('.'))];

			
			// Show what month and year "it is"
			$("#yearDate").html("<p>"+month+' '+year+"</p>");


			// Give/get data to charts
			getData(folderFile);

		}
	});
}


function getData(folderFile) {

	var currentData;

	{
		$.getJSON(jsonDir+'/'+folderFile[0]+'/'+folderFile[1], function(data) {

			// Create our charts

			createPie(data);

			createStackedColumn(data);

			createRotatedLabelsColumn(data);

		});
	}
}

function createRotatedLabelsColumn(data) {

	var categories = [],
		serieData = [];

	$.each(data.websites, function(index, value) {
		if (index != 'total') {
			categories.push(index);
			serieData.push(value);
		}
	});

	$(function () {
	        $('#rotatedlabels').highcharts({
	            chart: {
	                type: 'column',
	                margin: [ 50, 50, 100, 80]
	            },
	            title: {
	                text: 'Henvendelser per side'
	            },
	            xAxis: {
	                categories: categories,
	                labels: {
	                    rotation: -45,
	                    align: 'right',
	                    style: {
	                        fontSize: '13px',
	                        fontFamily: 'Verdana, sans-serif'
	                    }
	                }
	            },
	            yAxis: {
	                min: 0,
	                title: {
	                    text: 'Henvendelser'
	                }
	            },
	            legend: {
	                enabled: false
	            },
	            tooltip: {
	                pointFormat: 'Henvendelser : <b>{point.y:.1f}</b>',
	            },
	            series: [{
	                name: 'Population',
	                data: serieData,
                    animation: false,
	                dataLabels: {
	                    enabled: true,
	                    rotation: -90,
	                    color: '#FFFFFF',
	                    align: 'right',
	                    x: 4,
	                    y: 10,
	                    style: {
	                        fontSize: '13px',
	                        fontFamily: 'Verdana, sans-serif',
	                        textShadow: '0 0 3px black'
	                    }
	                }
	            }]
	        });
	    });
}

function createStackedColumn(data) {

	// Taken from demo : http://jsfiddle.net/gh/get/jquery/1.9.1/highslide-software/highcharts.com/tree/master/samples/highcharts/demo/column-stacked/

	var categories = [],
		serieData = [];

	$.each(data.ages, function(index, value) {
		if (index != 'total') {
			categories.push(index);
			serieData.push(value);
		}
	});

	$(function () {
	        $('#stackedcolumn').highcharts({
	            chart: {
	                type: 'column'
	            },
	            title: {
	                text: 'Henvendelser fordelt i årstrinn'
	            },
	            xAxis: {
	                categories: categories
	            },
	            yAxis: {
	                min: 0,
	                title: {
	                    text: 'Antal henvendelser'
	                },
	                stackLabels: {
	                    enabled: true,
	                    style: {
	                        fontWeight: 'bold',
	                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
	                    }
	                }
	            },
	            legend: {
	                align: 'right',
	                x: -70,
	                verticalAlign: 'top',
	                y: 20,
	                floating: true,
	                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
	                borderColor: '#CCC',
	                borderWidth: 1,
	                shadow: false
	            },
	            tooltip: {
	                formatter: function() {
	                    return '<b>'+ this.x +'</b><br/>'+
	                        this.series.name +': '+ this.y +'<br/>'+
	                        'Total: '+ this.point.stackTotal;
	                }
	            },
	            plotOptions: {
	                column: {
	                    stacking: 'normal',
	                    dataLabels: {
	                        enabled: true,
	                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
	                    }
	                }
	            },
	            series: [{
                    animation: false,
	                name: 'Begge kjønn',
	                data: serieData
	            }]
	        });
	    });
    
	    
}

function createPie(data) {

	var male = data.sexes.Mann,
		female = data.sexes.Kvinne;

	$(function () {
	    $('#pie').highcharts({
	        chart: {
	            plotBackgroundColor: null,
	            plotBorderWidth: null,
	            plotShadow: false
	        },
	        title: {
	            text: 'Kjønnsfordeling'
	        },
	        tooltip: {
	    	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
	        },
	        plotOptions: {
	            pie: {
	                allowPointSelect: true,
	                cursor: 'pointer',
	                dataLabels: {
	                    enabled: true,
	                    color: '#000000',
	                    connectorColor: '#000000',
	                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
	                }
	            }
	        },
	        series: [{
	            type: 'pie',
	            name: 'Andel',
                animation: false,
	            data: [
	            	['Menn', male], 
	            	['Kvinner', female]
	            ]
	        }]
	    });
	});
}