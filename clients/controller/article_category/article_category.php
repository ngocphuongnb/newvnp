<?php

class article_category extends Controller {
	public $NodeTypeName;
	public function __construct() {
		$this->NodeTypeName = 'article_category';
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
    'Value' => '[@title]',
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
		echo '<form class="form-horizontal" action="" method="post">';
		echo '<input type="hidden" name="SaveNodeSubmit" value="1"/>';
		include Form::$CompiledPath . 'InsertRow_article_category.php';
		echo '<div style="text-align:center;margin-top:10px"><input type="submit" class="btn btn-primary" value="Save"/></div>';
		echo '</form>';
		$Form = ob_get_clean();
		$this->Render($Form);		
	}
	
	public function SaveNodeAction() {
		if(Input::Post('SaveNodeSubmit') == 1) {
			$FormValue = Input::Post('Field');
			Boot::Library('Filter');
			if(!isset($FormValue['title']) || empty($FormValue['title']))
				Helper::Notify('error', 'Title Cannot be empty');

			if(isset($FormValue['title']))
				$FormValue['url'] = $FormValue['title'];

			if(!isset($FormValue['url']) || empty($FormValue['url']))
				Helper::Notify('error', 'Url Cannot be empty');

			$FormValue['url'] = str_replace('haha','hihi',Filter::CleanUrlString($FormValue['url']));

			if(Helper::NotifyCount('error') == 0) {
				$CheckUnique = array();
				$NodeExisted = false;

				$CheckExisted = DB::Query('article_category')->WhereGroupOpen();

				$CheckExisted = $CheckExisted->Where('title', '=', $FormValue['title']);
$CheckExisted = $CheckExisted->_OR();

				$CheckExisted = $CheckExisted->Where('url', '=', $FormValue['url']);

				$CheckExisted = $CheckExisted->WhereGroupClose();
				$CheckExisted = $CheckExisted->Get();
				if($CheckExisted->num_rows > 0) $NodeExisted = true;

				if(!$NodeExisted) {
					$NodeQuery = DB::Query('article_category')->Insert($FormValue);
					($NodeQuery->status && $NodeQuery->insert_id > 0) ? Helper::Notify('success', 'Successful add node in Article Category') : Helper::Notify('error', 'Cannot add node in Article Category');
				}
				else Helper::Notify('error', 'Cannot add node in Article Category. Be sure that <em>title, url</em> didn\'t existed!');
			}

			return $FormValue;
		}
	}
}