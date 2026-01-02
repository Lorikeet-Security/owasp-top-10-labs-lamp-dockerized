<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjBasePermissions extends pjBase
{
    public function pjActionIndex()
    {
        if (!$this->isAdmin())
        {
            $this->sendForbidden();
            return;
        }
        if(self::isGet())
        {
            $this->appendJs('jquery.datagrid.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
            $this->appendJs('pjBasePermissions.js', $this->getConst('PLUGIN_JS_PATH'));
        }
    }
    
    public function pjActionRolePermission()
    {
        if ($this->getUserId() != 1)
        {
            $this->sendForbidden();
            return;
        }

        if(self::isGet())
        {
            $role_arr = pjAuth::init()->getRoleList();
            if($this->_get->toInt('id'))
            {
                $role_id = $this->_get->toInt('id');
            }else{
                $role_id = (int) $role_arr[0]['id'];
            }
            $permission_id_arr = pjAuth::init(array('role_id' => $role_id))->getPermissionIdsByRole();
            $response = pjAuth::init()->getPermissions();
            $this->set('arr', $response['arr']);
            $this->set('second_level', $response['second_level']);
            $this->set('third_level', $response['third_level']);
            $this->set('role_arr', $role_arr);
            $this->set('role_id', $role_id);
            $this->set('permission_id_arr', $permission_id_arr);
            $this->appendJs('pjBasePermissions.js', $this->getConst('PLUGIN_JS_PATH'));
        }
    }
    
    public function pjActionUserPermission()
    {
        if (!pjAuth::factory()->hasAccess())
        {
            $this->sendForbidden();
            return;
        }

        if(self::isGet())
        {
            if($this->_get->toInt('id'))
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

                $user = pjAuth::init($params)->getUser();
                if (!$user)
                {
                    pjUtil::redirect(PJ_INSTALL_URL. "index.php?controller=pjBaseUsers&action=pjActionIndex&err=PU08");
                }
                $role_arr = pjAuth::init()->getRoleList();
                $user_id = $this->_get->toInt('id');
                $permission_id_arr = pjAuth::init(array('user_id' => $user_id))->getPermissionIdsByUser();
                $response = pjAuth::init()->getPermissions();
                $arr = array();
                if (isset($GLOBALS['CONFIG'], $GLOBALS['CONFIG']["permission_items_order"])
                && is_array($GLOBALS['CONFIG']["permission_items_order"])
                && !empty($GLOBALS['CONFIG']["permission_items_order"]))
                {
                    foreach($GLOBALS['CONFIG']["permission_items_order"] as $k => $key)
                    {
                        foreach($response['arr'] as $v)
                        {
                            if($v['key'] == $key)
                            {
                                $arr[$k] = $v;
                            }
                        }
                    }
                }else{
                    $arr = $response['arr'];
                }
                $this->set('arr', $arr);
                $this->set('second_level', $response['second_level']);
                $this->set('third_level', $response['third_level']);
                $this->set('role_arr', $role_arr);
                $this->set('user', $user);
                $this->set('permission_id_arr', $permission_id_arr);
                $this->appendJs('pjBasePermissions.js', $this->getConst('PLUGIN_JS_PATH'));
            }else{
                pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjBaseUsers&action=pjActionIndex&err=PU05");
            }
        }
    }
    
    public function pjActionAjaxSet()
    {
        $this->setAjax(true);
        
        if ($this->isXHR())
        {
            if (!self::isPost())
            {
                self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'HTTP method not allowed.'));
            }
            if (!pjAuth::factory()->hasAccess())
            {
                self::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'Access denied!'));
            }
            $data = array();
            $data['type'] = $this->_post->toString('type');
            $data['permission_id'] = $this->_post->toInt('permission_id');

            if($this->_post->toInt('role_id'))
            {
                $data['role_id'] = $this->_post->toInt('role_id');

                self::jsonResponse(pjAuth::init($data)->setRolePermission());
            }
            if($this->_post->toInt('user_id'))
            {
                if($this->_post->toInt('user_id') == 1)
                {
                    self::jsonResponse(array('status' => 'ERR', 'code' => '100'));
                }
                
                $data['user_id'] = $this->_post->toInt('user_id');

                self::jsonResponse(pjAuth::init($data)->setUserPermission());
            }
        }
        exit;
    }

    public function pjActionResetPermission()
	{
		$this->setAjax(true);

		if ($this->isXHR())
		{
		    if (!self::isPost())
            {
                self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'HTTP method not allowed.'));
            }
            if(!pjAuth::factory('pjBasePermissions', 'pjActionUserPermission')->hasAccess())
            {
                self::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'Access denied!'));
            }
            if($this->_post->toInt('user_id') == 1)
            {
                self::jsonResponse(array('status' => 'ERR', 'code' => '100'));
            }
            self::jsonResponse(pjAuth::init(array('user_id' => $this->_post->toInt('user_id')))->resetUserPermission());
		}
	}
}
?>