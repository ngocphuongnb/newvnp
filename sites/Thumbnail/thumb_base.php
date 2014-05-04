<?php

define('VNP_SYSTEM', true);
define('VNP_APPLICATION', true);

$ThumbBaseDir = pathinfo($_SERVER['PHP_SELF'], PATHINFO_DIRNAME );
define('APP_BASE', $ThumbBaseDir);
define('APP_PATH',dirname(dirname(realpath(__FILE__)) . '/'));
define('BASE_PATH', dirname(APP_PATH) . '/');
define('SYSTEM_PATH', BASE_PATH . 'system/');

define('ROUTER_BASE', '/Thumbnail');

/**** Start Router first ****/
require BASE_PATH . 'system/core/Router/Router.php';
Router::Start(ROUTER_BASE);
/**** Image thumbnail handler ****/
Router::map('ThumbnailHandler', '/[i:Width]_[i:Height]/[*:ImageLocation].[jpg|png|gif:Ext]', 'ThumbnailHandler', 'GET|POST' );
$Params = Router::Match();
if($Params['name'] == 'ThumbnailHandler')
{
	$Params = $Params['params'];
	$ThumbWidth = $Params['Width'];
	$ThumbHeight = $Params['Height'];
	$ImageLocation = '/' . $Params['ImageLocation'] . '.' . $Params['Ext'];
	//echo $ImageLocation; exit();
	if(!defined('FILE_CACHE_DIRECTORY'))
		define('FILE_CACHE_DIRECTORY', BASE_PATH . 'data/cache/');
	require APP_PATH . '/Thumbnail/timthumb.php';
	timthumb::start($ThumbWidth, $ThumbHeight, $ImageLocation);
	exit();
	break;
}

?>