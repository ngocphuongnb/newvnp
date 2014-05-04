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

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') ) die('Access denied!');

switch($ClientRequest['name'])
{
	case 'UserLogin':
	{
		G::$User->CheckLogin($_POST['username'], $_POST['password']);
		header('LOCATION:' . ADMIN_BASE);
		break;
	}
	case 'UserLogged':
	{
		header('LOCATION:' . ADMIN_BASE);
		break;
	}
	case 'UserLogout':
	{
		G::$User->Logout();
		header('LOCATION:' . ADMIN_BASE);
		break;
	}
}

class Loader
{
	static $Working = array('controller' => '', 'action' => '', 'params_string' => '');
	static $GetParams = array();
	protected $Site = array();
	protected $Settings = array();
	
	public function __construct($Route)
	{
		Boot::library('Helper,Input,Filter,Cache');
		$this->GetSiteData();
		$this->ThemeLoader();
		
		if(!$this->MainSiteFunction($Route))
			$this->CheckWorkingSession($Route);
		$this->ThemeOutput($Route);
	}
	
	protected function ThemeLoader()
	{
		Theme::SetTheme($this->Site['theme']);
		Theme::SetLayout($this->Site['layout']);
		Theme::SetTitle($this->Site['site_data']['site_name']);
		Theme::MetaTag('description', $this->Site['site_data']['site_description']);
	}
	
	protected function MainSiteFunction($Route)
	{
		if($Route['name'] == 'ProductHome') {
			$_CTL = 'Product';
			$_Action = '_main';
		}
		if($Route['name'] == 'ProductCategory' || $Route['name'] == 'ProductCategoryPage') {
			$_CTL = 'Product';
			$_Action = 'Category';
		}
		if($Route['name'] == 'ProductDetail') {
			$_CTL = 'Product';
			$_Action = 'Detail';
		}
		
		$ControllerFile = APP_PATH . 'controllers/' . $_CTL . '/' . $_CTL . '.php';
		if( file_exists($ControllerFile) )
		{
			$TplDir = APP_PATH . 'controllers/' . $_CTL . '/template/';
			
			TPL::Config(SITE_BASE, $TplDir, USER_CACHE_PATH . 'template/' . Theme::$CurrentTheme . '/');
			include APP_PATH . 'controllers/' . $_CTL . '/' . $_CTL . '.php';
			$ControllerSession = new $_CTL();
			
			Loader::$Working['controller']		= $_CTL;
			Loader::$Working['action']			= $_Action;
			
			if(isset($Route['params'])) {
				Loader::$GetParams = $Route['params'];
			}
			if( $_Action != '' ) $ControllerSession->$_Action($Route);
			return true;
		}
		return false;
	}
	
	protected function CheckWorkingSession($Route)
	{
	}
	
	protected function ThemeOutput($Route)
	{
	}
	
	private function AdminPanel($InDesignMod = false) {
		TPL::Config(SITE_BASE, APPLICATION_PATH . 'data/template/tpl/',  APPLICATION_PATH . 'data/template/complied/');
		$Panel = TPL::File('admin_panel');
		$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
		$Panel->Assign('CurrentState', $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
		$Panel->Assign('InDesignMod', $InDesignMod);
		return $Panel->Output();
	}
	
	private function DesignPanel() {
		TPL::Config(SITE_BASE, APPLICATION_PATH . 'data/template/tpl/',  APPLICATION_PATH . 'data/template/complied/');
		$Panel = TPL::File('design_panel');
		return $Panel->Output();
	}
}


?>