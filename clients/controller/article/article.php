<?php

class article extends Controller {
	public $NodeTypeName;
	public function __construct() {
		$this->NodeTypeName = 'article';
	}
	public function Main() {
	}
	public function InsertRow() {
		$FormValue = $this->SaveNodeAction();
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
	
	public function SaveNodeAction() {
		if(Input::Post('SaveNodeSubmit') == 1) {
			$FormValue = Input::Post('Field');
			Boot::Library('Filter');
			if(!isset($FormValue['title']) || empty($FormValue['title']))
				Helper::Notify('error', 'Title Cannot be empty');

			$FormValue['title'] = Utf8TrueType($FormValue['title']);

			if(!isset($FormValue['url']) || empty($FormValue['url']))
				Helper::Notify('error', 'Url Cannot be empty');

			$FormValue['url'] = str_replace('haha','hihi',Filter::CleanUrlString($FormValue['url']));

			if(!isset($FormValue['description']) || empty($FormValue['description']))
				Helper::Notify('error', 'Description Cannot be empty');

			if(!isset($FormValue['body']) || empty($FormValue['body']))
				Helper::Notify('error', 'Content Cannot be empty');

			if(!isset($FormValue['status']) || empty($FormValue['status']))
				Helper::Notify('error', 'Status Cannot be empty');

			if(!isset($FormValue['author']) || empty($FormValue['author']))
				Helper::Notify('error', 'Color Cannot be empty');

			$FormValue['new_field'] = Utf8TrueType($FormValue['new_field']);

			if(!isset($FormValue['main_catid']) || empty($FormValue['main_catid']))
				Helper::Notify('error', 'Main category Cannot be empty');

			if(Helper::NotifyCount('error') == 0) {
				$CheckUnique = array();
				$NodeExisted = false;

				$CheckExisted = DB::Query('article')->WhereGroupOpen();

				$CheckExisted = $CheckExisted->Where('url', '=', $FormValue['url']);

				$CheckExisted = $CheckExisted->WhereGroupClose();
				$CheckExisted = $CheckExisted->Get();
				if($CheckExisted->num_rows > 0) $NodeExisted = true;

				if(!$NodeExisted) {
					$NodeQuery = DB::Query('article')->Insert($FormValue);
					($NodeQuery->status && $NodeQuery->insert_id > 0) ? Helper::Notify('success', 'Successful add node in Article') : Helper::Notify('error', 'Cannot add node in Article');
				}
				else Helper::Notify('error', 'Cannot add node in Article. Be sure that <em>url</em> didn\'t existed!');
			}
return $FormValue;
		}
	}
}