<?php
    $entityBody = file_get_contents('php://input');
    $logfile = '/tmp/ttnlora_env.log';
    $content = "$entityBody\r\n";
    file_put_contents($logfile, $content, FILE_APPEND | LOCK_EX);


include './ttnlora_env_vars.php';

$headers = apache_request_headers();

foreach ($headers as $header => $value) {
    echo "$header: $value <br />\n";
}

if (!isset($headers['apikey'])) {
	die("apikey is not set");
}

if ($headers['apikey'] != $apikey) {
	die("apikey isn't what it should be");
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// {"payload":"LSgCcQAA","fields":{"batt":4.5,"bytes":"LSgCcQAA","humidity":40,"pkcount":0,"temperature":22.5,"txresult":0,"txretrycount":0},"port":1,"counter":0,"dev_eui":"0004A30B001AD790","metadata":[{"frequency":867.5,"datarate":"SF7BW125","codingrate":"4/5","gateway_timestamp":3992695868,"channel":5,"server_time":"2016-11-11T10:34:10.458885697Z","rssi":-81,"lsnr":6.8,"rfchain":0,"crc":1,"modulation":"LORA","gateway_eui":"1DEE026C7BFC3E5C","altitude":44,"longitude":6.83681,"latitude":52.2402}]}

// http://www.mapcoordinates.net/en

$dev_id = "NULL";
$time = "NULL";
$batt = "NULL";
$humidity = "NULL";
$temperature = "NULL";
$rssi = "NULL";
$ldr = "NULL";
$framecounter = "NULL" ;
$packetcounter = "NULL";
$txresult = "NULL";
$txretrycount = "NULL";
$pressure = "NULL";

function getData($parent,$arr)
{
	global $dev_id,$batt,$humidity,$pressure,$time,$temperature,$rssi,$ldr,$framecounter,$packetcounter,$txresult,$txretrycount;
	foreach($arr as $key => $value)
	{
		if (is_numeric($value))
		{
			if ($parent == "payload_fields")
			{
				switch($key) {
					case "batt" : $batt = $value; break;
					case "rssi" : $rssi = $value; break;
					case "humidity" : $humidity = $value; break;
					case "pressure" : $pressure = $value; break;
					case "temperature": $temperature = $value; break;
					case "pkcount": $packetcounter = $value; break;
					case "txresult": $txresult = $value; break;
					case "txretrycount": $txretrycount = $value; break;
				}
			}
			else	
			{
				switch($key) {
					case "counter": $framecounter = $value; break;
				}
			}
		}
		else if (is_array($value))
		{
			getData($key, $value);
		}
		else if (is_object($value))
		{
			getData($key, $value);
		}
		else 
		{
			if ($parent == "metadata" && !is_numeric($parent))
			{
				//echo "1.key = $key\n";
				switch($key) {
					case "time" : $time = $value; break;
				}
			}
			else
			{
				//echo "2.key = $key\n";
				switch($key) {
					case "dev_id" : $dev_id = $value; break;
					case "app_id" : $app_id = $value; break;
					case "rssi" : $rssi = $value; break;
				}
			}
		} 
	}	
}

$my_arr = json_decode($content);
getData("", $my_arr);

if ($pressure > 1030)
	$pressure = 'NULL';

if ($time != "NULL" && $dev_id != "NULL")
{
	$time = str_replace("Z", "", $time);
	$sql = "INSERT INTO Measurement (TimestampUTC, DevID, Temperature, Humidity, Pressure, Batt, RSSI, Raw) VALUES ('$time', '$dev_id', $temperature, $humidity, $pressure, $batt, $rssi, '$content')";
	
	if ($conn->query($sql) === TRUE) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
}
else
{
	echo "Nothing to do.";
}
$conn->close();
?>
