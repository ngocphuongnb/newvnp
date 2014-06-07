<?php

/**
 * Filter Class
 *
 * Filter output, xss prevent
 *
 * @package		VNP
 * @subpackage	Base libraries
 * @author		VNP Dev team
 * @category	Base layer
 * @link		http://vnphp.com/docs/base-layer/libraries/DB-Wrapper.html
 */

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') ) die('Access denied!');

class Filter
{
	static function CleanUrlString( $string, $spaceReplace = '-' )
	{
		$string = ltrim($string,'-');
		$string = rtrim($string,'-');
		$unicode = array( 
				'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ', 
				'd'=>'đ', 
				'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ', 
				'i'=>'í|ì|ỉ|ĩ|ị', 
				'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ', 
				'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự', 
				'y'=>'ý|ỳ|ỷ|ỹ|ỵ', 
				'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ', 
				'D'=>'Đ', 
				'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ', 
				'I'=>'Í|Ì|Ỉ|Ĩ|Ị', 
				'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ', 
				'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự', 
				'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
			); 
		foreach( $unicode as $nonUnicode=>$uni )
		{
			$string = preg_replace("/($uni)/i", $nonUnicode, $string ); 
		}
		$string = str_replace(',','', $string);
		$string = str_replace('.','', $string);
		$string = str_replace( ' ', $spaceReplace, $string );
		return strtolower( $string ); 
	}
	
	static function VariableFilter($FunctionString, $Variable = '') {
		if(empty($Variable)) return '';
		$Functions = array_filter(explode('|', $FunctionString));
		foreach($Functions as $Function) {
			$Function = preg_split('/(\-\>)|(::)/', $Function, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
			$MainFunctions = array();
			$MainFunctions[] = $Function[0];
			foreach($Function as $i => $F) {
				if(!in_array($F, array('->','::'))) {
					$S = explode(':', $F);
					if(!isset($S[1])) $S[1] = array($Variable);
					else
						$S[1] = array_map('trim',array_filter(explode(',', str_replace('[THIS_FIELD_VALUE]',$Variable,$S[1]))));
					if(isset($Function[$i-1]))
						$MainFunctions[$i] = array('type' => $Function[$i-1], 'function' => $S[0], 'parameters' => $S[1]);
					else $MainFunctions[$i] = array('type' => '', 'function' => $S[0], 'parameters' => $S[1]);
				}
			}
			if(sizeof($MainFunctions) > 1) {
				$MainObj = $MainFunctions[0]['function'];
				array_shift($MainFunctions);
				foreach($MainFunctions as $F)
					$Variable = call_user_func_array(array($MainObj, $F['function']), $F['parameters']);
			}
			else $Variable = call_user_func_array($MainFunctions[0]['function'], $MainFunctions[0]['parameters']);
		}
		return $Variable;
	}
}

?>