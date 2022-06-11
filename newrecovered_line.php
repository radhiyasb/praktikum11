<?php
include('koneksi2.php');
$covid = mysqli_query($koneksi, "select * from country");
while($row = mysqli_fetch_array($covid)){
	$country[] = $row['country'];
	$query = mysqli_query($koneksi, "select sum(new_recovered) as new_recovered from penderita where id_country ='".$row['id_country']."'");
	$row = $query->fetch_array();
	$new_recovered[] = $row['new_recovered'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Covid New Recovered Line Chart</title>
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
					label: 'Line Chart Covid New Recovered',
					data: <?php echo json_encode($new_recovered); ?>,
					backgroundColor: 'rgba(35,250,90,0.2)',
					borderColor: 'rgba(35,250,90,1)',
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