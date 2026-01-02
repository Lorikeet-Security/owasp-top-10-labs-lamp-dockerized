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
 * MySQL DBO driver object
 *
 * Provides connection and SQL generation for MySQL RDMS
 *
 * @package framework
 * @since 1.0.0
 */
class pjMysqlDriver extends pjDbDriver
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
	protected $driver = 'mysql';
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
		return mysql_affected_rows();
	}
/**
 * Open a connection to a MySQL Server
 *
 * Opens or reuses a connection to a MySQL server.
 *
 * @access public
 * @return resource|false Returns a MySQL link identifier on success or FALSE on failure.
 */
	public function connect()
	{
		if ($this->persistent)
		{
			$this->connectionId = @mysql_pconnect(is_null($this->socket) ? ($this->hostname . (!is_null($this->port) ? ":" . $this->port : NULL)) : $this->hostname . ":" . $this->socket, $this->username, $this->password);
		} else {
			$this->connectionId = @mysql_connect(is_null($this->socket) ? ($this->hostname . (!is_null($this->port) ? ":" . $this->port : NULL)) : $this->hostname . ":" . $this->socket, $this->username, $this->password);
		}
		
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
		return $this->error();
	}
/**
 * Returns the text of the error message from previous MySQL operation
 *
 * @access public
 * @return string Returns the error text from the last MySQL function, or '' (empty string) if no error occurred.
 */
	public function error()
	{
		return mysql_error($this->connectionId !== false ? $this->connectionId : NULL);
	}
/**
 * Escapes special characters in a string for use in an SQL statement
 *
 * @param string $value The string that is to be escaped
 * @access public
 * @return string|false Returns the escaped string, or FALSE on error.
 */
	public function escapeString($value)
    {
    	if (get_magic_quotes_gpc())
    	{
    		$value = stripslashes($value);
    	}
    	return function_exists('mysql_real_escape_string') ? mysql_real_escape_string($value) : mysql_escape_string($value);
    }
/**
 * Fetch a result row as an associative array, a numeric array, or both
 *
 * @access public
 * @return self
 */
    public function fetchArray()
    {
    	if (is_resource($this->result) && $this->result instanceof GdImage)
    	{
    		$this->data = array();
    		while ($row = mysql_fetch_array($this->result))
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
    	if (is_resource($this->result) && $this->result instanceof GdImage)
    	{
    		$this->data = array();
    		while ($row = mysql_fetch_assoc($this->result))
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
    	if (is_resource($this->result) && $this->result instanceof GdImage)
    	{
    		$this->data = array();
    		$this->data = mysql_fetch_row($this->result);
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
    	if (is_resource($this->result) && $this->result instanceof GdImage)
    	{
    		return mysql_free_result($this->result);
    	}
    	return false;
    }
/**
 * Get the ID generated in the last query
 *
 * @access public
 * @return int|false The ID generated for an AUTO_INCREMENT column by the previous query on success, 0 if the previous query does not generate an AUTO_INCREMENT value, or <b>FALSE</b> if no MySQL connection was established.
 */
	public function insertId()
	{
		return mysql_insert_id();
	}
/**
 * Get number of rows in result
 *
 * @access public
 * @return int|false The number of rows in a result set on success or <b>FALSE</b> on failure.
 */
	public function numRows()
	{
		if (is_resource($this->result) && $this->result instanceof GdImage)
		{
			return @mysql_num_rows($this->result);
		}
		return false;
	}
/**
 * Send a MySQL query
 *
 * @param string $query
 * @access public
 * @return resource Returns <b>FALSE</b> on failure. For successful `SELECT`, `SHOW`, `DESCRIBE` or `EXPLAIN` queries will return a mysqli_result object. For other successful queries will return <b>TRUE</b>.
 */
	public function query($query)
	{
		$this->result = mysql_query($query, $this->connectionId);
				
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
		return mysql_select_db($this->database, $this->connectionId);
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
			$this->useSetNames = (version_compare(PHP_VERSION, '5.2.3', '>=') && version_compare(mysql_get_server_info($this->connectionId), '5.0.7', '>=')) ? FALSE : TRUE;
		}

		if ($this->useSetNames === TRUE)
		{
			return $this->query("SET NAMES '".$this->escapeString($charset)."' COLLATE '".$this->escapeString($collation)."'");
		} else {
			return @mysql_set_charset($charset, $this->connectionId);
		}
	}
}
?>