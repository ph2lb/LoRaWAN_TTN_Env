<html> 
<head> 
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
  <title>TTN Enviromental map</title> 
  <?php
	// include the global vars
	include './ttnlora_env_vars.php';
  	//<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmN7mtrcr4b6c6PtGUUmxknZvk5cUnmWI" type="text/javascript"></script>
  	echo '<script src="https://maps.googleapis.com/maps/api/js?key=';
	echo $googleMapApiKey;
	echo '" type="text/javascript"></script>';
  ?>
	<style>
	#chartdiv {
		width	: 80%;
		height	: 500px;
	}																	
	</style>

 <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <!-- local stuff -->
  <?php
	$filter_area = null;
	if(isset($_GET['area'])) {
		$filter_area = $_GET["area"];
	}
  	echo'<script src="./ttnlora_env_last.php?area='.$filter_area.'" type="text/javascript"></script>';
  	echo '<script>';
	echo "var selected_area = '$filter_area';\n";
  	echo '</script>';
  ?>
  <script src="./ttnlora_env_areas.php"></script>

<script>
	function zeroPad(num, places) {
  		var zero = places - num.toString().length + 1;
  		return Array(+(zero > 0 && zero)).join("0") + num;
	}

	function setSelectedValue(selectObj, valueToSet) {
    		for (var i = 0; i < selectObj.options.length; i++) {
        		if (selectObj.options[i].text== valueToSet) {
            			selectObj.options[i].selected = true;
            			return;
        		}
    		}
	}

  $( function() {

        console.log("function called start");
	var $areapicker = $('#areapicker');
	$.each(availableAreas, function(val, text) 
	{
		var itemval = text;
		$areapicker.append( $('<option></option>').val(itemval).html(itemval) )
	});

	$areapicker.val(selected_area);

	var $refreshbutton = $('#refreshbutton');
        $refreshbutton.click(function() {
		var e = document.getElementById('areapicker');
		var area = e.options[e.selectedIndex].value;
      		window.location.href = "ttnlora_env_map.php?area=" + area;
	});
        console.log("function called ended");
  } );
</script>
</head> 
<body>
<center>
    <h3>TTN Enviromental map</h3>
    <p>Overzicht van de TTN Enviromenal sensoren.</p>
    <label for="arealabel">Select a area</label>
    <select name="area" id="areapicker"></select>
    <button name="refresh" id="refreshbutton">Refresh</button>
</center>
  <div id="container" style="margin-right:100px;">
    <div id="map" style="float:left; width:100%; height:615;"></div>
    <div id="colormap" style="float:right; width:100px; margin-right:-100px; height:615;"></div>
    <div id="cleared" style="clear:both;"></div>
  </div>
  <div>
	<div id="datatable"></div>
  </div>
  <!-- <div id="chartdivheader"> <center>Sensor X</center> </div>
  <div id="chartdiv" style="height:500px;"></div> -->
  <script src="./ttnlora_env_vars.js" type="text/javascript"></script>
  <script src="./ttnlora_env_map_code.js" type="text/javascript"></script>
  <!--<script src="./ttnlora_env_chart_embedded.js" type="text/javascript"></script> -->

<style>
#datatable table {
    font-family: Arial;
  border: 1px solid #ccc;
  border-collapse: collapse;
}

#datatable table td, #datatable table th {
  padding: 5px 9px;
  border: 1px solid #eee;
  text-align: left;
}

#datatable table tr:nth-child(even) td {
  background: #eee;
}
</style>
  <script src="./ttnlora_env_map_table.js" type="text/javascript"></script>
  </body>
</html>
