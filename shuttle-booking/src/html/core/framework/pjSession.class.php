<?php
if (!defined("ROOT_PATH"))
{
    header("HTTP/1.1 403 Forbidden");
    exit;
}
class pjSession
{
    public $sessionData;
    
    public function __construct()
    {
        $this->sessionData =& $_SESSION;
    }
    
    
    /**
     * Set Session data
     *
     * @param	mixed	$data	Session data key or an associative array
     * @param	mixed	$value	Value to store
     * @return	void
     */
    public function setData($data, $value = NULL)
    {
        if (is_array($data))
        {
            foreach ($data as $key => &$value)
            {
                $_SESSION[$key] = $value;
            }
            
            return;
        }
        
        $_SESSION[$data] = $value;
    }
    
    /**
     * Unset Session data by key
     *
     * @param	mixed	$key	Session data key(s)
     * @return	void
     */
    public function unsetData($key)
    {
        if (is_array($key))
        {
            foreach ($key as $k)
            {
                unset($_SESSION[$k]);
            }
            
            return;
        }
        
        unset($_SESSION[$key]);
    }
    
    /**
	 * Check Session key exists of not
	 *
	 * @param	string	$key	Session data key
	 * @return	bool
	 */
    public function has($key)
    {
        return isset($_SESSION[$key]);
    }
    
    /**
     * Get all Session data
     * 
     * @return mixed
     */
    public function getAll()
    {
        return $this->sessionData;
    }
    
    /**
     * Get Session data by key
     *
     * @param	string	$key	Session data key
     * @return	mixed	Session data value or NULL if not found
     */
    public function getData($key = NULL)
    {
        if (isset($key))
        {
            return isset($_SESSION[$key]) ? $_SESSION[$key] : NULL;
        }
        elseif (empty($_SESSION))
        {
            return array();
        }
    }
    
    /**
     * Session destroy
     *
     * @return	void
     */
    public function destroy()
    {
        session_destroy();
    }
    
    /**
     * Mark as flash
     *
     * @param	mixed	$key	Session data key(s)
     * @return	bool
     */
    public function markAsFlash($key)
    {
        if (is_array($key))
        {
            for ($i = 0, $c = count($key); $i < $c; $i++)
            {
                if ( ! isset($_SESSION[$key[$i]]))
                {
                    return FALSE;
                }
            }
            
            $new = array_fill_keys($key, 'new');
            
            $_SESSION['__pj_vars'] = isset($_SESSION['__pj_vars'])
            ? array_merge($_SESSION['__pj_vars'], $new)
            : $new;
            
            return TRUE;
        }
        
        if ( ! isset($_SESSION[$key]))
        {
            return FALSE;
        }
        
        $_SESSION['__pj_vars'][$key] = 'new';
        return TRUE;
    }
    
    /**
     * Set flashData
     *
     * @param	mixed	$data	Session data key or an associative array
     * @param	mixed	$value	Value to store
     * @return	void
     */
    public function setFlashData($data, $value = NULL)
    {
        $this->setData($data, $value);
        $this->markAsFlash(is_array($data) ? array_keys($data) : $data);
    }
    
    /**
     * Get flash keys
     *
     * @return	array
     */
    public function getFlashKeys()
    {
        if ( ! isset($_SESSION['__pj_vars']))
        {
            return array();
        }
        
        $keys = array();
        foreach (array_keys($_SESSION['__pj_vars']) as $key)
        {
            is_int($_SESSION['__pj_vars'][$key]) OR $keys[] = $key;
        }
        
        return $keys;
    }
    
    /**
     * Unmark flash
     *
     * @param	mixed	$key	Session data key(s)
     * @return	void
     */
    public function unmarkFlash($key)
    {
        if (empty($_SESSION['__pj_vars']))
        {
            return;
        }
        
        is_array($key) OR $key = array($key);
        
        foreach ($key as $k)
        {
            if (isset($_SESSION['__pj_vars'][$k]) && ! is_int($_SESSION['__pj_vars'][$k]))
            {
                unset($_SESSION['__pj_vars'][$k]);
            }
        }
        
        if (empty($_SESSION['__pj_vars']))
        {
            unset($_SESSION['__pj_vars']);
        }
    }
    
    /**
     * Flashdata (fetch)
     *
     *
     * @param	string	$key	Session data key
     * @return	mixed	Session data value or NULL if not found
     */
    public function flashData($key = NULL)
    {
        if (isset($key))
        {
            if((isset($_SESSION['__pj_vars'], $_SESSION['__pj_vars'][$key], $_SESSION[$key]) && ! is_int($_SESSION['__pj_vars'][$key]) && $_SESSION['__pj_vars'][$key] == 'new'))
            {
                $_SESSION['__pj_vars'][$key] = 'old';
                return $_SESSION[$key];
            }else{
                return NULL;
            }
        }
        
        $flashData = array();
        
        if ( ! empty($_SESSION['__pj_vars']))
        {
            foreach ($_SESSION['__pj_vars'] as $key => &$value)
            {
                if($value == 'new')
                {
                    is_int($value) OR $flashData[$key] = $_SESSION[$key];
                    $_SESSION['__pj_vars'][$key] = 'old';
                }
            }
        }
        
        return $flashData;
    }
}
?>