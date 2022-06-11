<?php
include('koneksi2.php');
$covid = mysqli_query($koneksi, "select * from country");
while($row = mysqli_fetch_array($covid)){
	$country[] = $row['country'];
	$query = mysqli_query($koneksi, "select sum(new_cases) as new_cases from penderita where id_country ='".$row['id_country']."'");
	$row = $query->fetch_array();
	$new_cases[] = $row['new_cases'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Covid New Cases Doughnut Chart</title>
	<script type="text/javascript" src="Chart.js"></script>
</head>
<body>
	<div id="canvas-holder" style="width:50%">
		<canvas id="chart-area"></canvas>
	</div>
	<script>
		var config = {
			type: 'doughnut',
			data: {
				labels: <?php echo json_encode($country); ?>,
				datasets: [{
					label: 'Doughnut Chart Covid New Cases',
					data: <?php echo json_encode($new_cases); ?>,
					backgroundColor: [
					'#29d0b0',
					'#ffdab9',
					'#F07124',
					'#bce0e3',
					'#d3d3d3',
					'#ffd700',
					'#f0e68c',
					'#DB7093',
					'#5f9ea0',
					'#FFFFE0'
					],
					borderColor: [
					'#29d0b0',
					'#ffdab9',
					'#F07124',
					'#bce0e3',
					'#d3d3d3',
					'#ffd700',
					'#f0e68c',
					'#DB7093',
					'#5f9ea0',
					'#FFFFE0'
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
			window.myDoughnut = new Chart(ctx, config);
		};

		document.getElementById('randomizeData').addEventListener('click', function() {
			config.data.datasets.forEach(function(dataset) {
				dataset.data = dataset.data.map(function() {
					return randomScalingFactor();
				});
			});

			window.myDoughnut.update();
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
			window.myDoughnut.update();
		});

		document.getElementById('removeDataset').addEventListener('click', function() {
			config.data.datasets.splice(0, 1);
			window.myDoughnut.update();
		});
	</script>
</body>

</html>