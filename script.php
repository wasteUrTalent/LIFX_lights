<?php
$cID=$_POST['cID'];
$options = array( 
			CURLOPT_RETURNTRANSFER => true,
			// CURLOPT_HEADER => false,
			// CURLOPT_FOLLOWLOCATION => true,
			// CURLOPT_ENCODING => 'UTF-8',
			// CURLOPT_USERAGENT => $user_agent,
			// CURLOPT_AUTOREFERER => true,
			// CURLOPT_CONNECTTIMEOUT => 120,
			// CURLOPT_TIMEOUT => 120,
			// CURLOPT_MAXREDIRS => 10,
			// CURLOPT_SSL_VERIFYHOST => 0,
			// CURLOPT_SSL_VERIFYPEER => false, 
			// CURLOPT_VERBOSE => 1
		); 

$link = "https://api.lifx.com/v1/lights/id:".$cID."/toggle";
$authToken = "{{token}}";
$ch = curl_init($link);
$headers = array('Authorization: Bearer ' . $authToken);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);


	curl_setopt_array($ch, $options); 
	$content = curl_exec($ch); 

	$err = curl_errno($ch); 
	$errmsg = curl_error($ch) ; 
	$header = curl_getinfo($ch);

	curl_close($ch); 

	// var_dump(json_decode($content, true));
	// echo $content;
?>