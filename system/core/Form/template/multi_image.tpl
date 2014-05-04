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
