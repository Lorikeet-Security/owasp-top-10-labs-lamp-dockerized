<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjFrontPublic extends pjFront
{
	public function __construct()
	{
		parent::__construct();
		
		$this->setAjax(true);
		
		$this->setLayout('pjActionEmpty');
	}
	public function pjActionSearch()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() || $this->_get->check('_escaped_fragment_'))
		{
		    if($this->_post->check('sbs_search'))
			{
			    if($this->_post->check('has_return'))
				{
				    $booking_date = pjDateTime::formatDate($this->_post->toString('booking_date'), $this->option_arr['o_date_format']);
				    $return_date = pjUtil::formatDate($this->_post->toString('return_date'), $this->option_arr['o_date_format']);
					if($booking_date > $return_date)
					{
						self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => __('front_invalid_date_msg', true)));
					}
				}
				if($this->_is('search'))
				{
					$this->_unset('search');
				}
				$this->_set("search", $this->_post->raw());
				pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200));
			}else{
				$pjLocationModel = pjLocationModel::factory();
				$da_arr = $pjLocationModel
					->select("t1.*, t2.content as title, t3.content as address")
					->join('pjMultiLang', "t2.model='pjLocation' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
					->join('pjMultiLang', "t3.model='pjLocation' AND t3.foreign_id=t1.id AND t3.field='address' AND t3.locale='".$this->getLocaleId()."'", 'left outer')
					->where('t1.type', 'DA')
					->where("(t1.id IN(SELECT `TL`.`location_id` FROM `".pjLineModel::factory()->getTable()."` AS `TL`))")
					->where('t1.status', 'T')
					->orderBy("title ASC")
					->findAll()->getData();
				
				$location_id = NULL;
				if(!empty($da_arr))
				{
					$location_id = $da_arr[0]['id'];
				}
				if(isset($_SESSION[$this->defaultStore]['search']) && isset($_SESSION[$this->defaultStore]['search']['location_id']) && (int) $_SESSION[$this->defaultStore]['search']['location_id'] > 0)
				{
					$location_id = (int) $_SESSION[$this->defaultStore]['search']['location_id'];
				}
				if($location_id != NULL)
				{
					$location_id_arr = pjLineDetailModel::factory()
						->select("DISTINCT t1.location_id")
						->where("(t1.line_id IN(SELECT `TL`.id FROM `".pjLineModel::factory()->getTable()."` AS `TL` WHERE `TL`.location_id='".$location_id."'))")
						->findAll()
						->getDataPair(null, 'location_id');
					if(!empty($location_id_arr))
					{
						$pd_arr = pjLocationModel::factory()
							->join('pjMultiLang', "t2.model='pjLocation' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
							->join('pjMultiLang', "t3.model='pjLocation' AND t3.foreign_id=t1.id AND t3.field='address' AND t3.locale='".$this->getLocaleId()."'", 'left outer')
							->select("t1.*, t2.content as title, t3.content as address")
							->whereIn('t1.id', $location_id_arr)
							->where('t1.type', 'PD')
							->where('t1.status', 'T')
							->orderBy("title ASC")
							->findAll()->getData();
						$this->set('pd_arr', $pd_arr);
					}
				}
				
				$this->set('da_arr', $da_arr);
			}
		}
	}
	public function pjActionLines()
	{
		if($this->isXHR())
		{
			if (isset($_SESSION[$this->defaultStore]) &&
					count($_SESSION[$this->defaultStore]) > 0 &&
					isset($_SESSION[$this->defaultStore]['search']))
			{
				$SEARCH = $this->_get('search');
				
				$location_id = $SEARCH['location_id'];
				$dropoff_id = $SEARCH['dropoff_id'];
				$traveling = $SEARCH['traveling'];
				$passengers = $SEARCH['passengers'];
				
				$line_arr = pjLineModel::factory()
					->select("t1.*, t2.content as title, t3.content as description")
					->join('pjMultiLang', "t2.model='pjLine' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
					->join('pjMultiLang', "t3.model='pjLine' AND t3.foreign_id=t1.id AND t3.field='description' AND t3.locale='".$this->getLocaleId()."'", 'left outer')
					->where("t1.location_id", $location_id)
					->where("t1.seats >=", $passengers)
					->where("(t1.id IN(SELECT `TLD`.line_id FROM `".pjLineDetailModel::factory()->getTable()."` AS `TLD` WHERE `TLD`.`location_id`='".$dropoff_id."'))")
					->findAll()
					->getData();
				
				$pjBookingModel = pjBookingModel::factory();
				if(isset($SEARCH['has_return']) && !empty($SEARCH['return_date']))
				{
					$return_book_time_arr = array();
					$temp_return_line_id_arr = array();
					$return_line_arr = $line_arr;
					$booking_date = pjDateTime::formatDate($SEARCH['return_date'], $this->option_arr['o_date_format']);
					foreach($return_line_arr as $k => $v)
					{
						$line_id = $v['id'];
						$result = $this->pjActionGetLineDetails($line_id, $location_id, $dropoff_id, $traveling == 'from' ? 'to' : 'from', $booking_date);
						$v['line_detail_arr'] = $result['line_detail_arr'];
						$v['timetable_arr'] = $result['timetable_arr'];
						$v['price_arr'] = $this->calcPrices($line_id, $dropoff_id, $traveling == 'from' ? 'to' : 'from', $passengers, $this->option_arr);
						if(!empty($v['timetable_arr']))
						{
							$return_line_arr[$k] = $v;
						}else{
							unset($return_line_arr[$k]);
						}
						$temp_return_line_id_arr[] = $line_id;
					}
					if(!empty($temp_return_line_id_arr))
					{
						$return_booked_arr = $pjBookingModel
							->where("t1.location_id", $location_id)
							->where("t1.dropoff_id", $dropoff_id)
							->where("t1.status <>", 'cancelled')
							->where("( (t1.line_id IN(".join(',', $temp_return_line_id_arr).") AND t1.booking_date='".$booking_date."') OR (t1.return_line_id IN(".join(',', $temp_return_line_id_arr).") AND t1.return_date='".$booking_date."'))")
							->findAll()
							->getData();
						foreach($return_booked_arr as $k => $v)
						{
							$return_book_time_arr[$v['line_id']][date("H:i", strtotime($v['booking_time']))] += $v['passengers'];
							if(!empty($v['return_time']))
							{
								$return_book_time_arr[$v['return_line_id']][date("H:i", strtotime($v['return_time']))] += $v['passengers'];
							}
						}
					}
					$this->set('return_line_arr', $return_line_arr);
					$this->set('return_book_time_arr', $return_book_time_arr);
				}
				
				$book_time_arr = array();
				$temp_line_id_arr = array();
				$booking_date = pjDateTime::formatDate($SEARCH['booking_date'], $this->option_arr['o_date_format']);
				foreach($line_arr as $k => $v)
				{
					$line_id = $v['id'];
					$result = $this->pjActionGetLineDetails($line_id, $location_id, $dropoff_id, $traveling, $booking_date);
					$v['price_arr'] = $this->calcPrices($line_id, $dropoff_id, $traveling, $passengers, $this->option_arr);
					$v['line_detail_arr'] = $result['line_detail_arr'];
					$v['timetable_arr'] = $result['timetable_arr'];
					if(!empty($v['timetable_arr']))
					{
						$line_arr[$k] = $v;
					}else{
						unset($line_arr[$k]);
					}
					$temp_line_id_arr[] = $line_id;
				}
				if(!empty($temp_line_id_arr))
				{
					$booked_arr = $pjBookingModel
						->reset()
						->where("t1.location_id", $location_id)
						->where("t1.dropoff_id", $dropoff_id)
						->where("t1.status <>", 'cancelled')
						->where("( (t1.line_id IN(".join(',', $temp_line_id_arr).") AND t1.booking_date='".$booking_date."') OR (t1.return_line_id IN(".join(',', $temp_line_id_arr).") AND t1.return_date='".$booking_date."'))")
						->findAll()
						->getData();
					
					foreach($booked_arr as $k => $v)
					{
						$book_time_arr[$v['line_id']][date("H:i", strtotime($v['booking_time']))] += $v['passengers'];
						if(!empty($v['return_time']))
						{
							$book_time_arr[$v['return_line_id']][date("H:i", strtotime($v['return_time']))] += $v['passengers'];
						}
					}
				} 
				
				$pjLocationModel = pjLocationModel::factory();
				$from_location = $pjLocationModel
					->join('pjMultiLang', "t2.model='pjLocation' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
					->select("t1.*, t2.content as title")
					->find($location_id)
					->getData();
				$to_location = $pjLocationModel
					->reset()
					->join('pjMultiLang', "t2.model='pjLocation' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
					->select("t1.*, t2.content as title")
					->find($dropoff_id)
					->getData();
				
				$this->set('line_arr', $line_arr);
				$this->set('book_time_arr', $book_time_arr);
				$this->set('from_location', $from_location);
				$this->set('to_location', $to_location);
			}else{
				self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => ''));
			}				
		}
	}
	
	public function pjActionCheckout()
	{
		if($this->isXHR())
		{
			if (isset($_SESSION[$this->defaultStore]) &&
					count($_SESSION[$this->defaultStore]) > 0 &&
					isset($_SESSION[$this->defaultStore]['search']) && isset($_SESSION[$this->defaultStore]['search']['location_id']) && 
					isset($_SESSION[$this->defaultStore]['line_id']))
			{
				if($this->_post->check('sbs_checkout'))
				{
				    if ((int) $this->option_arr['o_bf_include_captcha'] === 3 && $this->option_arr['o_captcha_type_front'] == 'system' && (!$this->_post->check('captcha') || ($this->_post->check('captcha') && $this->_post->isEmpty('captcha')) ||
				        !pjCaptcha::validate($this->_post->toString('captcha'), $_SESSION[$this->defaultCaptcha]) ))
					{
						pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 110));
					}
					
					$_SESSION[$this->defaultForm] = $this->_post->raw();
						
					pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200));
				}else{
					$this->pjActionLineDetails();
					
					$country_arr = pjBaseCountryModel::factory()
					->select('t1.*, t2.content AS country_title')
					->join('pjMultiLang', "t2.model='pjBaseCountry' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
					->where('t1.status', 'T')
					->orderBy('`country_title` ASC')
					->findAll()
					->getData();
						
					$this->set('country_arr', $country_arr);
					
					$bank_account = pjMultiLangModel::factory()
					->select('t1.content')
					->where('t1.model','pjOption')
					->where('t1.locale', $this->getLocaleId())
					->where('t1.field', 'o_bank_account')
					->limit(1)
					->findAll()->getDataIndex(0);
					$this->set('bank_account', $bank_account['content']);
					
					if(pjObject::getPlugin('pjPayments') !== NULL)
					{
					    $this->set('payment_option_arr', pjPaymentOptionModel::factory()->getOptions($this->getForeignId()));
					    $this->set('payment_titles', pjPayments::getPaymentTitles($this->getForeignId(), $this->getLocaleId()));
					}else{
					    $this->set('payment_titles', __('payment_methods', true));
					}
				}
			}else{
				pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => ''));
			}
		}
	}
	public function pjActionGetDropoffs()
	{
		if($this->isXHR())
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
						->join('pjMultiLang', "t3.model='pjLocation' AND t3.foreign_id=t1.id AND t3.field='address' AND t3.locale='".$this->getLocaleId()."'", 'left outer')
						->select("t1.*, t2.content as title, t3.content as address")
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
	
	
	public function pjActionPreview()
	{
		if($this->isXHR())
		{
			if (isset($_SESSION[$this->defaultStore]) &&
					count($_SESSION[$this->defaultStore]) > 0 &&
					isset($_SESSION[$this->defaultStore]['search']) && isset($_SESSION[$this->defaultStore]['search']['location_id']) && 
					isset($_SESSION[$this->defaultStore]['line_id']) && isset($_SESSION[$this->defaultForm]))
			{
				$this->pjActionLineDetails();
				
				$country_arr = pjBaseCountryModel::factory()
				->select('t1.*, t2.content AS country_title')
				->join('pjMultiLang', "t2.model='pjBaseCountry' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
				->find($_SESSION[$this->defaultForm]['c_country'])
				->getData();
				
				$this->set('country_arr', $country_arr);
				
				$bank_account = pjMultiLangModel::factory()
				->select('t1.content')
				->where('t1.model','pjOption')
				->where('t1.locale', $this->getLocaleId())
				->where('t1.field', 'o_bank_account')
				->limit(1)
				->findAll()->getDataIndex(0);
				$this->set('bank_account', $bank_account['content']);
				
				if(pjObject::getPlugin('pjPayments') !== NULL)
				{
				    $this->set('payment_option_arr', pjPaymentOptionModel::factory()->getOptions($this->getForeignId()));
				    $this->set('payment_titles', pjPayments::getPaymentTitles($this->getForeignId(), $this->getLocaleId()));
				}else{
				    $this->set('payment_titles', __('payment_methods', true));
				}
			}else{
				pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => ''));
			}
		}
	}
	
	public function pjActionGetPaymentForm()
	{
		if ($this->isXHR())
		{
			$arr = pjBookingModel::factory()->find($this->_get->toInt('booking_id'))->getData();
	
			if(pjObject::getPlugin('pjPayments') !== NULL)
			{
			    $pjPlugin = pjPayments::getPluginName($arr['payment_method']);
			    if(pjObject::getPlugin($pjPlugin) !== NULL)
			    {
			        $client = pjClientModel::factory()
			        ->select("t1.*, t2.email as c_email, t2.name as c_name, t2.phone as c_phone")
			        ->join('pjAuthUser', "t1.foreign_id=t2.id", 'left outer')
			        ->find($arr['client_id'])->getData();
			        
			        $this->set('params', $pjPlugin::getFormParams(array('payment_method' => $arr['payment_method']), array(
			            'locale_id'	 => $this->getLocaleId(),
			            'return_url'	=> $this->option_arr['o_thankyou_page'],
			            'id'			=> $arr['id'],
			            'foreign_id'	=> $this->getForeignId(),
			            'uuid'		  => $arr['uuid'],
			            'name'		  => @$client['c_name'],
			            'email'		 => @$client['c_email'],
			            'phone'		 => @$client['c_phone'],
			            'amount'		=> $arr['deposit'],
			            'cancel_hash'   => sha1($arr['uuid'].strtotime($arr['created']).PJ_SALT),
			            'currency_code' => $this->option_arr['o_currency'],
			        )));
			    }
			    
			    if ($arr['payment_method'] == 'bank')
			    {
			        $bank_account = pjMultiLangModel::factory()
			        ->select('t1.content')
			        ->where('t1.model','pjOption')
			        ->where('t1.locale', $this->getLocaleId())
			        ->where('t1.field', 'o_bank_account')
			        ->limit(1)
			        ->findAll()->getDataIndex(0);
			        $this->set('bank_account', $bank_account['content']);
			    }
			}
			
			$this->set('arr', $arr);
			$this->set('get', $this->_get->raw());
		}
	}
	
	private function pjActionLineDetails()
	{
		$SEARCH = $this->_get('search');
		$STORE = $_SESSION[$this->defaultStore];
		$location_id = $SEARCH['location_id'];
		$dropoff_id = $SEARCH['dropoff_id'];
		$traveling = $SEARCH['traveling'];
		$passengers = $SEARCH['passengers'];
		$line_id = $STORE['line_id'];
			
		$pjLocationModel = pjLocationModel::factory();
		$from_location = $pjLocationModel
		->join('pjMultiLang', "t2.model='pjLocation' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
		->select("t1.*, t2.content as title")
		->find($location_id)
		->getData();
		$to_location = $pjLocationModel
		->reset()
		->join('pjMultiLang', "t2.model='pjLocation' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
		->select("t1.*, t2.content as title")
		->find($dropoff_id)
		->getData();
			
		$pjLineModel = pjLineModel::factory();
		$line_arr = $pjLineModel
		->join('pjMultiLang', "t2.model='pjLine' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
		->select("t1.*, t2.content as title")
		->find($line_id)
		->getData();
		$this->set('line_arr', $line_arr);
		
		$price_arr = $this->calcPrices($line_id, $dropoff_id, $traveling, $passengers, $this->option_arr);
		$this->set('price_arr', $price_arr);
			
		$pjLineDetailModel = pjLineDetailModel::factory();
		$line_detail_arr = $pjLineDetailModel->where('t1.line_id', $line_id)->where('t1.location_id', $dropoff_id)->findAll()->getDataIndex(0);
		if(isset($SEARCH['has_return']))
		{
			$return_line_id = $STORE['return_line_id'];
			$return_line_detail_arr = $pjLineDetailModel->reset()->where('t1.line_id', $return_line_id)->where('t1.location_id', $dropoff_id)->findAll()->getDataIndex(0);
			$this->set('return_line_detail_arr', $return_line_detail_arr);
		
			$return_line_arr = $pjLineModel
			->reset()
			->join('pjMultiLang', "t2.model='pjLine' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
			->select("t1.*, t2.content as title")
			->find($STORE['return_line_id'])
			->getData();
			$this->set('return_line_arr', $return_line_arr);
		
			$return_price_arr = $this->calcPrices($STORE['return_line_id'], $dropoff_id, $traveling == 'from' ? 'to' : 'from', $passengers, $this->option_arr);
			$this->set('return_price_arr', $return_price_arr);
		}
			
		$this->set('from_location', $from_location);
		$this->set('to_location', $to_location);
		$this->set('line_detail_arr', $line_detail_arr);
			
	}
}
?>