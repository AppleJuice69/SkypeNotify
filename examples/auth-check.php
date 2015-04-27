<?php

include dirname(__DIR__) . "/library/skypenotify.class.php";

$apiKey = "";

try {
	$skypenotify = new SkypeNotify($apiKey);

	if ($skypenotify->checkAuth("apple.juice69")) {
		echo "User has authorized this application";
	} else {
		echo "User has not authorized this application";
	}
} catch (Exception $ex) {
	echo "API Request Failure: " . $ex->getMessage();
}
