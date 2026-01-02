<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjPaypalExpressSDKResponse extends pjPaymentsSDKResponse
{
	public function getError()
	{
		return isset($this->response['error']) ? $this->response['error'] : false;
	}
	
	public function isOK()
	{
		return !(isset($this->response['error']) && is_array($this->response['error']) && !empty($this->response['error']));
	}
}