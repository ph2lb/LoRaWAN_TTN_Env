<?php

include './ttnlora_env_vars.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$filter_area = null;
$filter_id = null;

if(isset($_GET['id'])) {
	$filter_id = $_GET["id"];
	$filter_id = $conn->real_escape_string($filter_id);
}

if(isset($_GET['area'])) {
	$filter_area = $_GET["area"];
	$filter_area = $conn->real_escape_string($filter_area);
}

$first = true;

$whereClause = "";

if ($filter_area != null && $filter_area != 'all') {
	$whereClause = $whereClause . "AreaID = '" . $filter_area . "' AND ";
}

if ($filter_id != null) {
	$whereClause = $whereClause . "AlarmWarning.DevID  = '" . $filter_id . "' AND ";
}


$sql = "SELECT AlarmWarning.DevID AS DevID, AlarmWarningLevel.Name AS Level, AlarmWarningType.Name AS Type, Value, TimestampUTCStart, TimestampUTCEnd, AreaID AS Area FROM AlarmWarning INNER JOIN AlarmWarningLevel ON  AlarmWarningLevel.Level = AlarmWarning.Level INNER JOIN AlarmWarningType ON  AlarmWarningType.Type = AlarmWarning.Type INNER JOIN NodeArea ON AlarmWarning.DevID = NodeArea.DevID WHERE " . $whereClause . " (TimestampUTCEnd IS NULL OR TimestampUTCEnd >  DATE_ADD(NOW(), INTERVAL -1 DAY)) ORDER BY DevId, TimestampUTCEnd, TimestampUTCStart";  

//echo "// filter_area = ". $filter_area;
//echo "// sql = ". $sql;

echo "var lastalarmwarnings = [\n";
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

	$devid = $row["DevID"];
	$level = $row["Level"];
	$type = $row["Type"];
	$value = $row["Value"];
	$timestart = $row["TimestampUTCStart"];
	$timeend = $row["TimestampUTCEnd"];
	$area = $row["Area"];

	$value = "['$devid','$level','$type','$value','$timestart','$timeend','$area']";
        echo "    $value";
    }
} 

echo "\n];\n";
$conn->close();
?>
