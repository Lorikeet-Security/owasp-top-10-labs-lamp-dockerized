<?php
if (!defined("ROOT_PATH"))
{
    header("HTTP/1.1 403 Forbidden");
    exit;
}
class pjAuthPermissionModel extends pjAuthAppModel
{
    protected $primaryKey = 'id';
    
    protected $table = 'plugin_auth_permissions';
    
    protected $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'parent_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'inherit_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'key', 'type' => 'varchar', 'default' => ':NULL'),
    	array('name' => 'is_shown', 'type' => 'enum', 'default' => 'T')
    );
    
    public static function factory($attr=array())
    {
        return new self($attr);
    }
}
?>