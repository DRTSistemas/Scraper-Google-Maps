$(function() {

	//
	// Bars chart
	//

	var BarsChart = (function() {

		//
		// Variables
		//

		var $chart = $('#chart-bars');


		//
		// Methods
		//

		// Init chart
		function initChart($chart) {

			var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

			var today = new Date();
			var d;
			var monthChart = [],
				dataChart  = [];


			for(var i = 6; i > 0; i -= 1) {
				d = new Date(today.getFullYear(), today.getMonth() - i + 1, 1);
				monthChart.push(monthNames[d.getMonth()]);
				dataChart.push(0);
			}

			console.log(monthChart, dataChart);

			$.get("/chart", function(response) {
				console.log(response);
				$.each(response, function (key, item) {
					console.log(item);
					let date = new Date(key + '-15');
					let monthy = date.toLocaleString('en-us', { month: 'short' });
					console.log(date, monthy);
					let search = monthChart.indexOf(monthy);

					console.log(date, monthy, search);

			    	if(search > -1) {
						dataChart[search] = item;
					}
			    });

			    console.log(monthChart, dataChart);

			    console.log('=================');
				console.log(dataChart);

				// Create chart
				var ordersChart = new Chart($chart, {
					type: 'bar',
					data: {
						labels: monthChart,
						datasets: [{
							label: 'Value',
							data: dataChart
						}]
					},
					options: {
					    scales: {
					      yAxes: [{
					        id: 'A',
					        type: 'linear',
					        position: 'left',
					      }]
					    }, 
					      annotation: {
					        annotations: [{
					        type: 'line',
					        mode: 'horizontal',
					        scaleID: 'A',
					        value: 5000,
					        borderColor: 'rgb(75, 0, 0)',
					        borderWidth: 4,
					        label: {
					          enabled: false,
					          content: 'Test label'
					        }
					      }]
					    }
				  	}
				});

				// Save to jQuery object
				$chart.data('chart', ordersChart);
			});

		}


		// Init chart
		if ($chart.length) {
			initChart($chart);
		}

	})();

});