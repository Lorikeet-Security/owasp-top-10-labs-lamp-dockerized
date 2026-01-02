<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pj2checkout extends pj2checkoutAppController
{
	protected static $logPrefix = "Payments | pj2checkout plugin<br>";
	
	protected static $paymentMethod = '2checkout';
    
    public function pjActionOptions()
    {
        $this->checkLogin();

        $this->setLayout('pjActionEmpty');

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

        $params['locale'] = self::getPaymentLocale($params['locale_id']);

        return $params;
    }

    public static function getPaymentLocale($localeId = null)
    {
        $locale = 'en'; // English (default)

        if ($localeId && $locale_arr = pjLocaleModel::factory()->select('language_iso')->find($localeId)->getData())
        {
            $lang = strtok($locale_arr['language_iso'], '-');
            if (in_array($locale_arr['language_iso'], array('es', 'es-ES')))
            {
                $lang = 'es_ib';
                
            } elseif (strpos($locale_arr['language_iso'], '-SE')) {
                
            	$lang = 'sv';
                
            } elseif (strpos($locale_arr['language_iso'], '-NO') || in_array($locale_arr['language_iso'], array('nb', 'nn'))) {
                $lang = 'no';
            }

            $locales = array(
                'zh' => 'zh', // Chinese
                'da' => 'da', // Danish
                'nl' => 'nl', // Dutch
                'fr' => 'fr', // French
                'de' => 'gr', // German
                'el' => 'el', // Greek
                'it' => 'it', // Italian
                'ja' => 'jp', // Japanese
                'no' => 'no', // Norwegian
                'pt' => 'pt', // Portuguese
                'sl' => 'sl', // Slovenian
                'es_ib' => 'es_ib', // European Spanish
                'es' => 'es_la', // Latin Spanish
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
        $custom = isset($request['cart_order_id'])? $request['cart_order_id']: (isset($request['li_0_product_id'])? $request['li_0_product_id'] : null);

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
		
		$this->set('arr', $this->getParams());
	}
	
	public function pjActionSubscribe()
	{
		$this->setLayout('pjActionEmpty');
	
		$this->set('arr', $this->getParams());
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

        $is_test_mode = (int) $options['is_test_mode'] === 1;
        if ($is_test_mode)
        {
        	$_private_key = 'test_private_key';
        	$_merchant_id = 'test_merchant_id';
        } else {
        	$_private_key = 'private_key';
        	$_merchant_id = 'merchant_id';
        }
        
        if (!(isset($options[$_private_key], $options[$_merchant_id], $request['total'])))
        {
            $this->log(self::$logPrefix . "Missing, empty or invalid parameters.");
            return $response;
        }
        
        $hashOrder = $request['order_number'];
        if ($is_test_mode || $request['demo'] == 'Y')
        {
            $hashOrder = "1";
        }

        $StringToHash = strtoupper(md5($options[$_private_key] . $options[$_merchant_id] . $hashOrder . $request['total']));
			
		if ($StringToHash == $request['key'])
        {
            $response['status'] = 'OK';
            $response['txn_id'] = $request['order_number'];
            $this->log(self::$logPrefix . "Payment was successful. TXN ID: {$response['txn_id']}.");
		} else {
			$this->log(self::$logPrefix . "Key: " . $request['key']);
			$this->log(self::$logPrefix . "StringToHash: " . $StringToHash);
            $this->log(self::$logPrefix . "Payment was not successful. Hash mismatch.");
		}
		
		return $response;
	}
	
	public function pjActionTest()
	{
		$this->setLayout('pjActionEmpty');
		
		$data = self::generateTestData();
		
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
		
		$params['recurrence'] = '1 Month';
		$params['duration'] = '1 Year';
		
		$this->set('params', $params);
	}
}
?>