<?php

Boot::Library('NodeBuilder');

class NodeBuilderGUI extends Controller {
	public	$NodeBuilder;
	private	$NodeTypes = array();
	private $NodeType = '';
	public function __construct() {
		NodeBuilder::$NodeBuilderCachePath = CACHE_PATH . 'NodeBuilder' . DIRECTORY_SEPARATOR;
		$this->NodeBuilder = new NodeBuilder();
		$XmlPath = DATA_PATH . 'NodeBuilder' . DIRECTORY_SEPARATOR . 'default_article.xml';
		$this->NodeBuilder->LoadXmlNodeFile($XmlPath);
		if(!empty(G::$Registry['Params']) && isset(G::$Registry['Params'][ROUTER_EXTRA_KEY]))
			$this->NodeType = array_shift(G::$Registry['Params']);
		//n(G::$Registry['Params']);
	}
	public function Main() {
		$this->UseCssComponents('Tables,Glyphicons');
		$v = $this->View('NodeTypeFromXml')
					->Assign('NodeTypes', $this->NodeBuilder->NodeTypes)
					->Output();
		$this->Render($v);
	}
	public function Structure() {
		$this->UseCssComponents('Tables,Glyphicons,Buttons,Labels');
		if($this->NodeType != '') {
			p(G::$Registry['Params']);
			if(!empty(G::$Registry['Params'])) {
				$ParamKeys = array_keys(G::$Registry['Params']);
				$FieldAction = array_shift($ParamKeys);
				if($FieldAction == 'EditField') {
					$NodeFieldName = G::$Registry['Params'][$FieldAction];
					$this->DetectPostEditField($NodeFieldName);
					$DB_FieldType['global'] = explode(',', 'INT,VARCHAR,TEXT,DATE');
					$DB_FieldType['Numeric'] = explode(',', 'TINYINT,SMALLINT,MEDIUMINT,BIGINT,DECIMAL,FLOAT,DOUBLE,REAL,BIT,BOOLEAN,SERIAL');
					$DB_FieldType['DateTime'] = explode(',', 'DATE,DATETIME,TIMESTAMP,TIME,YEAR');
					$DB_FieldType['String'] = explode(',', 'CHAR,VARCHAR,TINYTEXT,TEXT,MEDIUMTEXT,LONGTEXT,BINARY,VARBINARY,TINYBLOB,MEDIUMBLOB,BLOB,LONGBLOB,ENUM,SET');
					$DB_FieldType['Spatial'] = explode(',', 'GEOMETRY,POINT,LINESTRING,POLYGON,MULTIPOINT,MULTILINESTRING,MULTIPOLYGON,GEOMETRYCOLLECTION');
					
					$DB_Collation['utf8'] = explode(',', '
utf8_bin,utf8_croatian_ci,utf8_czech_ci,utf8_danish_ci,utf8_esperanto_ci,utf8_estonian_ci,utf8_general_ci,utf8_general_mysql500_ci,utf8_german2_ci,utf8_hungarian_ci,utf8_icelandic_ci,utf8_latvian_ci,utf8_lithuanian_ci,utf8_persian_ci,utf8_polish_ci,utf8_roman_ci,utf8_romanian_ci,utf8_sinhala_ci,utf8_slovak_ci,utf8_slovenian_ci,utf8_spanish2_ci,utf8_spanish_ci,utf8_swedish_ci,utf8_turkish_ci,utf8_unicode_520_ci,utf8_unicode_ci,utf8_vietnamese_ci27');
					$this->UseCssComponents('Forms,InputGroups');
					$v = $this->View($FieldAction)
							->Assign('NodeTypeName', $this->NodeType)
							->Assign('DBFieldTypes', $DB_FieldType)
							->Assign('DBCollations', $DB_Collation)
							->Assign('NodeField', $this->NodeBuilder->NodeTypes[$this->NodeType]['NodeFields'][$NodeFieldName])
							->Output();
					$this->Render($v);
				}
			}
			else {
				$v = $this->View('Structure')
						->Assign('NodeTypeName', $this->NodeType)
						->Assign('EditFieldUrl', Router::GenerateThisRoute() . 'EditField/')
						->Assign('NodeType', $this->NodeBuilder->NodeTypes[$this->NodeType])
						->Output();
				$this->Render($v);
			}
		}
	}
	private function DetectPostEditField($NodeFieldName) {
		if(Input::Post('edit_field') == 1 && Input::Post('field_name') == $NodeFieldName) {
			p(Input::Post('Field'));
		}
	}
	public function XmlFiles() {
		$NodeTypeXmlFiles = glob(DATA_PATH . 'NodeBuilder' . DIRECTORY_SEPARATOR . 'default_*.xml');
		$x = $this->View('XmlFiles');
		$x->Assign('XmlFiles', $NodeTypeXmlFiles);
		$x->Output();
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