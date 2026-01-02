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
 * MySQLi DBO driver object
 *
 * Provides connection and SQL generation for MySQL RDMS
 *
 * @package framework
 * @since 1.0.11
 */
class pjMysqliDriver extends pjDbDriver
{
/**
 * The full path and filename of the file.
 *
 * @var string
 * @access public
 */
	public $ClassFile = __FILE__;
/**
 * DB driver name
 *
 * @var string
 * @access protected
 */
	protected $driver = 'mysqli';
/**
 * Whether SET NAMES must be used to set the character set
 *
 * @var boolean
 * @access private
 */
	private $useSetNames;
/**
 * Get number of affected rows in previous MySQL operation
 *
 * @access public
 * @return int
 */
	public function affectedRows()
	{
		return mysqli_affected_rows($this->connectionId !== FALSE ? $this->connectionId : NULL);
	}
/**
 * Open a connection to a MySQL Server
 *
 * Opens or reuses a connection to a MySQL server.
 *
 * @access public
 * @return self
 */
	public function connect()
	{
		$this->connectionId = @mysqli_connect(
			$this->hostname,
			$this->username,
			$this->password,
			$this->database,
			!is_null($this->port) ? $this->port : NULL,
			!is_null($this->socket) ? $this->socket : NULL
		);
		
		return $this->connectionId;
	}
/**
 * Returns the text of the error message from previous MySQL operation
 *
 * @access public
 * @return string|null A string that describes the error. NULL is returned if no error occurred.
 */
	public function connectError()
	{
		return mysqli_connect_error();
	}
/**
 * Returns the text of the error message from previous MySQL operation
 *
 * @access public
 * @return string A string that describes the error. An empty string if no error occurred.
 */
	public function error()
	{
		return mysqli_error($this->connectionId);
	}
/**
 * Escapes special characters in a string for use in an SQL statement
 *
 * @param string $value The string that is to be escaped
 * @access public
 * @return string|false Returns the escaped string, or <b>FALSE</b> on error.
 */
	public function escapeString($value)
    {
    	if (defined('PHP_MAJOR_VERSION') && PHP_MAJOR_VERSION < 7){		
        if (get_magic_quotes_gpc())		$value = stripslashes($value);
		}
    	if (function_exists('mysqli_real_escape_string') && is_object($this->connectionId))
    	{
    		return mysqli_real_escape_string($this->connectionId, $value);
    	} elseif (function_exists('mysql_real_escape_string')) {
    		return mysql_real_escape_string($value);
    	} else {
    		trigger_error("Function mysqli_real_escape_string not found.", E_USER_ERROR);
    	}
    }
/**
 * Fetch a result row as an associative array, a numeric array, or both
 *
 * @access public
 * @return self
 */
    public function fetchArray()
    {
    	if (is_object($this->result))
    	{
    		$this->data = array();
    		while ($row = mysqli_fetch_array($this->result))
    		{
				$this->data[] = $row;
    		}
    		$this->freeResult();
    	}
    	return $this;
    }
/**
 * Fetch a result row as an associative array
 *
 * @access public
 * @return self
 */
	public function fetchAssoc()
    {
    	if (is_object($this->result))
    	{
    		$this->data = array();
    		while ($row = mysqli_fetch_assoc($this->result))
    		{
				$this->data[] = $row;
    		}
    		$this->freeResult();
    	}
    	return $this;
    }
/**
 * Get a result row as an enumerated array
 *
 * @access public
 * @return self
 */
	public function fetchRow()
    {
   		if (is_object($this->result))
    	{
    		$this->data = array();
    		$this->data = mysqli_fetch_row($this->result);
    	}
    	return $this;
    }
/**
 * Free result memory
 *
 * @access public
 * @return boolean Returns <b>TRUE</b> on success or <b>FALSE</b> on failure.
 */
    public function freeResult()
    {
    	if (is_object($this->result))
    	{
    		mysqli_free_result($this->result);
    		return TRUE;
    	}
    	return FALSE;
    }
/**
 * Get the ID generated in the last query
 *
 * @access public
 * @return int|false The ID generated for an AUTO_INCREMENT column by the previous query on success, 0 if the previous query does not generate an AUTO_INCREMENT value, or <b>FALSE</b> if no MySQL connection was established.
 */
	public function insertId()
	{
		return mysqli_insert_id($this->connectionId);
	}
/**
 * Get number of rows in result
 *
 * @access public
 * @return int|false The number of rows in a result set on success or <b>FALSE</b> on failure.
 */
	public function numRows()
	{
		if (is_object($this->result))
		{
			return @mysqli_num_rows($this->result);
		}
		return FALSE;
	}
/**
 * Send a MySQL query
 *
 * @param string $query
 * @access public
 * @return object Returns <b>FALSE</b> on failure. For successful `SELECT`, `SHOW`, `DESCRIBE` or `EXPLAIN` queries will return a mysqli_result object. For other successful queries will return <b>TRUE</b>.
 */
	public function query($query)
	{
		$this->result = mysqli_query($this->connectionId, $query);
		
		return $this->result;
	}
/**
 * Select a MySQL database
 *
 * @access public
 * @return boolean Returns <b>TRUE</b> on success or <b>FALSE</b> on failure.
 */
	public function selectDb()
	{
		return mysqli_select_db($this->connectionId, $this->database);
	}
/**
 * Set client character set
 *
 * @param string $charset A valid character set name.
 * @param string $collation A valid collation name.
 * @access protected
 * @return boolean Returns <b>TRUE</b> on success or <b>FALSE</b> on failure.
 */
	protected function setCharset($charset, $collation)
	{
		if (!isset($this->useSetNames))
		{
			$this->useSetNames = version_compare(mysqli_get_server_info($this->connectionId), '5.0.7', '>=') ? FALSE : TRUE;
		}

		if ($this->useSetNames === TRUE)
		{
			return $this->query("SET NAMES '".$this->escapeString($charset)."' COLLATE '".$this->escapeString($collation)."'");
		} else {
			return @mysqli_set_charset($this->connectionId, $charset);
		}
	}
}
?>