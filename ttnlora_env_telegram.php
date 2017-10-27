<?php
include './ttnlora_env_vars.php';

function sendTelegramGetMe($chat_id)
{
	global $telegrambotid;
	// NOTE : $telegrambotid come from ttnlora_env_vars.php
	$url = "https://api.telegram.org/bot". $telegrambotid ."/getMe";
	echo "URL > $url\n";

	// use key 'http' even if you send the request to https://...
	$options = array(
    		'http' => array(
        		'header'  => "Content-type: application/json\r\n",
        		'method'  => 'POST'
    		)
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	if ($result === FALSE) { /* Handle error */ }

	var_dump($result);
	$result_str = var_export($result, true);
	error_log($result_str);

	// make http.get
	echo "Message successfully sent!";  
}

function sendTelegramMessage($chat_id, $subject, $body)
{
	global $telegrambotid;
	// NOTE : $telegrambotid come from ttnlora_env_vars.php
	$url = "https://api.telegram.org/bot". $telegrambotid ."/sendMessage";
	$text = $subject ." ". $body;
	echo "URL > $url\n";
	$data = array('chat_id' => $chat_id, 
			'text' => $text);

	$json = json_encode($data);

	// use key 'http' even if you send the request to https://...
	$options = array(
    		'http' => array(
        		'header'  => "Content-type: application/json\r\n",
        		'method'  => 'POST',
        		'content' => $json
    		)
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	if ($result === FALSE) { /* Handle error */ }

	var_dump($result);
	$result_str = var_export($result, true);
	error_log($result_str);

	// make http.get
	echo "Message successfully sent!";  
}


// Get the ID from https://web.telegram.org/#/im?p=@get_id_bot
// Don't forget to connect to LoRaWAN_ENV_bot and send /start
// test
//$to = "299412663";
//$subject = "ENV";
//$body = "ENV For node ph2lb-env-004 the Alarm of type HumidityUpper raised on 2017-09-28 18:43:13 was ended on 2017-09-29T08:48:43.042145611 for the value of 98.";
//sendTelegramMessage($to, $subject, $body);
//sendTelegramGetMe($to);

?>
