<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjBaseUsers extends pjBase
{
	public function pjActionCheckEmail()
	{
		$this->setAjax(true);
		
		if ($this->isXHR())
		{
			$params = array(
				'controller' => $this->_get->toString('controller'),
				'action' => $this->_get->toString('action'),
				'email' => $this->_get->toString('email'),
				'id' => $this->_get->toInt('id'),
			);
			if ($this->_get->check('profile'))
			{
				$params['profile'] = $this->_get->toInt('profile');
			}

			echo pjAuth::init($params)->checkEmail();
		}
		exit;
	}
	
	public function pjActionCheckPassword()
	{
		$this->setAjax(true);
		if (!self::isPost())
		{
			self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'HTTP method not allowed.'));
		}
		if (!$this->_post->toString('password'))
		{
			self::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'Missing, empty or invalid parameters.'));
		}
		$response = pjAuth::init()->validatePassword($this->_post->toString('password'));
		self::jsonResponse($response);
		exit;
	}
	
	public function pjActionIndex()
	{
		$this->checkLogin();
		if (!pjAuth::factory('pjBaseUsers')->hasAccess())
		{
			$this->sendForbidden();
			return;
		}
		
		if (self::isGet())
		{ 
			$this->set('has_revert', pjAuth::factory('pjBaseUsers', 'pjActionStatusUser')->hasAccess());
			$this->appendJs('jquery.datagrid.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
			$this->appendJs('pjBaseUsers.js', $this->getConst('PLUGIN_JS_PATH'));
			
			$this->set('has_update', pjAuth::factory('pjBaseUsers', 'pjActionUpdate')->hasAccess());
			$this->set('has_create', pjAuth::factory('pjBaseUsers', 'pjActionCreate')->hasAccess());
			$this->set('has_delete', pjAuth::factory('pjBaseUsers', 'pjActionDeleteUser')->hasAccess());
			$this->set('has_delete_bulk', pjAuth::factory('pjBaseUsers', 'pjActionDeleteUserBulk')->hasAccess());
			$this->set('has_user_permission', pjAuth::factory('pjBasePermissions', 'pjActionUserPermission')->hasAccess());
		}
	}
	public function pjActionGetUser()
	{
		$this->setAjax(true);
		
		if ($this->isXHR())
		{
		    $pjAuthUserModel = pjAuthUserModel::factory()
		    					->join('pjAuthRole', 't2.id=t1.role_id', 'left')
		    					->where('t2.is_backend', 'T')
		    					->where('t2.is_admin', 'T');
			if ($q = $this->_get->toString('q'))
			{
				$q = str_replace(array('%', '_'), array('\%', '\_'), trim($q));
				$pjAuthUserModel->where('t1.email LIKE', "%$q%");
				$pjAuthUserModel->orWhere('t1.name LIKE', "%$q%");
			}
			
			if (in_array($this->_get->toString('status'), array('T', 'F')))
			{
				$pjAuthUserModel->where('t1.status', $this->_get->toString('status'));
			}
			
			$column = 'name';
			$direction = 'ASC';
			if ($this->_get->toString('column') && in_array(strtoupper($this->_get->toString('direction')), array('ASC', 'DESC')))
			{
				$column = $this->_get->toString('column');
				$direction = strtoupper($this->_get->toString('direction'));
			}
			
			$total = $pjAuthUserModel->findCount()->getData();
			$rowCount = $this->_get->toInt('rowCount') ?: 10;
			$pages = ceil($total / $rowCount);
			$page = $this->_get->toInt('page') ?: 1;
			if ($page > $pages)
			{
				$page = $pages;
			}
			$page = $page >= 1 ? $page : 1;
			$offset = ((int) $page - 1) * $rowCount;
			
			$data = $pjAuthUserModel
				->select('t1.id, t1.email, t1.name, DATE(t1.created) AS `created`, DATE(t1.last_login) AS `last_login`, t1.status, t1.is_active, t1.locked, t1.role_id')
				->orderBy("$column $direction")
				->limit($rowCount, $offset)
				->findAll()
				->getData();
			
			$role_arr = __('plugin_base_role_arr', true);
			foreach($data as $k => $v) {
				$data[$k]['role'] = $role_arr[$v['role_id']];
				$data[$k]['name'] = pjSanitize::clean($v['name']);
				$data[$k]['email'] = pjSanitize::clean($v['email']);
			}
			
			self::jsonResponse(compact('data', 'total', 'pages', 'page', 'rowCount', 'column', 'direction'));
		}
		exit;
	}
	
	public function pjActionCreate()
	{
		$this->checkLogin();
		if (!pjAuth::factory()->hasAccess())
		{
			$this->sendForbidden();
			return;
		}
		
		if (self::isPost() && $this->_post->toInt('user_create'))
		{
			$data = array();
			$data['status'] = $this->_post->check('status') ? 'T': 'F';
			$data['role_id'] = $this->_post->toInt('role_id');

			$response = pjAuth::init(array_merge($this->_post->raw(),$data))->createUser();
			pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjBaseUsers&action=pjActionIndex&err=" . $response['code']);
		}
		if (self::isGet())
		{
			$this->appendJs('pjBaseUsers.js', $this->getConst('PLUGIN_JS_PATH'));
		}
	}
	
	public function pjActionUpdate()
	{
		$this->checkLogin();
		if (!pjAuth::factory()->hasAccess())
		{
			$this->sendForbidden();
			return;
		}
		
		$has_revert = pjAuth::factory('pjBaseUsers')->hasAccess();
		
		if (self::isPost() && $this->_post->toInt('user_update') && $this->_post->toInt('id'))
		{
		    $post = $this->_post->raw();
			$data = array();
			$data['id'] = $this->_post->toInt('id');
			if ($has_revert)
			{
				$data['status'] = $this->_post->check('status') ? 'T' : 'F';
			}
			$data['ip'] = pjUtil::getClientIp();
			$data['role_id'] = $this->_post->toInt('role_id');
			if ($this->_post->has('password') && !$this->_post->isEmpty('password'))
			{
				$data['password'] = $this->_post->toString('password');
				$data['pswd_modified'] = ':NOW()';
			}else{
			    unset($post['password']);
			}

			$response = pjAuth::init(array_merge($post,$data))->updateUser();
			pjUtil::redirect(PJ_INSTALL_URL . "index.php?controller=pjBaseUsers&action=pjActionIndex&err=" . $response['code']);
		}
		if (self::isGet() && $this->_get->toInt('id'))
		{
		    if($this->_get->toInt('id') == 1 && $this->getUserId() != 1)
		    {
		        $this->sendForbidden();
		        return;
		    }
			$params = array(
				'controller' => $this->_get->toString('controller'),
				'action' => $this->_get->toString('action'),
				'id' => $this->_get->toInt('id'),
			);

			$arr = pjAuth::init($params)->getUser();
			if (!$arr)
			{
				pjUtil::redirect(PJ_INSTALL_URL. "index.php?controller=pjBaseUsers&action=pjActionIndex&err=PU08");
			}
			$this->set('arr', $arr);
			$this->set('has_revert', $has_revert);
			$this->appendJs('pjBaseUsers.js', $this->getConst('PLUGIN_JS_PATH'));
		}
	}
	
	public function pjActionProfile()
	{
	    $this->checkLogin();
	    if (!pjAuth::factory()->hasAccess())
	    {
	        $this->sendForbidden();
	        return;
	    }
	    
	    $has_revert = pjAuth::factory('pjBaseUsers', 'pjActionStatusUser')->hasAccess() && $this->getUserId() != 1;
	    
	    if (self::isPost() && $this->_post->toInt('user_update') && $this->_post->toInt('id'))
	    {
	        $data = array();
	        $data['id'] = $this->_post->toInt('id');
	        if ($has_revert)
	        {
	            $data['status'] = $this->_post->check('status') ? 'T' : 'F';
	        }
	        $data['ip'] = pjUtil::getClientIp();
	        $data['email'] = $this->_post->toString('email');
	        if ($this->_post->has('password') && !$this->_post->isEmpty('password'))
	        {
	            $data['password'] = $this->_post->toString('password');
	            $data['pswd_modified'] = ':NOW()';
	        }
	        $data['name'] = $this->_post->toString('name');
	        $data['phone'] = $this->_post->toString('phone') ?: ':NULL';
	        
	        $response = pjAuth::init($data)->updateUser();
	        pjUtil::redirect(PJ_INSTALL_URL . "index.php?controller=pjBaseUsers&action=pjActionProfile&err=" . $response['code']);
	    }
	    if (self::isGet())
	    {
	        $params = array(
	            'controller' => $this->_get->toString('controller'),
	            'action' => $this->_get->toString('action'),
	            'id' => $this->getUserId(),
	        );
	        
	        $arr = pjAuth::init($params)->getUser();
	        if (!$arr)
	        {
	            pjUtil::redirect(PJ_INSTALL_URL. "index.php?controller=pjBaseUsers&action=pjActionIndex&err=PU08");
	        }
	        $this->set('arr', $arr);
	        $this->set('role_arr', $arr = pjAuth::init()->getRoleList());
	        $this->set('has_revert', $has_revert);
	        $this->appendJs('pjBaseUsers.js', $this->getConst('PLUGIN_JS_PATH'));
	    }
	}
	
	public function pjActionExportUser()
	{
		$this->checkLogin();
		if (!pjAuth::factory('pjBaseUsers', 'pjActionExportUser')->hasAccess())
		{
			$this->sendForbidden();
			return;
		}

		$record = $this->_post->toArray('record');
		if (count($record))
		{
			$arr = pjAuthUserModel::factory()->whereIn('id', $record)->findAll()->getData();
			$datetime = array('created', 'last_login', 'pswd_modified');
			foreach ($arr as &$item)
			{
				foreach ($datetime as $index)
				{
					if (!empty($item[$index]))
					{
						$item[$index] = pjDateTime::formatDateTime($item[$index], 'Y-m-d H:i:s', $this->option_arr['o_date_format'] . ', ' . $this->option_arr['o_time_format']);
					}
				}
			}
			$csv = new pjCSV();
			$csv
				->setHeader(true)
				->setName("Users-".time().".csv")
				->process($arr)
				->download();
		}
		exit;
	}
	
	public function pjActionSaveUser()
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
		$params = array(
			'id' => $this->_get->toInt('id'),
			'column' => $this->_post->toString('column'),
			'value' => $this->_post->toString('value'),
		);
		if (!(isset($params['id'], $params['column'], $params['value'])
			&& pjValidation::pjActionNumeric($params['id'])
			&& pjValidation::pjActionNotEmpty($params['column'])))
		{
			self::jsonResponse(array('status' => 'ERR', 'code' => 102, 'text' => 'Missing, empty or invalid parameters.'));
		}
		
		if ($params['column'] == 'status' && !pjAuth::factory('pjBaseUsers')->hasAccess())
		{
			self::jsonResponse(array('status' => 'ERR', 'code' => 103, 'text' => 'Access denied.'));
		}
		
		if ($params['column'] == 'email')
		{
			if (pjAuthUserModel::factory()
				->join("pjAuthRole", "t1.role_id=t2.id", "left outer")
				->where('t1.id !=', $params['id'])
				->where('t1.email', $params['value'])
				->where('t2.is_backend', 'T')
				->findCount()
				->getData())
			{
				self::jsonResponse(array('status' => 'ERR', 'code' => 105, 'text' => 'Email address is already in use.'));
			}
		}
		
		$pass = true;
		if ((int) $params['id'] === 1)
		{
		    if($this->getUserId() == 1)
		    {
    			if (in_array($params['column'], array('role_id', 'status', 'is_active')))
    			{
    				$pass = false;
    			} elseif (in_array($params['column'], array('name', 'email')) && $params['value'] == '') {
    				$pass = false;
    			} elseif ($params['column'] == 'email' && $params['value'] != '' && !filter_var($params['value'], FILTER_VALIDATE_EMAIL)) {
    				$pass = false;
    			}
		    }else{
		        $pass = false;
		    }
		}
		if (in_array($params['column'], array('locked')))
		{
			$result = pjAuth::init()->unlockAccount($params['id']);
			if ($result['status'] == 'OK')
			{
				$params['value'] = 'F';
			} else {
				$pass = false;
			}
		}
		if (!$pass)
		{
			self::jsonResponse(array('status' => 'ERR', 'code' => 104, 'text' => 'Access denied.'));
		}
		self::jsonResponse(pjAuth::init($params)->updateUser());
	}
	
	public function pjActionStatusUser()
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
		if (!pjAuth::factory('pjBaseUsers', 'pjActionUpdate')->hasAccess())
		{
			self::jsonResponse(array('status' => 'ERR', 'code' => 102, 'text' => 'Access denied.'));
		}
		$record = $this->_post->toArray('record');
		if (empty($record))
		{
			self::jsonResponse(array('status' => 'ERR', 'code' => 103, 'text' => 'Missing, empty or invalid parameters.'));
		}
		pjAuthUserModel::factory()
			->whereIn('id', $record)
			->where('id !=', $this->getUserId())
			->where('id !=', 1)
			->modifyAll(array(
				'status' => ":IF(`status`='F','T','F')"
			));
		self::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'User status has been updated.'));
	}
	
	public function pjActionDeleteUser()
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
		if ($this->_get->toInt('id') == $this->getUserId() || $this->_get->toInt('id') == 1)
		{
			self::jsonResponse(array('status' => 'ERR', 'code' => 104, 'text' => 'Access denied.'));
		}
		if (!pjAuthUserModel::factory()->set('id', $this->_get->toInt('id'))->erase()->getAffectedRows())
		{
			self::jsonResponse(array('status' => 'ERR', 'code' => 105, 'text' => 'User has not been deleted.'));
		}
		
		pjAuthUserPermissionModel::factory()->where('user_id', $this->_get->toInt('id'))->eraseAll();
		
		self::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'User has been deleted'));
	}
	
	public function pjActionDeleteUserBulk()
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
		pjAuthUserModel::factory()
			->where('id !=', $this->getUserId())
			->where('id !=', 1)
			->whereIn('id', $record)
			->eraseAll();
		
		pjAuthUserPermissionModel::factory()
			->where('id !=', $this->getUserId())
			->where('id !=', 1)
			->whereIn('user_id', $record)
			->eraseAll();
			
		self::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'User(s) has been deleted.'));
	}
}
?>