<html> 
  <?php
	// include the global vars
	// default
	$filter_id = "0004a30b001ad790";
	$filter_from = NULL;
	$filter_to = NULL;

	if (isset($_GET["id"])) 
	{
		$filter_id = $_GET["id"];
	}

	if (isset($_GET["to"])) 
	{
		$filter_to = $_GET["to"];
	}
	else 
	{
		$filter_to = new DateTime();
		$filter_to = $filter_to->format("Y-m-d H:i:s");
	}
	
	if (isset($_GET["from"])) 
	{
		$filter_from = $_GET["from"];
	}
	else
	{
		$dt = new DateTime();
		$dt->modify("-1 day");
		$filter_from = $dt;
		$filter_from = $filter_from->format("Y-m-d H:i:s");
	}

  	echo '<script type="text/javascript">';
	echo 'var filter_id = "' . $filter_id . '";';
	echo 'var filter_from = "' . $filter_from . '";';
	echo 'var filter_to = "' . $filter_to . '";';
	echo '</script>';
  ?>
<head> 
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
  <title>TTN Enviromental chart</title> 

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
<body>
	<center>
    	<h3>TTN sensor chart map</h3>
  <?php
	echo '<p>For TTN sensor : ' . $filter_id ;
	echo '  from : '. $filter_from .' to : '. $filter_to ;
	echo '</p>';
	echo '<p>Switch view to last : ';
	// create new span
	$view_to = new DateTime();
	$view_to = $view_to->format("Y-m-d H:i:s");

	$days = array(-1, -2, -7, -14, -28);

	foreach($days as $span) 
	{
		$dt = new DateTime();
		$dt->modify($span .' day');
		$view_from = $dt;
		$view_from = $view_from->format("Y-m-d H:i:s");
	
		echo '<a href="ttnlora_env_chart.php?id='. $filter_id .'&from='. $view_from .'&to='. $view_to .'">['. $span*-1 .' days]</a> ';
	}
	echo '<a href="ttnlora_env_map.php">(back to map)</a> ';
	echo '</p>';
  ?>
	</center>
	<!-- HTML -->
	<div id="chartdiv"></div>
	<script src="./ttnlora_env_chart_embedded.js"></script>
</body>
</html>
