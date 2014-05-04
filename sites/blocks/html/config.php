<?php

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') && !defined('ADMIN_AREA') ) die('Access denied!');

if(!defined('SAVE_CONFIG')) {
	$Templates = array('default' => 'Mặc định');
	$_ConfigData = array(	'block_name' => '',
							'template' => 'default',
							'html_content' => ''
						);
	if(!empty($ConfigData)) {
		if(!empty($ConfigData['block_data'])) $ConfigData =array_merge($ConfigData, unserialize($ConfigData['block_data']));
		if(!empty($ConfigData))
			$ConfigData = array_merge($_ConfigData,$ConfigData);
	}
	else $ConfigData = $_ConfigData;
								
	$Config = TPL::File('config');
	$Config->Assign('Templates', $Templates);
	$ConfigData['html_content'] = base64_decode($ConfigData['html_content']);
	$Config->Assign('Data', $ConfigData);
	$Config->Assign('Block', $Block);
	$_BlockConfig = $Config->Output();
}
else {
	function PrepareBlockConfigs($Block) {
		$_Block = $Block;
		
		$Block['html_content'] = base64_encode($Block['html_content']);
		$_Block['block_data'] = serialize(array('template' => $Block['template'], 'html_content' => $Block['html_content']));
		unset($_Block['template'], $_Block['html_content']);
		return $_Block;
	}
}

?>