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
 * Application controller class for organization of business logic.
 * Provides basic functionality, such as rendering views inside layouts,
 * automatic model availability, redirection, callbacks, and more.
 *
 * @package framework
 * @since 1.0.0
 */
class pjController extends pjObject
{
/**
 * The full path and filename of the file.
 *
 * @access public
 * @var string
 */
	public $ClassFile = __FILE__;
/**
 * Options variable holding the keys and values of all system options
 *
 * @access public
 * @var array
 */
	public $option_arr = array();
/**
 * Template variable holding data comes from controllers, used in the views
 *
 * @access public
 * @var array
 */
	public $tpl = array();
/**
 * Hold path to JS files, use it in views/layouts
 *
 * @access private
 * @var array
 */
	private $js = array();
/**
 * Hold path to CSS files, use it in views/layouts
 *
 * @access private
 * @var array
 */
	private $css = array();
/**
 * Hold the name of session variable which store all the login information
 *
 * @access public
 * @var string
 * @example $_SESSION[$this->defaultUser] = 'test';
 */
	public $defaultUser = 'admin_user';
/**
 * Hold name of current layout
 *
 * @access public
 * @var string
 */
	public $layout = 'pjActionDefault';
/**
 * Hold names of controller and template
 *
 * @access public
 * @var array|null
 */
	public $template = NULL;
/**
 * Set this to boolean TRUE if expect AJAX method, default is FALSE.
 *
 * @var bool
 * @access public
 */
	public $ajax = FALSE;
/**
 * $_GET params
 *
 * @access public
 * @var array
 */
	public $params = array();
/**
 * An associative array of variables passed to the current script via the HTTP POST method.
 *
 * @access public
 * @var array
 */
	public $body = array();
/**
 * An associative array of variables passed to the current script via the URL parameters.
 *
 * @access public
 * @var array
 */
	public $query = array();
/**
 * An associative array of variables, copy of $_SESSION.
 *
 * @access public
 * @var pjSession
 */
	public $session = array();
/**
 * An associative array of variables, copy of $_FILES.
 *
 * @access public
 * @var array
*/
	public $files = array();
	
/**
 * An associative array of variables passed to the current script via the HTTP POST OR GET method.
 *
 * @access public
 * @var pjInput
 */
	public $_get = NULL;
	
	public $_post = NULL;
/**
 * Constructor - automatically called when you create a new instance of a class with new
 *
 * @access public
 * @return self
 */
	public function __construct()
	{
		
	}
/**
 * This function is executed before every action in the controller. Its a handy place to check for an active session or inspect user permissions.
 *
 * @access public
 * @return boolean
 */
	public function beforeFilter()
	{
		return true;
	}
/**
 * Called after controller action logic, but before the view is rendered.
 *
 * @access public
 * @return self
 */
	public function beforeRender()
	{
		
	}
/**
 * Called after every controller action.
 *
 * @access public
 * @return self
 */
	public function afterFilter()
	{
	    $this->_get->reassign_post_get();
	    $this->_post->reassign_post_get();
	}
/**
 * Called after an action has been rendered.
 *
 * @access public
 * @return self
 */
	public function afterRender()
	{
		
	}
/**
 * Add given file to internal CSS stack for later including at the rendering HTML time
 *
 * How to use:
 * <code>
 * $this->appendCss('reset.css');
 * $this->appendCss('jquery-ui.min.css', PJ_THIRD_PARTY_PATH . 'jquery_ui/css/smoothness/');
 * $this->appendCss('jquery-ui.css', 'http://code.jquery.com/ui/1.10.3/themes/smoothness/', true);
 * </code>
 *
 * @param string Base file name
 * @param string Path to file
 * @param boolean Indicate that file is remote or not. Defaults to <b>FALSE</b>.
 * @return self
 */
	public function appendCss($file, $path=PJ_CSS_PATH, $remote=FALSE, $resolver=TRUE)
	{
		if ($resolver)
		{
			$resolve = self::dependencyResolver(debug_backtrace(), 'appendCss', $path.$file);
			if ($resolve !== FALSE)
			{
				extract($resolve);
			}
		}
		$this->css[] = compact('file', 'path', 'remote');
		return $this;
	}
/**
 * Add a style to internal CSS stack by given library & plugin using the pjDependencyManager
 *
 * @param string $file
 * @param string $library
 * @param string $pluginName
 * @param string $basePath
 * @return pjController
 */
	public function appendCssFromPlugin($file, $library, $pluginName, $basePath=PJ_THIRD_PARTY_PATH, $baseDir=null)
	{
		$dm = new pjDependencyManager($baseDir, $basePath);
		$dependencies = pjObject::getConstant($pluginName, 'PLUGIN_DIR') . 'config/dependencies.php';
		$dm->load($dependencies)->resolve();
	
		return $this->appendCss($file, $dm->getPath($library), FALSE, FALSE);
	}
/**
 * Add given file to internal JS stack for later including at the rendering HTML time
 *
 * How to use:
 * <code>
 * $this->appendJs('pjAdmin.js');
 * $this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
 * $this->appendJs('jquery-1.9.1.js', 'http://code.jquery.com/', true);
 * </code>
 *
 * @param string Base file name
 * @param string Path to file
 * @param boolean Indicate that file is remote or not. Defaults to <b>FALSE</b>.
 * @return self
 */
	public function appendJs($file, $path=PJ_JS_PATH, $remote=FALSE, $resolver=TRUE)
	{
		if ($resolver)
		{
			$resolve = self::dependencyResolver(debug_backtrace(), 'appendJs', $path.$file);
			if ($resolve !== FALSE)
			{
				extract($resolve);
			}
		}
		$this->js[] = compact('file', 'path', 'remote');
		return $this;
	}
/**
 * Add a script to internal JS stack by given library & plugin using the pjDependencyManager
 * 
 * @param string $file
 * @param string $library
 * @param string $pluginName
 * @param string $basePath
 * @return pjController
 */
	public function appendJsFromPlugin($file, $library, $pluginName, $basePath=PJ_THIRD_PARTY_PATH, $baseDir=null)
	{
		$dm = new pjDependencyManager($baseDir, $basePath);
		$dependencies = pjObject::getConstant($pluginName, 'PLUGIN_DIR') . 'config/dependencies.php';
		$dm->load($dependencies)->resolve();
		
		return $this->appendJs($file, $dm->getPath($library), FALSE, FALSE);
	}
/**
 * Resolve resource dependencies
 *
 * @param array $trace
 * @param string $funcName
 * @param string $filePath
 * @return boolean|array
 */
	static private function dependencyResolver($trace, $funcName, $filePath)
	{
		if (!(isset($trace[0], $trace[0]['function']) && $trace[0]['function'] == $funcName))
		{
			return FALSE;
		}
		
		if (strpos($filePath, PJ_THIRD_PARTY_PATH) !== 0)
		{
			return FALSE;
		}

		$className = get_class($trace[0]['object']);
			
		$reflector = new ReflectionClass($className);
		$classFileName = $reflector->getFileName();
		
		$classFileName = str_replace('\\', '/', $classFileName);
		$pluginsPath = str_replace('\\', '/', PJ_PLUGINS_PATH);
 
		$isPlugin = FALSE;
		if (strpos($classFileName, $pluginsPath) === 0)
		{
			$isPlugin = TRUE;
		}
	
		$dependencies = array();
	
		if ($isPlugin)
		{
			$dependency_file = dirname(dirname($classFileName)) . '/config/dependencies.php';
			if (is_file($dependency_file))
			{
				$dependencies = include $dependency_file;
			}
		} else {
			$dependency_file = PJ_CONFIG_PATH . 'dependencies.php';
			if (is_file($dependency_file))
			{
				$dependencies = include $dependency_file;
			}
		}
	
		if (!isset($dependencies) || empty($dependencies))
		{
			return FALSE;
		}
	
		$parts = explode('/', $filePath);
		$cnt = substr_count(PJ_THIRD_PARTY_PATH, '/');
		$library = $parts[$cnt];
	
		if (!isset($dependencies[$library]))
		{
			return FALSE;
		}
	
		$file = join('/', array_slice($parts, $cnt+1));
	
		$baseDir = defined("PJ_INSTALL_PATH") ? PJ_INSTALL_PATH : null;
		$dep = new pjDependencyManager($baseDir, PJ_THIRD_PARTY_PATH);
		$version = $dep->load($dependencies)->resolve()->getVersion($library);
	
		$path = PJ_THIRD_PARTY_PATH . $library . '/' . $version . '/';
	
		return compact('file', 'path');
	}

    /**
     * @param null|array $params
     * @return $this
     */
	static public function init($params=NULL)
	{
	    $called_class = get_called_class();
	    $instance = new $called_class;
	    $instance->_get = pjRegistry::getInstance()->get('_get');
	    $instance->_post = pjRegistry::getInstance()->get('_post');
	    $instance->session = pjRegistry::getInstance()->get('session');
	    $instance->params = $params != NULL ? $params : array();
	    $instance->beforeFilter();
	    $instance->afterFilter();
	    $instance->beforeRender();
	    $instance->afterRender();
	    return $instance;
	}
/**
 * Default action to invoke, if no action is specified
 *
 * @access public
 * @return void
 */
	public function pjActionIndex()
	{
	}
/**
 * Invoke after script install
 *
 * @access public
 * @return void
 */
	public function pjActionAfterInstall()
	{
		
	}
/**
 * Invoke before script install
 *
 * @access public
 * @return void
 */
	public function pjActionBeforeInstall()
	{
		
	}
/**
 * Invoke on the begining of the install process
 *
 * @access public
 * @return void
 */
	public function pjActionCheckInstall()
	{
		
	}
/**
 * If not loged in refirects to login page
 *
 * @access public
 * @return void
 */
	public function checkLogin()
	{
		if (!$this->isLoged())
		{
			pjToolkit::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionLogin");
		}
	}
/**
 * Get a template variable
 *
 * @param string $key
 * @access public
 * @return array|string|false
 */
	public function get($key=NULL)
    {
    	if (is_null($key))
    	{
    		return $this->tpl;
    	}
    	
    	if (array_key_exists($key, $this->tpl))
    	{
    		return $this->tpl[$key];
    	}
    	
    	return FALSE;
    }
/**
 * Check if method is AJAX
 *
 * @access public
 * @return boolean
 */
	public function getAjax()
    {
    	return $this->ajax;
    }
/**
 * Get internal CSS stack (array with CSS files)
 *
 * @access public
 * @return array
 */
	public function getCss()
    {
    	return $this->css;
    }
/**
 * Get internal JS stack (array with JS files)
 *
 * @access public
 * @return array
 */
	public function getJs()
    {
    	return $this->js;
    }
/**
 * Get current layout
 *
 * @access public
 * @return string
 */
    public function getLayout()
    {
    	return $this->layout;
    }
/**
 * Get an associative array of variables passed to the current script via the URL parameters.
 *
 * @access public
 * @return array
 */
	public function getParams()
    {
    	return $this->params;
    }
/**
 * Get user ID
 *
 * @access public
 * @return int|false
 */
	public function getUserId()
    {
    	return isset($_SESSION[$this->defaultUser]) && array_key_exists('id', $_SESSION[$this->defaultUser]) ? $_SESSION[$this->defaultUser]['id'] : FALSE;
    }
/**
 * Get user's role ID
 *
 * @access public
 * @return int|false
 */
    public function getRoleId()
    {
    	return isset($_SESSION[$this->defaultUser]) && array_key_exists('role_id', $_SESSION[$this->defaultUser]) ? $_SESSION[$this->defaultUser]['role_id'] : FALSE;
    }
/**
 * Check if current user is loged in
 *
 * @access public
 * @return boolean
 */
	public function isLoged()
    {
        if (isset($_SESSION[$this->defaultUser]) && count($_SESSION[$this->defaultUser]) > 0)
        {
            return TRUE;
	    }
	    return FALSE;
    }
/**
 * Check current loged user against 'Admin' role
 *
 * @access public
 * @return boolean
 */
	public function isAdmin()
    {
   		return $this->getRoleId() == 1;
    }
/**
 * Check if request is send via AJAX
 *
 * @access public
 * @return boolean
 */
    public function isXHR()
    {
		return @$_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }
/**
 * Wrapper for the log functionality of pjBase plugin. Use to add message to the log.
 *
 * @param string $value
 * @access public
 * @return void
 */
    public function log($value)
    {
    	$this->requestAction(
    		array(
	    		'controller' => 'pjBaseLog',
	    		'action' => 'pjActionLogger',
	    		'params' => array(
	    			'value' => $value,
    				'key' => md5($this->option_arr['private_key'] . PJ_SALT)
    			)
    		),
    		array('return')
    	);
    }
/**
 * Reset internal JS stack
 *
 * @access public
 * @return self
 */
    public function resetJs()
    {
    	$this->js = array();
    	return $this;
    }
/**
 * Reset internal CSS stack
 *
 * @access public
 * @return self
 */
	public function resetCss()
    {
    	$this->css = array();
    	return $this;
    }
/**
 * Execute any controller's method
 *
 * How to use:
 * <code>
 * $params = array(
 *     'txn_id' => @$invoice_arr['txn_id'],
 *	   'paypal_address' => @$this->option_arr['o_paypal_address'],
 *	   'deposit' => @$invoice_arr['total'],
 *	   'currency' => @$invoice_arr['currency'],
 *	   'key' => md5($this->option_arr['private_key'] . PJ_SALT)
 * );
 *
 * $response = $this->requestAction(array('controller' => 'pjPaypal', 'action' => 'pjActionConfirm', 'params' => $params), array('return'));
 *
 * if ($response !== FALSE && $response['status'] === 'OK') {
 *   //do something
 * }
 * </code>
 *
 * @param array Array indexes: `controller`, `action`, `params`
 * @param array (Optional) Array indexes: `return`, `output`
 * @see pjDispatcher::dispatch
 * @access public
 * @return mixed
 */
	public function requestAction($request, $options=array())
	{
		$Dispatcher = new pjDispatcher();
		$dispatch = $Dispatcher->dispatch($request, $options);

		$v529 = in_array(version_compare(phpversion(), '5.2.9'), array(0,1));
		
		$css = array_merge($this->getCss(), $Dispatcher->getController()->getCss());
		if ($v529)
		{
			$unique = array_unique($css, SORT_REGULAR);
		} else {
			$unique = array_unique($css);
		}
		$unique = array_map('unserialize', array_unique(array_map('serialize', $css)));
		$this->setCss($unique);
		
		$js = array_merge($this->getJs(), $Dispatcher->getController()->getJs());
		if ($v529)
		{
			$unique = array_unique($js, SORT_REGULAR);
		} else {
			$unique = array_unique($js);
		}
		$unique = array_map('unserialize', array_unique(array_map('serialize', $js)));
		$this->setJs($unique);
		
		return $dispatch;
	}
/**
 * Set variable to use in the view
 *
 * @param string $key
 * @param mixed $value
 * @access public
 * @return self
 */
	public function set($key, $value)
	{
		$this->tpl[$key] = $value;
		return $this;
	}
/**
 * Turn AJAX mode on/off
 *
 * @param boolean
 * @access public
 * @return self
 */
	public function setAjax($value)
	{
		$this->ajax = (bool) $value;
		return $this;
	}
/**
 * Set internal CSS stack to given array
 *
 * @param array $value
 * @access public
 * @return self
 */
	public function setCss($value)
	{
		if (is_array($value))
		{
			$this->css = $value;
		}
		return $this;
	}
/**
 * Set internal JS stack to given array
 *
 * @param array $value
 * @access public
 * @return self
 */
	public function setJs($value)
	{
		if (is_array($value))
		{
			$this->js = $value;
		}
		return $this;
	}
/**
 * Set layout
 *
 * How to use:
 * <code>
 * $this->setLayout('pjActionFront');
 * </code>
 *
 * @param string View name (same as method name of the `pjLayout` controller)
 * @access public
 * @return self
 */
	public function setLayout($str)
	{
		$this->layout = $str;
		return $this;
	}
/**
 * Set template
 *
 * How to use:
 * <code>
 * $this->setTemplate('pjFrontPublic', 'pjActionPrint');
 * </code>
 *
 * @param string $controller
 * @param string $template
 * @access public
 * @return self
 */
	public function setTemplate($controller, $template)
	{
		$this->template = compact('controller', 'template');
		return $this;
	}
}
?>