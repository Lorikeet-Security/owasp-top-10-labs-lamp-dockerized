<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
abstract class pjPaymentsSDKResponse
{
	protected $response;
	
	public function __construct($response)
	{
		$this->response = $response;
	}
	
	abstract public function isOK();
}