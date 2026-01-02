<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
/**
 * PHP Framework
 *
 * @copyright Copyright 2018, PHPJabbets, Ltd.
 * @link      https://www.phpjabbers.com/
 * @package   framework.components
 * @version   2.1.0
 */
/**
 * Toolkit class
 *
 * @package framework.components
 * @since 1.0.0
 */
class pjToolkit
{

    /**
     * Decrypts a string
     *
     * @param string $str
     * @static
     * @access public
     * @return string
     */
	public static function decrypt($str)
	{
		$txt = '';
		$arr = explode("%", $str);
		foreach ($arr as $val)
		{
			if (strlen($val) > 0)
			{
				$txt .= chr(hexdec($val));
			}
		}
		return $txt;
	}

    /**
     * Send download headers
     *
     * @param string $name
     * @param int $length
     * @param string $type
     * @static
     * @access public
     * @return void
     */
	public static function sendDownloadHeaders($name, $length=0, $type='application/octet-stream')
	{
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private', false);
		header('Content-Transfer-Encoding: binary');
		header('Content-Disposition: attachment; filename="'.$name.'"');
		header('Content-Type: ' . $type);
		if ($length > 0)
		{
			header('Content-Length: ' . $length);
		}
	}

    /**
     * Force browser to download given file
     *
     * @param string $file
     * @param string $type
     * @param string $name
     * @static
     * @access public
     * @return void
     */
	public static function chunckedDownload($file, $type='application/octet-stream', $name=NULL)
	{
		$length = filesize($file);
		$name = empty($name) ? basename($file) : $name;
		
		self::sendDownloadHeaders($name, $length, $type);
		
		$chunkSize = 1024 * 1024;
		$handle = fopen($file, 'rb');
		while (!feof($handle))
		{
			$buffer = fread($handle, $chunkSize);
			echo $buffer;
			ob_flush();
			flush();
		}
		fclose($handle);
	}

    /**
     * Force browser to download given data
     *
     * @param string $data
     * @param string $name
     * @param string $mimetype
     * @param int|boolean $filesize
     * @static
     * @access public
     * @return void
     */
	public static function download($data, $name, $mimetype='', $filesize=false)
	{
        $length = ($filesize == false || !is_numeric($filesize)) ? strlen($data) : $filesize;
	
	    $type = empty($mimetype) ? 'application/octet-stream' : $mimetype;
	    
	    self::sendDownloadHeaders($name, $length, $type);
			
		echo $data;
	}

    /**
     * Convert to ASCII
     *
     * @param string $str
     * @static
     * @access public
     * @return string
     */
	public static function encodeEmail($str)
	{
		$output = "";
		for ($i = 0; $i < strlen($str); $i++)
		{
			$output .= '&#' . ord($str[$i]) . ';';
		}
		return $output;
	}

    /**
     * Get value from fields registry by given key
     *
     * @param string $key
     * @static
     * @access public
     * @return string|null
     */
	public static function field($key)
    {
    	$fields = pjRegistry::getInstance()->get('fields');
    	return isset($fields[$key]) ? $fields[$key] : NULL;
    }

    /**
     * Format size
     *
     * @param int $bytes
     * @access public
     * @static
     * @return string
     */
	public static function formatSize($bytes)
	{
		$size = (int) $bytes / 1024;
		if ($size > 1023)
		{
			$size = round($size / 1024, 1) . " MB";
		} else {
			$size = ceil($size) . " KB";
		}
		return $size;
	}

    /**
     * Extract domain from given URL
     *
     * @param string $url
     * @static
     * @access public
     * @return string|null
     */
	public static function getDomain($url)
	{
		$host = @parse_url($url, PHP_URL_HOST);
		if ($host !== false && !empty($host))
		{
			# Check for IP address
			preg_match('/\b(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b/', $host, $match);
			if (isset($match[0]))
			{
				return $match[0];
			}
			# Check for domain
		    if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $host, $regs))
		    {
		        return $regs['domain'];
		    }
		    # Check for localhost
		    if ($host == 'localhost')
		    {
		    	return $host;
		    }
		}
	    return null;
	}

    /**
     * Lookup a message in the current domain
     *
     * @param string $key
     * @param boolean $return
     * @param boolean $escape
     * @static
     * @access public
     * @return string|null
     */
	public static function getField($key, $return=false, $escape=false)
	{
		$text = pjToolkit::field($key);
		if ($return)
		{
			if (!$escape)
			{
				return $text;
			} else {
				if (!is_array($text))
				{
					return htmlspecialchars($text, ENT_QUOTES);
				} else {
					foreach ($text as $k => $v)
					{
						$text[$k] = htmlspecialchars($v, ENT_QUOTES);
					}
					return $text;
				}
			}
		}
		if (!is_array($text))
		{
			echo !$escape ? $text : htmlspecialchars($text, ENT_QUOTES);
		} else {
			if (!$escape)
			{
				return $text;
			} else {
				foreach ($text as $k => $v)
				{
					$text[$k] = htmlspecialchars($v, ENT_QUOTES);
				}
				return $text;
			}
		}

		return null;
	}

    /**
     * Get file extension
     *
     * @param string $str
     * @static
     * @access public
     * @return string
     */
	public static function getFileExtension($str)
    {
    	$arrSegments = explode('.', $str);
        $strExtension = $arrSegments[count($arrSegments) - 1];
        $strExtension = strtolower($strExtension);
        return $strExtension;
    }

    /**
     * Generate random password
     *
     * @param int $n
     * @param string $chars
     * @static
     * @access public
     * @return string
     */
	public static function getRandomPassword($n = 6, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890')
	{
		srand((double) microtime() * 1000000);
		$m = strlen($chars);
		$randPassword = "";
		while ($n--)
		{
			$randPassword .= substr($chars, rand() % $m, 1);
		}
		return $randPassword;
	}

    /**
     * Convert HEX to RGB
     *
     * @param string $color
     * @static
     * @access public
     * @return array|bool
     */
	public static function html2rgb($color)
	{
		if ($color[0] == '#')
		{
			$color = substr($color, 1);
		}
		if (strlen($color) == 6)
		{
			list($red, $green, $blue) = array($color[0].$color[1], $color[2].$color[3], $color[4].$color[5]);
		} elseif (strlen($color) == 3) {
			list($red, $green, $blue) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
		} else {
			return false;
		}
		$red = hexdec($red);
		$green = hexdec($green);
		$blue = hexdec($blue);
		return array($red, $green, $blue);
	}

    /**
     * Convert PHP date format to MomentJS date format
     *
     * @param string $phpFormat
     * @static
     * @access public
     * @return string
     */
	public static function momentJsDateFormat($phpFormat)
	{
		$f = str_replace(
				array('Y', 'm', 'n', 'd', 'j'),
				array('yyyy', 'mm', 'm', 'dd', 'd'),
				$phpFormat
		);

		return $f;
	}

    /**
     * Convert PHP date format to jQuery date format
     *
     * @param string $phpFormat
     * @static
     * @access public
     * @return string
     */
	public static function jqDateFormat($phpFormat)
	{
		$jQuery = array('d', 'dd', 'm', 'mm', 'yy');
		$php = array('j', 'd', 'n', 'm', 'Y');
		$limiters = array('.', '-', '/');
		foreach ($limiters as $limiter)
		{
			if (strpos($phpFormat, $limiter) !== false)
			{
				$_iFormat = explode($limiter, $phpFormat);
				return join($limiter, array(
					$jQuery[array_search($_iFormat[0], $php)],
					$jQuery[array_search($_iFormat[1], $php)],
					$jQuery[array_search($_iFormat[2], $php)]
				));
			}
		}
		return $phpFormat;
	}

    /**
     * Convert PHP time format to jQuery time format
     *
     * @param string $phpFormat
     * @static
     * @access public
     * @return string
     */
	public static function jqTimeFormat($phpFormat)
	{
		$jQuery = array('HH', 'hh', 'H', 'h', 'mm', 'TT', 'tt');
		$php = array('H', 'h', 'G', 'g', 'i', 'A', 'a');
		$limiters = array(':');
		foreach ($limiters as $limiter)
		{
			if (strpos($phpFormat, $limiter) !== false)
			{
				$_iFormat = explode($limiter, $phpFormat);
				$_iFormat[2] = NULL;
				if (strpos($_iFormat[1], " ") !== false)
				{
					list($_iFormat[1], $_iFormat[2]) = explode(" ", $_iFormat[1]);
				}
				$result = join($limiter, array(
					$jQuery[array_search($_iFormat[0], $php)],
					$jQuery[array_search($_iFormat[1], $php)]
				));
				if (!is_null($_iFormat[2]))
				{
					$result .= " " . $jQuery[array_search($_iFormat[2], $php)];
				}
				return $result;
			}
		}
		return $phpFormat;
	}

    /**
     * Convert PHP date format to Javascript date format
     *
     * @param string $phpFormat
     * @static
     * @access public
     * @return string
     */
	public static function jsDateFormat($phpFormat)
	{
		$js = array('d', 'dd', 'M', 'MM', 'yyyy');
		$php = array('j', 'd', 'n', 'm', 'Y');
		$limiters = array('.', '-', '/');
		foreach ($limiters as $limiter)
		{
			if (strpos($phpFormat, $limiter) !== false)
			{
				$_iFormat = explode($limiter, $phpFormat);
				return join($limiter, array(
					$js[array_search($_iFormat[0], $php)],
					$js[array_search($_iFormat[1], $php)],
					$js[array_search($_iFormat[2], $php)]
				));
			}
		}
		return $phpFormat;
	}

    /**
     * Print error notice (css-styled html container with text)
     *
     * @param string $title
     * @param string $body
     * @param boolean $convert
     * @param boolean $close
     * @param boolean $autoClose
     * @static
     * @access public
     * @return void
     */
	public static function printNotice($title, $body, $convert = true, $close = true, $autoClose = false)
	{
		?>
		<div class="notice-box">
			<div class="notice-top"></div>
			<div class="notice-middle">
				<span class="notice-info">&nbsp;</span>
				<?php
				if (!empty($title))
				{
					printf('<span class="block bold">%s</span>', $convert ? htmlspecialchars(stripslashes($title)) : stripslashes($title));
				}
				if (!empty($body))
				{
					printf('<span class="block">%s</span>', $convert ? htmlspecialchars(stripslashes($body)) : stripslashes($body));
				}
				if ($close && !$autoClose)
				{
					?><a href="#" class="notice-close"></a><?php
				}
				if ($autoClose)
				{
					$text = __('lblClickToClose', true);
					if (empty($text))
					{
						$text = 'Click to close';
					}
					?><a href="#" class="notice-counter"><?php echo $text; ?> (<span class="notice-seconds">20</span>)</a><?php 
				}
				?>
			</div>
			<div class="notice-bottom"></div>
		</div>
		<?php
	}

    /**
     * Recursively read entry from directory handle
     *
     * @param array $data
     * @param string $dir
     * @static
     * @access public
     * @return void
     */
	public static function readDir(&$data, $dir)
	{
		$stop = array('.', '..', '.buildpath', '.project', '.svn', 'Thumbs.db');
		if ($handle = opendir($dir))
		{
			$sep = $dir[strlen($dir)-1] != '/' ? '/' : NULL;
			while (false !== ($file = readdir($handle)))
			{
				if (in_array($file, $stop)) continue;
				if (!is_dir($dir . $sep . $file))
				{
					$data[] = $dir . $sep . $file;
				} else {
					pjToolkit::readDir($data, $dir . $sep . $file);
				}
			}
			closedir($handle);
		}
	}

    /**
     * Redirects via HTTP header. Javascript redirects are used if HTTP server running on Microsoft-IIS
     *
     * @param string $url
     * @param int $http_response_code
     * @param boolean $exit
     * @static
     * @access public
     * @return void
     */
	public static function redirect($url, $http_response_code = null, $exit = true)
	{
		if (strstr($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS'))
		{
			echo '<html><head><title></title><script type="text/javascript">window.location.href="'.$url.'";</script></head><body></body></html>';
		} else {
			$http_response_code = !is_null($http_response_code) && (int) $http_response_code > 0 ? $http_response_code : 303;
			header("Location: $url", true, $http_response_code);
		}
		if ($exit)
		{
	    	exit();
		}
	}

    /**
     * Return Client IP if available
     *
     * @static
     * @access public
     * @return string|null
     */
	public static function getClientIp()
	{
		if (isset($_SERVER['HTTP_CLIENT_IP']))
		{
			return $_SERVER['HTTP_CLIENT_IP'];
		} else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else if(isset($_SERVER['HTTP_X_FORWARDED'])) {
			return $_SERVER['HTTP_X_FORWARDED'];
		} else if(isset($_SERVER['HTTP_FORWARDED_FOR'])) {
			return $_SERVER['HTTP_FORWARDED_FOR'];
		} else if(isset($_SERVER['HTTP_FORWARDED'])) {
			return $_SERVER['HTTP_FORWARDED'];
		} else if(isset($_SERVER['REMOTE_ADDR'])) {
			return $_SERVER['REMOTE_ADDR'];
		}

		return 'UNKNOWN';
	}
}
?>