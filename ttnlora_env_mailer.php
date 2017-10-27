<?php
include './ttnlora_env_vars.php';

function sendEmail($to, $subject, $body)
{
	global $mailfrom;
 	global $mailhost;
 	global $mailusername;
 	global $mailpassword;

	//https://stackoverflow.com/questions/2284468/problem-with-php-pear-mail
	require_once 'Mail.php';

	// NOTE : $mailfrom,$mailhost,$mailusername,$mailpassword come from ttnlora_env_vars.php
 	$headers = array ('From' => $mailfrom,
   		'To' => $to,
   		'Subject' => $subject);

 	$smtp = Mail::factory('smtp',
   		array ('host' => $mailhost,
     			'auth' => true,
     			'username' => $mailusername,
     			'password' => $mailpassword));
 	
 	$mail = $smtp->send($to, $headers, $body);
 	
 	if (PEAR::isError($mail)) 
	{
   		echo(" " . $mail->getMessage() . " ");  
	} 
	else 
	{   
		echo("Message successfully sent!");  
	}
}
?>
