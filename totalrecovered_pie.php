<?php
include('koneksi2.php');
$covid = mysqli_query($koneksi,"select * from tb_recovered");
while($row = mysqli_fetch_array($covid)){
	$country[] = $row['country'];
	
	$query = mysqli_query($koneksi,"select sum(total_recovered) as total_recovered from tb_recovered where id_country='".$row['id_country']."'");
	$row = $query->fetch_array();
	$total_recovered[] = $row['total_recovered'];
}
?>
<!doctype html>
<html>

<head>
	<title>Covid Pie Chart</title>
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
				datasets: [{
					data:<?php echo json_encode($total_recovered); ?>,
					backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)',
                    'rgba(126, 0, 0, 0.2)',
                    'rgba(255, 175, 0, 0.2)',
                    'rgba(31, 199, 0, 0.2)',
                    'rgba(89, 0, 199, 0.2)',
                    'rgba( 127, 255, 0, 0.2 )',
                    'rgba( 0, 100, 0, 0.2 )'
					],
					borderColor: [
					'rgba(255,99,132,1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(75, 192, 192, 1)',
                    'rgba(126, 0, 0, 1)',
                    'rgba(255, 175, 0, 1)',
                    'rgba(31, 199, 0, 1)',
                    'rgba(89, 0, 199, 1)',
                    'rgba( 127, 255, 0, 1 )',
                    'rgba( 0, 100, 0, 1 )'
					],
					label: 'Presentase Total Recovered'
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