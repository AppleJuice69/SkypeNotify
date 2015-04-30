<?php

/**
 * Example callback listener using the SkypeNotify Callback library
 *
 * In this example, we register hooks to anonymous functions. All functions for
 * hooks require two arguments, $callback and $params. $callback is the
 * SkypeNotify Callback class, and $params contains the values of $_GET (array)
 *
 * @see http://php.net/manual/en/functions.anonymous.php
 */

include dirname(dirname(__DIR__)) . "/library/skypenotify.callback.php";

$fh = fopen(time() . "_SN.log", "w");

// create new instance of the SkypeNotifyCallback class
$callback = new SkypeNotifyCallback();

// register hook "auth" to function hook_auth()
$callback->registerHook("auth",   function($callback, $params) {
	global $fh;
	fwrite($fh, "[!] Authentication hook executed!" . PHP_EOL);
});

// register hook "deauth" to function hook_deauth()
$callback->registerHook("deauth", function($callback, $params) {
	global $fh;
	fwrite($fh, "[!] Unauthenticated hook executed!" . PHP_EOL);
});

try {
	// attempt to run the callback
	$callback->run();
} catch (Exception $ex) {
	echo "Callback error: " . $ex->toString();
}

fclose($fh);
