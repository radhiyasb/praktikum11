<?php
include('koneksi2.php');
$covid = mysqli_query($koneksi, "select * from country");
while($row = mysqli_fetch_array($covid)){
	$country[] = $row['country'];
	$query = mysqli_query($koneksi, "select sum(total_death) as total_death from penderita where id_country ='".$row['id_country']."'");
	$row = $query->fetch_array();
	$total_death[] = $row['total_death'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Covid Total Death Line Chart</title>
	<script type="text/javascript" src="Chart.js"></script>
</head>
<body>
	<div style="width: 800px; height: 800px">
		<canvas id="myChart"></canvas>
	</div>

	<script>
		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'line',
			data: {
				labels: <?php echo json_encode($country); ?>,
				datasets: [{
					label: 'Line Chart Covid Total Death',
					data: <?php echo json_encode($total_death); ?>,
					backgroundColor: 'rgba(20, 60, 122, 0.2)',
					borderColor: 'rgba(20, 60, 122, 1)',
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		})
	</script>

</body>
</html>