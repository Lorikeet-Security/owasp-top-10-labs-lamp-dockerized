<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjAuthorizeSDKResponse extends pjPaymentsSDKResponse
{
	public function getErrors()
	{
		return isset($this->response['messages']['message']) ? $this->response['messages']['message'] : array();
	}
	
	public function isOK()
	{
		return isset($this->response['messages']['resultCode']) && $this->response['messages']['resultCode'] == 'Ok';
	}
}