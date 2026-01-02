<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjAdmin extends pjAppController
{
	public $defaultUser = 'admin_user';
	
	public $requireLogin = true;
		
	public function __construct($requireLogin=null)
	{
	    $this->setLayout('pjActionAdmin');
	    
	    if (!is_null($requireLogin) && is_bool($requireLogin))
	    {
	        $this->requireLogin = $requireLogin;
	    }
	    
	    if ($this->requireLogin)
	    {
	        if (!$this->isLoged() && !in_array(@$_GET['action'], array('pjActionLogin', 'pjActionForgot', 'pjActionPreview')))
	        {
	            if (!$this->isXHR())
	            {
	                pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjBase&action=pjActionLogin");
	            } else {
	                header('HTTP/1.1 401 Unauthorized');
	                exit;
	            }
	        }
	    }
	    $ref_inherits_arr = array();
	    if ($this->isXHR() && isset($_SERVER['HTTP_REFERER'])) {
	        $http_refer_arr = parse_url($_SERVER['HTTP_REFERER']);
	        parse_str($http_refer_arr['query'], $arr);
	        if (isset($arr['controller']) && isset($arr['action'])) {
	            parse_str($_SERVER['QUERY_STRING'], $query_string_arr);
	            $key = $query_string_arr['controller'].'_'.$query_string_arr['action'];
	            $cnt = pjAuthPermissionModel::factory()->where('`key`', $key)->findCount()->getData();
	            if ($cnt <= 0) {
	                $ref_inherits_arr[$query_string_arr['controller'].'::'.$query_string_arr['action']] = $arr['controller'].'::'.$arr['action'];
	            }
	        }
	    }
	    $inherits_arr = array(
	        
	        'pjAdminOptions::pjActionNotificationsSetContent' => 'pjAdminOptions::pjActionNotifications',
	        'pjAdminOptions::pjActionNotificationsGetContent' => 'pjAdminOptions::pjActionNotifications',
	        'pjAdminOptions::pjActionNotificationsGetMetaData' => 'pjAdminOptions::pjActionNotifications',
	        'pjAdminOptions::pjActionPaymentOptions' => 'pjAdminOptions::pjActionPayments',
	        'pjAdmin::pjActionVerifyAPIKey' => 'pjBaseOptions::pjActionApiKeys',
	        'pjBasePermissions::pjActionResetPermission' => 'pjBasePermissions::pjActionUserPermission',
	        
	        'pjAdminBookings::pjActionCheckID' => 'pjAdminBookings::pjActionCreate',
	        'pjAdminBookings::pjActionCheckID' => 'pjAdminBookings::pjActionUpdate',
	        'pjAdminBookings::pjActionGetDropoff' => 'pjAdminBookings::pjActionCreate',
	        'pjAdminBookings::pjActionGetDropoff' => 'pjAdminBookings::pjActionUpdate',
	        'pjAdminBookings::pjActionGetLines' => 'pjAdminBookings::pjActionCreate',
	        'pjAdminBookings::pjActionGetLines' => 'pjAdminBookings::pjActionUpdate',
	        'pjAdminBookings::pjActionGetTimes' => 'pjAdminBookings::pjActionCreate',
	        'pjAdminBookings::pjActionGetTimes' => 'pjAdminBookings::pjActionUpdate',
	        'pjAdminBookings::pjActionGetPrices' => 'pjAdminBookings::pjActionCreate',
	        'pjAdminBookings::pjActionGetPrices' => 'pjAdminBookings::pjActionUpdate',
	        'pjAdminBookings::pjActionGetBooking' => 'pjAdminBookings::pjActionIndex',
	        
	        'pjAdminLines::pjActionGetBooking' => 'pjAdminLines::pjActionIndex',
	        'pjAdminLines::pjActionSaveLine' => 'pjAdminLines::pjActionUpdate',
	        'pjAdminLines::pjActionDeleteImage' => 'pjAdminLines::pjActionUpdate',
	        
	        'pjAdminLocations::pjActionGetLocation' => 'pjAdminLocations::pjActionIndex',
	        'pjAdminLocations::pjActionSaveLocation' => 'pjAdminLocations::pjActionUpdate',
	        
	        'pjAdminTimetable::pjActionGetTimetable' => 'pjAdminTimetable::pjActionIndex',
	        'pjAdminTimetable::pjActionSaveTimetable' => 'pjAdminTimetable::pjActionUpdate',
	        'pjAdminTimetable::pjActionGetSchedule' => 'pjAdminTimetable::pjActionSchedule',
	        
	        'pjAdminClients::pjActionCheckEmail' => 'pjAdminClients::pjActionCreate',
	        'pjAdminClients::pjActionCheckEmail' => 'pjAdminClients::pjActionUpdate',
	        'pjAdminClients::pjActionGetClient' => 'pjAdminClients::pjActionIndex',
	        'pjAdminClients::pjActionSaveClient' => 'pjAdminClients::pjActionUpdate',
	        'pjAdminClients::pjActionStatusClient' => 'pjAdminClients::pjActionUpdate',
	    );
	    if ($_REQUEST['controller'] == 'pjAdminOptions' && isset($_REQUEST['next_action'])) {
	        $inherits_arr['pjAdminOptions::pjActionUpdate'] = 'pjAdminOptions::'.$_REQUEST['next_action'];
	    }
	    $inherits_arr = array_merge($ref_inherits_arr, $inherits_arr);
	    pjRegistry::getInstance()->set('inherits', $inherits_arr);
	}
	
	public function beforeFilter()
	{
	    parent::beforeFilter();
	    
	    if (@$_REQUEST['controller'] == 'pjAdmin' && @$_REQUEST['action'] == 'pjActionMessages') {
	        return true;
	    } else {
	        if (!pjAuth::factory()->hasAccess())
	        {
	            $this->sendForbidden();
	            return false;
	        }
	        return true;
	    }
	}
	
	public function afterFilter()
	{
	    parent::afterFilter();
	    $this->appendJs('index.php?controller=pjBase&action=pjActionMessages', PJ_INSTALL_URL, true);
	}
	
	public function beforeRender()
	{
		
	}
	
	public function pjActionMessages()
	{
	    $this->setAjax(true);
	    header("Content-Type: text/javascript; charset=utf-8");
	}
	public function setLocalesData()
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
	
	public function pjActionVerifyAPIKey()
	{
	    $this->setAjax(true);
	    
	    if ($this->isXHR())
	    {
	        if (!self::isPost())
	        {
	            self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => __('plugin_base_api_key_text_ARRAY_100', true)));
	        }
	        
	        $option_key = $this->_post->toString('key');
	        if (!array_key_exists($option_key, $this->option_arr))
	        {
	            self::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => __('plugin_base_api_key_text_ARRAY_101', true)));
	        }
	        
	        $option_value = $this->_post->toString('value');
	        if(empty($option_value))
	        {
	            self::jsonResponse(array('status' => 'ERR', 'code' => 102, 'text' => __('plugin_base_api_key_text_ARRAY_102', true)));
	        }
	        
	        $html = '';
	        $isValid = false;
	        switch ($option_key)
	        {
	            case 'o_google_maps_api_key':
	                $address = preg_replace('/\s+/', '+', $this->option_arr['o_timezone']);
	                $api_key_str = $option_value;
	                $gfile = "https://maps.googleapis.com/maps/api/geocode/json?key=".$api_key_str."&address=".$address;
	                $Http = new pjHttp();
	                $response = $Http->request($gfile)->getResponse();
	                $geoObj = pjAppController::jsonDecode($response);
	                $geoArr = (array) $geoObj;
	                if ($geoArr['status'] == 'OK')
	                {
	                    $isValid = true;
	                }
	                break;
	            default:
	                $isValid = true;
	        }
	        
	        if ($isValid)
	        {
	            self::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => __('plugin_base_api_key_text_ARRAY_200', true), 'html' => $html));
	        }
	        else
	        {
	            self::jsonResponse(array('status' => 'ERR', 'code' => 103, 'text' => __('plugin_base_api_key_text_ARRAY_103', true), 'html' => $html));
	        }
	    }
	    exit;
	}
	
	public function pjActionIndex()
	{
	    $this->checkLogin();
	    if (!pjAuth::factory()->hasAccess())
	    {
	        $this->sendForbidden();
	        return;
	    }
	    
	    $pjBookingModel = pjBookingModel::factory();
	    
	    $cnt_new_reservations = $pjBookingModel
	    ->where("(DATE_FORMAT(t1.created, '%Y-%m-%d')=DATE_FORMAT(NOW(), '%Y-%m-%d'))")
	    ->findCount()
	    ->getData();
	    $cnt_today_transfers = $pjBookingModel
	    ->reset()
	    ->where("(DATE_FORMAT(t1.booking_date, '%Y-%m-%d')=DATE_FORMAT(NOW(), '%Y-%m-%d') OR (DATE_FORMAT(t1.return_date, '%Y-%m-%d')=DATE_FORMAT(NOW(), '%Y-%m-%d') AND t1.has_return='T'))")
	    ->findCount()
	    ->getData();
	    
	    $latest_arr = $pjBookingModel
	    ->reset()
	    ->join('pjMultiLang', "t2.model='pjLocation' AND t2.foreign_id=t1.location_id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
	    ->join('pjMultiLang', "t3.model='pjLocation' AND t3.foreign_id=t1.dropoff_id AND t3.field='title' AND t3.locale='".$this->getLocaleId()."'", 'left outer')
	    ->join('pjMultiLang', "t4.model='pjDropoff' AND t4.foreign_id=t1.line_id AND t4.field='title' AND t4.locale='".$this->getLocaleId()."'", 'left outer')
	    ->join('pjClient', "t5.id=t1.client_id", 'left outer')
	    ->join('pjLineDetail', "t6.line_id=t1.line_id AND t6.location_id=t1.dropoff_id", 'left outer')
	    ->join('pjMultiLang', "t7.model='pjLine' AND t7.foreign_id=t1.line_id AND t7.field='title' AND t7.locale='".$this->getLocaleId()."'", 'left outer')
	    ->join('pjMultiLang', "t8.model='pjLine' AND t8.foreign_id=t1.return_line_id AND t8.field='title' AND t8.locale='".$this->getLocaleId()."'", 'left outer')
	    ->join('pjAuthUser', "t9.id=t5.foreign_id", 'left outer')
	    ->select("t1.*, t2.content as from_location, t3.content as to_location, t4.content as line, t9.name, t9.email, t9.phone,
						t6.duration_pickup,t6.duration_dropoff, t7.content as line, t8.content as return_line")
		->orderBy("t1.created DESC")
		->limit(5)
		->findAll()
		->getData();
	    
		$today_arr = $pjBookingModel
		->reset()
		->join('pjMultiLang', "t2.model='pjLocation' AND t2.foreign_id=t1.location_id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
		->join('pjMultiLang', "t3.model='pjLocation' AND t3.foreign_id=t1.dropoff_id AND t3.field='title' AND t3.locale='".$this->getLocaleId()."'", 'left outer')
		->join('pjMultiLang', "t4.model='pjDropoff' AND t4.foreign_id=t1.line_id AND t4.field='title' AND t4.locale='".$this->getLocaleId()."'", 'left outer')
		->join('pjClient', "t5.id=t1.client_id", 'left outer')
		->join('pjLineDetail', "t6.line_id=t1.line_id AND t6.location_id=t1.dropoff_id", 'left outer')
		->join('pjMultiLang', "t7.model='pjLine' AND t7.foreign_id=t1.line_id AND t7.field='title' AND t7.locale='".$this->getLocaleId()."'", 'left outer')
		->join('pjMultiLang', "t8.model='pjLine' AND t8.foreign_id=t1.return_line_id AND t8.field='title' AND t8.locale='".$this->getLocaleId()."'", 'left outer')
		->join('pjAuthUser', "t9.id=t5.foreign_id", 'left outer')
		->select("t1.*, t2.content as from_location, t3.content as to_location, t4.content as line, t9.name, t9.email, t9.phone,
		      t6.duration_pickup,t6.duration_dropoff, t7.content as line, t8.content as return_line")
		->where("(DATE_FORMAT(t1.booking_date, '%Y-%m-%d')=DATE_FORMAT(NOW(), '%Y-%m-%d'))")
		->where("t1.status <> 'cancelled'")
		->orderBy("t1.created DESC")
		->limit(5)
		->findAll()
		->getData();
		
		$this->set('cnt_new_reservations', $cnt_new_reservations);
		$this->set('cnt_today_transfers', $cnt_today_transfers);
		$this->set('latest_arr', $latest_arr);
		$this->set('today_arr', $today_arr);
	}
}
?>