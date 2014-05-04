<?php

/**
 * Error Class
 *
 * Application error handler
 *
 * @package		VNP
 * @subpackage	Base libraries
 * @author		VNP Dev team
 * @category	Base layer
 * @link		http://vnphp.com/docs/base-layer/libraries/Error.html
 */

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') ) die('Access denied!');

class ErrorHandler
{
	static $List = array();
	public function __constructor()
	{
		$this->ini();
	}
	static $Content = array();
	
	/**
	 * Reset all error
	 * @return no
	 */
	static function reset()
	{
		ErrorHandler::$List = array();
	}
	
	/**
	 * Error handling initializing
	 * 
	 * @return no
	 */
	public function ini()
	{
		ErrorHandler::reset();
		if( ENVIRONMENT == 'develop' )
		{
			ini_set('display_startup_errors',1);
			ini_set('display_errors',1);
			error_reporting(E_ALL);
			set_error_handler(array($this, 'Detector'));
			register_shutdown_function(array($this, 'FatalErrorShutdownHandler'));
		}
		else error_reporting(0);
	}
	
	/**
	 * Default system error handler
	 * Errors storaged in static variable Error::$Content
	 * @param  level $level Error no
	 * @param  msg $msg Error content
	 * @param  Error File $error_file got error from file
	 * @param  Error Line $error_line got error from line
	 * @param  Context $Context Error context
	 * @return no
	 */
	public function Detector($level, $msg, $error_file, $error_line, $context = array())
	{
		ErrorHandler::$List[$level][] = array(	'msg' 		=> $msg,
												'file' 		=> $error_file, 
												'line' 		=> $error_line,
												'context' 	=> $context
											);
			}
	
	/**
	 * Manual error handler
	 * Errors storaged in static variable Error::$Content
	 * @param  level $level Error no
	 * @param  msg $msg Error content
	 * @return no
	 */
	static function Set($msg, $level = 0)
	{
		if($level == 0) trigger_error($msg);
		elseif($level == 1) trigger_error($msg, E_USER_WARNING);
		elseif($level == 2) trigger_error($msg, E_USER_ERROR);
	}
	
	public function FatalErrorShutdownHandler()
	{
		$last_error = error_get_last();
		$this->Detector($last_error['type'], $last_error['message'], $last_error['file'], $last_error['line']);
	}
}

?>