<?php

/**
 * Example callback listener using the SkypeNotify Callback library
 *
 * In this example, we register hooks to an object's methods. We can use static
 * and non-static methods to do so. All functions for jooks require two
 * arguments, $callback and $params. $callback is the SkypeNotify Callback
 * class, and $params contains the values of $_GET (array)
 */

include dirname(dirname(__DIR__)) . "/library/skypenotify.callback.php";

$fh = fopen(time() . "_SN.log", "w");

// create new instance of the SkypeNotifyCallback class
$callback = new SkypeNotifyCallback();

// example class that can handle hooks
class ExampleClass
{

	/**
	 * Example static method for callback
	 */
	public static function auth($callack, $params)
	{
		global $fh;
		fwrite($fh, "[!] Static authentication hook executed!" . PHP_EOL);
	}

	/**
	 * Non-static method, can only be called from an instance
	 */
	public function deauth($callback, $params)
	{
		global $fh;
		fwrite($fh, "[!] Unauthenticated hook executed!" . PHP_EOL);
	}

}

// create new instance of ExampleClass to handle the hooks
$class = new ExampleClass();

// register hook "auth" to a static method
$callback->registerHook("auth", ["ExampleClass", "auth"]);

// register hook "deauth" to deauth method of the ExampleClass object
$callback->registerHook("deauth", [$class, "deauth"]);

try {
	// attempt to run the callback
	$callback->run();
} catch (Exception $ex) {
	echo "Callback error: " . $ex->toString();
}

fclose($fh);
