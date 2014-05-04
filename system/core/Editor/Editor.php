<?php

/**
 * Editor Class
 *
 * Build in editor
 *
 * @package		VNP
 * @subpackage	Base libraries
 * @author		VNP Dev team
 * @category	Base layer
 * @link		http://vnphp.com/docs/base-layer/libraries/Boot.html
 */
 
if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') ) die('Access denied!');

class Editor
{
	static $DefaultEditor = 'tinymce';
	static $TextareaSelectors = array();
	
	static function AddEditor($Selector) {
		Editor::$TextareaSelectors[] = $Selector;
	}
	
	static function PrepareTinymce($Return = false) {
		if($Return)
			return '<script type="text/javascript" src="' . DATA_DIR . 'library/tinymce/tinymce.min.js"></script>';
		else Theme::JsHeader('tinymce', DATA_DIR . 'library/tinymce/tinymce.min.js');
	}
	
	static function Replace($Textarea = '', $Return = false)
	{
		if($Textarea == '') $Textarea = Editor::$TextareaSelectors;
		if(is_array($Textarea)) $Textarea = implode(',', $Textarea);
		$jsContent = '
		var vnp_editor = tinymce.init({
			selector: "' . $Textarea . '",
			theme: "modern",
			plugins: [
				"advlist autolink lists link image charmap print preview hr anchor pagebreak",
				"searchreplace wordcount visualblocks visualchars code fullscreen",
				"insertdatetime media nonbreaking save table contextmenu directionality",
				"emoticons template paste textcolor vnp_image"
			],
			toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | vnp_image",
			toolbar2: "print preview media | forecolor backcolor emoticons | fontselect | fontsizeselect | template",
			image_advtab: true,
			templates: [
				{title: \'Test template 1\', content: \'Test 1\'},
				{title: \'Test template 2\', content: \'Test 2\'}
			],
			height: 300,
			width: "100%",
			entity_encoding : "raw",
			theme_advanced_font_sizes: ["10px,12px,13px,14px,16px,18px,20px"],
			font_size_style_values: ["12px,13px,14px,16px,18px,20px"],
			relative_urls: false
		 });';
		if($Return) {
			return '<script type="text/javascript" src="' . DATA_DIR . 'library/tinymce/tinymce.min.js"></script>
					<script type="text/javascript">' . $jsContent . '</script>';
		}
		else {
			Theme::JsHeader('tinymce', DATA_DIR . 'library/tinymce/tinymce.min.js');
			Theme::JsHeader('tinymce_code_' . $Textarea, $jsContent,'string');
		}
	}
}

?>