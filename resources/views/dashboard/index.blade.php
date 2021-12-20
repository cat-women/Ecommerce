<?php

$cat = array();
$total = array();
foreach ($product[0] as $var) {
  $cat[] = $var->p_name;
  $total[] = $var->total;
}
$totaluser = $product[1][1]->totaluser;
//setting variable for sales for month
?>


<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

@extends('dashboard.header')
@section('content')
<div class="row text-white ">
{{-- 
  <div class="col-lg-9 bg-white d-flex justify-content-center" id="chart">
    <canvas id="mychart"></canvas>
  </div>
  --}}
  
  <div class="col-lg-9 bg-white d-flex justify-content-center" id="chart">
  <div id="chartContainer" style="height: 300px; width: 100%;"></div>
  </div>
  <div class="row d-flex justify-content-center">
    <div class="col-lg-10  ">
      <button class=" p-5 rounded my-5 shadow-sm" id="capital_gain">
        <h4> Total capital gain (after payment </h4>
      </button>
      <button class=" p-5 rounded my-5 shadow-sm" id="totaluser">
        <h4>Total User: {{ $totaluser }} </h4>
      </button>
      <button class="btn p-5 rounded my-5 shadow-sm" id="product">
        <h4> product </h4>
      </button>
    </div>
  </div>

  <div class="col-lg-9 bg-white d-flex justify-content-center" id="otherChart">
  </div>

  <div id="chartContainer" style="height: 300px; width: 100%;"></div>
</div>



<script>
	// sales rate 
	let seriesData = [];
	seriesData = [];
	var $data = <?php echo json_encode($product[2]); ?>;
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


<script>
  /*
  // bar char of sales
  var $label = <?php echo json_encode($cat); ?>;
  var $total = <?php echo json_encode($total); ?>;

  let mychart = document.getElementById('mychart').getContext('2d');
  //global option 
  Chart.defaults.font.family = 'Lato';
  Chart.defaults.font.size = 18;
  Chart.defaults.font.color = '#0777';

  let barhcart = new Chart(mychart, {
    type: 'bar',
    data: {
      labels: $label,
      datasets: [{
        label: 'Total Sales per Catogory ',
        data: $total
      }]
    },
    backgroundColor: [
      // need some work here 
      'rgba(170, 250, 195,0.6)',
      'rgba(170, 250, 195,0.6)',
      'rgba(128, 121, 247,0.6)',
      'rgba(128, 121, 247,0.6)',
      'rgba(247, 121, 182,0.6)',
      'rgba(224, 169, 92,0.6  )'
    ],
    options: {}

  });
  //end of bar chart

  */

// For total product available 
  $(document).ready(function() {
    $('#product').on('click', function() {
      const name = [];
      const total = [];
      $.ajax({
        url: "{{ route('chart.productAvail')}}",
        method: 'POST',
        data: {
          _token: '{{ csrf_token() }}'

        },
        dataType: 'json',
        success: function(data) {
          $html = `<canvas id="otherChartCanva"> </canvas>`;
          $btn = ``;
          $.each(data, function(index, row) {
            name.push(row.p_name);
            total.push(row.total);

          });
          console.log(name);
          console.log(total);
          $("#otherChart").append($html);
          

          // bar char of sales
          let mychart = document.getElementById('otherChartCanva').getContext('2d');
          //global option 
          Chart.defaults.font.family = 'Lato';
          Chart.defaults.font.size = 18;
          Chart.defaults.font.color = '#0777';

          let barhcart = new Chart(mychart, {
            type: 'bar',
            data: {
              labels: name,
              datasets: [{
                label: 'total product available',
                data: total
              }]
            },
            backgroundColor: [
              // need some work here 
              'rgba(170, 250, 195,0.6)',
              'rgba(170, 250, 195,0.6)',
              'rgba(128, 121, 247,0.6)',
              'rgba(128, 121, 247,0.6)',
              'rgba(247, 121, 182,0.6)',
              'rgba(224, 169, 92,0.6  )'
            ],
            options: {}

          });
          //end of bar chart

        },
        error: function(xhr, status, error) {
          console.log(xhr.responseText);
        }
      });
      //End of ajax
    });
  });


  //For sales per month

</script>

<!-- End demo content -->


<!-- Total product avail ko logic milaune  -->

@endsection