<?php

if( !defined('VNP_APPLICATION') && !defined('APPLICATION_NAME') ) die('Application not found!');

define('VNP_SYSTEM', true);
define('CURRENT_TIME', time());

$base_siteurl = pathinfo( $_SERVER['PHP_SELF'], PATHINFO_DIRNAME );
if( $base_siteurl == DIRECTORY_SEPARATOR ) $base_siteurl = '';
if( ! empty( $base_siteurl ) ) $base_siteurl = str_replace( DIRECTORY_SEPARATOR, '/', $base_siteurl );
if( ! empty( $base_siteurl ) ) $base_siteurl = preg_replace( "/[\/]+$/", '', $base_siteurl );
if( ! empty( $base_siteurl ) ) $base_siteurl = preg_replace( "/^[\/]*(.*)$/", '/\\1', $base_siteurl );
$base_siteurl .= '/';
define('BASE_DIR', $base_siteurl);
define('CONTROLLER_DIR', 'controller');
if(!defined('GLOBAL_BASE_URL')) define('GLOBAL_BASE_URL', BASE_DIR);

define('SYSTEM_PATH', BASE_PATH . 'system' . DIRECTORY_SEPARATOR);
define('DATA_PATH', APPLICATION_PATH . 'data' . DIRECTORY_SEPARATOR);
define('CONTROLLER_PATH', APPLICATION_PATH . CONTROLLER_DIR . DIRECTORY_SEPARATOR);
if(!defined('ADMIN_SECTION')) define('ADMIN_SECTION', false);
define('ROUTER_EXTRA_KEY', md5('vnp_extra_key_' . microtime()));

if(ENVIRONMENT == 'develop') {
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(-1);
}

if(file_exists(SYSTEM_PATH . 'functions.php'))
	require SYSTEM_PATH . 'functions.php';
else die('Main functions file doesn\'t existed!');
if(file_exists(SYSTEM_PATH . 'core/Boot/Boot.php'))
	require SYSTEM_PATH . 'core/Boot/Boot.php';
else die('Bootstrap load failed!');
if(file_exists(APPLICATION_PATH . APPLICATION_NAME . '.php'))
	require APPLICATION_PATH . APPLICATION_NAME . '.php';
else die('Application main file doesn\'t existed!');
if(file_exists(APPLICATION_PATH . 'config.php'))
	require APPLICATION_PATH . 'config.php';
else die('Application config file doesn\'t existed!');

Boot::ApplicationConfig($AppConfig);
Boot::Start();

if(!defined('STATIC_FILE_SERVER')) define('STATIC_FILE_SERVER', BASE_DIR);

if(file_exists(APPLICATION_PATH . 'routes.php')) include(APPLICATION_PATH . '/routes.php');

?>