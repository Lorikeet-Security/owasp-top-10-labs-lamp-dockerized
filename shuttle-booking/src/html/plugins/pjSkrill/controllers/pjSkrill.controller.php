<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjSkrill extends pjSkrillAppController
{
    protected static $paymentMethod = 'skrill';

    protected static $logPrefix = "Payments | pjSkrill plugin<br>";

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
        $params['cancel_url'] = "{$params['notify_url']}&transaction_id={$params['custom']}&cancel_hash={$params['cancel_hash']}";

        return $params;
    }

    public static function getPaymentLocale($localeId = null)
    {
        $locale = 'EN'; // English (default)

        if ($localeId && $locale_arr = pjLocaleModel::factory()->select('language_iso')->find($localeId)->getData())
        {
            $lang = strtok($locale_arr['language_iso'], '-');
            if (strpos($locale_arr['language_iso'], '-RU'))
            {
                $lang = 'ru';
                
            } elseif(strpos($locale_arr['language_iso'], '-FI')) {
             
                $lang = 'fi';
                
            } elseif(strpos($locale_arr['language_iso'], '-SE')) {
            	
                $lang = 'sv';
            }

            $locales = array(
                'bg' => 'BG', // Bulgarian
                'cs' => 'CS', // Czech
                'da' => 'DA', // Danish
                'de' => 'DE', // German
                'el' => 'EL', // Greek
                'es' => 'ES', // Spanish
                'fi' => 'FI', // Finnish
                'fr' => 'FR', // French
                'it' => 'IT', // Italian
                'zh' => 'ZH', // Chinese
                'nl' => 'NL', // Dutch
                'pl' => 'PL', // Polish
                'ro' => 'RO', // Romanian
                'ru' => 'RU', // Russian
                'sv' => 'SV', // Swedish
                'tr' => 'TR', // Turkish
                'ja' => 'JA', // Japanese
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
        $custom = isset($request['transaction_id'])? $request['transaction_id']: null;

        if(!empty($custom))
        {
            $this->log(self::$logPrefix . "Start confirmation process for: {$custom}<br>Request Data:<br>" . print_r($request, true));
        }
        else
        {
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
        if(isset($request['cancel_hash']) && $request['cancel_hash'] == $params['cancel_hash'])
        {
            $this->log(self::$logPrefix . "Payment was cancelled.");
            $response['status'] = 'CANCEL';
            return $response;
        }

        $options = pjPaymentOptionModel::factory()->getOptions($params['foreign_id'], self::$paymentMethod);
        
        if ((int) $options['is_test_mode'] === 1)
        {
        	$private_key = $options['test_private_key'];
        	$merchant_email = $options['test_merchant_email'];
        } else {
        	$private_key = $options['private_key'];
        	$merchant_email = $options['merchant_email'];
        }

        if(isset($request['pay_to_email']) && !empty($request['pay_to_email']) && $request['pay_to_email'] == $merchant_email && isset($request['merchant_id']) && !empty($request['merchant_id']))
        {
        	$md5sig = strtoupper(md5($request['merchant_id'] . $request['transaction_id'] . strtoupper(md5($private_key)) . $request['mb_amount'] . $request['mb_currency'] . $request['status']));
            if($request['md5sig'] == $md5sig)
            {
                if(isset($request['status']) && $request['status'] == '2')
                {
                    $response['status'] = 'OK';
                    $response['txn_id'] = $request['mb_transaction_id'];
                    $this->log(self::$logPrefix . "Payment was successful. TXN ID: {$response['txn_id']}.");
                }else{
                    $this->log(self::$logPrefix . "Transaction is not processed.");
                }
            }
            else
            {
                $this->log(self::$logPrefix . "Payment was not successful. Hash mismatch.");
            }
        } else if(isset($request['transaction_id']) && !empty($request['transaction_id']) && isset($request['msid']) && !empty($request['msid'])) {
			$response['status'] = 'OK';
            $response['txn_id'] = $request['transaction_id'];
            $this->log(self::$logPrefix . "Payment was successful. TXN ID: {$request['transaction_id']}.");
        }else{
            $this->log(self::$logPrefix . "Missing, empty or invalid parameters.");
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
    	
    	$params['rec_period'] = 1;
    	$params['rec_cycle'] = 'month';
    	
    	$this->set('params', $params);
    }
}
?>