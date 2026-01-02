<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjBaseCurrencyDataModel extends pjBaseAppModel
{
	protected $primaryKey = 'id';
	
	protected $table = 'plugin_base_currencies';
	
	protected $schema = array(
		array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'code', 'type' => 'varchar', 'default' => ':NULL'),
	    array('name' => 'sign', 'type' => 'varchar', 'default' => ':NULL')
	);
	
	public static function factory($attr=array())
	{
	    return new self($attr);
	}
}
?>