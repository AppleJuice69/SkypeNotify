<?php

/**
 * Example callback listener using the SkypeNotify Callback library
 *
 * All responses will be written to a file, because we cannot view the response
 */

include dirname(__DIR__) . "/library/skypenotify.callback.php";

$fh = fopen(time() . "_SN.log", "w");

$callback = new SkypeNotifyCallback();

// register hook "auth" to an anonymous function
$callback->registerHook("auth", function($callback, $params) {
	global $fh;
	fwrite($fh, "[!] Auth callback run! " . print_r($params, true) . PHP_EOL);
});

// example class that can handle hooks
class ExampleClass
{

	public function deauth($callback, $params)
	{
		global $fh;
		fwrite($fh, "[!] Deauth callback run! " . print_r($params, true) . PHP_EOL);
	}

}

$class = new ExampleClass();

// register hook "deauth" to deauth method of the ExampleClass object
$callback->registerHook("deauth", [$class, "deauth"]);

try {
	// attempt to run the callback
	$callback->run();
} catch (Exception $ex) {
	echo "Callback error: " . $ex->toString();
}

fclose($fh);
