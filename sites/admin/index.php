<?php

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') && !defined('VNP_APPLICATION_ADMIN') ) die('Access denied!');

TPL::Config(SITE_BASE, APPLICATION_PATH . 'admin/template/tpl/', APPLICATION_PATH . 'admin/template/complied/');
Router::map('UserLogin', '/admin/login', 'AdminLogin', 'POST|GET' );

n(Router::Match());

if( G::$User->IsLogged() )
{
}
else
{
	$LoginForm = TPL::File('login');
	$LoginForm->assign('loginAction', Router::Generate('UserLogin'));
	$LoginForm->Output();
	exit();
}

?>