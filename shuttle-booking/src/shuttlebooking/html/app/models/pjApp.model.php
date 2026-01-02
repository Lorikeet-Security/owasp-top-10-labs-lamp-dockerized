<?php
if (!defined("ROOT_PATH"))
{
    header("HTTP/1.1 403 Forbidden");
    exit;
}
class pjAppModel extends pjModel
{
    public static function factory($attr=array())
    {
        return new pjAppModel($attr);
    }
    
    public function validateRequest($required, $data)
    {
        if (!isset($required) || !is_array($required)
            || !isset($data) || !is_array($data))
        {
            return FALSE;
        }
        
        foreach ($required as $index)
        {
            if (!array_key_exists($index, $data))
            {
                return FALSE;
            }
        }
        
        return TRUE;
    }
}
?>