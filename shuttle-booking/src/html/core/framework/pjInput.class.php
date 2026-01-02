<?php
if (!defined("ROOT_PATH"))
{
    header("HTTP/1.1 403 Forbidden");
    exit;
}
class pjInput
{
    /**
     * Enable Sanitize clean flag
     *
     * Determines whether the Sanitize Clean is always active when
     * GET or POST data is encountered.
     * Set automatically based on config setting.
     *
     * @var	bool
     */
    protected $_sanitize_clean = FALSE;
    
    /**
     * 
     * Keeping data for method POST
     */
    protected $_pj_post;
    
    /**
     *
     * Keeping data for method GET
     */
    protected $_pj_get;
    
    /**
     *
     * Keep data for method. It will be get or post.
     */
    protected $_method;
    
    public function __construct()
    {
        if(isset($_POST))
        {
            $this->_pj_post = $_POST;
            if( pjRegistry::getInstance()->get('reset_request') == 1)
            {
                $this->reset_default_request($_POST);
            }
        }else{
            $this->_pj_post = array();
        }
        if(isset($_GET))
        {
            $this->_pj_get = $_GET;
            if( pjRegistry::getInstance()->get('reset_request') == 1)
            {
                $this->reset_default_request($_GET);
            }
        }else{
            $this->_pj_get = array();
        }
    }
    
    /**
     * Remove all data from the default $_GET and $_POST
     * 
     * @param array $request
     */
    protected function reset_default_request(& $request)
    {
        foreach($request as $key => & $value)
        {
            if(is_array($value))  
            {
                $this->reset_default_request($value);
            }else{
                $request[$key] = null;
            }
        }
    }
    
    /**
     * Check whether the input value is date format Y-m-d.
     * 
     * @param string $value
     * @return mixed
     */
    protected function checkDate($value)
    {
        $arr = explode("-", $value);
        if(count($arr) == 3)
        {
            if(checkdate( (int) $arr[1], (int) $arr[2] , (int) $arr[0] ))
            {
                return $value;
            }
        }
        return FALSE;
    }
    
    /**
     * Check whether the input value is date format H:i:s.
     *
     * @param string $value
     * @return mixed
     */
    protected function checkTime($value)
    {
        if(preg_match("/(2[0-4]|[01][1-9]|10):([0-5][0-9])/", $value) || preg_match("/(2[0-4]|[01][1-9]|10):([0-5][0-9]):([0-5][0-9])/", $value))
        {
            return $value;
        }else{
            return FALSE;
        }
    }
    
    /**
     * Fetch from array
     *
     * Internal method used to retrieve values from global arrays.
     *
     * @param	array	&$array		$_GET, $_POST
     * @param	mixed	$index		Index for item to be fetched from $array
     * @return	mixed
     */
    protected function _fetch_from_array(&$array, $index = NULL)
    {
        
        // If $index is NULL, it means that the whole $array is requested
        isset($index) OR $index = array_keys($array);
        
        // allow fetching multiple keys at once
        if (is_array($index))
        {
            $output = array();
            foreach ($index as $key)
            {
                $output[$key] = $this->_fetch_from_array($array, $key);
            }
            
            return $output;
        }
        
        if (isset($array[$index]))
        {
            $value = $array[$index];
        }
        elseif (($count = preg_match_all('/(?:^[^\[]+)|\[[^]]*\]/', $index, $matches)) > 1) // Does the index contain array notation
        {
            $value = $array;
            for ($i = 0; $i < $count; $i++)
            {
                $key = trim($matches[0][$i], '[]');
                if ($key === '') // Empty notation will return the value as array
                {
                    break;
                }
                
                if (isset($value[$key]))
                {
                    $value = $value[$key];
                }
                else
                {
                    return NULL;
                }
            }
        }
        else
        {
            return NULL;
        }
        return $value;
    }

    /**
     * Set the current method the class will execute for.
     * @param string $method
     * @return pjInput
     */
    public function setMethod($method)
    {
        $this->_method = $method;
        return $this;
    }
    
    /**
     * Fetch an item from the GET array
     *
     * @param mixed $index Index for item to be fetched from $_GET/$_POST
     * @return mixed
     */
    public function raw($index=null)
    {
    	if ($this->_method == 'post')
    	{
    		return $this->_fetch_from_array($this->_pj_post, $index);
    	} else {
    		return $this->_fetch_from_array($this->_pj_get, $index);
    	}
    }
    
    /**
     * Fetch an String item from GET/POST array
     *
     * @param string $index
     * @return mixed
     */
    public function toString($index)
    {
        $value = $this->raw($index);
        
        return $value != NULL ? strval($value) : FALSE;
    }
    
    /**
     * Check whether POST/GET with key $index exists or not.
     *
     * @param mixed $index
     * @return boolean
     */
    public function check($index = NULL)
    {
    	if (empty($index))
    	{
    		return false;
    	}

    	if ($this->_method == 'post')
    	{
    		return isset($this->_pj_post[$index]);
    	}
    	
    	if ($this->_method == 'get')
    	{
   			return isset($this->_pj_get[$index]);
    	}
    	
    	return false;
    }
    
    /**
     * Check if given index isset in POST/GET. Works only for multi-dimensional arrays!
     * 
     * @param string $index
     * @return boolean
     * @example $this->checkMulti('[pjBaseMultiLang][content][0]') is equivalent of isset($_POST[pjBaseMultiLang][content][0])
     */
    public function checkMulti($index)
    {
    	if (!preg_match_all('/\[\b\w+\b\]/U', $index, $matches))
    	{
    		return false;
    	}
    	
    	$levels = $matches[0];
    	foreach ($levels as &$item)
    	{
    		$item = trim($item, '[]');
    	}
    	
    	$result = array();
    	$arr = $this->_method == 'post' ? $this->_pj_post : $this->_pj_get;
    	foreach ($levels as $idx)
    	{
   			if (!isset($arr[$idx]))
   			{
   				$result[] = false;
   				break;
   			}
   			$result[] = true;
   			$arr = $arr[$idx];
    	}
    	
    	return !in_array(false, $result);
    }
    
    /**
     * Determine if a variable is set and is not NULL. This also work for elements in arrays. 
     * Accepts arbitrary length of arguments.
     * 
     * $this->has('x')
     * $this->has('x', 'y', '[a][b][c]')
     * 
     * @return boolean
     */
    public function has()
    {
    	if (!func_num_args())
    	{
    		return false;
    	}
    	$args = func_get_args();
    	
    	$result = array();
    	
    	foreach ($args as $arg)
    	{
    		$result[] = !preg_match('/^(\[\b\w+\b\])+$/', $arg)
    			? $this->check($arg)
    			: $this->checkMulti($arg);
    	}
    	
    	return !in_array(false, $result);
    }
    
    public function isEmpty($index)
    {
    	$value = $this->raw($index);
   		
   		return empty($value);
    }
    
    /**
     * Unset key $index from POST/GET if exists.
     *
     * @param mixed $index
     * @return pjInput
     */
    public function remove($index)
    {
        if($this->_method == 'post')
        {
            if($this->check($index))
            {
                unset($this->_pj_post[$index]);
            }
        }else{
            if($this->check($index))
            {
                unset($this->_pj_get[$index]);
            }
        }
        return $this;
    }
    
	/**
	 * Re-assign values back to $_POST and $_GET variables.
	 *
	 * @return	void
	 */
	public function reassign_post_get()
	{
	    if(!empty($this->_pj_post))
	    {
	        $_POST = $this->_pj_post;
	    }
	    if(!empty($this->_pj_get))
	    {
	        $_GET = $this->_pj_get;
	    }
	}
	
	/**
	 * Fetch an Integer item from GET/POST array
	 * If the data is not integer, it will return 0.
	 *
	 * @param string $index
	 * @return int
	 */
	public function toInt($index)
	{
	    return intval($this->raw($index));
	}
	
	/**
	 * Fetch an Float item from GET/POST array
	 * If the data is not Float, it will return 0.
	 *
	 * @param string $index
	 * @return int
	 */
	public function toFloat($index)
	{
	    return floatval($this->raw($index));
	}
	
	/**
	 * Fetch an item from GET/POST
	 * Type cast as Boolean 
	 * 
	 * @param string $index
	 * @return bool
	 */
	public function toBool($index)
	{
		$value = $this->raw($index);
		settype($value, 'boolean');
		
		return $value;
	}
	
	/**
	 * Fetch an item from GET/POST array and return html entinties content.
	 *
	 * @param string $index
	 * @return mixed
	 */
	public function toHTML($index)
	{
	    $value = $this->raw($index);
	    
	    return $value != NULL ? pjSanitize::html($value) : NULL;
	}
	
	/**
	 * Fetch an item from GET/POST array and return Date in format Y-m-d.
	 * If the value is not valid date in format Y-m-d, it will return FALSE
	 *
	 * @param string $index
	 * @return mixed
	 */
	public function toDate($index)
	{
	    return $this->checkDate($this->raw($index));
	}
	
	/**
	 * Fetch an item from GET/POST array and return Time in format H:i:s.
	 * If the value is not valid date in format H:i:s, it will return FALSE
	 *
	 * @param string $index
	 * @return mixed
	 */
	public function toTime($index)
	{
	    return $this->checkTime($this->raw($index));
	}
	
	/**
	 * Fetch an item from GET/POST array and return Date Time in format Y-m-d H:i:s.
	 * If the value is not valid date in format Y-m-d H:i:s, it will return FALSE
	 *
	 * @param string $index
	 * @return mixed
	 */
	public function toDateTime($index)
	{
	    $value = $this->raw($index);
	    
	    $arr = explode(" ", $value);
	    if(count($arr) == 2)
	    {
	        $date = $this->checkDate(trim($arr[0]));
	        $time = $this->checkTime(trim($arr[1]));
	        if($date !== FALSE && $time !== FALSE)
	        {
	            return $date . ' ' . $time;
	        }
	    }
	    return FALSE;
	}

	/**
	 * Fetch an array from GET/GET array.
	 * If the value is not a valid array, it will return an empty array
	 *
	 * @param string $index
	 * @return array
	 */
	public function toArray($index)
	{
		$value = $this->raw($index);
	    
	    if (is_array($value))
        {
            array_walk_recursive($value, function (&$v, $k) {
                if ($v != NULL)
                {
                    $v = str_replace(array("\r\n", "\r", "\n"),"", trim($v));
                    $v = pjObject::escapeString($v);
                }
            });
            return $value;
        }
        return array();
	}
	
	/**
	 * Fetch an array from POST array which will be used to update pjMultiLang.
	 * If the value is not a valid array, it will return an empty array.
	 *
	 * @param string $index
	 * @return array|string
	 */
	public function toI18n($index)
	{
	    $value = $this->_fetch_from_array($this->_pj_post, $index);
	    if (is_array($value))
        {
            array_walk_recursive($value, function (&$v, $k) {
                if ($v != NULL)
                {
                    $v = trim($v);
                }
            });
            return $value;
        }

        return trim($value);
	}
}
?>