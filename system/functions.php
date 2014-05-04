<?php

function n($str)
{
	echo '<pre>';
	print_r($str);
	echo '</pre>';
}

function p($data)
{
	$return = '<pre>' . print_r($data, true) . '</pre>';
	return $return;
}

?>