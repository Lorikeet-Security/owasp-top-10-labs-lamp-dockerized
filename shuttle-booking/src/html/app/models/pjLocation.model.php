<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjLocationModel extends pjAppModel
{
	protected $primaryKey = 'id';
	
	protected $table = 'locations';
	
	protected $schema = array(
		array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'type', 'type' => 'enum', 'default' => 'DA'),
		array('name' => 'lat', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'lng', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'status', 'type' => 'enum', 'default' => 'T')
	);
	
	public $i18n = array('title', 'address');
	
	public static function factory($attr=array())
	{
		return new pjLocationModel($attr);
	}
}
?>