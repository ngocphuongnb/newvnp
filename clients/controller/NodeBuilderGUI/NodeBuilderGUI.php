<?php

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') && !defined('ADMIN_AREA') ) die('Access denied!');

Boot::Library('NodeBuilder');

define('CONTROLLER_BASE_URL', Router::Generate('Controller',array('controller'=> 'NodeBuilderGUI')));
define('NODE_UTILITY_BASE_URL', Router::Generate('Controller',array('controller'=> 'NodeUtility')));

class NodeBuilderGUI extends Controller {
	public	$NodeBuilder;
	private	$NodeTypes	= array();
	private $NodeType	= '';
	private $NodeField	= '';
	private $MergedProfilesFileName = '';
	private $NodeProfilePath = '';
	private $SubAction	= '';
	public function Construct() {
		NodeBuilder::$NodeBuilderCachePath = CACHE_PATH . 'NodeBuilder' . DIRECTORY_SEPARATOR;
		$this->NodeProfilePath = DATA_PATH . 'NodeBuilder' . DIRECTORY_SEPARATOR;
		$this->MergedProfilesFilePath =
			NodeBuilder::$NodeBuilderCachePath . md5('VNP_MERGED_PROFILE_1906') . '_merge' . NodeBuilder::CACHE_FILE_EXTENSION;
		$this->NodeBuilder = new NodeBuilder();
		if(!empty($this->Registry['Params'])) {
			if(count($this->Registry['Params']) == 1 && isset($this->Registry['Params'][ROUTER_EXTRA_KEY])) $this->NodeType = $this->Registry['Params'][ROUTER_EXTRA_KEY];
			elseif((count($this->Registry['Params']) == 1 && !isset($this->Registry['Params'][ROUTER_EXTRA_KEY])) || count($this->Registry['Params']) > 1 ) {
				if(isset($this->Registry['Params'][ROUTER_EXTRA_KEY])) $this->NodeField = $this->Registry['Params'][ROUTER_EXTRA_KEY];
				$this->NodeType = array_keys($this->Registry['Params']);
				$this->NodeType = $this->NodeType[0];
				$this->SubAction = $this->Registry['Params'][$this->NodeType];
			}
			$this->LoadNodeTypeProfiles('default_' . $this->NodeType . '.xml');
		}
	}
	protected function LoadNodeTypeProfiles($NodeTypeFile = '', $Reload = false) {
		$XmlPath = $this->NodeProfilePath . $NodeTypeFile;
		if($NodeTypeFile != '' || !file_exists($XmlPath))
			$this->NodeBuilder->LoadXmlNodeFile($XmlPath, $Reload);
		else trigger_error('Node profile doesn\'t exists: ' . $NodeTypeFile, E_USER_ERROR);
	}
	protected function MergeProfiles() {
		$Profiles = glob(NodeBuilder::$NodeBuilderCachePath . '*' . NodeBuilder::CACHE_FILE_EXTENSION);
		$_Temp = array('NodeTypes' => array(), 'RequiredNodeTypes' => array(), 'NodeTypeMissed' => array());
		foreach($Profiles as $Profile) {
			$_CP = unserialize(File::GetContent($Profile));
			$_Temp['NodeTypes'] = array_merge($_Temp['NodeTypes'], $_CP['NodeTypes']);
			$_Temp['RequiredNodeTypes'] = array_merge($_Temp['RequiredNodeTypes'], $_CP['RequiredNodeTypes']);
			$_Temp['NodeTypeMissed'] = array_merge($_Temp['NodeTypeMissed'], $_CP['NodeTypeMissed']);
		}
		File::Create($this->MergedProfilesFilePath, serialize($_Temp));
	}
	protected function RebuildProfileCache() {
		$PrepareProfiles = glob($this->NodeProfilePath . 'default_*.xml');
		foreach($PrepareProfiles as $Profile) {
			$this->NodeBuilder->ResetNodeBuilder();
			$this->LoadNodeTypeProfiles(basename($Profile), true);
		}
		$this->MergeProfiles();
	}
	public function Main() {
		$this->UseCssComponents('Tables,Glyphicons,Buttons');
		if(Input::Post('RescanNodeTypes') == 1 || !file_exists($this->MergedProfilesFilePath))
			$this->RebuildProfileCache();
		$NodeTypes = $this->GetAllNodeTypes();
		$v = $this->View('NodeTypeFromXml')
					->Assign('StructureUrl', Router::GenerateThisRoute())
					->Assign('NodeTypes', $NodeTypes['NodeTypes'])
					->Output();
		$this->Render($v);
	}
	private function GetAllNodeTypes() {
		if(!file_exists($this->MergedProfilesFilePath)) $this->MergeProfiles();
		return unserialize(File::GetContent($this->MergedProfilesFilePath));
	}
	public function Structure() {
		$this->UseCssComponents('Tables,Glyphicons,Buttons,Labels,InputGroups');
		if($this->NodeType != '') {
			if(!empty($this->SubAction)) {
				if($this->SubAction == 'EditField') {
					Helper::PageInfo('Edit field : ' . $this->NodeField . ' <span class="label label-primary">Node type ' . $this->NodeType . '</span>');
					Helper::FeaturedPanel('Drop this field',BASE_DIR . 'NodeBuilderGUI/Structure/' . $this->NodeType . '/DropField/' . $this->NodeField . '/','remove');
					$this->DetectPostEditField($this->NodeField);
					$this->UseCssComponents('Forms,InputGroups');
					$v = $this->View('EditField')
							->Assign(array(
								'NodeTypeName'	=> $this->NodeType,
								'FieldTypes'	=> $this->NodeBuilder->FieldTypes,
								'DBFieldTypes'	=> $this->NodeBuilder->DB_FieldTypes,
								'DBCollations'	=> $this->NodeBuilder->DB_Collations,
								'NodeField'		=> $this->NodeBuilder->NodeTypes[$this->NodeType]['NodeFields'][$this->NodeField],
								'NodeTypes'		=> $this->GetAllNodeTypes()
							))
							->Output();
					$this->Render($v);
					Theme::UseJquery();
					Theme::JqueryUI('sortable');
					Theme::JsFooter('NodeBuilderGUI', $this->ControllerAddress(__FILE__) . 'js/node_builder.js');
				}
				elseif($this->SubAction == 'AddField') {
					Helper::PageInfo('Add field <span class="label label-primary">Node type ' . $this->NodeType . '</span>');
					$this->UseCssComponents('Forms,InputGroups');
					$NodeField = $this->DetectPostAddField();
					$v = $this->View('EditField')
							->Assign(array(
								'NodeTypeName'	=> $this->NodeType,
								'FieldTypes'	=> $this->NodeBuilder->FieldTypes,
								'DBFieldTypes'	=> $this->NodeBuilder->DB_FieldTypes,
								'DBCollations'	=> $this->NodeBuilder->DB_Collations,
								'NodeField'		=> array_merge($this->NodeBuilder->DefaultFieldAttributes,$NodeField),
								'NodeTypes'		=> $this->GetAllNodeTypes()
							))
							->Output();
					$this->Render($v);
					Theme::UseJquery();
					Theme::JqueryUI('sortable');
					Theme::JsFooter('JsBaseFunctions', APPLICATION_DATA_DIR . 'js/base.js');
					Theme::JsFooter('NodeBuilderGUI', $this->ControllerAddress(__FILE__) . 'js/node_builder.js');
				}
				elseif($this->SubAction == 'DropField') {
					$this->DetectPostDropField($this->NodeField);
					Boot::Library('Access');
					$config = array('action'	=> Router::GenerateThisRoute(),
									'tokens'	=> array(array('name' => 'NodeFieldName', 'value' => $this->NodeField))
									);
					$v = Access::Confirm('Confirm drop this field: ' . $this->NodeField, $config);
					$this->Render($v);
				}
			}
			else {
				Helper::PageInfo('Node type ' . $this->NodeType);
				Helper::FeaturedPanel( array(
								array(	'text'	=> 'Add field',
										'url'	=> Router::GenerateThisRoute() . 'AddField/',
										'class'	=> 'plus'),
								array(	'text'	=> 'Rebuild',
										'url'	=> CONTROLLER_BASE_URL . 'Rebuild/' . $this->NodeType . '/',
										'class'	=> 'share-alt'),
								array(	'text'	=> 'Reload',
										'url'	=> Router::GenerateThisRoute() . 'Reload/',
										'class'	=> 'refresh')
								)
							);
				$v = $this->View('Structure')
						->Assign(array(
							'NodeTypeName'	=> $this->NodeType,
							'FieldAction'	=> Router::GenerateThisRoute(),
							'NodeType'		=> $this->NodeBuilder->NodeTypes[$this->NodeType]
						))
						->Output();
				$this->Render($v);
			}
		}
	}
	public function Rebuild() {
		$this->UseCssComponents('Tables,Glyphicons,Buttons,Labels,InputGroups');
		if($this->NodeType != '') {
			$this->DetectPostRebuildNodeType($this->NodeType);
			Boot::Library('Access');
			$config = array('action'	=> Router::GenerateThisRoute(),
							'tokens'	=> array(array('name' => 'NodeType', 'value' => $this->NodeType))
							);
			$v = Access::Confirm('Confirm rebuild this node type: ' . $this->NodeType, $config);
			$this->Render($v);
		}
	}
	private function DetectPostEditField($NodeFieldName) {
		if(Input::Post('edit_field') == 1 && Input::Post('field_name') == $NodeFieldName) {
			$FieldData = Input::Post('Field');
			if($FieldData['type'] == 'multi_value' || $FieldData['type'] == 'single_value') {
				$ValueCollections = array();
				if(!is_array($FieldData['value'])) $FieldData['value'] = array($FieldData['value']);
				$FieldData['value'] = array_filter($FieldData['value']);
				if(!empty($FieldData['value']))
					foreach($FieldData['value'] as $v)
						$ValueCollections[] = $FieldData['options'][$v]['value'];
				$FieldData['value'] = implode(',',$ValueCollections);
				unset($ValueCollections);
			}
			$this->NodeBuilder->NodeTypes[$this->NodeType]['NodeFields'][$NodeFieldName] = $FieldData;
			$this->NodeBuilder->RebuildProfile();
			$this->LoadNodeTypeProfiles('default_' . $this->NodeType . '.xml', true);
			$this->MergeProfiles();
		}
	}
	private function DetectPostAddField() {
		if(Input::Post('edit_field') == 1) {
			$FieldData = Input::Post('Field');
			if($FieldData['type'] == 'multi_value' || $FieldData['type'] == 'single_value') {
				$ValueCollections = array();
				if(!is_array($FieldData['value'])) $FieldData['value'] = array($FieldData['value']);
				foreach($FieldData['value'] as $v)
					$ValueCollections[] = $FieldData['options'][$v]['value'];
				$FieldData['value'] = implode(',',$ValueCollections);
				unset($ValueCollections);
			}
			$this->NodeBuilder->NodeTypes[$this->NodeType]['NodeFields'][$FieldData['name']] = $FieldData;
			$this->NodeBuilder->RebuildProfile();
			$this->LoadNodeTypeProfiles('default_' . $this->NodeType . '.xml', true);
			$this->MergeProfiles();
			return $FieldData;
		}
		return array();
	}
	private function DetectPostDropField($NodeFieldName) {
		if(Input::Post('NodeFieldName') == $NodeFieldName) {
			unset($this->NodeBuilder->NodeTypes[$this->NodeType]['NodeFields'][$NodeFieldName]);
			$this->NodeBuilder->RebuildProfile();
			Helper::Notify('success', 'Successful drop field ' . $NodeFieldName);
			header('REFRESH: 2; url=' . Router::Generate(	'ControllerParams',
															array(	'controller' => get_class($this),
																	'action'	=> 'Structure',
																	'params'	=> $this->NodeType
																)
														));
		}
	}
	private function DetectPostRebuildNodeType($NodeTypeName) {
		if(Input::Post('NodeType') == $NodeTypeName) {
			$db_config = $this->NodeBuilder->NodeTypes[$this->NodeType]['NodeTypeInfo']['db_config'];
			$CreateTableResult = $this->NodeBuilder->CreateBaseNodeTable($this->NodeType, $db_config);
			$CurrentNodeDB = new NodeBuilder();
			$OnlyAdd = false;
			if(!file_exists($this->NodeProfilePath . 'current_' . $this->NodeType . '.xml')) {
				$_C = File::GetContent($this->NodeProfilePath . 'default_' . $this->NodeType . '.xml');
				File::Create($this->NodeProfilePath . 'current_' . $this->NodeType . '.xml', $_C);
				$OnlyAdd = true;
			}
			$CurrentNodeDB->LoadXmlNodeFile($this->NodeProfilePath . 'current_' . $this->NodeType . '.xml');
			$ProfileFields = $this->NodeBuilder->NodeTypes[$this->NodeType]['NodeFields'];
			$WorkingFields = $CurrentNodeDB->NodeTypes[$this->NodeType]['NodeFields'];
			$RemoveFields = array_diff_key($WorkingFields,$ProfileFields);
			$AddFields = array_diff_key($ProfileFields,$WorkingFields);
			$SkipFields = array_diff_key($WorkingFields,$RemoveFields);
			if(!empty($RemoveFields)) {
				$DropSql = array();
				foreach($RemoveFields as $FieldKey => $Field) $DropSql[] = $FieldKey;
				$this->NodeBuilder->DropFields($this->NodeType, $DropSql);
			}
			if($OnlyAdd) $AddFields = $ProfileFields;
			if(!empty($AddFields)) {
				$this->NodeBuilder->AddFields($this->NodeType, $AddFields);
			}
			if(!empty($SkipFields)) {
				$ModifyFields = array();
				foreach($SkipFields as $FKey => $Field) {
					if($ProfileFields[$FKey] != $Field)
						$ModifyFields[] = array('original'	=> $Field,
												'modified'	=> $ProfileFields[$FKey]
												);
				}
				if(sizeof($ModifyFields) > 0)
					$this->NodeBuilder->ModifyFields($this->NodeType, $ModifyFields);
			}
			$CurrentNodeDB->NodeTypes[$this->NodeType] = $this->NodeBuilder->NodeTypes[$this->NodeType];
			$CurrentNodeDB->RebuildProfile();
			$CacheFiles = glob(CACHE_PATH . 'form' . DIRECTORY_SEPARATOR . '*' . $this->NodeType . '.php');
			array_map('unlink', $CacheFiles);
			//$this->RebuildProfileCache();
			$this->MergeProfiles();
		}
	}
	public function XmlFiles() {
		$NodeTypeXmlFiles = glob(DATA_PATH . 'NodeBuilder' . DIRECTORY_SEPARATOR . 'default_*.xml');
		$x = $this->View('XmlFiles');
		$x->Assign('XmlFiles', $NodeTypeXmlFiles);
		$x->Output();
	}
	public function NodeFieldExtraAttribute() {
		$FieldType = Input::Post('FieldType');
		if(in_array($FieldType, array('single_value', 'multi_value'))) $tpl = 'ExtraOptionsField';
		elseif($FieldType == 'referer') $tpl = 'ExtraRefererField';
		$this->Render($this->View($tpl)
							->Assign('FieldType', $FieldType)
							->Output());
	}
	public function ListNodeTypes() {
		$NodeTypeXmlFiles = glob(DATA_PATH . 'NodeBuilder' . DIRECTORY_SEPARATOR . 'default_*.xml');
		$NodeTypes = array();
		foreach($NodeTypeXmlFiles as $XmlFile) {
			n($XmlFile);
		}
	}
	private function ListAllNodeTypeFiles() {
		
	}
}

?>