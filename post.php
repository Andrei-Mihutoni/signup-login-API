<?php

if (!isset($_POST['to_phone'])) {
	http_response_code(400);
	echo 'Phone number required';
	exit();
}

if (strlen($_POST['to_phone']) < 8) {
	http_response_code(400);
	echo 'Phone number must be 8 digits';
	exit();
}

if (!isset($_POST['message'])) {
	http_response_code(400);
	echo 'Message is required';
	exit();
}

if (strlen($_POST['message']) < 1) {
	http_response_code(400);
	echo 'Message needs to be minimum 1 character';
	exit();
}



try {
	$ch = curl_init();

	$fields = array('to_phone' => $_POST['to_phone'], 'message' => $_POST['message'], 'api_key' => '87ebf26b-37b1-4a5d-8eba-7bfd4709d2f3');
	$postvars = '';
	foreach ($fields as $key => $value) {
		$postvars .= $key . "=" . $value . "&";
	}
	echo $postvars;
	$url = "https://fatsms.com/send-sms";
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 1);                //0 for a get request
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
	curl_setopt($ch, CURLOPT_TIMEOUT, 20);
	$response = curl_exec($ch);
	// print "curl response is:" . $response;
	echo "Message sent successfully";
	curl_close($ch);
} catch (Exception $ex) {
	echo $ex;
	echo "System under maintainance";
}
