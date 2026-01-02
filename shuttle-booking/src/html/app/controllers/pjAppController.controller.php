<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjAppController extends pjBaseAppController
{
	public $models = array();
	
	protected static function getAdminEmail()
	{
	    $arr = pjAuthUserModel::factory()->select('t1.email')->find(1)->getData();
	    
	    return $arr ? $arr['email'] : NULL;
	}
	protected static function getAdminPhone()
	{
	    $arr = pjAuthUserModel::factory()->select('t1.phone')->find(1)->getData();
	    
	    return $arr ? $arr['phone'] : NULL;
	}
	public function isClient()
	{
	    return $this->getRoleId() == 3;
	}
	public function getDirection()
	{
		$dir = 'ltr';
		if($this->getLocaleId() != false)
		{
			$locale_arr = pjLocaleModel::factory()->find($this->getLocaleId())->getData();
			$dir = $locale_arr['dir'];
		}
		return $dir;
	}
	
	public function beforeFilter()
	{
	    parent::beforeFilter();
	    
	    if(!in_array($this->_get->toString('controller'), array('pjFront')))
	    {
	        $this->appendJs('pjAdminCore.js');
	        // TODO: DELETE unnecessary files
	        #$this->appendCss('reset.css');
	        #$this->appendCss('pj-all.css', PJ_FRAMEWORK_LIBS_PATH . 'pj/css/');
	        $this->appendCss('admin.css');
	    }
	    
	    return true;
	}
	
	public function pjActionCheckInstall()
	{
	    $this->setLayout('pjActionEmpty');
	    
	    $result = array('status' => 'OK', 'code' => 200, 'text' => 'Operation succeeded', 'info' => array());
	    $folders = array('app/web/upload');
	    foreach ($folders as $dir)
	    {
	        if (!is_writable($dir))
	        {
	            $result['status'] = 'ERR';
	            $result['code'] = 101;
	            $result['text'] = 'Permission requirement';
	            $result['info'][] = sprintf('Folder \'<span class="bold">%1$s</span>\' is not writable. You need to set write permissions (chmod 777) to directory located at \'<span class="bold">%1$s</span>\'', $dir);
	        }
	    }
	    
	    return $result;
	}
    
	/**
	 * Sets some predefined role permissions and grants full permissions to Admin.
	 */
	public function pjActionAfterInstall()
	{
	    $this->setLayout('pjActionEmpty');
	    
	    $result = array('status' => 'OK', 'code' => 200, 'text' => 'Operation succeeded', 'info' => array());
	    
	    $pjAuthRolePermissionModel = pjAuthRolePermissionModel::factory();
	    $pjAuthUserPermissionModel = pjAuthUserPermissionModel::factory();
	    
	    $permissions = pjAuthPermissionModel::factory()->findAll()->getDataPair('key', 'id');
	    
	    $roles = array(1 => 'admin', 2 => 'editor');
	    foreach ($roles as $role_id => $role)
	    {
	        if (isset($GLOBALS['CONFIG'], $GLOBALS['CONFIG']["role_permissions_{$role}"])
	        && is_array($GLOBALS['CONFIG']["role_permissions_{$role}"])
	        && !empty($GLOBALS['CONFIG']["role_permissions_{$role}"]))
	        {
	            $pjAuthRolePermissionModel->reset()->where('role_id', $role_id)->eraseAll();
	            
	            foreach ($GLOBALS['CONFIG']["role_permissions_{$role}"] as $role_permission)
	            {
	                if($role_permission == '*')
	                {
	                    // Grant full permissions for the role
	                    foreach($permissions as $key => $permission_id)
	                    {
	                        $pjAuthRolePermissionModel->setAttributes(compact('role_id', 'permission_id'))->insert();
	                    }
	                    break;
	                }
	                else
	                {
	                    $hasAsterix = strpos($role_permission, '*') !== false;
	                    if($hasAsterix)
	                    {
	                        $role_permission = str_replace('*', '', $role_permission);
	                    }
	                    
	                    foreach($permissions as $key => $permission_id)
	                    {
	                        if($role_permission == $key || ($hasAsterix && strpos($key, $role_permission) !== false))
	                        {
	                            $pjAuthRolePermissionModel->setAttributes(compact('role_id', 'permission_id'))->insert();
	                        }
	                    }
	                }
	            }
	        }
	    }
	    if (isset($GLOBALS['CONFIG'], $GLOBALS['CONFIG']["listing_actions"])
	        && is_array($GLOBALS['CONFIG']["listing_actions"])
	        && !empty($GLOBALS['CONFIG']["listing_actions"]))
	    {
	        $pjAuthPermissionModel = pjAuthPermissionModel::factory();
	        foreach($GLOBALS['CONFIG']["listing_actions"] as $parent_key => $get_action)
	        {
	            $parent_arr = $pjAuthPermissionModel->reset()->where('`key`', $parent_key)->findAll()->getDataIndex(0);
	            if(!empty($parent_arr))
	            {
	                $data = array('parent_id' => ':NULL', 'key' => $get_action, 'inherit_id' => $parent_arr['id']);
	                $pjAuthPermissionModel->reset()->setAttributes($data)->insert();
	            }
	        }
	    }
	    pjAuthRoleModel::factory()->setAttributes(array('id' => 3, 'role' => 'Client', 'is_backend' => 'F', 'T'))->insert();
	    
	    // Grant full permissions to Admin
	    $user_id = 1; // Admin ID
	    $pjAuthUserPermissionModel->reset()->where('user_id', $user_id)->eraseAll();
	    foreach($permissions as $key => $permission_id)
	    {
	        $pjAuthUserPermissionModel->setAttributes(compact('user_id', 'permission_id'))->insert();
	    }
	    
	    return $result;
	}

	public function friendlyURL($str, $divider='-')
	{
		$str = mb_strtolower($str, mb_detect_encoding($str));
		$str = trim($str);
		$str = preg_replace('/[_|\s]+/', $divider, $str);
		$str = preg_replace('/\x{00C5}/u', 'AA', $str);
		$str = preg_replace('/\x{00C6}/u', 'AE', $str);
		$str = preg_replace('/\x{00D8}/u', 'OE', $str);
		$str = preg_replace('/\x{00E5}/u', 'aa', $str);
		$str = preg_replace('/\x{00E6}/u', 'ae', $str);
		$str = preg_replace('/\x{00F8}/u', 'oe', $str);
		$str = preg_replace('/[^a-z\x{0400}-\x{04FF}0-9-]+/u', '', $str);
		$str = preg_replace('/[-]+/', $divider, $str);
		$str = preg_replace('/^-+|-+$/', '', $str);
		return $str;
	}
	public function calcPrices($line_id, $location_id, $traveling, $passengers, $option_arr)
	{
		$sub_total = 0;
		$tax = 0;
		$total = 0;
		$deposit = 0;
		
		$line_arr = pjLineDetailModel::factory()->where('t1.line_id', $line_id)->where('t1.location_id', $location_id)->findAll()->getDataIndex(0);
		
		if(!empty($line_arr))
		{
			$price_per_person = 0;
			if($traveling == 'from')
			{
				$price_per_person = (float) $line_arr['price_dropoff'];
			}else{
				$price_per_person = (float) $line_arr['price_pickup'];
			}
			$sub_total = $passengers * $price_per_person;
			$tax = ($sub_total * $option_arr['o_tax_payment']) / 100;
			$total = $sub_total + $tax;
			$deposit = 	($total * $option_arr['o_deposit_payment']) / 100;
		}
		return compact('sub_total', 'tax', 'total', 'deposit');
	}
	public function pjActionGetLineDetails($line_id, $location_id, $dropoff_id, $traveling, $booking_date)
	{
		$week_number = date('w', strtotime($booking_date));
		$timetable_arr = pjTimetableModel::factory()
			->where('t1.status', 'T')
			->where('t1.location_id', $location_id)
			->where('t1.line_id', $line_id)
			->where('t1.direction', $traveling == 'from' ? 'departing' : 'arriving')
			->where("(t1.every LIKE '%$week_number%')")
			->findAll()
			->getDataIndex(0);
		$line_detail_arr = pjLineDetailModel::factory()->where('t1.line_id', $line_id)->where('t1.location_id', $dropoff_id)->findAll()->getDataIndex(0);
		return compact('timetable_arr', 'line_detail_arr');
	}
	public function getTokens($option_arr, $booking_arr, $salt, $locale_id)
	{
	    $name_titles = __('personal_titles', true, false);
	    $country = NULL;
	    $title = !empty($booking_arr['c_title']) ? $name_titles[$booking_arr['c_title']] : NULL;
	    $first_name = pjSanitize::clean($booking_arr['c_fname']);
	    $last_name = pjSanitize::clean($booking_arr['c_lname']);
	    $phone = pjSanitize::clean($booking_arr['c_phone']);
	    $email = pjSanitize::clean($booking_arr['c_email']);
	    
	    if((int) $booking_arr['client_id'] > 0)
	    {
	        $client = pjClientModel::factory()
	        ->select("t1.*, t2.content AS country_title")
	        ->join('pjMultiLang', "t2.model='pjBaseCountry' AND t2.foreign_id=t1.country_id AND t2.field='name' AND t2.locale='".$locale_id."'", 'left outer')
	        ->find($booking_arr['client_id'])
	        ->getData();
	        if (!empty($client))
	        {
	            $country = $client['country_title'];
	            $title = !empty($client['title']) ? $name_titles[$client['title']] : NULL;
	            if((int) $client['foreign_id'] > 0)
	            {
	                $user = pjAuthUserModel::factory()->find($client['foreign_id'])->getData();
	                if(!empty($user))
	                {
	                    $phone = pjSanitize::clean($user['phone']);
	                    $email = pjSanitize::clean($user['email']);
	                    $name_arr = pjUtil::splitName($user['name']);
	                    $first_name = $name_arr[0];
	                    $last_name = $name_arr[1];
	                }
	            }
	        }
	    }
	    
	    $sub_total = pjCurrency::formatPrice($booking_arr['sub_total']);
	    $tax = pjCurrency::formatPrice($booking_arr['tax']);
	    $total = pjCurrency::formatPrice($booking_arr['total']);
	    $deposit = pjCurrency::formatPrice($booking_arr['deposit']);
		
		$booking_date = NULL;
		if (isset($booking_arr['booking_date']) && !empty($booking_arr['booking_date']))
		{
			$tm = strtotime($booking_arr['booking_date'] . ' ' . $booking_arr['booking_time']);
			$booking_date = date($option_arr['o_date_format'] . ', ' . $option_arr['o_time_format'], $tm);
		}
		$return_date = NULL;
		if ($booking_arr['has_return'] == 'T' && isset($booking_arr['return_date']) && !empty($booking_arr['return_date']))
		{
			$tm = strtotime($booking_arr['return_date'] . ' ' . $booking_arr['return_time']);
			$return_date = date($option_arr['o_date_format'], $tm) . ', ' . date($option_arr['o_time_format'], $tm);
		}
		
		$flight_time = null;
		if(!empty($booking_arr['c_flight_time']))
		{
			$flight_time = date($option_arr['o_time_format'], strtotime($booking_arr['c_flight_time']));
		}
		$from = $booking_arr['traveling'] == 'from' ? $booking_arr['from_location'] . ' ('.pjSanitize::html($booking_arr['from_address']).')' : $booking_arr['to_location'] . ' ('.pjSanitize::html($booking_arr['to_address']).')';
		$to = $booking_arr['traveling'] == 'from' ? $booking_arr['to_location'] . ' ('.pjSanitize::html($booking_arr['to_address']).')' : $booking_arr['from_location'] . ' ('.pjSanitize::html($booking_arr['from_address']).')';
		$distance = @$booking_arr['distance'] . ($option_arr['o_mileage'] == 'km' ? 'km' : ($booking_arr['distance'] == 1 ? 'mile' : __('front_miles', true)));
		$duration = @$booking_arr['duration'] . ' ' . __('front_minutes', true);
		$return_duration = @$booking_arr['return_duration'] . ' ' . __('front_minutes', true);
				
		$cancelURL = PJ_INSTALL_URL . 'index.php?controller=pjFrontEnd&action=pjActionCancel&id='.@$booking_arr['id'].'&hash='.sha1(@$booking_arr['id'].@$booking_arr['created'].$salt);
		$cancelURL = '<a href="'.$cancelURL.'">'.$cancelURL.'</a>';
		$search = array(
			'{Title}', '{FirstName}', '{LastName}', '{Email}', '{Password}', '{Phone}', '{Country}', '{City}', '{State}', '{Zip}', '{Address}','{Company}', 
			'{Airline}', '{FlightNumber}', '{ArrivalTime}', '{Terminal}',
			'{CCType}', '{CCNum}', '{CCExp}','{CCSec}', '{PaymentMethod}', 
			'{UniqueID}', '{DateTime}', '{ReturnDateTime}', '{From}', '{To}', '{Line}', '{ReturnLine}',
			'{Passengers}','{Distance}','{Duration}','{ReturnDuration}',
			'{SubTotal}', '{Tax}', '{Total}', '{Deposit}', '{Notes}',
			'{CancelURL}');
		$replace = array(
			$title, $first_name, $last_name, $email, $password, $phone, $country, $city, $state, $zip, $address, pjSanitize::clean(@$booking_arr['c_company']),
			pjSanitize::clean(@$booking_arr['c_airline_company']), pjSanitize::clean(@$booking_arr['c_flight_number']), $flight_time, $booking_arr['c_terminal'],
			@$booking_arr['cc_type'], @$booking_arr['cc_num'], (@$booking_arr['payment_method'] == 'creditcard' ? @$booking_arr['cc_exp_month'] . '-' . @$booking_arr['cc_exp_year'] : NULL), @$booking_arr['cc_code'], @$booking_arr['payment_method'], 
			@$booking_arr['uuid'], $booking_date, $return_date, $from, $to, @$booking_arr['line'], @$booking_arr['return_line'],
			@$booking_arr['passengers'],$distance,$duration, $return_duration,
			@$sub_total, @$tax, @$total, @$deposit, @$booking_arr['c_notes'],
			$cancelURL);

		return compact('search', 'replace');
	}
	
	public function getClientTokens($option_arr, $client, $salt, $locale_id)
	{
	    $name_titles = __('personal_titles', true, false);
	    
	    $first_name = NULL;
	    $last_name = NULL;
	    $phone = NULL;
	    $email = NULL;
	    $password = NULL;
	    $title = NULL;
	    
	    $client_arr = pjClientModel::factory()
	    ->select("t1.*, t2.content AS country_title")
	    ->join('pjMultiLang', "t2.model='pjBaseCountry' AND t2.foreign_id=t1.country_id AND t2.field='name' AND t2.locale='".$locale_id."'", 'left outer')
	    ->find($client['id'])
	    ->getData();
	    if (!empty($client_arr))
	    {
	        $country = $client_arr['country_title'];
	        $title = !empty($client['title']) ? $name_titles[$client_arr['title']] : NULL;
	        if((int) $client_arr['foreign_id'] > 0)
	        {
	            $user = pjAuthUserModel::factory()->find($client_arr['foreign_id'])->getData();
	            if(!empty($user))
	            {
	                $phone = pjSanitize::clean($user['phone']);
	                $email = pjSanitize::clean($user['email']);
	                $password = pjSanitize::clean($user['password']);
	                $name_arr = pjUtil::splitName($user['name']);
	                $first_name = $name_arr[0];
	                $last_name = $name_arr[1];
	            }
	        }
	    }
	    
	    $search = array('{Title}', '{FirstName}', '{LastName}', '{Email}', '{Password}', '{Phone}');
	    $replace = array($title, $first_name, $last_name, $email, $password, $phone);
	    
	    return compact('search', 'replace');
	}
	
	public static function pjActionGetSubjectMessage($notification, $locale_id, $calendar_id)
	{
	    $field = $notification['variant'] . '_tokens_' . $notification['recipient'];
	    $field = str_replace('confirmation', 'confirm', $field);
	    $pjMultiLangModel = pjMultiLangModel::factory();
	    $lang_message = $pjMultiLangModel
	    ->reset()
	    ->select('t1.*')
	    ->where('t1.foreign_id', $calendar_id)
	    ->where('t1.model','pjOption')
	    ->where('t1.locale', $locale_id)
	    ->where('t1.field', $field)
	    ->limit(0, 1)
	    ->findAll()
	    ->getData();
	    $field = $notification['variant'] . '_subject_' . $notification['recipient'];
	    $field = str_replace('confirmation', 'confirm', $field);
	    $lang_subject = $pjMultiLangModel
	    ->reset()
	    ->select('t1.*')
	    ->where('t1.foreign_id',  $calendar_id)
	    ->where('t1.model','pjOption')
	    ->where('t1.locale', $locale_id)
	    ->where('t1.field', $field)
	    ->limit(0, 1)
	    ->findAll()
	    ->getData();
	    return compact('lang_message', 'lang_subject');
	}
	
	public static function pjActionGetSmsMessage($notification, $locale_id, $calendar_id)
	{
	    $field = $notification['variant'] . '_sms_' . $notification['recipient'];
	    $field = str_replace('confirmation', 'confirm', $field);
	    $pjMultiLangModel = pjMultiLangModel::factory();
	    $lang_message = $pjMultiLangModel
	    ->reset()
	    ->select('t1.*')
	    ->where('t1.foreign_id', $calendar_id)
	    ->where('t1.model','pjOption')
	    ->where('t1.locale', $locale_id)
	    ->where('t1.field', $field)
	    ->limit(0, 1)
	    ->findAll()
	    ->getData();
	    return compact('lang_message');
	}
	
	public function pjActionAccountSend($option_arr, $client_id, $salt, $opt, $locale_id)
	{
	    $Email = self::getMailer($option_arr);
	    
	    $pjNotificationModel = pjNotificationModel::factory();
	    
	    $notification = $pjNotificationModel->reset()->where('recipient', 'client')->where('transport', 'email')->where('variant', $opt)->findAll()->getDataIndex(0);
	    if((int) $notification['id'] > 0 && $notification['is_active'] == 1)
	    {
	        $data = pjClientModel::factory()->find($client_id)->getData();
	        $tokens = pjAppController::getClientTokens($option_arr, $data, PJ_SALT, $locale_id);
	        $resp = pjAppController::pjActionGetSubjectMessage($notification, $locale_id, $this->getForeignId());
	        $lang_message = $resp['lang_message'];
	        $lang_subject = $resp['lang_subject'];
	        $auth_client = pjAuthUserModel::factory()->find($data['foreign_id'])->getData();
	        if (count($lang_message) === 1 && count($lang_subject) === 1 && !empty($auth_client['email']))
	        {
	            $message = preg_replace('/\[Delivery\].*\[\/Delivery\]/s', '', $lang_message[0]['content']);
	            $message = str_replace($tokens['search'], $tokens['replace'], $message);
	            $Email
	            ->setTo($auth_client['email'])
	            ->setSubject($lang_subject[0]['content'])
	            ->send($message);
	        }
	    }
	}
	
	public function pjActionConfirmSend($option_arr, $booking_arr, $salt, $opt, $locale_id)
	{
	    $pjMultiLangModel = pjMultiLangModel::factory();
	    $pjNotificationModel = pjNotificationModel::factory();
	    
	    $Email = self::getMailer($option_arr);
	    
	    $locale_id = isset($booking_arr['locale_id']) && (int) $booking_arr['locale_id'] > 0 ? (int) $booking_arr['locale_id'] : $this->getLocaleId();
	    $booking_arr['calendar_id'] = $this->getForeignId();
	    
	    $tokens = pjAppController::getTokens($option_arr, $booking_arr, $salt, $locale_id);
	    
	    $admin_email = $this->getAdminEmail();
	    $admin_phone = $this->getAdminPhone();
	    
	    $client_email = NULL;
	    $client_phone = NULL;
	    if((int) $booking_arr['client_id'] > 0)
	    {
	        $client = pjClientModel::factory()->find($booking_arr['client_id'])->getData();
	        if (!empty($client))
	        {
	            if((int) $client['foreign_id'] > 0)
	            {
	                $user = pjAuthUserModel::factory()->find($client['foreign_id'])->getData();
	                if(!empty($user['email']))
	                {
	                    $client_email = $user['email'];
	                }
	                if(!empty($user['phone']))
	                {
	                    $client_phone = $user['phone'];
	                }
	            }
	        }
	    }
	    
	    /*Email sent to Client*/
	    if($client_email != NULL)
	    {
	        $notification = $pjNotificationModel->reset()->where('recipient', 'client')->where('transport', 'email')->where('variant', $opt)->findAll()->getDataIndex(0);
	        if((int) $notification['id'] > 0 && $notification['is_active'] == 1)
	        {
	            $resp = pjAppController::pjActionGetSubjectMessage($notification, $locale_id, $booking_arr['calendar_id']);
	            $lang_message = $resp['lang_message'];
	            $lang_subject = $resp['lang_subject'];
	            if (count($lang_message) === 1 && count($lang_subject) === 1 && !empty($lang_subject[0]['content']))
	            {
	                $subject = str_replace($tokens['search'], $tokens['replace'], $lang_subject[0]['content']);
	                $message = str_replace($tokens['search'], $tokens['replace'], $lang_message[0]['content']);
	                $Email
	                ->setTo($client_email)
	                ->setSubject(stripslashes($subject))
	                ->send(stripslashes($message));
	            }
	        }
	    }
	    
	    /*Email sent to Admin*/
	    $notification = $pjNotificationModel->reset()->where('recipient', 'admin')->where('transport', 'email')->where('variant', $opt)->findAll()->getDataIndex(0);
	    
	    if((int) $notification['id'] > 0 && $notification['is_active'] == 1)
	    {
	        $resp = pjAppController::pjActionGetSubjectMessage($notification, $locale_id, $booking_arr['calendar_id']);
	        $lang_message = $resp['lang_message'];
	        $lang_subject = $resp['lang_subject'];
	        if (count($lang_message) === 1 && count($lang_subject) === 1 && !empty($lang_subject[0]['content']))
	        {
	            $subject = str_replace($tokens['search'], $tokens['replace'], $lang_subject[0]['content']);
	            $message = str_replace($tokens['search'], $tokens['replace'], $lang_message[0]['content']);
	            
	            $Email
	            ->setTo($admin_email)
	            ->setSubject(stripslashes($subject))
	            ->send(stripslashes($message));
	        }
	    }
	    
	    /*SMS sent to client*/
	    if($client_phone != NULL)
	    {
	        $notification = $pjNotificationModel->reset()->where('recipient', 'client')->where('transport', 'sms')->where('variant', $opt)->findAll()->getDataIndex(0);
	        if((int) $notification['id'] > 0 && $notification['is_active'] == 1)
	        {
	            $resp = pjAppController::pjActionGetSmsMessage($notification, $locale_id, $booking_arr['calendar_id']);
	            $lang_message = $resp['lang_message'];
	            if (count($lang_message) === 1)
	            {
	                $message = str_replace($tokens['search'], $tokens['replace'], $lang_message[0]['content']);
	                $params = array(
	                    'text' => stripslashes($message),
	                    'type' => 'unicode',
	                    'key' => md5($option_arr['private_key'] . PJ_SALT)
	                );
	                $params['number'] = $client_phone;
	                pjBaseSms::init($params)->pjActionSend();
	            }
	        }
	    }
	    
	    /*SMS sent to admin*/
	    if(!empty($admin_phone))
	    {
	        $notification = $pjNotificationModel->reset()->where('recipient', 'admin')->where('transport', 'sms')->where('variant', $opt)->findAll()->getDataIndex(0);
	        if((int) $notification['id'] > 0 && $notification['is_active'] == 1)
	        {
	            $resp = pjAppController::pjActionGetSmsMessage($notification, $locale_id, $booking_arr['calendar_id']);
	            $lang_message = $resp['lang_message'];
	            if (count($lang_message) === 1)
	            {
	                $message = str_replace($tokens['search'], $tokens['replace'], $lang_message[0]['content']);
	                $params = array(
	                    'text' => stripslashes($message),
	                    'type' => 'unicode',
	                    'key' => md5($option_arr['private_key'] . PJ_SALT)
	                );
	                $params['number'] = $admin_phone;
	                pjBaseSms::init($params)->pjActionSend();
	            }
	        }
	    }
	}
}
?>