<?php

/**
 * SkypeNotify Library
 *
 * @author  AppleJuice (juiceyapple69@gmail.com)
 * @package SkypeNotify
 * @version 1.0
 */
class SkypeNotify
{

	/**
	 * The absolute address to the API gateway
	 *
	 * @const API_URL
	 */
	const     API_URL = "http://skypenotify.com/api.php";

	/**
	 * The private API key
	 *
	 * @var string
	 */
	protected $apiKey;

	/**
	 * The class constructor
	 *
	 * @access private
	 * @param  string  $apiKey  The private API key to use
	 * @since  1.0
	 */
	public function __construct($apiKey)
	{
		$this->apiKey = $apiKey;
	}

	/**
	 * Function to send a cURL request to the API
	 *
	 * @access private
	 * @param  string  $action  The API action to use
	 * @param  array   $options An array of options for the action
	 * @return string  The API response
	 * @since  1.0
	 * @throws Exception If there's an error during the cURL request
	 */
	private function sendRequest($action, $options = [])
	{
		$params = array_merge([
			"key"    => $this->apiKey,
			"action" => $action
		], $options);

		// init and setup cURL
		$ch = curl_init();
		curl_setopt_array($ch, [
			CURLOPT_URL            => self::API_URL . "?" . http_build_query($params),
			CURLOPT_RETURNTRANSFER => true,
		]);

		// execute cURL request
		$data = curl_exec($ch);

		// if there's no error, return $data, otherwise throw an exception
		if (!curl_errno($ch)) {
			return $data;
		} else {
			throw new Exception("An error occurred while sending cURL request: " . curl_error($ch));
		}
	}

	/**
	 * Function to send a message to an authorized user
	 *
	 * @access private
	 * @param  string  $username The authorize recipient's Skype username
	 * @param  string  $message  The message contents
	 * @return bool    True if successful
	 * @since  1.0
	 * @throws Exception If there's an error during the cURL request
	 */
	public function sendMessage($username, $message)
	{
		$opts = [
			"skype"   => $username,
			"message" => $message
		];
		if (($response = $this->sendRequest("sendmessage", $opts)) !== null) {
			if ($response !== "success") {
				throw new Exception("Unexpected response given: " . $response);
			}
			return true;
		} else {
			throw new Exception("Invalid SkypeNotify API response");
		}
	}

	/**
	 * Function to send a message to all authorized users
	 *
	 * @access private
	 * @param  string  $message  The message contents
	 * @return bool    True if successful
	 * @since  1.0
	 * @throws Exception If there's an error during the cURL request
	 */
	public function sendToAll($message)
	{
		$opts = [
			"message" => $message
		];
		if (($response = $this->sendRequest("sendall", $opts)) !== null) {
			if ($response !== "success") {
				throw new Exception("Unexpected response given: " . $response);
			}
			return true;
		} else {
			throw new Exception("Invalid SkypeNotify API response");
		}
	}

	/**
	 * Function to check if a Skype username has authorized the application
	 *
	 * @access private
	 * @param  string  $username The Skype username
	 * @return bool    True if authorized, false otherwise
	 * @since  1.0
	 * @throws Exception If there's an error during the cURL request
	 */
	public function checkAuth($username)
	{
		$opts = [
			"skype" => $username,
		];
		if (($response = $this->sendRequest("authcheck", $opts)) !== null) {
			return ($response === "success");
		} else {
			throw new Exception("Invalid SkypeNotify API response");
		}
	}

}
