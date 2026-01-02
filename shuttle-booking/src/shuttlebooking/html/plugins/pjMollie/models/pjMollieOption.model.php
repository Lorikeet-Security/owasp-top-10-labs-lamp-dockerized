<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjMollieOptionModel extends pjMollieAppModel
{
	protected $primaryKey = 'id';
	
	protected $table = 'plugin_mollie_options';
	
	protected $schema = array(
		array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'foreign_id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'method', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'is_active', 'type' => 'bool', 'default' => 0),
	);
	
	public static function factory($attr=array())
	{
		return new pjMollieOptionModel($attr);
	}
}
?>