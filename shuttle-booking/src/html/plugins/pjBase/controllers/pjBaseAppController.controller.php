<?php
if (!defined("ROOT_PATH"))
{
    header("HTTP/1.1 403 Forbidden");
    exit;
}
class pjBaseAppController extends pjController
{
    public $models = array();
    
    public $defaultFields = 'admin_fields';
    
    public $defaultFieldsIndex = 'admin_index';
    
    public $defaultLocale = 'admin_locale_id';
    
    public $defaultDir = 'admin_locale_dir';
    
    public $defaultLang = 'admin_locale_lang';
    
    public $loginAttempts = 'login_attempts';
    
    public $defaultLoginToken = 'admin_login_token';
    
    public $defaultLoginEmail = 'admin_login_email';
    
    public $defaultPermissions = 'admin_permissions';
        
    public function __construct()
    {
        $this->setLayout('pjActionAdmin');
    }
    
    public static function getConst($const)
    {
        $registry = pjRegistry::getInstance();
        $store = $registry->get('pjBase');
        return isset($store[$const]) ? $store[$const] : NULL;
    }
    
    public static function isPost()
    {
        if (($method = getenv('REQUEST_METHOD')) === false)
        {
            $method = @$_SERVER['REQUEST_METHOD'];
        }
        return $method == 'POST';
    }
    public static function isGet()
    {
        if (($method = getenv('REQUEST_METHOD')) === false)
        {
            $method = @$_SERVER['REQUEST_METHOD'];
        }
        return $method == 'GET';
    }
    
    protected function isInstaller()
    {
        $_get = pjRegistry::getInstance()->get('_get');
        if ($_get->toString('controller') == 'pjInstaller')
        {
            return true;
        }
        return false;
    }
    
    public function isEditor()
    {
    	return (int) $this->getRoleId() === 2;
    }
    
    protected function getDependencyManager($plugin='pjBase')
    {
        $baseDir = defined('PJ_INSTALL_PATH') ? PJ_INSTALL_PATH : NULL;
        
        $dm = new pjDependencyManager($baseDir, PJ_THIRD_PARTY_PATH);
        $dependencies = $baseDir . $this->getConstant($plugin, 'PLUGIN_CONFIG_PATH') . 'dependencies.php';
        if (is_file($dependencies))
        {
            $dm->load($dependencies)->resolve();
        }
        
        return $dm;
    }
    
    protected static function isIDsShown()
    {
        return isset($_SESSION['lang_show_id']) && (int) $_SESSION['lang_show_id'] === 1;
    }
    
    protected function sendForbidden()
    {
        header('HTTP/1.1 403 Forbidden');
        $this->setTemplate('pjBase', 'pjBase:elements/403');
    }
    
    protected function loadSetFields($force=FALSE, $locale_id=NULL, $fields=NULL)
    {
        if (is_null($locale_id))
        {
            $locale_id = $this->getLocaleId();
        }
        
        if (is_null($fields))
        {
            $fields = $this->defaultFields;
        }
        
        $registry = pjRegistry::getInstance();
        $field_arr = $this->session->getData($fields);
        if ($force
            || !$this->session->has($this->defaultFieldsIndex)
            || $this->session->getData($this->defaultFieldsIndex) != $this->option_arr['o_fields_index']
            || !$this->session->has($fields)
            || empty($field_arr))
        {
            pjAppController::setFields($locale_id);
            
            # Update session
            if ($registry->is('fields'))
            {
                $this->session->setData($fields, $registry->get('fields'));
            }
            $this->session->setData($this->defaultFieldsIndex, $this->option_arr['o_fields_index']);
        }
        
        if ($this->session->has($fields) && !empty($field_arr))
        {
            # Load fields from session
            $registry->set('fields', $this->session->getData($fields));
        }
        
        return TRUE;
    }
    
    protected function setLocalesData()
    {
        $locale_arr = pjLocaleModel::factory()
        ->select('t1.*, t2.file')
        ->join('pjBaseLocaleLanguage', 't2.iso=t1.language_iso', 'left')
        ->where('t2.file IS NOT NULL')
        ->orderBy('t1.sort ASC')->findAll()->getData();
        
        $lp_arr = array();
        foreach ($locale_arr as $item)
        {
            $lp_arr[$item['id']."_"] = $item['file'];
        }
        $this->set('lp_arr', $locale_arr);
        $this->set('locale_str', pjAppController::jsonEncode($lp_arr));
        $this->set('is_flag_ready', $this->requestAction(array('controller' => 'pjBaseLocale', 'action' => 'pjActionIsFlagReady'), array('return')));
    }
    
    public static function setFields($locale)
    {
        if(self::isIDsShown())
        {
            $fields = pjMultiLangModel::factory()
            ->select('CONCAT(t1.content, CONCAT(":", t2.id, ":")) AS content, t2.key')
            ->join('pjBaseField', "t2.id=t1.foreign_id", 'inner')
            ->where('t1.locale', $locale)
            ->where('t1.model', 'pjBaseField')
            ->where('t1.field', 'title')
            ->findAll()
            ->getDataPair('key', 'content');
        }else{
            $fields = pjMultiLangModel::factory()
            ->select('t1.content, t2.key')
            ->join('pjBaseField', "t2.id=t1.foreign_id", 'inner')
            ->where('t1.locale', $locale)
            ->where('t1.model', 'pjBaseField')
            ->where('t1.field', 'title')
            ->findAll()
            ->getDataPair('key', 'content');
        }
        $registry = pjRegistry::getInstance();
        $tmp = array();
        if ($registry->is('fields'))
        {
            $tmp = $registry->get('fields');
        }
        $arrays = array();
        foreach ($fields as $key => $value)
        {
            if (strpos($key, '_ARRAY_') !== false)
            {
                list($prefix, $suffix) = explode("_ARRAY_", $key);
                if (!isset($arrays[$prefix]))
                {
                    $arrays[$prefix] = array();
                }
                $arrays[$prefix][$suffix] = $value;
            }
        }
        require PJ_CONFIG_PATH . 'settings.inc.php';
        $fields = array_merge($tmp, $fields, $settings, $arrays);
        $registry->set('fields', $fields);
    }
    
    public static function jsonDecode($str)
    {
        if (function_exists('json_decode'))
        {
            return json_decode($str, true);
        }
        
        $Services_JSON = new pjServices_JSON(SERVICES_JSON_LOOSE_TYPE);
        return $Services_JSON->decode($str);
    }
    
    public static function jsonEncode($arr)
    {
        if (function_exists('json_encode'))
        {
            return json_encode($arr);
        }
        
        $Services_JSON = new pjServices_JSON();
        return $Services_JSON->encode($arr);
    }
    
    public static function jsonResponse($arr)
    {
        header("Content-Type: application/json; charset=utf-8");
        echo self::jsonEncode($arr);
        exit;
    }
    
    public function friendlyURL($str, $divider='-')
    {
        $str = mb_strtolower($str, mb_detect_encoding($str)); // change everything to lowercase
        $str = trim($str); // trim leading and trailing spaces
        $str = preg_replace('/[_|\s]+/', $divider, $str); // change all spaces and underscores to a hyphen
        $str = preg_replace('/\x{00C5}/u', 'AA', $str);
        $str = preg_replace('/\x{00C6}/u', 'AE', $str);
        $str = preg_replace('/\x{00D8}/u', 'OE', $str);
        $str = preg_replace('/\x{00E5}/u', 'aa', $str);
        $str = preg_replace('/\x{00E6}/u', 'ae', $str);
        $str = preg_replace('/\x{00F8}/u', 'oe', $str);
        $str = preg_replace('/[^a-z\x{0400}-\x{04FF}0-9-]+/u', '', $str); // remove all non-cyrillic, non-numeric characters except the hyphen
        $str = preg_replace('/[-]+/', $divider, $str); // replace multiple instances of the hyphen with a single instance
        $str = preg_replace('/^-+|-+$/', '', $str); // trim leading and trailing hyphens
        return $str;
    }
    
    public function getLocaleId()
    {
        return $this->session->has($this->defaultLocale) && (int) $this->session->getData($this->defaultLocale) > 0 ? (int) $this->session->getData($this->defaultLocale) : false;
    }
    
    public function setLocaleId($locale_id)
    {
        $this->session->setData($this->defaultLocale, (int) $locale_id);
    }
    
    public function getLocaleDir()
    {
        return $this->session->has($this->defaultDir) && in_array($this->session->getData($this->defaultDir), array('ltr', 'rtl')) ? $this->session->getData($this->defaultDir) : 'ltr';
    }
    
    public function setLocaleDir($dir)
    {
        $this->session->setData($this->defaultDir, $dir);
    }
    
    public function getLocaleLang()
    {
        return $this->session->has($this->defaultLang) ? $this->session->getData($this->defaultLang) : NULL;
    }
    
    public function setLocaleLang($lang)
    {
        $this->session->setData($this->defaultLang, $lang);
    }
    
    public function getLocale()
    {
        return array(
            'locale_id' => $this->getLocaleId(),
            'dir' => $this->getLocaleDir(),
            'lang' => $this->getLocaleLang()
        );
    }
    
    public function setLocale($locale_id)
    {
        $this->setLocaleId($locale_id);
        
        $locale_arr = pjLocaleModel::factory()->find($locale_id)->getData();
        if (!empty($locale_arr))
        {
            $this->setLocaleDir($locale_arr['dir']);
            $this->setLocaleLang($locale_arr['language_iso']);
        }
    }
    
    public function getForeignId()
    {
        return 1;
    }
    
    public function beforeFilter()
    {
        $this->resetCss();
        $this->resetJs();
        
        $cssPath = $this->getConstant('pjBase', 'PLUGIN_CSS_PATH');
        $jsPath = $this->getConstant('pjBase', 'PLUGIN_JS_PATH');
        
        $dm = $this->getDependencyManager();
        
        $this->appendCss('css/bootstrap.min.css', $dm->getPath('bootstrap'), false, false);
        $this->appendCss('css/font-awesome.min.css', $dm->getPath('font_awesome'), false, false);
        $this->appendCss('toastr.min.css', $dm->getPath('toastr'), false, false);
        $this->appendCss('custom.css', $dm->getPath('icheck'), false, false);
        $this->appendCss('jquery.gritter.css', $dm->getPath('gritter'), false, false);
        $this->appendCss('sweetalert.css', $dm->getPath('sweetalert'), false, false);
        $this->appendCss('jquery.bootstrap-touchspin.min.css', $dm->getPath('touchspin'), false, false);
        $this->appendCss('animate.css', $cssPath);
        
        $this->appendJs('jquery.min.js', $dm->getPath('jquery'), false, false);
        $this->appendJs('pjBaseCore.js', $jsPath);
        $this->appendJs('js/bootstrap.min.js', $dm->getPath('bootstrap'), false, false);
        $this->appendJs('jquery.metisMenu.js', $dm->getPath('metis_menu'), false, false);
        $this->appendJs('jquery.slimscroll.min.js', $dm->getPath('slimscroll'), false, false);
        $this->appendJs('jquery.validate.min.js', $dm->getPath('validate'), false, false);
        $this->appendJs('jquery.gritter.min.js', $dm->getPath('gritter'), false, false);
        $this->appendJs('jquery.sparkline.min.js', $dm->getPath('sparkline'), false, false);
        $this->appendJs('toastr.min.js', $dm->getPath('toastr'), false, false);
        $this->appendJs('icheck.min.js', $dm->getPath('icheck'), false, false);
        $this->appendJs('spin.min.js', $dm->getPath('ladda'), false, false);
        $this->appendJs('ladda.min.js', $dm->getPath('ladda'), false, false);
        $this->appendJs('ladda.jquery.min.js', $dm->getPath('ladda'), false, false);
        $this->appendJs('sweetalert.min.js', $dm->getPath('sweetalert'), false, false);
        $this->appendJs('pace.min.js', $dm->getPath('pace'), false, false);
        $this->appendJs('jquery.bootstrap-touchspin.min.js', $dm->getPath('touchspin'), false, false);
        
        if (!$this->isInstaller())
        {
            $this->models['Option'] = pjBaseOptionModel::factory();
            $base_option_arr = $this->models['Option']->getPairs($this->getForeignId());
            $script_option_arr = pjOptionModel::factory()->getPairs($this->getForeignId());
            $this->option_arr = array_merge($base_option_arr, $script_option_arr);
            $this->set('option_arr', $this->option_arr);
            
            pjRegistry::getInstance()->set('options', $this->option_arr);
            if (isset($this->option_arr['o_timezone']))
            {
                pjTimezone::factory()->setAllTimezones($this->option_arr['o_timezone']);
            }
            pjCurrency::factory()->setCurrencyData();

            if (!$this->session->has($this->defaultLocale))
            {
                $locale_arr = pjLocaleModel::factory()->where('is_default', 1)->limit(1)->findAll()->getData();
                if (count($locale_arr) === 1)
                {
                    $this->setLocaleId($locale_arr[0]['id']);
                }
            }
            $this->loadSetFields(true);
            
            $is_ip_blocked = pjBase::isBlockedIp(pjUtil::getClientIp(), $this->option_arr);
            if($is_ip_blocked == true && !in_array($this->_get->toString('controller'), array('pjFront', 'pjFrontEnd', 'pjFrontPublic')))
            {
                $this->sendForbidden();
                return false;
            }
        }
        
        return true;
    }
    
    public function afterFilter()
    {
        if (!$this->isInstaller())
        {
            $menu_locale_arr =  pjLocaleModel::factory()
                ->select('t1.*, t2.file, t2.title')
                ->join('pjBaseLocaleLanguage', 't2.iso=t1.language_iso', 'left outer')
                ->where('t2.file IS NOT NULL')
                ->orderBy('t1.sort ASC')
                ->findAll()
                ->getDataPair('id');
            
            $this->set('menu_locale_arr', $menu_locale_arr);
            
            $default_language = NULL;
            foreach ($menu_locale_arr as $item)
            {
                if ($item['is_default'] == 1)
                {
                    $default_language = __('plugin_base_default_language', true) . ' - ' .  $item['name'];
                    break;
                }
            }
            $this->set('default_language', $default_language);
            
            $this->appendCss('style.css', $this->getConstant('pjBase', 'PLUGIN_CSS_PATH'));
            $this->appendCss('custom.css', $this->getConstant('pjBase', 'PLUGIN_CSS_PATH'));
            $this->appendCss('themes/'.$this->option_arr['o_base_theme'].'.css', $this->getConstant('pjBase', 'PLUGIN_CSS_PATH'));
            $this->appendJs('inspinia.js', $this->getConstant('pjBase', 'PLUGIN_JS_PATH'));
        }
    }

    public static function getMailer($option_arr)
    {
    	$pjEmail = new pjEmail();
    	$pjEmail->setContentType("text/html");
    	
    	if ($option_arr['o_send_email'] == 'smtp')
    	{
    		$pjEmail
	    		->setTransport('smtp')
	    		->setSmtpSecure($option_arr['o_smtp_secure'])
	    		->setSmtpHost($option_arr['o_smtp_host'])
	    		->setSmtpPort($option_arr['o_smtp_port'])
	    		->setSmtpUser($option_arr['o_smtp_user'])
	    		->setSmtpPass($option_arr['o_smtp_pass'])
	    		->setSmtpAuthType($option_arr['o_smtp_auth']);
    	}
    	
    	if (pjValidation::pjActionEmail($option_arr['o_sender_email']))
    	{
    		$pjEmail->setSender($option_arr['o_sender_email']);
    		$pjEmail->setFrom($option_arr['o_sender_email'], $option_arr['o_sender_name']);
    	} else {
    	    $admin = pjAuthUserModel::factory()->find(1)->getData();
    	    $sender_name = @$admin['name'];
    	    if(!empty($option_arr['o_sender_name']))
    	    {
    	        $sender_name = $option_arr['o_sender_name'];
    	    }
    	    $pjEmail->setFrom(@$admin['email'], $sender_name);
    	}
    	
    	return $pjEmail;
    }
}
?>