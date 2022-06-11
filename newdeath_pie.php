<?php
include('koneksi2.php');
$covid = mysqli_query($koneksi, "select * from country");
while($row = mysqli_fetch_array($covid)){
	$country[] = $row['country'];
	$query = mysqli_query($koneksi, "select sum(new_death) as new_death from penderita where id_country ='".$row['id_country']."'");
	$row = $query->fetch_array();
	$new_death[] = $row['new_death'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Covid New Death Pie Chart</title>
	<script type="text/javascript" src="Chart.js"></script>
</head>
<body>
	<div id="canvas-holder" style="width:50%">
		<canvas id="chart-area"></canvas>
	</div>
	<script>
		var config = {
			type: 'pie',
			data: {
				labels: <?php echo json_encode($country); ?>,
				datasets: [{
					label: 'Pie Chart Covid New Death',
					data: <?php echo json_encode($new_death); ?>,
					backgroundColor: [
					'rgba(250, 99, 132, 0.2)',
					'rgba(54, 160, 235, 0.2)',
					'rgba(255, 206, 80, 0.2)',
					'rgba(120, 20, 90, 0.2)',
                    'rgba(40, 30, 280, 0.2)',
                    'rgba(200, 175, 0, 0.2)',
                    'rgba(30, 190, 0, 0.2)',
                    'rgba(80, 0, 180, 0.2)',
                    'rgba( 20, 40, 0, 0.2 )',
                    'rgba( 0, 100, 0, 0.2 )'
					],
					borderColor: [
					'rgba(250,99,132,1)',
					'rgba(54, 160, 235, 1)',
					'rgba(255, 206, 80, 1)',
					'rgba(120, 20, 90, 1)',
                    'rgba(40, 30, 280, 1)',
                    'rgba(200, 175, 0, 1)',
                    'rgba(30, 190, 0, 1)',
                    'rgba(80, 0, 180, 1)',
                    'rgba( 20, 40, 0, 1 )',
                    'rgba( 0, 100, 0, 1 )'
					],
					label: 'Presentase New Cases'
				}],
				labels: <?php echo json_encode($country); ?>},
			options: {
				responsive: true
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('chart-area').getContext('2d');
			window.myPie = new Chart(ctx, config);
		};

		document.getElementById('randomizeData').addEventListener('click', function() {
			config.data.datasets.forEach(function(dataset) {
				dataset.data = dataset.data.map(function() {
					return randomScalingFactor();
				});
			});

			window.myPie.update();
		});

		var colorNames = Object.keys(window.chartColors);
		document.getElementById('addDataset').addEventListener('click', function() {
			var newDataset = {
				backgroundColor: [],
				data: [],
				label: 'New dataset ' + config.data.datasets.length,
			};

			for (var index = 0; index < config.data.labels.length; ++index) {
				newDataset.data.push(randomScalingFactor());

				var colorName = colorNames[index % colorNames.length];
				var newColor = window.chartColors[colorName];
				newDataset.backgroundColor.push(newColor);
			}

			config.data.datasets.push(newDataset);
			window.myPie.update();
		});

		document.getElementById('removeDataset').addEventListener('click', function() {
			config.data.datasets.splice(0, 1);
			window.myPie.update();
		});
	</script>
</body>

</html>