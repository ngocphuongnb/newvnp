<?php

/**
 * DB Driver Class
 *
 * DB Driver Class
 *
 * @package		VNP
 * @subpackage	Base libraries
 * @author		VNP Dev team
 * @category	Base layer
 * @link		http://vnphp.com/docs/base-layer/libraries/DB-Driver.html
 */

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') ) die('Access denied!');

class DB
{
	static $PARAM_TYPES	= array('i', 's', 'b', 'd');
	static $PARAM_NUMBER	= array('i');
	static $PARAM_STRING	= array('s');
	/**
	 *  Param variable type define
	 */
	const NUMBER	= 'i';
	const NUM		= 'i';
	const INTERGER	= 'i';
	const INT		= 'i';
	const TEXT		= 's';
	const STRING	= 's';
	const STR		= 's';
	const BLOB		= 'b';
	const DOUBLE	= 'd';
	
	/**
	 *  Multi param relationship
	 */
	const ONEOF		= 'oneof';
	const ALLOF		= 'allof';
	const NONEOF	= 'noneof';
	const NOTALL	= 'notall';
	
	/**
	 *  Custom variable type
	 */
	const PLAINTEXT	= 'ToPlaintext';
	
	static $Config	= array(
								'host'		=> 'localhost',
								'user'		=> NULL,
								'pass'		=> NULL,
								'name'		=> NULL,
								'port'		=> NULL,
								'charset'	=> 'utf8',
								'prefix'	=> '',
								'debug'		=> 1
								);
	static $Slave	= array();
	static $Log		= array(
								'total_query'	=> 0,
								'query'			=> array()
							);
	static $PrefixBU = '';
	
	static function Query($TableName, $AddPrefix = '', $DBConfig = array())
	{
		if(empty($DBConfig)) $DBConfig = DB::$Config;
		if($AddPrefix != '') {
			DB::SetPrefix($AddPrefix);
			$DBConfig['prefix'] = DB::Prefix();
		}
		$Obj = new DBWrapper($DBConfig);
		return $Obj->Query($TableName);
	}
	
	static function CustomQuery($SQL, $AddPrefix = '', $DBConfig = array())
	{
		if(empty($DBConfig)) $DBConfig = DB::$Config;
		if($AddPrefix != '') {
			if(DB::Prefix() == '') DB::SetPrefix($AddPrefix);
			else DB::SetPrefix(DB::Prefix() . '_' . $AddPrefix);
			$DBConfig['prefix'] = DB::Prefix();
		}
		$Obj = new DBWrapper($DBConfig);
		return $Obj->CustomQuery($SQL);
	}
	
	static function Object($DBConfig = array())
	{
		if(empty($DBConfig)) $DBConfig = DB::$Config;
		if($AddPrefix != '') {
			if(DB::Prefix() == '') DB::SetPrefix($AddPrefix);
			else DB::SetPrefix(DB::Prefix() . '_' . $AddPrefix);
			$DBConfig['prefix'] = DB::Prefix();
		}
		$Obj = new DBWrapper($DBConfig);
		return $Obj;
	}
	
	static function Log()
	{
		return DB::$Log;
	}
	
	static function Prefix()
	{
		return DB::$Config['prefix'];
	}
	
	static function SetPrefix($Prefix)
	{
		DB::$Config['prefix'] = $Prefix;
	}
	
	static function BackUpPrefix() {
		DB::$PrefixBU = DB::Prefix();
	}
	
	static function RestorePrefix() {
		DB::SetPrefix(DB::$PrefixBU);
	}
	
	static function Slave($Name = 'main') {
		return DB::$Slave[$Name];
	}
}

?>