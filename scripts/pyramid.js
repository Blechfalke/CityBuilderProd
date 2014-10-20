
function createPyramid(){

	// Load the fonts
	Highcharts.createElement('link', {
	   href: 'http://fonts.googleapis.com/css?family=Unica+One',
	   rel: 'stylesheet',
	   type: 'text/css'
	}, null, document.getElementsByTagName('head')[0]);
	
	Highcharts.theme = {
	   colors: ["#DBDBDB", "#C5E0B4", "#FF5050", "#9DC3E6", "#FBE5D6", "#CC99FF", "#FFF2CC",
	      "#55BF3B", "#DF5353", "#7798BF", "#aaeeee"],
	   
	   chart: {
	      backgroundColor: 'rgba(255, 255, 255, 0)' ,
	
	      style: {
	         fontFamily: "'Verdana', sans-serif"
	      },
	      plotBorderColor: '#606063'
	   },
	   title: {
	      style: {
	         color: '#E0E0E3',
	         textTransform: 'uppercase',
	         fontSize: '20px'
	      }
	   },
	   subtitle: {
	      style: {
	         color: '#E0E0E3',
	         textTransform: 'uppercase'
	      }
	   },
	   xAxis: {
	      gridLineColor: '#707073',
	      labels: {
	         style: {
	            color: '#E0E0E3'
	         }
	      },
	      lineColor: '#707073',
	      minorGridLineColor: '#505053',
	      tickColor: '#707073',
	      title: {
	         style: {
	            color: '#A0A0A3'
	
	         }
	      }
	   },
	   yAxis: {
	      gridLineColor: '#707073',
	      labels: {
	         style: {
	            color: '#E0E0E3'
	         }
	      },
	      lineColor: '#707073',
	      minorGridLineColor: '#505053',
	      tickColor: '#707073',
	      tickWidth: 1,
	      title: {
	         style: {
	            color: '#A0A0A3'
	         }
	      }
	   },
	   tooltip: {
		   borderWidth: 0,
		   shadow:false,
	      backgroundColor: 'rgba(0, 0, 0, 0)',
	      style: {
	         color: 'rgba(0, 0, 0, 0)'
	      }
	   },
	   plotOptions: {
	      series: {
	         dataLabels: {
	            color: '#B0B0B3'
	         },
	         marker: {
	            lineColor: '#333'
	         }
	      },
	      boxplot: {
	         fillColor: '#505053'
	      },
	      candlestick: {
	         lineColor: 'white'
	      },
	      errorbar: {
	         color: 'white'
	      }
	   },
	   legend: {
	      itemStyle: {
	         color: '#E0E0E3'
	      },
	      itemHoverStyle: {
	         color: '#FFF'
	      },
	      itemHiddenStyle: {
	         color: '#606063'
	      }
	   },
	   credits: {
	      style: {
	         color: '#666'
	      }
	   },
	   labels: {
	      style: {
	         color: '#707073'
	      }
	   },
	
	   drilldown: {
	      activeAxisLabelStyle: {
	         color: '#F0F0F3'
	      },
	      activeDataLabelStyle: {
	         color: '#F0F0F3'
	      }
	   },
	
	   navigation: {
	      buttonOptions: {
	         symbolStroke: '#DDDDDD',
	         theme: {
	            fill: '#505053'
	         }
	      }
	   },
	
	   // scroll charts
	   rangeSelector: {
	      buttonTheme: {
	         fill: '#505053',
	         stroke: '#000000',
	         style: {
	            color: '#CCC'
	         },
	         states: {
	            hover: {
	               fill: '#707073',
	               stroke: '#000000',
	               style: {
	                  color: 'white'
	               }
	            },
	            select: {
	               fill: '#000003',
	               stroke: '#000000',
	               style: {
	                  color: 'white'
	               }
	            }
	         }
	      },
	      inputBoxBorderColor: '#505053',
	      inputStyle: {
	         backgroundColor: '#333',
	         color: 'silver'
	      },
	      labelStyle: {
	         color: 'silver'
	      }
	   },
	
	   navigator: {
	      handles: {
	         backgroundColor: '#666',
	         borderColor: '#AAA'
	      },
	      outlineColor: '#CCC',
	      maskFill: 'rgba(255,255,255,0.1)',
	      series: {
	         color: '#7798BF',
	         lineColor: '#A6C7ED'
	      },
	      xAxis: {
	         gridLineColor: '#505053'
	      }
	   },
	
	   scrollbar: {
	      barBackgroundColor: '#808083',
	      barBorderColor: '#808083',
	      buttonArrowColor: '#CCC',
	      buttonBackgroundColor: '#606063',
	      buttonBorderColor: '#606063',
	      rifleColor: '#FFF',
	      trackBackgroundColor: '#404043',
	      trackBorderColor: '#404043'
	   },
	
	   // special colors for some of the
	   legendBackgroundColor: 'rgba(0, 0, 0, 0.5)',
	   background2: '#505053',
	   dataLabelsColor: '#B0B0B3',
	   textColor: '#C0C0C0',
	   contrastTextColor: '#F0F0F3',
	   maskColor: 'rgba(255,255,255,0.3)'
	};
	
	//updatePyramid(1,1,1,1,1,1,1);

};  

function updatePyramid(slaves, peasants, soldiers, craftsmen, scribes, priests, kings){
	
	var total = Number(slaves) + Number(peasants) + Number(soldiers) + Number(craftsmen) + Number(scribes) + Number(priests) + Number(kings);
	
	//alert('slaves:'+slaves+', peasants:'+peasants+', soldier:'+soldiers+', craftsmen:'+craftsmen+', scribes:'+scribes+', priests:'+priests+', kings:'+kings+', total:'+total);
	//Apply the theme
	Highcharts.setOptions(Highcharts.theme);
	slaves = oneCheck(slaves, total);
	peasants = oneCheck(peasants, total);
	soldiers = oneCheck(soldiers, total);
	craftsmen = oneCheck(craftsmen, total);
	scribes = oneCheck(scribes, total);
	priests = oneCheck(priests, total);
	kings = oneCheck(kings, total);
	
	
	    $('#Diagram').highcharts({
	        chart: {
	            type: 'pyramid',
	            marginRight: 100
	        },
	        title: {
	            text: ' ',
	            x: -50
	        },
	        legend: {
	            enabled: false
	        },
	        series: [{
	            name: 'Population',
	            data: [ 
	            	['Slaves',   Number(slaves)],
	                ['Peasants',       Number(peasants)],
	                ['Soldiers', Number(soldiers)],
	                ['Craftsmen',    Number(craftsmen)],
	                ['Scribes',    Number(scribes)],
					['Priests',    Number(priests)],
					['Kings',    Number(kings)]
	            ]
	        }]
	    });
}

function oneCheck(test, total){
	var result = (test / total)
	
	var valReturn = result;
	if(result > 0.625){
		valReturn = 0.625;
		//alert('result:'+0.62+', total:'+valReturn);
	}
	if(result < 0.0625){
		valReturn = 0.0625;
		//alert('result:'+0.62+', total:'+valReturn);
	}
	//alert(result);
	return valReturn * 10000;
	}