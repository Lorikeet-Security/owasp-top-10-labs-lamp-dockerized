<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjBaseLog extends pjBase
{
    public function __construct()
    {
        parent::__construct(false); // TODO: Should be False only for pjActionLogger
    }

	public function pjActionConfig()
	{
		$this->checkLogin();

		if ($this->isAdmin())
		{
			$pjBaseLogConfigModel = pjBaseLogConfigModel::factory();

			if ($this->_post->check('update_config'))
			{
				$pjBaseLogConfigModel->eraseAll();

				$filenames = $this->_post->toArray('filename');
				if (count($filenames) > 0)
				{
					$pjBaseLogConfigModel->begin();
					foreach ($filenames as $filename)
					{
						$pjBaseLogConfigModel->reset()->set('filename', $filename)->insert();
					}
					$pjBaseLogConfigModel->commit();
				}
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjBaseLog&action=pjActionConfig&err=PLG01");
			}

			$data = array();
			pjUtil::readDir($data, 'app/controllers/');
			pjUtil::readDir($data, PJ_PLUGINS_PATH);
			$this->set('data', $data);

			$this->set('config_arr', $pjBaseLogConfigModel->findAll()->getDataPair('id', 'filename'));
		} else {
			$this->set('status', 2);
		}
	}

	public function pjActionDeleteLogBulk()
	{
		$this->setAjax(true);

		if ($this->isXHR() && $this->isLoged() && $this->isAdmin())
		{
		    $record = $this->_post->toArray('record');
			if (count($record))
			{
				pjBaseLogModel::factory()->whereIn('id', $record)->eraseAll();

				self::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Log(s) has been deleted.'));
			}

			self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Log(s) has not been deleted.'));
		}
		exit;
	}

	public function pjActionEmptyLog()
	{
		$this->setAjax(true);

		if ($this->isXHR() && $this->isLoged() && $this->isAdmin())
		{
			pjBaseLogModel::factory()->truncate();
		}
		exit;
	}

	public function pjActionGetLog()
	{
		$this->setAjax(true);

		if ($this->isXHR() && $this->isLoged() && $this->isAdmin())
		{
			$pjBaseLogModel = pjBaseLogModel::factory();

			if ($q = $this->_get->toString('q'))
			{
				$pjBaseLogModel->where('t1.filename LIKE', "%$q%");
			}

			$column = 'created';
			$direction = 'ASC';
			if ($this->_get->check('column') && in_array(strtoupper($this->_get->toString('direction')), array('ASC', 'DESC')))
			{
				$column = $this->_get->toString('column');
				$direction = strtoupper($this->_get->toString('direction'));
			}

			$total = $pjBaseLogModel->findCount()->getData();
			$rowCount = $this->_get->toInt('rowCount') ?: 10;
			$pages = ceil($total / $rowCount);
			$page = $this->_get->toInt('page') ?: 1;
			$offset = ((int) $page - 1) * $rowCount;
			if ($page > $pages)
			{
				$page = $pages;
			}

			$data = $pjBaseLogModel->select('t1.*')
				->orderBy("`$column` $direction")->limit($rowCount, $offset)->findAll()->getData();

			pjAppController::jsonResponse(compact('data', 'total', 'pages', 'page', 'rowCount', 'column', 'direction'));
		}
		exit;
	}

	public function pjActionIndex()
	{
		$this->checkLogin();

		if ($this->isAdmin())
		{
			$this->appendJs('jquery.datagrid.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
			$this->appendJs('pjBaseLog.js', $this->getConst('PLUGIN_JS_PATH'));
			$this->appendJs('index.php?controller=pjBase&action=pjActionMessages', PJ_INSTALL_URL, true);
		} else {
			$this->set('status', 2);
		}
	}

	public function pjActionLogger()
	{
		$params = $this->getParams();
		if (!isset($params['key']) || $params['key'] != md5($this->option_arr['private_key'] . PJ_SALT))
		{
			return FALSE;
		}

		$debug_backtrace = debug_backtrace(false);

		$controller = NULL;
    	foreach ($debug_backtrace as $item)
    	{
    		if (strpos($item['file'], 'pjObserver.class.php') !== false)
    		{
    			$params['function'] = $item['args'][0]['action'];
    			$controller = $item['args'][0]['controller'];
    			break;
    		}
    	}

    	foreach ($debug_backtrace as $item)
    	{
    		if (strpos($item['file'], $controller) !== false)
    		{
    			$params['filename'] = str_replace(PJ_INSTALL_PATH, "", str_replace("\\", "/", $item['file']));
    		}
    	}

    	if (!is_null($controller))
    	{
			if (pjBaseLogConfigModel::factory()->where('t1.filename', $controller)->findCount()->getData() != 0)
			{
				pjBaseLogModel::factory($params)->insert();
			}
    	}
	}
}
?>