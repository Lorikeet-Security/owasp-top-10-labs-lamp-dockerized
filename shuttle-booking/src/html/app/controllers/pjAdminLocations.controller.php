<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjAdminLocations extends pjAdmin
{
	public function pjActionCreate()
	{
	    $this->checkLogin();
	    
	    if (!pjAuth::factory()->hasAccess())
	    {
	        $this->sendForbidden();
	        return;
	    }
	    if (self::isPost() && $this->_post->toInt('action_create'))
	    {
	        $id = pjLocationModel::factory($this->_post->raw())->insert()->getInsertId();
	        if ($id !== false && (int) $id > 0)
	        {
	            $i18n_arr = $this->_post->toI18n('i18n');
	            if (!empty($i18n_arr))
	            {
	                pjMultiLangModel::factory()->saveMultiLang($i18n_arr, $id, 'pjLocation');
	            }
	            $err = 'AL03';
	        }else{
	            $err = 'AL04';
	        }
	        pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminLocations&action=pjActionIndex&err=$err");
	    }
	    if (self::isGet())
	    {
	        $this->setLocalesData();
	        
	        $api_key_str = isset($this->option_arr['o_google_maps_api_key']) && !empty($this->option_arr['o_google_maps_api_key']) ? 'key=' . $this->option_arr['o_google_maps_api_key'] . '&' : '';
	        $this->appendJs('', 'https://maps.google.com/maps/api/js?'.$api_key_str.'libraries=places&region=uk&language=en', true);
	        $this->appendJs('jquery.multilang.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
	        $this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
	        $this->appendJs('additional-methods.js', PJ_THIRD_PARTY_PATH . 'validate/');
	        $this->appendJs('pjAdminLocations.js');
	    }
	}
	
	public function pjActionDeleteLocation()
	{
	    $this->setAjax(true);
	    
	    if (!pjAuth::factory()->hasAccess())
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 103, 'text' => 'Access denied.'));
	    }
	    
	    if (!$this->isXHR())
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Missing headers.'));
	    }
	    
	    if (!self::isGet() && !$this->_get->check('id') && $this->_get->toInt('id') < 0)
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'HTTP method not allowed.'));
	    }
	    if (pjLocationModel::factory()->set('id', $this->_get->toInt('id'))->erase()->getAffectedRows() == 1)
	    {
	        pjMultiLangModel::factory()->where('model', 'pjLocation')->where('foreign_id', $this->_get->toInt('id'))->eraseAll();
	        $response = array('status' => 'OK');
	    } else {
	        $response = array('status' => 'ERR');
	    }
	    
	    self::jsonResponse($response);
	}
	
	public function pjActionDeleteLocationBulk()
	{
	    $this->setAjax(true);
	    
	    if (!pjAuth::factory()->hasAccess())
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 103, 'text' => 'Access denied.'));
	    }
	    
	    if (!$this->isXHR())
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Missing headers.'));
	    }
	    
	    if (!self::isPost())
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'HTTP method not allowed.'));
	    }
	    
	    if (!$this->_post->has('record') || !($record = $this->_post->toArray('record')))
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 102, 'text' => 'Missing, empty or invalid data.'));
	    }
	    
	    if (pjLocationModel::factory()->whereIn('id', $record)->eraseAll()->getAffectedRows() > 0)
	    {
	        pjMultiLangModel::factory()->where('model', 'pjLocation')->whereIn('foreign_id', $record)->eraseAll();
	        self::jsonResponse(array('status' => 'OK'));
	    }
	    
	    self::jsonResponse(array('status' => 'ERR'));
	}
	
	public function pjActionGetLocation()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			$pjLocationModel = pjLocationModel::factory()
			->join('pjMultiLang', "t2.model='pjLocation' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
			->join('pjMultiLang', "t3.model='pjLocation' AND t3.foreign_id=t1.id AND t3.field='address' AND t3.locale='".$this->getLocaleId()."'", 'left outer');
			
			if ($q = $this->_get->toString('q'))
			{
			    $pjLocationModel->where("(t2.content LIKE '%$q%' OR t3.content LIKE '%$q%')");
			}
	
			$column = 'title';
			$direction = 'ASC';
			if ($this->_get->toString('column') && in_array(strtoupper($this->_get->toString('direction')), array('ASC', 'DESC')))
			{
			    $column = $this->_get->toString('column');
			    $direction = strtoupper($this->_get->toString('direction'));
			}

			$total = $pjLocationModel->findCount()->getData();
			$rowCount = $this->_get->toInt('rowCount') ?: 10;
			$pages = ceil($total / $rowCount);
			$page = $this->_get->toInt('page') ?: 1;
			$offset = ((int) $page - 1) * $rowCount;
			if ($page > $pages)
			{
			    $page = $pages;
			}
			$data = $pjLocationModel
			->select(" t1.id, t1.status, t2.content as title, t3.content as `address`")
			->orderBy("$column $direction")->limit($rowCount, $offset)->findAll()->getData();
				
			self::jsonResponse(compact('data', 'total', 'pages', 'page', 'rowCount', 'column', 'direction'));
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
		
	    $this->appendJs('jquery.datagrid.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
	    $this->appendJs('pjAdminLocations.js');
	}
	
	public function pjActionSaveLocation()
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
	    
	    if (!pjAuth::factory($this->_get->toString('controller'), 'pjActionUpdate')->hasAccess())
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 102, 'text' => 'Access denied.'));
	    }
	    
	    $arr = pjLocationModel::factory()->find($this->_get->toInt('id'))->getData();
	    if (!$arr)
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 103, 'text' => 'Location not found.'));
	    }
	    
	    $pjLocationModel = pjLocationModel::factory();
	    if (!in_array($this->_post->toString('column'), $pjLocationModel->getI18n()))
	    {
	        $pjLocationModel->where('id', $this->_get->toInt('id'))->limit(1)->modifyAll(array($this->_post->toString('column') => $this->_post->toString('value')));
	    } else {
	        pjMultiLangModel::factory()->updateMultiLang(array($this->getLocaleId() => array($this->_post->toString('column') => $this->_post->toString('value'))), $this->_get->toInt('id'), 'pjLocation', 'data');
	    }
	    
	    self::jsonResponse(array('status' => 'OK', 'code' => 201, 'text' => 'Location has been updated.'));
	    
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
	    if (self::isPost() && $this->_post->toInt('action_update'))
	    {
	        pjLocationModel::factory()->set('id', $this->_post->toString('id'))->modify($this->_post->raw());
	        $i18n_arr = $this->_post->toI18n('i18n');
	        if (!empty($i18n_arr))
	        {
	            pjMultiLangModel::factory()->updateMultiLang($i18n_arr, $this->_post->toInt('id'), 'pjLocation');
	        }
	        pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminLocations&action=pjActionIndex&err=AL01");
	    }
	    if (self::isGet())
	    {
	        $arr = pjLocationModel::factory()->find($this->_get->toInt('id'))->getData();
	        if (empty($arr))
	        {
	            pjUtil::redirect(PJ_INSTALL_URL. "index.php?controller=pjAdminLocations&action=pjActionIndex&err=AL08");
	        }
	        $arr['i18n'] = pjMultiLangModel::factory()->getMultiLang($arr['id'], 'pjLocation');
	        $this->set('arr', $arr);
	        
	        $this->setLocalesData();
	        
	        $api_key_str = isset($this->option_arr['o_google_maps_api_key']) && !empty($this->option_arr['o_google_maps_api_key']) ? 'key=' . $this->option_arr['o_google_maps_api_key'] . '&' : '';
	        $this->appendJs('', 'https://maps.google.com/maps/api/js?'.$api_key_str.'libraries=places&region=uk&language=en', true);
	        $this->appendJs('jquery.multilang.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
	        $this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
	        $this->appendJs('additional-methods.js', PJ_THIRD_PARTY_PATH . 'validate/');
	        $this->appendJs('pjAdminLocations.js');
	    }
	}
}
?>