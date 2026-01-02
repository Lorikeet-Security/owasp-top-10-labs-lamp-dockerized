<?php
if (!defined("ROOT_PATH"))
{
    header("HTTP/1.1 403 Forbidden");
    exit;
}
class pjPayments extends pjPaymentsAppController
{
	protected static $testLog = 'payments.log';	
    /*
     * Gets the titles set in payment methods' configuration. If a payment method's title is missing, the default name will be used.
     */
	
	public function pjActionIndex()
	{
	    if (class_exists('pjAuth') && !pjAuth::factory()->hasAccess())
	    {
	        $this->sendForbidden();
	        return;
	    }
	    
	    $this->setLocalesData();
	    
	    $this->appendJs('jquery.multilang.js', $this->getConstant('pjBase', 'PLUGIN_JS_PATH'), false, false);
	    $this->appendJs('pjAdminPayments.js', $this->getConst('PLUGIN_JS_PATH'));
	}
	
	public function pjActionPaymentOptions()
	{
	    $this->checkLogin();
	    
	    $this->setAjax(true);
	    if ($this->_post->check('options_update'))
	    {
	        if (pjObject::getPlugin('pjPayments') !== NULL && $this->_post->check('plugin_payment_options'))
	        {
	            $this->requestAction(array(
	                'controller' => 'pjPayments',
	                'action' => 'pjActionSaveOptions',
	                'params' => array(
	                    'foreign_id' => $this->getForeignId(),
	                    'data' => $this->_post->toArray('plugin_payment_options'),
	                )
	            ), array('return'));
	        }
	        if (in_array($this->_post->toString('payment_method'), array('cash', 'bank')))
	        {
	            pjPaymentOptionModel::factory()
    	            ->where('foreign_id', $this->getForeignId())
    	            ->where('`payment_method`', $this->_post->toString('payment_method'))
    	            ->limit(1)
    	            ->modifyAll(array('is_active' => $this->_post->toInt('is_active')));
	        }
	        if ($this->_post->check('i18n'))
	        {
	            pjMultiLangModel::factory()->updateMultiLang($this->_post->toI18n('i18n'), $this->getForeignId(), 'pjPayment', 'data');
	        }
	        if ($this->_post->check('i18n_options'))
	        {
	            pjMultiLangModel::factory()->updateMultiLang($this->_post->toI18n('i18n_options'), $this->getForeignId(), 'pjOption', 'data');
	        }
	    } else {
	        $this->set('i18n', pjMultiLangModel::factory()->getMultiLang($this->getForeignId(), 'pjPayment'));
	        $this->set('i18n_options', pjMultiLangModel::factory()->getMultiLang($this->getForeignId(), 'pjOption'));
	        
	        $this->setLocalesData();
	    }
	}
	
	public function setLocalesData()
	{
	    $locale_arr = pjLocaleModel::factory()
    	    ->select('t1.*, t2.file')
    	    ->join('pjBaseLocaleLanguage', 't2.iso=t1.language_iso', 'left')
    	    ->where('t2.file IS NOT NULL')
    	    ->orderBy('t1.sort ASC')
    	    ->findAll()
    	    ->getData();
	    
	    $lp_arr = array();
	    foreach ($locale_arr as $item)
	    {
	        $lp_arr[$item['id']."_"] = $item['file'];
	    }
	    $this->set('lp_arr', $locale_arr);
	    $this->set('locale_str', pjAppController::jsonEncode($lp_arr));
	    $this->set('is_flag_ready', $this->requestAction(array('controller' => 'pjBaseLocale', 'action' => 'pjActionIsFlagReady'), array('return')));
	}

    public static function cancelAuthorization($params)
    {}

	public static function captureFunds($params)
    {}

    public static function getPaymentTitles($foreign_id, $locale_id)
    {
        $i18n_arr = pjMultiLangModel::factory()->getMultiLang($foreign_id, 'pjPayment');
        $payment_titles = isset($i18n_arr[$locale_id]) ? $i18n_arr[$locale_id] : array();
        foreach (array('o_bank_account', 'creditcard') as $idx)
        {
            if (isset($payment_titles[$idx]))
            {
                unset($payment_titles[$idx]);
            }
        }
        $payment_methods = __('payment_methods', true);
        foreach($payment_titles as $k => $v)
        {
            if (empty($v) && !empty($payment_methods[$k]))
            {
                $payment_titles[$k] = $payment_methods[$k];
            }
        }
        
        return $payment_titles;
    }
    
    /*
     * Gets the payment methods' keys and names.
     * Returns only the ones coming from the payment plugins. Excludes payment methods like cash, bank transfer etc.
     */
    public static function getPaymentMethods()
    {
        $payment_methods = __('payment_methods', true);
        $whitelist = pjPaymentOptionModel::factory()->getPaymentMethods();
        $payment_methods = array_intersect_key($payment_methods, $whitelist);
        
        return $payment_methods;
    }
    
    /*
     * Gets the active payment methods' keys and names.
     * Returns only the ones coming from the payment plugins. Excludes payment methods like cash, bank transfer etc.
     */
    public static function getActivePaymentMethods($foreign_id)
    {
        $payment_methods = __('payment_methods', true);
        $whitelist = pjPaymentOptionModel::factory()->getActivePaymentMethods($foreign_id);
        $payment_methods = array_intersect_key($payment_methods, $whitelist);
        
        return $payment_methods;
    }

    public static function getActivePaymentMethodsWithAuthorization($foreign_id)
    {
        $payment_methods = __('payment_methods', true);
        $whitelist = pjPaymentOptionModel::factory()->where('is_hold_on', 1)->getActivePaymentMethods($foreign_id);
        $payment_methods = array_intersect_key($payment_methods, $whitelist);

        return $payment_methods;
    }
    
    public static function getPluginName($payment_method = null)
    {
        $plugin_name = null;
        if ($payment_method)
        {
            $plugin_name = 'pj' . str_replace(' ', '', ucwords(str_replace('_', ' ', $payment_method)));
        }
        return $plugin_name;
    }
    
    public static function getFormParams($post, $order_arr)
    {
        $payment_method = $post['payment_method'];
        $payment_options = pjPaymentOptionModel::factory()->getOptions($order_arr['foreign_id'], $payment_method);
        
        $item_name = __("plugin_{$payment_method}_payment_title", true);
        if (empty($item_name))
        {
            $item_name = "Unique ID: {$order_arr['uuid']}";
        } else {
            $item_name .= " (Unique ID: {$order_arr['uuid']})";
        }
        
        $first_name = $last_name = null;
        if (isset($order_arr['first_name']) && isset($order_arr['last_name']))
        {
            $first_name = pjSanitize::html($order_arr['first_name']);
            $last_name = pjSanitize::html($order_arr['last_name']);
            
        } elseif (isset($order_arr['name'])) {
        	
            $pos = stripos($order_arr['name'], ' ');
            $first_name = pjSanitize::html(substr($order_arr['name'], 0, $pos));
            $last_name = pjSanitize::html(substr($order_arr['name'], $pos + 1));
        }
        
        $is_test_mode = (int) $payment_options['is_test_mode'] === 1;
        
        $params = array(
            'plugin'            => pjPayments::getPluginName($payment_method),
            'name'              => 'pjOnlinePaymentForm',
            'id'                => 'pjOnlinePaymentForm_' . $payment_method,
            'locale_id'         => $order_arr['locale_id'],
            'item_name'         => $item_name,
            'amount'            => $order_arr['amount'],
            'custom'            => $order_arr['uuid'],
            'currency_code'     => $order_arr['currency_code'],
            'return_url'        => $order_arr['return_url'],
            'notify_url'        => PJ_INSTALL_URL . 'payments_webhook.php?payment_method=' . $payment_method,
            'cancel_hash'       => $order_arr['cancel_hash'],
            'option_foreign_id' => $payment_options['foreign_id'],
        	'is_test_mode'      => $payment_options['is_test_mode'],
        	'merchant_id'       => !$is_test_mode ? $payment_options['merchant_id'] : $payment_options['test_merchant_id'],
        	'merchant_email'    => !$is_test_mode ? $payment_options['merchant_email'] : $payment_options['test_merchant_email'],
        	'public_key'        => !$is_test_mode ? $payment_options['public_key'] : $payment_options['test_public_key'],
        	'private_key'       => !$is_test_mode ? $payment_options['private_key'] : $payment_options['test_private_key'],
        	'tz'                => !$is_test_mode ? $payment_options['tz'] : $payment_options['test_tz'],
            'success_url'       => $payment_options['success_url'],
            'failure_url'       => $payment_options['failure_url'],
            'description'       => $payment_options['description']? $payment_options['description']: $item_name,
            'target'            => '_self',
            'first_name'        => $first_name,
            'last_name'         => $last_name,
            'email'             => pjSanitize::html($order_arr['email']),
            'phone'             => pjSanitize::html($order_arr['phone']),
        );
        
        return $params;
    }
    
    public function pjActionOptions()
    {
        $this->checkLogin();
        $this->setLayout('pjActionEmpty');
        $this->set('params', $this->getParams());
    }
    
    public function pjActionSaveOptions()
    {
        $this->checkLogin();
        
        $params = $this->getParams();
        
        pjPaymentOptionModel::factory()->saveOptions($params['data'], $params['foreign_id']);
        
        foreach($params['data'] as $payment_method => $data)
        {
            $pjPlugin = self::getPluginName($payment_method);
            if (pjObject::getPlugin($pjPlugin) !== NULL)
            {
                $this->requestAction(array(
                    'controller' => $pjPlugin,
                    'action' => 'pjActionSaveOptions',
                    'params' => array('foreign_id' => $params['foreign_id'], 'data' => $data)
                ), array('return'));
            }
        }
    }
    
    public function pjActionCopyOptions()
    {
        $this->checkLogin();
        
        $params = $this->getParams();
        
        pjPaymentOptionModel::factory()->copyOptions($params['from_foreign_id'], $params['to_foreign_id']);
        
        foreach (array_keys(self::getPaymentMethods()) as $payment_method)
        {
            $pjPlugin = self::getPluginName($payment_method);
            if (pjObject::getPlugin($pjPlugin) !== NULL)
            {
                $this->requestAction(array(
                    'controller' => $pjPlugin,
                    'action' => 'pjActionCopyOptions',
                    'params' => $params
                ), array('return'));
            }
        }
    }
    
    public function pjActionDeleteOptions()
    {
        $this->checkLogin();
        
        $params = $this->getParams();
        
        pjPaymentOptionModel::factory()->deleteOptions($params['foreign_id']);
        
        foreach (array_keys(self::getPaymentMethods()) as $payment_method)
        {
            $pjPlugin = self::getPluginName($payment_method);
            if (pjObject::getPlugin($pjPlugin) !== NULL)
            {
                $this->requestAction(array(
                    'controller' => $pjPlugin,
                    'action' => 'pjActionDeleteOptions',
                    'params' => $params
                ), array('return'));
            }
        }
    }
    
    public function getPaymentPlugin($requestData = array())
    {
        if (!isset($requestData['payment_method']) || empty($requestData['payment_method']))
        {
            $this->log("Payments | Payment method not found<br>Request Data:<br>" . print_r($requestData, true));
            return false;
        }
        
        $pjPlugin = self::getPluginName($requestData['payment_method']);
        if (pjObject::getPlugin($pjPlugin) === NULL)
        {
            $this->log("Payments | {$pjPlugin} plugin not found<br>Request Data:<br>" . print_r($requestData, true));
            return false;
        }
        
        return $pjPlugin;
    }
    
    public static function generateTestData($custom=array())
    {
    	$uuid = pjUtil::uuid();
    	
    	$data = array(
    		'id'         => rand(1000, 9999999),
    		'foreign_id' => 1,
    		'uuid'       => $uuid,
    		'c_name'     => 'John Smith',
    		'c_email'    => 'john.smith@domain.com',
    		'c_phone'    => '+1 (234) 567-8901',
    		'created'    => date("Y-m-d H:i:s"),
    		'amount'     => '0.01',
    		'deposit'    => '0.01',
    		'txn_id'     => '',
    		// PayPal Subscription payment
    		'a3_price'         => '0.01',
    		'p3_duration'      => 6,
    		't3_duration_unit' => 'M',
    	);
    	
    	foreach ($custom as $key => $val)
    	{
    		if (is_numeric($key))
    		{
    			if (!isset($data[$val]))
	    		{
	    			$data[$val] = "";
	    		}
    		} else {
    			$data[$key] = $val;
    		}
    	}
    	
    	# ------------------------
    	$arr = array();
    	$string = @file_get_contents(self::$testLog);
    	if ($string !== false)
    	{
    		$arr = json_decode($string, true);
    	}
    	
    	$arr[$uuid] = $data;
    	
    	@file_put_contents(self::$testLog, json_encode($arr), LOCK_EX);
    	
    	# ------------------------
    	
    	return $data;
    }
    
    public static function getTestData($uuid)
    {
    	$string = @file_get_contents(self::$testLog);
    	if ($string !== false)
    	{
    		$arr = json_decode($string, true);
    		
    		if (isset($arr[$uuid]))
    		{
    			return $arr[$uuid];
    		}
    	}
    	
    	return false;
    }
    
    protected static function isSecure()
    {
    	return (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
    }

    public static function confirmationFailed($arguments)
    {
        $method_name = 'confirmationFailed';
        if (!defined('PJ_ENGINE')
            || trim(PJ_ENGINE) == ""
            || !class_exists(PJ_ENGINE)
            || !method_exists(PJ_ENGINE, $method_name)
        )
        {
            return false;
        }

        $class_name = constant('PJ_ENGINE');
        $object = new $class_name();

        $default = array(
            'uuid' => '',
            'payment_method' => '',
            'payment_code' => '',
            'payment_message' => '',
            'exception_code' => '',
            'exception_message' => '',
            'description' => '',
            'response' => '',
        );

        $args = array_merge($default, $arguments);

        try {
            $reflectionMethod = new ReflectionMethod($class_name, $method_name);
            $reflectionMethod->invokeArgs($object, array($args));
        } catch (ReflectionException $e) {
            return false;
        }

        return true;
    }
}