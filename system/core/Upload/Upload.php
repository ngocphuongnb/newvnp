<?php

/**
 * Upload Class
 *
 * Upload Class
 *
 * @package		VNP
 * @subpackage	Base libraries
 * @author		VNP Dev team
 * @category	Base layer
 * @link		http://vnphp.com/docs/base-layer/libraries/DB-Driver.html
 */

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') ) die('Access denied!');

class Upload
{
	static function Start($Files)
	{
		require SYSTEM_PATH . 'core/Upload/class.upload.php';
		return new upload_base($Files);
	}
}

?>