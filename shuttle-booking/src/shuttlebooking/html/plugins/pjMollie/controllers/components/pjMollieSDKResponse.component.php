<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjMollieSDKResponse extends pjPaymentsSDKResponse
{
	public function isOK()
	{
		return isset($this->response['resource']) || array_key_exists('count', $this->response);
	}
}