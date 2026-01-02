<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjNotificationModel extends pjAppModel
{
	protected $primaryKey = 'id';
	
	protected $table = 'notifications';
	
	protected $schema = array(
		array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'recipient', 'type' => 'enum', 'default' => ':NULL'),
		array('name' => 'transport', 'type' => 'enum', 'default' => ':NULL'),
		array('name' => 'variant', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'is_active', 'type' => 'tinyint', 'default' => 1),
	);
	
	protected $validate = array();
	
	protected $i18n = array('subject', 'message');
	
	public static function factory($attr=array())
	{
		return new self($attr);
	}
	
}
?>