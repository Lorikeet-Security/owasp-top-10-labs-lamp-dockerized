<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjFrontClient extends pjAuth
{
    public $defaultFrontClient = 'pjShuttleBS_Client';
    
    public $defaultTmpUser = 'pjShuttleBS_Temp_User';
    
    public function getClientByEmail()
    {
        $params = $this->getParams();
        $client = pjAuthUserModel::factory()->where('email', $params['email'])->where('role_id', 3)->findAll()->getDataIndex(0);
        if(!empty($client))
        {
            return $client;
        }else{
            return FALSE;
        }
    }
    
    public function createClient()
    {
        $params = $this->getParams();
        $u_data = array();
        $u_data['is_active'] = 'T';
        $u_data['role_id'] = 3;
        $u_data['email'] = $params['email'];
        $u_data['password'] = isset($params['password']) ? $params['password'] : pjAuth::generatePassword($this->option_arr);
        $name_arr = array();
        if(isset($params['fname']) && !empty($params['fname']))
        {
            $name_arr[] = $params['fname'];
        }
        if(isset($params['lname']) && !empty($params['lname']))
        {
            $name_arr[] = $params['lname'];
        }
        $u_data['name'] = join(" ", $name_arr);
        $u_data['phone'] = isset($params['phone']) ? $params['phone'] : ":NULL";
        $u_data['status'] = isset($params['status']) ? $params['status'] : ":NULL";
        $u_data['ip'] = pjUtil::getClientIp();
        $u_data['is_active'] = 'T';
        $id = pjAuthUserModel::factory($u_data)->insert()->getInsertId();
        if ($id !== false && (int) $id > 0)
        {
            $client = pjFrontClient::init($u_data)->getClientByEmail();
            if($client != FALSE)
            {
                $c_data = array();
                $c_data['foreign_id'] = $client['id'];
                $c_data['title'] = isset($params['title']) ? $params['title'] : ":NULL";
                $c_data['company'] = isset($params['company']) ? $params['company'] : ":NULL";
                $c_data['address'] = isset($params['address']) ? $params['address'] : ":NULL";
                $c_data['city'] = isset($params['city']) ? $params['city'] : ":NULL";
                $c_data['state'] = isset($params['state']) ? $params['state'] : ":NULL";
                $c_data['zip'] = isset($params['zip']) ? $params['zip'] : ":NULL";
                $c_data['country_id'] = isset($params['country_id']) ? $params['country_id'] : ":NULL";
                $client_id = pjClientModel::factory()->setAttributes($c_data)->insert()->getInsertId();
                if ($client_id !== false && (int) $client_id > 0)
                {
                    pjAppController::pjActionAccountSend($this->option_arr, $client_id, PJ_SALT, 'account', $this->getLocaleId());
                    return array('status' => "OK", 'code' => 200, 'client_id' => $client_id);
                }
                return array('status' => "OK", 'code' => 200);
            }
        }else{
            return array('status' => "ERR", 'code' => 100);
        }
    }
    
    public function setClientSession()
    {
        $params = $this->getParams();
        $client = pjClientModel::factory()->where('foreign_id', $params['id'])->findAll()->getDataIndex(0);
        if(!empty($client))
        {
            $user = pjAuth::init($params)->getUser();
            unset($client['id']);
            $client = array_merge($user, $client);
            $this->session->unsetData($this->defaultFrontClient);
            $this->session->setData($this->defaultFrontClient, $client);
        }
    }
    
    public function doClientLogin()
    {
        $params = $this->getParams();
        if($this->session->has($this->defaultUser))
        {
            $this->session->setData($this->defaultTmpUser, $this->session->getData($this->defaultUser));
        }
        $params['is_backend'] = 'F';
        $response = pjAuth::init($params)->doLogin();
        if($response['status'] == 'OK')
        {
            if($this->isClient())
            {
                pjFrontClient::init(array('id' => $this->getUserId()))->setClientSession();
            }else{
                $response = array('status' => 'ERR', 'code' => '6');
            }
        }
        if($this->session->has($this->defaultTmpUser))
        {
            $this->session->setData($this->defaultUser, $this->session->getData($this->defaultTmpUser));
            $this->session->unsetData($this->defaultTmpUser);
        }
        return $response;
    }
    
    public function doSendPassword()
    {
        $params = $this->getParams();
        $user = pjFrontClient::init($params)->getClientByEmail();
        $response = array();
        if ($user == FALSE)
        {
            $response = array('status' => 'ERR', 'code' => 100);
        }else{
            $client = pjClientModel::factory()->where('foreign_id', $user['id'])->findAll()->getDataIndex(0);
            if ($user['status'] != 'T')
            {
                $response = array('status' => 'ERR', 'code' => 101);
            }else{
                $locale_id = $this->getLocaleId();
                if(isset($params['locale_id']) && (int) $params['locale_id'] > 0)
                {
                    $locale_id = $params['locale_id'];
                }
                pjAppController::pjActionAccountSend($this->option_arr, $client['id'], PJ_SALT, 'forgot', $locale_id);
                $response = array('status' => 'OK', 'code' => 200);
            }
        }
        return $response;
    }
}
?>