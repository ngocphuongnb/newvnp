<?php

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') ) die('Access denied!');

define('DATA_DIR', 'data');
define('SESSION_DIR', 'session');
define('TEMPLATE_DIR', 'template');
define('CACHE_DIR', 'cache');
define('SESSION_PATH', APPLICATION_PATH . DATA_DIR . DIRECTORY_SEPARATOR . SESSION_DIR . DIRECTORY_SEPARATOR);
define('TEMPLATE_PATH', APPLICATION_PATH . DATA_DIR . DIRECTORY_SEPARATOR . TEMPLATE_DIR . DIRECTORY_SEPARATOR);
define('CACHE_PATH', APPLICATION_PATH . DATA_DIR . DIRECTORY_SEPARATOR . CACHE_DIR . DIRECTORY_SEPARATOR);

$AppConfig['DB']['main']['host']	= 'localhost';
$AppConfig['DB']['main']['name']	= '1_web';
$AppConfig['DB']['main']['user']	= 'root';
$AppConfig['DB']['main']['pass']	= '123';
$AppConfig['DB']['main']['type']	= 'mysqli';
$AppConfig['DB']['main']['prefix']	= '';

/*$AppConfig['DB']['master'][] = array(	'host'		=> 'localhost',
										'name'		=> 'newvnp',
										'user'		=> 'root',
										'pass'		=> '123',
										'type'		=> 'mysqli',
										'prefix'	=> ''
									);
$AppConfig['DB']['slave'][] = array(	'host'		=> 'localhost',
										'name'		=> 'newvnp',
										'user'		=> 'root',
										'pass'		=> '123',
										'type'		=> 'mysqli',
										'prefix'	=> ''
									);*/




?>