<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjBaseCountryModel extends pjBaseAppModel
{
	protected $primaryKey = 'id';
	
	protected $table = 'plugin_base_countries';
	
	protected $schema = array(
		array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'alpha_2', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'alpha_3', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'status', 'type' => 'enum', 'default' => 'T'),
	);
	
	protected $i18n = array('name');
	
	public static function factory($attr=array())
	{
		return new self($attr);
	}
	
	public function isUnique($alpha, $length=2, $id=null)
	{
		if (empty($alpha))
		{
			throw new \Exception('Alpha code can\'t be empty.');
		}
		if (!in_array($length, array(2,3)))
		{
			throw new \Exception('Alpha code length is invalid.');
		}
		
		$this->reset();
		
		if ($length == 2)
		{
			$this->where('t1.alpha_2', $alpha);
		} elseif ($length == 3) {
			$this->where('t1.alpha_3', $alpha);
		}
		
		if ($id !== null)
		{
			$this->where('t1.id !=', $id);
		}
			
		return $this->findCount()->getData() == 0;
	}
}
?>