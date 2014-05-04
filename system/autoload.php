<?php

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') ) die('Access denied!');

spl_autoload_register('SystemBaseAutoloader');

function SystemBaseAutoloader($ClassName)
{
    include SYSTEM_PATH . 'core/' . $ClassName . '/' . $ClassName . '.php';
	
	//throw new Exception('SystemBaseAutoloader: Unable to load ' . $ClassName . ' class!');
}

?>