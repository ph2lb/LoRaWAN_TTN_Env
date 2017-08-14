<?php

// DEZE MOET JE FF AANPASSEN
include './ttnlora_env_vars.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


echo "var availableAreas  = [\n";
echo "    'all'";
$sql = "SELECT DISTINCT(AreaID) AS Area FROM Area";

$result = $conn->query($sql);

if (!$result) {
    echo 'Invalid query: ' . $conn->error;
}

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) 
    {
    	echo ",\n";
	$first = false;
	$value = $row["Area"];
        echo "    '$value'";
    }
} 

echo "\n];\n";
$conn->close();
?>
