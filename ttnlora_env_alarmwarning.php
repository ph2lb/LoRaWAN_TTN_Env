<?php

// needed for sendEmail
include './ttnlora_env_mailer.php';
include './ttnlora_env_telegram.php';

// needs global $conn

function levelToStr($level)
{
	// Alarm=0, Warning=1
	if ($level == 0) return "Alarm";
	else if ($level == 1) return "Warning";
	return "Uknown";
}
function typeToStr($type)
{
	// Temp=0, Humidty=1, Pressure=2, Batt=3, RSSI=4
	if ($type == 0) return "TempLower";
	else if ($type == 1) return "TempUpper";
	else if ($type == 2) return "HumidityLower";
	else if ($type == 3) return "HumidityUpper";
	else if ($type == 4) return "PressureLower";
	else if ($type == 5) return "PressureUpper";
	else if ($type == 6) return "BattLower";
	else if ($type == 7) return "BattUpper";
	else if ($type == 8) return "RSSILower";
	else if ($type == 9) return "RSSIUpper";
	return "Uknown";
}

function unitToType($unit)
{
	$type = -1;
	// Temp=0, Humidty=1, Pressure=2, Batt=3, RSSI=4
	if ($unit == "TempLower") $type = 0;
	else if ($unit == "TempUpper") $type = 1;
	else if ($unit == "HumidityLower") $type = 2;
	else if ($unit == "HumidityUpper") $type = 3;
	else if ($unit == "PressureLower") $type = 4;
	else if ($unit == "PressureUpper") $type = 5;
	else if ($unit == "BattLower") $type = 6;
	else if ($unit == "BattUpper") $type = 7;
	else if ($unit == "RSSILower") $type = 8;
	else if ($unit == "RSSIUpper") $type = 9;

	//echo "unit : $unit > type : $type\n";
	return $type;
}

function sendAlarmWarning($dev_id, $level, $type, $value, $raise, $timestamputcstart, $timestamputcend, $action)
{
	// choice you're tool
	global $mailfrom;
	global $telegrambotid;

	$typeStr = typeToStr($type);
	$levelStr = levelToStr($level);
		
	if ($raise)
	{
		$subject = "$dev_id : New $levelStr of type $typeStr";	
		$body = "For node $dev_id on $timestamputcstart a $levelStr of type $typeStr was raised for the value of $value.";
	}
	else
	{
		$subject = "$dev_id : End of $levelStr of type $typeStr";
		$body = "For node $dev_id the $levelStr of type $typeStr raised on $timestamputcstart was ended on $timestamputcend for the value of $value.";
	}

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

function handleAlarmWarning($dev_id, $level, $type, $value, $raise, $time, $action)
{
	// check if there is a open alarm for this kind of unit
	global $conn;

	$sql = "SELECT DevID, Level, Type, TimestampUTCStart, TimestampUTCEnd FROM AlarmWarning WHERE DevID = '$dev_id' AND Level = '$level' AND Type = '$type' AND TimestampUTCEnd IS NULL";

	//echo "SQL : $sql\n";
	$result = $conn->query($sql);

	if (!$result) 
	{
    		error_log('Invalid query: ' . $conn->error);
	}

	if ($result->num_rows > 0) 
	{
		echo "open alarm/warning\n";
    		while($row = $result->fetch_assoc()) 
    		{
			//var_dump($row);
			// we need timestamputcstart because we don't want to reset all the other alarms and warnings in the history
        		$timestamputcstart = $row["TimestampUTCStart"];	
			if (!$raise)
			{
				echo "should close alarmwarning DevID = '$dev_id' AND Level = $level AND Type = $type\n";
				$sql = "UPDATE AlarmWarning SET TimestampUTCEnd='$time' WHERE DevID = '$dev_id' AND Level = $level AND Type = $type AND TimestampUTCStart = '$timestamputcstart'";
				//echo "SQL > $sql\n";
				if ($conn->query($sql) === TRUE) {
    					echo "Record updated successfully\n";
					// TODO : send notification
					sendAlarmWarning($dev_id, $level, $type, $value, $raise, $timestamputcstart, $time, $action);
				} else {
    					error_log("Error updating record: " . $conn->error);
				}
			}
			else
			{
				echo "still alarmwarning DevID = '$dev_id' AND Level = $level AND Type = $type\n";
			}
		}
	}
	else
	{
		if ($raise)
		{
			error_log("create alarm/warning");
			$sql = "INSERT INTO AlarmWarning (DevID, Level, Type, Value, TimestampUTCStart, TimestampUTCEnd ) VALUES ('$dev_id', $level, $type, $value, '$time', NULL)";
				
			if ($conn->query($sql) === TRUE) {
				echo "New record created successfully\n";
				// TODO : send email
				sendAlarmWarning($dev_id, $level, $type, $value, $raise, $time, NULL, $action);
			} else {
				error_log("Error: " . $sql . "<br>" . $conn->error);
			}
		}
	}
}

function checkLimits($dev_id, $level, $unit, $time, $value, $lowerLimit, $upperLimit, $action)
{
	global $conn;
	if (!empty($lowerLimit))
	{
		echo "$unit lower : $value <= $lowerLimit : ";
		$result = ($value <= $lowerLimit);
		$resultstr = $result ? 'true' : 'false';
		echo "$resultstr\n";
		handleAlarmWarning($dev_id, $level, unitToType($unit . 'Lower'), $value, $result, $time, $action);
	}

	if (!empty($upperLimit))
	{
		echo "$unit upper : $value >= $upperLimit : ";
		$result = ($value >= $upperLimit);
		$resultstr = $result ? 'true' : 'false';
		echo "$resultstr\n";
		handleAlarmWarning($dev_id, $level, unitToType($unit . 'Upper'), $value, $result, $time, $action);
	}
}

function checkForAlarmWarning($dev_id, $time, $rssi, $temp, $humidity, $pressure, $batt )
{
	global $conn;

	echo "<pre>\n";

 	$awsql = "SELECT DevID, Level, TemperatureLower, TemperatureUpper, HumidityLower, HumidityUpper, PressureLower, PressureUpper, BattLower, BattUpper, RSSILower, RSSIUpper, Action FROM AlarmWarningLevels
WHERE DevID = '$dev_id'";

	$awresult = $conn->query($awsql);

	if (!$awresult) 
	{
    		error_log('Invalid query: ' . $conn->error);
	}
	else if ($awresult->num_rows > 0) 
	{
    		// output data of each row
    		while($row = $awresult->fetch_assoc())
    		{

			echo "------< AlarmWarningLevels >------\n";

        		$level = $row["Level"];
        		$templow = $row["TemperatureLower"];
        		$temphigh = $row["TemperatureUpper"];
        		$humlow = $row["HumidityLower"];
        		$humhigh = $row["HumidityUpper"];
        		$presslow = $row["PressureLower"];
        		$presshigh = $row["PressureUpper"];
        		$battlow = $row["BattLower"];
        		$batthigh = $row["BattUpper"];
        		$rssilow = $row["RSSILower"];
        		$rssihigh = $row["RSSIUpper"];
        		$action = $row["Action"];

			echo "level:$level\n";
			echo "templow:$templow\n";
			echo "temphigh:$temphigh\n";
			echo "humlow:$humlow\n";
			echo "humhigh:$humhigh\n";
			echo "presslow:$presslow\n";
			echo "presshigh:$presshigh\n";
			echo "battlow:$battlow\n";
			echo "batthigh:$batthigh\n";
			echo "rssilow:$rssilow\n";
			echo "rssihigh:$rssihigh\n";
			echo "action:$action\n";
			echo "------< Result >------\n";
			
			checkLimits($dev_id, $level, "Temp", $time, $temp, $templow, $temphigh, $action);
			checkLimits($dev_id, $level, "Humidity", $time, $humidity, $humlow, $humhigh, $action);
			checkLimits($dev_id, $level, "Pressure", $time, $pressure, $presslow, $presshigh, $action);
			checkLimits($dev_id, $level, "Batt", $time, $batt, $battlow, $batthigh, $action);
			checkLimits($dev_id, $level, "RSSI", $time, $rssi, $rssilow, $rssihigh, $action);

			echo "------< End >------\n";
    		}
	}
	echo "</pre>\n";
}

