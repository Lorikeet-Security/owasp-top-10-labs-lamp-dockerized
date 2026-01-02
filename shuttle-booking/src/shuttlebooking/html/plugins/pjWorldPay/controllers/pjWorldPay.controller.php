<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjWorldPay extends pjWorldPayAppController
{
    protected static $logPrefix = "Payments | pjWorldPay plugin<br>";
    
    protected static $paymentMethod = 'world_pay';

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
            if (in_array($locale_arr['language_iso'], array('zh-TW')))
            {
                $lang = 'tw';
            } elseif (strpos($locale_arr['language_iso'], '-FI')) {
                $lang = 'fi';
            } elseif (strpos($locale_arr['language_iso'], '-NO') || in_array($locale_arr['language_iso'], array('nb', 'nn'))) {
                $lang = 'no';
            } elseif ($locale_arr['language_iso'] == 'pt-BR') {
                $lang = 'pt_br';
            } elseif (strpos($locale_arr['language_iso'], '-RU')) {
                $lang = 'ru';
            } elseif (in_array($locale_arr['language_iso'], array('es', 'es-ES'))) {
                $lang = 'es_es';
            } elseif (strpos($locale_arr['language_iso'], '-SE')) {
                $lang = 'sv';
            }

            $locales = array(
                'bs' => 'bs', // Bosnian
                'bg' => 'bg', // Bulgarian
                'ca' => 'ca', // Catalan
                'zh' => 'zh', // Chinese - Simplified
                'tw' => 'zh_TW', // Chinese - Traditional
                'hr' => 'hr', // Croatian
                'cs' => 'cs', // Czech
                'nl' => 'nl', // Dutch
                'et' => 'et', // Estonian
                'fi' => 'fi', // Finnish
                'fr' => 'fr', // French
                'de' => 'de', // German
                'el' => 'el', // Greek
                'hi' => 'hi', // Hindi
                'hu' => 'hu', // Hungarian
                'it' => 'it', // Italian
                'ja' => 'ja', // Japanese
                'ko' => 'ko', // Korean
                'lv' => 'lv', // Latvian
                'no' => 'no', // Norwegian
                'pl' => 'pl', // Polish
                'pt' => 'pt', // Portuguese
                'pt_br' => 'pt_BR', // Brazilian Portuguese
                'ro' => 'ro', // Romanian
                'ru' => 'ru', // Russian
                'si' => 'si', // Sinhalese (Sri Lanka)
                'sk' => 'sk', // Slovak
                'sl' => 'sl', // Slovenian
                'es_es' => 'es', // Spanish
                'es' => 'es_CO', // Colombian Spanish
                'sv' => 'sv', // Swedish
                'th' => 'th', // Thai
                'tr' => 'tr', // Turkish
                'cy' => 'cy', // Welsh
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
        $custom = isset($request['MC_uuid'])? $request['MC_uuid']: null;

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

    public function pjActionConfirm()
    {
        $params = $this->getParams();
        $request = $params['request'];

        if (!isset($params['key']) || $params['key'] != md5($this->option_arr['private_key'] . PJ_SALT))
        {
            $this->log(self::$logPrefix . "Missing or invalid 'key' parameter.");
            return FALSE;
        }

        if (!isset($request['pj_http_referer']) || empty($request['pj_http_referer']) || strpos($request['pj_http_referer'], '.worldpay.com') === false)
        {
            $this->log(self::$logPrefix . "Payment was not successful. The response is not coming from WorldPay.");
            return FALSE;
        }

        $response = array('status' => 'FAIL');

        $options = pjPaymentOptionModel::factory()->getOptions($params['foreign_id'], self::$paymentMethod);
        
        if ((int) $options['is_test_mode'] === 1)
        {
        	$private_key = $options['test_private_key'];
        } else {
        	$private_key = $options['private_key'];
        }

        if (isset($request['transStatus']) && !empty($request['transStatus']) && isset($request['callbackPW']) && !empty($request['callbackPW']))
        {
        	if ($request['callbackPW'] == $private_key)
            {
                if ($request['transStatus'] == 'Y')
                {
                    $response['status'] = 'OK';
                    $response['txn_id'] = $request['transId'];
                    $this->log(self::$logPrefix . "Payment was successful. TXN ID: {$response['txn_id']}.");
                } elseif ($request['transStatus'] == 'C') {
                    $response['status'] = 'CANCEL';
                    $response['txn_id'] = $request['transId'];
                    $this->log(self::$logPrefix . "Payment was cancelled. TXN ID: {$response['txn_id']}.");
                } else {
                    $this->log(self::$logPrefix . "Payment was not successful.");
                }
            } else {
                $this->log(self::$logPrefix . "Payment was not successful. Password mismatch.");
            }
        } else {
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
    	foreach (array_keys($order) as $key)
    	{
    		if (class_exists('pjInput'))
    		{
    			if ($this->_get->has($key))
    			{
    				$order[$key] = $this->_get->raw($key);
    			}
    		} else {
    			if (array_key_exists($key, $_GET))
    			{
    				$order[$key] = $_GET[$key];
    			}
    		}
    	}
    	
    	$params = self::getFormParams($post, $order);
    	
    	$this->set('params', $params);
    }
}
?>