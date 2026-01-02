<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjAdminBookings extends pjAdmin
{
    public function pjActionCheckID()
    {
        $this->setAjax(true);
        
        if ($this->isXHR())
        {
            if ($this->_get->isEmpty('uuid'))
            {
                echo 'false';
                exit;
            }
            $pjBookingModel = pjBookingModel::factory()->where('t1.uuid', $this->_get->tostring('uuid'));
            if ($this->_get->toInt('id') > 0)
            {
                $pjBookingModel->where('t1.id !=', $this->_get->toInt('id'));
            }
            echo $pjBookingModel->findCount()->getData() == 0 ? 'true' : 'false';
        }
        exit;
    }
    
    public function pjActionGetDropoff()
    {
        $this->setAjax(true);
        
        if ($this->isXHR())
        {
            if($this->_get->toInt('location_id') > 0)
            {
                $location_id = $this->_get->toInt('location_id');
                
                $location_id_arr = pjLineDetailModel::factory()
                ->select("DISTINCT t1.location_id")
                ->where("(t1.line_id IN(SELECT `TL`.id FROM `".pjLineModel::factory()->getTable()."` AS `TL` WHERE `TL`.location_id='".$location_id."'))")
                ->findAll()
                ->getDataPair(null, 'location_id');
                if(!empty($location_id_arr))
                {
                    $pd_arr = pjLocationModel::factory()
                    ->join('pjMultiLang', "t2.model='pjLocation' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
                    ->select("t1.*, t2.content as title")
                    ->whereIn('t1.id', $location_id_arr)
                    ->where('t1.type', 'PD')
                    ->where('t1.status', 'T')
                    ->orderBy("title ASC")
                    ->findAll()->getData();
                    $this->set('pd_arr', $pd_arr);
                }
            }
        }
    }
    public function pjActionGetLines()
    {
        $this->setAjax(true);
        
        if ($this->isXHR())
        {
            if($this->_get->toInt('location_id') > 0 && $this->_get->toInt('dropoff_id') > 0)
            {
                $location_id = $this->_get->toInt('location_id');
                $dropoff_id = $this->_get->toInt('dropoff_id');
                $passengers = $this->_get->toInt('passengers');
                
                $line_arr = pjLineModel::factory()
                ->select("t1.*, t2.content as title")
                ->join('pjMultiLang', "t2.model='pjLine' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
                ->where("t1.location_id", $location_id)
                ->where("t1.seats >=", $passengers)
                ->where("(t1.id IN(SELECT `TLD`.line_id FROM `".pjLineDetailModel::factory()->getTable()."` AS `TLD` WHERE `TLD`.`location_id`='".$dropoff_id."'))")
                ->findAll()
                ->getData();
                $this->set('line_arr', $line_arr);
            }
        }
    }
    public function pjActionGetTimes()
    {
        $this->setAjax(true);
        
        if ($this->isXHR())
        {
            if($this->_get->toInt('line_id') > 0 && $this->_get->toInt('location_id') > 0 && $this->_get->check('booking_date') && !$this->_get->isEmpty('booking_date'))
            {
                $line_id = $this->_get->toInt('line_id');
                $location_id =  $this->_get->toInt('location_id');
                $dropoff_id =  $this->_get->toInt('dropoff_id');
                $traveling = $this->_get->toString('traveling');
                $booking_date = pjDateTime::formatDate($this->_get->toString('booking_date'), $this->option_arr['o_date_format']);
                $result = $this->pjActionGetLineDetails($line_id, $location_id, $dropoff_id, $traveling, $booking_date);
                $this->set('traveling', $traveling);
                $this->set('line_detail_arr', $result['line_detail_arr']);
                $this->set('timetable_arr', $result['timetable_arr']);
                
                $pjBookingModel = pjBookingModel::factory();
                if($this->_get->check('id') && $this->_get->toInt('id') > 0)
                {
                    $pjBookingModel->where("t1.id <>", $this->_get->toInt('id'));
                }
                $booked_arr = $pjBookingModel
                ->where("t1.location_id", $location_id)
                ->where("t1.dropoff_id", $dropoff_id)
                ->where("t1.status <>", 'cancelled')
                ->where("( (t1.line_id='".$line_id."' AND t1.booking_date='".$booking_date."') OR (t1.return_line_id='".$line_id."' AND t1.return_date='".$booking_date."') )")
                ->findAll()
                ->getData();
                $booked_time_arr = array();
                foreach($booked_arr as $k => $v)
                {
                    $booked_time_arr[date("H:i", strtotime($v['booking_time']))] += $v['passengers'];
                    if(!empty($v['return_time']))
                    {
                        $booked_time_arr[date("H:i", strtotime($v['return_time']))] += $v['passengers'];
                    }
                }
                $this->set('booked_time_arr', $booked_time_arr);
                $this->set('line', pjLineModel::factory()->find($line_id)->getData());
            }
        }
    }
    public function pjActionGetPrices()
    {
        $this->setAjax(true);
        
        if ($this->isXHR())
        {
            $sub_total = $tax = $total = $deposit = 0;
            
            if($this->_post->toInt('line_id') > 0)
            {
                $passengers = $this->_post->toInt('passengers');
                $price_per_person = $this->_post->toFloat('price_per_person');
                $return_price_per_person = $this->_post->check('has_return') ? $this->_post->toFloat('return_price_per_person') : 0;
                $tax_percentage = (float) $this->option_arr['o_tax_payment'];
                $deposit_percentage = (float) $this->option_arr['o_deposit_payment'];
                
                if($price_per_person > 0)
                {
                    $sub_total = ($price_per_person + $return_price_per_person) * $passengers;
                    $tax = ($sub_total * $tax_percentage) / 100;
                    $total = $sub_total + $tax;
                    $deposit = ($total * $deposit_percentage) / 100;
                }
            }
            
            $sub_total_format = pjCurrency::formatPrice($sub_total);
            $tax_format = pjCurrency::formatPrice($tax);
            $total_format = pjCurrency::formatPrice($total);
            $deposit_format = pjCurrency::formatPrice($deposit);
            
            self::jsonResponse(compact("sub_total", "tax", "total", "deposit", "sub_total_format", "tax_format", "total_format", "deposit_format"));
        }
    }
    public function pjActionCreate()
    {
        $this->checkLogin();
        if (!pjAuth::factory()->hasAccess())
        {
            $this->sendForbidden();
            return;
        }
        if (self::isPost() && $this->_post->toInt('booking_create'))
        {
            $pjBookingModel = pjBookingModel::factory();
            
            $data = array();
            $data['uuid'] = pjUtil::uuid();
            $data['ip'] = pjUtil::getClientIp();
            
            $data['booking_date'] = pjDateTime::formatDate($this->_post->toString('booking_date'), $this->option_arr['o_date_format']);
            $data['c_flight_time'] = $this->_post->check('c_flight_time') ? date("H:i:s", strtotime($this->_post->toString('c_flight_time'))) : ':NULL';
            if($this->_post->check('has_return'))
            {
                $data['return_date'] = pjDateTime::formatDate($this->_post->toString('return_date'), $this->option_arr['o_date_format']);
                $data['has_return'] = 'T';
            }else{
                $data['has_return'] = 'F';
                $data['return_date'] = ':NULL';
                $data['return_time'] = ':NULL';
                $data['return_line_id'] = ':NULL';
            }   
            if($this->_post->check('new_client'))
            {
                $c_data = array();
                $c_data['title'] = $this->_post->toString('c_title');
                $c_data['fname'] = $this->_post->toString('c_fname');
                $c_data['lname'] = $this->_post->toString('c_lname');
                $c_data['email'] = $this->_post->toString('c_email');
                $c_data['password'] = $this->_post->toString('c_password');
                $c_data['phone'] = $this->_post->toString('c_phone');
                $c_data['company'] = $this->_post->toString('c_company');
                $c_data['address'] = $this->_post->toString('c_address');
                $c_data['city'] = $this->_post->toString('c_city');
                $c_data['state'] = $this->_post->toString('c_state');
                $c_data['zip'] = $this->_post->toString('c_zip');
                $c_data['country_id'] = $this->_post->toInt('c_country');
                $c_data['status'] = 'T';
                $c_data['locale_id'] = $this->getLocaleId();
                $response = pjFrontClient::init($c_data)->createClient();
                if(isset($response['client_id']) && (int) $response['client_id'] > 0)
                {
                    $data['client_id'] = $response['client_id'];
                }
            }else{
                $data['client_id'] = $this->_post->toInt('client_id');
            }
            $id = pjBookingModel::factory(array_merge($this->_post->raw(), $data))->insert()->getInsertId();
            
            if ($id !== false && (int) $id > 0)
            {
                $err = 'ABB03';
            }else{
                $err = 'ABB04';
            }
            
            pjUtil::redirect(PJ_INSTALL_URL. "index.php?controller=pjAdminBookings&action=pjActionIndex&err=$err");
        }
        if (self::isGet())
        {
            $country_arr = pjBaseCountryModel::factory()
            ->select('t1.*, t2.content AS `name`')
            ->join('pjMultiLang', "t2.model='pjBaseCountry' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
            ->where('t1.status', 'T')
            ->orderBy('`name` ASC')
            ->findAll()->getData();
            $this->set('country_arr', $country_arr);
            
            $client_arr = pjClientModel::factory()
            ->select("t1.*, t2.email as c_email, t2.name as c_name, t2.phone as c_phone")
            ->join("pjAuthUser", "t2.id=t1.foreign_id", 'left outer')
            ->where('t2.status', 'T')
            ->orderBy('t2.name ASC')
            ->findAll()
            ->getData();
            $this->set('client_arr', $client_arr);
            
            $pjLocationModel = pjLocationModel::factory();
            $da_arr = $pjLocationModel
            ->join('pjMultiLang', "t2.model='pjLocation' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
            ->select("t1.*, t2.content as title")
            ->where('t1.type', 'DA')
            ->where('t1.status', 'T')
            ->orderBy("title ASC")
            ->findAll()->getData();
            $this->set('da_arr', $da_arr);
            
            $this->set('date_format', pjUtil::toBootstrapDate($this->option_arr['o_date_format']));
            if(pjObject::getPlugin('pjPayments') !== NULL)
            {
                $this->set('payment_option_arr', pjPaymentOptionModel::factory()->getOptions($this->getForeignId()));
                $this->set('payment_titles', pjPayments::getPaymentTitles($this->getForeignId(), $this->getLocaleId()));
            }else{
                $this->set('payment_titles', __('payment_methods', true));
            }
            
            $this->appendCss('css/select2.min.css', PJ_THIRD_PARTY_PATH . 'select2/');
            $this->appendJs('js/select2.full.min.js', PJ_THIRD_PARTY_PATH . 'select2/');
            $this->appendCss('clockpicker.css', PJ_THIRD_PARTY_PATH . 'clockpicker/');
            $this->appendJs('clockpicker.js', PJ_THIRD_PARTY_PATH . 'clockpicker/');
            $this->appendCss('datepicker.css', PJ_THIRD_PARTY_PATH . 'bootstrap_datepicker/');
            $this->appendJs('bootstrap-datepicker.js', PJ_THIRD_PARTY_PATH . 'bootstrap_datepicker/');
            $this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
            $this->appendJs('pjAdminBookings.js');
        }
    }
	public function pjActionIndex()
	{
	    $this->checkLogin();
	    if (!pjAuth::factory()->hasAccess())
	    {
	        $this->sendForbidden();
	        return;
	    }
	    
	    $pjLocationModel = pjLocationModel::factory();
	    $pickup_arr = $pjLocationModel
	    ->join('pjMultiLang', "t2.model='pjLocation' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
	    ->select("t1.*, t2.content as title")
	    ->where('t1.type', 'DA')
	    ->where('t1.status', 'T')
	    ->orderBy("title ASC")
	    ->findAll()->getData();
	    $this->set('pickup_arr', $pickup_arr);
	    
	    $this->appendCss('datepicker.css', PJ_THIRD_PARTY_PATH . 'bootstrap_datepicker/');
	    $this->appendJs('bootstrap-datepicker.js', PJ_THIRD_PARTY_PATH . 'bootstrap_datepicker/');
	    $this->appendJs('jquery.datagrid.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
	    $this->appendJs('pjAdminBookings.js');
	}
	
	public function pjActionGetBooking()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			$pjBookingModel = pjBookingModel::factory()
				->join('pjMultiLang', "t2.model='pjLocation' AND t2.foreign_id=t1.location_id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
				->join('pjMultiLang', "t3.model='pjLocation' AND t3.foreign_id=t1.dropoff_id AND t3.field='title' AND t3.locale='".$this->getLocaleId()."'", 'left outer')
				->join('pjClient', "t4.id=t1.client_id", 'left')
				->join('pjAuthUser', "t5.id=t4.foreign_id", 'left outer');
			
			if ($q = $this->_get->toString('q'))
			{
				$pjBookingModel->where("(t5.name LIKE '%$q%' OR t5.email LIKE '%$q%')");
			}
			if ($this->_get->toInt('client_id') > 0)
			{
			    $client_id = $this->_get->toInt('client_id');
				$pjBookingModel->where("(t1.client_id='".$client_id."')");
			}
			if ($this->_get->check('status') && in_array($this->_get->toString('status'), array('confirmed', 'pending', 'cancelled')))
			{
			    $pjBookingModel->where('t1.status', $this->_get->toString('status'));
			}
			if ($this->_get->check('name') && !$this->_get->isEmpty('name'))
			{
			    $q = $this->_get->toString('name');
			    $pjBookingModel->where("(t5.name LIKE '%$q%')");
			}
			if ($this->_get->check('email') && !$this->_get->isEmpty('email'))
			{
			    $q = $this->_get->toString('email');
			    $pjBookingModel->where("(t5.email LIKE '%$q%')");
			}
			if ($this->_get->check('phone') && !$this->_get->isEmpty('phone'))
			{
			    $q = $this->_get->toString('phone');
			    $pjBookingModel->where("(t5.phone LIKE '%$q%')");
			}
			if ($this->_get->check('date') && !$this->_get->isEmpty('date'))
			{
			    $date = pjDateTime::formatDate(pjObject::escapeString($this->_get->toString('date')), $this->option_arr['o_date_format']);
				$pjBookingModel->where("((DATE_FORMAT(t1.booking_date, '%Y-%m-%d')='$date') OR (t1.has_return='T' AND DATE_FORMAT(t1.return_date, '%Y-%m-%d')='$date'))");
			}
			if ($this->_get->toInt('location_id') > 0)
			{
			    $location_id = $this->_get->toInt('location_id');
				$pjBookingModel->where("(t1.location_id='".$location_id."')");
			}
			if ($this->_get->toInt('dropoff_id') > 0)
			{
			    $dropoff_id = $this->_get->toInt('dropoff_id');
				$pjBookingModel->where("(t1.dropoff_id='".$dropoff_id."')");
			}
			
			$column = 'title';
			$direction = 'ASC';
			if ($this->_get->toString('column') && in_array(strtoupper($this->_get->toString('direction')), array('ASC', 'DESC')))
			{
			    $column = $this->_get->toString('column');
			    $direction = strtoupper($this->_get->toString('direction'));
			}
			
			$total = $pjBookingModel->findCount()->getData();
			
			$rowCount = $this->_get->toInt('rowCount') ?: 10;
			$pages = ceil($total / $rowCount);
			$page = $this->_get->toInt('page') ?: 1;
			$offset = ((int) $page - 1) * $rowCount;
			if ($page > $pages)
			{
				$page = $pages;
			}

			$data = array();
			
			$data = $pjBookingModel
				->select("t1.*, t2.content as from_location, t3.content as to_location, t5.name, t5.email,t5.phone,
							AES_DECRYPT(t1.cc_type, '".PJ_SALT."') AS `cc_type`,
							AES_DECRYPT(t1.cc_num, '".PJ_SALT."') AS `cc_num`,
							AES_DECRYPT(t1.cc_exp_month, '".PJ_SALT."') AS `cc_exp_month`,
							AES_DECRYPT(t1.cc_exp_year, '".PJ_SALT."') AS `cc_exp_year`,
							AES_DECRYPT(t1.cc_code, '".PJ_SALT."') AS `cc_code`
						")
				->orderBy("$column $direction")
				->limit($rowCount, $offset)
				->findAll()
				->getData();
				
			foreach($data as $k => $v)
			{
				$v['client'] = pjSanitize::clean($v['name']) . "<br/>" . pjSanitize::clean($v['email']);
				$v['pickup_dropoff'] = $v['from_location'] . "<br/>" . $v['to_location'];
				if($v['has_return'] == 'T')
				{
					$v['date_time'] = date($this->option_arr['o_date_format'] . ', ' . $this->option_arr['o_time_format'], strtotime($v['booking_date'] . ' ' . $v['booking_time'])) . '<br/>' . strtolower(__('lblReturn', true, false)) . ': ' . date($this->option_arr['o_date_format'] . ', ' . $this->option_arr['o_time_format'], strtotime($v['return_date'] . ' ' . $v['return_time'])) ;
				}else{
					$v['date_time'] = date($this->option_arr['o_date_format'] . ', ' . $this->option_arr['o_time_format'], strtotime($v['booking_date'] . ' ' . $v['booking_time']));
				}
				$data[$k] = $v;
			}
						
			pjAppController::jsonResponse(compact('data', 'total', 'pages', 'page', 'rowCount', 'column', 'direction'));
		}
		exit;
	}
	
	public function pjActionDeleteBooking()
	{
	    $this->setAjax(true);
	    
	    if (!$this->isXHR())
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Missing headers.'));
	    }
	    if (!self::isPost())
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'HTTP method not allowed.'));
	    }
	    if (!pjAuth::factory()->hasAccess())
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 102, 'text' => 'Access denied.'));
	    }
	    if (!($this->_get->toInt('id')))
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 103, 'text' => 'Missing, empty or invalid parameters.'));
	    }
	    $pjBookingModel = pjBookingModel::factory();
	    $arr = $pjBookingModel->find($this->_get->toInt('id'))->getData();
	    if (!$arr)
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 103, 'text' => 'Fleet not found.'));
	    }
	    $id = $this->_get->toInt('id');
	    if ($pjBookingModel->setAttributes(array('id' => $id))->erase()->getAffectedRows() == 1)
	    {
	        pjBookingPaymentModel::factory()->where('booking_id', $id)->eraseAll();
	        self::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Fleet has been deleted'));
	    }else{
	        self::jsonResponse(array('status' => 'ERR', 'code' => 105, 'text' => 'Fleet has not been deleted.'));
	    }
	    exit;
	}
	
	public function pjActionDeleteBookingBulk()
	{
	    $this->setAjax(true);
	    if (!$this->isXHR())
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Missing headers.'));
	    }
	    if (!self::isPost())
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'HTTP method not allowed.'));
	    }
	    if (!pjAuth::factory()->hasAccess())
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 102, 'text' => 'Access denied.'));
	    }
	    if (!$this->_post->has('record'))
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 103, 'text' => 'Missing, empty or invalid parameters.'));
	    }
	    $record = $this->_post->toArray('record');
	    if (empty($record))
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 104, 'text' => 'Missing, empty or invalid parameters.'));
	    }
	    $pjBookingModel = pjBookingModel::factory();
	    $pjBookingModel->reset()->whereIn('id', $record)->eraseAll();
	    pjBookingPaymentModel::factory()->whereIn('booking_id', $record)->eraseAll();
	    self::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Fleet(s) has been deleted.'));
	    exit;
	}
	
	public function pjActionExportBooking()
	{
	    $this->checkLogin();
	    if (!pjAuth::factory()->hasAccess())
	    {
	        $this->sendForbidden();
	        return;
	    }
	    
	    $record = $this->_post->toArray('record');
	    if (!empty($record))
	    {
	        $arr = pjBookingModel::factory()->whereIn('id', $record)->findAll()->getData();
	        $csv = new pjCSV();
	        $csv
	        ->setHeader(true)
	        ->setName("Bookings-".time().".csv")
	        ->process($arr)
	        ->download();
	    }
	    exit;
	}
	
	public function pjActionPrint()
	{
	    $this->checkLogin();
	    if (!pjAuth::factory()->hasAccess())
	    {
	        $this->sendForbidden();
	        return;
	    }
	    
	    $this->setLayout('pjActionPrint');
	    $transfer_arr = array();
	    
	    $record = $this->_get->toString('record');
	    if (!empty($record) || $this->_get->check('today') || $this->_get->check('id'))
	    {
	        $pjBookingModel = pjBookingModel::factory()
	        ->reset()
	        ->join('pjMultiLang', "t2.model='pjLocation' AND t2.foreign_id=t1.location_id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
	        ->join('pjMultiLang', "t3.model='pjLocation' AND t3.foreign_id=t1.dropoff_id AND t3.field='title' AND t3.locale='".$this->getLocaleId()."'", 'left outer')
	        ->join('pjMultiLang', "t4.model='pjLine' AND t4.foreign_id=t1.line_id AND t4.field='title' AND t4.locale='".$this->getLocaleId()."'", 'left outer')
	        ->join('pjMultiLang', "t5.model='pjLine' AND t5.foreign_id=t1.return_line_id AND t5.field='title' AND t5.locale='".$this->getLocaleId()."'", 'left outer')
	        ->join('pjClient', "t6.id=t1.client_id", 'left outer')
	        ->join('pjMultiLang', "t7.model='pjCountry' AND t7.foreign_id=t6.country_id AND t7.field='name' AND t7.locale='".$this->getLocaleId()."'", 'left outer')
	        ->join('pjMultiLang', "t8.model='pjLocation' AND t8.foreign_id=t1.location_id AND t8.field='address' AND t8.locale='".$this->getLocaleId()."'", 'left outer')
	        ->join('pjMultiLang', "t9.model='pjLocation' AND t9.foreign_id=t1.dropoff_id AND t9.field='address' AND t9.locale='".$this->getLocaleId()."'", 'left outer')
	        ->join('pjAuthUser', "t10.id=t6.foreign_id", 'left outer')
	        ->select("t1.*, t2.content as from_location, t3.content as to_location, t4.content as line, t5.content as return_line,
							t7.content as country, t8.content as from_address, t9.content as to_address,
							t6.title, t10.name, t10.email, t10.phone, t6.company, t6.address, t6.city, t6.state, t6.zip");
	        
	        if(!$this->_get->check('id'))
	        {
	            if (!empty($record))
	            {
	                $pjBookingModel->whereIn("t1.id", explode(",", $record));
	            }else{
	                $pjBookingModel->where("(DATE_FORMAT(t1.booking_date, '%Y-%m-%d')=DATE_FORMAT(NOW(), '%Y-%m-%d'))")	;
	                $pjBookingModel->where("t1.status <> 'cancelled'");
	            }
	        }else{
	            $pjBookingModel->where("t1.id", $this->_get->toInt('id'));
	        }
	        $transfer_arr = $pjBookingModel
	        ->orderBy("t1.created DESC")
	        ->findAll()
	        ->getData();
	    }
	    $this->set('transfer_arr', $transfer_arr);
	}
	
	public function pjActionUpdate()
	{
	    $this->checkLogin();
	    if (!pjAuth::factory()->hasAccess())
	    {
	        $this->sendForbidden();
	        return;
	    }
	    if (self::isPost() && $this->_post->toInt('booking_update'))
	    {
	        $pjBookingModel = pjBookingModel::factory();
	        
	        $arr = $pjBookingModel->find($this->_post->toInt('id'))->getData();
	        if (empty($arr))
	        {
	            pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminBookings&action=pjActionIndex&err=ABB08");
	        }
	        $data = array();
	        
	        $data['booking_date'] = pjDateTime::formatDate($this->_post->toString('booking_date'), $this->option_arr['o_date_format']);
	        $data['c_flight_time'] = $this->_post->check('c_flight_time') ? date("H:i:s", strtotime($this->_post->toString('c_flight_time'))) : ':NULL';
	        if($this->_post->check('has_return'))
	        {
	            $data['return_date'] = pjDateTime::formatDate($this->_post->toString('return_date'), $this->option_arr['o_date_format']);
	            $data['has_return'] = 'T';
	        }else{
	            $data['has_return'] = 'F';
	            $data['return_date'] = ':NULL';
	            $data['return_time'] = ':NULL';
	            $data['return_line_id'] = ':NULL';
	        }
	        if($this->_post->check('new_client'))
	        {
	            $c_data = array();
	            $c_data['title'] = $this->_post->toString('c_title');
	            $c_data['fname'] = $this->_post->toString('c_fname');
	            $c_data['lname'] = $this->_post->toString('c_lname');
	            $c_data['email'] = $this->_post->toString('c_email');
	            $c_data['password'] = $this->_post->toString('c_password');
	            $c_data['phone'] = $this->_post->toString('c_phone');
	            $c_data['company'] = $this->_post->toString('c_company');
	            $c_data['address'] = $this->_post->toString('c_address');
	            $c_data['city'] = $this->_post->toString('c_city');
	            $c_data['state'] = $this->_post->toString('c_state');
	            $c_data['zip'] = $this->_post->toString('c_zip');
	            $c_data['country_id'] = $this->_post->toInt('c_country');
	            $c_data['status'] = 'T';
	            $c_data['locale_id'] = $this->getLocaleId();
	            $response = pjFrontClient::init($c_data)->createClient();
	            if(isset($response['client_id']) && (int) $response['client_id'] > 0)
	            {
	                $data['client_id'] = $response['client_id'];
	            }
	        }else{
	            $data['client_id'] = $this->_post->toInt('client_id');
	        }
	        
	        $pjBookingModel->reset()->where('id', $this->_post->toInt('id'))->limit(1)->modifyAll(array_merge($this->_post->raw(), $data));
	        
	        $err = 'ABB01';
	        pjUtil::redirect(PJ_INSTALL_URL. "index.php?controller=pjAdminBookings&action=pjActionIndex&err=$err");
	    }
	    if (self::isGet() && $this->_get->toInt('id') > 0)
	    {
	        $arr = pjBookingModel::factory()
	        ->find($this->_get->toInt('id'))
	        ->getData();
	        
	        if(count($arr) <= 0)
	        {
	            pjUtil::redirect(PJ_INSTALL_URL. "index.php?controller=pjAdminBookings&action=pjActionIndex&err=ABB08");
	        }
	        
	        $this->set('arr', $arr);
	        
	        $country_arr = pjBaseCountryModel::factory()
	        ->select('t1.*, t2.content AS `name`')
	        ->join('pjMultiLang', "t2.model='pjBaseCountry' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
	        ->where('t1.status', 'T')
	        ->orderBy('`name` ASC')
	        ->findAll()->getData();
	        $this->set('country_arr', $country_arr);
	        
	        $client_arr = pjClientModel::factory()
	        ->select("t1.*, t2.email as c_email, t2.name as c_name, t2.phone as c_phone")
	        ->join("pjAuthUser", "t2.id=t1.foreign_id", 'left outer')
	        ->where('t2.status', 'T')
	        ->orderBy('t2.name ASC')
	        ->findAll()
	        ->getData();
	        $this->set('client_arr', $client_arr);
	        
	        $pjLocationModel = pjLocationModel::factory();
	        $da_arr = $pjLocationModel
	        ->join('pjMultiLang', "t2.model='pjLocation' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
	        ->select("t1.*, t2.content as title")
	        ->where('t1.type', 'DA')
	        ->where('t1.status', 'T')
	        ->orderBy("title ASC")
	        ->findAll()->getData();
	        $this->set('da_arr', $da_arr);
	        
	        $location_id = $arr['location_id'];
	        
	        $pd_arr = array();
	        $location_id_arr = pjLineDetailModel::factory()
	        ->select("DISTINCT t1.location_id")
	        ->where("(t1.line_id IN(SELECT `TL`.id FROM `".pjLineModel::factory()->getTable()."` AS `TL` WHERE `TL`.location_id='".$location_id."'))")
	        ->findAll()
	        ->getDataPair(null, 'location_id');
	        if(!empty($location_id_arr))
	        {
	            $pd_arr = pjLocationModel::factory()
	            ->join('pjMultiLang', "t2.model='pjLocation' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
	            ->select("t1.*, t2.content as title")
	            ->whereIn('t1.id', $location_id_arr)
	            ->where('t1.type', 'PD')
	            ->where('t1.status', 'T')
	            ->orderBy("title ASC")
	            ->findAll()->getData();
	            $this->set('pd_arr', $pd_arr);
	        }
	        
	        $dropoff_id = $arr['dropoff_id'];
	        
	        $line_arr = pjLineModel::factory()
	        ->select("t1.*, t2.content as title")
	        ->join('pjMultiLang', "t2.model='pjLine' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
	        ->where("t1.location_id", $location_id)
	        ->where("(t1.id IN(SELECT `TLD`.line_id FROM `".pjLineDetailModel::factory()->getTable()."` AS `TLD` WHERE `TLD`.`location_id`='".$dropoff_id."'))")
	        ->findAll()
	        ->getData();
	        $this->set('line_arr', $line_arr);
	        
	        
	        $line_id = $arr['line_id'];
	        $traveling = $arr['traveling'];
	        $booking_date = $arr['booking_date'];
	        $result = $this->pjActionGetLineDetails($line_id, $location_id, $dropoff_id, $traveling, $booking_date);
	        
	        $this->set('line_detail_arr', $result['line_detail_arr']);
	        $this->set('timetable_arr', $result['timetable_arr']);
	        
	        $pjBookingModel = pjBookingModel::factory();
	        $pjBookingModel->where("t1.id <>", $this->_get->toInt('id'));
	        $booked_arr = $pjBookingModel
	        ->where("t1.location_id", $location_id)
	        ->where("t1.dropoff_id", $dropoff_id)
	        ->where("t1.status <>", 'cancelled')
	        ->where("( (t1.line_id='".$line_id."' AND t1.booking_date='".$booking_date."') OR (t1.return_line_id='".$line_id."' AND t1.return_date='".$booking_date."') )")
	        ->findAll()
	        ->getData();
	        
	        $booked_time_arr = array();
	        $return_booked_time_arr = array();
	        foreach($booked_arr as $k => $v)
	        {
	            $booked_time_arr[date("H:i", strtotime($v['booking_time']))] += (int) $v['passengers'];
	            if(!empty($v['return_time']))
	            {
	                $booked_time_arr[date("H:i", strtotime($v['return_time']))] += (int) $v['passengers'];
	            }
	        }
	        $this->set('booked_time_arr', $booked_time_arr);
	        
	        if($arr['has_return'] == 'T')
	        {
	            $booking_date = $arr['return_date'];
	            $traveling = $arr['traveling'] == 'from' ? 'to' : 'from';
	            $result = $this->pjActionGetLineDetails($arr['return_line_id'], $location_id, $dropoff_id, $traveling, $booking_date);
	            
	            $this->set('return_line_detail_arr', $result['line_detail_arr']);
	            $this->set('return_timetable_arr', $result['timetable_arr']);
	            
	            $pjBookingModel->reset();
	            $pjBookingModel->where("t1.id <>", $this->_get->toInt('id'));
	            $return_booked_arr = $pjBookingModel
	            ->where("t1.location_id", $location_id)
	            ->where("t1.dropoff_id", $dropoff_id)
	            ->where("t1.status <>", 'cancelled')
	            ->where("( (t1.line_id='".$arr['return_line_id']."' AND t1.booking_date='".$booking_date."') OR (t1.return_line_id='".$arr['return_line_id']."' AND t1.return_date='".$booking_date."') )")
	            ->findAll()
	            ->getData();
	            foreach($return_booked_arr as $k => $v)
	            {
	                $return_booked_time_arr[date("H:i", strtotime($v['booking_time']))] += (int) $v['passengers'];
	                if(!empty($v['return_time']))
	                {
	                    $return_booked_time_arr[date("H:i", strtotime($v['return_time']))] += (int) $v['passengers'];
	                }
	            }
	        }
	        $this->set('return_booked_time_arr', $return_booked_time_arr);
	        
	        $this->set('date_format', pjUtil::toBootstrapDate($this->option_arr['o_date_format']));
	        if(pjObject::getPlugin('pjPayments') !== NULL)
	        {
	            $this->set('payment_option_arr', pjPaymentOptionModel::factory()->getOptions($this->getForeignId()));
	            $this->set('payment_titles', pjPayments::getPaymentTitles($this->getForeignId(), $this->getLocaleId()));
	        }else{
	            $this->set('payment_titles', __('payment_methods', true));
	        }
	        
	        $this->appendJs('tinymce.min.js', PJ_THIRD_PARTY_PATH . 'tinymce/');
	        $this->appendCss('css/select2.min.css', PJ_THIRD_PARTY_PATH . 'select2/');
	        $this->appendJs('js/select2.full.min.js', PJ_THIRD_PARTY_PATH . 'select2/');
	        $this->appendCss('clockpicker.css', PJ_THIRD_PARTY_PATH . 'clockpicker/');
	        $this->appendJs('clockpicker.js', PJ_THIRD_PARTY_PATH . 'clockpicker/');
	        $this->appendCss('datepicker.css', PJ_THIRD_PARTY_PATH . 'bootstrap_datepicker/');
	        $this->appendJs('bootstrap-datepicker.js', PJ_THIRD_PARTY_PATH . 'bootstrap_datepicker/');
	        $this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
	        $this->appendJs('pjAdminBookings.js');
	    }
	}
	
	public function pjActionConfirmation()
	{
	    $this->setAjax(true);
	    
	    if ($this->isXHR())
	    {
	        if ($this->_post->check('send_email') && $this->_post->toString('to') &&  $this->_post->toInt('id') && $this->_post->toString('subject') && $this->_post->toString('message'))
	        {
	            $pjEmail = self::getMailer($this->option_arr);
	            
	            $subject = $this->_post->toString('subject');
	            $message = $this->_post->toString('message');
	            
	            $r = $pjEmail
	            ->setTo($this->_post->toString('to'))
	            ->setSubject($subject)
	            ->send($message);
	            
	            if ($r)
	            {
	                self::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Email has been sent.'));
	            }
	            self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Email failed to send.'));
	        }
	        
	        if (self::isGet() && $this->_get->toInt('id') > 0)
	        {
	            $booking_arr = pjBookingModel::factory()
	            ->join('pjMultiLang', "t2.model='pjLocation' AND t2.foreign_id=t1.location_id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
	            ->join('pjMultiLang', "t3.model='pjLocation' AND t3.foreign_id=t1.dropoff_id AND t3.field='title' AND t3.locale='".$this->getLocaleId()."'", 'left outer')
	            ->join('pjMultiLang', "t4.model='pjLine' AND t4.foreign_id=t1.line_id AND t4.field='title' AND t4.locale='".$this->getLocaleId()."'", 'left outer')
	            ->join('pjMultiLang', "t5.model='pjLine' AND t5.foreign_id=t1.return_line_id AND t5.field='title' AND t5.locale='".$this->getLocaleId()."'", 'left outer')
	            ->join('pjClient', "t6.id=t1.client_id", 'left outer')
	            ->join('pjMultiLang', "t7.model='pjCountry' AND t7.foreign_id=t6.country_id AND t7.field='name' AND t7.locale='".$this->getLocaleId()."'", 'left outer')
	            ->join('pjMultiLang', "t8.model='pjLocation' AND t8.foreign_id=t1.location_id AND t8.field='address' AND t8.locale='".$this->getLocaleId()."'", 'left outer')
	            ->join('pjMultiLang', "t9.model='pjLocation' AND t9.foreign_id=t1.dropoff_id AND t9.field='address' AND t9.locale='".$this->getLocaleId()."'", 'left outer')
	            ->select("t1.*, t2.content as from_location, t3.content as to_location, t4.content as line, t5.content as return_line,
								t7.content as country, t8.content as from_address, t9.content as to_address,
								t6.company, t6.address, t6.city, t6.state, t6.zip")
				->find($this->_get->toInt('id'))
				->getData();
	            
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
				
				$pjMultiLangModel = pjMultiLangModel::factory();
				$pjNotificationModel = pjNotificationModel::factory();
				
				$locale_id = isset($booking_arr['locale_id']) && (int) $booking_arr['locale_id'] > 0 ? (int) $booking_arr['locale_id'] : $this->getLocaleId();
				
				$tokens = self::getTokens($this->option_arr, $booking_arr, PJ_SALT, $locale_id);
				
				$notification = $pjNotificationModel->reset()->where('recipient', 'client')->where('transport', 'email')->where('variant', "confirmation")->findAll()->getDataIndex(0);
				
				if((int) $notification['id'] > 0 && $notification['is_active'] == 1 && !empty($client_email))
				{
				    $resp = pjAppController::pjActionGetSubjectMessage($notification, $locale_id, $this->getForeignId());
				    $lang_message = $resp['lang_message'];
				    $lang_subject = $resp['lang_subject'];
				    if (count($lang_message) === 1 && count($lang_subject) === 1 && !empty($lang_subject[0]['content']))
				    {
				        $subject = str_replace($tokens['search'], $tokens['replace'], $lang_subject[0]['content']);
				        $message = str_replace($tokens['search'], $tokens['replace'], $lang_message[0]['content']);
				        
				        $this->set('arr', array(
				            'id' => $this->_get->toInt('id'),
				            'client_email' => $client_email,
				            'message' => $message,
				            'subject' => $subject
				        ));
				    }
				}
	            $this->setLocalesData();
	        } else {
	            exit;
	        }
	    }
	}
	
	public function pjActionSendSms()
	{
	    $this->setAjax(true);
	    
	    if ($this->isXHR())
	    {
	        if (self::isPost() && $this->_post->check('send_sms') && $this->_post->toInt('id') > 0 && $this->_post->toString('to') && $this->_post->toString('message'))
	        {
	            $params = array(
	                'text' => stripslashes($this->_post->toString('message')),
	                'type' => 'unicode',
	                'key' => md5($this->option_arr['private_key'] . PJ_SALT)
	            );
	            $params['number'] = $this->_post->toString('to');
	            pjBaseSms::init($params)->pjActionSend();
	            
	            self::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'SMS has been sent.'));
	        }
	        if (self::isGet() && $this->_get->toInt('id') > 0)
	        {
	            $booking_arr = pjBookingModel::factory()
	            ->join('pjMultiLang', "t2.model='pjLocation' AND t2.foreign_id=t1.location_id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
	            ->join('pjMultiLang', "t3.model='pjLocation' AND t3.foreign_id=t1.dropoff_id AND t3.field='title' AND t3.locale='".$this->getLocaleId()."'", 'left outer')
	            ->join('pjMultiLang', "t4.model='pjLine' AND t4.foreign_id=t1.line_id AND t4.field='title' AND t4.locale='".$this->getLocaleId()."'", 'left outer')
	            ->join('pjMultiLang', "t5.model='pjLine' AND t5.foreign_id=t1.return_line_id AND t5.field='title' AND t5.locale='".$this->getLocaleId()."'", 'left outer')
	            ->join('pjClient', "t6.id=t1.client_id", 'left outer')
	            ->join('pjMultiLang', "t7.model='pjCountry' AND t7.foreign_id=t6.country_id AND t7.field='name' AND t7.locale='".$this->getLocaleId()."'", 'left outer')
	            ->join('pjMultiLang', "t8.model='pjLocation' AND t8.foreign_id=t1.location_id AND t8.field='address' AND t8.locale='".$this->getLocaleId()."'", 'left outer')
	            ->join('pjMultiLang', "t9.model='pjLocation' AND t9.foreign_id=t1.dropoff_id AND t9.field='address' AND t9.locale='".$this->getLocaleId()."'", 'left outer')
	            ->select("t1.*, t2.content as from_location, t3.content as to_location, t4.content as line, t5.content as return_line,
								t7.content as country, t8.content as from_address, t9.content as to_address,
								t6.company, t6.address, t6.city, t6.state, t6.zip")
				->find($this->_get->toInt('id'))
				->getData();
				
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
				
				$pjMultiLangModel = pjMultiLangModel::factory();
				$pjNotificationModel = pjNotificationModel::factory();
				
				$locale_id = isset($booking_arr['locale_id']) && (int) $booking_arr['locale_id'] > 0 ? (int) $booking_arr['locale_id'] : $this->getLocaleId();
				
				$tokens = self::getTokens($this->option_arr, $booking_arr, PJ_SALT, $locale_id);
				
				$notification = $pjNotificationModel->reset()->where('recipient', 'client')->where('transport', 'sms')->where('variant', "confirmation")->findAll()->getDataIndex(0);
				
				if((int) $notification['id'] > 0 && $notification['is_active'] == 1 && !empty($client_email))
				{
				    $resp = pjAppController::pjActionGetSmsMessage($notification, $locale_id, $this->getForeignId());
				    $lang_message = $resp['lang_message'];
				    if (count($lang_message) === 1 && !empty($lang_message[0]['content']))
				    {
				        $message = str_replace($tokens['search'], $tokens['replace'], $lang_message[0]['content']);
				        
				        $this->set('arr', array(
				            'id' => $this->_get->toInt('id'),
				            'client_phone' => $client_phone,
				            'message' => $message
				        ));
				    }
				}
				$this->setLocalesData();
	        } else {
	            exit;
	        }
	    }
	}
}
?>