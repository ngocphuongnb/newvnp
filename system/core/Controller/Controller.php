<?php

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') ) die('Access denied!');

abstract class Controller
{
	public $Registry;
	abstract public function Main();
	public function __construct() {
		//$this->Registry = G::$Registry;
	}
	public function ControllerInitializer() {
		$this->ControllerAction = G::$Registry['ControllerAction'];
		$this->Registry = G::$Registry;
	}
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
	public function UseCssComponents($Components){
		Theme::AddCssComponent($Components);
	}
	public function Render($Content, $ConfigArray = array()) {
		$Config = array(	'layout'		=> Theme::$Config['layout'],
							'theme'			=> Theme::$Config['theme'],
							're_compile'	=> false,
							'is_cache'		=> false,
						);
		$Config = array_merge($Config, $ConfigArray);
		Theme::$BodyContent .= $Content;
		if($Config['layout'] != '') Theme::$Working['layout'] = $Config['layout'];
		//else Theme::$Working['layout'] = Theme::$Config['layout'];
		if($Config['theme'] != '') Theme::$Working['theme']	= $Config['theme'];
		//else Theme::$Working['theme'] = Theme::$Config['theme'];
		Theme::$Working['re_compile']	= $Config['re_compile'];
		Theme::$Working['is_cache']	= $Config['is_cache'];
		//n(Theme::$Working);
	}
	public function ControllerAddress($FilePath, $Type = 'url') {
		$PDPath = realpath(dirname($FilePath));
		if($Type == 'url')
			return GLOBAL_BASE_URL . APPLICATION_NAME . '/' . CONTROLLER_DIR . '/' . basename($PDPath) . '/';
		elseif($Type == 'path') return $PDPath;
		else return '';
	}
}

?>