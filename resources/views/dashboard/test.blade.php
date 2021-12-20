<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<div id="chartContainer" style="height: 300px; width: 100%;"></div>

<script>
	// testing variable

	let seriesData = [];
	seriesData = [];
	var $data = <?php echo json_encode($data); ?>;
	for (let i = 0; i < $data.length; i++) {
		seriesData.push({
			//x: moment($data[i].created_at).format('DD MMM YYYY'),
			x: new Date(moment($data[i].created_at).format('DD MMM YYYY')),
			y: Number($data[i].total)
		});

	}
	//chart start 
	window.onload = function() {

		var chart = new CanvasJS.Chart("chartContainer", {
			animationEnabled: true,
			title: {
				text: "Sales rate"
			},
			axisY: {
				title: "Sales",
				valueFormatString: "",
				suffix: "",
				prefix: ""
			},
			data: [{
				type: "splineArea",
				color: "rgba(54,158,173,.7)",
				markerSize: 5,
				xValueFormatString: "DD MM YYYY",
				yValueFormatString: "#",
				dataPoints: seriesData
			}]
		});
		chart.render();

	}
</script>