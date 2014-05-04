<?php

class Form
{
	private $FormName = '';
	private $FormAction = '';
	private $FormMethod = '';
	private $FormElements = array();
	static	$CompiledPath = '';
	static	$BasePath = '';
	
	public	$button, $fieldset, $input, $isindex, $label, $legend, $select, $radio, $checkbox, $file, $image;
	
	public function __construct($FormName) {
		$this->FormName = $FormName;
		Form::$BasePath = dirname(realpath(__FILE__)) . DIRECTORY_SEPARATOR;
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
	
	public function Render($Rebuild = false) {
		$Vars = array();
		$RenderedForm = '';
		$i = 0;
		foreach($this->FormElements as $ElementName => $Element) {
			$i++;
			$Vars['var' . $i] = $Element->Element;
		}
		if(file_exists(Form::$CompiledPath . $this->FormName . '.php') && !$Rebuild) {
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
		include(Form::$CompiledPath . $this->FormName . '.php');
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
							'Multiple' => false,
							'Options' => array());
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
	public function ResetOptions() {
		$this->Element['Options'] = array();
		return $this;
	}
	public function DeleteOptions($Name) {
		unset($this->Element['Options'][$Name]);
		return $this;
	}
	public function FieldOutput() {
		$FieldContent = file_get_contents(Form::$BasePath . 'field_template' . DIRECTORY_SEPARATOR . $this->Element['ElementType'] . '.php');
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
		$ValidTypes = array('button','checkbox','file','hidden','image','password','radio','reset','submit','text ');
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
		$options = '
		<?php foreach($Field[\'Options\'] as $Options):?>
        <option value="<?php echo $Options[\'value\'] ?>"<?php if($Options[\'value\'] == $Field[\'Value\']): ?> selected="selected"<?php endif ?>><?php echo $Options[\'text\'] ?></option>
        <?php endforeach ?>';
		
		$FieldContent = str_replace('[@@FieldOptions@@]', $options, $FieldContent);
		$FieldContent = str_replace('[@@FieldMultiple@@]', $this->Element['Multiple'] ? 'multiple' : '', $FieldContent);
		return $FieldContent . PHP_EOL;
	}
}
class FormRadioElement extends FormBaseElement {
	public function __construct($Name) {$this->ElementType($Name, 'radio');return $this;}
	public function FieldContent() {
		$FieldContent = $this->FieldOutput();
		$options = '
		<?php foreach($Field[\'Options\'] as $Options):?>
		<label for="ID_<?php echo $Field[\'Name\'] ?>_<?php echo $Options[\'value\'] ?>">
			<input type="radio" name="<?php echo $Field[\'Name\'] ?>" id="ID_<?php echo $Field[\'Name\'] ?>_<?php echo $Options[\'value\'] ?>" class="<?php echo $Field[\'Class\'] ?>" value="<?php echo $Options[\'value\'] ?>"<?php if($Options[\'value\'] == $Field[\'Value\']): ?> checked="checked"<?php endif ?>/>
			<?php echo $Options[\'text\'] ?>
		</label>
		<?php endforeach ?>';
		
		$FieldContent = str_replace('[@@FieldOptions@@]', $options, $FieldContent);
		return $FieldContent . PHP_EOL;
	}
}
class FormCheckboxElement extends FormBaseElement {
	public function __construct($Name) {$this->ElementType($Name, 'checkbox');return $this;}
	public function FieldContent() {
		$FieldContent = $this->FieldOutput();
		$options = '
		<?php foreach($Field[\'Options\'] as $Options):?>
		<label for="ID_<?php echo $Field[\'Name\'] ?>_<?php echo $Options[\'value\'] ?>">
			<input type="checkbox" name="<?php echo $Field[\'Name\'] ?>[]" id="ID_<?php echo $Field[\'Name\'] ?>_<?php echo $Options[\'value\'] ?>" class="<?php echo $Field[\'Class\'] ?>" value="<?php echo $Options[\'value\'] ?>"<?php if($Options[\'value\'] == $Field[\'Value\']): ?> checked="checked"<?php endif ?>/>
			<?php echo $Options[\'text\'] ?>
		</label>
		<?php endforeach ?>';
		
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