<?php

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') ) die('Access denied!');

$AppConfig['DB']['host']		= 'localhost';
$AppConfig['DB']['name']		= '0_npvn';
$AppConfig['DB']['user']		= 'root';
$AppConfig['DB']['pass']		= '123';
$AppConfig['DB']['type']		= 'mysqli';
$AppConfig['DB']['prefix']		= '';


$AppConfig['main']['host']		= 'localhost';
$AppConfig['main']['name']		= '0_web2c';
$AppConfig['main']['user']		= 'root';
$AppConfig['main']['pass']		= '123';
$AppConfig['main']['type']		= 'mysqli';
$AppConfig['main']['prefix']		= '';

define('ROOT_DOMAIN', 'np.vn');

?>