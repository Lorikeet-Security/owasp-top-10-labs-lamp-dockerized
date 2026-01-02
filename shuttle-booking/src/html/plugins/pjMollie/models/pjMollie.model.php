<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjMollieModel extends pjMollieAppModel
{
	protected $primaryKey = 'id';
	
	protected $table = 'plugin_mollie';
	
	protected $schema = array(
		array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'foreign_id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'method', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'amount', 'type' => 'decimal', 'default' => ':NULL'),
		array('name' => 'txn_id', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'ref_id', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'bank_id', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'interval', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'customer_id', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'type', 'type' => 'enum', 'default' => 'regular'),
		array('name' => 'processed_on', 'type' => 'datetime', 'default' => ':NULL'),
		array('name' => 'status', 'type' => 'enum', 'default' => ':NULL'),
		array('name' => 'created', 'type' => 'datetime', 'default' => ':NULL')
	);
	
	public static function factory($attr=array())
	{
		return new pjMollieModel($attr);
	}
}
?>