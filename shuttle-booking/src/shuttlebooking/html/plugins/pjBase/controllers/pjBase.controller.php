<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjBase extends pjBaseAppController
{
	public $defaultUser = 'admin_user';
	
	public $defaultFields = 'admin_fields';
	
	public $defaultFieldsIndex = 'admin_index';
	
	public $defaultLocale = 'admin_locale_id';
	
	public $defaultDir = 'admin_locale_dir';
	
	public $defaultLang = 'admin_locale_lang';
	
	public $defaultCaptcha = 'admin_captcha';
	
	protected $requireLogin = true;
	
	public function __construct($requireLogin=null)
	{
		parent::__construct();
		
		$this->setLayout('pjActionBase');
	
		if (!is_null($requireLogin) && is_bool($requireLogin))
		{
			$this->requireLogin = $requireLogin;
		}
		if ($this->requireLogin && !$this->isInstaller())
		{
		    $_get = pjRegistry::getInstance()->get('_get');
		    if (!$this->isLoged() && !in_array($_get->toString('action'), array('pjActionLogin', 'pjActionForgot', 'pjActionCaptcha', 'pjActionCheckCaptcha', 'pjActionCheckReCaptcha', 'pjActionCheckLoginEmail', 'pjActionResendPassword', 'pjActionRun', 'pjActionReset', 'pjActionMessages')))
			{
				$next = NULL;
				if (isset($_SERVER['REQUEST_URI']) && !empty($_SERVER['REQUEST_URI']))
				{
					$next = '&next='.urlencode($_SERVER['REQUEST_URI']);
				}
				if (!$this->isXHR())
				{
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjBase&action=pjActionLogin");
				} else {
					header('HTTP/1.1 401 Unauthorized');
					exit;
				}
			}
		}
	}
	
	public function afterFilter()
	{
	    parent::afterFilter();
	    $this->appendJs('index.php?controller=pjBase&action=pjActionMessages', PJ_INSTALL_URL, true);
	}
	
	public function beforeFilter()
	{
	    parent::beforeFilter();
	    
	    $pjAuth = pjAuth::init();
	    $checkUser = $pjAuth->checkCurrentUser();
	    if($checkUser == false)
	    {
	        $pjAuth->doLogout();
	        if (!$this->isXHR())
	        {
	            pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjBase&action=pjActionLogin");
	        } else {
	            header('HTTP/1.1 401 Unauthorized');
	            return false;
	        }
	    }
	    
	    return true;
	}
	
	public function beforeRender()
	{
		
	}

    public function pjActionAfterInstall()
    {
        $this->setLayout('pjActionEmpty');

        $result = array('status' => 'OK', 'code' => 200, 'text' => 'Operation succeeded', 'info' => array());

        $arr = pjAuthUserModel::factory()->find(1)->getData();
        if ($arr)
        {
            pjBaseOptionModel::factory()
                ->where('foreign_id', $this->getForeignId())
                ->where('`key`', 'o_sender_email')
                ->limit(1)
                ->modifyAll(array('value' => $arr['email']));
            
			pjBaseOptionModel::factory()
                ->where('foreign_id', $this->getForeignId())
                ->where('`key`', 'o_sender_name')
                ->limit(1)
                ->modifyAll(array('value' => $arr['name']));
        }

        return $result;
    }
	
	public function pjActionCaptcha()
	{
	    $this->setAjax(true);
	    
	    header("Cache-Control: max-age=3600, private");
	    $rand = $this->_get->toString('rand') ? $this->_get->toString('rand') : null;
	    $patterns = null;
	    if(!empty($this->option_arr['o_captcha_background']) && $this->option_arr['o_captcha_background'] != 'plain')
	    {
	        $patterns = PJ_INSTALL_PATH . $this->getConst('PLUGIN_IMG_PATH') . 'captcha_patterns/' . $this->option_arr['o_captcha_background'];
	    }
	    $Captcha = new pjCaptcha(PJ_INSTALL_PATH . $this->getConst('PLUGIN_WEB_PATH') . 'obj/arialbd.ttf', $this->defaultCaptcha, (int) $this->option_arr['o_captcha_length']);
	    $Captcha->setImage($patterns)->setMode($this->option_arr['o_captcha_mode'])->init($rand);
	    exit;
	}

	public function pjActionCheckLoginEmail()
	{
	    $this->setAjax(true);

	    if ($this->isXHR())
        {
            $response = pjAuth::init(array('login_email' => $this->_get->toString('login_email')))->checkLoginEmail();
            self::jsonResponse($response);
        }
	    exit;
	}
	
	public function pjActionCheckCaptcha()
	{
	    $this->setAjax(true);
	    
	    if (!$this->_get->toString('login_captcha') || !pjCaptcha::validate($this->_get->toString('login_captcha'), $this->session->getData($this->defaultCaptcha))){
	        echo 'false';
	    }else{
	        echo 'true';
	    }
	    exit;
	}
	
	public function pjActionCheckReCaptcha()
	{
	    $this->setAjax(true);
	    $pjHttp = new pjHttp();
	    $pjHttp->curlRequest('https://www.google.com/recaptcha/api/siteverify?secret='.$this->option_arr['o_captcha_secret_key'].'&response='.$this->_get->toString('recaptcha'));
	    $verifyResponse = $pjHttp->getResponse();
	    $responseData = json_decode($verifyResponse);
	    echo $responseData->success ? 'true': 'false';
	    exit;
	}
	
	public function pjActionIndex()
	{
	    $this->checkLogin();

	    if(!empty($this->option_arr['o_dashboard']))
        {
            pjUtil::redirect($this->option_arr['o_dashboard']);
        } else {
	        pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjBaseOptions&action=pjActionIndex");
        }
	}
	
	public function pjActionMessages()
	{
		$this->setAjax(true);
		header("Content-Type: text/javascript; charset=utf-8");
	}
	
	public function pjActionLogin()
	{
	    $this->setLayout('pjActionAdminLogin');
	    
	    if(self::isPost() && $this->_post->toInt('login_user') == 1)
	    {
	        $data = array();
            $data['login_email'] = $this->_post->toString('login_email');
	        if(!$this->_post->toInt('two_factor'))
	        {
	        	# Validate captcha
	        	if ($this->option_arr['o_secure_login_use_captcha'] == 'Yes' && $this->option_arr['o_captcha_type'] == 'system')
	        	{
	        		if (!$this->_post->has('login_captcha') || !pjCaptcha::validate($this->_post->toString('login_captcha'), $this->session->getData($this->defaultCaptcha)))
	        		{
	        			pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjBase&action=pjActionLogin&err=44");
	        		}
        		}
	        	
                $data['login_password'] = $this->_post->toString('login_password');
	            $response = pjAuth::init($data)->doLogin();
    	        if($response['status'] == 'OK')
    	        {
    	            
    	            if(!empty($this->option_arr['o_dashboard']))
    	            {
    	                pjUtil::redirect($this->option_arr['o_dashboard']);
    	            }
    	            
    	        	if (!pjAuth::init()->isPasswordChangedOnTime())
    	        	{
    	        		pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjBaseUsers&action=pjActionUpdate&id=" . $this->getUserId() . "&change");
    	        	}
    	        	
   	        		pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjBaseOptions&action=pjActionIndex");
    	        	
    	            /*$response = pjAuth::init()->checkChangePassword();
    	            if($response['status'] == 'OK')
    	            {
    	                if(!empty($this->option_arr['o_dashboard']))
                        {
                            pjUtil::redirect($this->option_arr['o_dashboard']);
                        } else {
                            pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjBaseOptions&action=pjActionIndex");
                        }
    	            }else{
    	                if($response['code'] == '101')
    	                {
    	                    if(!empty($this->option_arr['o_dashboard']))
                            {
                                pjUtil::redirect($this->option_arr['o_dashboard']);
                            } else {
                                pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjBaseOptions&action=pjActionIndex");
                            }
    	                }else{
    	                    pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjBase&action=pjActionLogin");
    	                }
    	            }*/
    	        }else{
    	            pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjBase&action=pjActionLogin&err=" . $response['code']);
    	        }
	        }/*else{
	            $response = pjAuth::init($data)->checkEmailLogin();
	            if($response['status'] == 'OK')
	            {
	                pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjBase&action=pjActionLogin&msg=" . $response['code']);
	            }else{
	                pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjBase&action=pjActionLogin&err=" . $response['code']);
	            }
	        }*/
	    }
	    if(self::isGet())
	    {
            $apply_captcha = $this->option_arr['o_captcha_location'] == 'admin' && $this->option_arr['o_secure_login_use_captcha'] == 'Yes';
	        $this->set('apply_captcha', $apply_captcha);

	        $this->appendJs('pjBase.js', $this->getConst('PLUGIN_JS_PATH'));
	        if($this->option_arr['o_captcha_type'] == 'google')
	        {
	            $this->appendJs('https://www.google.com/recaptcha/api.js', NULL, true);
	        }
	    }
	}
	
	public function pjActionLogout()
	{
	    $response = pjAuth::init()->doLogout();
	    if($response['status'] == 'OK')
	    {
	       pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjBase&action=pjActionLogin");
	    }
	}

	public function pjActionResendPassword()
	{
	    $this->setAjax(true);

	    if (!$this->isXHR())
        {
            self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Missing headers.'));
        }
        
        if (!self::isPost())
        {
        	self::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'Invalid request.'));
        }
        
        $response = pjAuth::init(array('login_email' => $this->_post->toString('login_email')))->checkEmailLogin();
        self::jsonResponse($response);
	}

	public function pjActionForgot()
	{
	    $this->setLayout('pjActionAdminLogin');

	    if(self::isPost() && $this->_post->toInt('forgot_user') == 1)
	    {
	    	# Validate captcha
	    	if ($this->option_arr['o_forgot_use_captcha'] == 'Yes' && $this->option_arr['o_captcha_type'] == 'system')
	    	{
	    		if (!$this->_post->has('login_captcha') || !pjCaptcha::validate($this->_post->toString('login_captcha'), $this->session->getData($this->defaultCaptcha)))
	    		{
	    			pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjBase&action=pjActionForgot&err=44");
	    		}
	    	}
	    	
	        $data = array();
            $data['forgot_email'] = $this->_post->toString('forgot_email');

            $response = pjAuth::init($data)->doForgotPassword();
            if($response['status'] == 'OK')
            {
                pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjBase&action=pjActionLogin&msg=" . $response['code']);
            }else{
                pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjBase&action=pjActionForgot&err=" . $response['code']);
            }
	    }
	    if(self::isGet())
	    {
	        $this->appendJs('pjBase.js', $this->getConst('PLUGIN_JS_PATH'));
	        if($this->option_arr['o_captcha_type'] == 'google')
	        {
	            $this->appendJs('https://www.google.com/recaptcha/api.js', NULL, true);
	        }
	    }
	}
	
	public function pjActionReset()
	{
		$this->setLayout('pjActionAdminLogin');
		
		if ($this->_get->has('err'))
		{
			return;
		}
		
		if (!$this->_get->has('email', 'hash') || $this->_get->isEmpty('email') || $this->_get->isEmpty('hash'))
		{
			pjUtil::redirect(sprintf("%s?controller=pjBase&action=pjActionReset&err=33", $_SERVER['PHP_SELF']));
		}
		
		$pjAuthUserModel = pjAuthUserModel::factory();
		$user = $pjAuthUserModel
		->join("pjAuthRole", "t1.role_id=t2.id", "left outer")
		->where('t1.email', $this->_get->toString('email'))
		->where("t2.is_backend", 'T')
		->limit(1)
		->findAll()
		->getDataIndex(0);
		
		if (!$user)
		{
		    pjUtil::redirect(sprintf("%s?controller=pjBase&action=pjActionReset&err=32", $_SERVER['PHP_SELF']));
		}
		
		if ($this->_get->toString('hash') !== sha1(PJ_SALT . $this->_get->toString('email') . $user['pswd_modified'] . PJ_SALT))
		{
			pjUtil::redirect(sprintf("%s?controller=pjBase&action=pjActionReset&err=31", $_SERVER['PHP_SELF']));
		}
		
		$new_password = pjAuth::init()->generatePassword($this->option_arr);
		
		# Change password
		$pjAuthUserModel
			->reset()
			->set('id', $user['id'])
			->modify(array(
				'password' => $new_password,
			    'pswd_modified' => ':NOW()',
			));
			
		$this->set('new_password', $new_password);
	}
	
	public static function isBannedWords($string, $option_arr)
	{
	    if($option_arr['o_spam_banned_words'] == ''){
	        return false;
	    }else{
	        $banned_words = trim($option_arr['o_spam_banned_words']);
	        $banned_arr = explode(",", $banned_words);
	        foreach($banned_arr as $k => $v){
	            $banned_arr[$k] = trim($v);
	        }
	        $matches = array();
	        $matchFound = preg_match_all("/\b(" . implode($banned_arr,"|") . ")\b/i", $string, $matches);
	        if ($matchFound) {
	            return true;
	        }else{
	            return false;
	        }
	    }
	}
	
	public static function isBlockedIp($client_ip, $option_arr)
	{
		$ip_arr = !empty($option_arr['o_spam_banned_ip']) ? preg_split("/\r\n|\n|,|;/", $option_arr['o_spam_banned_ip']) : array();
		$ip_arr = array_filter(array_map('trim', $ip_arr));
		
		if (!$ip_arr)
		{
			return false;
		}
		
		return in_array($client_ip, $ip_arr);
	}
}
?>