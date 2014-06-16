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

//require SYSTEM_PATH . 'core/Router/AltoRouter.php';
require SYSTEM_PATH . 'core/Router/VNP_Router.php';

class Router
{
	static $Router;
	static $BasePath;
	
	static function Start($BasePath, $CachePath)
	{
		VNP_Router::Init();
		VNP_Router::$CompiledRoutesPath = $CachePath;
		Router::$Router = new VNP_Router();
		Router::$Router->SetBasePath($BasePath);
		return Router::$Router;
	}
	
	static function Map($Name = NULL, $Route, $Target, $Method = 'GET', $Priority = 0)
	{
		return Router::$Router->Map($Name, $Route, $Target, $Method, $Priority);
	}
	
	static function UnMap($Name)
	{
		return Router::$Router->UnMap($Name);
	}
	
	static function AddRule($RuleName, $Rule) {
		VNP_Router::AddRule($RuleName, $Rule);
	}
	
	static function Match($Priority = 0)
	{
		$Routes = Router::$Router->Match();
		$_R = array();
		foreach($Routes as $Route) {
			if(preg_match('/^Ajax_(.*)/', $Route['name'], $matchs)) {
				$Route['name'] = $matchs[1];
				$Route['ajax'] = $Route['params']['Ajax_Mod'];
				unset($Route['params']['Ajax_Mod']);
			}
			$_R[] = $Route;
		}
		if(strcmp($Priority, 'all') === 0 || !isset($_R[$Priority])) return $_R;
		else return $_R[$Priority];
	}
	
	static function Generate($RouteName, array $Params = array())
	{
		return Router::$Router->Generate($RouteName, $Params);
	}
	
	static function GenerateThisRoute()
	{
		return Router::$Router->Generate(G::$Route['name'], G::$Route['params']);
	}
	
	static function BasePath()
	{
		return Router::$Router->GetBasePath();
	}
	
	static function ExtractParams($ParamsString)
	{
		if(!empty($ParamsString)) {
			$ExtractedParams = array();
			$_ParamsArray = explode('/', $ParamsString);
			//if( sizeof($_ParamsArray) % 2 != 0 ) array_unshift($_ParamsArray, ROUTER_EXTRA_KEY);
			if( sizeof($_ParamsArray) % 2 != 0 ) {
				$LastElement = array_pop($_ParamsArray);
				$_ParamsArray[] = ROUTER_EXTRA_KEY;
				$_ParamsArray[] = $LastElement;
				//array_unshift($_ParamsArray, ROUTER_EXTRA_KEY);
			}
			if(!empty($_ParamsArray)) {
				$KeyIndex = 0;
				while(isset($_ParamsArray[$KeyIndex])) {
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
