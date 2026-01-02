<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjBraintreeSDKResponse extends pjPaymentsSDKResponse
{
	public function isOK()
	{
		return !$this->getErrors();
	}
	
	public function getErrors()
	{
		return isset($this->response['errors']) ? $this->response['errors'] : array();
	}
	
	public function toArray()
	{
		return $this->response;
	}
	
	public function toString()
	{
		return json_encode($this->response);
	}
}