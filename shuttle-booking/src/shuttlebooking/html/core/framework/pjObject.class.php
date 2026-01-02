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
 * Object class provides a few generic methods used in several subclasses.
 *
 * @package framework
 * @since 1.0.0
 */
class pjObject
{
/**
 * Framework version
 * 
 * @var string
 */
	const PJ_FRAMEWORK_VERSION = '2.0';
/**
 * Framework build
 * 
 * @var string
 */
	const PJ_FRAMEWORK_BUILD = '2.0.4';
/**
 * The full path and filename of the file.
 *
 * @var string
 * @access public
 */
	public $ClassFile = __FILE__;
/**
 * Escapes special characters in a string for use in an SQL statement
 *
 * @param string $value The string that is to be escaped
 * @access public
 * @return string|false Returns the escaped string, or FALSE on error.
 */
	public static function escapeString($value)
	{
		$registry = pjRegistry::getInstance();
		
		if ($registry->is('dbo'))
		{
			$dbo = $registry->get('dbo');
			if (is_object($dbo) && method_exists($dbo, 'escapeString'))
			{
				return $dbo->escapeString($value);
			}
		}

		if (!defined('PJ_HOST') || !defined('PJ_USER') || !defined('PJ_PASS') || !defined('PJ_DB'))
        {
            $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
            $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");

            return str_replace($search, $replace, $value);
        }

        $driver = function_exists('mysqli_connect') ? 'pjMysqliDriver' : 'pjMysqlDriver';

		$params = array(
			'hostname' => PJ_HOST,
			'username' => PJ_USER,
			'password' => PJ_PASS,
			'database' => PJ_DB
		);
		
		if (strpos($params['hostname'], ":") !== FALSE)
		{
			list($hostname, $value) = explode(":", $params['hostname']);
			if (preg_match('/\D/', $value))
			{
				$params['socket'] = $value;
			} else {
				$params['port'] = $value;
			}
			$params['hostname'] = $hostname;
		}
		
		$dbo = pjSingleton::getInstance($driver, $params);
		if (!$dbo->init())
		{
			return $value;
		}
		
		return $dbo->escapeString($value);
	}
/**
 * Finds and require() classes based on $name and $type.
 *
 * How to use:
 * <code>
 * //include only one model
 * pjObject::import('Model', 'pjUser');
 * //include more than one models
 * pjObject::import('Model', array('pjUser', 'pjRole'));
 * //include plugin model
 * pjObject::import('Model', 'pjInvoice:pjInvoice');
 * pjObject::import('Model', 'pjLocale:pjLocaleLanguage');
 * //include more than one plugin models
 * pjObject::import('Model', array('pjLocale:pjLocaleLanguage', 'pjLocale:pjLocale'));
 * </code>
 *
 * @param string The type of Class. Possible values (case-insensitive) are: 'Model' and 'Component'.
 * @param array|string Name of the Class
 * @access public
 * @return void
 * @static
 */
	public static function import($type, $name)
	{
		$type = strtolower($type);
		if (!in_array($type, array('model', 'component', 'plugin')))
		{
			return false;
		}
		
		switch ($type)
		{
			case 'model':
			case 'component':
				break;
			case 'plugin':
				if (is_array($name))
				{
					foreach ($name as $n)
					{
						$configFile = PJ_PLUGINS_PATH . $n . '/config/config.inc.php';
						if (is_file($configFile))
						{
							require_once $configFile;
						}
					}
				} else {
					$configFile = PJ_PLUGINS_PATH . $name . '/config/config.inc.php';
					if (is_file($configFile))
					{
						require_once $configFile;
					}
				}
				break;
		}
		return;
	}
/**
 * Often used to check if given plugin is available(included).
 *
 * How to use:
 * <code>
 * if (pjObject::getPlugin('pjPaypal') !== NULL) {
 *   //do something with this plugin
 * }
 * </code>
 *
 * @param string Plugin name as string.
 * @access public
 * @static
 * @return array|null Confirm that the plugin is included as returning it's name, otherwise returns <b>NULL</b>.
 */
	public static function getPlugin($name)
	{
		$registry = pjRegistry::getInstance();
		if (null !== $registry->get($name))
		{
			return $name;
		}

		$plugins = $registry->get('plugins');
		if (is_array($plugins))
		{
			foreach ($plugins as $plugin => $controllers)
			{
				if (in_array($name, $controllers))
				{
					return $plugin;
				}
			}
		}

		return null;
	}
/**
 * Get value of given constant from registry.
 *
 * How to use:
 * <code>
 * $this->appendCss('pj-gallery.css', pjObject::getConstant('pjGallery', 'PLUGIN_CSS_PATH'));
 * </code>
 *
 * @param string Plugin name as string.
 * @param string Constant name as string.
 * @access public
 * @static
 * @return mixed|null Returns value of the plugin constant, if constant is not found returns <b>NULL</b>.
 */
	public static function getConstant($plugin, $const)
	{
		$registry = pjRegistry::getInstance();
		$config = $registry->get($plugin);
		return isset($config[$const]) ? $config[$const] : NULL;
	}
/**
 * Get framework version
 * 
 * @access public
 * @static
 * @return string
 */
	public static function getFrameworkVersion()
	{
		return self::PJ_FRAMEWORK_VERSION;
	}
/**
 * Get framework build
 * 
 * @access public
 * @static
 * @return string
 */
	public static function getFrameworkBuild()
	{
		return self::PJ_FRAMEWORK_BUILD;
	}
}
?>