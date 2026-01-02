<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
/**
 * PHP Framework
 *
 * @copyright Copyright 2018, PHPJabbers
 * @link      https://www.phpjabbers.com/
 * @package   framework
 * @version   2.1.0
 */

/**
 * Object-relational mapper.
 *
 * DBO-backed object data model.
 *
 * @package framework
 * @since 1.0.0
 */
class pjModel extends pjObject
{
/**
 * The full path and filename of the file.
 *
 * @var string
 * @access public
 */
	public $ClassFile = __FILE__;
/**
 * Number of affected rows in previous MySQL operation
 *
 * @var int
 * @access private
 */
	private $affectedRows = -1;
/**
 * Hold the parts of sql statement for BATCH (bulk) execution
 *
 * @var array
 * @access private
 */
	private $arBatch = array();
/**
 * Array of column names affected by batch INSERT
 *
 * @var array
 * @access private
 */
	private $arBatchFields = array();
/**
 * Array of data
 * 
 * @var array
 * @access private
 */
	private $arData = array();
/**
 * Flag which tells the query string compiler to print the query at execution time
 *
 * @var boolean
 * @access private
 */
	private $arDebug = FALSE;
/**
 * Flag which tells the query string compiler to add DISTINCT.
 *
 * @var boolean
 * @access private
 */
	private $arDistinct = FALSE;
/**
 * Hold FROM clause
 *
 * @var string
 * @access private
 */
	private $arFrom = NULL;
/**
 * Hold GROUP BY clause
 *
 * @var string
 * @access private
 */
	private $arGroupBy = NULL;
/**
 * Hold HAVING clause
 *
 * @var string
 * @access private
 */
	private $arHaving = NULL;
/**
 * Hold Index Hint
 *
 * @var string
 * @access private
 */
	private $arIndex = NULL;
/**
 * Hold joined tables used by JOIN clause(s)
 *
 * @var array
 * @access private
 */
	private $arJoin = array();
/**
 * Hold offset used by LIMIT clause
 *
 * @var int
 * @access private
 */
	private $arOffset = NULL;
/**
 * Hold ORDER BY clause
 *
 * @var string
 * @access private
 */
	private $arOrderBy = NULL;
/**
 * Hold row_count used by LIMIT clause
 *
 * @var int
 * @access private
 */
	private $arRowCount = NULL;
/**
 * Hold SELECT clause
 *
 * @var array
 * @access private
 */
	private $arSelect = array();
/**
 * Hold WHERE clause
 *
 * @var array
 * @access private
 */
	private $arWhere = array();
/**
 * Hold WHERE clause
 *
 * @var array
 * @access private
 */
	private $arWhereIn = array();
/**
 * Allowed association types
 *
 * @var array
 * @access private
 */
	private $assocTypes = array('hasOne', 'hasMany', 'belongsTo', 'hasAndBelongsToMany');
/**
 * Hold belongsTo model associations
 *
 * @var array
 * @access protected
 */
	protected $belongsTo = NULL;
/**
 * Hold result data
 *
 * @var array
 * @access private
 */
	private $data = array();
/**
 * Database object
 *
 * @var object
 * @access private
 */
	private $dbo = NULL;
/**
 * Hold errors if any
 *
 * @var array
 * @access private
 */
	private $errors = array();
/**
 * Hold hasAndBelongsToMany model associations
 *
 * @var array
 * @access protected
 */
	protected $hasAndBelongsToMany = NULL;
/**
 * Hold hasMany model associations
 *
 * @var array
 * @access protected
 */
	protected $hasMany = NULL;
/**
 * Hold hasOne model associations
 *
 * @var array
 * @access protected
 */
	protected $hasOne = NULL;
/**
 * Show connection status
 *
 * @var boolean
 * @access private
 */
	private $initialized = FALSE;
/**
 * The ID generated in the last query.
 *
 * @var int
 * @access private
 */
	private $insertId = FALSE;
/**
 * Allowed JOIN types
 *
 * @var array
 * @access private
 */
	private $joinArr = array('LEFT', 'RIGHT', 'OUTER', 'INNER', 'LEFT OUTER', 'RIGHT OUTER', 'CROSS', 'NATURAL', 'STRAIGHT');
/**
 * Table prefix
 *
 * @var string
 * @access private
 */
	private $prefix = NULL;
/**
 * Model's Primary key name
 *
 * @var string
 * @access protected
 */
	protected $primaryKey = NULL;
/**
 * Model's schema
 *
 * @var array
 * @access protected
 */
	protected $schema = array();
/**
 * Script prefix. Used to build table name
 *
 * @var string
 * @access private
 */
	private $scriptPrefix = NULL;
/**
 * Hold custom SQL statement
 *
 * @var string
 * @access private
 */
	private $statement = NULL;
/**
 * Model's table name
 *
 * @var string
 * @access protected
 */
	protected $table = NULL;
/**
 * Model's i18n column names
 *
 * @var array
 * @access protected
 */
	protected $i18n = array();
/**
 * Tells whether transaction is already started
 *
 * @var boolean
 * @access private
 */
	private $transactionStarted = false;
/**
 * Model's validate schema
 *
 * @var array
 * @access protected
 */
	protected $validate = array();
/**
 * Constructor. Binds the model's database table to the object.
 *
 * @param array $attr
 * @access public
 * @return self
 */
	public function __construct($attr=array())
	{
		if (defined('PJ_PREFIX'))
		{
			$this->setPrefix(PJ_PREFIX);
		}
		if (defined('PJ_SCRIPT_PREFIX'))
		{
			$this->scriptPrefix = PJ_SCRIPT_PREFIX;
		}
		
		$registry = pjRegistry::getInstance();
		if ($registry->is('dbo'))
		{
			$this->dbo = $registry->get('dbo');
			$this->initialized = TRUE;
		} else {
			$driver = function_exists('mysqli_connect') ? 'pjMysqliDriver' : 'pjMysqlDriver';

			$params = array(
				'hostname' => PJ_HOST,
				'username' => PJ_USER,
				'password' => PJ_PASS,
				'database' => PJ_DB
			);
			
			if (strpos($params['hostname'], ":") !== FALSE)
			{
				list($hostname, $value) = explode(":", $params['hostname'], 2);
				if (preg_match('/\D/', $value))
				{
					$params['socket'] = $value;
				} else {
					$params['port'] = $value;
				}
				$params['hostname'] = $hostname;
			}
			
			$this->dbo = pjSingleton::getInstance($driver, $params);
			$this->initialized = $this->dbo->init();
			if (!$this->initialized)
			{
				die($this->dbo->connectError());
			}
			$registry->set('dbo', $this->dbo);
		}
		
		$this->setAttributes($attr);
		return $this;
	}
/**
 * Called after every deletion operation.
 *
 * @access public
 * @return boolean
 */
	public function afterDelete($method)
	{
		return true;
	}
/**
 * Called after each find operation.
 *
 * @access public
 * @return boolean
 */
	public function afterFind()
	{
		return true;
	}
/**
 * Called after each successful save operation.
 *
 * @access public
 * @return boolean
 */
	public function afterSave($method)
	{
		return true;
	}
/**
 * Set autocommit mode. If set to 1, all changes to a table take effect
 * immediately. If set to 0, you must use 'commit' to accept a transaction
 * or 'rollback' to cancel it.
 *
 * @access public
 * @return boolean
 */
	public function autocommit($value = 0)
	{
		if (!in_array($value, array(0,1))) return false;
		if (!$this->transactionStarted && $this->prepare("SET autocommit = " . $value)->exec()->dbo->getResult())
		{
			$this->transactionStarted = true;
			return true;
		}
		return false;
	}
/**
 * Called before every deletion operation. Return false if you want to halt the delete call.
 *
 * @access public
 * @return boolean
 */
	public function beforeDelete($method)
	{
		return true;
	}
/**
 * Called before each find operation. Return false if you want to halt the find call.
 *
 * @access public
 * @return boolean
 */
	public function beforeFind()
	{
		return true;
	}
/**
 * Called before each save operation. Return a non-true result to halt the save.
 *
 * @access public
 * @return boolean
 */
	public function beforeSave($method)
	{
		return true;
	}
/**
 * Begin a transaction.
 *
 * @access public
 * @return boolean
 */
	public function begin()
	{
		if (!$this->transactionStarted && $this->prepare("START TRANSACTION")->exec()->dbo->getResult())
		{
			$this->transactionStarted = true;
			return true;
		}
		return false;
	}
/**
 * Generates a query string based on which functions were used.
 * Should not be called directly. The insert(), modify() and modifyAll() function calls it.
 *
 * @param string $type
 * @access private
 * @return array
 */
	private function buildSave($type=NULL)
	{
		$save = array();
		$data = $this->getAttributes();
		
		foreach ($this->schema as $field)
		{
			if (isset($data[$field['name']]))
			{
				if (!is_array($data[$field['name']]))
				{
					//$save[] = sprintf("`%s` = %s", $field['name'], strpos($data[$field['name']], ":") === 0 ? substr($data[$field['name']], 1) : $this->escapeValue($data[$field['name']]));
					if (!isset($field['encrypt']))
					{
						$save[] = sprintf("`%s` = %s", $field['name'],
							preg_match('/^:[a-zA-Z]{1}.*/', $data[$field['name']]) ?
								substr($data[$field['name']], 1) :
								$this->escapeValue($data[$field['name']])
						);
					} else {
						switch (strtoupper($field['encrypt']))
						{
							case 'AES':
								$save[] = sprintf("`%s` = %s", $field['name'], $this->aesEncrypt($data[$field['name']]));
								break;
						}
					}
				}
			} else {
				if (!is_null($type) && $type == 'insert')
				{
					$save[] = "`".$field['name']."` = " . (strpos($field['default'], ":") === 0 ? substr($field['default'], 1) : "'".$this->escape($field['default'], null, $field['type'])."'");
				}
			}
		}
		return $save;
	}
/**
 * Generates a query string based on which functions were used.
 * Should not be called directly. The find() and findAll() function calls it.
 *
 * @access private
 * @return string
 */
	private function buildSelect()
	{
		$sql = "";
		
		# Select ---
		$sql .= !$this->arDistinct ? "SELECT " : "SELECT DISTINCT ";
		if (count($this->arSelect) === 0)
		{
			$tmp = array();
			foreach ($this->schema as $field)
			{
				if (!isset($field['encrypt']))
				{
					$tmp[] = 't1.' . $field['name'];
				} else {
					switch (strtoupper($field['encrypt']))
					{
						case 'AES':
							$tmp[] = sprintf("%s AS `%s`", $this->aesDecrypt($field['name']), $field['name']);
							break;
					}
				}
			}
			$sql .= join(", ", $tmp);
		} else {
			$sql .= join(", ", $this->arSelect);
		}
		$sql .= "\n";
		
		# From ---
		$sql .= "FROM " . (empty($this->arFrom) ? $this->getTable() : $this->arFrom) . " AS t1";
		$sql .= "\n";
		
		# Index hint ---
		if (!empty($this->arIndex))
		{
			$sql .= $this->arIndex;
			$sql .= "\n";
		}
		
		# Join ---
		if (count($this->arJoin) > 0)
		{
			$sql .= join("\n", $this->arJoin);
			$sql .= "\n";
		}
		
		# Where ---
		if (is_array($this->arWhere) && count($this->arWhere) > 0)
		{
			$sql .= "WHERE " . join("\n", $this->arWhere);
			$sql .= "\n";
		}
		
		# Group By ---
		if (!empty($this->arGroupBy))
		{
			$sql .= "GROUP BY " . $this->arGroupBy;
			$sql .= "\n";
		}
		
		# Having ---
		if (!empty($this->arHaving))
		{
			$sql .= "HAVING " . $this->arHaving;
			$sql .= "\n";
		}
		
		# Order By ---
		if (!empty($this->arOrderBy))
		{
			$sql .= "ORDER BY " . $this->arOrderBy;
			$sql .= "\n";
		}
		
		# Limit ---
		if ((int) $this->arRowCount > 0)
		{
			$sql .= "LIMIT " . (int) $this->arOffset . ", " . (int) $this->arRowCount;
		}
		
		return $sql;
	}
/**
 * Commit a transaction.
 *
 * @access public
 * @return boolean
 */
	public function commit()
	{
		if ($this->transactionStarted && $this->prepare("COMMIT")->exec()->dbo->getResult())
		{
			$this->transactionStarted = false;
			return true;
		}
		return false;
	}
/**
 * Sets a flag which tells the query string compiler to print the query.
 *
 * @param boolean $val
 * @access public
 * @return self
 */
	public function debug($val)
	{
		$this->arDebug = (bool) $val;
		return $this;
	}
/**
 * Sets a flag which tells the query string compiler to add DISTINCT.
 *
 * @param boolean $val
 * @access public
 * @return self
 */
	public function distinct($val)
	{
		$this->arDistinct = is_bool($val) ? $val : true;
		return $this;
	}
/**
 * Runs DELETE ... LIMIT 1 query.
 * @access public
 * @return self
 */
	public function erase()
	{
		if ($this->beforeDelete('erase'))
		{
			$sql = sprintf("DELETE FROM `%s` WHERE `%s` = '%s' LIMIT 1", $this->getTable(), $this->primaryKey, $this->arData[$this->primaryKey]);
			if (FALSE !== $this->dbo->query($sql))
			{
				$this->affectedRows = $this->dbo->affectedRows();
				$this->afterDelete('erase');
			} else {
				die($this->dbo->error());
			}
		}
		return $this;
	}
/**
 * Runs DELETE query.
 *
 * @access public
 * @return self
 */
	public function eraseAll()
	{
		if ($this->beforeDelete('eraseAll'))
		{
			$sql = "";
			$sql .= sprintf("DELETE FROM `%s`", empty($this->arFrom) ? $this->getTable() : $this->arFrom);
			$sql .= "\n";
			
			# Where ---
			if (is_array($this->arWhere) && count($this->arWhere) > 0)
			{
				$sql .= "WHERE " . join("\n", $this->arWhere);
				$sql .= "\n";
			}
		
			# Order By ---
			if (!empty($this->arOrderBy))
			{
				$sql .= "ORDER BY " . $this->arOrderBy;
				$sql .= "\n";
			}
			
			# Limit
			if ((int) $this->arRowCount > 0)
			{
				$sql .= "LIMIT " . (int) $this->arRowCount;
			}
			
			if ($this->arDebug)
			{
				printf('<pre>%s</pre>', $sql);
			}
			if (FALSE !== $this->dbo->query($sql))
			{
				$this->affectedRows = $this->dbo->affectedRows();
				$this->afterDelete('eraseAll');
			} else {
				die($this->dbo->error());
			}
		}
		return $this;
	}
/**
 * Escape a value by given column or type.
 *
 * @param string $value
 * @param string $column
 * @param string $type
 * @access public
 * @return int|float|string|null
 */
	public function escape($value, $column=null, $type=null)
	{
		if (is_null($type) && !is_null($column))
		{
			$type = $this->getColumnType($column);
		}
		
		switch ($type)
		{
			case 'null':
			case 'tinyblob':
			case 'mediumblob':
			case 'blob':
			case 'longblob':
				return $value;
				break;
			case 'int':
			case 'smallint':
			case 'tinyint':
			case 'mediumint':
			case 'bigint':
				return intval($value);
				break;
			case 'float':
			case 'decimal':
			case 'double':
			case 'real':
				return floatval($value);
				break;
			case 'string':
			case 'varchar':
			case 'enum':
			case 'set':
			case 'char':
			case 'text':
			case 'tinytext':
			case 'mediumtext':
			case 'longtext':
			case 'date':
			case 'datetime':
			case 'year':
			case 'time':
			case 'timestamp':
			default:
				return $this->escapeStr($value);
				break;
		}
	}
/**
 * Escapes special characters in a string for use in an SQL statement
 *
 * @param string $value The string that is to be escaped.
 * @access public
 * @return string
 */
	public function escapeStr($value)
	{
		return $this->dbo->escapeString($value);
	}
/**
 * Escapes a value.
 *
 * @param string $str
 * @access private
 * @return string
 */
	private function escapeValue($str)
	{
		if (is_string($str) && strlen($str) > 0)
		{
			return "'".$this->escapeStr($str)."'";
		}
		
		if (is_bool($str))
		{
			return ($str === FALSE) ? 0 : 1;
		}

		if (is_numeric($str))
		{
			return $str;
		}
		
		if (is_null($str) || empty($str))
		{
			return 'NULL';
		}
		
		return $str;
	}
/**
 * Executes a prepared statement
 *
 * @param array $params Key/value pairs to replace
 * @access public
 * @return self
 * @example
	$MyModel
		->prepare("SELECT * FROM `myTable` WHERE `password` = :password AND `id` = :id LIMIT 1")
		->exec(array(
			'password' => 'qwerty123456',
			'id' => 32
		));
 */
	public function exec($params=array())
	{
		$sql = $this->statement;
		
		foreach ($params as $key => $value)
		{
			$sql = str_replace(":".$key, $this->escapeValue($value), $sql);
		}
		
		if ($this->arDebug)
		{
			printf('<pre>%s</pre>', $sql);
		}
		
		$special = array('\x00', '\n', '\r', "'", '"', '\x1a', '\\');
		foreach ($special as $str)
		{
			if (strpos($this->statement, $str) !== false)
			{
				trigger_error(sprintf("Illegal string found: <code>%s</code> in: %s", ($str), $this->statement), E_USER_WARNING);
				exit;
			}
		}
		
		if (FALSE !== $this->dbo->query($sql))
		{
			$this->dbo->fetchAssoc();
			$this->data = $this->dbo->getData();
			$this->affectedRows = $this->dbo->affectedRows();
			$this->insertId = $this->dbo->insertId();
		} else {
			die($this->dbo->error());
		}
		
		return $this;
	}
/**
 * Compiles the SELECT ... LIMIT 1 statement based on the other functions called
 * and runs the query
 *
 * @param string $pk
 * @access public
 * @return self
 */
	public function find($pk)
	{
		if ($this->beforeFind())
		{
			$this->arWhere = array();
			$this->arHaving = NULL;
			$this->arIndex = NULL;
			$this->arGroupBy = NULL;
			$this->arOrderBy = NULL;
			$this->arDistinct = FALSE;
			$this
				->limit(1, 0)
				->where("t1.".$this->primaryKey, $pk)
			;
			$sql = $this->buildSelect();
			if ($this->arDebug)
			{
				printf('<pre>%s</pre>', $sql);
			}
			if (FALSE !== $this->dbo->query($sql))
			{
				$this->dbo->fetchAssoc();
				$this->afterFind();
				//$this->_reset();
				
				$this->data = count($this->dbo->getData()) > 0 ? $this->dbo->getData(0) : array();
				$this->setAttributes($this->data);
			} else {
				die($this->dbo->error());
			}
		}
		return $this;
	}
/**
 * Compiles the SELECT statement based on the other functions called
 * and runs the query
 *
 * @access public
 * @return self
 */
	public function findAll()
	{
		if ($this->beforeFind())
		{
			$sql = $this->buildSelect();
			if ($this->arDebug)
			{
				printf('<pre>%s</pre>', $sql);
			}
			if (FALSE !== $this->dbo->query($sql))
			{
				$this->dbo->fetchAssoc();
				$this->afterFind();
				//$this->_reset();
				$this->data = $this->dbo->getData();
			} else {
				die($this->dbo->error());
			}
		}
		return $this;
	}
/**
 * Runs SELECT COUNT(*) statement.
 *
 * @access public
 * @return self
 */
	public function findCount()
	{
		$sql = "";
		
		$sql .= "SELECT COUNT(*) AS `cnt`";
		$sql .= "\n";
		
		$sql .= sprintf("FROM `%s` AS t1", !empty($this->arFrom) ? $this->arFrom : $this->getTable());
		$sql .= "\n";
		
		# Index hint ---
		if (!empty($this->arIndex))
		{
			$sql .= $this->arIndex;
			$sql .= "\n";
		}
		
		# Join ---
		if (count($this->arJoin) > 0)
		{
			$sql .= join("\n", $this->arJoin);
			$sql .= "\n";
		}
		
		# Where ---
		if (is_array($this->arWhere) && count($this->arWhere) > 0)
		{
			$sql .= "WHERE " . join("\n", $this->arWhere);
			$sql .= "\n";
		}
		
		# Group By ---
		if (!empty($this->arGroupBy))
		{
			$sql .= "GROUP BY " . $this->arGroupBy;
			$sql .= "\n";
		}
		
		# Having ---
		if (!empty($this->arHaving))
		{
			$sql .= "HAVING " . $this->arHaving;
			$sql .= "\n";
		}
		
		# Fix for Group By queries ---
		if (!empty($this->arGroupBy))
		{
			$sql = sprintf("SELECT COUNT(*) AS `cnt` FROM (%s) AS `tmp`", $sql);
			$sql .= "\n";
		}
		
		$sql .= "LIMIT 1";
		if ($this->arDebug)
		{
			printf('<pre>%s</pre>', $sql);
		}
		if (FALSE !== $this->dbo->query($sql))
		{
			$this->dbo->fetchRow();
			//$this->_reset();
			$this->data = $this->dbo->getData(0);
		} else {
			die($this->dbo->error());
		}
		return $this;
	}
/**
 * Set FROM clause.
 *
 * @param string $table Table name
 * @param boolean $escape Whether to escape the $table
 * @access public
 * @return self
 */
	public function from($table, $escape=TRUE)
	{
		if ((bool) $escape === TRUE)
		{
			$this->arFrom = $this->escapeStr($table);
		} else {
			$this->arFrom = $table;
		}
		return $this;
	}
/**
 * Get number of affected rows in previous MySQL operation.
 *
 * @access public
 * @return int
 */
	public function getAffectedRows()
	{
		return $this->affectedRows;
	}
/**
 * Get association types.
 *
 * @access public
 * @return array
 */
	public function getAssocTypes()
	{
		return $this->assocTypes;
	}
/**
 * Get active record attributes (key/value pairs).
 *
 * @access public
 * @return array
 */
	public function getAttributes()
	{
		$attr = array();
		foreach ($this->schema as $field)
		{
			$attr[$field['name']] = NULL;
			if (isset($this->arData[$field['name']]))
			{
				$attr[$field['name']] = $this->arData[$field['name']];
			}
		}
		return $attr;
	}
/**
 * Get schema column type.
 *
 * @param string $column
 * @access public
 * @return string|false
 */
	public function getColumnType($column)
	{
		foreach ($this->schema as $col)
		{
			if ($col['name'] == $column)
			{
				return $col['type'];
			}
		}
		return false;
	}
/**
 * Runs a SHOW COLUMNS query.
 *
 * @access public
 * @return self
 */
	public function getColumns()
    {
    	$this
    		->prepare(sprintf("SHOW COLUMNS FROM `%s`", $this->getTable()))
    		->exec();
		return $this;
    }
/**
 * Get the result data from SELECT statements.
 *
 * @access public
 * @return array
 */
	public function getData()
	{
		return $this->data;
	}
/**
 * Get a slice from the result data
 *
 * @param int $offset
 * @param int $length
 * @param boolean $preserve_keys
 * @access public
 * @return array
 */
	public function getDataSlice($offset, $length=NULL, $preserve_keys=FALSE)
	{
		if (is_null($length))
		{
			$length = count($this->data) - $offset;
		}
		return array_slice($this->data, $offset, $length, $preserve_keys);
	}
/**
 * Get a record from the result data
 *
 * @param int $index
 * @access public
 * @return array
 */
	public function getDataIndex($index)
	{
		return !empty($this->data) && isset($this->data[$index]) ? $this->data[$index] : FALSE;
	}
/**
 * Get custom version of the result data from SELECT statements.
 *
 * @param string|null $key
 * @param string|null $value
 * @access public
 * @return array
 */
	public function getDataPair($key=NULL, $value=NULL)
	{
		$arr = array();
		foreach ($this->data as $item)
		{
			if ($key !== NULL)
			{
				$arr[$item[$key]] = !is_null($value) ? $item[$value] : $item;
			} else {
				$arr[] = !is_null($value) ? $item[$value] : $item;
			}
		}
		return $arr;
	}
/**
 * Get errors if any.
 *
 * @access public
 * @return array
 */
	public function getErrors()
	{
		return $this->errors;
	}
/**
 * Get i18n field names of current model if any.
 *
 * @access public
 * @return array
 */
	public function getI18n()
	{
		return $this->i18n;
	}
/**
 * Get connection status
 *
 * @access public
 * @return boolean
 */
	public function getInitialized()
	{
		return $this->initialized;
	}
/**
 * Get the ID generated in the last query.
 *
 * @access public
 * @return int|false
 */
	public function getInsertId()
	{
		return $this->insertId;
	}
/**
 * Get mysql result resource
 *
 * @access public
 * @return resource|object|false
 */
	public function getResult()
	{
		return $this->dbo->getResult();
	}
/**
 * Get associated model schema
 *
 * @access public
 * @return array
 */
	public function getSchema()
	{
		return $this->schema;
	}
/**
 * Get table name.
 *
 * @access public
 * @return string
 */
	public function getTable()
	{
		return $this->prefix . $this->scriptPrefix . $this->table;
	}
/**
 * Sets the GROUP BY value.
 *
 * @param string $group
 * @param boolean $escape
 * @access public
 * @return self
 */
	public function groupBy($group, $escape=TRUE)
	{
		if ((bool) $escape === TRUE)
		{
			$this->arGroupBy = $this->escapeStr($group);
		} else {
			$this->arGroupBy = $group;
		}
		return $this;
	}
/**
 * Check if column name exists in model's schema.
 *
 * @param string $columnName
 * @access public
 * @return boolean
 */
	public function hasColumn($columnName)
	{
		foreach ($this->schema as $field)
		{
			if ($field['name'] == $columnName)
			{
				return true;
			}
		}
		return false;
	}
/**
 * Check if operator is allowed.
 *
 * @param string $str
 * @access private
 * @return boolean
 */
	private function hasOperator($str)
	{
		$str = trim($str);
		if (!preg_match("/(\s|<|>|!|=|IS NULL|IS NOT NULL)/i", $str))
		{
			return FALSE;
		}
		return TRUE;
	}
/**
 * Sets the HAVING values.
 *
 * @param string $val
 * @param boolean $escape
 * @access public
 * @return self
 */
	public function having($val, $escape=TRUE)
	{
		if ((bool) $escape === TRUE)
		{
			$this->arHaving = $this->escapeStr($val);
		} else {
			$this->arHaving = $val;
		}
		return $this;
	}
/**
 * USE INDEX (`foreign_id`)
 * FORCE INDEX (`foreign_id`)
 * IGNORE INDEX (`foreign_id`)
 *
 * @param string $val
 * @return self
 */
	public function index($val, $escape=TRUE)
	{
		if ((bool) $escape === TRUE)
		{
			$this->arIndex = $this->escapeStr($val);
		} else {
			$this->arIndex = $val;
		}
		
		return $this;
	}
/**
 * Compiles an insert string and runs the query.
 *
 * @access public
 * @return self
 */
	public function insert()
	{
		if ($this->beforeSave('insert'))
		{
			$save = $this->buildSave('insert');
			
			if (count($save) > 0)
			{
				$sql = sprintf("INSERT IGNORE INTO `%s` SET %s;", $this->getTable(), join(",", $save));
				if ($this->arDebug)
				{
					printf('<pre>%s</pre>', $sql);
				}
				if (FALSE !== $this->dbo->query($sql))
				{
					$this->affectedRows = $this->dbo->affectedRows();
					if ($this->getAffectedRows() === 1)
					{
						$this->insertId = $this->dbo->insertId();
						$this->afterSave('insert');
					}
				} else {
					die($this->dbo->error());
				}
			}
		}
		return $this;
	}
/**
 * @param array $value
 * @access public
 * @return self
 */
	public function setBatchFields($value)
	{
		if (is_array($value))
		{
			$this->arBatchFields = $value;
		}
		
		return $this;
	}
/**
 * @param array $value
 * @access public
 * @return self
 */
	public function addBatchRow($value)
	{
		if (is_array($value))
		{
			$this->arBatch[] = $value;
		}
		
		return $this;
	}
/**
 * @param array $value
 * @access public
 * @return self
 */
	public function setBatchRows($value)
	{
		if (is_array($value))
		{
			$this->arBatch = $value;
		}
		
		return $this;
	}
/**
 * @access private
 * @return array
 */
	private function buildBatch()
	{
		$save = array();
		
		$i = 0;
		foreach ($this->arBatch as $item)
		{
			foreach ($item as $k => $v)
			{
				$item[$k] = preg_match('/^:[a-zA-Z]{1}.*/', $v) ?
					substr($v, 1) :
					$this->escapeValue($v);
			}
			
			$save[$i] = sprintf("(%s)", join(",", $item));
			$i++;
		}
		
		return $save;
	}
/**
 * Compiles batch insert strings and runs the queries.
 *
 * @access public
 * @return self
 */
	public function insertBatch()
	{
		if ($this->beforeSave('insertBatch'))
		{
			$save = $this->buildBatch();
			
			if (!empty($save))
			{
				$sql = sprintf("INSERT IGNORE INTO `%s` (`%s`) VALUES %s;", $this->getTable(), join("`, `", $this->arBatchFields), join(",", $save));
				if ($this->arDebug)
				{
					printf('<pre>%s</pre>', $sql);
				}
				if (FALSE !== $this->dbo->query($sql))
				{
					$this->affectedRows = $this->dbo->affectedRows();
					if ($this->getAffectedRows() > 0)
					{
						$this->afterSave('insertBatch');
					}
				} else {
					die($this->dbo->error());
				}
			}
		}
		return $this;
	}
/**
 * Generates the JOIN portion of the query
 *
 * @param string $modelName
 * @param string $cond
 * @param string $type
 * @access public
 * @return self
 */
	public function join()
	{
		$args = func_get_args();
		switch (func_num_args())
		{
			case 1:
				$this->arJoin[] = $args[0];
				return $this;
				break;
			case 2:
				$modelName = $args[0];
				$cond = $args[1];
				$type = NULL;
				$index = NULL;
				break;
			case 3:
				$modelName = $args[0];
				$cond = $args[1];
				$type = $args[2];
				$index = NULL;
				break;
			case 4:
				$modelName = $args[0];
				$cond = $args[1];
				$type = $args[2];
				$index = $args[3];
				break;
			default:
				throw new Exception('Number of arguments not supported.');
		}
		
		if (!is_null($type))
		{
			$type = strtoupper(trim($type));

			if (!in_array($type, $this->joinArr))
			{
				$type = '';
			} else {
				$type .= ' ';
			}
		}
		
		if (!is_null($index))
		{
			if (!preg_match('/^\s*(USE|FORCE|IGNORE)\s+(INDEX|KEY)/', $index))
			{
				$index = NULL;
			} else {
				$index = ' ' . $this->escapeStr($index);
			}
		}

		if (preg_match('/([\w\.]+)([\W\s]+)(.+)/', $cond, $match))
		{
			$cond = $match[1].$match[2].$match[3];
		}
		$className = $modelName . 'Model';
		if (class_exists($className))
		{
			$model = new $className;
		}
		if (isset($model) && is_object($model))
		{
			$join = $type.'JOIN '. $model->getTable() .' AS t'.(count($this->arJoin) + 2).$index.' ON '.$cond;
			$this->arJoin[] = $join;
		}
		return $this;
	}
/**
 * Sets the LIMIT value.
 *
 * @param int $rowCount
 * @param int $offset
 * @access public
 * @return self
 */
	public function limit($row_count, $offset=NULL)
	{
		$this->arRowCount = (int) $row_count;
		if (!is_null($offset))
		{
			$this->arOffset = (int) $offset;
		}
		
		return $this;
	}
/**
 * Compiles an update string and runs the query.
 *
 * @param array $data
 * @access public
 * @return self
 */
	public function modify($data=array())
	{
		if ($this->beforeSave('modify'))
		{
			$data[$this->primaryKey] = $this->arData[$this->primaryKey];
			$this->setAttributes($data);
			$update = $this->buildSave();
	
			if (count($update) > 0)
			{
				$sql = sprintf("UPDATE `%s` SET %s WHERE `%s` = '%s' LIMIT 1", $this->getTable(), join(", ", $update), $this->primaryKey, $this->arData[$this->primaryKey]);
				if ($this->arDebug)
				{
					printf('<pre>%s</pre>', $sql);
				}
				if (FALSE !== $this->dbo->query($sql))
				{
					$this->affectedRows = $this->dbo->affectedRows();
					if ($this->getAffectedRows() === 1)
					{
						$this->afterSave('modify');
					}
				} else {
					die($this->dbo->error());
				}
			}
		}
		return $this;
	}
/**
 * Compiles an update string and runs the query. Allow update over multiple records.
 *
 * @param array $data
 * @access public
 * @return self
 */
	public function modifyAll($data=array())
	{
		if ($this->beforeSave('modifyAll'))
		{
			$this->setAttributes($data);
			$update = $this->buildSave();
			
			if (count($update) > 0)
			{
				$sql = sprintf("UPDATE `%s` SET %s", $this->getTable(), join(",", $update));
				$sql .= "\n";
				
				if (is_array($this->arWhere) && count($this->arWhere) > 0)
				{
					$sql .= "WHERE " . join("\n", $this->arWhere);
					$sql .= "\n";
				}
				
				if (!empty($this->arOrderBy))
				{
					$sql .= "ORDER BY " . $this->arOrderBy;
					$sql .= "\n";
				}
				
				if ((int) $this->arRowCount > 0)
				{
					$sql .= "LIMIT " . (int) $this->arRowCount;
				}
				
				if ($this->arDebug)
				{
					printf('<pre>%s</pre>', $sql);
				}
				if (FALSE !== $this->dbo->query($sql))
				{
					$this->affectedRows = $this->dbo->affectedRows();
					$this->afterSave('modifyAll');
				} else {
					die($this->dbo->error());
				}
			}
		}
		return $this;
	}
/**
 * Sets the OFFSET value
 *
 * @param int $offset
 * @access public
 * @return self
 */
	public function offset($offset)
	{
		$this->arOffset = (int) $offset;
		return $this;
	}
/**
 * Sets the ORDER BY value.
 *
 * @param string $order
 * @param boolean $escape
 * @access public
 * @return self
 */
	public function orderBy($order, $escape=TRUE)
	{
		if ((bool) $escape === TRUE)
		{
			$this->arOrderBy = $this->escapeStr($order);
		} else {
			$this->arOrderBy = $order;
		}
		return $this;
	}
/**
 * Generates the WHERE portion of the query. Separates
 * multiple calls with OR
 *
 * @param string $key The field to search
 * @param string $value The values searched on
 * @param boolean $escape Whether to escape the $value
 * @access public
 * @return self
 */
	public function orWhere($key, $value = NULL, $escape = TRUE)
	{
		return $this->setWhere($key, $value, 'OR', $escape);
	}
/**
 * Generates a WHERE field IN ('item', 'item') SQL query joined with
 * OR if appropriate
 *
 * @param string $key The field to search
 * @param array $values The values searched on
 * @access public
 * @return self
 */
	public function orWhereIn($key = NULL, $values = NULL)
	{
		return $this->setWhereIn($key, $values, FALSE, 'OR');
	}
/**
 * Generates a WHERE field NOT IN ('item', 'item') SQL query joined
 * with OR if appropriate
 *
 * @param string $key The field to search
 * @param array $values The values searched on
 * @access public
 * @return self
 */
	public function orWhereNotIn($key = NULL, $values = NULL)
	{
		return $this->setWhereIn($key, $values, TRUE, 'OR');
	}
/**
 * Prepare an SQL statement for execution. Use before 'exec' method.
 *
 * @param string $statement
 * @access public
 * @return self
 */
	public function prepare($statement)
	{
		$this->statement = $statement;
		return $this;
	}
/**
 * Release savepoint a transaction.
 *
 * @param string $identifier
 * @access public
 * @return boolean
 */
	public function releaseSavepoint($identifier)
	{
		if ($this->transactionStarted && $this->prepare("RELEASE SAVEPOINT " . $identifier)->exec()->dbo->getResult())
		{
			return true;
		}
		return false;
	}
/**
 * Empties the active record cache
 *
 * @access public
 * @return self
 */
	public function reset()
	{
		$this->arBatch = array();
		$this->arBatchFields = array();
		$this->arData = array();
		$this->arDebug = FALSE;
		$this->arDistinct = FALSE;
		$this->arFrom = NULL;
		$this->arGroupBy = NULL;
		$this->arHaving = NULL;
		$this->arIndex = NULL;
		$this->arJoin = array();
		$this->arOffset = NULL;
		$this->arOrderBy = NULL;
		$this->arRowCount = NULL;
		$this->arSelect = array();
		$this->arWhere = array();
		$this->arWhereIn = array();
		$this->data = array();
		$this->statement = NULL;
		return $this;
	}
/**
 * Rollback a transaction.
 *
 * @access public
 * @return boolean
 */
	public function rollback()
	{
		if ($this->transactionStarted && $this->prepare("ROLLBACK")->exec()->dbo->getResult())
		{
			$this->transactionStarted = false;
			return true;
		}
		return false;
	}
/**
 * Rollback to savepoint a transaction.
 *
 * @access public
 * @return boolean
 */
	public function rollbackToSavepoint($identifier)
	{
		if ($this->transactionStarted && $this->prepare("ROLLBACK TO SAVEPOINT " . $identifier)->exec()->dbo->getResult())
		{
			return true;
		}
		return false;
	}
/**
 * Savepoint a transaction.
 *
 * @param string $identifier
 * @access public
 * @return boolean
 */
	public function savepoint($identifier)
	{
		if ($this->transactionStarted && $this->prepare("SAVEPOINT " . $identifier)->exec()->dbo->getResult())
		{
			return true;
		}
		return false;
	}
/**
 * Generates the SELECT portion of the query.
 *
 * @param string|array $fields
 * @access public
 * @return self
 */
	public function select($fields="*")
	{
		if (is_string($fields))
		{
			$fields = explode(",", $fields);
		}
		foreach ($fields as $field)
		{
			$field = trim($field);
			if (!empty($field))
			{
				$this->arSelect[] = $field;
			}
		}
		return $this;
	}
/**
 * The "set" function.
 *
 * @param string $key
 * @param string $value
 * @access public
 * @return self
 */
	public function set($key, $value)
	{
		foreach ($this->schema as $field)
		{
			if ($field['name'] == $key)
			{
				$this->arData[$field['name']] = $value;
				break;
			}
		}
		return $this;
	}
/**
 * Set object data attributes.
 *
 * @param array $attr Key/value pairs to be set for inserting or updating
 * @access public
 * @return self
 */
	public function setAttributes($attr)
	{
		$this->arData = array();
		foreach ($this->schema as $field)
		{
			if (isset($attr[$field['name']]))
			{
				$this->arData[$field['name']] = $attr[$field['name']];
			}
		}
		return $this;
	}
/**
 * Set table prefix.
 *
 * @param string $prefix
 * @access public
 * @return self
 */
	public function setPrefix($prefix)
	{
		$this->prefix = $prefix;
		return $this;
	}
/**
 * Set table name.
 *
 * @param string $tblName
 * @access public
 * @return self
 */
	public function setTable($tblName)
	{
		$this->table = $tblName;
		return $this;
	}
/**
 * Called by 'orWhere', 'where' methods
 *
 * @param string|array $key The field to search
 * @param string $value The value searched on
 * @param string $type
 * @param boolean $escape Whether to escape the value
 * @access private
 * @return self
 */
	private function setWhere($key, $value = NULL, $type = 'AND', $escape = TRUE)
	{
		if (!is_array($key))
		{
			$key = array($key => $value);
		}

		foreach ($key as $k => $v)
		{
			$operator = count($this->arWhere) === 0 ? NULL : $type;
			
			if (is_null($v) && ! $this->hasOperator($k))
			{
				$k .= ' IS NULL';
			}
			
			if (!is_null($v))
			{
				if ($escape)
				{
					$v = $this->escapeValue($v);
				}
				
				if (!$this->hasOperator($k))
				{
					$k .= ' =';
				}
			}
			
			$this->arWhere[] = sprintf("%s %s %s", $operator, $k, $v);
		}
		return $this;
	}
/**
 * Called by 'whereIn', 'whereNotIn', 'orWhereIn', 'orWhereNotIn' methods
 *
 * @param string $key The field to search
 * @param string|array $values The values searched on
 * @param boolean $not If the statement would be IN or NOT IN
 * @param string $type
 * @access private
 * @return self
 */
	private function setWhereIn($key = NULL, $values = NULL, $not = FALSE, $type = 'AND')
	{
		if ($key === NULL || $values === NULL)
		{
			return;
		}

		if (!is_array($values))
		{
			$values = array($values);
		}

		$not = ($not) ? ' NOT' : NULL;

		foreach ($values as $value)
		{
			$this->arWhereIn[] = $this->escapeValue($value);
		}

		$operator = (count($this->arWhere) == 0) ? NULL : $type;
		$whereIn = $operator . " " . $key . $not . " IN (" . join(", ", $this->arWhereIn) . ") ";

		$this->arWhere[] = $whereIn;
		$this->arWhereIn = array();
		return $this;
	}
/**
 * Iterate over result data and split a string by string
 *
 * @param string $key Column name or alias
 * @param string $separator The boundary string
 * @param string $newKey
 * @access public
 * @return self
 */
	public function toArray($key, $separator = "|", $newKey=NULL)
	{
		$data = $this->getData();
		foreach ($this->data as $k => $v)
		{
			if (is_array($v) && is_numeric($k))
			{
				foreach ($v as $_k => $_v)
				{
					if ($_k == $key)
					{
						$_v = is_null($_v) ? '' : $_v;
						$this->data[$k][is_null($newKey) ? $key : $newKey] = strpos($_v, $separator) !== FALSE ? explode($separator, $_v) : (strlen($_v) > 0 ? array($_v) : array());
						break;
					}
				}
			} else {
				if ($k == $key)
				{
					$v = is_null($v) ? '' : $v;
					$this->data[is_null($newKey) ? $key : $newKey] = strpos($v, $separator) !== FALSE ? explode($separator, $v) : (strlen($v) > 0 ? array($v) : array());
					break;
				}
			}
		}
		
		return $this;
	}
/**
 * Truncate a table. Empties a table completely.
 *
 * @param string $tblName The name of table to truncate if different of current model
 * @access public
 * @return self
 */
	public function truncate($tblName=NULL)
	{
		if ($this->beforeDelete('truncate'))
		{
			$sql = sprintf("TRUNCATE TABLE `%s`;", !empty($tblName) ? $tblName : $this->getTable());
			if ($this->arDebug)
			{
				printf('<pre>%s</pre>', $sql);
			}
			if (FALSE !== $this->dbo->query($sql))
			{
				$this->afterDelete('truncate');
			} else {
				die($this->dbo->error());
			}
		}
		return $this;
	}
/**
 * Validates data.
 *
 * @param array $data
 * @access public
 * @return boolean
 */
	public function validates($data)
	{
		foreach ($this->schema as $field)
		{
			if (isset($this->validate['rules']) && isset($this->validate['rules'][$field['name']]))
			{
				$rule = $this->validate['rules'][$field['name']];
				if (is_array($rule))
				{
					foreach ($rule as $ruleName => $ruleValue)
					{
						if (is_array($ruleValue))
						{
							$rule = $ruleValue;
							array_shift($rule);
							$param_arr = array_merge(array(@$data[$field['name']]), $rule);
							if (!call_user_func_array(array('pjValidation', $ruleValue[0]), $param_arr))
							{
								$this->errors[] = array('field' => $field['name'], 'value' => @$data[$field['name']]);
							}
						} else {
							if (!pjValidation::$ruleName(@$data[$field['name']]) == $ruleValue) {
								$this->errors[] = array('field' => $field['name'], 'value' => @$data[$field['name']]);
							}
						}
					}
				} else {
					if (!pjValidation::$rule(@$data[$field['name']]))
					{
						$this->errors[] = array('field' => $field['name'], 'value' => @$data[$field['name']]);
					}
				}
			}
		}
		return count($this->errors) === 0;
	}
/**
 * Generates the WHERE portion of the query. Separates multiple calls with AND
 *
 * @param string $key The field to search
 * @param string $value The values searched on
 * @param boolean $escape Whether to escape the $value
 * @access public
 * @return self
 */
	public function where($key, $value = NULL, $escape = TRUE)
	{
		return $this->setWhere($key, $value, 'AND', $escape);
	}
/**
 * Generates a WHERE field IN ('item', 'item') SQL query joined with AND if appropriate
 *
 * @param string $key The field to search
 * @param string|array $values The values searched on
 * @access public
 * @return self
 */
	public function whereIn($key = NULL, $values = NULL)
	{
		return $this->setWhereIn($key, $values);
	}
/**
 * Generates a WHERE field NOT IN ('item', 'item') SQL query joined with AND if appropriate
 *
 * @param string $key The field to search
 * @param string|array $values The values searched on
 * @access public
 * @return self
 */
	public function whereNotIn($key = NULL, $values = NULL)
	{
		return $this->setWhereIn($key, $values, TRUE);
	}
/**
 * Encrypt given data
 *  
 * @param string $str String to be encrypted
 * @access public
 * @return string
 */
	public function aesEncrypt($str)
	{
		if (!defined("PJ_USE_IV") || !PJ_USE_IV)
		{
			return sprintf("AES_ENCRYPT(%s, %s)", $this->escapeValue($str), $this->escapeValue(PJ_SALT));
		}

		return sprintf("AES_ENCRYPT(%s, %s, %s)", $this->escapeValue($str), $this->escapeValue(PJ_SALT), $this->escapeValue(md5(PJ_SALT)));
	}
/**
 * Decrypt value of the given column
 * 
 * @param string $column_name The value of that column will be decrypted
 * @access public
 * @return string
 */
	public function aesDecrypt($column_name)
	{
		if (!defined("PJ_USE_IV") || !PJ_USE_IV)
		{
			return sprintf("AES_DECRYPT(t1.%s, %s)", $column_name, $this->escapeValue(PJ_SALT));
		}

		return sprintf("AES_DECRYPT(t1.%s, %s, %s)", $column_name, $this->escapeValue(PJ_SALT), $this->escapeValue(md5(PJ_SALT)));
	}
}
?>