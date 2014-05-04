<?php

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') ) die('Access denied!');

abstract class Controller
{
	public $Registry;
	abstract public function Main();
	public function View($File, $ReCompile = false, $IsCache = false) {
		return TPL::File($File, $ReCompile, $IsCache);
	}
	public function SetTitle($Title) {
		Theme::SetTitle($Title);
	}
	public function HookBefore($Target, $Action) {
	}
	public function HookAfter($Target, $Action) {
	}
}

?>