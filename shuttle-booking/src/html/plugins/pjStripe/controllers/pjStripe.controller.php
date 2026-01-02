<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjStripe extends pjStripeAppController
{
    protected static $logPrefix = "Payments | pjStripe plugin<br>";
    
    protected static $paymentMethod = 'stripe';
    
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

    public static function cancelAuthorization($params)
    {
        $sdk = new pjStripeSDK(null, $params['public_key'], $params['private_key']);

        try {
            $result = $sdk->cancel($params['txn_id']);

            $retval = array('status' => 'OK', 'code' => 200, 'text' => 'Cancel authorization succeed.', 'result' => $result);
        } catch (Exception $e) {
            $retval = array('status' => 'ERR', 'code' => 100, 'text' => 'Cancel authorization failed: ' . $e->getMessage());
        }

        return $retval;
    }

    public static function captureFunds($params)
    {
        $sdk = new pjStripeSDK(null, $params['public_key'], $params['private_key']);

        $data = array(
            'amount_to_capture' => $params['amount'],
        );

        try {
            $result = $sdk->capture($params['txn_id'], $data);

            $retval = array('status' => 'OK', 'code' => 200, 'text' => 'Capture funds succeed.', 'result' => $result);
        } catch (Exception $e) {
            $retval = array('status' => 'ERR', 'code' => 100, 'text' => 'Capture funds failed: ' . $e->getMessage());
        }

        return $retval;
    }

    public static function getFormParams($post, $order_arr)
    {
        $params = parent::getFormParams($post, $order_arr);

        $params['locale'] = self::getPaymentLocale($params['locale_id']);
        $params['cancel_url'] = "{$params['notify_url']}&cancel_hash={$params['cancel_hash']}";
        $params['amount'] *= 100;

        return $params;
    }

    public static function getPaymentLocale($localeId = null)
    {
        $locale = 'en'; // English (default)

        if ($localeId && $locale_arr = pjLocaleModel::factory()->select('language_iso')->find($localeId)->getData())
        {
            $lang = strtok($locale_arr['language_iso'], '-');
            if (strpos($locale_arr['language_iso'], '-FI'))
            {
                $lang = 'fi';
            }
            elseif (strpos($locale_arr['language_iso'], '-NO') || in_array($locale_arr['language_iso'], array('nb', 'nn')))
            {
                $lang = 'no';
            }
            elseif (strpos($locale_arr['language_iso'], '-SE'))
            {
                $lang = 'sv';
            }

            $locales = array(
                'zh' => 'zh', // Simplified Chinese
                'da' => 'da', // Danish
                'nl' => 'nl', // Dutch
                'fi' => 'fi', // Finnish
                'fr' => 'fr', // French
                'de' => 'de', // German
                'it' => 'it', // Italian
                'ja' => 'ja', // Japanese
                'no' => 'no', // Norwegian
                'es' => 'es', // Spanish
                'sv' => 'sv', // Swedish
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
        $custom = isset($request['id'])? $request['id']: null;

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
		
		$data = array(
			'payment_method_types' => array('card'),
			'line_items' => array(
				array(
					'price_data' => array(
						'currency' => strtolower($params['currency_code']),
						'product_data' => array(
							'name' => @$params['item_name'],
							'description' => @$params['item_name'],
						),
						'unit_amount' => $params['amount'],
					),
					'quantity' => 1,
				)
			),
			'mode' => 'payment',
			'locale' => @$params['locale'],
			'success_url' => @$params['notify_url'] . '&id=' . @$params['custom'] .'&stripesessid={CHECKOUT_SESSION_ID}',
			'cancel_url' => @$params['cancel_url'] . '&id=' . @$params['custom'] .'&stripesessid={CHECKOUT_SESSION_ID}',
		);

		if (array_key_exists('place_a_hold', $params) && (int) $params['place_a_hold'] === 1)
        {
            $data['mode'] = 'payment';
            $data['payment_intent_data'] = array(
                'capture_method' => 'manual',
            );
        }
		
		$sdk = new pjStripeSDK(null, $params['public_key'], $params['private_key']);
		
		try {
			$result = $sdk->createSession($data);
			
			if (isset($result['id']))
			{
				$this->set('session_id', $result['id']);
			}
		} catch (Exception $e) {
			//echo $e->getMessage();
		}
		
		$this->set('arr', $params);
	}

	public function pjActionSubscribe()
	{
		$this->setLayout('pjActionEmpty');

		$params = $this->getParams();
		
		$data_product = array('name' => @$params['item_name']);
		
		$sdk = new pjStripeSDK(null, $params['public_key'], $params['private_key']);
		
		try {
			$result = $sdk->createProduct($data_product);
			if (isset($result['id']))
			{
				$product_id = $result['id'];

                $interval = isset($params['recurring_interval']) && in_array($params['recurring_interval'], array('month', 'year'))
                    ? $params['recurring_interval']
                    : 'month';

                $interval_count = isset($params['recurring_interval_count']) && is_numeric($params['recurring_interval_count'])
                    ? $params['recurring_interval_count']
                    : 1;

				$data_price = array(
                    'unit_amount' => $params['amount'],
                    'currency' => strtolower($params['currency_code']),
                    'recurring' => array(
                        'interval' => $interval,
                        'interval_count' => $interval_count,
                    ),
                    'product' => $product_id
				);
				$result = $sdk->createPrice($data_price);

				if (isset($result['id']))
				{
					$price_id = $result['id'];
					$data = array(
                        'mode' => 'subscription',
                        'payment_method_types' => array('card'),
                        'line_items' => array(
                            array(
                                'price' => $price_id,
                                'quantity' => 1
                            )
                        ),
                        'locale' => @$params['locale'],
                        'success_url' => @$params['notify_url'] . '&id=' . @$params['custom'] .'&stripesessid={CHECKOUT_SESSION_ID}',
                        'cancel_url' => @$params['cancel_url'] . '&id=' . @$params['custom'] .'&stripesessid={CHECKOUT_SESSION_ID}',
					);
					
					$result = $sdk->createSession($data);
				
					if (isset($result['id']))
					{
						$this->set('session_id', $result['id']);
					}
				} else {
					
				}
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		
		$this->set('arr', $params);
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
        if (isset($request['cancel_hash']) && $request['cancel_hash'] == $params['cancel_hash'])
        {
            $this->log(self::$logPrefix . "Payment was cancelled.");
            $response['status'] = 'CANCEL';
            return $response;
        }

        $options = pjPaymentOptionModel::factory()->getOptions($params['foreign_id'], self::$paymentMethod);

        $_response = $this->requestAction(array(
            'controller' => 'pjStripe',
            'action' => 'pjActionProcess',
            'params' => array(
                'key' => md5($this->option_arr['private_key'] . PJ_SALT),
            	'public_key' => (int) $options['is_test_mode'] === 1 ? $options['test_public_key'] : $options['public_key'],
            	'private_key' => (int) $options['is_test_mode'] === 1 ? $options['test_private_key'] : $options['private_key'],
                'amount' => $params['amount'] * 100,
                'currency' => $this->option_arr['o_currency'],
                'description' => pjSanitize::html(@$params['uuid']),
                'foreign_id' => $params['order_id'],
            	'session_id' => $request['stripesessid'], // Stripe session_id
            )
        ), array('return'));
        
        if ($_response['status'] == 'OK')
        {
            $response['status'] = 'OK';
            $response['txn_id'] = @$_response['result']['data']['object']['payment_intent'];
        }

        return $response;
    }

	public function pjActionProcess()
	{
		$params = $this->getParams();
		if (!isset($params['key']) || $params['key'] != md5($this->option_arr['private_key'] . PJ_SALT))
		{
            $this->log(self::$logPrefix . "Missing or invalid key parameter.");
            return array('status' => 'ERR', 'code' => 100, 'text' => 'Missing or invalid key parameter');
		}
		
		if (!(isset($params['session_id'], $params['private_key'], $params['amount'], $params['currency'])))
		{
            $this->log(self::$logPrefix . "Missing, empty or invalid parameters.");
            return array('status' => 'ERR', 'code' => 101, 'text' => 'Missing, empty or invalid parameters.');
		}
		
		$sdk = new pjStripeSDK(null, $params['public_key'], $params['private_key']);
		
		try {
			$events = $sdk->getEvents();
			
		} catch (Exception $e) {
			
			$this->log(self::$logPrefix . $e->getMessage());
			return array('status' => 'ERR', 'code' => 102, 'text' => $e->getMessage());
		}
		
		# Handle post-payment fulfillment
		$found = false;
		$completed = false;
		$event_id = NULL;
		$payment_id = NULL;
		$result = NULL;
		foreach ($events['data'] as $item)
		{
			if ($item['data']['object']['id'] == $params['session_id'] && $item['data']['object']['object'] == 'checkout.session')
			{
				$found = true;
				if ($item['type'] == 'checkout.session.completed')
				{
				    $event_id = $item['id'];
				    $payment_id = $item['data']['object']['payment_intent'];
				    $result = $item;
				    
					$completed = true;
					if (isset($params['foreign_id']))
					{
						$data = array_merge($params, array(
							'stripe_id' => $item['id'],
							'created' => $item['created']
						));
						self::pjActionSavePayment($params['foreign_id'], $data);
					}
				}
				break;
			}
		}
		
		if (!$found)
		{
			$this->log(self::$logPrefix . "Payment not found.");
			return array('status' => 'ERR', 'code' => 104, 'text' => 'Payment still not found.', 'result' => $events);
		}
		
		if (!$completed)
		{
			$this->log(self::$logPrefix . "Payment failed.");
			return array('status' => 'ERR', 'code' => 105, 'text' => 'Payment failed.', 'result' => $events);
		}
		
		$this->log(self::$logPrefix . "Payment completed. Event ID: {$event_id}. Payment ID: {$payment_id}");
		return array('status' => 'OK', 'code' => 200, 'text' => 'Payment completed.', 'result' => $result);
	}
	
	private static function pjActionSavePayment($foreign_id, $data)
	{
		return pjStripeModel::factory()
			->setAttributes(array(
				'foreign_id' => $foreign_id,
				'stripe_id' => @$data['stripe_id'],
				'token' => @$data['token'],
				'amount' => @$data['amount']/100,
				'currency' => @$data['currency'],
				'description' => @$data['item_name'],
				'created' => preg_match('|^\d{10}$|', @$data['created']) ? sprintf(':FROM_UNIXTIME(%u)', @$data['created']) : @$data['created']
			))
			->insert()
			->getInsertId();
	}
	
	public function pjActionGetDetails()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged())
		{
		    $id = null;
		    if (class_exists('pjInput'))
            {
                $id = $this->_get->toInt('id');
            } elseif (isset($_GET['id']) && (int) $_GET['id'] > 0) {
                $id = (int) $_GET['id'];
            }

			if ($id)
			{
				$this->set('arr', pjStripeModel::factory()->find($id)->getData());
			}
		}
	}
	
	public function pjActionGetStripe()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged())
		{
			$pjStripeModel = pjStripeModel::factory();

			$q = null;
			if (class_exists('pjInput'))
            {
                $q = $this->_get->toString('q');
            } elseif (isset($_GET['q']) && !empty($_GET['q'])) {
                $q = $pjStripeModel->escapeStr($_GET['q']);
            }
			if ($q)
			{
				$q = str_replace(array('%', '_'), array('\%', '\_'), $q);
				$pjStripeModel
					->where('t1.stripe_id LIKE', "%$q%")
					->orWhere('t1.token LIKE', "%$q%")
					->orWhere('t1.amount LIKE', "%$q%")
					->orWhere('t1.currency LIKE', "%$q%")
					->orWhere('t1.description LIKE', "%$q%")
					->orWhere('t1.created LIKE', "%$q%");
			}

			$column = 'created';
			$direction = 'DESC';
			if (class_exists('pjInput'))
            {
                if (in_array(strtoupper($this->_get->toString('direction')), array('ASC', 'DESC')))
                {
                    $column = $this->_get->toString('column');
                    $direction = strtoupper($this->_get->toString('direction'));
                }
            } elseif (isset($_GET['direction']) && isset($_GET['column']) && in_array(strtoupper($_GET['direction']), array('ASC', 'DESC'))) {
                $column = $_GET['column'];
                $direction = strtoupper($_GET['direction']);
            }
	
			$total = $pjStripeModel->findCount()->getData();
			if (class_exists('pjInput'))
            {
                $rowCount = $this->_get->toInt('rowCount') ?: 10;
    			$page = $this->_get->toInt('page') ?: 1;
            } else {
                $rowCount = isset($_GET['rowCount']) && (int) $_GET['rowCount'] > 0 ? (int) $_GET['rowCount'] : 10;
                $page = isset($_GET['page']) && (int) $_GET['page'] > 0 ? intval($_GET['page']) : 1;
            }
            $pages = ceil($total / $rowCount);
            $offset = ((int) $page - 1) * $rowCount;
			if ($page > $pages)
			{
				$page = $pages;
			}
	
			$data = $pjStripeModel
			    ->orderBy("`$column` $direction")
				->limit($rowCount, $offset)
				->findAll()
				->getData();
	
			pjAppController::jsonResponse(compact('data', 'total', 'pages', 'page', 'rowCount', 'column', 'direction'));
		}
		exit;
	}
	
	public function pjActionIndex()
	{
	    if (!$this->isLoged())
        {
            $this->sendForbidden();
            return;
        }

        $this->appendJs('pjStripe.js', $this->getConst('PLUGIN_JS_PATH'));
        if (pjObject::getPlugin('pjCms') !== null)
        {
            $this->appendJs('jquery.datagrid.js', $this->getConstant('pjCms', 'PLUGIN_JS_PATH'), false, false);
            $this->appendJs('index.php?controller=pjCms&action=pjActionMessages', PJ_INSTALL_URL, true);
        } else {
            $this->appendJs('jquery.datagrid.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
            $this->appendJs('index.php?controller=pjAdmin&action=pjActionMessages', PJ_INSTALL_URL, true);
        }
	}
	
	public function pjActionTest()
	{
		$this->setLayout('pjActionEmpty');
		
		$data = self::generateTestData(array('amount' => '1.00'));
		
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
			'currency_code' => 'USD',
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
		
		$params['interval'] = 'month';
		
		$this->set('params', $params);
	}
}