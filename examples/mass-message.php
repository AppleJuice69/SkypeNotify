<?php

include dirname(__DIR__) . "/library/skypenotify.class.php";

$apiKey = "";

try {
	$skypenotify = new SkypeNotify($apiKey);

	if ($skypenotify->sendToAll(
		"Sending a mass message to all authorized users!"
	)) {
		echo "Successful mass message";
	} else {
		echo "Failed to send out request";
	}
} catch (Exception $ex) {
	echo "API Request Failure: " . $ex->getMessage();
}
