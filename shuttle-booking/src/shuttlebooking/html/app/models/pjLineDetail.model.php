<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjLineDetailModel extends pjAppModel
{
	protected $primaryKey = 'id';
	
	protected $table = 'line_details';
	
	protected $schema = array(
		array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'line_id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'location_id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'duration_pickup', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'duration_dropoff', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'price_pickup', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'price_dropoff', 'type' => 'int', 'default' => ':NULL'),
	);
	
	public static function factory($attr=array())
	{
		return new pjLineDetailModel($attr);
	}
}
?>