<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pj2checkoutAppController extends pjPayments
{
	public function __construct()
	{
        parent::__construct();
		$this->setLayout('pjActionAdmin');
	}
	
	public static function getConst($const)
	{
		$registry = pjRegistry::getInstance();
		$store = $registry->get('pj2checkout');
		return isset($store[$const]) ? $store[$const] : NULL;
	}
}
?>