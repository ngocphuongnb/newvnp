<?php

/**
 * Crypt Class
 *
 * Crypt Class
 *
 * @package		VNP
 * @subpackage	Base libraries
 * @author		VNP Dev team
 * @category	Base layer
 * @link		http://vnphp.com/docs/base-layer/libraries/Helper.html
 */

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') ) die('Access denied!');
require SYSTEM_PATH . 'core/Crypt/Hashids/Hashids.php';
class Crypt
{
	static function EncryptHashID()
	{
		$hashids = new Hashids\Hashids(md5(USER_DOMAIN), 5);
		$numbers = func_get_args();
		return call_user_func_array( array($hashids, 'encrypt'), $numbers);
	}
	
	static function DecryptHashID($hash)
	{
		$hashids = new Hashids\Hashids(md5(USER_DOMAIN), 5);
		return $hashids->decrypt($hash);
	}
}

?>