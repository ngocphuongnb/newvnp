<?php

/**
 * Output Class
 *
 * Handle output data
 *
 * @package		VNP
 * @subpackage	Base libraries
 * @author		VNP Dev team
 * @category	Base layer
 * @link		http://vnphp.com/docs/base-layer/libraries/Helper.html
 */

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') ) die('Access denied!');
define('VNP_OUTPUT_CLASS', true);

class Output
{
	static $CurrentPageUrl;
	static $TotalPages;
	static $Paging = array('total_pages' => 0, 'current_page' => 0, 'base_url' => '', 'ext' => '/', 'bridge' => '/');
	
	static function Paging($PageParams = NULL)
	{
		$GetParams = array_filter(Loader::$GetParams);
		if(!isset($GetParams['page'])) $CurrentPage = 0;
		else
		{
			$CurrentPage = $GetParams['page'] - 1;
			unset($GetParams['page']);
		}
		$GetParams = array_map(function($v, $k) {return $k . '/' . $v;}, $GetParams, array_keys($GetParams));
		$_param = !empty($GetParams) ? implode('/', $GetParams) . '/' : '';
		Output::$CurrentPageUrl =
			Router::BasePath() . '/' . 
			Loader::$Working['controller'];
		if(empty($Working['action'])) Output::$CurrentPageUrl .= '/' . Loader::$Working['action'] . $_param;
		Output::$Paging['base_url']		= Output::$CurrentPageUrl;
		Output::$Paging['current_page'] = $CurrentPage;
		return $CurrentPage;
	}
	
	static function Page()
	{
		$PageOutput = array();
		$Page = Output::$Paging;
		for($i = 1; $i <= $Page['total_pages']; $i++)
		{
			if($i == 1) $url = $Page['base_url'] . $Page['ext'];
			else $url = $Page['base_url'] . '/page' . $Page['bridge'] . $i . $Page['ext'];
			
			if($Page['current_page'] + 1 == $i)
				$PageOutput[] = '<li class="active"><a>' . $i . '</a></li>';
			else
				$PageOutput[] = '<li><a href="' . $url . '">' . $i . '</a></li>';
		}
		if($Page['current_page'] + 1 > 1)
		{
			if($Page['current_page']  == 1)
				$PrevPage = array($Page['base_url'] . $Page['ext'], '');
			else
				$PrevPage = array($Page['base_url'] . '/page' . $Page['bridge'] . $Page['current_page'] . $Page['ext'], '');
		}
		else
			$PrevPage = array('', 'class="disabled"');
		if($Page['current_page'] + 1 < $Page['total_pages'])
			$NextPage = array($Page['base_url'] . '/page' . $Page['bridge'] . intval($Page['current_page']+2) . $Page['ext'], '');
		else
			$NextPage = array('', 'class="disabled"');
		
		if(!empty($PageOutput) && $Page['total_pages'] > 1)
			$PageString = '
			<ul class="pagination pagination-sm">
				<li ' . $PrevPage[1] . '><a href="' . $PrevPage[0] . '">&laquo;</a></li>' . 
				implode(PHP_EOL, $PageOutput) . '
				<li ' . $NextPage[1] . '><a href="' . $NextPage[0] . '">&raquo;</a></li>
			</ul>';
		else $PageString = '';
		return $PageString;
	}	
	
	static function ThumbnailOutput($Params)
	{
		$Params = $Params['params'];
		$ThumbWidth = $Params['Width'];
		$ThumbHeight = $Params['Height'];
		$ImageLocation = SITE_BASE . $Params['ImageLocation'] . '.' . $Params['Ext'];
		define('FILE_CACHE_DIRECTORY', APPLICATION_PATH . 'data/cache/');
		require SYSTEM_PATH . 'core/Output/timthumb.php';
		timthumb::start($ThumbWidth, $ThumbHeight, $ImageLocation);
	}
	
	static function GetThumbLink($ImageLocation,$Width = 80, $Height = 80)
	{
		return Router::Generate('ThumbnailHandler', array('Width' => $Width, 'Height' => $Height, 'ImageLocation' => $ImageLocation));
	}
}

?>