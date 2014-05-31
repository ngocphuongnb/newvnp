<?php

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') ) die('Access denied!');

class Access
{
	static function Confirm($Name, $Config) {
		Theme::AddCssComponent('Panels');
		$DefaultConfig = array(
							'template'	=> TEMPLATE_PATH,
							'method'	=> 'post'
						);
		$Config = array_merge($DefaultConfig, $Config);
		$ConfirmBox = TPL::File('confirm_box')
						->SetDir('TPLFileDir', TEMPLATE_PATH)
						->SetDir('CompiledDir', CACHE_PATH . 'compiled' . DIRECTORY_SEPARATOR)
						->SetDir('CacheDir', CACHE_PATH . 'html' . DIRECTORY_SEPARATOR);
		return $ConfirmBox->Assign(array(	'name'		=> $Name,
											'config'	=> $Config
										)
									)->Output();
	}
}


?>