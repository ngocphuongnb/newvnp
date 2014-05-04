<?php

if(!defined('THEME_BLOCK')) die('Error!');

if(!function_exists('GetSubMenus')) {
	function GetSubMenus($ParentID, $Menus, $PrefixTPL) {
		$OutputMenus = array();
		$_Menus = $Menus;
		
		foreach($Menus as $MenuID => $Menu) {
			if($Menu['parent_menuid'] == $ParentID) {
				
				unset($_Menus[$MenuID]);
				$_SubMenu = GetSubMenus($MenuID, $_Menus, $PrefixTPL);
				if(!empty($_SubMenu)) $Menu['sub'] = $_SubMenu;
				else $Menu['sub'] = '';
				$OutputMenus[] = $Menu;
			}
		}
		
		if(!empty($OutputMenus)) {
			$SubMenu = TPL::File($PrefixTPL . '_submenu');
			$SubMenu->Assign('Menus', $OutputMenus);
			return $SubMenu->Output();
		}
		return '';
	}
}

$TMenu = TPL::File($_BlockData['template']);
$Menus = DB::Query('menu', USER_DOMAIN)->Where('menu_group', '=', $_BlockData['menu_group'])->Get('menu_id')->Result;
$_Menus = $Menus;
$OutputMenus = array();
foreach($Menus as $MenuID => $Menu) {
	if($Menu['parent_menuid'] == 0) {
		unset($_Menus[$MenuID]);
		$_SubMenu = GetSubMenus($MenuID, $_Menus, $_BlockData['template']);
		$Menu['sub'] = $_SubMenu;
		$OutputMenus[] = $Menu;
	}
}

$TMenu->Assign('BLOCK', $Block);
$TMenu->Assign('Menus', $OutputMenus);
$_BlockContent = $TMenu->Output();

?>