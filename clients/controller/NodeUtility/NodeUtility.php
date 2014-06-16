<?php

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') && !defined('ADMIN_AREA') ) die('Access denied!');

Boot::Library('NodeBuilder');

define('CONTROLLER_BASE_URL', Router::Generate('Controller',array('controller'=> 'NodeUtility')));

class NodeUtility extends Controller {
	private $MergedProfilesFilePath;
	private $AdapterFunctions = array();
	private $NodeTypes = array();
	function __construct() {
		$this->MergedProfilesFilePath =
			CACHE_PATH . 'NodeBuilder' . DIRECTORY_SEPARATOR . md5('VNP_MERGED_PROFILE_1906') . '_merge' . NodeBuilder::CACHE_FILE_EXTENSION;
		if(file_exists($this->MergedProfilesFilePath))
			$this->NodeTypes = unserialize(File::GetContent($this->MergedProfilesFilePath));
	}
	
	public function Main() {
	}
	
	public function InsertRow() {
		Boot::Library('Filter');
		$this->UseCssComponents('Glyphicons,Buttons,Labels,InputGroups');
		$FormElements = array(	'text'		=> 'input',
								'number'	=> 'input',
								'textarea'	=> 'textarea',
								'html'		=> 'textarea'
							);
		$NodeType = $this->Registry['Params'][ROUTER_EXTRA_KEY];
		
		$FormVariables = $PrepareOptions = array();
		$FVIndex = 0;
		$this->NodeType = $this->NodeTypes['NodeTypes'][$NodeType];
		
		$FormValue = $this->SaveNodeAction($NodeType);
		
		$Form = new Form('InsertRow_' . $NodeType, true);
		$Form->TemplateDir(CONTROLLER_PATH . 'NodeUtility' . DIRECTORY_SEPARATOR . 'field_template' . DIRECTORY_SEPARATOR);
		foreach($this->NodeType['NodeFields'] as $Field) {
			if(isset($FormValue[$Field['name']])) $Field['value'] = $FormValue[$Field['name']];
			$FVIndex++;
			$FormVariables['var' . $FVIndex]['Value'] = $Field['value'];
			$FieldTemplate = isset($FormElements[$Field['type']]) ? $FormElements[$Field['type']] : 'input';
			$FieldObj = $Form->$FieldTemplate('Field[' . $Field['name'] . ']')
								->Label($Field['label'])
								->Value($Field['value'])
								->Required($Field['require'])
								->FieldClass('FieldType_' . $Field['type'] . ' Field_' . $Field['name']);
			if(in_array($Field['type'], array('number', 'text', 'file'))) {
				$FieldObj->Type($Field['type']);
			}
			if(in_array($Field['type'], array('single_value', 'multi_value'))) {
				if($Field['display'] == 'single_selectbox') $T = 'select';
				if($Field['display'] == 'multi_selectbox') $T = 'multi_select';
				if($Field['display'] == 'radio') $T = 'radio';
				if($Field['display'] == 'checkbox') $T = 'checkbox';
				if(!$Field['require']) array_unshift($Field['options'], array('text' => 'Select', 'value' => ''));
				$FieldObj = $Form->$T('Field[' . $Field['name'] . ']')
									->Label($Field['label'])
									->Value($Field['value'])
									->FieldClass('FieldType_' . $Field['type'] . ' Field_' . $Field['name'])
									;
				$FieldObj->Options($Field['options'])->StaticOptions(true);
			}
			if($Field['type'] == 'referer') {
				$T = $Field['display'];
				if($Field['display'] == 'single_selectbox') $T = 'select';
				if($Field['display'] == 'multi_selectbox') $T = 'multi_select';
				$FieldObj = $Form->$T('Field[' . $Field['name'] . ']')
									->Label($Field['label'])
									->Value($Field['value'])
									->FieldClass('FieldType_' . $Field['type'] . ' Field_' . $Field['name']);
				$RefererTable = $Field['referer']['node_type'];
				$DisplayField = $Field['referer']['node_field'];
				$Options = DB::Query($RefererTable)
								->Columns(array($RefererTable . '_id', $DisplayField))
								->Get()->Result;
				$_O = array();
				foreach($Options as $Opt)
					$_O[] = array('value' => $Opt[$RefererTable . '_id'], 'text' => $Opt[$DisplayField]);
				unset($Options);
				
				$AdapterFunctionName = 'vnp' . md5($DisplayField . $RefererTable);
				if(!in_array($AdapterFunctionName, $this->AdapterFunctions)) {
					$this->AdapterFunctions[] = $AdapterFunctionName;
					$PrepareOptions[] = 'function PrepareOptions_' . $AdapterFunctionName . '($Row) {
						return array(	\'text\' => $Row[\'' . $DisplayField . '\'],
										\'value\' => $Row[\'' . $RefererTable . '_id\']);
					}';
					$PrepareOptions[] = '$' . $AdapterFunctionName . ' = DB::Query(\'' . $RefererTable . '\')
									->Columns(array(\'' . $RefererTable . '_id\',\'' . $DisplayField . '\'))
									->Adapter(\'PrepareOptions_' . $AdapterFunctionName . '\')
									->Get()->Result;';
				}
				$PrepareOptions[] = '$Vars[\'var' . $FVIndex . '\'][\'Options\'] = $' . $AdapterFunctionName .';';
								
				if(!$Field['require']) {
					array_unshift($_O, array('text' => 'Select', 'value' => ''));
					$PrepareOptions[] = 'array_unshift($Vars[\'var' . $FVIndex . '\'][\'Options\'], array(\'text\' => \'Select\', \'value\' => \'\'));';
				}
				$FieldObj->Options($_O);
				
			}
			$Form->AddFormElement($FieldObj);
		}
		$this->NodeControllerTemplate($NodeType, $FormVariables, $PrepareOptions);
		//p($FormVariables);
		$v = $this->View('InsertRow');
		$v->Assign('FormElements', $Form->Render());
		$this->Render($v->Output());
	}
	
	public function SaveNodeAction($NodeType) {
		if(Input::Post('SaveNodeSubmit') == 1) {
			$FormValue = Input::Post('Field');
			$CheckUnique = array();
			foreach($this->NodeType['NodeFields'] as $Field) {
				if(preg_match('/\[\@([a-zA-Z0-9_\-]+)\]/', $Field['value'], $MF)) {
					if(isset($FormValue[$MF[1]]))
						$FormValue[$Field['name']] = $FormValue[$MF[1]];
				}
				if($Field['require'] && (!isset($FormValue[$Field['name']]) || empty($FormValue[$Field['name']])))
					Helper::Notify('error', $Field['label'] . ' Cannot be empty');
				if($Field['db_config']['is_unique'])
					$CheckUnique[$Field['name']] = $FormValue[$Field['name']];
				if($Field['filter']) {
					$FormValue[$Field['name']] = Filter::VariableFilter($Field['filter'], $FormValue[$Field['name']]);
					//$CheckUnique[$Field['name']] = $FormValue[$Field['name']];
				}
			}
			if(Helper::NotifyCount('error') == 0) {
				$TableName = $this->NodeType['NodeTypeInfo']['name'];
				$NodeQuery = DB::Query($this->NodeType['NodeTypeInfo']['name']);
				$NodeExisted = false;
				if(!empty($CheckUnique)) {
					$CheckExisted = $NodeQuery->WhereGroupOpen();
					$i = 0;
					foreach($CheckUnique as $FField => $FValue) {
						if($i > 0) $NodeQuery = $NodeQuery->_OR();
						$CheckExisted = $CheckExisted->Where($FField, '=', $FValue);
						$i++;
					}
					$NodeQuery = $NodeQuery->WhereGroupClose();
					$CheckExisted = $NodeQuery->Get();
					if($CheckExisted->num_rows > 0) $NodeExisted = true;
				}
				if(!$NodeExisted) {
					$NodeQuery = DB::Query($this->NodeType['NodeTypeInfo']['name'])->Insert($FormValue);
					($NodeQuery->status && $NodeQuery->insert_id > 0) ? Helper::Notify('success', 'Successful add node in ' . $this->NodeType['NodeTypeInfo']['title']) : Helper::Notify('error', 'Cannot add node in ' . $this->NodeType['NodeTypeInfo']['title']);
				}
				else Helper::Notify('error', 'Cannot add node in ' . $this->NodeType['NodeTypeInfo']['title'] . '. Be sure that <em>' . implode(', ', array_keys($CheckUnique)) . '</em> didn\'t existed!');
			}
			return $FormValue;
		}
		return array();
	}
	
	private function NodeControllerTemplate($NodeType, $VarArray = array(), $PrepareOptions = array()) {
		$NodeFields = $this->NodeType['NodeFields'];
		$PrepareFields = array();
		$CheckUnique = array();
		//Boot::Library('Filter');
		foreach($this->NodeType['NodeFields'] as $Field) {
			if(preg_match('/\[\@([a-zA-Z0-9_\-]+)\]/', $Field['value'], $MF)) {
				$PrepareFields[] = '
			if(isset($FormValue[\'' . $MF[1] . '\']))
				$FormValue[\'' . $Field['name'] . '\'] = $FormValue[\'' . $MF[1] . '\'];';
			}
			if($Field['require']) {
				$PrepareFields[] = '
			if(!isset($FormValue[\'' . $Field['name'] . '\']) || empty($FormValue[\'' . $Field['name'] . '\']))
				Helper::Notify(\'error\', \'' . $Field['label'] . ' Cannot be empty\');';
			}
			if($Field['filter']) {
				$PrepareFields[] = '
			$FormValue[\'' . $Field['name'] . '\'] = ' . Filter::FunctionBuilder($Field['filter'], '$FormValue[\'' . $Field['name'] . '\']') . ';';
				//$CheckUnique[$Field['name']] = $FormValue[$Field['name']];
			}
			if($Field['db_config']['is_unique'])
				$CheckUnique[] = $Field['name'];
		}
			
			
			
			
		$PrepareFields[] = '
			if(Helper::NotifyCount(\'error\') == 0) {
				$CheckUnique = array();
				$NodeExisted = false;';
		if(!empty($CheckUnique)) {
			$PrepareFields[] = '
				$CheckExisted = DB::Query(\'' . $this->NodeType['NodeTypeInfo']['name'] . '\')->WhereGroupOpen();';
			$i = 0;
			foreach($CheckUnique as $FField) {
				if($i > 0) $PrepareFields[] = '$CheckExisted = $CheckExisted->_OR();';
				$PrepareFields[] = '
				$CheckExisted = $CheckExisted->Where(\'' . $FField . '\', \'=\', $FormValue[\'' . $FField . '\']);';
				$i++;					
			}
			$PrepareFields[] = '
				$CheckExisted = $CheckExisted->WhereGroupClose();
				$CheckExisted = $CheckExisted->Get();
				if($CheckExisted->num_rows > 0) $NodeExisted = true;';
		}
		$PrepareFields[] = '
				if(!$NodeExisted) {
					$NodeQuery = DB::Query(\'' . $this->NodeType['NodeTypeInfo']['name'] . '\')->Insert($FormValue);
					($NodeQuery->status && $NodeQuery->insert_id > 0) ? Helper::Notify(\'success\', \'Successful add node in ' . $this->NodeType['NodeTypeInfo']['title'] . '\') : Helper::Notify(\'error\', \'Cannot add node in ' . $this->NodeType['NodeTypeInfo']['title'] . '\');
				}
				else Helper::Notify(\'error\', \'Cannot add node in ' . $this->NodeType['NodeTypeInfo']['title'] . '. Be sure that <em>' . implode(', ', $CheckUnique) . '</em> didn\\\'t existed!\');
			}';
		$PrepareFields[] = '
			return $FormValue;';

		$TPL = '<?php

class ' . $NodeType . ' extends Controller {
	public $NodeTypeName;
	public function __construct() {
		$this->NodeTypeName = \'' . $NodeType . '\';
	}
	public function Main() {
	}
	public function InsertRow() {
		$FormValue = $this->SaveNodeAction();
		$this->UseCssComponents(\'Glyphicons,Buttons,Labels,InputGroups\');
		$Vars = ' . var_export($VarArray, true) . ';
		' . implode(PHP_EOL . "\t\t", $PrepareOptions) . '
		ob_start();
		echo \'<form class="form-horizontal" action="" method="post">\';
		echo \'<input type="hidden" name="SaveNodeSubmit" value="1"/>\';
		include Form::$CompiledPath . \'InsertRow_' . $NodeType . '.php\';
		echo \'<div style="text-align:center;margin-top:10px"><input type="submit" class="btn btn-primary" value="Save"/></div>\';
		echo \'</form>\';
		$Form = ob_get_clean();
		$this->Render($Form);		
	}
	
	public function SaveNodeAction() {
		if(Input::Post(\'SaveNodeSubmit\') == 1) {
			$FormValue = Input::Post(\'Field\');
			Boot::Library(\'Filter\');' .
			implode(PHP_EOL, $PrepareFields). '
		}
	}
}';
		if(!file_exists(CONTROLLER_PATH . $NodeType))
			mkdir(CONTROLLER_PATH . $NodeType);
		FILE::Create(CONTROLLER_PATH . $NodeType . DIRECTORY_SEPARATOR . $NodeType . '.php', $TPL);
	}
}

?>