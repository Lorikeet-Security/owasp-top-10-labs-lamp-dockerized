<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjAdminTimetable extends pjAdmin
{
	public function pjActionCreate()
	{
	    $this->checkLogin();
	    if (!pjAuth::factory()->hasAccess())
	    {
	        $this->sendForbidden();
	        return;
	    }
	    if (self::isPost() && $this->_post->toInt('timetable_create'))
	    {
	        $data = array();
	        $data['status'] = $this->_post->check('status') ? 'T' : 'F';
	        $every = $this->_post->toArray('every');
	        $time_arr = $this->_post->toArray('time');
	        if(count($every) > 0)
	        {
	            $data['every'] = implode("|", $every);
	        }
	        if(count($time_arr) > 0)
	        {
	            $temp_arr = array();
	            foreach($time_arr as $time)
	            {
	                $temp_arr[] = date('H:i', strtotime($time));
	            }
	            sort($temp_arr);
	            $data['time'] = implode("|", $temp_arr);
	        }
	        $id = pjTimetableModel::factory()->setAttributes(array_merge($this->_post->raw(), $data))->insert()->getInsertId();
	        if ($id !== false && (int) $id > 0)
	        {
	            $err = 'ATB03';
	        }else{
	            $err = 'ATB04';
	        }
	        pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminTimetable&action=pjActionIndex&err=$err");
	    }
	    if (self::isGet())
	    {
	        $this->setLocalesData();
	        
	        $pjLocationModel = pjLocationModel::factory();
	        $da_arr = $pjLocationModel
	        ->join('pjMultiLang', "t2.model='pjLocation' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
	        ->select("t1.*, t2.content as title")
	        ->where('t1.type', 'DA')
	        ->where('t1.status', 'T')
	        ->orderBy("title ASC")
	        ->findAll()->getData();
	        $this->set('da_arr', $da_arr);
	        
	        $this->appendCss('awesome-bootstrap-checkbox.css', PJ_THIRD_PARTY_PATH . 'awesome_bootstrap_checkbox/');
	        $this->appendCss('clockpicker.css', PJ_THIRD_PARTY_PATH . 'clockpicker/');
	        $this->appendJs('clockpicker.js', PJ_THIRD_PARTY_PATH . 'clockpicker/');
	        $this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
	        $this->appendJs('additional-methods.js', PJ_THIRD_PARTY_PATH . 'validate/');
	        $this->appendJs('jquery.multilang.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
	        $this->appendJs('pjAdminTimetable.js');
	    }
	}
	public function pjActionGetTimetable()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			$pjTimetableModel = pjTimetableModel::factory();
				
			$pjTimetableModel
			->join('pjMultiLang', "t2.model='pjLocation' AND t2.foreign_id=t1.location_id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
			->join('pjMultiLang', "t3.model='pjLine' AND t3.foreign_id=t1.line_id AND t3.field='title' AND t3.locale='".$this->getLocaleId()."'", 'left outer');
				
			if ($q = $this->_get->toString('q'))
			{
			    $pjTimetableModel->where("(t2.content LIKE '%$q%' OR t3.content LIKE '%$q%')");
			}
	
			$column = 'location';
			$direction = 'ASC';
			if ($this->_get->toString('column') && in_array(strtoupper($this->_get->toString('direction')), array('ASC', 'DESC')))
			{
			    $column = $this->_get->toString('column');
			    $direction = strtoupper($this->_get->toString('direction'));
			}
	
			$total = $pjTimetableModel->findCount()->getData();
			$rowCount = $this->_get->toInt('rowCount') ?: 10;
			$pages = ceil($total / $rowCount);
			$page = $this->_get->toInt('page') ?: 1;
			$offset = ((int) $page - 1) * $rowCount;
			if ($page > $pages)
			{
				$page = $pages;
			}
			$data = $pjTimetableModel
				->select('t1.*, t2.content as location, t3.content as line')
				->orderBy("$column $direction")
				->limit($rowCount, $offset)
				->findAll()->getData();
			foreach($data as $k => $v)
			{
				$v['direction'] = ($v['direction'] == 'arriving' ? __('lblArrivingAt', true) : __('lblDepartingFrom', true)) . ' ' . pjSanitize::html($v['location']);
				$data[$k] = $v;
			}
			pjAppController::jsonResponse(compact('data', 'total', 'pages', 'page', 'rowCount', 'column', 'direction'));
		}
		exit;
	}
	public function pjActionGetLines()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			if($this->_get->toInt('location_id') > 0)
			{
				$line_arr = pjLineModel::factory()
				->select("t1.*, t2.content as title")
				->join('pjMultiLang', "t2.model='pjLine' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
				->where('t1.location_id', $this->_get->toInt('location_id'))
				->orderBy('title ASC')
				->findAll()->getData();
				$this->set('line_arr', $line_arr);
			}
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
	    
	    $this->appendJs('jquery.datagrid.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
        $this->appendJs('pjAdminTimetable.js');
	}
	public function pjActionDeleteTimetable()
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
	    if (pjTimetableModel::factory()->setAttributes(array('id' => $this->_get->toInt('id')))->erase()->getAffectedRows() == 1)
	    {
	        self::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Timetable has been deleted'));
	    } else {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 104, 'text' => 'Timetable has not been deleted'));
	    }
		exit;
	}
	
	public function pjActionDeleteTimetableBulk()
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
	    pjTimetableModel::factory()->reset()->whereIn('id', $record)->eraseAll();
	    self::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Timetable(s) has been deleted.'));
		exit;
	}
	public function pjActionSaveTimetable()
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
	    
	    $arr = pjTimetableModel::factory()->find($this->_get->toInt('id'))->getData();
	    if (!$arr)
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 103, 'text' => 'Timetable is not found.'));
	    }
	    $pjTimetableModel = pjTimetableModel::factory();
	    
	    $pjTimetableModel->where('id', $this->_get->toInt('id'))->limit(1)->modifyAll(array($this->_post->toString('column') => $this->_post->toString('value')));
	    
	    self::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Line has been updated.'));
	    exit;
	}
	public function pjActionUpdate()
	{
	    $this->checkLogin();
	    if (!pjAuth::factory()->hasAccess())
	    {
	        $this->sendForbidden();
	        return;
	    }
	    if (self::isPost() && $this->_post->toInt('timetable_update'))
	    {
	        $data = array();
	        $data['status'] = $this->_post->check('status') ? 'T' : 'F';
	        $every = $this->_post->toArray('every');
	        $time_arr = $this->_post->toArray('time');
	        if(count($every) > 0)
	        {
	            $data['every'] = implode("|", $every);
	        }
	        if(count($time_arr) > 0)
	        {
	            $temp_arr = array();
	            foreach($time_arr as $time)
	            {
	                $temp_arr[] = date('H:i', strtotime($time));
	            }
	            sort($temp_arr);
	            $data['time'] = implode("|", $temp_arr);
	        }
	        pjTimetableModel::factory()->reset()->where('id', $this->_post->toInt('id'))->limit(1)->modifyAll(array_merge($this->_post->raw(), $data));
	        
	        pjUtil::redirect(PJ_INSTALL_URL . "index.php?controller=pjAdminTimetable&action=pjActionIndex&err=ATB01");
	    }
	    if (self::isGet() && $this->_get->toInt('id') > 0)
	    {
	        $pjMultiLangModel = pjMultiLangModel::factory();
	        
	        $arr = pjTimetableModel::factory()->find($this->_get->toInt('id'))->getData();
	        if (count($arr) === 0)
	        {
	            pjUtil::redirect(PJ_INSTALL_URL. "index.php?controller=pjAdminTimetable&action=pjActionIndex&err=ATB08");
	        }
	        
	        $this->set('arr', $arr);
	        
	        $pjLocationModel = pjLocationModel::factory();
	        $da_arr = $pjLocationModel
	        ->join('pjMultiLang', "t2.model='pjLocation' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
	        ->select("t1.*, t2.content as title")
	        ->where('t1.type', 'DA')
	        ->where('t1.status', 'T')
	        ->orderBy("title ASC")
	        ->findAll()->getData();
	        $this->set('da_arr', $da_arr);
	        
	        $line_arr = pjLineModel::factory()
	        ->select("t1.*, t2.content as title")
	        ->join('pjMultiLang', "t2.model='pjLine' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
	        ->where('t1.location_id', $arr['location_id'])
	        ->orderBy('title ASC')
	        ->findAll()->getData();
	        $this->set('line_arr', $line_arr);
	        
	        $this->appendCss('awesome-bootstrap-checkbox.css', PJ_THIRD_PARTY_PATH . 'awesome_bootstrap_checkbox/');
	        $this->appendCss('clockpicker.css', PJ_THIRD_PARTY_PATH . 'clockpicker/');
	        $this->appendJs('clockpicker.js', PJ_THIRD_PARTY_PATH . 'clockpicker/');
	        $this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
	        $this->appendJs('additional-methods.js', PJ_THIRD_PARTY_PATH . 'validate/');
	        $this->appendJs('jquery.multilang.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
	        $this->appendJs('pjAdminTimetable.js');
	    }
	
	}
	public function pjActionSchedule()
	{
		$this->checkLogin();
	
		if ($this->isAdmin())
		{
			$pjMultiLangModel = pjMultiLangModel::factory();
	
			$arr = pjTimetableModel::factory()
				->select("t1.*, t2.content as title")
				->join('pjMultiLang', "t2.model='pjLocation' AND t2.foreign_id=t1.location_id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
				->find($_GET['id'])->getData();
			if (count($arr) === 0)
			{
				pjUtil::redirect(PJ_INSTALL_URL. "index.php?controller=pjAdminTimetable&action=pjActionIndex&err=ATB08");
			}

			$this->set('arr', $arr);

			
			$this->appendJs('pjAdminTimetable.js');
		} else {
			$this->set('status', 2);
		}
	}
	public function pjActionGetSchedule()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			if (isset($_GET['line_id']) && (int) $_GET['line_id'] > 0)
			{
				$line_detail_arr = pjLineDetailModel::factory()
					->join('pjMultiLang', "t2.model='pjLocation' AND t2.foreign_id=t1.location_id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
					->select("t1.*, t2.content as title")
					->where('t1.line_id', $_GET['line_id'])
					->orderBy("title ASC")
					->findAll()->getData();
				$this->set('line_detail_arr', $line_detail_arr);
			}
		}
	}
}
?>