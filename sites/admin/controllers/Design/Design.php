<?php

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') && !defined('ADMIN_AREA') ) die('Access denied!');

class Design
{
	public function __construct() {
	}
	
	public function _main() {
	}
	
	public function SwitchDesignMod() {
		$_DeletedBlocks = G::$Session->Get('DeletedBlocks');
		if(Input::Post('SwitchDesignMod') == 1) {
			if(G::$Session->Get('EnableFrontEndEdit'))
				G::$Session->Set('EnableFrontEndEdit', false);
			else G::$Session->Set('EnableFrontEndEdit', true);
			header('LOCATION: ' . Input::Post('CurrentState'));
		}
		if(Input::Post('LoadCurrentDesign') == 1) {
			G::$Session->Set('BlocksOrder', '');
			G::$Session->Set('DeletedBlocks', array());
			header('LOCATION: ' . Input::Post('CurrentState'));
		}
		if(Input::Post('SaveAndQuit') == 1) {
			DB::Query('blocks', USER_DOMAIN)->Where('block_id', 'IN', $_DeletedBlocks)->Delete();
			$SaveDesign = DB::Query('settings', USER_DOMAIN)
							->Where('name', '=', 'blocks_order')
							->Update(array('value' => serialize(G::$Session->Get('BlocksOrder'))));
			G::$Session->Set('BlocksOrder', array());
			G::$Session->Set('EnableFrontEndEdit', false);
			header('LOCATION: ' . Input::Post('CurrentState'));
		}
		if(Input::Post('SaveAndContinue') == 1) {
			DB::Query('blocks', USER_DOMAIN)->Where('block_id', 'IN', $_DeletedBlocks)->Delete();
			$SaveDesign = DB::Query('settings', USER_DOMAIN)
							->Where('name', '=', 'blocks_order')
							->Update(array('value' => serialize(G::$Session->Get('BlocksOrder'))));
			//G::$Session->Set('BlocksOrder', array());
			//G::$Session->Set('EnableFrontEndEdit', false);
			header('LOCATION: ' . Input::Post('CurrentState'));
		}
	}
	
	public function TemporaryBlocksOrder() {
		if(G::$Session->Get('EnableFrontEndEdit')) {
			$BlocksOrder = G::$Session->Get('BlocksOrder');
			$BlocksOrder[G::$Session->Get('CurrentState')] = (array)json_decode(Input::Post('blocks_order'));
			G::$Session->Set('BlocksOrder', $BlocksOrder);
			echo 'ok';
			exit();
		}
	}
	
	public function DeleteBlock() {
		$_DeletedBlocks = G::$Session->Get('DeletedBlocks');
		$_DeletedBlocks[] = Input::Post('block_id');
		G::$Session->Set('DeletedBlocks', $_DeletedBlocks);
		echo 'ok'; exit();
	}
	
	public function BlockConfig() {
		$Block['block_id'] = Input::Post('block_id');
		$Block['block_file'] = Input::Post('block_file');
		$Block['theme_area'] = Input::Post('dropped_area');
		
		$BlockData = array();
		$ConfigData = $custom_pages = '';
		$pages = array();
		if($Block['block_id'] > 0) {
			$BlockData = DB::Query('blocks', USER_DOMAIN)->Where('block_id', '=', $Block['block_id'])->Get()->Result[0];
			if($BlockData['block_file'] != $Block['block_file']) {
				echo 'Error!';
				exit;
			}
			else {
				$ConfigData = $BlockData;
				$pages = explode(',',$BlockData['pages']);
				$custom_pages = str_replace(',', PHP_EOL,$BlockData['custom_pages']);
			}
		}
		$_BlockConfig = '';
		if(file_exists(APPLICATION_PATH . 'blocks/' . $Block['block_file'] . '/config.php')) {
			TPL::Config(SITE_BASE, APPLICATION_PATH . 'blocks/' . $Block['block_file'] . '/',
						USER_CACHE_PATH . 'template/blocks/');
			include APPLICATION_PATH . 'blocks/' . $Block['block_file'] . '/config.php';
		}
		echo '<form class="sugarbox-form VNP_BlockConfig_Form" role="form" method="post" action="' . ADMIN_BASE . 'Design/SaveBlockConfig/' . '">' . $_BlockConfig . $this->ExtraBlockConfig($pages, $custom_pages) . '</form>';
		exit;
	}
	
	private function ExtraBlockConfig($pages, $custom_pages)
	{
		$TplDir = ADMIN_PATH . 'controllers/Design/template/';
		TPL::Config(ADMIN_BASE, $TplDir, $TplDir . 'complied/');
		$ExConfig = TPL::File('extra_block_config');
		$ExConfig->Assign('Pages', $pages);
		$ExConfig->Assign('CustomPages', $custom_pages);
		return $ExConfig->Output();
	}
	
	public function SaveBlockConfig() {
		$Block = Input::Post('Block');
		$CustomPages = explode(PHP_EOL, $Block['custom_pages']);
		if(isset($Block['pages']))
		{
			if(!empty($Block['pages']) && in_array('current_page', $Block['pages'])) {
				$Block['pages'] = array_diff($Block['pages'], array('current_page'));
				$CustomPages = array_filter($CustomPages);
				$CustomPages[] = G::$Session->Get('CurrentState');
			}
		}
		if(!empty($CustomPages)) $Block['custom_pages'] = implode(',', $CustomPages);
		else $Block['custom_pages'] = '';
		if(!empty($Block['pages'])) {
			$Block['pages'] = array_unique($Block['pages']);
			$Block['pages'] = implode(',', array_filter($Block['pages']));
		}
		else $Block['pages'] = '';
		define('SAVE_CONFIG', true);
		if(file_exists(APPLICATION_PATH . 'blocks/' . $Block['block_file'] . '/config.php')) {
			include APPLICATION_PATH . 'blocks/' . $Block['block_file'] . '/config.php';
			$_Block = PrepareBlockConfigs($Block);
			if(empty($_Block['block_id']) || $_Block['block_id'] == 0) {
				unset($_Block['block_id']);
				$I = DB::Query('blocks', USER_DOMAIN)->Insert($_Block);
				if($I->status && $I->insert_id > 0) {
					echo json_encode(array('status' => 'ok', 'block_id' => $I->insert_id));
				}
			}
			else {
				$I = DB::Query('blocks', USER_DOMAIN)->Where('block_id', '=', $_Block['block_id'])->Update($_Block);
				if($I->status) {
					echo json_encode(array('status' => 'ok', 'block_id' => $_Block['block_id']));
				}
			}
		}
		exit();
	}
	
	public function LoadBlock() {
		$Block['block_id'] = Input::Post('block_id');
		$Block['block_file'] = Input::Post('block_file');
		
		if($Block['block_id'] > 0 ) {
			define('THEME_BLOCK', true);
			$Block = DB::Query('blocks', USER_DOMAIN)->Where('block_id', '=', $Block['block_id'])->Get()->Result[0];
			
			TPL::Config(SITE_BASE, APPLICATION_PATH . 'blocks/' . $Block['block_file'] . '/',
						USER_CACHE_PATH . 'template/blocks/');
			$_BlockContent = '';
			//if($Block['block_file'] == 'html') $_BlockContent = $Block['block_data'];
			//else
			{
				$_BlockData = $Block['block_data'] != '' ? unserialize($Block['block_data']) : array();
				include APPLICATION_PATH . 'blocks/' . $Block['block_file'] . '/' . $Block['block_file'] . '.php';
			}
			echo $_BlockContent;
		}
		else echo '';
		exit();
	}
}

?>