<?php
include('koneksi2.php');
$covid = mysqli_query($koneksi, "select * from tb_recovered");
while($row = mysqli_fetch_array($covid)){
	$country[] = $row['country'];
	$query = mysqli_query($koneksi, "select sum(total_recovered) as total_recovered from tb_recovered where id_country ='".$row['id_country']."'");
	$row = $query->fetch_array();
	$total_recovered[] = $row['total_recovered'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Covid Bar Chart</title>
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
					label: 'Grafik Covid Recovered',
					data: <?php echo json_encode($total_recovered); ?>,
					backgroundColor: 'rgba(25,25,112,0.2)',
					borderColor: 'rgba(25,25,112,1)',
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