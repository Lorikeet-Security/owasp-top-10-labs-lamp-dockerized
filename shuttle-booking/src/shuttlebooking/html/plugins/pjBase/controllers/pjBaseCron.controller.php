<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjBaseCron extends pjBase
{
    public function pjActionIndex()
    {
    	if (!pjAuth::factory()->hasAccess())
        {
            $this->sendForbidden();
            return;
        }

        $arr = pjBaseCronJobModel::factory()->findAll()->getData();

        $this->set('arr', $arr);
        $this->set('has_execute', pjAuth::factory('pjBaseCron', 'pjActionExecute')->hasAccess());
        
        $this->appendJs('pjBaseCron.js', $this->getConst('PLUGIN_JS_PATH'));
    }

    public function pjActionRun()
	{
	    $arr = pjBaseCronJobModel::factory()->where('t1.is_active', 1)->findAll()->getData();
	    foreach($arr as $job)
	    {
	        if(empty($job['next_run']) || time() >= strtotime($job['next_run']))
	        {
                $this->executeCronJob($job['id']);
	        }
	    }
	    exit;
	}

	public function pjActionExecute()
	{
	    $this->setAjax(true);
	    
	    if (!pjAuth::factory()->hasAccess())
	    {
	    	self::jsonResponse(array('status' => 'ERR', 'code' => 104, 'text' => 'Access denied.'));
	    }
	    
	    if (!$this->isXHR())
	    {
	    	self::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Missing headers.'));
	    }
	    
	    if (!self::isPost())
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'HTTP method not allowed.'));
	    }
	    
	    if (!$this->_post->toInt('id'))
	    {
	        self::jsonResponse(array('status' => 'ERR', 'code' => 102, 'text' => 'Missing, empty or invalid parameters.'));
	    }
	    
	    $success = $this->executeCronJob($this->_post->toInt('id'));
	    if ($success)
        {
            self::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Cron job has been executed.'));
        }
        
		self::jsonResponse(array('status' => 'OK', 'code' => 103, 'text' => 'Cron job not found.'));
	}

	protected function executeCronJob($id)
	{
	    $pjBaseCronJobModel = pjBaseCronJobModel::factory();
	    $job = $pjBaseCronJobModel->find($id)->getData();

	    if ($job)
        {
            $controller = $job['controller'];
            $action     = $job['action'];

            if (class_exists($controller))
            {
                $controller = $controller::init();
                if(method_exists($controller, $action))
                {
                    $status = $controller->$action();

                    $pjBaseCronJobModel->reset()->set('id', $job['id'])->modify(array(
                        'last_run' => ':NOW()',
                        'next_run' => $this->getNextRunDate($job, time()),
                        'status'   => $status
                    ));

                    return true;
                }
            }
        }

	    return false;
	}

	private function getNextRunDate($job, $last_run_ts=null)
    {
		if ($last_run_ts == null)
		{
        	$last_run_ts = !empty($job['last_run'])? strtotime($job['last_run']): time();
		}
        $next_ts = strtotime(date('Y-m-d', $last_run_ts) . ' ' . $this->option_arr['o_cron_start_time']);

        $interval = 0;
        $units = (int) $job['interval'];
        switch ($job['period'])
        {
            case 'minute':
                $interval = $units * 60;
                break;
            case 'hour':
                $interval = $units * 60 * 60;
                break;
            case 'day':
                $interval = $units * 60 * 60 * 24;
                break;
            case 'week':
                $interval = $units * 60 * 60 * 24 * 7;
                break;
            case 'month':
                $interval = $units * 60 * 60 * 24 * 30;
                break;
        }

        if ($interval)
        {
            while ($last_run_ts > $next_ts)
            {
                $next_ts += $interval;
            }
        }

        return date('Y-m-d H:i:s', $next_ts);
    }
}
?>