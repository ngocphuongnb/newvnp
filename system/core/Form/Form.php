<?php

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') ) die('Access denied!');

class Form
{
	private $FormName = '';
	private $FormAction = '';
	private $FormMethod = '';
	private $FormElements = array();
	static	$CompiledPath = '';
	static	$BasePath = '';
	private	$Rebuild = false;
	static	$TemplateDir = '';
	
	public	$button, $fieldset, $input, $textarea, $isindex, $label, $legend, $select, $multi_select, $radio, $checkbox, $file, $image;
	
	public function __construct($FormName, $Rebuild = false) {
		self::$TemplateDir = Form::$BasePath . 'field_template' . DIRECTORY_SEPARATOR;
		$this->Rebuild = $Rebuild;
		$this->FormName = $FormName;
		Form::$BasePath = dirname(realpath(__FILE__)) . DIRECTORY_SEPARATOR;
	}
	
	public function TemplateDir($Path) {
		self::$TemplateDir = $Path;
	}
	
	public function button($Name) {
		return $this->button = new FormButtonElement($Name);
	}
	public function fieldset($Name) {
		return $this->fieldset	= new FormFieldsetElement($Name);
	}
	public function input($Name) {
		return $this->input = new FormInputElement($Name);
	}
	public function textarea($Name) {
		return $this->textarea = new FormTextareaElement($Name);
	}
	public function isindex($Name) {
		return $this->isindex = new FormIsindexElement($Name);
	}
	public function label($Name) {
		return $this->label = new FormLabelElement($Name);
	}
	public function legend($Name) {
		return $this->legend = new FormLegendElement($Name);
	}
	public function select($Name) {
		return $this->select = new FormSelectElement($Name);
	}
	public function multi_select($Name) {
		return $this->multi_select = new FormMultiSelectElement($Name);
	}
	public function radio($Name) {
		return $this->radio = new FormRadioElement($Name);
	}
	public function checkbox($Name) {
		return $this->checkbox	= new FormCheckboxElement($Name);
	}
	public function file($Name) {
		return $this->file	= new FormFileElement($Name);
	}
	public function image($Name) {
		return $this->image	= new FormImageElement($Name);
	}
	public function SetFormName($FormName = '') {
		$this->FormName = $FormName;
		return $this;
	}
	
	public function Action($FormAction = '') {
		$this->FormAction = $FormAction;
		return $this;
	}
	
	public function Method($FormMethod = 'GET') {
		$this->FormMethod = $FormMethod;
		return $this;
	}
	
	public function AddFormElement($FormElementObject) {
		$this->FormElements[] = $FormElementObject;
	}
	
	public function Render($Return = true) {
		$Vars = array();
		$RenderedForm = '';
		$i = 0;
		foreach($this->FormElements as $ElementName => $Element) {
			$i++;
			$Vars['var' . $i] = $Element->Element;
		}
		if(file_exists(Form::$CompiledPath . $this->FormName . '.php') && !$this->Rebuild) {
			//include(Form::$CompiledPath . $this->FormName . '.php');
		}
		else {
			$i = 0;
			foreach($this->FormElements as $ElementName => $Element) {
				$i++;
				$RenderedForm .= '<?php $Field = $Vars[\'var' . $i . '\']; ?>' . PHP_EOL;
				$RenderedForm .= $Element->FieldContent();
			}
			file_put_contents(Form::$CompiledPath . $this->FormName . '.php', $RenderedForm);
		}
		if($Return) {
			$FormStr = '';
			ob_start();
			include(Form::$CompiledPath . $this->FormName . '.php');
			$FormStr = ob_get_clean();
			return $FormStr;
		}
		else include(Form::$CompiledPath . $this->FormName . '.php');
	}
}

class FormBaseElement {
	public $Element = array('ElementType' => '',
							'Name' => '',
							'Value' => '',
							'Type' => '',
							'Class' => '',
							'Style' => '',
							'Content' => '',
							'Label'	=> '',
							'Prompt' => '',
							'Cols' => '',
							'Rows' => '',
							'Required' => false,
							'Multiple' => false,
							'Options' => array(),
							'StaticOptions' => false);
	public function __construct($Name) {
		$this->Element['Name'] = $Name;
		return $this;
	}
	public function ElementType($Name, $Type) {
		$this->Element['Name'] = $Name;
		$this->Element['ElementType'] = $Type;
		return $this;
	}
	public function Name($Name) {
		$this->Element['Name'] = $Name;
		return $this;
	}
	public function Value($Value = '') {
		$this->Element['Value'] = $Value;
		return $this;
	}
	protected function FieldType($Type, $ValidTypes, $DefaultType) {
		if(!in_array(strtolower($Type), $ValidTypes)) $Type = $DefaultType;
		$this->Element['Type'] = $Type;
		return $this;
	}
	public function Content($Value = '') {
		$this->Element['Content'] = $Value;
		return $this;
	}
	public function Label($Value = '') {
		$this->Element['Label'] = $Value;
		return $this;
	}
	public function Required($Value = true) {
		$this->Element['Required'] = $Value;
		return $this;
	}
	public function FieldClass($Value = '') {
		$this->Element['Class'] = $Value;
		return $this;
	}
	public function Style($Value = '') {
		$this->Element['Style'] = $Value;
		return $this;
	}
	public function Prompt($Value = '') {
		$this->Element['Prompt'] = $Value;
		return $this;
	}
	public function Cols($Value = '') {
		$this->Element['Cols'] = $Value;
		return $this;
	}
	public function Rows($Value = '') {
		$this->Element['Rows'] = $Value;
		return $this;
	}
	public function Multiple($Value = true) {
		$this->Element['Multiple'] = $Value;
		return $this;
	}
	public function Options($Options = array()) {
		$this->Element['Options'] += $Options;
		return $this;
	}
	public function StaticOptions($S = false) {
		$this->Element['StaticOptions'] += $S;
		return $this;
	}
	public function ResetOptions() {
		$this->Element['Options'] = array();
		return $this;
	}
	public function DeleteOptions($Name) {
		unset($this->Element['Options'][$Name]);
		return $this;
	}
	public function FieldOutput() {
		$FieldContent = file_get_contents(Form::$TemplateDir . $this->Element['ElementType'] . '.php');
		if($this->Element['Required']) {
			$this->Element['Class'] .= ' RequiredField';
			$this->Element['Label'] .= '<span class="RequireField">*</span>';
		}
		$FieldContent = str_replace('[@@FieldName@@]', $this->Element['Name'], $FieldContent);
		$FieldContent = str_replace('[@@FieldLabel@@]', $this->Element['Label'], $FieldContent);
		$FieldContent = str_replace('[@@FieldClass@@]', $this->Element['Class'], $FieldContent);
		$FieldContent = str_replace('[@@FieldStyle@@]', $this->Element['Style'], $FieldContent);
		return $FieldContent;
	}
	public function FieldContent() {
		$FieldContent = $this->FieldOutput();
		return $FieldContent . PHP_EOL;
	}
}

class FormButtonElement extends FormBaseElement {
	public function __construct($Name) {$this->ElementType($Name, 'button');}
	public function Type($Type) {
		$ValidTypes = array('button', 'submit', 'reset');
		$this->FieldType($Type, $ValidTypes, 'button');
		return $this;
	}
	public function FieldContent() {
		$FieldContent = $this->FieldOutput();
		$FieldContent = str_replace('[@@FieldValue@@]', '<?php echo $Field[\'Value\'] ?>', $FieldContent);
		return $FieldContent . PHP_EOL;
	}
}
class FormInputElement extends FormBaseElement {
	public function __construct($Name) {$this->ElementType($Name, 'input');}
	public function Type($Type) {
		$ValidTypes = array('button','checkbox','file','hidden','image','password','radio','reset','submit','text','number');
		$this->FieldType($Type, $ValidTypes, 'text');
		return $this;
	}
	public function FieldContent() {
		$FieldContent = $this->FieldOutput();
		$FieldContent = str_replace('[@@FieldValue@@]', '<?php echo $Field[\'Value\'] ?>', $FieldContent);
		$FieldContent = str_replace('[@@FieldType@@]', $this->Element['Type'], $FieldContent);
		return $FieldContent . PHP_EOL;
	}
}
class FormTextareaElement extends FormBaseElement {
	public function __construct($Name) {$this->ElementType($Name, 'textarea');}
	public function FieldContent() {
		$FieldContent = $this->FieldOutput();
		$FieldContent = str_replace('[@@FieldValue@@]', '<?php echo $Field[\'Value\'] ?>', $FieldContent);
		//$FieldContent = str_replace('[@@FieldType@@]', $this->Element['Type'], $FieldContent);
		return $FieldContent . PHP_EOL;
	}
}
class FormFieldsetElement extends FormBaseElement {
	public function __construct($Name) {$this->ElementType($Name, 'fieldset');return $this;}
	public function FieldContent() {
		$FieldContent = $this->FieldOutput();
		$FieldContent = str_replace('[@@FieldContent@@]', $this->Element['Content'], $FieldContent);
		return $FieldContent . PHP_EOL;
	}
}
class FormIsindexElement extends FormBaseElement {
	public function __construct($Name) {$this->ElementType($Name, 'insindex');return $this;}
}
class FormLabelElement extends FormBaseElement {
	public function __construct($Name) {$this->ElementType($Name, 'label');return $this;}
}
class FormLegendElement extends FormBaseElement {
	public function __construct($Name) {$this->ElementType($Name, 'legend');return $this;}
}
class FormSelectElement extends FormBaseElement {
	public function __construct($Name) {$this->ElementType($Name, 'select');return $this;}
	public function FieldContent() {
		$FieldContent = $this->FieldOutput();
		if(!$this->Element['StaticOptions']) {
			$options = '<?php foreach($Field[\'Options\'] as $Options):?>
			<option value="<?php echo $Options[\'value\'] ?>"<?php if($Options[\'value\'] == $Field[\'Value\']): ?> selected="selected"<?php endif ?>><?php echo $Options[\'text\'] ?></option>
			<?php endforeach ?>';
		}
		else {
			$options = array();
			foreach($this->Element['Options'] as $Opt) {
				$options[] = '<option value="' . $Opt['value'] . '"<?php if(\'' . $Opt['value'] . '\' == $Field[\'Value\']): ?> selected="selected"<?php endif ?>>' . $Opt['text'] . '</option>';
			}
			$options = implode(PHP_EOL, $options);
		}
		
		$FieldContent = str_replace('[@@FieldOptions@@]', $options, $FieldContent);
		$FieldContent = str_replace('[@@FieldMultiple@@]', $this->Element['Multiple'] ? 'multiple' : '', $FieldContent);
		return $FieldContent . PHP_EOL;
	}
}
class FormMultiSelectElement extends FormBaseElement {
	public function __construct($Name) {$this->ElementType($Name, 'multi_select');return $this;}
	public function FieldContent() {
		$FieldContent = $this->FieldOutput();
		if(!$this->Element['StaticOptions']) {
			$options = '<?php $ArrValue = explode(\',\',$Field[\'Value\']); foreach($Field[\'Options\'] as $Options):?>
			<option value="<?php echo $Options[\'value\'] ?>"<?php if(in_array($Options[\'value\'],$ArrValue)): ?> selected="selected"<?php endif ?>><?php echo $Options[\'text\'] ?></option>
			<?php endforeach ?>';
		}
		else {
			$options = array();
			foreach($this->Element['Options'] as $Opt) {
				$options[] = '<option value="' . $Opt['value'] . '"<?php if(in_array(\'' . $Opt['value'] . '\',$ArrValue)): ?> selected="selected"<?php endif ?>>' . $Opt['text'] . '</option>';
			}
			$options = '<?php $ArrValue = explode(\',\',$Field[\'Value\']); ?>' . implode(PHP_EOL, $options);
		}
		
		$FieldContent = str_replace('[@@FieldOptions@@]', $options, $FieldContent);
		$FieldContent = str_replace('[@@FieldMultiple@@]', $this->Element['Multiple'] ? 'multiple' : '', $FieldContent);
		return $FieldContent . PHP_EOL;
	}
}
class FormRadioElement extends FormBaseElement {
	public function __construct($Name) {$this->ElementType($Name, 'radio');return $this;}
	public function FieldContent() {
		$FieldContent = $this->FieldOutput();
		if(!$this->Element['StaticOptions']) {
			$options = '
			<?php foreach($Field[\'Options\'] as $Options):?>
			<label for="ID_<?php echo $Field[\'Name\'] ?>_<?php echo $Options[\'value\'] ?>">
				<input type="radio" name="<?php echo $Field[\'Name\'] ?>" id="ID_<?php echo $Field[\'Name\'] ?>_<?php echo $Options[\'value\'] ?>" class="<?php echo $Field[\'Class\'] ?>" value="<?php echo $Options[\'value\'] ?>"<?php if($Options[\'value\'] == $Field[\'Value\']): ?> checked="checked"<?php endif ?>/>
				<?php echo $Options[\'text\'] ?>
			</label>
			<?php endforeach ?>';
		}
		else {
			$options = array();
			foreach($this->Element['Options'] as $Opt) {
				$options[] = '<label for="ID_' . $this->Element['Name'] . '_' . $Opt['value'] . '">
				<input type="radio" name="' . $this->Element['Name'] . '" id="ID_' . $this->Element['Name'] . '_' . $Opt['value'] . '" class="' . $this->Element['Class'] . '" value="' . $Opt['value'] . '"<?php if(\'' . $Opt['value'] . '\' == $Field[\'Value\']): ?> checked="checked"<?php endif ?>/>' . $Opt['text'] . '</label>';
			}
			$options = implode(PHP_EOL, $options);
		}
		
		$FieldContent = str_replace('[@@FieldOptions@@]', $options, $FieldContent);
		return $FieldContent . PHP_EOL;
	}
}
class FormCheckboxElement extends FormBaseElement {
	public function __construct($Name) {$this->ElementType($Name, 'checkbox');return $this;}
	public function FieldContent() {
		$FieldContent = $this->FieldOutput();
		if(!$this->Element['StaticOptions']) {
			$options = '
			<?php $ArrValue = explode(\',\',$Field[\'Value\']); foreach($Field[\'Options\'] as $Options):?>
			<label for="ID_<?php echo $Field[\'Name\'] ?>_<?php echo $Options[\'value\'] ?>">
				<input type="checkbox" name="<?php echo $Field[\'Name\'] ?>[]" id="ID_<?php echo $Field[\'Name\'] ?>_<?php echo $Options[\'value\'] ?>" class="<?php echo $Field[\'Class\'] ?>" value="<?php echo $Options[\'value\'] ?>"<?php if(in_array($Options[\'value\'],$ArrValue)): ?> checked="checked"<?php endif ?>/>
				<?php echo $Options[\'text\'] ?>
			</label>
			<?php endforeach ?>';
		}
		else {
			$options = array();
			foreach($this->Element['Options'] as $Opt) {
				$options[] = '<label for="ID_' . $this->Element['Name'] . '_' . $Opt['value'] . '">
				<input type="checkbox" name="' . $this->Element['Name'] . '[]" id="ID_' . $this->Element['Name'] . '_' . $Opt['value'] . '" class="' . $this->Element['Class'] . '" value="' . $Opt['value'] . '"<?php if(in_array(\'' . $Opt['value'] . '\', $ArrValue)): ?> checked="checked"<?php endif ?>/>' . $Opt['text'] . '</label>';
			}
			$options = '<?php $ArrValue = explode(\',\',$Field[\'Value\']); ?>' . implode(PHP_EOL, $options);
		}
		
		$FieldContent = str_replace('[@@FieldOptions@@]', $options, $FieldContent);
		return $FieldContent . PHP_EOL;
	}
}
class FormFileElement extends FormBaseElement {
	public function __construct($Name) {$this->ElementType($Name, 'file');return $this;}
}
class FormImageElement extends FormBaseElement {
	public function __construct($Name) {$this->ElementType($Name, 'image');return $this;}
}

?>