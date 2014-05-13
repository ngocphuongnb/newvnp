<?php

function n($str)
{
	echo '<pre>';
	echo '<code class="VNP_CodeBlock">';
	print_r($str);
	echo '</code>';
	echo '</pre>';
}

function p($data)
{
	$str = '<pre><code class="VNP_CodeBlock">';
	$str .= print_r($data, true);
	$str .= '</code></pre>';
	Theme::$Hook['before_body'] .= $str;
}

?>