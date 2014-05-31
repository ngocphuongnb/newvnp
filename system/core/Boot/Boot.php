<?php

/**
 * Boot up Class
 *
 * Boot up an application, detect running environment
 *
 * @package		VNP
 * @subpackage	Base libraries
 * @author		VNP Dev team
 * @category	Base layer
 * @link		http://vnphp.com/docs/base-layer/libraries/Boot.html
 */

//namespace System;
if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') ) die('Access denied!');

class G
{
	static $WorkingSession;
	static $ValidWorkingSession = Boot::GUEST_SESSION;
	static $Loader;
	static $Session;
	static $User;
	static $Theme;
	static $RouteObj;
	static $Route;
	static $Config;
	static $Error;
	static $Registry;
}

class Boot {
	//System message//
	const ERROR_CONTROLLER_NOT_FOUND	= 'Error: Controller not found!';
	const ADMIN_SESSION		= '_AdminSession';
	const MEMBER_SESSION	= '_MemberSession';
	const GUEST_SESSION		= '_GuestSession';
	const WORKING_SESSION	= '_WorkingSession';
	
	static $App = array();
	static $Config = array();
	
	/**
	 * Application initializer
	 *
	 * @return no
	 */
	static function ApplicationConfig($AppConfig = array())
	{
		G::$Config = $AppConfig;
	}
	
	static function RequirePermision($Session) {
		G::$ValidWorkingSession = $Session;
	}
	
	static function Start() {
		require SYSTEM_PATH . 'core/Error/Error.php';
		require SYSTEM_PATH . 'core/Output/Output.php';
		require SYSTEM_PATH . 'core/Helper/Helper.php';
		require SYSTEM_PATH . 'core/Router/Router.php';
		require SYSTEM_PATH . 'core/Template/Template.php';
		require SYSTEM_PATH . 'core/Session/Session.php';
		require SYSTEM_PATH . 'core/User/User.php';
		require SYSTEM_PATH . 'core/Theme/Theme.php';
		require SYSTEM_PATH . 'core/Crypt/Crypt.php';
		require SYSTEM_PATH . 'core/Form/Form.php';
		require SYSTEM_PATH . 'core/Input/Input.php';
		require SYSTEM_PATH . 'core/DB/DB.php';
		require SYSTEM_PATH . 'core/File/File.php';
		require SYSTEM_PATH . 'core/DB/' . G::$Config['DB']['main']['type'] . 'DBWrapper.php';
		
		DB::$Config		= G::$Config['DB']['main'];
		G::$Error		= new ErrorHandler();
		G::$RouteObj	= Router::Start(rtrim(BASE_DIR, '/'));
		G::$Session		= new Session();
		G::$User		= new User();
		Theme::Config(array(
						'theme_root'		=> DATA_PATH . 'theme' . DIRECTORY_SEPARATOR,
						'default_theme'		=> 'vnp',
						'default_layout'	=> 'left.body'
					));
		TPL::Config(	BASE_DIR,
						TEMPLATE_PATH,
						CACHE_PATH . 'compiled' . DIRECTORY_SEPARATOR,
						CACHE_PATH . 'html' . DIRECTORY_SEPARATOR,
						CACHE_PATH . 'compiled' . DIRECTORY_SEPARATOR
					);
		
		G::$WorkingSession = Boot::GUEST_SESSION;
		G::$Session->Set(Boot::WORKING_SESSION, Boot::GUEST_SESSION);
		Form::$CompiledPath = CACHE_PATH . 'form' . DIRECTORY_SEPARATOR;
		
		Router::Map('LoginAction', '/login', 'User#Login', 'POST');
		Router::Map('LogoutAction', '/logout', 'User#Logout', 'GET|POST');
		
		/* Ajax working Mapper */
		Router::Map('Ajax_Controller',
					'/ajax/[json|text|state:Ajax_Mod]/[:controller]/',
					'ControllerSection', 'GET|POST' );
		Router::Map('Ajax_ControllerAction',
					'/ajax/[json|text|state:Ajax_Mod]/[:controller]/[:action]/',
					'ControllerSection', 'GET|POST' );
		Router::Map('Ajax_ControllerParams',
					'/ajax/[json|text|state:Ajax_Mod]/[:controller]/[:action]/[*:params]/',
					'ControllerSection', 'GET|POST' );
		/* End ajax working Mapper */
		
		Router::Map('Controller', '/[:controller]/', 'ControllerSection', 'GET|POST' );
		Router::Map('ControllerAction', '/[:controller]/[:action]/', 'ControllerSection', 'GET|POST' );
		Router::Map('ControllerParams', '/[:controller]/[:action]/[*:params]/', 'ControllerSection', 'GET|POST' );
	}
	
	static function Library($LibrariesUsing)
	{
		$l = explode(',', $LibrariesUsing);
		foreach($l as $_lib) {
			$_libFile = SYSTEM_PATH . 'core' . DIRECTORY_SEPARATOR . $_lib . DIRECTORY_SEPARATOR . $_lib . '.php';
			if( file_exists($_libFile) ) include $_libFile;
			else trigger_error($_lib . ' does not existed!');
		}
	}
	
	static function Run() {
		G::$Route = Router::Match();
		if(G::$Route['name'] == 'LoginAction') {
			G::$User->CheckLogin(Input::Post('username'), Input::Post('password'));
			if(G::$User->IsLogged()) header('LOCATION:' . BASE_DIR);
		}
		if(G::$Route['name'] == 'LogoutAction') {
			G::$User->Logout();
			header('LOCATION:' . BASE_DIR);
		}
		
		if(G::$ValidWorkingSession == Boot::GUEST_SESSION) {
		}
		else {
			//if(!G::$User->IsLogged() || G::$WorkingSession !=  Boot::ADMIN_SESSION) {
			if(!G::$User->IsLogged()) {
				TPL::File('login')
					->SetDir('TPLFileDir', TEMPLATE_PATH)
					->SetDir('CompiledDir', CACHE_PATH . 'compiled' . DIRECTORY_SEPARATOR)
					->SetDir('CacheDir', CACHE_PATH . 'html' . DIRECTORY_SEPARATOR)
					->Output(false);
			}
			else {
				Boot::ControllerAction();
				Theme::$AjaxSession = G::$Registry['Ajax'];
				Theme::Output();
			}
		}
	}
	
	static function ControllerAction() {
		if(empty(G::$Route) || G::$Route['target'] == 'ControllerSection') {
			require SYSTEM_PATH . 'core/Controller/Controller.php';
			$Controller = G::$Route['params']['controller'];
			isset(G::$Route['params']['action']) ? $Action = G::$Route['params']['action'] : $Action = 'Main';
			isset(G::$Route['params']['params']) ? $Params = Router::ExtractParams(G::$Route['params']['params'])
												 : $Params = array();
			if(file_exists(CONTROLLER_PATH . $Controller . DIRECTORY_SEPARATOR . $Controller . '.php')) {
				require CONTROLLER_PATH . $Controller . DIRECTORY_SEPARATOR . $Controller . '.php';
				TPL::Config(	BASE_DIR,
								CONTROLLER_PATH . $Controller . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR,
								CACHE_PATH . 'compiled' . DIRECTORY_SEPARATOR,
								CACHE_PATH . 'html' . DIRECTORY_SEPARATOR,
								CACHE_PATH . 'compiled' . DIRECTORY_SEPARATOR
							);
				G::$Registry['Ajax']		= isset(G::$Route['ajax']) ? G::$Route['ajax'] : false;
				G::$Registry['Params']		= $Params;
				G::$Registry['ControllerAction']	= $Action;
				G::$Registry['Controller']	= new $Controller;
				G::$Registry['Controller']->ControllerInitializer();
				if(method_exists(G::$Registry['Controller'], 'Construct')) G::$Registry['Controller']->Construct();
				G::$Registry['Controller']->$Action();
			}
			else {
				//trigger_error(Boot::ERROR_CONTROLLER_NOT_FOUND);
			}
		}
	}
}

?>