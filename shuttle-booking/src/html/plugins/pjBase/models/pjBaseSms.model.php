<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjBaseSmsModel extends pjBaseAppModel
{
	protected $primaryKey = 'id';
	
	protected $table = 'plugin_base_sms';
	
	protected $schema = array(
		array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'number', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'text', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'status', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'created', 'type' => 'datetime', 'default' => ':NOW()')
	);
	
	public static function factory($attr=array())
	{
	    return new self($attr);
	}
	
	public function pjActionSetup()
	{
		
	}
}
?>