<?php

class article_category extends Controller {
	public $NodeTypeName;
	public function __construct() {
		$this->NodeTypeName = 'article_category';
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
  'var4' => 
  array (
    'Value' => 'article_category',
  ),
);
		function PrepareOptions_vnpd8af29fe2fa7e61f1975893abfff36f7($Row) {
						return array(	'text' => $Row['title'],
										'value' => $Row['article_category_id']);
					}
		$vnpd8af29fe2fa7e61f1975893abfff36f7 = DB::Query('article_category')
									->Columns(array('article_category_id','title'))
									->Adapter('PrepareOptions_vnpd8af29fe2fa7e61f1975893abfff36f7')
									->Get()->Result;
		$Vars['var4']['Options'] = $vnpd8af29fe2fa7e61f1975893abfff36f7;
		array_unshift($Vars['var4']['Options'], array('text' => 'Select', 'value' => ''));
		ob_start();
		include Form::$CompiledPath . 'InsertRow_article_category.php';
		$Form = ob_get_clean();
		$this->Render($Form);		
	}
}