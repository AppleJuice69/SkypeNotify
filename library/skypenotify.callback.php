<?php

/**
 * SkypeNotify Callback Library
 *
 * This class will handle callback requests from the SkypeNotify server.
 * This class is similar to the observer pattern, where you can hook a callback
 * to an action, and handle it. In order to handle callback methods, you have to
 * register a callback method to it, whether its a function of an object method.
 *
 * @author  AppleJuice (juiceyapple69@gmail.com)
 * @package SkypeNotify
 * @version 1.0
 */
class SkypeNotifyCallback
{

	/**
	 * The action the server has given
	 *
	 * @var string
	 */
	private $action;

	/**
	 * An array of registered hooks
	 *
	 * The key is the action name, such as auth, with a callable value such as
	 * a class or a function.
	 *
	 * @var array
	 */
	protected $hooks = [];

	/**
	 * An array of valid actions
	 *
	 * @var array
	 */
	private $validActions = [
		"auth", "deauth",
	];

	/**
	 * The class constructor
	 *
	 * @access private
	 * @since  1.0
	 */
	public function __construct()
	{
		if (isset($_GET['action']) && in_array($_GET['action'], $this->validActions)) {
			$this->action = $_GET['action'];
		}
	}

	/**
	 * Hook a callback for a specific action
	 */
	public function registerHook($name, callable $callable)
	{
		$this->hooks[$name] = $callable;
		return $this;
	}

	/**
	 * Unregister a hook
	 */
	public function unregisterHook($name)
	{
		unset($this->hooks[$name]);
		return $this;
	}

	/**
	 * Attempt to run a specific hook
	 */
	public function run()
	{
		// skip if there's no valid action
		if (empty($this->action)) return;

		if (!isset($this->hooks[$this->action])) {
			throw new Exception("Unhandled hook: " . $this->action);
		}

		return call_user_func_array($this->hooks[$this->action], [$this, $_GET]);
	}

}
