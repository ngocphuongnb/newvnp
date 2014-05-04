<?php

require './Exception.php';
//$ArrayElement = '(\w+(?:\.\${0,1}[A-Za-z0-9_]+)*(?:(?:\[\${0,1}[A-Za-z0-9_]+\])|(?:\-\>\${0,1}[A-Za-z0-9_]+))*)(.*?)';

class VTE
{
	private		$Tag = array('left' => '{', 'right' => '}');
	protected	$SingleVar = '[a-zA-Z0-9\_]';
	protected	$VarElement = '\w+(?:\.\${0,1}[A-Za-z0-9_]+)*(?:(?:\[\${0,1}[A-Za-z0-9_]+\])|(?:\-\>\${0,1}[A-Za-z0-9_]+))*(.*?)';
	
	private $InputTPLString = '';
	private $TPLFileName = '';
	private $HtmlString = '';
	private $CompiledPHPCode = '';
	
	static $TPLFileDir = '/';
	
	public $TPLFileExt = '.tpl';
	static function TPLFileDir($TPLFileDir) {
		self::$TPLFileDir = $TPLFileDir;
	}
	
	public function __construct() {
	}
	
	public function File($TPLFileOrHtmlStringOrCompiledPHPCode = '', $Mode = 'file') {
		$this->InputTPLString = $TPLFileOrHtmlStringOrCompiledPHPCode;
		if($Mode == 'file') {
			$this->TPLFileName = $TPLFileOrHtmlStringOrCompiledPHPCode;
			$this->InputTPLString = $this->ReadTPLFile();
		}
		if($Mode == 'html') $this->HtmlString = $TPLFileOrHtmlStringOrCompiledPHPCode;
		if($Mode == 'compiled') $this->CompiledPHPCode = $TPLFileOrHtmlStringOrCompiledPHPCode;
		$this->CompileTPL();
	}
	
	private function ReadTPLFile() {
		$TPLFilePath = self::$TPLFileDir . DIRECTORY_SEPARATOR . $this->TPLFileName . $this->TPLFileExt;
		if(file_exists($TPLFilePath)) {
			return file_get_contents($TPLFilePath);
		}
		else {
			throw new VTE_Exception ('TPL file not found ' . $this->TPLFileName);
			trigger_error('TPL file not found ' . $this->TPLFileName);
		}
	}
	
	private function DetectCodeTag() {
		$SingleVar = $this->SingleVar;
		$VarElement = $this->VarElement;
		
		$CodesCheck = 
			array(
				'if'		=> 'if(:condition){0,1}\s*\(.*\)',
				'elseif'	=> 'elseif(:condition){0,1}\s*\(.*\)',
				'else'		=> 'else',
				'end_if'	=> '\/if',
				'for'		=> 'for\s+\$' . $SingleVar . '+\s+in\s+\$' . $VarElement . '*\s*(?: as\s+\$' . $SingleVar . '+)?',
				'end_for'	=> '\/for',
				'skip'		=> 'skip',
				'end_skip'	=> '\/skip',
				'comment'	=> '\/\*\*',
				'end_comment'	=> '\*\*\/'
			);
		
		$_c = array();
		foreach($CodesCheck as $key =>$code)
			$_c[$key] = '(\\' . $this->Tag['left'] . $code . '\\' . $this->Tag['right'] . ')';

		$CodesCheck = $_c; unset($_c);	
		$CodesCheck = '/' . join('|', $CodesCheck) . '/';
		return preg_split ($CodesCheck, $this->InputTPLString, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);	
	}
	
	private function CompileFunction($Code, $echo = false) {
		if(preg_match_all('/' . '\{\#{0,1}(\"{0,1}.*?\"{0,1})(\|\w.*?)\#{0,1}\}' . '/', '{$a|GetAlias:1,2}', $matches)) {
			$Count = count($matches);
			for($i = 0; $i < $Count; $i++) {
				//complete tag ex: {$news.title|substr:0,100}
				$tag = $matches[0][$i] ;
				//variable name ex: news.title
				$var = $matches[1][$i];
				//function and parameters associate to the variable ex: substr:0,100
				$extra_var = $matches[2][$i];
				$extra_var = $this->CompileVariable($extra_var);
				// check if there's an operator = in the variable tags, if there's this is an initialization so it will not output any value
				$is_init_variable = preg_match( "/^(\s*?)\=[^=](.*?)$/", $extra_var );
				//function associate to variable
				$function_var = ( $extra_var and $extra_var[0] == '|') ? substr( $extra_var, 1 ) : NULL;
				//variable path split array (ex. $news.title o $news[title]) or object (ex. $news->title)
				$temp = preg_split( "/\.|\[|\-\>/", $var );
				//variable name
				$var_name = $temp[ 0 ];
				//variable path
				$variable_path = substr( $var, strlen( $var_name ) );
				//parentesis transform [ e ] in [" e in "]
				$variable_path = str_replace( '[', '["', $variable_path );
				$variable_path = str_replace( ']', '"]', $variable_path );
				//transform .$variable in ["$variable"]
				$variable_path = preg_replace('/\.\$(\w+)/', '["$\\1"]', $variable_path );
				//transform [variable] in ["variable"]
				$variable_path = preg_replace('/\.(\w+)/', '["\\1"]', $variable_path );
				//if there's a function
				if( $function_var )
				{   
					// check if there's a function or a static method and separate, function by parameters
					$function_var = str_replace("::", "@double_dot@", $function_var );
					// get the position of the first :
					if($dot_position = strpos( $function_var, ":" )) {
						// get the function and the parameters
						$function = substr( $function_var, 0, $dot_position );
						$params = substr( $function_var, $dot_position+1 );
					}
					else {
						//get the function
						$function = str_replace( "@double_dot@", "::", $function_var );
						$params = NULL;
					}
					// replace back the @double_dot@ with ::
					$function = str_replace( "@double_dot@", "::", $function );
					$params = str_replace( "@double_dot@", "::", $params );
				}
				else $function = $params = NULL;
	
				$php_var = $var_name . $variable_path;
				// compile the variable for php
				if(isset($function))
				{
					if($php_var)
						$php_var = ( !$is_init_variable && $echo ? 'echo ' : NULL ) . ( $params ? "( $function( $php_var, $params ) )" : "$function( $php_var )" );
					else
						$php_var = ( !$is_init_variable && $echo ? 'echo ' : NULL ) . ( $params ? "( $function( $params ) )" : "$function()" );
				}
				else
					$php_var = ( !$is_init_variable && $echo ? 'echo ' : NULL ) . $php_var . $extra_var;
	
				$Code = str_replace( $tag, $php_var, $Code );
			}
			return $Code;
		}
	}
	
	private function CompileVariable($Code, $echo = false) {
		if(preg_match_all('/\$(' . $this->VarElement . ')/', $Code, $matches)) {
			$n = count($matches[0]);
			$Parsed = array();
			for($i = 0; $i < $n; $i++ )
				$Parsed[$matches[0][$i]] = array('Var' => $matches[1][$i],'ExtraVar'=>$matches[2][$i]);
			foreach($Parsed as $Tag => $Value) {
				$Var = $Value['Var'];
				$ExtraVar = $this->CompileVariable($Value['ExtraVar']);
				$is_init_variable = preg_match( "/^[a-z_A-Z\.\[\](\-\>)]*=[^=]*$/", $ExtraVar );
				$FunctionVar = ( $ExtraVar and $ExtraVar[0] == '|') ? substr( $ExtraVar, 1 ) : NULL;
				//variable path split array (ex. $news.title o $news[title]) or object (ex. $news->title)
				$_temp = preg_split( "/\.|\[|\-\>/", $Var );
				//variable name
				$VarName = $_temp[0];
				//variable path
				$VariablePath = substr( $Var, strlen( $VarName ) );
				//parentesis transform [ e ] in [" e in "]
				$VariablePath = str_replace( '[', '["', $VariablePath );
				$VariablePath = str_replace( ']', '"]', $VariablePath );
				//transform .$variable in ["$variable"] and .variable in ["variable"]
				$VariablePath = preg_replace('/\.(\${0,1}\w+)/', '["\\1"]', $VariablePath );
				if( $is_init_variable )
					$ExtraVar = "=\$this->var['{$VarName}']{$VariablePath}" . $ExtraVar;
				
				if($FunctionVar) {            
					// check if there's a function or a static method and separate, function by parameters
					$function_var = str_replace("::", "@double_dot@", $function_var );
					// get the position of the first :
					if($dot_position = strpos( $function_var, ":" )) {
						// get the function and the parameters
						$function = substr( $function_var, 0, $dot_position );
						$params = substr( $function_var, $dot_position + 1 );
					}
					else {
						//get the function
						$function = str_replace( "@double_dot@", "::", $function_var );
						$params = NULL;
					}
					// replace back the @double_dot@ with ::
					$function = str_replace( "@double_dot@", "::", $function );
					$params = str_replace( "@double_dot@", "::", $params );
				}
				else
					$function = $params = NULL;
				
				$php_var = '$' . $VarName . $VariablePath;
				if(isset($function))
					$php_var = (!$is_init_variable && $echo ? 'echo ' : NULL ) . ( $params ? "( $function( $php_var, $params ) )" : "$function( $php_var )" );
				else
					$php_var = ( !$is_init_variable && $echo ? 'echo ' : NULL ) . $php_var . $ExtraVar;
                            
              	$Code = str_replace( $Tag, $php_var, $Code );
			}
		}
		return $Code;
	}
	
	private function CompileTPL() {
		$TPLCodes = $this->DetectCodeTag();
		//n($TPLCodes);
		$CompiledCode = array();
		$IfOpen = $ForOpen = $CommentOpen = $SkipOpen = 0;
		$CheckCommand['if'] = '/\\' . $this->Tag['left'] . 'if\s*\(\s*(.*)\s*\)\s*\\' . $this->Tag['right'] . '/';
		
		while($Html = array_shift($TPLCodes)) {
			// Remove all comment tag
			if($Html == '{**/}') {
				if($CommentOpen < 1) continue;
				else $CommentOpen--;
			}
			elseif($Html == '{/**}') {
				$CommentOpen++;
			}
			elseif($CommentOpen > 0 ) continue;
			
			// Skip all betwen Skip tag
			elseif($Html == '{skip}') {
				$SkipOpen++;
				if($SkipOpen == 1) continue;
				else $CompiledCode[] = $Html;
			}
			elseif($Html == '{/skip}') {
				if($SkipOpen == 1) {
					$SkipOpen = 0;
					continue;
				}
				else {
					$SkipOpen--;
					$CompiledCode[] = $Html;
				}
			}
			elseif($SkipOpen > 0) $CompiledCode[] = $Html;
			
			// Compile If command
			elseif(preg_match($CheckCommand['if'], $Html, $Code)) {
				$IfOpen++;
				$IfCondition = $Code[1];
				
				$parsed_condition = $this->CompileVariable($IfCondition);
				//if code
				$CompiledCode[] =   "<?php if($parsed_condition) { ?>";
			}
			//elseif
			elseif( preg_match( '/\{elseif(?: condition){0,1}\s*\(\s*(.*)\s*\)\s*\}/', $Html, $Code ) ){
				//tag
				$tag = $code[ 0 ];
				//condition attribute
				$condition = $code[ 1 ];
				//variable substitution into condition (no delimiter into the condition)
				$parsed_condition = $this->CompileVariable($condition);
				//elseif code
				$CompiledCode[] =   "<?php } elseif($parsed_condition) { ?>";
			}

			//else
			elseif( strpos( $Html, '{else}' ) !== FALSE ) {
				//else code
				$CompiledCode[] =   '<?php }else{ ?>';
			}

			//close if tag
			elseif( strpos( $Html, '{/if}' ) !== FALSE ) {
				//decrease if counter
				$IfOpen--;
				// close if code
				$CompiledCode[] =   '<?php } ?>';

			}
			else {
				$Html = $this->CompileVariable($Html, true);
				$CompiledCode[] = $this->CompileFunction($Html, true);
			}		
			
			//else $CompiledCode[] = '<font color="red">' . $Html . '</font>';
		}
		n($CompiledCode);
	}
	
	public function Output() {
		echo $this->InputTPLString;
	}
}

?>