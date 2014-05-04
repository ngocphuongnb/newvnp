<?php

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') && !defined('ADMIN_AREA') ) die('Access denied!');
define('UPLOAD_PATH', USER_PATH . 'data/uploads/');
define('UPLOAD_BASE', '/data/uploads/');

require BASE_PATH . 'admin/controllers/File/File.php';

?>