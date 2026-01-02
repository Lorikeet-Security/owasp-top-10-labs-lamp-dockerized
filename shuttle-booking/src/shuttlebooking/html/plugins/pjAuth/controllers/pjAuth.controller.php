<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjAuth extends pjAuthAppController
{
    protected function addLoginAttempts($email)
    {
        $params = array();
        $params['email'] = $email;
        $params['ip'] = pjUtil::getClientIp();
        $pjAuthLoginAttemptModel = pjAuthLoginAttemptModel::factory();
        $id = $pjAuthLoginAttemptModel->setAttributes($params)->insert()->getInsertId();
        if ($id !== false && (int) $id > 0)
        {
            $this->session->setData($this->loginAttempts, $this->getLoginAttempts($email));
            return true;
        }else{
            return false;
        }
    }

    protected function getLoginAttempts($login_email)
    {
        return pjAuthLoginAttemptModel::factory()->where('email', $login_email)->findCount()->getData();
    }

    protected function lockAfterFailedAttempts($email)
    {
        $attempts = $this->getLoginAttempts($email);
        if($attempts >= (int) $this->option_arr['o_failed_login_lock_after'] && (int) $this->option_arr['o_failed_login_lock_after'] > 0)
        {
            pjAuthUserModel::factory()->where('email', $email)->limit(1)->modifyAll(array('locked' => 'T'));
        }
    }

    protected function checkAccountLocked($email)
    {
        return pjAuthUserModel::factory()->where('email', $email)->where('locked', 'T')->findCount()->getData() > 0 ? true : false;
    }

    protected function clearLoginAttempts($email)
    {
        pjAuthLoginAttemptModel::factory()->where('email', $email)->eraseAll();
        if($this->session->has($this->loginAttempts))
        {
            $this->session->unsetData($this->loginAttempts);
        }
    }

    protected function setFailedLoginNotifications($email)
    {
        $user = pjAuthUserModel::factory()->where('email', $email)->limit(1)->findAll()->getDataIndex(0);
        if ($user)
        {
            $attempts = $this->getLoginAttempts($email);

            $tokens = array(
                '{Title}' => @$user['title'],
                '{Name}' => $user['name'],
                '{Email}' => $user['email'],
                '{Phone}' => $user['phone'],
                '{LoginAttempts}' => $attempts,
                '{LoginAttemptsToLock}' => (int) $this->option_arr['o_failed_login_lock_after'],
            );
            if($attempts == (int) $this->option_arr['o_failed_login_send_email_after']) {
            	pjAuthUserModel::factory()->set('id', $user['id'])->modify(array('locked' => 'T'));
	            if($this->option_arr['o_failed_login_send_email'] == 'Yes')
	            {
	            	$subject = $this->getI18nContent("o_failed_login_send_email_subject", $this->getLocaleId());
					$message = $this->getI18nContent("o_failed_login_send_email_message", $this->getLocaleId());
					if (!empty($email) && !empty($subject) && !empty($message))
					{
						$subject = str_ireplace(array_keys($tokens), $tokens, $subject);
						$message = str_ireplace(array_keys($tokens), $tokens, $message);
					
						$pjEmail = self::getMailer($this->option_arr);
					
						$pjEmail
							->setTo($email)
							->setSubject(stripslashes($subject))
							->send($message);
					}
	            }
	            if($this->option_arr['o_failed_login_send_sms'] == 'Yes')
	            {
	                $message = $this->getI18nContent("o_failed_login_send_sms_message", $this->getLocaleId());
	                if (!empty($user['phone']) && !empty($message))
	                {
	                    $message = str_ireplace(array_keys($tokens), $tokens, $message);
	                    $params = array(
	                        'text' => $message,
	                        'number' => $user['phone'],
	                        'type' => 'unicode',
	                        'key' => md5($this->option_arr['private_key'] . PJ_SALT)
	                    );
	                    pjBaseSms::init($params)->pjActionSend();
	                }
	            }
            }
        }

        return $this;
    }

    protected function getI18nContent($field, $locale_id)
    {
        $content = NULL;
        $arr = pjBaseMultiLangModel::factory()
        ->select('t1.*')
        ->where('t1.foreign_id', 1)
        ->where('t1.model','pjBaseOption')
        ->where('t1.locale', $locale_id)
        ->where('t1.field', $field)
        ->limit(0, 1)
        ->findAll()
        ->getDataIndex(0);
        if(isset($arr['content']))
        {
            $content = $arr['content'];
        }
        return $content;
    }
    
    public static function generatePassword($options)
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789[\'^£$%&*()}{@#~?><>,|=_+!-]';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        $len = (int) $options['o_password_min_length'];
        if($len <= 8)
        {
            $len = 8;
        }
        for ($i = 0; $i < $len; $i++) {
            $n = rand(0, $alphaLength);
            $single_char = $alphabet[$n];
            while($options['o_password_special_symbol'] == 'No' && preg_match('/[\'^£$%&*()}{@#~?><>,|=_+!-]/', $single_char))
            {
                $n = rand(0, $alphaLength);
                $single_char = $alphabet[$n];
            }
            switch ($options['o_password_chars_used'])
            {
                case 'letters':
                    while(!preg_match('/[A-Za-z]/', $single_char))
                    {
                        $n = rand(0, $alphaLength);
                        $single_char = $alphabet[$n];
                    }
                    while(!preg_match('/[A-Z]/', $single_char) && $options['o_password_capital_letter'] == 'Yes')
                    {
                        $n = rand(0, $alphaLength);
                        $single_char = $alphabet[$n];
                    }
                    break;
                case 'digits':
                    while(!preg_match('/[0-9]/', $single_char))
                    {
                        $n = rand(0, $alphaLength);
                        $single_char = $alphabet[$n];
                    }
                    break;
                case 'both':
                    while(!(preg_match('/[A-Za-z]/', $single_char) || preg_match('/[0-9]/', $single_char)))
                    {
                        $n = rand(0, $alphaLength);
                        $single_char = $alphabet[$n];
                    }
                    while(!preg_match('/[A-Z]/', $single_char) && $options['o_password_capital_letter'] == 'Yes')
                    {
                        $n = rand(0, $alphaLength);
                        $single_char = $alphabet[$n];
                    }
                    break;
            }
            $pass[] = $single_char;
        }
        $password = implode($pass);

        return $password;
    }

    protected function sendTempPassword($id)
    {
        $user = pjAuthUserModel::factory()->find($id)->getData();
    
        $tokens = array(
            '{Name}' => $user['name'],
            '{Email}' => $user['email'],
            '{Phone}' => $user['phone'],
            '{Password}' => $user['password'],
        );

        if($this->option_arr['o_secure_login_send_password_to'] == 'email')
        {
            if(!empty($this->option_arr['o_secure_login_send_password_to_email_message']) && !empty($this->option_arr['o_secure_login_send_password_to_email_subject']))
            {
                $subject = str_ireplace(array_keys($tokens), $tokens, $this->option_arr['o_secure_login_send_password_to_email_subject']);
                $message = str_ireplace(array_keys($tokens), $tokens, $this->option_arr['o_secure_login_send_password_to_email_message']);
    
                $pjEmail = self::getMailer($this->option_arr);
    
                $pjEmail->setTo($user['email']);
                $pjEmail->setSubject(stripslashes($subject));
                
                if ($pjEmail->send($message))
                {
                	return array('status' => 'OK', 'code' => '200', 'text' => 'Temporary password has been sent!');
                } else {
                    return array('status' => 'ERR', 'code' => '15', 'text' => 'Failed when try to send a password via email.');
                }
            }else{
            	return array('status' => 'ERR', 'code' => '16', 'text' => 'Can not send an empty email message.');
            }
        }else{
        	if(!empty($user['phone']))
			{
				if(!empty($this->option_arr['o_secure_login_send_password_to_sms_message']))
				{
					$message = str_ireplace(array_keys($tokens), $tokens, $this->option_arr['o_secure_login_send_password_to_sms_message']);
					$pjSmsApi = new pjSmsApi();
					$response = $pjSmsApi
						->setType('unicode')
						->setNumber($user['phone'])
						->setText($message)
						->setSender(null)
						->send();
					if($response == 1)
					{
						return array('status' => 'OK', 'code' => '200', 'text' => 'An SMS has been sent successfully!');
					}else{
						return array('status' => 'ERR', 'code' => '20', 'text' => 'Failed when try to send a password via SMS.');
					}
				}else{
					return array('status' => 'ERR', 'code' => '18', 'text' => 'SMS transport is not activated.');
				}
			}else{
				return array('status' => 'ERR', 'code' => '19', 'text' => 'Empty phone.');
			}
        }
    }

    protected function initializePermissions()
    {
        $pair = array();
        $pjAuthUserPermissionModel = pjAuthUserPermissionModel::factory();
        $cnt = $pjAuthUserPermissionModel->where("t1.user_id", $this->getUserId())->findCount()->getData();
        if($cnt > 0)
        {
            $pair = $pjAuthUserPermissionModel
                ->reset()
                ->select("t1.*, t2.`key`")
                ->join('pjAuthPermission', 't2.id=t1.permission_id', 'left')
                ->where("t1.user_id", $this->getUserId())
                ->findAll()->getDataPair(null, 'key');
        }else{
            $pair = pjAuthRolePermissionModel::factory()
                ->select("t1.*, t2.`key`")
                ->join('pjAuthPermission', 't2.id=t1.permission_id', 'left')
                ->where("t1.role_id", $this->getRoleId())
                ->findAll()->getDataPair(null, 'key');
        }
        $this->session->setData($this->defaultPermissions, $pair);
    }

	public static function factory($controller=null, $action=null)
	{
		$registry = pjRegistry::getInstance();
		
		$params = array();
		
		if (empty($controller))
		{
			$get = $registry->get('_get');
			$params['controller'] = $get->toString('controller');
			$params['action'] = $get->toString('action');
		} else {
			$params['controller'] = $controller;
			if (!empty($action))
			{
				$params['action'] = $action;
			}
		}
		
		$inherits = $registry->is('inherits') ? $registry->get('inherits') : array();
		foreach ($inherits as $key => $val)
		{
			if (strpos($key, '::') !== false && (!isset($params['action']) || $key !== sprintf("%s::%s", $params['controller'], $params['action'])))
			{
				continue;
			}
			
			if (strpos($key, '::') === false && $key !== $params['controller'])
			{
				continue;
			}
			
			if (strpos($val, '::') !== false)
			{
				list($params['controller'], $params['action']) = explode('::', $val);
			} else {
				$params['controller'] = $val;
			}
			break;
		}
		
		return self::init($params);
    }
    
    public function validatePassword($password)
    {
        $option_arr = $this->option_arr;
        $errors = __('plugin_auth_pwd_error', true);
        if((int) $option_arr['o_password_min_length'] > strlen($password))
        {
            return array('status' => 'ERR', 'code' => '100', 'text' => sprintf($errors['100'], $option_arr['o_password_min_length']));
        }
        switch ($option_arr['o_password_chars_used']) {
            case 'letters':
                if (preg_match('/[0-9]/', $password))
                {
                    return array('status' => 'ERR', 'code' => '101', 'text' => $errors['101']);
                }
                if (!preg_match('/[A-Z]/', $password) && $option_arr['o_password_capital_letter'] == 'Yes')
                {
                    return array('status' => 'ERR', 'code' => '105', 'text' => $errors['105']);
                }
                break;
            case 'digits':
                if (preg_match('/[A-Za-z]/', $password))
                {
                    return array('status' => 'ERR', 'code' => '102', 'text' => $errors['102']);
                }
                break;
            case 'both':
                if (!(preg_match('/[A-Za-z]/', $password) && preg_match('/[0-9]/', $password)))
                {
                    return array('status' => 'ERR', 'code' => '103', 'text' => $errors['103']);
                }
                if (!preg_match('/[A-Z]/', $password) && $option_arr['o_password_capital_letter'] == 'Yes')
                {
                    return array('status' => 'ERR', 'code' => '105', 'text' => $errors['105']);
                }
                break;
        }
        if($option_arr['o_password_special_symbol'] == 'Yes')
        {
            if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+!-]/', $password))
            {
                return array('status' => 'ERR', 'code' => '104', 'text' => $errors['104']);
            }
        }
        return array('status' => 'OK', 'code' => 200);
    }
    
    public function getMasterAdminEmail()
    {
        $arr = pjAuthUserModel::factory()->limit(1)->orderBy("id ASC")->findAll()->getDataIndex(0);
        if(!empty($arr))
        {
            if(!empty($arr['email']))
            {
                return $arr['email'];
            }else{
                return NULL;
            }
        }else{
            return NULL;
        }
    }
    
    public function checkLoginEmail()
    {
        $params = $this->getParams();
        $email = $params['login_email'];

        $disable_form = false;
        $disable_form_text = '';
        $require_captcha = false;
        $remain_ts = 0;

        if(!empty($email))
        {
            $attempts = $this->getLoginAttempts($email);
            if($attempts > 0)
            {
                if($attempts >= (int) $this->option_arr['o_failed_login_disable_form_after'])
                {
                    $last_attempt = pjAuthLoginAttemptModel::factory()->where('email', $email)->limit(1)->orderBy("created DESC")->findAll()->getDataIndex(0);

                    $ts = 0;
                    $units = (int) $this->option_arr['o_failed_login_disable_form'];
                    switch ($this->option_arr['o_failed_login_disbale_form_unit']) {
                        case 'minutes':
                            $ts = $units * 60;
                        break;
                        case 'hours':
                            $ts = $units * 60 * 60;
                        break;
                        case 'days':
                            $ts = $units * 60 * 60 * 24;
                        break;
                        case 'weeks':
                            $ts = $units * 60 * 60 * 24 * 7;
                        break;
                        case 'months':
                            $ts = $units * 60 * 60 * 24 * 30;
                        break;
                    }
                    $last_attempt_ts = strtotime($last_attempt['created']);
                    if($last_attempt_ts + $ts > time())
                    {
                        $disable_form = true;
                        $remain_ts = ($last_attempt_ts + $ts) - time();
                    }
                }
                if($attempts >= (int) $this->option_arr['o_failed_login_required_captcha_after'])
                {
                    $require_captcha = true;
                }
            }
        }

        if ($disable_form)
        {
            $disable_form_text = str_ireplace('{REMAINING_TIME}', $this->secondsToTime($remain_ts), __('plugin_base_disabled_login_form_text', true));
        }

        return compact('disable_form', 'disable_form_text', 'require_captcha','remain_ts');
    }

    private function secondsToTime($inputSeconds) {
        $secondsInAMinute = 60;
        $secondsInAnHour = 60 * $secondsInAMinute;
        $secondsInADay = 24 * $secondsInAnHour;

        // Extract days
        $days = floor($inputSeconds / $secondsInADay);

        // Extract hours
        $hourSeconds = $inputSeconds % $secondsInADay;
        $hours = floor($hourSeconds / $secondsInAnHour);

        // Extract minutes
        $minuteSeconds = $hourSeconds % $secondsInAnHour;
        $minutes = floor($minuteSeconds / $secondsInAMinute);

        // Extract the remaining seconds
        $remainingSeconds = $minuteSeconds % $secondsInAMinute;
        $seconds = ceil($remainingSeconds);

        // Format and return
        $timeParts = array();
        $sections = array(
            'day' => (int)$days,
            'hour' => (int)$hours,
            'minute' => (int)$minutes,
            'second' => (int)$seconds,
        );

        foreach ($sections as $name => $value){
            if ($value > 0){
                $timeParts[] = $value. ' '.$name.($value == 1 ? '' : 's');
            }
        }

        return implode(', ', $timeParts);
    }

    /**
     * This function is used to check login email when Two-factor authentication is enabled.
     *
     * @return array
     */
    public function checkEmailLogin()
    {
        $params = $this->getParams();
        if (!$params['login_email'] || !pjValidation::pjActionNotEmpty($params['login_email']) || !pjValidation::pjActionEmail($params['login_email']))
        {
            return array('status' => 'ERR', 'code' => '4', 'text' => 'Missing, empty or invalid email.');
        }
        $pjAuthUserModel = pjAuthUserModel::factory();
        $user = $pjAuthUserModel
        ->join("pjAuthRole", "t1.role_id=t2.id", "left outer")
        ->where('t1.email', $params['login_email'])
        ->where("t2.is_backend", 'T')
        ->limit(1)
        ->findAll()
        ->getData();
        if (count($user) != 1)
        {
        	return array('status' => 'ERR', 'code' => '6', 'text' => 'User account not found.');
        }else{
            $user = $user[0];
            $data = array();
            $data['password'] = self::generatePassword($this->option_arr);
            $pjAuthUserModel->reset()->setAttributes(array('id' => $user['id']))->modify($data);
            $this->session->setData($this->defaultLoginEmail, $user['email']);
            $response = $this->sendTempPassword($user['id']);
            return $response;
        }
    }

    public function doLogin()
    {
        $params = $this->getParams();
        if (!$params['login_email'] || !$params['login_password'] || !pjValidation::pjActionNotEmpty($params['login_email']) || !pjValidation::pjActionNotEmpty($params['login_password']) || !pjValidation::pjActionEmail($params['login_email']))
        {
            return array('status' => 'ERR', 'code' => '4');
        }
        $is_backend = isset($params['is_backend']) ? $params['is_backend'] : 'T';
        $pjAuthUserModel = pjAuthUserModel::factory();
        if (isset($params['role_id']) && (int)$params['role_id'] > 0) {
        	$pjAuthUserModel->where('t1.role_id', (int)$params['role_id']);
        }
        $user = $pjAuthUserModel
            ->join("pjAuthRole", "t1.role_id=t2.id", "left outer")
            ->where('t1.email', $params['login_email'])
            ->where("t2.is_backend", $is_backend)
            ->limit(1)
            ->findAll()
            ->getData();

        if (count($user) != 1)
        {
            $this->addLoginAttempts($params['login_email']);
            $this->lockAfterFailedAttempts($params['login_email']);
            return array('status' => 'ERR', 'code' => '6');
        }else{
        	$pjAuthUserModel = $pjAuthUserModel->reset();
	        if (isset($params['role_id']) && (int)$params['role_id'] > 0) {
	        	$pjAuthUserModel->where('t1.role_id', (int)$params['role_id']);
	        }
            $user = $pjAuthUserModel
            	->join("pjAuthRole", "t1.role_id=t2.id", "left outer")
                ->where('t1.email', $params['login_email'])
				->where(sprintf("t1.password = AES_ENCRYPT('%s', '%s')", pjObject::escapeString($params['login_password']), PJ_SALT))
				->where("t2.is_backend", $is_backend)
                ->limit(1)
                ->findAll()
                ->getData();

            if (count($user) != 1)
            {
                $this->addLoginAttempts($params['login_email']);
                $this->lockAfterFailedAttempts($params['login_email']);
                $this->setFailedLoginNotifications($params['login_email']);
                return array('status' => 'ERR', 'code' => $this->checkAccountLocked($params['login_email']) ? '5' : '7');
            }else{
                $user = $user[0];
                unset($user['password']);
                if ($user['locked'] == 'T')
                {
                    return array('status' => 'ERR', 'code' => '5');
                }
                if ($user['status'] != 'T')
                {
                    $this->addLoginAttempts($params['login_email']);
                    $this->lockAfterFailedAttempts($params['login_email']);
                    $this->setFailedLoginNotifications($params['login_email']);
                    return array('status' => 'ERR', 'code' => $this->checkAccountLocked($params['login_email']) ? '5' : '3');
                }
                $current_login = date("Y-m-d H:i:s");
                $this->session->setData($this->defaultUser, $user);

                $login_token = sha1(time());
                $this->session->setData($this->defaultLoginToken, $login_token);

                $data = array();
                if(!empty($user['current_login']))
                {
                    $data['last_login'] = $user['current_login'];
                }
                $data['login_token'] = $login_token;
                $data['current_login'] = $current_login;
                $pjAuthUserModel->reset()->setAttributes(array('id' => $user['id']))->modify($data);
                if($this->session->has($this->defaultLoginEmail)){
                    $this->session->unsetData($this->defaultLoginEmail);
                }
                $this->clearLoginAttempts($user['email']);
                $this->initializePermissions();
                return array('status' => 'OK', 'code' => '200');
            }
        }
    }

    public function checkChangePassword()
    {
        if($this->isLogged())
        {
            $user = $this->session->getData($this->defaultUser);
            $last_login_ts = strtotime($user['last_login']);
            
            if($last_login_ts + $this->getPswdExpireTime() <= time())
            {
                return array('status' => 'OK', 'code' => '200');
            }else{
                return array('status' => 'ERR', 'code' => '101');
            }
        }else{
            return array('status' => 'ERR', 'code' => '100');
        }
    }
    
    public function isPasswordChangedOnTime()
    {
    	if (!$this->isLogged())
    	{
    		return false;
    	}
    	
    	$user = $this->session->getData($this->defaultUser);
    	$pswd_modified = strtotime($user['pswd_modified']);
    	
    	return ($pswd_modified + $this->getPswdExpireTime() > time());
    }
    
    protected function getPswdExpireTime()
    {
    	$ts = 0;
    	$units = (int) $this->option_arr['o_password_change_every'];
    	switch ($this->option_arr['o_password_change_every_unit'])
    	{
    		case 'days':
    			$ts = $units * 60 * 60 * 24;
    			break;
    		case 'weeks':
    			$ts = $units * 60 * 60 * 24 * 7;
    			break;
    		case 'months':
    			$ts = $units * 60 * 60 * 24 * 30;
    			break;
    	}
    	
    	return $ts;
    }

    public function doLogout()
    {
        if ($this->isLogged())
        {
            $this->session->unsetData($this->defaultUser);
            return array('status' => 'OK', 'code' => '200');
        }else{
            return array('status' => 'ERR', 'code' => '100');
        }
    }

    public function getPermissions()
    {
        $arr = array();
        $second_level = array();
        $third_level = array();
        $pjAuthPermissionModel = pjAuthPermissionModel::factory();
        $arr = $pjAuthPermissionModel
		        ->select("t1.*, t2.content as title")
		        ->join('pjBaseMultiLang', sprintf("t2.model='pjAuthPermission' AND t2.foreign_id=t1.id AND t2.locale='%u' AND t2.field='title'", $this->getLocaleId()), 'left outer')
		        ->where("t1.parent_id IS NULL")
		        ->where('t1.is_shown', 'T')
		        ->findAll()
        		->getData();
        if(!empty($arr))
        {
            $id_arr = $pjAuthPermissionModel->findAll()->getDataPair(NULL, 'id');
            $temp_second_arr = $pjAuthPermissionModel
					            ->reset()
					            ->select("t1.*, t2.content as title")
					            ->join('pjBaseMultiLang', sprintf("t2.model='pjAuthPermission' AND t2.foreign_id=t1.id AND t2.locale='%u' AND t2.field='title'", $this->getLocaleId()), 'left outer')
					            ->whereIn("t1.parent_id", $id_arr)
					            ->where('t1.is_shown', 'T')
					            ->findAll()
            					->getData();
            foreach($temp_second_arr as $k => $v)
            {
                $second_level[$v['parent_id']][] = $v;
            }
            $second_id_arr = $pjAuthPermissionModel->findAll()->getDataPair(NULL, 'id');
            if(!empty($second_id_arr))
            {
                $temp_third_arr = $pjAuthPermissionModel
					                ->reset()
					                ->select("t1.*, t2.content as title")
					                ->join('pjBaseMultiLang', sprintf("t2.model='pjAuthPermission' AND t2.foreign_id=t1.id AND t2.locale='%u' AND t2.field='title'", $this->getLocaleId()), 'left outer')
					                ->whereIn("t1.parent_id", $second_id_arr)
					                ->where('t1.is_shown', 'T')
					                ->findAll()
                					->getData();
                foreach($temp_third_arr as $k => $v)
                {
                    $third_level[$v['parent_id']][] = $v;
                }
            }
        }
        return compact('arr', 'second_level', 'third_level');
    }

    public function setRolePermission()
    {
        if (!pjAuth::factory('pjBasePermissions', 'pjActionAjaxSet')->hasAccess())
        {
            return array('status' => 'ERR', 'code' => 100, 'text' => 'Access denied.');
        }
        
        $params = $this->getParams();
        if(isset($params['type']) && in_array($params['type'], array('insert', 'delete')) && isset($params['role_id']) && (int) $params['role_id'] > 0 && isset($params['permission_id']) && (int) $params['permission_id'] > 0)
        {
            $permission = pjAuthPermissionModel::factory()->where('inherit_id', $params['permission_id'])->findAll()->getDataIndex(0);
            switch ($params['type']) {
                case 'insert':
                    $id = pjAuthRolePermissionModel::factory(array('role_id' => $params['role_id'], 'permission_id' => $params['permission_id']))->insert()->getInsertId();
                    if ($id !== false && (int) $id > 0)
                    {
                        if(!empty($permission))
                        {
                            pjAuthRolePermissionModel::factory(array('role_id' => $params['role_id'], 'permission_id' => $permission['id']))->insert();
                        }
                        return array('status' => 'OK', 'code' => '200');
                    } else {
                        return array('status' => 'ERR', 'code' => '101');
                    }
                break;
                case 'delete':
                    $pjAuthRolePermissionModel = pjAuthRolePermissionModel::factory();
                    $pjAuthPermissionModel = pjAuthPermissionModel::factory();
                    $pjAuthRolePermissionModel->where('role_id', $params['role_id'])->where('permission_id', $params['permission_id'])->eraseAll();
                    if(!empty($permission))
                    {
                        $pjAuthRolePermissionModel->reset()->where('role_id', $params['role_id'])->where('permission_id', $permission['id'])->eraseAll();
                    }
                    $second_id_arr = $pjAuthPermissionModel->where('parent_id', $params['permission_id'])->findAll()->getDataPair(NULL, 'id');
                    if(!empty($second_id_arr))
                    {
                        $pjAuthRolePermissionModel->reset()->where('role_id', $params['role_id'])->whereIn('permission_id', $second_id_arr)->eraseAll();
                        $third_id_arr = $pjAuthPermissionModel->whereIn('parent_id', $second_id_arr)->findAll()->getDataPair(NULL, 'id');
                        if(!empty($third_id_arr))
                        {
                            $pjAuthRolePermissionModel->reset()->where('role_id', $params['role_id'])->whereIn('permission_id', $third_id_arr)->eraseAll();
                        }
                    }
                    return array('status' => 'OK', 'code' => '200');
                break;
            }
        }else{
            return array('status' => 'ERR', 'code' => '100');
        }
    }

    public function setUserPermission()
    {
        if (!pjAuth::factory('pjBasePermissions', 'pjActionAjaxSet')->hasAccess())
        {
            return array('status' => 'ERR', 'code' => 100, 'text' => 'Access denied.');
        }
        
        $params = $this->getParams();
        if(isset($params['type']) && in_array($params['type'], array('insert', 'delete')) && isset($params['user_id']) && (int) $params['user_id'] > 0 && isset($params['permission_id']) && (int) $params['permission_id'] > 0)
        {
            $permission = pjAuthPermissionModel::factory()->where('inherit_id', $params['permission_id'])->findAll()->getDataIndex(0);
            switch ($params['type']) {
                case 'insert':
                    $id = pjAuthUserPermissionModel::factory(array('user_id' => $params['user_id'], 'permission_id' => $params['permission_id']))->insert()->getInsertId();
                    if ($id !== false && (int) $id > 0)
                    {
                        if(!empty($permission))
                        {
                            pjAuthUserPermissionModel::factory(array('user_id' => $params['user_id'], 'permission_id' => $permission['id']))->insert();
                        }
                        return array('status' => 'OK', 'code' => '200');
                    } else {
                        return array('status' => 'ERR', 'code' => '101');
                    }
                    break;
                case 'delete':
                    $pjAuthUserPermissionModel = pjAuthUserPermissionModel::factory();
                    $pjAuthPermissionModel = pjAuthPermissionModel::factory();
                    $pjAuthUserPermissionModel->where('user_id', $params['user_id'])->where('permission_id', $params['permission_id'])->eraseAll();
                    if(!empty($permission))
                    {
                        $pjAuthUserPermissionModel->reset()->where('user_id', $params['user_id'])->where('permission_id', $permission['id'])->eraseAll();
                    }
                    $second_id_arr = $pjAuthPermissionModel->where('parent_id', $params['permission_id'])->findAll()->getDataPair(NULL, 'id');
                    if(!empty($second_id_arr))
                    {
                        $pjAuthUserPermissionModel->reset()->where('user_id', $params['user_id'])->whereIn('permission_id', $second_id_arr)->eraseAll();
                        $third_id_arr = $pjAuthPermissionModel->reset()->whereIn('parent_id', $second_id_arr)->findAll()->getDataPair(NULL, 'id');
                        if(!empty($third_id_arr))
                        {
                            $pjAuthUserPermissionModel->reset()->where('user_id', $params['user_id'])->whereIn('permission_id', $third_id_arr)->eraseAll();
                        }
                    }

                    return array('status' => 'OK', 'code' => '200');
                    break;
            }
        }else{
            return array('status' => 'ERR', 'code' => '100');
        }
    }

    public function resetUserPermission()
    {
    	if (!pjAuth::factory('pjBasePermissions', 'pjActionUserPermission')->hasAccess())
        {
            return array('status' => 'ERR', 'code' => 100, 'text' => 'Access denied.');
        }

        $params = $this->getParams();
        if(isset($params['user_id']) && (int) $params['user_id'] > 0)
        {
            $user_id = $params['user_id'];
            $user = pjAuthUserModel::factory()->select('id, role_id')->find($user_id)->getData();
		    if ($user)
            {
                $pjAuthUserPermissionModel = pjAuthUserPermissionModel::factory();
                $pjAuthUserPermissionModel->where('user_id', $user_id)->eraseAll();

                $role_permissions = pjAuthRolePermissionModel::factory()->where('role_id', $user['role_id'])->findAll()->getDataPair(null, 'permission_id');
                if ($role_permissions)
                {
                    foreach ($role_permissions as $permission_id)
                    {
                        pjAuthUserPermissionModel::factory(array('user_id' => $user_id, 'permission_id' => $permission_id))->insert();
                    }
                }

                return array('status' => 'OK', 'code' => 200, 'text' => 'User permissions has been reset.');
            }
            else
            {
                return array('status' => 'ERR', 'code' => 100, 'text' => 'User not found.');
            }
        }else{
            return array('status' => 'ERR', 'code' => 100, 'text' => 'Missing, empty or invalid parameters.');
        }
    }

    public function getPermissionIdsByRole()
    {
        $params = $this->getParams();
        if(isset($params['role_id']) && (int) $params['role_id'] > 0)
        {
            return pjAuthRolePermissionModel::factory()->where('t1.role_id', $params['role_id'])->findAll()->getDataPair(NULL, 'permission_id');
        }else{
            return array();
        }
    }
    public function getPermissionIdsByUser()
    {
        $params = $this->getParams();
        if(isset($params['user_id']) && (int) $params['user_id'] > 0)
        {
            $pjAuthUserPermissionModel = pjAuthUserPermissionModel::factory();
            $permission_id_arr = $pjAuthUserPermissionModel->where('t1.user_id', $params['user_id'])->findAll()->getDataPair(NULL, 'permission_id');
            if(!empty($permission_id_arr))
            {
                $inherit_id_arr = pjAuthPermissionModel::factory()->where("t1.inherit_id >", 0)->findAll()->getDataPair('id', 'inherit_id');
                foreach($inherit_id_arr as $id => $inherit_id)
                {
                    $cnt = $pjAuthUserPermissionModel->reset()->where('user_id', $params['user_id'])->where('permission_id', $id)->findCount()->getData();
                    if(in_array($inherit_id, $permission_id_arr) && $cnt == 0)
                    {
                        $pjAuthUserPermissionModel->reset()->setAttributes(array('user_id' => $params['user_id'], 'permission_id' => $id))->insert();
                    }
                }
            }
            if(empty($permission_id_arr))
            {
                $user = pjAuthUserModel::factory()->find($params['user_id'])->getData();
                $pid_arr = pjAuthRolePermissionModel::factory()->where('t1.role_id', $user['role_id'])->findAll()->getDataPair(NULL, 'permission_id');
                if(!empty($pid_arr))
                {
                	$pjAuthUserPermissionModel->reset();
                    foreach ($pid_arr as $permission_id)
                    {
                    	$pjAuthUserPermissionModel->addBatchRow(array($params['user_id'], $permission_id));
                    }
                    $pjAuthUserPermissionModel->setBatchFields(array('user_id', 'permission_id'))->insertBatch();
                    	
                    $permission_id_arr = $pjAuthUserPermissionModel->reset()->where('t1.user_id', $params['user_id'])->findAll()->getDataPair(NULL, 'permission_id');
                }
                
            }
            return $permission_id_arr;
        }else{
            return array();
        }
    }
        
    /**
     * @param string $subaction Optional parameter used when single action can perform multiple tasks
     * @return bool
     */
    public function hasAccess($subaction = null)
    {
        $params = $this->getParams();

        if (!$this->isLoged())
        {
            return false;
        }else{
            if($this->getUserId() == 1)
            {
                return true;
            }
            if(isset($params['controller']) && !empty($params['controller']))
            {
                $pair = $params['controller'];
                if (isset($params['action']) && !empty($params['action']))
                {
                    $pair .= '_' . $params['action'];
                }
                if($subaction)
                {
                    $pair .= '_' . $subaction;
                }
                $permissions = $this->session->has($this->defaultPermissions) ? $this->session->getData($this->defaultPermissions) : array();
                if(in_array($pair, $permissions))
                {
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
    }

    public function doForgotPassword()
    {
        $params = $this->getParams();

        if (!isset($params['forgot_email']) || !pjValidation::pjActionNotEmpty($params['forgot_email']) || !pjValidation::pjActionEmail($params['forgot_email']))
        {
            return array('status' => 'ERR', 'code' => '4');
        }
        $pjAuthUserModel = pjAuthUserModel::factory();
        $user = $pjAuthUserModel
            ->join("pjAuthRole", "t1.role_id=t2.id", "left")
            ->where('t1.email', $params['forgot_email'])
            ->where('t2.is_backend', 'T')
            ->limit(1)
            ->findAll()
            ->getDataIndex(0);

        if (!$user)
        {
            return array('status' => 'ERR', 'code' => '6');
        } else {
            $tokens = array(
                '{Name}' => $user['name'],
                '{Email}' => $user['email'],
                '{Phone}' => $user['phone'],
                '{URL}' => sprintf("%sindex.php?controller=pjBase&action=pjActionReset&email=%s&hash=%s", PJ_INSTALL_URL, $user['email'], sha1(PJ_SALT . $user['email'] . $user['pswd_modified'] . PJ_SALT)),
            );
            $email_status = array(); 
            if($this->option_arr['o_forgot_contact_admin'] == 'Yes')
            {
                $master_email = $this->getMasterAdminEmail();
                
                $subject = $this->getI18nContent("o_forgot_contact_admin_subject", $this->getLocaleId());
                $message = $this->getI18nContent("o_forgot_contact_admin_message", $this->getLocaleId());
                if(!empty($subject) && !empty($message))
                {
                    $subject = str_ireplace(array_keys($tokens), $tokens, $subject);
                    $message = str_ireplace(array_keys($tokens), $tokens, $message);
                    
                    $pjEmail = self::getMailer($this->option_arr);
                    
                    $pjEmail->setTo($master_email);
                    $pjEmail->setSubject(stripslashes($subject));
                    $pjEmail->send($message);
                }
            }
            if($this->option_arr['o_forgot_email_confirmation'] == 'Yes')
            {
                $subject = $this->getI18nContent("o_forgot_email_subject", $this->getLocaleId());
                $message = $this->getI18nContent("o_forgot_email_message", $this->getLocaleId());
                
                if(!empty($subject) && !empty($message))
                {
                    $subject = str_ireplace(array_keys($tokens), $tokens, $subject);
                    $message = str_ireplace(array_keys($tokens), $tokens, $message);
                    
                    $pjEmail = self::getMailer($this->option_arr);
    
                    $pjEmail->setTo($user['email']);
                    $pjEmail->setSubject(stripslashes($subject));
                    
                    if ($pjEmail->send($message))
                    {
                        $email_status = array('status' => 'OK', 'code' => '8');
                    } else {
                        $email_status = array('status' => 'ERR', 'code' => '10');
                    }
                }
            }
            if($this->option_arr['o_forgot_sms_confirmation'] == 'Yes')
            {
                if(!empty($user['phone']))
                {
                    if(!empty($this->option_arr['o_forgot_sms_message']))
                    {
                        $message = $this->getI18nContent("o_forgot_sms_message", $this->getLocaleId());
                        $message = str_ireplace(array_keys($tokens), $tokens, $message);
                        
                        $params = array(
                            'text' => $message,
                            'number' => $user['phone'],
                            'type' => 'unicode',
                            'key' => md5($this->option_arr['private_key'] . PJ_SALT)
                        );
                        $response = pjBaseSms::init($params)->pjActionSend();
                        
                        if(!empty($email_status))
                        {
                            return $email_status;
                        }else{
                            if($response == 1)
                            {
                                return array('status' => 'OK', 'code' => '9');
                            }else{
                                return array('status' => 'ERR', 'code' => '10');
                            }
                        }
                    }else{
                        return array('status' => 'ERR', 'code' => '14');
                    }
                }else{
                    return array('status' => 'ERR', 'code' => '13');
                }
            }else{
                if(!empty($email_status))
                {
                    return $email_status;
                }else{
                    return array('status' => 'ERR', 'code' => '4');
                }
            }
        }
        return array('status' => 'ERR', 'code' => '4');
    }

    public function getRoleId()
    {
        if (!$this->isLoged())
        {
            return FALSE;
        }else{
            $current_user = $this->session->getData($this->defaultUser);
            return array_key_exists('role_id', $current_user) ? $current_user['role_id'] : FALSE;
        }
    }

    public function getRoleList()
    {
        return pjAuthRoleModel::factory()->where('is_backend', 'T')->where('is_admin', 'T')->orderBy('t1.id ASC')->findAll()->getData();
    }

    public function checkEmail()
    {
        $params = $this->getParams();
        if (!isset($params['email']) || empty($params['email']))
        {
            return false;
        }
        $pjAuthUserModel = pjAuthUserModel::factory()
        	->join("pjAuthRole", "t1.role_id=t2.id", "left outer")
        	->where('t1.email', $params['email'])
        	->where("t2.is_backend", 'T');
        if (isset($params['id']) && (int) $params['id'] > 0)
        {
            $user_id = $params['id'];
        } elseif (isset($params['profile'])) {
            $user_id = $this->getUserId();
        }
        if (isset($user_id))
        {
            $pjAuthUserModel->where('t1.id !=', $user_id);
        }
        return $pjAuthUserModel->findCount()->getData() == 0 ? 'true' : 'false';
    }

    public function createUser()
    {
        if (!pjAuth::factory('pjBaseUsers', 'pjActionCreate')->hasAccess())
        {
            return array('status' => 'ERR', 'code' => 100, 'text' => 'Access denied.');
        }
        
        $params = $this->getParams();
        $data = array();
        $data['is_active'] = 'T';
        $data['ip'] = pjUtil::getClientIp();
        $id = pjAuthUserModel::factory(array_merge($params, $data))->insert()->getInsertId();
        if ($id !== false && (int) $id > 0)
        {
            return array('status' => 'OK', 'code' => 'PU03');
        } else {
            return array('status' => 'ERR', 'code' => 'PU04');
        }
    }

    public function updateUser()
    {
        if (!pjAuth::factory('pjBaseUsers', 'pjActionUpdate')->hasAccess() && !pjAuth::factory('pjBaseUsers', 'pjActionProfile')->hasAccess())
        {
            return array('status' => 'ERR', 'code' => 103, 'text' => 'Access denied.');
        }
        
        $params = $this->getParams();
        if(isset($params['id'], $params['column'], $params['value']) && (int) $params['id'] > 0 && !empty($params['column']))
        {
            pjAuthUserModel::factory()->set('id', $params['id'])->modify(array($params['column'] => $params['value']));
            return array('status' => 'OK', 'code' => 'PU01', 'text' => __('plugin_base_error_bodies_ARRAY_PU01', true, true));
        }
        elseif(isset($params['id']) && (int) $params['id'] > 0)
        {
            pjAuthUserModel::factory()->set('id', $params['id'])->modify($params);
            return array('status' => 'OK', 'code' => 'PU01', 'text' => __('plugin_base_error_bodies_ARRAY_PU01', true, true));
        }
        else
        {
        	return array('status' => 'ERR', 'code' => 'PU05', 'text' => __('plugin_base_error_bodies_ARRAY_PU08', true, true));
        }
    }

    public function getUser()
    {
        $params = $this->getParams();
        if(isset($params['id']) && (int) $params['id'] > 0)
        {
            return pjAuthUserModel::factory()->find($params['id'])->getData();
        }else{
            return FALSE;
        }
    }

    public function  isLogged(){
        if($this->session->has($this->defaultUser) && count($this->session->getData($this->defaultUser)))
        {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * This function will be called in the beforeFilter action of pjBase class.
     * It's used to determine whether the current user is the unique one who is login.
     *
     * @return boolean
     */
    public function checkCurrentUser()
    {
        if($this->isLogged() && $this->option_arr['o_secure_login_1_active_login'] !== 'No')
        {
            $user_id = $this->getUserId();
            $user = pjAuthUserModel::factory()->find($user_id)->getData();
            if(!empty($user))
            {
                if($this->session->getData($this->defaultLoginToken) != $user['login_token'])
                {
                    $this->session->unsetData($this->defaultLoginToken);
                    return false;
                }
            }
        }
        return true;
    }

    public function unlockAccount($user_id)
    {
    	if (!pjAuth::factory('pjBaseUsers', 'pjActionUnlockAccount')->hasAccess())
        {
            return array('status' => 'ERR', 'code' => 100, 'text' => 'Access denied.');
        }

        $user = pjAuthUserModel::factory()->select('email, locked')->find($user_id)->getData();
        if ($user['locked'] == 'T')
        {
            pjAuthLoginAttemptModel::factory()->where('email', $user['email'])->eraseAll();
            if($this->session->has($this->loginAttempts))
            {
                $this->session->unsetData($this->loginAttempts);
            }
        }

        return array('status' => 'OK', 'code' => 200, 'text' => 'OK');
    }
}
?>