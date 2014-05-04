<?php

/**
 * Admin loader
 *
 * Boot up an application, detect running environment
 *
 * @package		VNP
 * @subpackage	Admin
 * @author		VNP Dev team
 * @category	Base layer
 * @link		http://vnphp.com/docs/base-layer/libraries/Boot.html
 */

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') && !defined('ADMIN_AREA') ) die('Access denied!');

class Loader
{
	static $Working = array('controller' => '', 'action' => '', 'params_string' => '');
	static $GetParams = array();
	
	public function __construct($Route)
	{
		$this->CheckUserDomain();
		Boot::library('Helper,Input,Filter,Cache');
		Helper::State('Quản trị', Router::BasePath() . '/');
		$this->ThemeLoader();
		$this->CheckWorkingSession($Route);
		$this->ThemeOutput();
	}
	
	protected function CheckUserDomain() {
		$UserInfo = DB::Query('customers', '', DB::Slave())->Where('subname', '=', USER_DOMAIN)->Cache(APP_CACHE_PATH)->Get();
		if($UserInfo->status && $UserInfo->num_rows == 1) {
			//if(DB::Prefix() == '') DB::SetPrefix(USER_DOMAIN);
			//else DB::SetPrefix(DB::Prefix() . '_' . USER_DOMAIN);
		}
		else {
			die('Website not found!');
		}
		
	}
	
	protected function ThemeLoader()
	{
		Theme::SetTheme('site_admin');
		Theme::SetLayout('left.body');
		Theme::AddCssComponent('BreadCrums,GridSystem,ReponsiveUtilities,Glyphicons,
								Alerts,Buttons,Pagination,Pager,Glyphicons,Typography');
		Theme::SetTitle('Admin Board!');
	}
	
	protected function CheckWorkingSession($Route)
	{
		if(isset($Route['ajax']) && in_array($Route['ajax'],array('json','text','state')))
			define('IS_AJAX', $Route['ajax']);
		$ControllerValidation = array('Controller', 'ControllerAction', 'ControllerParams');
		if(in_array($Route['name'],$ControllerValidation))
		{
			$_CTL = $Route['params']['controller'];
			$ControllerFile = ADMIN_PATH . 'controllers/' . $_CTL . '/' . $_CTL . '.php';
			if( file_exists($ControllerFile) )
			{
				$TplDir = ADMIN_PATH . 'controllers/' . $_CTL . '/template/';
				TPL::Config(ADMIN_BASE, $TplDir, $TplDir . 'complied/');
				define('CTL_PATH', ADMIN_PATH . 'controllers/' . $_CTL . '/');
				include ADMIN_PATH . 'controllers/' . $_CTL . '/' . $_CTL . '.php';
				$ControllerSession = new $_CTL();
				
				$_params = $ControllerAction = '';
				if($Route['name'] == 'Controller') {
					if(method_exists($ControllerSession, '_main'))
						$ControllerAction = '_main';
					else $ControllerAction = 'main';
				}
				elseif($Route['name'] == 'ControllerAction')
				{
					if(method_exists($ControllerSession, $Route['params']['action']))
						$ControllerAction = $Route['params']['action'];
					else trigger_error('Action not found!', E_USER_NOTICE);
				}
				elseif($Route['name'] == 'ControllerParams')
				{
					if(method_exists($ControllerSession, $Route['params']['action']))
						$ControllerAction = $Route['params']['action'];
					else trigger_error('Action not found!', E_USER_NOTICE);
					$_params = $Route['params']['params'];
				}
				Loader::$Working['controller']		= $_CTL;
				Loader::$Working['action']			= $ControllerAction;
				Loader::$Working['params_string']	= $_params;
				Loader::$GetParams					= Router::ExtractParams($_params);
				if( $ControllerAction != '' ) $ControllerSession->$ControllerAction(Loader::$GetParams);
			}
		}
	}
	
	protected function ThemeOutput()
	{
		Theme::Assign('State', Helper::GetState());
		Theme::Assign('Notify', Helper::GetNotify());
		Theme::$Body .= '<a onclick="var DBLogging = document.getElementById(\'DBLogging\'); DBLogging.style.display == \'block\' ? DBLogging.style.display = \'none\': DBLogging.style.display = \'block\'; return false;" href="#">Logging</a><div id="DBLogging" style="display: none">' . p(DB::Log()) . '</div>';
		Theme::CssHeader('ResponsiveMenuCss', CDN_SERVER . '/' . APPLICATION_NAME . '/data/themes/vnp_admin/css/RSMenu.css');
		Theme::JsHeader('ResponsiveMenuJs', CDN_SERVER . '/' . APPLICATION_NAME . '/data/themes/vnp_admin/js/RSMenu.js');
		Theme::JsFooter('ActiveRSMenu', 'var nav = responsiveNav(\'#left-sidebar\', {customToggle: \'.nav-toggle\', animate: true,transition: 284});', 'inline');
		Theme::Show();
	}
}


?>