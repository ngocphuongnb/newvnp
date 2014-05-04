<?php

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') && !defined('ADMIN_AREA') ) die('Access denied!');

if(!defined('SAVE_CONFIG')) {
	$Templates = array('default' => 'Menu ngang', 'category' => 'Menu danh mục');
	$_ConfigData = array(	'block_name' => '',
							'template' => 'default',
							'menu_group' => 0
						);
	if(!empty($ConfigData)) {
		if(!empty($ConfigData['block_data'])) $ConfigData =array_merge($ConfigData, unserialize($ConfigData['block_data']));
		if(!empty($ConfigData))
			$ConfigData = array_merge($_ConfigData,$ConfigData);
	}
	else $ConfigData = $_ConfigData;
	
	$MenuGroups = DB::Query('menu_group', USER_DOMAIN)
							->Columns(array('menu_group_id', 'menu_group_title'))
							->Get('menu_group_id')->Result;
								
	$Config = TPL::File('config');
	$Config->Assign('MenuGroups', $MenuGroups);
	$Config->Assign('Templates', $Templates);
	$Config->Assign('Data', $ConfigData);
	$Config->Assign('Block', $Block);
	$_BlockConfig = $Config->Output();
}
else {
	function PrepareBlockConfigs($Block) {
		$_Block = $Block;
		$_Block['block_data'] = serialize(array('template' => $Block['template'], 'menu_group' => $Block['menu_group']));
		unset($_Block['template'], $_Block['menu_group']);
		return $_Block;
	}
}

?>