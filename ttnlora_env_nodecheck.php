<?php

// needed for sendEmail
include '/home/www/ssl/env/ttnlora_env_vars.php';
include '/home/www/ssl/env/ttnlora_env_mailer.php';
include '/home/www/ssl/env/ttnlora_env_telegram.php';

// needs global $conn

function sendAlarmWarning($dev_id, $value)
{
	// choice you're tool
	global $mailfrom;
	global $telegrambotid;

	$subject = "TTNLORAENV > $dev_id IS A RUNNER!!!";
	$body = "WARNING : The node $dev_id is a RUNNER!!! ($value calls the past hour).";

	if ($mailfrom != null)
	{
		// send email
		// TODO change $to from DB -> rip apart $action
		sendEmail('lexbolkesteijn@gmail.com', $subject, $body);
	}

	if ($telegrambotid != null)
	{
		// send telegram message (299412663 = lex)
		// TODO change $chatid from DB -> rip apart $action
		sendTelegramMessage('299412663', 'ENV', $body);
	}
}




// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT DevId AS DevID, COUNT(TimestampUTC) AS Amount FROM Measurement WHERE TimestampUTC > DATE_SUB(UTC_TIMESTAMP(), INTERVAL 1 HOUR) GROUP BY DevID HAVING COUNT(TimestampUTC) > 10";

$result = $conn->query($sql);

if (!$result) {
    echo 'Invalid query: ' . $conn->error;
}

$first = true;

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) 
    {
    	if (!$first)
    	{
    		echo ",\n";
    	}
	$first = false;

	$dev_id = $row["DevID"];
	$amount = $row["Amount"];

	echo "{";
        echo "\"dev_id\":\"$dev_id\",";
        echo "\"amount\":\"$amount\"";
        echo "}\n";
	sendAlarmWarning($dev_id, $amount);
    }
} 

echo "\n]\n";
$conn->close();
?>
