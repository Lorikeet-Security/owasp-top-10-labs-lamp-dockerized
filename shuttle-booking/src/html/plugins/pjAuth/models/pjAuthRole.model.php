<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjAuthRoleModel extends pjAuthAppModel
{
	protected $primaryKey = 'id';
	
	protected $table = 'plugin_auth_roles';
	
	protected $schema = array(
		array('name' => 'id', 'type' => 'tinyint', 'default' => ':NULL'),
		array('name' => 'role', 'type' => 'varchar', 'default' => ':NULL'),
	    array('name' => 'is_backend', 'type' => 'enum', 'default' => 'T'),
		array('name' => 'is_admin', 'type' => 'enum', 'default' => 'T'),
		array('name' => 'status', 'type' => 'enum', 'default' => 'T')
	);
	
	public static function factory($attr=array())
	{
	    return new self($attr);
	}
}
?>