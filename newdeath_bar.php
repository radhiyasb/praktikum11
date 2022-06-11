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
	<title>Covid New Death Bar Chart</title>
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
					label: 'Bar Chart Covid New Death',
					data: <?php echo json_encode($new_death); ?>,
					backgroundColor: 'rgba(140, 75, 150, 0.2)',
					borderColor: 'rgba(140, 75, 150, 1)',
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