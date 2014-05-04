<?php

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') && !defined('ADMIN_AREA') ) die('Access denied!');

if(!defined('SAVE_CONFIG')) {
	$Templates = array('default' => 'Mặc định', 'vertical' => 'Danh sách dọc');
	$_ConfigData = array(	'block_name' => '',
							'template' => 'default',
							'product_group' => 0,
							'block_url'		=> '',
							'num_rows'		=> 4,
							'from_date'		=> 30
						);
	if(!empty($ConfigData)) {
		if(!empty($ConfigData['block_data'])) $ConfigData =array_merge($ConfigData, unserialize($ConfigData['block_data']));
		if(!empty($ConfigData))
			$ConfigData = array_merge($_ConfigData,$ConfigData);
	}
	else $ConfigData = $_ConfigData;
	
	$ProductGroups = DB::Query('product_group', USER_DOMAIN)
							->Columns(array('product_group_id', 'product_group_title'))
							->Get('product_group_id')->Result;
	//n(DB::Log());
								
	$Config = TPL::File('config');
	$Config->Assign('ProductGroups', $ProductGroups);
	$Config->Assign('Templates', $Templates);
	$Config->Assign('Data', $ConfigData);
	$Config->Assign('Block', $Block);
	$_BlockConfig = $Config->Output();
}
else {
	function PrepareBlockConfigs($Block) {
		$_Block = $Block;
		$_Block['block_data'] = serialize(array('template' => $Block['template'], 'product_group' => $Block['product_group'], 'block_url' => $Block['block_url'], 'num_rows' => $Block['num_rows'], 'from_date' => $Block['from_date']));
		unset($_Block['template'], $_Block['product_group'], $_Block['block_url'], $_Block['num_rows'], $_Block['from_date']);
		return $_Block;
	}
}

?>