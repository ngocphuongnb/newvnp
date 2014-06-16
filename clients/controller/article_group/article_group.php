<?php

class article_group extends Controller {
	public $NodeTypeName;
	public function __construct() {
		$this->NodeTypeName = 'article_group';
	}
	public function Main() {
	}
	public function InsertRow() {
		$this->UseCssComponents('Glyphicons,Buttons,Labels,InputGroups');
		$Vars = array (
  'var1' => 
  array (
    'Value' => 'Enter title here',
  ),
  'var2' => 
  array (
    'Value' => 'Enter url here',
  ),
  'var3' => 
  array (
    'Value' => '',
  ),
);
		
		ob_start();
		include Form::$CompiledPath . 'InsertRow_article_group.php';
		$Form = ob_get_clean();
		$this->Render($Form);		
	}
}