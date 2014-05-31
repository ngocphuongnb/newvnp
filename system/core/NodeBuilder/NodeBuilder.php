<?php

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') ) die('Access denied!');

class NodeBuilder
{
	const		CACHE_FILE_EXTENSION = '_node_builder.txt';
	static		$NodeBuilderCachePath;
	public		$NodeTypes = array();
	public		$RequiredNodeTypes = array();
	public		$NodeTypeMissed = array();
	public		$DefaultFieldAttributes = array();
	protected	$XmlFilePath = '';
	protected	$FieldTypeDBConfig = array(
					'varchar'	=> array(	'type'		=> 'VARCHAR',
											'length'	=> 255,
											'collation'	=> 'utf8_unicode_ci',
											'null'		=> 'NOT NULL',
											'default'	=> ''
										),
					'tiny_int'	=> array(	'type'		=> 'TINYINT',
											'length'	=> 4,
											'collation'	=> '',
											'null'		=> 'NOT NULL',
											'default'	=> 0
										),
					'number'	=> array(	'type'		=> 'INT',
											'length'	=> 11,
											'collation'	=> '',
											'null'		=> 'NOT NULL',
											'default'	=> 0
										),
					'text'		=> array(	'type'		=> 'TEXT',
											'length'	=> '',
											'collation'	=> 'utf8_unicode_ci',
											'null'		=> '',
											'default'	=> ''
										)
				);
	public	$FieldTypes = array(), $DB_FieldTypes = array(), $DB_Collations = array();
	public function __construct() {
		$this->FieldTypes = array(	'text'					=> $this->FieldTypeDBConfig['varchar'],
									'number'				=> $this->FieldTypeDBConfig['number'],
									'textarea'				=> $this->FieldTypeDBConfig['text'],
									'html'					=> $this->FieldTypeDBConfig['text'],
									//'single_selectbox'		=> $this->FieldTypeDBConfig['varchar'],
									//'multi_selectbox'		=> $this->FieldTypeDBConfig['varchar'],
									'single_value'			=> $this->FieldTypeDBConfig['varchar'],
									'multi_value'			=> $this->FieldTypeDBConfig['varchar'],
									//'radio'					=> $this->FieldTypeDBConfig['varchar'],
									//'checkbox'				=> $this->FieldTypeDBConfig['varchar'],
									'hidden'				=> $this->FieldTypeDBConfig['varchar'],
									'url'					=> $this->FieldTypeDBConfig['varchar'],
									'image'					=> $this->FieldTypeDBConfig['varchar'],
									'file'					=> $this->FieldTypeDBConfig['varchar'],
									'meta_title'			=> $this->FieldTypeDBConfig['varchar'],
									'meta_description'		=> $this->FieldTypeDBConfig['varchar'],
									'date'					=> $this->FieldTypeDBConfig['number'],
									'time'					=> $this->FieldTypeDBConfig['number'],
									'referer'				=> $this->FieldTypeDBConfig['number']
								);
		$this->DB_FieldTypes = array(	'global'	=> explode(',', 'INT,VARCHAR,TEXT,DATE'),
										'Numeric'	=> explode(',', 'TINYINT,SMALLINT,MEDIUMINT,BIGINT,DECIMAL,FLOAT,DOUBLE,REAL,BIT,BOOLEAN,SERIAL'),
										'DateTime'	=> explode(',', 'DATE,DATETIME,TIMESTAMP,TIME,YEAR'),
										'String'	=> explode(',', 'CHAR,VARCHAR,TINYTEXT,TEXT,MEDIUMTEXT,LONGTEXT,BINARY,VARBINARY,TINYBLOB,MEDIUMBLOB,BLOB,LONGBLOB,ENUM,SET'),
										'Spatial'	=> explode(',', 'GEOMETRY,POINT,LINESTRING,POLYGON,MULTIPOINT,MULTILINESTRING,MULTIPOLYGON,GEOMETRYCOLLECTION')
								);
		$this->DB_Collations['utf8'] = explode(',', 'utf8_bin,utf8_croatian_ci,utf8_czech_ci,utf8_danish_ci,utf8_esperanto_ci,utf8_estonian_ci,utf8_general_ci,utf8_general_mysql500_ci,utf8_german2_ci,utf8_hungarian_ci,utf8_icelandic_ci,utf8_latvian_ci,utf8_lithuanian_ci,utf8_persian_ci,utf8_polish_ci,utf8_roman_ci,utf8_romanian_ci,utf8_sinhala_ci,utf8_slovak_ci,utf8_slovenian_ci,utf8_spanish2_ci,utf8_spanish_ci,utf8_swedish_ci,utf8_turkish_ci,utf8_unicode_520_ci,utf8_unicode_ci,utf8_vietnamese_ci27');

		$this->DefaultFieldAttributes = array(	'name'		=> '',
												'label'		=> '',
												'type'		=> '',
												'filter'	=> '',
												'value'		=> '',
												'inform'	=> 1,
												'require'	=> 0,
												'db_config'	=> array(	'type'				=> '',
																		'length'			=> '',
																		'collation'			=> '',
																		'auto_increment'	=> 0,
																		'is_unique'			=> 0)
											);
	}
	public function ResetNodeBuilder() {
		$this->NodeTypes = array();
		$this->RequiredNodeTypes = array();
		$this->NodeTypeMissed = array();
	}
	
	public function LoadXmlNodeFile($XmlFilePath, $Reload = false) {
		$this->XmlFilePath = $XmlFilePath;
		$CacheFile = self::$NodeBuilderCachePath . md5($XmlFilePath) . NodeBuilder::CACHE_FILE_EXTENSION;
		if($Reload || !file_exists($CacheFile) || (filemtime($XmlFilePath) > filemtime($CacheFile))) {
			$XmlObj = new DOMDocument();
			$XmlObj->load($XmlFilePath);
			$this->ExtractNodeTypes($XmlObj);
			//$this->CheckRequiredNodeTypes();
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
			
			$NodeTypeDBConfig = $NodeTypeInfo->getElementsByTagName('DB');
			if($NodeTypeDBConfig->length > 0) {
				$NodeTypeDBConfig = $NodeTypeDBConfig->item(0);
				$db_config['engine'] = $NodeTypeInfo->getElementsByTagName('Engine')->item(0)->nodeValue;
				$db_config['collate_key'] = $NodeTypeInfo->getElementsByTagName('CollateKey')->item(0)->nodeValue;
				$db_config['collate'] = $NodeTypeInfo->getElementsByTagName('Collate')->item(0)->nodeValue;
				$db_config['auto_increment'] = $NodeTypeInfo->getElementsByTagName('AutoIncrement')->item(0)->nodeValue;
			}
			else $db_config = array();
			
			$NodeTypeInfo = array(	'name'		=> $NodeTypeName,
									'title'		=> $NodeTypeInfo->getElementsByTagName('Title')->item(0)->nodeValue,
									'author'	=> $NodeTypeInfo->getElementsByTagName('Author')->item(0)->nodeValue,
									'require'	=> $require,
									'db_config'	=> $db_config);
			$this->RequiredNodeTypes[$NodeTypeName] =
				array_map('trim',array_filter(explode(',',$NodeTypeInfo['require']['node_type'])));
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
			$FieldOptions = $FieldObject->getElementsByTagName('Options');
			if($FieldOptions->length > 0) {
				$_Field['options'] = array();
				$FieldOptions = $FieldOptions->item(0);
				$_Field['display'] = $FieldOptions->getAttribute('display');
				$Options = $FieldOptions->getElementsByTagName('option');
				foreach($Options as $Option)
					$_Field['options'][] = array('value' => $Option->getAttribute('value'), 'text' => $Option->nodeValue);
			}
			$RefererNode = $FieldObject->getElementsByTagName('Referer');
			if($RefererNode->length > 0) {
				$RefererNode = $RefererNode->item(0);
				$_Field['referer'] = array(	'node_type'		=> $RefererNode->getAttribute('node_type'),
											'node_field'	=> $RefererNode->getAttribute('node_field'));
				$_Field['value'] = $_Field['referer']['node_type'];
				$_Field['display'] = $RefererNode->getAttribute('display');
			}
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
			$DBConfig['auto_increment'] = $this->GetFirstElementIfExisted($DBTag, 'AutoIncrement');
			$DBConfig['is_unique'] = $this->GetFirstElementIfExisted($DBTag, 'IsUnique');
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
	
	public function RebuildProfile() {
		$XmlProfile = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><NodeTypes/>');
		foreach($this->NodeTypes as $NodeTypeName => $NodeType) {
			$NodeTypeChild	= $XmlProfile->addChild('NodeType');
			$NodeTypeChild->addAttribute('name', $NodeTypeName);
			//Add Node type info
			$NodeTypeInfo	= $NodeTypeChild->addChild('Info');
			$NodeTypeInfo->addChild('Title', $NodeType['NodeTypeInfo']['title']);
			$NodeTypeInfo->addChild('Author', $NodeType['NodeTypeInfo']['author']);
			$NodeTypeRequirement = $NodeTypeInfo->addChild('Require');
			if(isset($NodeType['NodeTypeInfo']['require']['node_type']))
				$NodeTypeRequirement->addChild('Node', $NodeType['NodeTypeInfo']['require']['node_type']);
			$NodeTypeDB = $NodeTypeInfo->addChild('DB');
			$NodeTypeDB->addChild('Engine', $NodeType['NodeTypeInfo']['db_config']['engine']);
			$NodeTypeDB->addChild('CollateKey', $NodeType['NodeTypeInfo']['db_config']['collate_key']);
			$NodeTypeDB->addChild('Collate',  $NodeType['NodeTypeInfo']['db_config']['collate']);
			$NodeTypeDB->addChild('AutoIncrement',  $NodeType['NodeTypeInfo']['db_config']['auto_increment']);	
			//Add fields
			$NodeFields = $NodeTypeChild->addChild('Fields');
			foreach($NodeType['NodeFields'] as $FieldName => $Field) {
				$NodeField = $NodeFields->addChild('Field');
				$NodeField->addAttribute('name', $Field['name']);
				$NodeField->addAttribute('type', $Field['type']);
				if(isset($Field['inform'])) $NodeField->addAttribute('inform', $Field['inform']);
				$NodeField->addChild('Label', $Field['label']);
				if(isset($Field['require']))
					$NodeField->addChild('Require', $Field['require']);
				else $NodeField->addChild('Require', 0);
				if(isset($Field['filter']))
					$NodeField->addChild('Filter', $Field['filter']);
				if(isset($Field['value']))
					$NodeField->addChild('Value', $Field['value']);
				// Add options if the field is single_value or multi_value
				if($Field['type'] == 'single_value' || $Field['type'] == 'multi_value') {
					$Options = $NodeField->addChild('Options');
					$Options->addAttribute('display', $Field['display']);
					foreach($Field['options'] as $_O) {
						$Option = $Options->addChild('option', $_O['text']);
						$Option->addAttribute('value', $_O['value']);
					}
				}
				// Add referer info
				if($Field['type'] == 'referer') {
					$Referer = $NodeField->addChild('Referer');
					$Referer->addAttribute('node_type', $Field['referer']['node_type']);
					$Referer->addAttribute('node_field', $Field['referer']['node_field']);
					$Referer->addAttribute('display', $Field['display']);
				}
				// DB configs
				$NodeFieldDB = $NodeField->addChild('DB');
				if(isset($Field['db_config']['type']))
					$NodeFieldDB->addChild('Type', $Field['db_config']['type']);
				if(isset($Field['db_config']['length']))
					$NodeFieldDB->addChild('Length', $Field['db_config']['length']);
				if(isset($Field['db_config']['collation']))
					$NodeFieldDB->addChild('Collation', $Field['db_config']['collation']);
				if(isset($Field['db_config']['auto_increment']))
					$NodeFieldDB->addChild('AutoIncrement', $Field['db_config']['auto_increment']);
				if(isset($Field['db_config']['is_unique']))
					$NodeFieldDB->addChild('IsUnique', $Field['db_config']['is_unique']);
			}		
		}
		$dom = dom_import_simplexml($XmlProfile)->ownerDocument;
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		File::Create($this->XmlFilePath, $dom->saveXML());
	}
	
	public function CreateBaseNodeTable($TableName, $Config = array()) {
		$DFConfig = array('engine' => 'MyISAM', 'collate_key' => 'utf', 'collate' => 'utf8_unicode_ci', 'auto_increment' => 0);
		$Config = array_merge($DFConfig, $Config);
		$sql = 'CREATE TABLE IF NOT EXISTS ' . DB::Prefix() . $TableName . ' (
			 ' . $TableName . '_id INT(11) unsigned NOT NULL AUTO_INCREMENT,
			 PRIMARY KEY (' . $TableName . '_id)
		)
		ENGINE=' . $Config['engine'] . '
		CHARACTER SET ' . $Config['collate_key'] . ' COLLATE ' . $Config['collate'] . '
		DEFAULT CHARSET=' . $Config['collate_key'] . '
		AUTO_INCREMENT=' . $Config['auto_increment'];
		return DB::CustomQuery($sql);
	}
	public function DropFields($TableName, $DropFields = array()) {
		foreach($DropFields as $Field) $sql[] = 'DROP ' . $Field;
		$sql = 'ALTER TABLE ' . DB::Prefix() . $TableName . ' ' . implode(',', $sql);
		return DB::CustomQuery($sql);
	}
	public function AddFields($TableName, $AddFields = array()) {
		/*
		ALTER TABLE users
		ADD COLUMN `count` SMALLINT(6) NOT NULL AFTER `lastname`,
		ADD COLUMN `log` VARCHAR(12) NOT NULL AFTER `count`,
		ADD COLUMN `status` INT(10) UNSIGNED NOT NULL AFTER `log`;
		*/
		$sql = 'ALTER TABLE ' . DB::Prefix() . $TableName . ' ';
		$AddSql = array();
		foreach($AddFields as $Field) {
			$DBConfig = $this->FieldTypes[$Field['type']];
			$CustomConfig = $Field['db_config'];
			if(!isset($CustomConfig['type']) || $CustomConfig['type'] == '') $CustomConfig['type'] = $DBConfig['type'];
			if(!isset($CustomConfig['length']) || $CustomConfig['length'] == '') $CustomConfig['length'] = $DBConfig['length'];
			if(!isset($CustomConfig['collation']) || $CustomConfig['collation'] == '')
				$CustomConfig['collation'] = $DBConfig['collation'];
			if(!isset($CustomConfig['auto_increment']) || $CustomConfig['auto_increment'] == '')
				$CustomConfig['auto_increment'] = 0;
			if(empty($Field['require'])) $CustomConfig['null'] = $DBConfig['null'];
			else $CustomConfig['null'] = 'NOT NULL';
			
			if(in_array($CustomConfig['type'], array('longtext','text','mediumtext')))  $CustomConfig['length'] = '';
			if($CustomConfig['length'] != '') $CustomConfig['length'] = '(' . $CustomConfig['length'] . ')';
			if($CustomConfig['collation'] != '') $CustomConfig['collation'] = 'COLLATE ' . $CustomConfig['collation'];
			
			$AddSql[] = 'ADD COLUMN ' . $Field['name'] . ' ' . $CustomConfig['type'] .$CustomConfig['length'] . ' ' . $CustomConfig['null'] . ' ' . $CustomConfig['collation'];
		}
		$sql .= implode(',', $AddSql);
		return DB::CustomQuery($sql);
	}
	public function ModifyFields($TableName, $ModifyFields = array()) {
		/*
		ALTER TABLE  `article` CHANGE  `title`  `title` INT( 11 ) NOT NULL DEFAULT  '0';
		*/
		$AddSql = array();
		$sql = 'ALTER TABLE  ' . DB::Prefix() . $TableName . ' ' ;
		foreach($ModifyFields as $Field) {
			$OriginalField = $Field['original'];
			$ModifiedField = $Field['modified'];
			$DBConfig = $this->FieldTypes[$ModifiedField['type']];
			$CustomConfig = $ModifiedField['db_config'];
			if(!isset($CustomConfig['type']) || $CustomConfig['type'] == '') $CustomConfig['type'] = $DBConfig['type'];
			if(!isset($CustomConfig['length']) || $CustomConfig['length'] == '') $CustomConfig['length'] = $DBConfig['length'];
			if(!isset($CustomConfig['collation']) || $CustomConfig['collation'] == '')
				$CustomConfig['collation'] = $DBConfig['collation'];
			if(!isset($CustomConfig['auto_increment']) || $CustomConfig['auto_increment'] == '')
				$CustomConfig['auto_increment'] = 0;
			if(empty($Field['require'])) $CustomConfig['null'] = $DBConfig['null'];
			else $CustomConfig['null'] = 'NOT NULL';
			
			if(in_array($CustomConfig['type'], array('longtext','text','mediumtext')))  $CustomConfig['length'] = '';
			if($CustomConfig['length'] != '') $CustomConfig['length'] = '(' . $CustomConfig['length'] . ')';
			if($CustomConfig['collation'] != '') $CustomConfig['collation'] = 'COLLATE ' . $CustomConfig['collation'];
			
			$AddSql[] = 'CHANGE ' . $OriginalField['name'] . ' ' . $ModifiedField['name'] . ' ' . $CustomConfig['type'] . $CustomConfig['length'] . ' ' . $CustomConfig['null'] . ' ' . $CustomConfig['collation'];
		}
		$sql .= implode(',', $AddSql);
		return DB::CustomQuery($sql);
	}
}

?>