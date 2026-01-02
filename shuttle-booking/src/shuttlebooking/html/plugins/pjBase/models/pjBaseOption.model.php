<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjBaseOptionModel extends pjBaseAppModel
{
	protected $primaryKey = NULL;
	
	protected $table = 'plugin_base_options';
	
	protected $schema = array(
		array('name' => 'foreign_id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'key', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'tab_id', 'type' => 'tinyint', 'default' => ':NULL'),
		array('name' => 'value', 'type' => 'text', 'default' => ':NULL'),
		array('name' => 'label', 'type' => 'text', 'default' => ':NULL'),
		array('name' => 'type', 'type' => 'varchar', 'default' => 'string'),
		array('name' => 'order', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'is_visible', 'type' => 'tinyint', 'default' => 1),
		array('name' => 'style', 'type' => 'varchar', 'default' => 'string')
	);
	
	public static function factory($attr=array())
	{
		return new self($attr);
	}
	
	public function getAllPairs($foreign_id)
	{
		return $this->where('t1.foreign_id', $foreign_id)->findAll()->getDataPair('key', 'value');
	}
	
	public function getPairs($foreign_id)
	{
		$_arr = $this->where('t1.foreign_id', $foreign_id)->findAll()->getData();
		$arr = array();
		foreach ($_arr as $row)
		{
			switch ($row['type'])
			{
				case 'enum':
				case 'bool':
					if (strpos($row['value'], '::') !== false)
					{
						list(, $arr[$row['key']]) = explode("::", $row['value']);
					} else {
						$arr[$row['key']] = NULL;
					}
					break;
				default:
					$arr[$row['key']] = $row['value'];
					break;
			}
		}
		
		return $arr;
	}

	public function getPairsExt($foreign_id)
	{
		$arr = $this
			->where('t1.foreign_id', $foreign_id)
			->orderBy('t1.order ASC')
			->findAll()
			->getDataPair('key');
			
		foreach ($arr as &$item)
		{
			if (in_array($item['type'], array('enum', 'bool')))
			{
				$default = explode("::", $item['value']);
				$item['_value'] = $default[1];
				$item['_keys'] = explode("|", $default[0]);
					
				if (!empty($item['label']))
				{
					$item['_values'] = explode("|", $item['label']);
					
					if (count($item['_keys']) == count($item['_values']))
					{
						$item['_pairs'] = array_combine($item['_keys'], $item['_values']);
					}
				}
			}
		}
		
		return $arr;
	}
}
?>