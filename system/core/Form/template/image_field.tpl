rompt'] = $Value;
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

class FormButtonElement exten