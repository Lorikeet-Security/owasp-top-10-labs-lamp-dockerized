<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjAdminOptions extends pjAdmin
{
    public function pjActionUpdate()
    {
        $this->checkLogin();
        
        if (!pjAuth::factory()->hasAccess())
        {
            $this->sendForbidden();
            return;
        }
        
        if (self::isPost() && $this->_post->toInt('options_update'))
        {
            $pjOptionModel = new pjOptionModel();
            $pjOptionModel
            ->where('foreign_id', $this->getForeignId())
            ->where('type', 'bool')
            ->where('tab_id', $this->_post->toInt('tab'))
            ->modifyAll(array('value' => '1|0::0'));
            if ($this->_post->toInt('tab') == 2) {
                $pjOptionModel->reset()
                ->where('foreign_id', $this->getForeignId())
                ->where('`key`', 'o_payment_disable')
                ->modifyAll(array('value' => 'Yes|No::No'));
            }
            foreach ($this->_post->raw() as $key => $value)
            {
                if (preg_match('/value-(string|text|int|float|enum|bool|color)-(.*)/', $key) === 1)
                {
                    list(, $type, $k) = explode("-", $key);
                    if (!empty($k))
                    {
                        $_value = ':NULL';
                        if ($value)
                        {
                            switch ($type)
                            {
                                case 'string':
                                case 'text':
                                case 'enum':
                                case 'color':
                                    $_value = $this->_post->toString($key);
                                    break;
                                case 'int':
                                case 'bool':
                                    $_value = $this->_post->toString($key);
                                    break;
                                case 'float':
                                    $_value = $this->_post->toString($key);
                                    break;
                            }
                        }
                        
                        $pjOptionModel
                        ->reset()
                        ->where('foreign_id', $this->getForeignId())
                        ->where('`key`', $k)
                        ->limit(1)
                        ->modifyAll(array('value' => $_value));
                    }
                }
            }
            
            $i18n_arr = $this->_post->toI18n('i18n');
            if (!empty($i18n_arr))
            {
                pjMultiLangModel::factory()->updateMultiLang($i18n_arr, $this->getForeignId(), 'pjOption', 'data');
            }
            $err = '';
            if ($this->_post->check('next_action'))
            {
                switch ($this->_post->toString('next_action'))
                {
                    case 'pjActionBooking':
                        $err = 'AO02';
                        break;
                    case 'pjActionBookingForm':
                        $err = 'AO03';
                        break;
                    case 'pjActionTerm':
                        $err = 'AO05';
                        break;
                }
            }
            pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminOptions&action=" . $this->_post->toString('next_action') . "&err=$err");
        }
    }
    public function pjActionBooking()
    {
        if (!pjAuth::factory()->hasAccess())
        {
            $this->sendForbidden();
            return;
        }
        $arr = pjOptionModel::factory()
        ->where('t1.foreign_id', $this->getForeignId())
        ->where('t1.tab_id', 2)
        ->orderBy('t1.order ASC')
        ->findAll()
        ->getData();
        
        $this->set('arr', $arr);
        $this->appendJs('pjAdminOptions.js');
    }
    public function pjActionBookingForm()
    {
        if (!pjAuth::factory()->hasAccess())
        {
            $this->sendForbidden();
            return;
        }
        $pjOptionModel = pjOptionModel::factory();
        
        $group_1_arr = $pjOptionModel
        ->where('t1.foreign_id', $this->getForeignId())
        ->where('t1.tab_id', 4)
        ->whereIn('`key`', array('o_bf_include_title', 'o_bf_include_fname', 'o_bf_include_lname', 'o_bf_include_phone', 'o_bf_include_email', 'o_bf_include_company'))
        ->orderBy('t1.order ASC')
        ->findAll()
        ->getData();
        $this->set('group_1_arr', $group_1_arr);
        
        $group_2_arr = $pjOptionModel
        ->reset()
        ->where('t1.foreign_id', $this->getForeignId())
        ->where('t1.tab_id', 4)
        ->whereIn('`key`', array('o_bf_include_address', 'o_bf_include_city', 'o_bf_include_state', 'o_bf_include_zip', 'o_bf_include_country', 'o_bf_include_notes'))
        ->orderBy('t1.order ASC')
        ->findAll()
        ->getData();
        $this->set('group_2_arr', $group_2_arr);
        
        $group_3_arr = $pjOptionModel
        ->reset()
        ->where('t1.foreign_id', $this->getForeignId())
        ->where('t1.tab_id', 4)
        ->whereIn('`key`', array('o_bf_include_captcha', 'o_bf_include_airline_company', 'o_bf_include_flight_number', 'o_bf_include_flight_time', 'o_bf_include_terminal'))
        ->orderBy('t1.order ASC')
        ->findAll()
        ->getData();
        $this->set('group_3_arr', $group_3_arr);
        
        $this->appendJs('pjAdminOptions.js');
    }
    public function pjActionNotifications()
    {
        if (!pjAuth::factory()->hasAccess())
        {
            $this->sendForbidden();
            return;
        }
        
        $arr = pjOptionModel::factory()
        ->where('t1.foreign_id', $this->getForeignId())
        ->orderBy('t1.order ASC')
        ->findAll()
        ->getData();
        
        $arr['i18n'] = pjMultiLangModel::factory()->getMultiLang($this->getForeignId(), 'pjOption');
        
        $this->set('arr', $arr);
        
        $this->setLocalesData();
        
        $this->appendCss('awesome-bootstrap-checkbox.css', PJ_THIRD_PARTY_PATH . 'awesome_bootstrap_checkbox/');
        $this->appendJs('jquery.multilang.js', $this->getConstant('pjBase', 'PLUGIN_JS_PATH'), false, false);
        $this->appendJs('tinymce.min.js', PJ_THIRD_PARTY_PATH . 'tinymce/');
        $this->appendJs('pjAdminOptions.js');
    }
    public function pjActionTerm()
    {
        if (!pjAuth::factory()->hasAccess())
        {
            $this->sendForbidden();
            return;
        }
        
        $arr = pjOptionModel::factory()
        ->where('t1.foreign_id', $this->getForeignId())
        ->where('t1.tab_id', 5)
        ->orderBy('t1.order ASC')
        ->findAll()
        ->getData();
        
        $arr['i18n'] = pjMultiLangModel::factory()->getMultiLang($this->getForeignId(), 'pjOption');
        
        $this->set('arr', $arr);
        
        $this->setLocalesData();
        
        $this->appendJs('jquery.multilang.js', $this->getConstant('pjBase', 'PLUGIN_JS_PATH'), false, false);
        $this->appendJs('tinymce.min.js', PJ_THIRD_PARTY_PATH . 'tinymce/');
        $this->appendJs('pjAdminOptions.js');
    }
    public function pjActionPreview()
    {
        $this->appendJs('pjAdminOptions.js');
    }
    
    public function pjActionInstall()
    {
        $this->appendJs('pjAdminOptions.js');
    }
    
    public function pjActionUpdateTheme()
    {
        $this->setAjax(true);
        
        if (!$this->isXHR())
        {
            self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Missing headers.'));
        }
        
        if(!self::isPost())
        {
            self::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'HTTP method not allowed.'));
        }
        
        if (!$this->_post->has('theme'))
        {
            self::jsonResponse(array('status' => 'ERR', 'code' => 102, 'text' => 'Missing, empty or invalid parameters.'));
        }
        
        pjOptionModel::factory()
        ->where('foreign_id', $this->getForeignId())
        ->where('`key`', 'o_theme')
        ->limit(1)
        ->modifyAll(array('value' => 'theme1|theme2|theme3|theme4|theme5|theme6|theme7|theme8|theme9|theme10::' . $this->_post->toString('theme')));
        
        self::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Theme has been changed.'));
    }
    
    public function pjActionNotificationsGetMetaData()
    {
        $this->setAjax(true);
        
        if (!$this->isXHR())
        {
            self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Missing headers.'));
        }
        
        if (!self::isGet())
        {
            self::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'Invalid request.'));
        }
        
        if (!(isset($this->query['recipient']) && pjValidation::pjActionNotEmpty($this->query['recipient'])))
        {
            self::jsonResponse(array('status' => 'ERR', 'code' => 102, 'text' => 'Missing, empty or invalid parameters.'));
        }
        
        $this->set('arr', pjNotificationModel::factory()
            ->where('t1.recipient', $this->query['recipient'])
            ->orderBy('t1.id ASC')
            ->findAll()
            ->getData());
    }
    
    public function pjActionNotificationsGetContent()
    {
        $this->setAjax(true);
        
        if (!$this->isXHR())
        {
            self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Missing headers.'));
        }
        
        if (!self::isGet())
        {
            self::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'Invalid request.'));
        }
        
        if (!($this->_get->check('recipient') && $this->_get->check('variant') && $this->_get->check('transport'))
            && pjValidation::pjActionNotEmpty($this->_get->toString('recipient'))
            && pjValidation::pjActionNotEmpty($this->_get->toString('variant'))
            && pjValidation::pjActionNotEmpty($this->_get->toString('transport'))
            && in_array($this->_get->toString('transport'), array('email', 'sms'))
            )
        {
            self::jsonResponse(array('status' => 'ERR', 'code' => 102, 'text' => 'Missing, empty or invalid parameters.'));
        }
        
        $arr = pjNotificationModel::factory()
        ->where('t1.recipient', $this->_get->toString('recipient'))
        ->where('t1.variant', $this->_get->toString('variant'))
        ->where('t1.transport', $this->_get->toString('transport'))
        ->limit(1)
        ->findAll()
        ->getDataIndex(0);
        
        if (!$arr)
        {
            self::jsonResponse(array('status' => 'ERR', 'code' => 103, 'text' => 'Message not found.'));
        }
        
        $arr['i18n'] = pjBaseMultiLangModel::factory()->getMultiLang($this->getForeignId(), 'pjOption');
        $this->set('arr', $arr);
        
        # Check SMS
        $this->set('is_sms_ready', (isset($this->option_arr['plugin_sms_api_key']) && !empty($this->option_arr['plugin_sms_api_key']) ? 1 : 0));
        
        # Get locales
        $locale_arr = pjBaseLocaleModel::factory()
        ->select('t1.*, t2.file, t2.title')
        ->join('pjBaseLocaleLanguage', 't2.iso=t1.language_iso', 'left')
        ->where('t2.file IS NOT NULL')
        ->orderBy('t1.sort ASC')
        ->findAll()
        ->getData();
        
        $lp_arr = array();
        foreach ($locale_arr as $item)
        {
            $lp_arr[$item['id']."_"] = array($item['file'], $item['title']);
        }
        $this->set('lp_arr', $locale_arr);
        $this->set('locale_str', self::jsonEncode($lp_arr));
        $this->set('is_flag_ready', $this->requestAction(array('controller' => 'pjBaseLocale', 'action' => 'pjActionIsFlagReady'), array('return')));
    }
    public function pjActionNotificationsSetContent()
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
        
        if (!(isset($this->body['id']) && pjValidation::pjActionNumeric($this->body['id'])))
        {
            self::jsonResponse(array('status' => 'ERR', 'code' => 102, 'text' => 'Missing, empty or invalid parameters.'));
        }
        
        $isToggle = $this->_post->check('is_active') && in_array($this->_post->toInt('is_active'), array(1,0));
        $isFormSubmit = $this->_post->check('i18n') && !$this->_post->isEmpty('i18n');
        
        if (!($isToggle xor $isFormSubmit))
        {
            self::jsonResponse(array('status' => 'ERR', 'code' => 103, 'text' => 'Data mismatch.'));
        }
        
        if ($isToggle)
        {
            pjNotificationModel::factory()
            ->set('id', $this->_post->toInt('id'))
            ->modify(array('is_active' => $this->_post->toInt('is_active')));
        } elseif ($isFormSubmit) {
            pjBaseMultiLangModel::factory()->updateMultiLang($this->_post->toArray('i18n'), $this->getForeignId(), 'pjOption');
        }
        
        self::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Notification has been updated.'));
    }
}
?>