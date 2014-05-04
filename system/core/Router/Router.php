<?php

/**
 * Router Class
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

require SYSTEM_PATH . 'core/Router/AltoRouter.php';

class Router
{
	static $Router;
	static $BasePath;
	
	static function Start($BasePath)
	{
		Router::$BasePath = $BasePath;
		Router::$Router = new AltoRouter();
		Router::$Router->setBasePath($BasePath);
		return Router::$Router;
	}
	
	static function Map($Name = NULL, $Route, $Target, $Method = 'GET')
	{
		return Router::$Router->map($Method, $Route, $Target, $Name);
	}
	
	static function UnMap($Name)
	{
		return Router::$Router->unmap($Name);
	}
	
	static function Match()
	{
		$Router = Router::$Router->match();
		if(preg_match('/^Ajax_(.*)/', $Router['name'], $matchs))
		{
			$Router['name'] = $matchs[1];
			$Router['ajax'] = $Router['params']['Ajax_Mod'];
			unset($Router['params']['Ajax_Mod']);
		}
		return $Router;
	}
	
	static function Generate($RouteName, array $Params = array())
	{
		return Router::$Router->generate($RouteName, $Params);
	}
	
	static function BasePath()
	{
		return Router::$Router->GetBasePath();
	}
	
	static function ExtractParams($ParamsString)
	{
		if(!empty($ParamsString))
		{
			$ExtractedParams = array();
			$_ParamsArray = explode('/', $ParamsString);
			if( sizeof($_ParamsArray) % 2 != 0 ) $_ParamsArray[] = 0;
			if(!empty($_ParamsArray))
			{
				$KeyIndex = 0;
				while( isset($_ParamsArray[$KeyIndex]) )
				{
					$ExtractedParams[$_ParamsArray[$KeyIndex]] = $_ParamsArray[$KeyIndex+1];
					$KeyIndex += 2;
				}
			}
			return $ExtractedParams;
		}
		else return array();
	}
}

?>
