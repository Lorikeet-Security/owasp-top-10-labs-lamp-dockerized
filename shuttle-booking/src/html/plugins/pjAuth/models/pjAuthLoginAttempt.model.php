<?php
if (!defined("ROOT_PATH"))
{
    header("HTTP/1.1 403 Forbidden");
    exit;
}
class pjAuthLoginAttemptModel extends pjAuthAppModel
{
    protected $primaryKey = 'id';
    
    protected $table = 'plugin_auth_login_attempts';
    
    protected $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'email', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'ip', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'created', 'type' => 'datetime', 'default' => ':NOW()')
    );
    
    public static function factory($attr=array())
    {
        return new self($attr);
    }
}
?>