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
 * Date Time class
 *
 * @package framework.components
 * @since 2.0.0
 */
class pjDateTime
{
/**
 * Attributes
 *
 * @var array
 * @access private
 */
	private $attr = array(); //name, id, class, etc.
/**
 * Properties
 *
 * @var array
 * @access private
 */
	private $prop = array(); //selected, format, emptyValue, emptyTitle, left, right, start, end, skip, step, ampm
/**
 * The Factory pattern allows for the instantiation of objects at runtime.
 *
 * @param array $attr
 * @static
 * @access public
 * @return self
 */
	public static function factory($attr=array())
	{
		return new self($attr);
	}
/**
 * Generate HTML SELECT element filled with days. Properties and attributes are applied first.
 *
 * @access public
 * @return string
 */
	public function day()
	{
		$html = sprintf('<select name="%s" id="%s" class="%s">', $this->attr('name'), $this->attr('id'), $this->attr('class'));
		if (isset($this->prop['emptyTitle']) && isset($this->prop['emptyValue']))
		{
			$html .= sprintf('<option value="%s">%s</option>', $this->prop('emptyValue'), $this->prop('emptyTitle'));
		}
		foreach (range(1, 31) as $v)
		{
			if (strlen($v) == 1)
			{
				$v = '0' . $v;
			}
			$html .= sprintf('<option value="%s"%s>%s</option>', $v, (!is_null($this->prop('selected')) && $v == $this->prop('selected') ? ' selected="selected"' : NULL), $v);
		}
		$html .= '</select>';
		
		return $html;
	}
/**
 * Generate HTML SELECT element filled with months. Properties and attributes are applied first.
 *
 * @access public
 * @return string
 */
	public function month()
	{
		$html = sprintf('<select name="%s" id="%s" class="%s">', $this->attr('name'), $this->attr('id'), $this->attr('class'));
		if (isset($this->prop['emptyTitle']) && isset($this->prop['emptyValue']))
		{
			$html .= sprintf('<option value="%s">%s</option>', $this->prop('emptyValue'), $this->prop('emptyTitle'));
		}
		$format = !is_null($this->prop('format')) && in_array($this->prop('format'), array('F', 'm', 'M', 'n')) ? $this->prop('format') : "m";
		
		foreach (range(1, 12) as $v)
		{
			if (strlen($v) == 1)
			{
				$v = '0' . $v;
			}
			$html .= sprintf('<option value="%s"%s>%s</option>', $v, (!is_null($this->prop('selected')) && $v == $this->prop('selected') ? ' selected="selected"' : NULL), date($format, mktime(0, 0, 0, $v, 1, 2000)));
		}
		$html .= '</select>';
		
		return $html;
	}
/**
 * Generate HTML SELECT element filled with years. Properties and attributes are applied first.
 *
 * @access public
 * @return string
 */
	public function year()
	{
		$html = sprintf('<select name="%s" id="%s" class="%s">', $this->attr('name'), $this->attr('id'), $this->attr('class'));
		if (isset($this->prop['emptyTitle']) && isset($this->prop['emptyValue']))
		{
			$html .= sprintf('<option value="%s">%s</option>', $this->prop('emptyValue'), $this->prop('emptyTitle'));
		}
		$curr_year = date("Y");
			
		foreach (range($curr_year - (int) $this->prop('left'), $curr_year + 1 + (int) $this->prop('right')) as $v)
		{
			$html .= sprintf('<option value="%s"%s>%s</option>', $v, (!is_null($this->prop('selected')) && $v == $this->prop('selected') ? ' selected="selected"' : NULL), $v);
		}
		$html .= '</select>';
		
		return $html;
	}
/**
 * Generate HTML SELECT element filled with hours. Properties and attributes are applied first.
 *
 * @access public
 * @return string
 */
	public function hour()
	{
	    $ampm = !is_null($this->prop('ampm')) ? $this->prop('ampm') : 0;
		$opts = array(
			'start' => !is_null($this->prop('start')) ? $this->prop('start') : ($ampm? 12: 0),
			'end' => !is_null($this->prop('end')) ? $this->prop('end') : ($ampm? 11: 23),
			'skip' => !is_null($this->prop('skip')) ? $this->prop('skip') : array()
		);

		if($opts['start'] > $opts['end'])
        {
            $range = range($opts['start'], $ampm? 12: 24) + range(0, $opts['end']);
        }
        else
        {
            $range = range($opts['start'], $opts['end']);
        }
		
		$attributes = NULL;
		foreach ($this->attr as $k => $v)
		{
			if (!in_array($k, array('name', 'id', 'class')))
			{
				$attributes .= sprintf(' %s="%s"', $k, $v);
			}
		}
		$html = sprintf('<select name="%s" id="%s" class="%s"%s>', $this->attr('name'), $this->attr('id'), $this->attr('class'), $attributes);
		foreach ($range as $v)
		{
			if (in_array($v, $opts['skip'])) continue;
			
			if (strlen($v) == 1)
			{
				$v = '0' . $v;
			}
			$html .= sprintf('<option value="%s"%s>%s</option>', $v, (!is_null($this->prop('selected')) && $v == $this->prop('selected') ? ' selected="selected"' : NULL), $v);
		}
		$html .= '</select>';
		
		return $html;
	}
/**
 * Generate HTML SELECT element filled with minutes. Properties and attributes are applied first.
 *
 * @access public
 * @return string
 */
	public function minute()
	{
		$opts = array(
			'start' => !is_null($this->prop('start')) ? $this->prop('start') : 0,
			'end' => !is_null($this->prop('end')) ? $this->prop('end') : 59,
			'skip' => !is_null($this->prop('skip')) ? $this->prop('skip') : array(),
			'step' => !is_null($this->prop('step')) ? $this->prop('step') : 1
		);
		
		$attributes = NULL;
		foreach ($this->attr as $k => $v)
		{
			if (!in_array($k, array('name', 'id', 'class')))
			{
				$attributes .= sprintf(' %s="%s"', $k, $v);
			}
		}
		$html = sprintf('<select name="%s" id="%s" class="%s"%s>', $this->attr('name'), $this->attr('id'), $this->attr('class'), $attributes);
		foreach (range($opts['start'], $opts['end']) as $v)
		{
			if (is_array($opts['skip']) && in_array($v, $opts['skip'])) continue;
			
			if (!is_null($this->prop('step')) && $this->prop('step') > 0 && $v % $this->prop('step') !== 0)
			{
				continue;
			}
			if (strlen($v) == 1)
			{
				$v = '0' . $v;
			}
			$html .= sprintf('<option value="%s"%s>%s</option>', $v, (!is_null($this->prop('selected')) && $v == $this->prop('selected') ? ' selected="selected"' : NULL), $v);
		}
		$html .= '</select>';
		
		return $html;
	}
	/**
 * Generate HTML SELECT element filled with AM/PM. Properties and attributes are applied first.
 *
 * @access public
 * @return string
 */
	public function ampm()
	{
	    $ampm = !is_null($this->prop('ampm')) ? $this->prop('ampm') : 0;
	    if($ampm != 0)
        {
            $ampm_arr = array('am', 'pm');
            if($ampm == 2)
            {
                $ampm_arr = array_map('strtoupper', $ampm_arr);
            }

            $attributes = NULL;
            foreach ($this->attr as $k => $v)
            {
                if (!in_array($k, array('name', 'id', 'class')))
                {
                    $attributes .= sprintf(' %s="%s"', $k, $v);
                }
            }
            $html = sprintf('<select name="%s" id="%s" class="%s"%s>', $this->attr('name'), $this->attr('id'), $this->attr('class'), $attributes);
            foreach ($ampm_arr as $v)
            {
                $html .= sprintf('<option value="%1$s"%2$s>%1$s</option>', $v, (!is_null($this->prop('selected')) && $v == $this->prop('selected') ? ' selected="selected"' : NULL));
            }
            $html .= '</select>';

            return $html;
        }

        return '';
	}
/**
 * Get or set attribute
 *
 * @param string $name
 * @param string $value
 * @access public
 * @return self
 */
	public function attr($name, $value=NULL)
	{
		if (func_num_args() === 1)
		{
			//Get
			return isset($this->attr[$name]) ? $this->attr[$name] : NULL;
		}
		//Set
		$this->attr[$name] = $value;
		return $this;
	}
/**
 * Get or set property
 *
 * @param string $name
 * @param string $value
 * @access public
 * @return self
 */
	public function prop($name, $value=NULL)
	{
		if (func_num_args() === 1)
		{
			//Get
			return isset($this->prop[$name]) ? $this->prop[$name] : NULL;
		}
		//Set
		$this->prop[$name] = $value;
		return $this;
	}
/**
 * Reset properties and attributes
 *
 * @access public
 * @return self
 */
	public function reset()
	{
		$this->attr = array();
		$this->prop = array();
		
		return $this;
	}
	
    /**
     * Format date
     *
     * @param string $date
     * @param string $inputFormat
     * @param string $outputFormat
     * @access public
     * @return string
     */
	public static function formatDate($date, $inputFormat, $outputFormat = "Y-m-d")
	{
	    if (empty($date))
	    {
	        return FALSE;
	    }
	    $limiters = array('.', '-', '/');
	    foreach ($limiters as $limiter)
	    {
	        if (strpos($inputFormat, $limiter) !== false)
	        {
	            $_date = explode($limiter, $date);
	            $_iFormat = explode($limiter, $inputFormat);
	            $_iFormat = array_flip($_iFormat);
	            break;
	        }
	    }
	    if (!isset($_iFormat) || !isset($_date) || count($_date) !== 3)
	    {
	        return FALSE;
	    }
	    return date($outputFormat, mktime(0, 0, 0,
	        $_date[isset($_iFormat['m']) ? $_iFormat['m'] : $_iFormat['n']],
	        $_date[isset($_iFormat['d']) ? $_iFormat['d'] : $_iFormat['j']],
	        $_date[$_iFormat['Y']]));
	}
	
	/**
	 * Format time
	 *
	 * @param string $time
	 * @param string $inputFormat
	 * @param string $outputFormat
	 * @static
	 * @access public
	 * @return string
	 */
	public static function formatTime($time, $inputFormat, $outputFormat = "H:i:s")
	{
	    $limiters = array(':');
	    foreach ($limiters as $limiter)
	    {
	        if (strpos($inputFormat, $limiter) !== false)
	        {
	            $_time = explode($limiter, $time);
	            if (strpos($_time[1], " ") !== false)
	            {
	                list($_time[1], $_time[2]) = explode(" ", $_time[1]);
	            }
	            $_iFormat = explode($limiter, $inputFormat);
	            if (strpos($_iFormat[1], " ") !== false)
	            {
	                list($_iFormat[1], $_iFormat[2]) = explode(" ", $_iFormat[1]);
	            }
	            $_iFormat = array_flip($_iFormat);
	            break;
	        }
	    }
	    
	    $h = $_time[isset($_iFormat['G']) ? $_iFormat['G'] : (isset($_iFormat['g']) ? $_iFormat['g'] : (isset($_iFormat['H']) ? $_iFormat['H'] : $_iFormat['h']))];
	    $sec = 0;
	    if (isset($_iFormat['a']))
	    {
	        if ($_time[$_iFormat['a']] == 'pm')
	        {
	            $sec = 60 * 60 * 12;
	            if ((int) $h === 12)
	            {
	                $sec = 0;
	            }
	        } elseif ($_time[$_iFormat['a']] == 'am') {
	            if ((int) $h === 12)
	            {
	                $sec = 60 * 60 * 12;
	            }
	        }
	    } elseif (isset($_iFormat['A'])) {
	        if ($_time[$_iFormat['A']] == 'PM')
	        {
	            $sec = 60 * 60 * 12;
	            if ((int) $h === 12)
	            {
	                $sec = 0;
	            }
	        } elseif ($_time[$_iFormat['A']] == 'AM') {
	            if ((int) $h === 12)
	            {
	                $sec = 60 * 60 * 12;
	            }
	        }
	    }
	    
	    return date($outputFormat, mktime(
	        $_time[isset($_iFormat['G']) ? $_iFormat['G'] : (isset($_iFormat['g']) ? $_iFormat['g'] : (isset($_iFormat['H']) ? $_iFormat['H'] : $_iFormat['h']))],
	        $_time[$_iFormat['i']],
	        $sec,
	        0, 0, 0
	        ));
	}
	
	/**
	 * Format date time
	 *
	 * @param string $dateTime
	 * @param string $inputFormat
	 * @param string $outputFormat
	 * @static
	 * @access public
	 * @return string
	 */
	public static function formatDateTime($dateTime, $inputFormat, $outputFormat = "Y-m-d, H:i:s")
	{
	    $limiters = array(' ', ', ');
	    foreach ($limiters as $limiter)
	    {
	        if (strpos($inputFormat, $limiter) !== false)
	        {
	            list($date, $time) = explode($limiter, $dateTime);
	            list($inputDateFormat, $inputTimeFormat) = explode($limiter, $inputFormat);
	            break;
	        }
	    }
	    if (!isset($date) || !isset($time) || !isset($inputDateFormat) || !isset($inputTimeFormat))
	    {
	        return FALSE;
	    }
	    
	    $date_limiters = array('.', '-', '/');
	    foreach ($date_limiters as $limiter)
	    {
	        if (strpos($inputDateFormat, $limiter) !== false)
	        {
	            $_date = explode($limiter, $date);
	            $_iDateFormat = explode($limiter, $inputDateFormat);
	            $_iDateFormat = array_flip($_iDateFormat);
	            break;
	        }
	    }
	    if (!isset($_iDateFormat) || !isset($_date) || count($_date) !== 3)
	    {
	        return FALSE;
	    }
	    
	    $time_limiters = array(':');
	    foreach ($time_limiters as $limiter)
	    {
	        if (strpos($inputTimeFormat, $limiter) !== false)
	        {
	            $_time = explode($limiter, $time);
	            if (strpos($_time[1], " ") !== false)
	            {
	                list($_time[1], $_time[2]) = explode(" ", $_time[1]);
	            }
	            $_iTimeFormat = explode($limiter, $inputTimeFormat);
	            if (strpos($_iTimeFormat[1], " ") !== false)
	            {
	                list($_iTimeFormat[1], $_iTimeFormat[2]) = explode(" ", $_iTimeFormat[1]);
	            }
	            $_iTimeFormat = array_flip($_iTimeFormat);
	            break;
	        }
	    }
	    
	    $h = $_time[isset($_iTimeFormat['G']) ? $_iTimeFormat['G'] : (isset($_iTimeFormat['g']) ? $_iTimeFormat['g'] : (isset($_iTimeFormat['H']) ? $_iTimeFormat['H'] : $_iTimeFormat['h']))];
	    $sec = 0;
	    if (isset($_iTimeFormat['a']))
	    {
	        if ($_time[$_iTimeFormat['a']] == 'pm')
	        {
	            $sec = 60 * 60 * 12;
	            if ((int) $h === 12)
	            {
	                $sec = 0;
	            }
	        } elseif ($_time[$_iTimeFormat['a']] == 'am') {
	            if ((int) $h === 12)
	            {
	                $sec = 60 * 60 * 12;
	            }
	        }
	    } elseif (isset($_iTimeFormat['A'])) {
	        if ($_time[$_iTimeFormat['A']] == 'PM')
	        {
	            $sec = 60 * 60 * 12;
	            if ((int) $h === 12)
	            {
	                $sec = 0;
	            }
	        } elseif ($_time[$_iTimeFormat['A']] == 'AM') {
	            if ((int) $h === 12)
	            {
	                $sec = 60 * 60 * 12;
	            }
	        }
	    }
	    return date($outputFormat, mktime(
	        $_time[isset($_iTimeFormat['G']) ? $_iTimeFormat['G'] : (isset($_iTimeFormat['g']) ? $_iTimeFormat['g'] : (isset($_iTimeFormat['H']) ? $_iTimeFormat['H'] : $_iTimeFormat['h']))],
	        $_time[$_iTimeFormat['i']],
	        $sec,
	        $_date[isset($_iDateFormat['m']) ? $_iDateFormat['m'] : $_iDateFormat['n']],
	        $_date[isset($_iDateFormat['d']) ? $_iDateFormat['d'] : $_iDateFormat['j']],
	        $_date[$_iDateFormat['Y']]
	        ));
	}
}
?>