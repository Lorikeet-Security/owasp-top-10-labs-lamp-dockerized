<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjAuthorize extends pjAuthorizeAppController
{
	protected static $currencies = array(
		'AUD',
		'GBP',
		'CAD',
		'DKK',
		'EUR',
		'NZD',
		'NOK',
		'PLN',
		'SEK',
		'CHF',
		'USD',
	);

	protected static $config = 'pjAuthorizeConfig';
	
	protected static $error = 'pjAuthorizeError';
	
	protected static $logPrefix = "Payments | pjAuthorize plugin<br>";
	
	protected static $paymentMethod = 'authorize';

    public function pjActionOptions()
    {
        $this->checkLogin();
        
        $this->setLayout('pjActionEmpty');
        
        if (!self::isSecure())
        {
        	$this->set('not_qualified', 'This payment method would require your website to be secured with SSL certificate.');
        }

        $params = $this->getParams();

        $this->set('arr', pjPaymentOptionModel::factory()->getOptions($params['foreign_id'], self::$paymentMethod));
        
        $i18n = pjMultiLangModel::factory()->getMultiLang($params['fid'], 'pjPayment');
        $this->set('i18n', $i18n);
        
        $locale_arr = pjLocaleModel::factory()
        	->select('t1.*, t2.file')
	        ->join('pjLocaleLanguage', 't2.iso=t1.language_iso', 'left')
	        ->where('t2.file IS NOT NULL')
	        ->orderBy('t1.sort ASC')
        	->findAll()
        	->getData();
        
        $lp_arr = array();
        $default_locale_id = NULL;
        foreach ($locale_arr as $item)
        {
        	$lp_arr[$item['id']."_"] = $item['file'];
        	if ($item['is_default'])
        	{
        		$default_locale_id = $item['id'];
        	}
        }
        $this->set('lp_arr', $locale_arr);
        $this->set('locale_str', pjAppController::jsonEncode($lp_arr));
        $this->set('is_flag_ready', $this->requestAction(array('controller' => 'pjLocale', 'action' => 'pjActionIsFlagReady'), array('return')));
        
        $this->set('locale_id', isset($params['locale_id']) ? $params['locale_id'] : $default_locale_id);
    }

    public function pjActionSaveOptions()
    {
        $this->checkLogin();

        return true;
    }

    public function pjActionCopyOptions()
    {
        $this->checkLogin();

        return true;
    }

    public function pjActionDeleteOptions()
    {
        $this->checkLogin();

        return true;
    }

    public static function getFormParams($post, $order_arr)
    {
        $params = parent::getFormParams($post, $order_arr);
        
        # It seems that Authorize.NET doesn't likes more than 1 parameter in the query string
        # https://community.developer.authorize.net/t5/Integration-and-Testing/Potential-Hosted-Payment-Page-Bug/td-p/68031
        $params['notify_url'] .= '|x_invoice_num=' . $params['custom'];
        $params['cancel_url'] = "{$params['notify_url']}|cancel_hash={$params['cancel_hash']}";

        return $params;
    }

    public function pjActionGetCustom()
    {
        $request = $this->getParams();
        $custom = isset($request['x_invoice_num']) ? $request['x_invoice_num']: null;
        if (!empty($custom))
        {
            $this->log(self::$logPrefix . "Start confirmation process for: {$custom}<br>Request Data:<br>" . print_r($request, true));
        } else {
            $this->log(self::$logPrefix . "Missing parameters. Cannot start confirmation process.<br>Request Data:<br>" . print_r($request, true));
        }

        return $custom;
    }

	public function pjActionGetCurrencies()
	{
		return self::$currencies;
	}
	
	public function pjActionCheckCurrency()
	{
		$params = $this->getParams();
		
		if (!isset($params['currency']) || empty($params['currency']))
		{
			return array('status' => 'ERR', 'code' => 100, 'text' => 'Missing or empty \'currency\' parameter');
		}
		
		$currency = strtoupper($params['currency']);
		
		if (!in_array($currency, self::$currencies))
		{
			return array(
				'status' => 'ERR', 
				'code' => 101, 
				'text' => sprintf(__('plugin_authorize_currency_not_supported', true), $currency),
				'currency' => $currency,
				'currencies' => self::$currencies,
			);
		}
		
		return array(
			'status' => 'OK', 
			'code' => 200, 
			'text' => sprintf(__('plugin_authorize_currency_supported', true), $currency),
			'currency' => $currency,
			'currencies' => self::$currencies,
		);
	}
                                            
	public function pjActionConfirm()
	{
		$params = $this->getParams();
        $request = $params['request'];

		if (!isset($params['key']) || $params['key'] != md5($this->option_arr['private_key'] . PJ_SALT))
		{
            $this->log(self::$logPrefix . "Missing or invalid 'key' parameter.");
			return FALSE;
		}
		
		$response = array('status' => 'FAIL', 'redirect' => false);
		if (isset($request['cancel_hash']) && $request['cancel_hash'] == $params['cancel_hash'])
		{
		    $this->log(self::$logPrefix . "Payment was cancelled.");
		    $response['status'] = 'CANCEL';
		    $response['redirect'] = true;
		    return $response;
		}

        $options = pjPaymentOptionModel::factory()->getOptions($params['foreign_id'], self::$paymentMethod);
        
        if ((int) $options['is_test_mode'] === 1)
        {
        	$merchant_id = $options['test_merchant_id'];
        	$public_key  = $options['test_public_key'];
        	$private_key = $options['test_private_key'];
        	$sandbox     = true;
        } else {
        	$merchant_id = $options['merchant_id'];
        	$public_key  = $options['public_key'];
        	$private_key = $options['private_key'];
        	$sandbox     = false;
        }
		
		$sdk = new pjAuthorizeSDK($merchant_id, $public_key, $private_key, $sandbox);
		
		try {
			
			if (isset($request['subscriptionId']) && !empty($request['subscriptionId']) && isset($request['resultCode']) && strtoupper($request['resultCode']) == 'OK')
			{
				$response['status'] = 'OK';
				$response['txn_id'] = $request['subscriptionId'];
				$this->log(self::$logPrefix . "Payment was successful. Subscrition ID: {$request['subscriptionId']}.");
			} else {
				if (array_key_exists('x_trans_id', $request))
				{
					$id = $request['x_trans_id'];
					
				} elseif (array_key_exists('transId', $request)) {
					
					$id = $request['transId'];
					
				} else {
					$id = null;
				}
				
				$transaction = $sdk->getTransactionDetails($id);
				
				if ((int) $transaction['responseCode'] === 1)
				{
					$response['status'] = 'OK';
					$response['txn_id'] = $transaction['transId'];
					$this->log(self::$logPrefix . "Payment was successful. Transaction ID: {$transaction['transId']}.");
				} else {
					$response['response_reason_code'] = $transaction['responseReasonCode'];
					$response['response_code']        = $transaction['responseCode'];
					$response['response_reason_text'] = $transaction['responseReasonDescription'];
					$this->log(self::$logPrefix . "Payment was not successful. " . sprintf('Reason text: %s | Reason code: %s | Code: %s', $transaction['responseReasonDescription'], $transaction['responseReasonCode'], $transaction['responseCode']));
				}
			}
		} catch (Exception $e) {
			$this->log(self::$logPrefix . $e->getMessage());
		}

		return $response;
	}
	
	public function pjActionForm()
	{
        $this->setLayout('pjActionEmpty');

        $params = $this->getParams();
        
        $sdk = new pjAuthorizeSDK($params['merchant_id'], $params['public_key'], $params['private_key'], $params['is_test_mode']);
        
        try {
        	
        	$params['hostedPaymentToken'] = $sdk->getClientToken(
        		$params['amount'], 
        		$params['custom'], 
        		$params['description'], 
        		$params['notify_url'], 
        		$params['cancel_url'], 
        		PJ_INSTALL_URL .'authorize-iframe-communicator.html',
        		__('plugin_authorize_pay_btn_title', true), 
        		__('plugin_authorize_continue_btn_title', true), 
        		__('plugin_authorize_cancel_btn_title', true)
        	);
        	
        } catch (Exception $e) {
        	echo $e->getMessage();
        }
        
        $this->set('arr', $params);
	}
	
	public function pjActionSubscribe()
	{
		$this->setLayout('pjActionEmpty');
	
		$params = $this->getParams();
	
		$sdk = new pjAuthorizeSDK($params['merchant_id'], $params['public_key'], $params['private_key'], $params['is_test_mode']);
	
		try {
		    
		    $params['hostedPaymentToken'] = $sdk->getClientToken(
		        $params['amount'],
		        $params['custom'],
		        $params['description'],
		        $params['notify_url'],
		        $params['cancel_url'],
		        PJ_INSTALL_URL .'authorize-iframe-communicator.html',
		        __('plugin_authorize_pay_btn_title', true),
		        __('plugin_authorize_continue_btn_title', true),
		        __('plugin_authorize_cancel_btn_title', true)
		    );
		    
		} catch (Exception $e) {
		    echo $e->getMessage();
		}
		
		$config = array();
		$config['sandbox']	   = (int) $params['is_test_mode'];
		$config['merchant_id'] = $params['merchant_id'];
		$config['public_key']  = $params['public_key'];
		$config['private_key'] = $params['private_key'];
		
		$_SESSION[self::$config] = $config;
		
		$this->set('arr', array_merge($params, $config));
	}
	
	public function pjActionGetCustomer()
	{
	    $this->setAjax(true);
	    $this->setLayout('pjActionEmpty');
	    	    
	    $time = time();
	    if (!isset($_SESSION[self::$error]))
	    {
	        $_SESSION[self::$error] = array();
	    }
	    
	    if (!(isset($_SESSION[self::$config]) && is_array($_SESSION[self::$config])))
	    {
	        $_SESSION[self::$error][$time] = __('plugin_braintree_config_missing', true);
	        self::jsonResponse(array('status' => 'ERR', 'code' => 102, 'text' => '', 'tm' => $time));
	    }
	    
	    $config = $_SESSION[self::$config];
	    
	    if (class_exists('pjInput'))
	    {
	        $transId = $this->_post->toString('transId');
	        $amount = $this->_post->toString('amount');
	        $custom = $this->_post->toString('custom');
	        $description = $this->_post->toString('description');
	    } else {
	        $transId = isset($_POST['transId']) ? $_POST['transId'] : NULL;
	        $amount = isset($_POST['amount']) && is_numeric($_POST['amount']) ? $_POST['amount'] : NULL;
	        $custom = isset($_POST['custom']) && !empty($_POST['custom']) ? $_POST['custom'] : NULL;
	        $description = isset($_POST['description']) && !empty($_POST['description']) ? $_POST['description'] : NULL;
	    }
	    
	    $sdk = new pjAuthorizeSDK($config['merchant_id'], $config['public_key'], $config['private_key'], $config['sandbox']);
	    
	    try {
	        # 1. Create customer
	        $customer = $sdk->createCustomer($transId);
	        
	        $customerProfileId = $customer['customerProfileId'];
	        $customerPaymentProfileId = $customer['customerPaymentProfileIdList'][0];
	        
	        # 2. Get customer payment profile
	        $profile = $sdk->getCustomerPaymentProfile($customerProfileId, $customerPaymentProfileId);
	        
	        $payment = array();
	        if (isset($profile['paymentProfile']['payment']['creditCard']))
	        {
	            $payment['creditCard'] = array(
	                'cardNumber' => $profile['paymentProfile']['payment']['creditCard']['cardNumber'],
	                'expirationDate' => $profile['paymentProfile']['payment']['creditCard']['expirationDate'],
	            );
	        }
	        $billTo = array();
	        if (isset($profile['paymentProfile']['billTo']))
	        {
	            $billTo = $profile['paymentProfile']['billTo'];
	        }
	        $billTo['firstName'] = 'John'; //FIXME
	        $billTo['lastName'] = 'Doe'; // FIXME
	        
	        # 3. Update customer payment profile
	        $sdk->updateCustomerPaymentProfile($customerProfileId, $customerPaymentProfileId, $billTo, $payment);
	        
	        # 4. Create subscription
	        $sdk->createSubscription(
	            $amount, 
	            $custom, 
	            $description, 
	            $customerProfileId, 
	            $customerPaymentProfileId,
	            @$config['interval_length'], 
	            @$config['interval_unit']);
	        
	    } catch (Exception $e) {
	        $_SESSION[self::$error][$time] = $e->getMessage();
	        self::jsonResponse(array('status' => 'ERR', 'code' => 104, 'text' => 'An exception occured.', 'tm' => $time));
	    }
	    
	    self::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Customer and subscription has been created.'));
	}
	
	public function pjActionIframeCommunicator()
	{
		$this->setAjax(true);
		$this->setLayout('pjActionEmpty');
	}
	
	public function pjActionTest()
	{
		$this->setLayout('pjActionEmpty');
		
		$custom = array();
		if (class_exists('pjInput'))
		{
			if ($this->_get->has('foreign_id'))
			{
				$custom['foreign_id'] = $this->_get->raw('foreign_id');
			}
		} else {
			if (array_key_exists('foreign_id', $_GET))
			{
				$custom['foreign_id'] = $_GET['foreign_id'];
			}
		}
		$data = self::generateTestData($custom);
		
		$post = array(
			'payment_method' => self::$paymentMethod,
		);
		
		$order = array(
			'locale_id'     => $this->getLocaleId(),
			'return_url'    => PJ_INSTALL_URL . (class_exists('pjUtil') && method_exists('pjUtil', 'getWebsiteUrl') ? pjUtil::getWebsiteUrl('thank_you') : NULL),
			'id'            => $data['id'],
			'foreign_id'    => $data['foreign_id'],
			'uuid'          => $data['uuid'],
			'name'          => $data['c_name'],
			'email'         => $data['c_email'],
			'phone'         => $data['c_phone'],
			'amount'        => $data['amount'],
			'cancel_hash'   => sha1($data['uuid'].strtotime($data['created']).PJ_SALT),
			'currency_code' => isset($this->option_arr['o_currency']) ? $this->option_arr['o_currency'] : 'USD',
		);
		
		# Override parameters from query string, e.g. &foreign_id=2
		$qs = array();
		foreach (array_keys($order) as $key)
		{
			if (class_exists('pjInput'))
			{
				if ($this->_get->has($key))
				{
					$order[$key] = $this->_get->raw($key);
					$qs[$key] = $order[$key];
				}
			} else {
				if (array_key_exists($key, $_GET))
				{
					$order[$key] = $_GET[$key];
					$qs[$key] = $order[$key];
				}
			}
		}
		$this->set('qs', $qs);
		
		$params = self::getFormParams($post, $order);
		
		$params['interval_length'] = 1;
		$params['interval_unit'] = 'months';
		$params['cardNumber'] = '4111111111111111';
		$params['expirationDate'] = '2028-12';
		
		$this->set('params', $params);
	}
}
?>