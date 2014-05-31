<?php

class article extends Controller {
	public $NodeTypeName;
	public function __construct() {
		$this->NodeTypeName = 'article';
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
    'Value' => 'article_category',
  ),
  'var3' => 
  array (
    'Value' => '',
  ),
  'var4' => 
  array (
    'Value' => '',
  ),
  'var5' => 
  array (
    'Value' => '',
  ),
  'var6' => 
  array (
    'Value' => '1',
  ),
  'var7' => 
  array (
    'Value' => '',
  ),
  'var8' => 
  array (
    'Value' => '',
  ),
  'var9' => 
  array (
    'Value' => '',
  ),
  'var10' => 
  array (
    'Value' => '',
  ),
  'var11' => 
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
		$Vars['var2']['Options'] = $vnpd8af29fe2fa7e61f1975893abfff36f7;
		array_unshift($Vars['var2']['Options'], array('text' => 'Select', 'value' => ''));
		$Vars['var11']['Options'] = $vnpd8af29fe2fa7e61f1975893abfff36f7;
		ob_start();
		include Form::$CompiledPath . 'InsertRow_article.php';
		$Form = ob_get_clean();
		$this->Render($Form);		
	}
}