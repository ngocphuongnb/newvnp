<?php

/**
 * Helper Class
 *
 * System information and notification
 *
 * @package		VNP
 * @subpackage	Base libraries
 * @author		VNP Dev team
 * @category	Base layer
 * @link		http://vnphp.com/docs/base-layer/libraries/Helper.html
 */

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') ) die('Access denied!');

class Helper
{
	static protected $UserState		= array();
	static protected $Notification	= array();
	static protected $PageHeader	= array();
	static protected $FeaturedPanel	= array();
	static protected $PageInfo		= '';
	
	public function __construct()
	{
	}
	
	static function State($Title, $Route)
	{
		Helper::$UserState[$Title] = array('route' => $Route, 'title' => $Title);
	}
	
	static function GetState()
	{
		return Helper::$UserState;
	}
	
	static function Notify($Type, $Msg)
	{
		if($Type == 'error') $Type = 'danger';
		Helper::$Notification[$Type][] = array('type' => $Type, 'content' => $Msg);
	}
	
	static function NotifyCount($Type) {
		if($Type == 'error') $Type = 'danger';
		if(isset(Helper::$Notification[$Type])) return sizeof(Helper::$Notification[$Type]);
		else return 0;
	}
	
	static function PageInfo($Text)
	{
		Helper::$PageInfo = $Text;
	}
	
	static function FeaturedPanel($Text, $Url = NULL, $Class = '')
	{
		is_array($Text) ? Helper::$FeaturedPanel += $Text :
		Helper::$FeaturedPanel[] = array('text' => $Text, 'url' => $Url, 'class' => $Class);
	}
	
	static function GetNotify()
	{
		Theme::AddCssComponent('Alerts');
		return Helper::$Notification;
	}
	
	static function GetFeaturedPanel() {
		return Helper::$FeaturedPanel;
	}
	
	static function GetPageInfo() {
		return Helper::$PageInfo;
	}
	
	static function NotifyLength($Type) {
		if($Type == 'error') $Type = 'danger';
		if(!isset(Helper::$Notification[$Type])) return 0;
		return sizeof(Helper::$Notification[$Type]);
	}
	
	static function Header($PageHeader, $Subtext = '')
	{
		Helper::$PageHeader = array($PageHeader,$Subtext);
	}
	
	static function GetPageHeader()
	{
		if(!empty(Helper::$PageHeader))
			return '
			<div class="page-header">
				<h1>' . Helper::$PageHeader[0] . '&nbsp;<small>' . Helper::$PageHeader[1] . '</small></h1>
			</div>';
		else return '';
	}
}

?>