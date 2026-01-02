<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjAuthAppController extends pjPlugin
{
	public function __construct()
	{
		$this->setLayout('pjActionEmpty');
	}
	
	public function beforeFilter()
	{
	    $this->models['Option'] = pjBaseOptionModel::factory();
	    $this->option_arr = $this->models['Option']->getPairs($this->getForeignId());
	    $this->set('option_arr', $this->option_arr);
	    pjRegistry::getInstance()->set('options', $this->option_arr);
	    if (isset($this->option_arr['o_timezone']))
	    {
	        pjTimezone::factory()->setAllTimezones($this->option_arr['o_timezone']);
	    }
	    pjCurrency::factory()->setCurrencyData();
	    
	    if (!$this->session->has($this->defaultLocale))
	    {
	        $locale_arr = pjLocaleModel::factory()->where('is_default', 1)->limit(1)->findAll()->getData();
	        if (count($locale_arr) === 1)
	        {
	            $this->setLocaleId($locale_arr[0]['id']);
	        }
	    }
	    
	    return true;
	}
	
	public function afterFilter()
	{
		
	}
	
	public static function getConst($const)
	{
		$registry = pjRegistry::getInstance();
		$store = $registry->get('pjAuth');
		return isset($store[$const]) ? $store[$const] : NULL;
	}
	
	public function isAuthReady()
	{
		$reflector = new ReflectionClass('pjPlugin');
		try {
			//Try to find out 'isAuthReady' into parent class
			$ReflectionMethod = $reflector->getMethod('isAuthReady');
			return $ReflectionMethod->invoke(new pjPlugin(), 'isAuthReady');
		} catch (ReflectionException $e) {
			//echo $e->getMessage();
			//If failed to find it out, denied access, or not :)
			return false;
		}
	}
}
?>