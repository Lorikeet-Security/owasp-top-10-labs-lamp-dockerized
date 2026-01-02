<?php
if (!defined("ROOT_PATH"))
{
    header("HTTP/1.1 403 Forbidden");
    exit;
}
class pjAuthRolePermissionModel extends pjAuthAppModel
{
    protected $primaryKey = 'id';
    
    protected $table = 'plugin_auth_roles_permissions';
    
    protected $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'role_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'permission_id', 'type' => 'int', 'default' => ':NULL'),
    );
    
    public static function factory($attr=array())
    {
        return new self($attr);
    }
}
?>