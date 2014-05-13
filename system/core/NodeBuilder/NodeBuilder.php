<?php

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') ) die('Access denied!');

class NodeBuilder
{
	static $NodeBuilderCachePath;
	public $NodeTypes = array();
	public $RequiredNodeTypes = array();
	public $NodeTypeMissed = array();
	public $CacheFileExtension = '_node_builder.txt';
	public function __construct() {
	}
	public function AAA() {
		echo 'aaa';
	}
	
	public function LoadXmlNodeFile($XmlFilePath, $Reload = false) {
		$CacheFile = self::$NodeBuilderCachePath . md5($XmlFilePath) . $this->CacheFileExtension;
		if($Reload || !file_exists($CacheFile)) {
			$XmlObj = new DOMDocument();
			$XmlObj->load($XmlFilePath);
			$this->ExtractNodeTypes($XmlObj);
			$this->CheckRequiredNodeTypes();
			/// Cache data ///
			$_Temp['NodeTypes'] = $this->NodeTypes;
			$_Temp['RequiredNodeTypes'] = $this->RequiredNodeTypes;
			$_Temp['NodeTypeMissed'] = $this->NodeTypeMissed;
			File::Create($CacheFile, serialize($_Temp));
		}
		else {
			$_Temp = unserialize(File::GetContent($CacheFile));
			$this->NodeTypes = $_Temp['NodeTypes'];
			$this->RequiredNodeTypes = $_Temp['RequiredNodeTypes'];
			$this->NodeTypeMissed = $_Temp['NodeTypeMissed'];
		}
	}
	
	protected function ExtractNodeTypes($XmlObj) {
		$NodeTypes = $XmlObj->getElementsByTagName('NodeTypes')->item(0)->getElementsByTagName('NodeType');
		foreach($NodeTypes as $NodeType) {
			$NodeTypeName = $NodeType->getAttribute('name');
			$NodeTypeInfo = $NodeType->getElementsByTagName('Info');
			$NodeTypeInfo = $NodeTypeInfo->item(0);
			$GetRequire = $NodeTypeInfo->getElementsByTagName('Require');
			if($GetRequire->length > 0) {
				$R = $GetRequire->item(0);
				$require = array('node_type'	=> $this->GetFirstElementIfExisted($R, 'Node'));
			}
			else $require = array('node_type' => '');
			$NodeTypeInfo = array(	'title'		=> $NodeTypeInfo->getElementsByTagName('Title')->item(0)->nodeValue,
									'author'	=> $NodeTypeInfo->getElementsByTagName('Author')->item(0)->nodeValue,
									'require'	=> $require);
			$this->RequiredNodeTypes[$NodeTypeName] = array_map('trim',array_filter(explode(',',$NodeTypeInfo['require']['node_type'])));
			$NodeFields = $this->ExtractNodeFields($NodeType->getElementsByTagName('Fields')->item(0));
			$this->NodeTypes[$NodeTypeName] = array('NodeTypeInfo'	=> $NodeTypeInfo,
													'NodeFields'	=> $NodeFields);
		}
	}
	
	protected function ExtractNodeFields($XmlFieldsObject) {
		$FieldsCollection = $XmlFieldsObject->getElementsByTagName('Field');
		$Fields = array();
		foreach($FieldsCollection as $FieldObject) {
			$inform = $FieldObject->getAttribute('inform');
			if(empty($inform)) $inform = 1;
			$_Field['name'] = $FieldObject->getAttribute('name');
			$_Field['type'] = $FieldObject->getAttribute('type');
			$_Field['inform'] = $inform;
			$_Field['label'] = $this->GetFirstElementIfExisted($FieldObject, 'Label');
			$_Field['require'] = $this->GetFirstElementIfExisted($FieldObject, 'Require');
			$_Field['filter'] = $this->GetFirstElementIfExisted($FieldObject, 'Filter');
			$_Field['value'] = $this->GetFirstElementIfExisted($FieldObject, 'Value');
			$_Field['db_config'] = $this->GetDBConfig($FieldObject);
			$Fields[$_Field['name']] = $_Field;
		}
		return $Fields;
	}
	
	protected function GetDBConfig($Object) {
		$TagObj = $Object->getElementsByTagName('DB');
		if($TagObj->length > 0) {
			$DBConfig = array();
			$DBTag = $TagObj->item(0);
			$DBConfig['type'] = $this->GetFirstElementIfExisted($DBTag, 'Type');
			$DBConfig['length'] = $this->GetFirstElementIfExisted($DBTag, 'Length');
			$DBConfig['collation'] = $this->GetFirstElementIfExisted($DBTag, 'Collation');
			$DBConfig['auto_increament'] = $this->GetFirstElementIfExisted($DBTag, 'AutoIncreament');
			return $DBConfig;
		}
		else return '';
	}
	
	protected function CheckRequiredNodeTypes() {
		$ExsitedNodeTypes = array_keys($this->NodeTypes);
		foreach($this->RequiredNodeTypes as $NodeTypeName => $NodeTypesRequired) {
			$NodeTypesMissed = array_diff($NodeTypesRequired, $ExsitedNodeTypes);
			if(!empty($NodeTypesMissed)) $this->NodeTypeMissed[$NodeTypeName] = $NodeTypesMissed;
		}
		if(!empty($this->NodeTypeMissed)) {
			trigger_error('Error: Some node type is missing!' . print_r($this->NodeTypeMissed, true), E_USER_ERROR);
			return false;
		}
		return true;
	}
	
	protected function GetFirstElementIfExisted($Object, $TagName) {
		$TagObj = $Object->getElementsByTagName($TagName);
		if($TagObj->length > 0) return $TagObj->item(0)->nodeValue;
		else return '';
	}
	
	protected function CreateNodeTypeTable($NodeTypeObj) {
		n($NodeTypeObj);
	}
}

?>