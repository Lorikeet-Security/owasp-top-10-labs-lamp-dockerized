<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjBaseAppModel extends pjAppModel
{
	public function getAutoIncrement()
	{
		$statement = sprintf("SHOW TABLE STATUS LIKE :table_name;");
		
		$tmp = $this->prepare($statement)->exec(array('table_name' => $this->getTable()))->getDataIndex(0);
		
		return $tmp['Auto_increment'];
	}
}
?>