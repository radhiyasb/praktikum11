<?php
include('koneksi2.php');
$covid = mysqli_query($koneksi, "select * from tb_cases");
while($row = mysqli_fetch_array($covid)){
	$country[] = $row['country'];
	$query = mysqli_query($koneksi, "select sum(total_cases) as total_cases from tb_cases where id_country ='".$row['id_country']."'");
	$row = $query->fetch_array();
	$total_cases[] = $row['total_cases'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Covid Cases Bar Chart</title>
	<script type="text/javascript" src="Chart.js"></script>
</head>
<body>
	<div style="width: 800px; height: 800px">
		<canvas id="myChart"></canvas>
	</div>

	<script>
		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: <?php echo json_encode($country); ?>,
				datasets: [{
					label: 'Grafik Covid Cases',
					data: <?php echo json_encode($total_cases); ?>,
					backgroundColor: 'rgba(25,255,112,0.2)',
					borderColor: 'rgba(25,255,112,1)',
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