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

require BASE_PATH . 'base.php';
define('GLOBAL_DATA_DIR', '/data/');
Boot::RequirePermision(Boot::ADMIN_SESSION);
Boot::Run();
?>
<div class="VNP_SysStat">
	<span class="glyphicon glyphicon-time"></span>&nbsp;Time:&nbsp;<?php echo (microtime() - $stimer) ?> s&nbsp;&nbsp;&nbsp;
    <span class="glyphicon glyphicon-stats"></span>&nbsp;Memory:&nbsp;<?php echo convert((memory_get_usage() - $memstart)) ?>
</div>
<?php
function convert($size) {
	$unit=array('b','kb','mb','gb','tb','pb');
	return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}

?>