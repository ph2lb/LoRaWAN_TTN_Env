<html> 
<head> 
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
  <title>TTN Enviromental chart 0004a30b001ad790</title> 

	<!-- Styles -->
	<style>
	#chartdiv {
		width	: 80%;
		height	: 500px;
	}																	
	</style>
	
	<!-- Resources -->
	<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
	<script src="https://www.amcharts.com/lib/3/serial.js"></script>
	<script src="https://www.amcharts.com/lib/3/plugins/dataloader/dataloader.min.js"></script>
	<!-- <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script> -->
	<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
	<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
</head> 
  <?php
	// include the global vars
	// default
	$filter_id = "0004a30b001ad790";
	if(isset($_GET['id'])) {
    	// id index exists
		$filter_id = $_GET["id"];
	}
  	echo '<script type="text/javascript">';
	echo 'var filter_id = "' . $filter_id . '";';
	echo '</script>';
  ?>
<body>
	<center>
    	<h3>TTN sensor chart map</h3>
  <?php
	echo '<p>For TTN sensor : ' . $filter_id .'</p>';
  ?>
	</center>
	<!-- HTML -->
	<div id="chartdiv"></div>
	<script src="./ttnlora_env_chart_embedded.js"></script>
</body>
</html>
