<?php
function n($a) {
	echo '<pre>';
	print_r($a);
	echo '</pre>';
}

require './class.VTP.php';
VTE::$TPLFileDir	= dirname(__FILE__) . DIRECTORY_SEPARATOR;
VTE::$CompiledDir	= dirname(__FILE__) . DIRECTORY_SEPARATOR . 'compiled' . DIRECTORY_SEPARATOR;
VTE::$CacheDir	= dirname(__FILE__) . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR;
VTE::$MergedDir	= dirname(__FILE__) . DIRECTORY_SEPARATOR . 'merged' . DIRECTORY_SEPARATOR;

require './form/class.form.php';
Form::$CompiledPath = dirname(realpath(__FILE__)) . DIRECTORY_SEPARATOR . 'compiled' . DIRECTORY_SEPARATOR;
$Form = new Form('test_form');
$Form->AddFormElement($Form->input('name1')->Type('text')->Label('Text field 1')->Value('hahaha 1'));
$Form->AddFormElement($Form->input('name2')->Type('text')->Label('Text field 2')->Value('hahaha 2'));
$Form->AddFormElement($Form->input('name3')->Type('text')->Label('Text field 3')->Value('hahaha 3'));
$Form->AddFormElement($Form->select('name4')
						->Label('Select field 4')
						->Options(array(array('value' => 'v1', 'text' => 't1'),
										array('value' => 'v2', 'text' => 't2'),
										array('value' => 'v3', 'text' => 't3')
									))
						->Value('v2'));
$Form->AddFormElement($Form->radio('name5')
						->Label('Radio field 5')
						->Options(array(array('value' => 'v1', 'text' => 't1'),
										array('value' => 'v2', 'text' => 't2'),
										array('value' => 'v3', 'text' => 't3')
									))
						->Value('v2'));
$Form->AddFormElement($Form->checkbox('name6')
						->Label('Checkbox field 6')
						->Options(array(array('value' => 'v1', 'text' => 't1'),
										array('value' => 'v2', 'text' => 't2'),
										array('value' => 'v3', 'text' => 't3')
									))
						->Value('v2'));
$Form->AddFormElement($Form->file('name7')->Label('File field 7'));
$Form->AddFormElement($Form->image('name8')->Multiple(true)->Label('Image'));
$Form->AddFormElement($Form->button('name9')->Value('Save')->Label('Save'));
echo $Form->Render(false);

/*$File1Vars = array('name' => 'nvn');
$File2Vars = array('file2here' => 'nnp');
TPL::Merge('file','file2')
		->AddFile('file', $File1Vars)
		->AddFile('file2',$File2Vars)
		->OutputMerged();*/
/*$b[] = TPL::File('file', true, true)
		->Assign('name', 'nvn')
		->Output(false, true);

$b[] = TPL::File('file2', true, true)
		->Assign('file2here', 'nnp')
		->Output(false, true);*/

//VTE::MergeCompiledFile($b, 'merged.php');
//VTE::DeleteMergedFiles();
//VTE::DeleteCompiledFiles();
//VTE::DeleteCachedFiles();

?>