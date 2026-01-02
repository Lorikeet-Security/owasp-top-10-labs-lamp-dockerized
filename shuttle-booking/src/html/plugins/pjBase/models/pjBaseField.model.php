<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjBaseFieldModel extends pjBaseAppModel
{
	protected $primaryKey = 'id';
	
	protected $table = 'plugin_base_fields';
	
	protected $schema = array(
		array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'key', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'type', 'type' => 'enum', 'default' => ':NULL'),
		array('name' => 'label', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'source', 'type' => 'enum', 'default' => 'script'),
  		array('name' => 'modified', 'type' => 'datetime', 'default' => ':NULL')
	);
	
	public static function factory($attr=array())
	{
		return new self($attr);
	}
}
?>