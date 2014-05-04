<?php

$stimer = microtime();
$memstart = memory_get_usage();

define('VNP_APPLICATION', true);
define('APPLICATION_NAME', 'sites');
define('APPLICATION_DIR', 'sites');
define('ENVIRONMENT', 'develop'); // develop, test, publish

define('APP_BASE', '');
define('BASE_PATH', dirname(dirname(realpath(__FILE__))) . '/');
define('AdminDirectory', 'admincp');
define('ADMIN_FOLDER', AdminDirectory);
define('ADMIN_AREA', true);
define('ADMIN_PATH', BASE_PATH . APPLICATION_DIR . '/admin/');

require BASE_PATH . 'constant.php';
require BASE_PATH . '/base.php';
define('USER_DOMAIN', str_replace('.' . ROOT_DOMAIN,'',$_SERVER['SERVER_NAME']));
define('USER_PATH', BASE_PATH . 'customers/' . USER_DOMAIN . '/');
define('USER_CACHE_PATH', USER_PATH . 'data/cache/');

Router::Start('/' . AdminDirectory);
define('APP_PATH', BASE_PATH . APPLICATION_DIR . '/');
define('APP_CACHE_PATH', APP_PATH . 'data/cache/');
require APP_PATH . '/admin_loader.php';

/* Ajax working mapper */
Router::map('Ajax_Controller', '/ajax/[json|text|state:Ajax_Mod]/[:controller]/', 'Ajax_Controller', 'GET|POST' );
Router::map('Ajax_ControllerAction', '/ajax/[json|text|state:Ajax_Mod]/[:controller]/[:action]/', 'Ajax_ControllerAction', 'GET|POST' );
Router::map('Ajax_ControllerParams', '/ajax/[json|text|state:Ajax_Mod]/[:controller]/[:action]/[*:params]/', 'Ajax_ControllerParams', 'GET|POST' );
/* End ajax working mapper */
Router::map('UserLogin', '/login/', 'UserLogin', 'POST' );
Router::map('UserLogged', '/login/', 'UserLogged', 'GET' );
Router::map('UserLogout', '/logout/', 'UserLogout', 'GET' );

Router::map('Controller', '/[:controller]/', 'Controller', 'GET|POST' );
Router::map('ControllerAction', '/[:controller]/[:action]/', 'ControllerAction', 'GET|POST' );
Router::map('ControllerParams', '/[:controller]/[:action]/[*:params]/', 'ControllerParams', 'GET|POST' );
require APP_PATH . '/routes.php';

$ClientRequest = Router::Match();

TPL::Config(SITE_BASE, APPLICATION_PATH . 'data/template/complied/', APPLICATION_DIR . 'data/template/tpl/');

switch($ClientRequest['name'])
{
	case 'UserLogin':
	{
		//G::$User->CheckLogin($_POST['username'], $_POST['password']);
		G::$User->CheckCustomerLogin($_POST['username'], $_POST['password']);
		header('LOCATION:' . ADMIN_BASE);
		break;
	}
	case 'UserLogged':
	{
		//header('LOCATION:' . ADMIN_BASE);
		break;
	}
	case 'UserLogout':
	{
		G::$User->Logout();
		header('LOCATION:' . ADMIN_BASE);
		break;
	}
}

if( G::$User->IsLogged() )
{
	new Loader($ClientRequest);
}
else
{
	TPL::Config(SITE_BASE, APPLICATION_PATH . 'template/tpl/', APPLICATION_PATH . 'template/complied/');
	$LoginForm = TPL::File('login');
	$LoginForm->Assign('loginAction', Router::Generate('UserLogin'));
	$LoginForm->Output(false);
	//exit();
}

$r = memory_get_usage() - $memstart;

//echo convert($r);
//echo '<br />' .( microtime() - $stimer);

function convert($size) {
	$unit=array('b','kb','mb','gb','tb','pb');
	return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}


?>