<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjLineModel extends pjAppModel
{
	protected $primaryKey = 'id';
	
	protected $table = 'lines';
	
	protected $schema = array(
		array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'location_id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'seats', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'source_path', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'thumb_path', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'image_name', 'type' => 'varchar', 'default' => ':NULL')
	);
	
	public $i18n = array('title', 'description');
	
	public static function factory($attr=array())
	{
		return new pjLineModel($attr);
	}
}
?>