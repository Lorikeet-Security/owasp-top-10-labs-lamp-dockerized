<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjMollie extends pjMollieAppController
{
	protected static $logPrefix = "Payments | pjMollie plugin<br>";
	
	protected static $paymentMethod = 'mollie';

    protected static function allowCORS()
    {
        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '*';
        header('P3P: CP="ALL DSP COR CUR ADM TAI OUR IND COM NAV INT"');
        header("Access-Control-Allow-Origin: $origin");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With");
    }
    
    public function __construct()
    {
        parent::__construct();
        if (!headers_sent())
        {
        	self::allowCORS();
        }
    }

    public function pjActionOptions()
    {
        $this->checkLogin();

        $this->setLayout('pjActionEmpty');

        $params = $this->getParams();

        $this->set('arr', pjPaymentOptionModel::factory()->getOptions($params['foreign_id'], self::$paymentMethod));
        $this->set('active_option_arr', pjMollieOptionModel::factory()->where('foreign_id', $params['foreign_id'])->where('is_active', 1)->findAll()->getDataPair('method', 'method'));
        
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

        $pjMollieOptionModel = pjMollieOptionModel::factory();

        $params = $this->getParams();
        $foreign_id = is_null($params['foreign_id']) ? ':NULL' : $params['foreign_id'];
        $savedMethods = array();

        $option_arr = $pjMollieOptionModel->where('foreign_id', $params['foreign_id'])->findAll()->getDataPair('method');
        if (isset($params['data']['methods']) && !empty($params['data']['methods']))
        {
            foreach ($params['data']['methods'] as $method => $is_active)
            {
                $pjMollieOptionModel->reset();
                if (array_key_exists($method, $option_arr))
                {
                    $pjMollieOptionModel->set('id', $option_arr[$method]['id'])->modify(array('is_active', $is_active));
                } else {
                    $pjMollieOptionModel->setAttributes(array(
                        'foreign_id' => $foreign_id,
                        'method' => $method,
                        'is_active' => 1,
                    ))->insert();
                }
                $savedMethods[] = $method;
            }
            $pjMollieOptionModel->reset();
			if (is_numeric($foreign_id))
			{
				$pjMollieOptionModel->where('foreign_id', $foreign_id);
			} else {
				$pjMollieOptionModel->where('foreign_id IS NULL');
			}			
			$pjMollieOptionModel->whereNotIn('method', $savedMethods)->eraseAll();
        } else {
            $pjMollieOptionModel->reset()->where('foreign_id', $foreign_id)->eraseAll();
        }

        return true;
    }

    public function pjActionCopyOptions()
    {
        $this->checkLogin();

        $pjMollieOptionModel = pjMollieOptionModel::factory();

        $params = $this->getParams();
        $from_foreign_id = is_null($params['from_foreign_id'])? ':NULL': $params['from_foreign_id'];
        $to_foreign_id = is_null($params['to_foreign_id'])? ':NULL': $params['to_foreign_id'];

        $pjMollieOptionModel->reset()->where('foreign_id', $to_foreign_id)->eraseAll();

        $option_arr = $pjMollieOptionModel->reset()->where('foreign_id', $from_foreign_id)->findAll()->getDataPair('method', 'method');
        foreach ($option_arr as $method)
        {
            $pjMollieOptionModel->setAttributes(array(
                'foreign_id' => $to_foreign_id,
                'method' => $method,
                'is_active' => 1,
            ))->insert();
        }

        return true;
    }

    public function pjActionDeleteOptions()
    {
        $this->checkLogin();

        $params = $this->getParams();
        if (is_array($params['foreign_id']))
        {
            $foreign_id = $params['foreign_id'];
        } else {
            $foreign_id = array(is_null($params['foreign_id'])? ':NULL': $params['foreign_id']);
        }

        pjMollieOptionModel::factory()->whereIn('foreign_id', $foreign_id)->eraseAll();

        return true;
    }

    public static function getFormParams($post, $order_arr)
    {
        $params = parent::getFormParams($post, $order_arr);

        $params['locale'] = self::getPaymentLocale($params['locale_id']);
        $params['foreign_id'] = $order_arr['id'];
        $params['amount'] = number_format($params['amount'], 2, '.', '');
        $params['notify_url'] .= '&ref_id=' . $params['custom'];

        return $params;
    }

    public static function getPaymentLocale($localeId = null)
    {
        $locale = 'en_US'; // English (default)

        if ($localeId && $locale_arr = pjLocaleModel::factory()->select('language_iso')->find($localeId)->getData())
        {
            $lang = strtok($locale_arr['language_iso'], '-');
            if ($locale_arr['language_iso'] == 'nl-BE')
            {
                $lang = 'nl_be';
            } elseif ($locale_arr['language_iso'] == 'fr-BE') {
                $lang = 'fr_be';
            }

            $locales = array(
                'de' => 'de_DE', // German
                'es' => 'es_ES', // Spanish
                'fr' => 'fr_FR', // French
                'nl' => 'nl_NL', // Dutch
                'fr_be' => 'fr_BE', // French (Belgium)
                'nl_be' => 'nl_BE', // Dutch (Belgium)
            );

            if (array_key_exists($lang, $locales))
            {
                $locale = $locales[$lang];
            }
        }

        return $locale;
    }

    public function pjActionGetCustom()
    {
        $request = $this->getParams();
        $custom = isset($request['ref_id']) ? $request['ref_id'] : null;

        if (!empty($custom))
        {
            $this->log(self::$logPrefix . "Start confirmation process for: {$custom}<br>Request Data:<br>" . print_r($request, true));
        } else {
            $this->log(self::$logPrefix . "Missing parameters. Cannot start confirmation process.<br>Request Data:<br>" . print_r($request, true));
        }

        return $custom;
    }

    public function pjActionForm()
    {
        $this->setLayout('pjActionEmpty');

        $params = $this->getParams();

        $this->set('arr', $params);

        $avail_methods = $this->getAvailMethods($params);
        
        $enabled_methods = pjMollieOptionModel::factory()
            ->where('foreign_id', $params['option_foreign_id'])
            ->where('is_active', 1)
            ->findAll()
            ->getDataPair('method', 'method');
        
        $method_arr = array_intersect_key($enabled_methods, $avail_methods);

        $this->set('method_arr', $method_arr);
    }
    
    public function pjActionSubscribe()
    {
    	$this->setLayout('pjActionEmpty');
    
    	$params = $this->getParams();
    	$sdk = new pjMollieSDK(null, $params['public_key']);
    		
    	try {
    	
    		$customer = $sdk->createCustomer(array('name' => $params['first_name'] . ' ' . $params['last_name'], 'email' => $params['email']));
    	
    		if ($customer) {
    			$params['customer_id'] = $customer['id'];
    		}
    	} catch (Exception $e) {
    		$this->log(self::$logPrefix . "Error: " . $e->getMessage());
    	}
    	
		$this->set('arr', $params);

        $avail_methods = $this->getAvailMethods($params);
        
        $enabled_methods = pjMollieOptionModel::factory()
            ->where('foreign_id', $params['option_foreign_id'])
            ->where('is_active', 1)
            ->findAll()
            ->getDataPair('method', 'method');
        
        $method_arr = array_intersect_key($enabled_methods, $avail_methods);

        $this->set('method_arr', $method_arr);
    }
    
    public function pjActionGetUrl()
    {
        $this->setLayout('pjActionEmpty');
        $this->setAjax(true);
        
        if (class_exists('pjInput'))
        {
            $failure_url = $this->_post->toString('failure_url');
            $foreign_id  = $this->_post->toInt('foreign_id');
        } else {
            $pjAppModel  = pjAppModel::factory();
            $failure_url = @$_POST['failure_url'] ? $pjAppModel->escapeStr($_POST['failure_url']): null;
            $foreign_id  = (int) @$_POST['foreign_id'];
        }

        $response = array('status' => 'ERR', 'code' => 100, 'text' => 'Error', 'url' => $failure_url);

        if ($foreign_id)
        {
            if (class_exists('pjInput'))
            {
                $ref_id         = $this->_post->toString('custom');
                $redirectUrl    = $this->_post->toString('notify_url') . "&ref_id={$ref_id}";
                $method         = $this->_post->toString('mollie_method') ?: "ideal";
                $public_key     = $this->_post->toString('public_key');
                $amount         = $this->_post->toString('amount');
                $currency       = $this->_post->toString('currency');
                $description    = $this->_post->toString('description');
                $ideal_bank_id  = $this->_post->toString('ideal_bank_id');
                $locale         = $this->_post->toString('locale');
                $cancel_hash    = $this->_post->toString('cancel_hash');
            } else {
                $ref_id         = @$_POST['custom'] ? $pjAppModel->escapeStr($_POST['custom']): null;
                $redirectUrl    = @$_POST['notify_url'] ? $pjAppModel->escapeStr($_POST['notify_url']): null;
                $method         = @$_POST['mollie_method'] ? $pjAppModel->escapeStr($_POST['mollie_method']): "ideal";
                $public_key     = @$_POST['public_key'] ? $pjAppModel->escapeStr($_POST['public_key']): null;
                $amount         = @$_POST['amount'] ? $pjAppModel->escapeStr($_POST['amount']): null;
                $currency       = @$_POST['currency'] ? $pjAppModel->escapeStr($_POST['currency']): null;
                $description    = @$_POST['description'] ? $pjAppModel->escapeStr($_POST['description']): null;
                $ideal_bank_id  = @$_POST['ideal_bank_id'] ? $pjAppModel->escapeStr($_POST['ideal_bank_id']): null;
                $locale         = @$_POST['locale'] ? $pjAppModel->escapeStr($_POST['locale']): null;
                $cancel_hash    = @$_POST['cancel_hash'] ? $pjAppModel->escapeStr($_POST['cancel_hash']): null;
            }

            $params = array(
                'public_key'    => $public_key,
                'foreign_id'    => $foreign_id,
                'amount'        => $amount,
            	'currency'      => $currency,
                'description'   => $description,
                'ref_id'        => $ref_id,
                'redirectUrl'   => $redirectUrl,
                'method'        => $method,
                'bank_id'       => $method == 'ideal' && $ideal_bank_id? $ideal_bank_id: NULL,
                'locale'        => $locale,
            );
            
            if (isset($_POST['customer_id'])) {
            	$params['interval'] = $_POST['interval'];
            	$params['customerId'] = $_POST['customer_id'];
            	$params['sequenceType'] = $_POST['sequence_type'];
            }
            
            if ($cancel_hash)
            {
                $params['cancel_hash'] = $cancel_hash;
            }
            $payment_url = $this->getPaymentUrl($params);
            
            if (!empty($payment_url))
            {
            	$response['status'] = 'OK';
                $response['code'] = 200;
                $response['text'] = 'Success';
                $response['url']  = $payment_url;
            }
        }

        pjAppController::jsonResponse($response);
    }

    protected function getPaymentUrl($params)
	{
		$payment_url = NULL;
		if (!empty($params['public_key']))
		{
			$method = isset($params['method']) && in_array($params['method'], array('ideal', 'mistercash', 'sofort', 'creditcard', 'banktransfer', 'directdebit', 'belfius', 'paypal', 'bitcoin', 'podiumcadeaukaart', 'paysafecard', 'kbc')) 
				? $params['method'] 
				: "ideal";
			
			$paymentData = array(
				'method'       => $method,
				'amount'       => array(
					'value'    => $params['amount'],
					'currency' => $params['currency'],
				),
				'description'  => $params['description'],
				'redirectUrl'  => $params['redirectUrl'],
				'issuer'       => $params['bank_id'],
				'locale'       => $params['locale'],
				'metadata'     => array(
					'ref_id'     => $params['ref_id'],
					'foreign_id' => $params['foreign_id'],
				)
			);
				
			if (isset($params['customerId'])) {
				$paymentData['customerId'] = $params['customerId'];
				$paymentData['sequenceType'] = $params['sequenceType'];
			}
			
			$sdk = new pjMollieSDK(null, $params['public_key']);
			
			try {

                $txn_id = null;
                if (isset($params['cancel_hash']))
                {
                    $txn_id = 'CANCELLED';
                    $payment_url = $params['redirectUrl'] . "&cancel_hash={$params['cancel_hash']}";
                    
                } else {
                	
                	$payment = $sdk->createPayment($paymentData);
                	
                    $txn_id      = @$payment['id'];
                    $payment_url = @$payment['_links']['checkout']['href'];
                }
                
				if ($txn_id)
				{
					$id = pjMollieModel::factory(array(
						'foreign_id' => $params['foreign_id'],
						'ref_id'  => $params['ref_id'],
						'method'  => $params['method'],
						'bank_id' => $params['bank_id'],
						'interval' => isset($params['interval']) ? $params['interval'] : ':NULL',
						'customer_id' => isset($params['customerId']) ? $params['customerId'] : ':NULL',
						'type' => isset($params['customerId']) ? 'subscription' : 'regular',
						'txn_id'  => $txn_id,
						'amount'  => $params['amount'],
						'status'  => 'notpaid',
						'created' => date('Y-m-d H:i:s')
					))->insert()->getInsertId();
					
					if ($id)
					{
                        $this->log(self::$logPrefix . "Payment is saved. TXN ID: {$txn_id}.");
					}
				}
			} catch (Exception $e) {
                $this->log(self::$logPrefix . "Error: " . $e->getMessage());
			}
		} else {
            $this->log(self::$logPrefix . "Payment is not saved. Merchant ID is empty.");
		}
		
		return $payment_url;
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

        $response = array('status' => 'FAIL', 'redirect' => true);

        $options = pjPaymentOptionModel::factory()->getOptions($params['foreign_id'], self::$paymentMethod);
        $response['return_url'] = $options['failure_url'];
        
        if ((int) $options['is_test_mode'] === 1)
        {
        	$public_key = $options['test_public_key'];
        } else {
        	$public_key = $options['public_key'];
        }

        if (!isset($public_key) || (isset($public_key) && empty($public_key)) || !isset($request['ref_id']) || (isset($request['ref_id']) && empty($request['ref_id'])))
		{
            $this->log(self::$logPrefix . "Missing, empty or invalid parameters.");
			return $response;
		}

        if (isset($request['cancel_hash']) && $request['cancel_hash'] == $params['cancel_hash'])
        {
            $this->log(self::$logPrefix . "Payment was cancelled.");
            $response['status'] = 'CANCEL';
            return $response;
        }
		
		$pjMollieModel = pjMollieModel::factory();
		$payment_arr = $pjMollieModel->reset()->where('t1.ref_id', $request['ref_id'])->findAll()->getDataIndex(0);
		if (!empty($payment_arr))
		{
			$response['foreign_id'] = $payment_arr['foreign_id'];
			$response['txn_id'] = $payment_arr['txn_id'];
			
			$sdk = new pjMollieSDK(null, $public_key);
			
			try {
				
				$payment = $sdk->getPayment($payment_arr['txn_id']);
				
				if (isset($payment['paidAt']) && !empty($payment['paidAt']))
				{
					$response['status'] = 'OK';
					$pjMollieModel->reset()->set('id', $payment_arr['id'])->modify(array('status' => 'paid', 'processed_on' => ':NOW()'));
					if ($payment_arr['type'] == 'subscription')
					{
						$this->log(self::$logPrefix . "Customer ID: {$payment_arr['customer_id']}.");
						$this->log(self::$logPrefix . "Payment: " . print_r($payment_arr, true));
						$sdk->createSubscription($payment_arr['customer_id'], array('amount' => array('currency' => $this->option_arr['o_currency'], 'value' => $payment_arr['amount']),
								'interval' => $payment_arr['interval'],
								'description' => $payment_arr['ref_id']
						));
					}
						
                    $this->log(self::$logPrefix . "Payment was successful. TXN ID: {$response['txn_id']}.");
				
				} elseif ($payment['status'] == 'canceled' || $payment['status'] != 'open') {
					
					$response['status'] = 'CANCEL';
                    $this->log(self::$logPrefix . "Payment was cancelled.");
                    
				} else {
                    $this->log(self::$logPrefix . "Payment was not successful.");
                }
			} catch (Exception $e) {
                $this->log(self::$logPrefix . "Error: " . $e->getMessage());
			}
		} else {
            $this->log(self::$logPrefix . "Payment with Ref ID {$request['ref_id']} not found.");
		}
		
		return $response;
	}

	protected function getAvailMethods($params)
	{
		$mollie_methods_arr = array();
		if (!empty($params['public_key']))
		{
			$sdk = new pjMollieSDK(null, $params['public_key']);
			
			try {
				$mollie_methods = $sdk->getMethods();
				
				foreach ($mollie_methods as $method)
				{
					$mollie_methods_arr[$method['id']] = $method['id'];
				}
			} catch (Exception $e) {
				$this->log(self::$logPrefix . "Error: " . $e->getMessage());
			}
		}
		
		return $mollie_methods_arr;
	}

	public function pjActionGetAvailUsers()
	{
		$this->setLayout('pjActionEmpty');
		$params = $this->getParams();
		$issuers = array();
		if (!empty($params['public_key']))
		{
			$sdk = new pjMollieSDK(null, $params['public_key']);
			
			try {

				$ideal = $sdk->getMethod('ideal?include=issuers');
				$issuers = $ideal['issuers'];
				
			} catch (Exception $e) {}
		}
		
		return $issuers;
	}
	
	public function pjActionTest()
	{
		$this->setLayout('pjActionEmpty');
		
		$data = self::generateTestData();
		
		$post = array(
			'payment_method' => self::$paymentMethod,
		);
		
		$order = array(
			'locale_id'	    => $this->getLocaleId(),
			'return_url'    => PJ_INSTALL_URL . (class_exists('pjUtil') && method_exists('pjUtil', 'getWebsiteUrl') ? pjUtil::getWebsiteUrl('thank_you') : NULL),
			'id'		    => $data['id'],
			'foreign_id'    => $data['foreign_id'],
			'uuid'		    => $data['uuid'],
			'name'		    => $data['c_name'],
			'email'		    => $data['c_email'],
			'phone'		    => $data['c_phone'],
			'amount'		=> $data['amount'],
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
		
		$params['interval'] = '1 month';
		
		$this->set('params', $params);
	}
}
?>