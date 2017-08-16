<?php

include './ttnlora_env_vars.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$filter_area = null;

if(isset($_GET['area'])) {
	$filter_area = $_GET["area"];
	$filter_area = $conn->real_escape_string($filter_area);
}

$first = true;
if ($filter_area != null && $filter_area != 'all') {
$sql = "SELECT m1.DevID AS Code, m1.TimestampUTC AS Time, m1.RSSI AS Rssi, m1.Temperature AS Temp, m1.Humidity AS Humidity, m1.Pressure AS Pressure, m1.Batt AS Batt, n.Latitude AS Latitude, n.Longitude AS Longitude, na.AeraID as Area, n.Description AS Description FROM Measurement m1 INNER JOIN (SELECT mi.DevID as DevID, MAX(mi.TimestampUTC) AS maxtimestamp FROM Measurement mi GROUP BY mi.DevID) m2 ON (m1.TimestampUTC = m2.maxtimestamp AND m1.DevID = m2.DevID) INNER JOIN Node n ON n.DevID = m1.DevID INNER JOIN NodeArea na ON m1.DevID = na.DevID WHERE na.AeraID = '" . $filter_area . "'";
} else {
$sql = "SELECT m1.DevID AS Code, m1.TimestampUTC AS Time, m1.RSSI AS Rssi, m1.Temperature AS Temp, m1.Humidity AS Humidity, m1.Pressure AS Pressure, m1.Batt AS Batt, n.Latitude AS Latitude, n.Longitude AS Longitude, na.AeraID as Area , n.Description AS Description FROM Measurement m1 INNER JOIN (SELECT mi.DevID as DevID, MAX(mi.TimestampUTC) AS maxtimestamp FROM Measurement mi GROUP BY mi.DevID) m2 ON (m1.TimestampUTC = m2.maxtimestamp AND m1.DevID = m2.DevID) INNER JOIN Node n ON n.DevID = m1.DevID INNER JOIN NodeArea na ON m1.DevID = na.DevID";
}

//echo "// filter_area = ". $filter_area;
//echo "// sql = ". $sql;

echo "var lastmeasurment = [\n";
$result = $conn->query($sql);

if (!$result) {
    echo 'Invalid query: ' . $conn->error;
}

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) 
    {
    	if (!$first)
    	{
    		echo ",\n";
    	}
	$first = false;

	$code = $row["Code"];
	$time = $row["Time"];
	$rssi = $row["Rssi"];
	$temp = $row["Temp"];
	$humidity = $row["Humidity"];
	$pressure = $row["Pressure"];
	$batt = $row["Batt"];
	$lat = $row["Latitude"];
	$lng = $row["Longitude"];
	$area = $row["Area"];
	$description = $row["Description"];

	$value = "['$code','$time','$rssi','$lat','$lng', '$temp', '$humidity', '$pressure', '$batt', '$area', '$description']";
        echo "    $value";
    }
} 

echo "\n];\n";
$conn->close();
?>
