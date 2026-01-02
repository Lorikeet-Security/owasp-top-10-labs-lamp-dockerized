<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjFront extends pjAppController
{	
	public $defaultCaptcha = 'pjShuttleBS_Captcha';
	
	public $defaultLocale = 'pjShuttleBS_LocaleId';
	
	public $defaultFrontClient = 'pjShuttleBS_Client';
	
	public $defaultStore = 'pjShuttleBS_Store';
	
	public $defaultForm = 'pjShuttleBS_Form';
	
	public function __construct()
	{
		$this->setLayout('pjActionFront');
		
		self::allowCORS();
	}
	
	public function afterFilter()
	{
	    if (!$this->_get->check('hide') || ($this->_get->check('hide') && $this->_get->toInt('hide') !== 1) &&
	        in_array($this->_get->toString('action'), array('pjActionSearch', 'pjActionLines', 'pjActionCheckout', 'pjActionPreview', 'pjActionGetPaymentForm')))
	    {
	        $locale_arr = pjLocaleModel::factory()->select('t1.*, t2.file, t2.title')
	        ->join('pjLocaleLanguage', 't2.iso=t1.language_iso', 'left')
	        ->where('t2.file IS NOT NULL')
	        ->orderBy('t1.sort ASC')->findAll()->getData();
	        
	        $this->set('locale_arr', $locale_arr);
	    }
	}
	
	public function beforeFilter()
	{
	    return parent::beforeFilter();
	}
	
	public function beforeRender()
	{
	    if (isset($_GET['iframe']))
	    {
	        $this->setLayout('pjActionIframe');
	    }
	}
	
	public function pjActionLocale()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
		    if ($locale_id = $this->_get->toInt('locale_id'))
		    {
		        $this->pjActionSetLocale($locale_id);
				
				$this->loadSetFields(true);
				
				$day_names = __('day_names', true);
				ksort($day_names, SORT_NUMERIC);
				
				$months = __('months', true);
				ksort($months, SORT_NUMERIC);
				
				pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Locale have been changed.', 'opts' => array(
					'day_names' => array_values($day_names),
					'month_names' => array_values($months)
				)));
			}
		}
		exit;
	}
	
	public function pjActionGetLocale()
	{
		return isset($_SESSION[$this->defaultLocale]) && (int) $_SESSION[$this->defaultLocale] > 0 ? (int) $_SESSION[$this->defaultLocale] : FALSE;
	}
	
	public function isXHR()
	{
		return parent::isXHR() || isset($_SERVER['HTTP_ORIGIN']);
	}
	public function isFrontLogged()
	{
		if (isset($_SESSION[$this->defaultFrontClient]) && count($_SESSION[$this->defaultFrontClient]) > 0)
		{
			return true;
		}
		return false;
	}
	public function getClientId()
	{
	    return isset($_SESSION[$this->defaultFrontClient]) && array_key_exists('id', $_SESSION[$this->defaultFrontClient]) ? $_SESSION[$this->defaultFrontClient]['id'] : FALSE;
	}
	protected static function allowCORS()
	{
		$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '*';
		header('P3P: CP="ALL DSP COR CUR ADM TAI OUR IND COM NAV INT"');
		header("Access-Control-Allow-Origin: $origin");
		header("Access-Control-Allow-Credentials: true");
		header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
		header("Access-Control-Allow-Headers: Origin, X-Requested-With");
	}
	protected function _get($key)
	{
		if ($this->_is($key))
		{
			return $_SESSION[$this->defaultStore][$key];
		}
		return false;
	}
	
	protected function _is($key)
	{
		return isset($_SESSION[$this->defaultStore]) && isset($_SESSION[$this->defaultStore][$key]);
	}
	
	protected function _set($key, $value)
	{
		$_SESSION[$this->defaultStore][$key] = $value;
		return $this;
	}
	
	protected function _unset($key)
	{
		if ($this->_is($key))
		{
			unset($_SESSION[$this->defaultStore][$key]);
		}
	}
	private function pjActionSetLocale($locale)
	{
		if ((int) $locale > 0)
		{
			$_SESSION[$this->defaultLocale] = (int) $locale;
		}
		return $this;
	}
}
?>