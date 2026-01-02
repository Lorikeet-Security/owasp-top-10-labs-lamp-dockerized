<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjTimetableModel extends pjAppModel
{
	protected $primaryKey = 'id';
	
	protected $table = 'timetable';
	
	protected $schema = array(
		array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'line_id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'location_id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'direction', 'type' => 'enum', 'default' => ':NULL'),
		array('name' => 'every', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'time', 'type' => 'text', 'default' => ':NULL'),
		array('name' => 'status', 'type' => 'enum', 'default' => 'T'),
	);
	
	public static function factory($attr=array())
	{
		return new pjTimetableModel($attr);
	}
}
?>