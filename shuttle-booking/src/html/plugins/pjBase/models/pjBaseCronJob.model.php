<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjBaseCronJobModel extends pjBaseAppModel
{
	protected $primaryKey = 'id';
	
	protected $table = 'plugin_base_cron_jobs';
	
	protected $schema = array(
		array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'name', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'controller', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'action', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'interval', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'period', 'type' => 'enum', 'default' => ':NULL'),
		array('name' => 'next_run', 'type' => 'datetime', 'default' => ':NULL'),
		array('name' => 'last_run', 'type' => 'datetime', 'default' => ':NULL'),
		array('name' => 'status', 'type' => 'text', 'default' => ':NULL'),
		array('name' => 'is_active', 'type' => 'tinyint', 'default' => 1),
	);
	
	public static function factory($attr=array())
	{
		return new self($attr);
	}

	public function setIsActive($is_active, $controller, $action)
	{
	    $this
            ->where('controller', $controller)
            ->where('action', $action)
            ->limit(1)
            ->modifyAll(array('is_active' => (int) $is_active ? 1: 0));

		return $this;
	}
}
?>