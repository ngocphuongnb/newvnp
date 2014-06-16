<?php

$stimer = microtime();
$memstart = memory_get_usage();

define('VNP_APPLICATION', true);
define('APPLICATION_NAME', 'clients');
define('APPLICATION_DIR', 'clients');
define('ENVIRONMENT', 'develop'); // develop, test, publish

define('BASE_PATH', dirname(realpath(__FILE__)) . DIRECTORY_SEPARATOR);
define('APPLICATION_PATH', BASE_PATH . APPLICATION_DIR . DIRECTORY_SEPARATOR);
define('ADMIN_SECTION', false);
define('GLOBAL_DATA_DIR', '/data/');
define('GLOBAL_BASE_URL', '/');

require BASE_PATH . 'base.php';
Boot::Run();

echo ( microtime() - $stimer);
$r = memory_get_usage() - $memstart;
echo '<br />' . convert($r);
function convert($size) {
	$unit=array('b','kb','mb','gb','tb','pb');
	return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}

?>