<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjUtil extends pjToolkit
{
	static public function uuid()
	{
		return chr(rand(65,90)) . chr(rand(65,90)) . time();
	}
	static public function getReferer()
	{
		if (isset($_GET['_escaped_fragment_']))
		{
			if (isset($_SERVER['REDIRECT_URL']))
			{
				return $_SERVER['REDIRECT_URL'];
			}
		}
		
		if (isset($_SERVER['HTTP_REFERER']))
		{
			$pos = strpos($_SERVER['HTTP_REFERER'], "#");
			if ($pos !== FALSE)
			{
				return substr($_SERVER['HTTP_REFERER'], 0, $pos);
			}
			return $_SERVER['HTTP_REFERER'];
		}
	}
	
	static public function textToHtml($content)
	{
		$content = preg_replace('/\r\n|\n/', '<br />', $content);
		return '<html><head><title></title></head><body>'.$content.'</body></html>';
	}
	static public function toMomemtJS($format)
	{
		$f = str_replace(
				array('Y', 'm', 'n', 'd', 'j'),
				array('yyyy', 'mm', 'm', 'dd', 'd'),
				$format
		);
	
		return $f;
	}
	static public function getTitles(){
		$arr = array();
		$arr[] = 'mr';
		$arr[] = 'mrs';
		$arr[] = 'ms';
		$arr[] = 'dr';
		$arr[] = 'prof';
		$arr[] = 'rev';
		$arr[] = 'other';
		return $arr;
	}
	
	static public function getPostMaxSize()
	{
		$post_max_size = ini_get('post_max_size');
		switch (substr($post_max_size, -1))
		{
			case 'G':
				$post_max_size = (int) $post_max_size * 1024 * 1024 * 1024;
				break;
			case 'M':
				$post_max_size = (int) $post_max_size * 1024 * 1024;
				break;
			case 'K':
				$post_max_size = (int) $post_max_size * 1024;
				break;
		}
		return $post_max_size;
	}
	
	static public function calPrice($price, $return, $option_arr)
	{
		$sub_total = 0;
		$tax = 0;
		$total = 0;
		$deposit = 0;
		
		$sub_total = !empty($price) ? $price : 0;
		if($return)
		{
			$sub_total = !empty($price) ? $price * 2 : 0;
		}
		$tax = ($sub_total * $option_arr['o_tax_payment']) / 100;
		$total = $sub_total + $tax;
		$deposit = 	($total * $option_arr['o_deposit_payment']) / 100;
		
		return compact('sub_total', 'tax', 'total', 'deposit');
	}
	
	static public function arrayMergeDistinct ( array &$array1, array &$array2 )
	{
	  	$merged = $array1;
	
	  	foreach ( $array2 as $key => &$value )
	  	{
	    	if ( is_array ( $value ) && isset ( $merged [$key] ) && is_array ( $merged [$key] ) )
	    	{
	      		$merged [$key] = pjUtil::arrayMergeDistinct ( $merged [$key], $value );
	    	}
	    	else
	    	{
	      		$merged [$key] = $value;
	    	}
	  	}
	
	  	return $merged;
	}
	static public function splitName($name)
	{
	    $name = trim($name);
	    $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
	    $first_name = trim( preg_replace('#'.preg_quote($last_name,'#').'#', '', $name ) );
	    return array($first_name, $last_name);
	}
	
	static public function sortArrayByArray(Array $array, Array $orderArray)
	{
	    $ordered = array();
	    foreach($orderArray as $key)
	    {
	        if(array_key_exists($key,$array))
	        {
	            $ordered[$key] = $array[$key];
	            unset($array[$key]);
	        }
	    }
	    return $ordered + $array;
	}
	public static function toBootstrapDate($format)
	{
	    return str_replace(
	        array('Y', 'm', 'n', 'd', 'j'),
	        array('yyyy', 'mm', 'm', 'dd', 'd'),
	        $format);
	}
}
?>