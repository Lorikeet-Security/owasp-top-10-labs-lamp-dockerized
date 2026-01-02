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
 * DBO driver object
 *
 * @package framework
 * @since 1.0.11
 */
class pjDbDriver
{
/**
 * The full path and filename of the file.
 *
 * @var string
 * @access public
 */
	public $ClassFile = __FILE__;
/**
 * Client character set
 *
 * @var string
 * @access protected
 */
	protected $charset = 'utf8';
/**
 * Client collation
 *
 * @var string
 * @access protected
 */
	protected $collation = 'utf8_general_ci';
/**
 * Default driver
 *
 * @var string
 * @access protected
 */
	protected $driver = 'mysqli';
/**
 * MySQL link identifier
 *
 * @var resource
 * @access protected
 */
	protected $connectionId = false;
/**
 * An associative or indexed (or both) array of strings that corresponds to the fetched row(s)
 *
 * @var array
 * @access protected
 */
	protected $data = array();
/**
 * The name of the database that is to be selected.
 *
 * @var string
 * @access protected
 */
	protected $database = null;
/**
 * The MySQL server
 *
 * @var string
 * @access protected
 */
	protected $hostname = "localhost";
/**
 * The password.
 *
 * @var string
 * @access protected
 */
	protected $password = null;
/**
 * Flag which tells whether to open a persistent connection to SQL server
 *
 * @var boolean
 * @access protected
 */
	protected $persistent = false;
/**
 * Port number
 *
 * @var int
 * @access protected
 */
	protected $port = "3306";
/**
 * Result resource from last sql query
 *
 * @var resource
 * @access protected
 */
	protected $result;
/**
 * Path to a local socket e.g. ":/path/to/socket" for the localhost.
 *
 * @var string
 * @access protected
 */
	protected $socket = null;
/**
 * The username
 *
 * @var string
 * @access protected
 */
	protected $username = null;
/**
 * Constructor - automatically called when you create a new instance of a class with new
 *
 * @param array $params
 * @access public
 * @return self
 */
	public function __construct($params=array())
	{
		if (is_array($params))
		{
			foreach ($params as $key => $val)
			{
				$this->$key = $val;
			}
		}
	}
/**
 * Get result data from last query
 *
 * @param int|string $index
 * @access public
 * @return array|string
 */
	public function getData($index=NULL)
	{
		return is_null($index) ? $this->data : $this->data[$index];
	}
/**
 * The returned result from last sql query
 *
 * @access public
 * @return resource|object|false
 */
	public function getResult()
	{
		return $this->result;
	}
/**
 * Initialize SQL DBO driver, e.g. open a connection, select database, set charset
 *
 * @access public
 * @return boolean Returns <b>TRUE</b> on success, and <b>FALSE</b> on failure.
 */
	public function init()
	{
		if ((is_resource($this->connectionId) || $this->connectionId instanceof GdImage) || is_object($this->connectionId))
		{
			return TRUE;
		}
		
		if (!$this->connect())
		{
			return FALSE;
		}
		if ($this->database != '' && $this->driver == 'mysql')
		{
			if (!$this->selectDb())
			{
				return FALSE;
			}
		}
		if (!$this->setCharset($this->charset, $this->collation))
		{
			return FALSE;
		}
		
		return TRUE;
	}
}
?>