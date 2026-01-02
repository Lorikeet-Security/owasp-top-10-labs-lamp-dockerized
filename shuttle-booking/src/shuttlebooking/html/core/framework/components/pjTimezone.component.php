<?php
/**
 * PHP Framework
 *
 * @copyright Copyright 2018, PHPJabbets, Ltd.
 * @link      https://www.phpjabbers.com/
 * @package   framework.components
 * @version   2.1.0
 */
/**
 * Timezone class
 *
 * @package framework.components
 * @since 2.0.0
 */
class pjTimezone
{
    /**
     * The Factory pattern allows for the instantiation of objects at runtime.
     *
     * @static
     * @access public
     * @return self
     */
    public static function factory()
    {
        return new pjTimezone();
    }
    
    /**
     * Set the timezone for the server.
     * @access public
     * @param string $timezone
     */
    public function setServerTimezone($timezone="Europe/London")
    {
        date_default_timezone_set($timezone);
    }
    
    /**
     * Get the timezone of the server.
     * @access public
     */
    public function getServerTimezone()
    {
        return date_default_timezone_get();
    }
    
    /**
     * Set the timezone for the Mysql.
     * @access public
     * @param string $offset
     */
    public function setDatabaseTimezone($offset="+0:00")
    {
        pjAppModel::factory()->prepare("SET SESSION time_zone = :offset;")->exec(compact('offset'));
    }
    
    /**
     * Get the timezone of the Database.
     * @access public
     */
    public function getDatabaseTimezone()
    {
        $arr = pjAppModel::factory()->prepare("SELECT @@session.time_zone AS timezone;")->exec(array())->getDataIndex(0);
        if(!empty($arr) && isset($arr['timezone']))
        {
            return $arr['timezone'];
        }else{
            return FALSE;
        }        
    }
    
    /**
     * synchronize server and database timezones. example: https://www.sitepoint.com/synchronize-php-mysql-timezone-configuration/
     * @access public
     */
    public function synchronizeTimezones()
    {
        $now = new DateTime();
        $mins = $now->getOffset() / 60;
        $sgn = ($mins < 0 ? -1 : 1);
        $mins = abs($mins);
        $hours = floor($mins / 60);
        $mins -= $hours * 60;
        $offset = sprintf('%+d:%02d', $hours  * $sgn, $mins);
        self::setDatabaseTimezone($offset);
    }
    
    /**
     * set server timezone and synchronize it with database
     * @access public
     */
    public function setAllTimezones($timezone="Europe/London")
    {
        self::setServerTimezone($timezone);
        self::synchronizeTimezones();
    }

    /**
     * Get the offset related to UTC timezone.
     *
     * @param string $timezone
     * @param bool $formatted If true, returns the result in {+/-}H:i format (e.g. +02:00). Otherwise returns the seconds (e.g. 7200).
     * @return int|string
     */
    public static function getTimezoneOffset($timezone, $formatted = true)
    {
        $tz = new DateTimeZone($timezone);
        $offset = $tz->getOffset(new DateTime('', new DateTimeZone('UTC')));

        if ($formatted)
        {
            if ($offset != 0)
            {
                $sign   = $offset > 0? '+': '-';
                $offset = $sign . gmdate('H:i', abs($offset));
            }
            else
            {
                $offset = '';
            }
        }

        return $offset;
    }
}
?>