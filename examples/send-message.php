<?php

include dirname(__DIR__) . "/library/skypenotify.class.php";

$apiKey = "";

try {
	$skypenotify = new SkypeNotify($apiKey);

	if ($skypenotify->sendMessage(
		"apple.juice69",
		"Sending you a message from " . $_SERVER['SERVER_ADDR'] . " at " . date("r")
	)) {
		echo "Successful message";
	} else {
		echo "Failed to send out request";
	}
} catch (Exception $ex) {
	echo "API Request Failure: " . $ex->getMessage();
}
