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
 * @package   framework
 * @version   2.1.0
 */
/**
 * Used to invoke the Dispatcher
 *
 * @package framework
 * @since 1.0.0
 */
class pjObserver
{
    /**
     * @var object
     * @access private
     */
	private $controller;

    /**
     * The Factory pattern allows for the instantiation of objects at runtime.
     *
     * @param array Array with parameters passed to class constructor.
     * @access public
     * @static
     * @return self Instance of a `pjObserver`
     */
	public static function factory($attr=array())
	{
		return new pjObserver($attr);
	}

    /**
     * Initialize
     *
     * @access public
     * @return void
     */
	public function init()
	{
		if (isset($GLOBALS['CONFIG']['plugins']))
		{
			pjObject::import('Plugin', $GLOBALS['CONFIG']['plugins']);
		}
		
		$pjDispatcher = new pjDispatcher();
		$pjDispatcher->dispatch($_REQUEST, array());
		$this->controller = $pjDispatcher->getController();
	}

    /**
     * Gets the controller object
     *
     * @access public
     * @return object Instance of a requested controller
     */
	public function getController()
	{
		return $this->controller;
	}
}

function __($key, $return=false, $escape=false)
{
	return pjUtil::getField($key, $return, $escape);
}

function x__encode($key)
{
	echo pjAppController::jsonEncode(__($key, true));
}
?>