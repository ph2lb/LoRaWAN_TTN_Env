<?php

// DEZE MOET JE FF AANPASSEN
include './ttnlora_env_vars.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$filter_id = $_GET["id"];
$filter_from = $_GET["from"];
$filter_to = $_GET["to"];

$filter_id = $conn->real_escape_string($filter_id);
$filter_from = $conn->real_escape_string($filter_from);
$filter_to = $conn->real_escape_string($filter_to);

// hardcoded overrule
//$filter_id = '0004a30b001ad790';
$filter_to = new DateTime();
$dt = new DateTime();
$dt->modify("-1 day");
$filter_from = $dt;
$filter_to = $filter_to->format("Y-m-d H:i:s");
$filter_from = $filter_from->format("Y-m-d H:i:s");

echo "[\n";

$first = true;

$sql = "SELECT DevID AS Code, TimestampUTC AS Time, RSSI AS Rssi, Temperature AS Temp, Humidity AS Humidity, Pressure AS Pressure, Batt AS Batt FROM Measurement WHERE DevID = '$filter_id' AND TimeStampUTC >= '$filter_from' AND TimeSTampUTC <= '$filter_to'";

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


	echo "{";
        echo "\"dev_id\":\"$code\",";
        echo "\"time\":\"$time\",";
        echo "\"rssi\":\"$rssi\",";
        echo "\"batt\":\"$batt\",";
        echo "\"temperature\":\"$temp\",";
        echo "\"humidity\":\"$humidity\",";
        echo "\"pressure\":\"$pressure\"";
        echo "}\n";
    }
} 

echo "\n]\n";
$conn->close();
?>
