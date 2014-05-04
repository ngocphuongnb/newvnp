<?php

/**
 * Router Class
 *
 * Application error handler
 *
 * @package		VNP
 * @subpackage	Base libraries
 * @author		VNP Dev team
 * @category	Base layer
 * @link		http://vnphp.com/docs/base-layer/libraries/Error.html
 */

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') ) die('Access denied!');

//require SYSTEM_PATH . 'core/Template/NTPLEngine/NTPL.class.php';
require SYSTEM_PATH . 'core/Template/Exception.php';
require SYSTEM_PATH . 'core/Template/class.VTE.php';

class TPL
{
	static function Config($BaseUrl = NULL, $TPLDir = 'tpl/', $CompiledDir = '', $CacheDir = 'tmp/', $MergedDir = '', $Debug = false)
	{
		VTE::$TPLFileDir	= $TPLDir;
		VTE::$CompiledDir	= $CompiledDir;
		VTE::$CacheDir		= $CacheDir;
		VTE::$MergedDir		= $MergedDir;
	}
	
	static function File($TPLFile = '', $ReCompile = false, $IsCache = false) {
		$TPL = new VTE();
		return $TPL->File($TPLFile, $ReCompile, $IsCache);
	}
	static function Merge() {
		$Parameters = func_get_args();
		$TPL = new MergedTPL();
		return $TPL->Merge($Parameters);
	}
	
	static function Source($TemplateFileName, $TPLString = '', $CustomDir = '', $CompileDir = '')
	{
		return new NTPL($TemplateFileName,$CustomDir,$CompileDir, $TPLString);
	}
}

?>