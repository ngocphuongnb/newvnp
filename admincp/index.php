<?php

$stimer = microtime();
$memstart = memory_get_usage();

define('VNP_APPLICATION', true);
define('APPLICATION_NAME', 'clients');
define('APPLICATION_DIR', 'clients');
define('ENVIRONMENT', 'develop'); // develop, test, publish

define('BASE_PATH', dirname(dirname(realpath(__FILE__))) . DIRECTORY_SEPARATOR);
define('APPLICATION_PATH', BASE_PATH . APPLICATION_DIR . DIRECTORY_SEPARATOR);
define('ADMIN_SECTION', false);
define('GLOBAL_DATA_DIR', '/data/');
define('GLOBAL_BASE_URL', '/');
define('ADMIN_AREA', true);
require BASE_PATH . 'base.php';
Theme::AddCssComponent('GridSystem,Glyphicons,Code,Labels');
Boot::RequirePermision(Boot::ADMIN_SESSION);
Boot::Run();
//DB::Query('users')->Where('userid', 'INCLUDE', '1')->Get();

/*
DB::Query('users1')->Get();
DB::Query('users')->Get();
DB::Query('users1')->Get();
DB::Query('users1')->Get();*/
$time	= microtime() - $stimer;
$mem	= memory_get_usage() - $memstart;
VNP_AdminLogPanel($time, $mem);
?>