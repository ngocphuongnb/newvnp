<?php

/**
 * Input Class
 *
 * Handle User request method
 *
 * @package		VNP
 * @subpackage	Base libraries
 * @author		VNP Dev team
 * @category	Base layer
 * @link		http://vnphp.com/docs/base-layer/libraries/Error.html
 */

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') ) die('Access denied!');

class Input
{
	static function Post($Name = NULL)
	{
		if( $Name == NULL ) return $_POST;
		if( isset($_POST[$Name]) && !empty($_POST[$Name]) ) return $_POST[$Name];
		else return false;
	}
	
	static function Get($Name = NULL)
	{
		if( $Name == NULL ) return $_GET;
		if( isset($_GET[$Name]) && !empty($_GET[$Name]) ) return $_GET[$Name];
		else return false;
	}
}

?>