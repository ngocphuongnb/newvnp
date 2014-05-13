<?php

/**
 * Theme Class
 *
 * Theme Class
 *
 * @package		VNP
 * @subpackage	Base libraries
 * @author		VNP Dev team
 * @category	Base layer
 * @link		http://vnphp.com/docs/base-layer/libraries/DB-Driver.html
 */

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') ) die('Access denied!');

class Theme
{
	static $BaseDir;
	static $Theme;
	static $Title;
	static $MetaTags = array();
	static $Layout;
	static $BodyContent;
	static $CssComponents		= array();
	static $AjaxCssComponents	= array();
	
	static $Hook = array(	'header'		=> '',
							'footer'		=> '',
							'before_body'	=> '',
							'after_body'	=> ''
						);
	static $JsHeader = array();
	static $JsFooter = array();
	static $AjaxJsHeader = array();
	static $AjaxJsFooter = array();
	
	static $CssHeader = array();
	static $CssFooter = array();
	static $AjaxCssHeader = array();
	static $AjaxCssFooter = array();
	
	static $ThemeVariables = array();
	static $Config = array();
	static $Working = array();
	
	public function __construct()
	{
	}
	
	static function Config($ConfigArray = array()) {
		Theme::$Config = array(	'theme_root'		=> dirname(__FILE__),
								'default_theme'		=> 'vnp',
								'default_layout'	=> 'left.body',
								'theme'				=> '',
								'layout'			=> '',
								're_compile'		=> false,
								'is_cache'			=> ''
							);
		Theme::$Config = array_merge(Theme::$Config, $ConfigArray);
		if(Theme::$Config['theme'] == '') Theme::$Config['theme'] = Theme::$Config['default_theme'];
		if(Theme::$Config['layout'] == '') Theme::$Config['layout'] = Theme::$Config['default_layout'];
		Theme::$Working = Theme::$Config;
		Theme::$Title = 'VNP FW';
		Theme::$MetaTags['title'] = 'VNP FW';
	}
	
	static function SetLayout($Layout) {
		Theme::$Config['layout'] = $Layout;
	}	
	static function Layout($Layout) {
		Theme::$Config['layout'] = $Layout;
	}	
	static function SetTitle($Title) {
		Theme::$Title = $Title;
	}	
	static function MetaTag($Name, $Content) {
		Theme::$MetaTags[$Name] = $Content;
	}	
	static function ResetCssComponent() {
		Theme::$CssComponents = array();
	}	
	static function AddCssComponent($Components = '') {
		if(!empty($Components))
			if(defined('IS_AJAX'))
				Theme::$AjaxCssComponents = array_merge(Theme::$AjaxCssComponents, array_unique(explode(',', $Components)));
			else
				Theme::$CssComponents = array_merge(Theme::$CssComponents, array_unique(explode(',', $Components)));
	}	
	static function Assign($variable, $value = NULL) {
		if(is_array($variable)) Theme::$ThemeVariables += $variable;
		else Theme::$ThemeVariables[$variable] = $value;
	}	
	static function PrepareVariables() {
		//Theme::JsHeader('VNP_Object', 'var VNP = new BaseObject("' . $BaseUrl . '");', 'inline');
		Theme::$Hook['header'] = Theme::GetJs('JsHeader');
		Theme::$Hook['header'] .= Theme::GetCss('CssHeader');
		Theme::$Hook['footer'] = Theme::GetJs('JsFooter');
		Theme::$Hook['footer'] .= Theme::GetCss('CssFooter');
	}	
	static function JsHeader($Name, $JsString, $Type = 'file') {
		if(defined('IS_AJAX'))
			Theme::$AjaxJsHeader[$Name] = array('js_string' => $JsString, 'type' => $Type);
		else
			Theme::$JsHeader[$Name] = array('js_string' => $JsString, 'type' => $Type);
	}
	static function JsFooter($Name, $JsString, $Type = 'file') {
		if(defined('IS_AJAX'))
			Theme::$AjaxJsFooter[$Name] = array('js_string' => $JsString, 'type' => $Type);
		else
			Theme::$JsFooter[$Name] = array('js_string' => $JsString, 'type' => $Type);
	}
	
	static function CssHeader($Name, $CssString, $Type = 'file') {
		if(defined('IS_AJAX'))
			Theme::$AjaxCssHeader[$Name] = array('css_string' => $CssString, 'type' => $Type);
		else
			Theme::$CssHeader[$Name] = array('css_string' => $CssString, 'type' => $Type);
	}	
	static function CssFooter($Name, $CssString, $Type = 'file') {
		if(defined('IS_AJAX'))
			Theme::$AjaxCssFooter[$Name] = array('css_string' => $CssString, 'type' => $Type);
		else
			Theme::$CssFooter[$Name] = array('css_string' => $CssString, 'type' => $Type);
	}
	static function GetJs($Area = 'JsHeader') {
		$Return = array();
		foreach(Theme::$$Area as $Js) {
			if($Js['type'] == 'file')
				$Return[] = '<script type="text/javascript" src="' . $Js['js_string'] . '"></script>';
			else
				$Return[] = '<script type="text/javascript">' . $Js['js_string'] . '</script>';
		}
		return implode(PHP_EOL, $Return);
	}
	static function GetCss($Area = 'CssHeader') {
		$Return = array();
		foreach(Theme::$$Area as $Css) {
			if($Css['type'] == 'file')
				$Return[] = '<link rel="stylesheet" type="text/css" href="' . $Css['css_string'] . '"/>';
		}
		return implode(PHP_EOL, $Return);
	}
	static function GenerateCssComponents($VariableName) {
		$GeneratedStyleSheet = array();
		foreach(Theme::$$VariableName as $_c) {
			$_c = trim($_c);
			$GeneratedStyleSheet[] = '<link rel="stylesheet" type="text/css" href="' . GLOBAL_DATA_DIR . 'library/bootstrap/' . $_c . '/css/bootstrap.min.css" />';
		}
		return implode(PHP_EOL, $GeneratedStyleSheet);
	}	
	static function UseJquery($Version = '1.8.3') {
		if(!isset(Theme::$JsHeader['jquery-' . $Version]))
			Theme::JsHeader('jquery-' . $Version, GLOBAL_DATA_DIR . 'library/jquery-' . $Version . '.min.js');
	}	
	static function JqueryUI($Component, $Version = '1.10.4', $JqueryVersion = '1.8.3') {
		if(!isset(Theme::$JsHeader['jquery-' . $JqueryVersion]))
			Theme::JsHeader('jquery-' . $JqueryVersion, GLOBAL_DATA_DIR . 'library/jquery-' . $JqueryVersion . '.min.js');
		Theme::JsHeader('jqueryUI-' . $Version . '-' . $Component, GLOBAL_DATA_DIR . 'library/jquery-ui/jquery-ui-' . $Version . '.' . $Component . '.min.js');
	}
	
	static function PrepareTheme() {
		TPL::Config(	BASE_DIR,
						Theme::$Config['theme_root'] . Theme::$Working['theme'] . DIRECTORY_SEPARATOR,
						CACHE_PATH . 'compiled' . DIRECTORY_SEPARATOR,
						CACHE_PATH . 'html' . DIRECTORY_SEPARATOR,
						CACHE_PATH . 'compiled' . DIRECTORY_SEPARATOR
					);
	}
	static function Output() {
		Theme::PrepareTheme();
		Theme::PrepareVariables();
		$Output = TPL::File(Theme::$Working['layout'], Theme::$Working['re_compile'], Theme::$Working['is_cache']);
		$Output->Assign('META', Theme::$MetaTags);
		$Output->Assign('CssComponents', Theme::GenerateCssComponents('CssComponents'));
		$Output->Assign('Hook', Theme::$Hook);
		$Output->Assign('BODY', Theme::$BodyContent);
		$Output->Output(false);
	}
}

?>