<?php
if (!defined("ROOT_PATH"))
{
    header("HTTP/1.1 403 Forbidden");
    exit;
}
class pjClientModel extends pjAppModel
{
    protected $primaryKey = 'id';
    
    protected $table = 'clients';
    
    protected $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'foreign_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'title', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'company', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'address', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'city', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'state', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'zip', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'country_id', 'type' => 'int', 'default' => ':NULL')
    );
    
    public static function factory($attr=array())
    {
        return new pjClientModel($attr);
    }
}
?>