<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjPaymentsAppController extends pjPlugin
{
	public function __construct()
	{
		$this->setLayout('pjActionAdmin');
	}
	
	public static function getConst($const)
	{
		$registry = pjRegistry::getInstance();
		$store = $registry->get('pjPayments');
		return isset($store[$const]) ? $store[$const] : NULL;
	}
}
?>