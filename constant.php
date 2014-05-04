<?php

if(!defined('ADMIN_FOLDER')) define('ADMIN_FOLDER', 'admin');
define('DATA_FOLDER', 'data');
define('SYSTEM_PATH', BASE_PATH . 'system/');
define('DATA_PATH', BASE_PATH . DATA_FOLDER . '/');
define('SESSION_PATH', BASE_PATH . 'data/session/');
define('DBWRAPPER_CLASS_NAME', 'MysqliDBWrapper.php');
define('ThumbBase', '/Thumbnail/');
define('URL_EXT', '.html');
define('PRODUCT_HASHID', 6);
define('ARTICLE_HASHID', 3);

if( APP_BASE != '/') {
	define('SITE_BASE', APP_BASE . '/');
	define('ROUTER_BASE', APP_BASE );
}
else {
	define('SITE_BASE', '/');
	define('ROUTER_BASE', '/');
}

define('CDN_SERVER', 'http://static.npcdn.com');

define('APPLICATION_BASE', SITE_BASE . APPLICATION_DIR . '/');
define('APPLICATION_PATH', BASE_PATH . APPLICATION_DIR . '/');
define('ADMIN_BASE', SITE_BASE . ADMIN_FOLDER . '/');
define('DATA_DIR', CDN_SERVER . '/' . DATA_FOLDER . '/');

?>