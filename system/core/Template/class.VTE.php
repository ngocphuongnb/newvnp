<?php

//$ArrayElement = '(\w+(?:\.\${0,1}[A-Za-z0-9_]+)*(?:(?:\[\${0,1}[A-Za-z0-9_]+\])|(?:\-\>\${0,1}[A-Za-z0-9_]+))*)(.*?)';

class VTE
{
	private		$Tag = array('left' => '{', 'right' => '}');
	protected	$SingleVar = '[a-zA-Z0-9\_]';
	protected	$VarElement = '\w+(?:\.\${0,1}[A-Za-z0-9_]+)*(?:(?:\[\${0,1}[A-Za-z0-9_]+\])|(?:\-\>\${0,1}[A-Za-z0-9_]+))*(.*?)';
	
	private $CACHE_EXPIRE_TIME = 3600; // default cache expire time = hour
	private $InputTPLString = '';
	private $TPLFileName = '';
	private $HtmlString = '';
	private $CompiledPHPCode = '';
	private $TPLFilePath = '';
	private $CompiledFilePath = '';
	private $CachedFilePath = '';
	private $ReCompile = false;
	private $IsCache = false;
	private $VAR = array();
	
	static $TPLFileDir = '/';
	static $CompiledDir = '/';
	static $CacheDir = '/';
	static	$MergedDir = '/';
	
	public $_TPLFileDir = '/';
	public $_CompiledDir = '/';
	public $_CacheDir = '/';
	public $_MergedDir = '/';
	
	public $TPLFileExt = '.tpl';
	static function TPLFileDir($TPLFileDir) {
		self::$TPLFileDir = $TPLFileDir;
	}
	
	public function __construct() {
		$this->_TPLFileDir = self::$TPLFileDir;
		$this->_CompiledDir = self::$CompiledDir;
		$this->_CacheDir = self::$CacheDir;
		$this->_MergedDir = self::$MergedDir;
	}
	
	public function SetDir($Name, $Value) {
		$Name = '_' . $Name;
		$this->$Name = $Value;
		return $this;
	}
	
	public function String($HtmlString = '', $ReCompile = false, $IsCache = false) {
		$this->ReCompile = $ReCompile;
		$this->IsCache = $IsCache;
		$this->HtmlString = $HtmlString;
		return $this;
	}
	
	public function Compiled($CompiledPHPCode, $ReCompile = false, $IsCache) {
		$this->ReCompile = $ReCompile;
		$this->IsCache = $IsCache;
		$this->CompiledPHPCode = $TPLFileOrHtmlStringOrCompiledPHPCode;
		return $this;
	}
	
	public function File($TPLFile = '', $ReCompile = false, $IsCache = false) {
		$this->ReCompile = $ReCompile;
		$this->IsCache = $IsCache;
		$this->TPLFileName = $TPLFile;
		$this->InputTPLString = $this->ReadTPLFile();
		return $this;
	}
	
	public function Assign($Name, $Value = NULL) {
		is_array($Name) ? $this->VAR += $Name : $this->VAR[$Name] = $Value;
		return $this;
	}
	
	public function Output($Return = true, $ReturnCompiled = false) {
		$TPLFileName = rtrim(basename($this->TPLFilePath), $this->TPLFileExt);
		$EncodedFileName = $TPLFileName . '_' . md5($this->TPLFilePath);
		$this->CompiledFilePath = $this->_CompiledDir . $EncodedFileName . '.php';
		$this->CachedFilePath = $this->_CacheDir . $EncodedFileName . '.html';
		if(	$this->ReCompile || 
			!file_exists($this->CompiledFilePath) || 
			(file_exists($this->CompiledFilePath) && filemtime($this->CompiledFilePath) < filemtime($this->TPLFilePath))
		) $ReCompile = true;
		else $ReCompile = false;
		
		if($ReCompile) $this->CompileTPL();
		if($ReturnCompiled) {
			$CompiledContent = file_get_contents($this->CompiledFilePath);
			return array('var' => $this->VAR, 'content' => $CompiledContent);
		}
		elseif($this->IsCache) {
			$CacheLifeTime = time() - filemtime($this->CachedFilePath);
			if(file_exists($this->CachedFilePath) && $CacheLifeTime < $this->CACHE_EXPIRE_TIME )
				file_get_contents( $this->CachedFilePath );
			else
				file_put_contents($this->CachedFilePath, $OutputContent );
		}
		elseif(!$Return && !$this->IsCache) {
			extract($this->VAR);
			include $this->CompiledFilePath;
		}
		else {
			ob_start();
            extract($this->VAR);
            include $this->CompiledFilePath;
            $OutputContent = ob_get_clean();
            // return or print the template
            if($Return) return $OutputContent; else echo $OutputContent;
		}
	}
	
	private function ReadTPLFile() {
		$this->TPLFilePath = $this->_TPLFileDir . $this->TPLFileName . $this->TPLFileExt;
		if(file_exists($this->TPLFilePath)) {
			return file_get_contents($this->TPLFilePath);
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
				'while'		=> 'while(:condition){0,1}\s*\(.*\)',
				'end_while'	=> '\/while',
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
	
	private function VariableTrueForm($Var) {
		$_temp = preg_split( "/\.|\[|\-\>/", $Var );
		$VarName = $_temp[0];
		//variable path
		$VariablePath = substr( $Var, strlen( $VarName ) );
		//parentesis transform [ e ] in [" e in "]
		$VariablePath = str_replace( '[', "['", $VariablePath );
		$VariablePath = str_replace( ']', "']", $VariablePath );
		//transform .$variable in ["$variable"] and .variable in ["variable"]
		$VariablePath = preg_replace('/\.(\${0,1}\w+)/', "['\\1']", $VariablePath );
		return $VarName . $VariablePath;
	}
	
	private function CompileFunction($Code, $echo = false) {
		if(preg_match_all('/' . '\{\#{0,1}(\"{0,1}.*?\"{0,1})(\|\w.*?)\#{0,1}\}' . '/', $Code, $matches)) {
			$Parsed = array();
			$TotalTags = count($matches[0]);
			for($i = 0; $i < $TotalTags; $i++) {
				$Tag['key']				= $matches[0][$i];
				$Tag['VariableName']	= $matches[1][$i];
				$Tag['ExtraFunction']	= $matches[2][$i];
				$Tag['FunctionName']	= '';
				$Tag['FunctionParams']	= '';
				
				if(preg_match_all('/\{(\$' . $this->VarElement . ')((?:\+\+|\-\-|\+=|\-=|\*=|=)([^=].*))\}/', $Tag['key'], $m)){
					$VarKey = $m[1][0];
					$IsInitializeVar = true;
					$InitializeVar = $m[1][0];
					$FunctionVar = trim($m[3][0]);
					$VarOnly = trim($m[4][0]);
					$subLength = strlen($FunctionVar) - strlen($VarOnly);
					$Math = trim(substr($FunctionVar, 0, $subLength));
					$VarOnly = substr($VarOnly, 0, -strlen($Tag['ExtraFunction']));
					
					if($Tag['ExtraFunction'] && $Tag['ExtraFunction'][0] == '|') {
						$Tag['ExtraFunction'] = ltrim($Tag['ExtraFunction'], '|');
						//Check Static Class method
						if(strpos($Tag['ExtraFunction'], '::') != NULL)
							$Tag['ExtraFunction'] = str_replace('::', '@@StaticClassMethodSignal@@', $Tag['ExtraFunction']);
						if(strpos($Tag['ExtraFunction'], ':') != NULL) {
							$_f = explode(':', $Tag['ExtraFunction']);
							$Tag['FunctionName']	= $_f[0];
							$Tag['FunctionParams']	= $_f[1];
						}
						else $Tag['FunctionName'] = $Tag['ExtraFunction'];
						
						$Tag['FunctionName'] = str_replace('@@StaticClassMethodSignal@@', '::', $Tag['FunctionName']);
						$FunctionName	= trim($Tag['FunctionName']);
						$InitializeVar	= $this->VariableTrueForm(trim($InitializeVar));
						$VarOnly	= $this->VariableTrueForm(trim($VarOnly));
						$ExtraParams	= $Tag['FunctionParams'];
						$PhpCompiled = !empty($ExtraParams) ? "$InitializeVar $Math $FunctionName($VarOnly,$ExtraParams)" : "$InitializeVar $Math $FunctionName($VarOnly)";
						$PhpCompiled = '<?php ' . $PhpCompiled . ' ?>';
						$Code = str_replace($Tag['key'], $PhpCompiled, $Code);
					}
				}
				else {
				
					if($Tag['ExtraFunction'] && $Tag['ExtraFunction'][0] == '|') {
						$Tag['ExtraFunction'] = ltrim($Tag['ExtraFunction'], '|');
						//Check Static Class method
						if(strpos($Tag['ExtraFunction'], '::') != NULL)
							$Tag['ExtraFunction'] = str_replace('::', '@@StaticClassMethodSignal@@', $Tag['ExtraFunction']);
						if(strpos($Tag['ExtraFunction'], ':') != NULL) {
							$_f = explode(':', $Tag['ExtraFunction']);
							$Tag['FunctionName']	= $_f[0];
							$Tag['FunctionParams']	= $_f[1];
						}
						else $Tag['FunctionName'] = $Tag['ExtraFunction'];
						
						$Tag['FunctionName'] = str_replace('@@StaticClassMethodSignal@@', '::', $Tag['FunctionName']);
						$FunctionName	= trim($Tag['FunctionName']);
						$VariableName	= $this->VariableTrueForm(trim($Tag['VariableName']));
						$ExtraParams	= $Tag['FunctionParams'];
						$PhpCompiled = ($echo ? 'echo ' : NULL) . (!empty($ExtraParams) ? "$FunctionName($VariableName,$ExtraParams)" : "$FunctionName($VariableName)");
						$PhpCompiled = '<?php ' . $PhpCompiled . ' ?>';
						$Code = str_replace($Tag['key'], $PhpCompiled, $Code);
					}
				}
			}
			
		}
		return $Code;
	}
	
	private function CompileVariable($Code, $echo = true) {
		if(preg_match_all('/\{\$(' . $this->VarElement . ')\}/', $Code, $matches)) {
			$n = count($matches[0]);
			$Parsed = array();
			for($i = 0; $i < $n; $i++ )
				$Parsed[$matches[0][$i]] = array('Var' => $matches[1][$i],'ExtraVar'=>$matches[2][$i]);
			foreach($Parsed as $Key => $Value) {
				$IsInitializeVar = false;
				$VarKey = '';
				if(preg_match_all('/\{(\$' . $this->VarElement . ')((?:\+\+|\-\-|\+=|\-=|\*=|=)([^=].*))\}/', $Key, $m)) {
					$VarKey = trim($m[1][0]);
					$IsInitializeVar = true;
				}
				if($IsInitializeVar) {
					$PhpCompiled = '<?php ' . $this->VariableTrueForm($VarKey) . $Value['ExtraVar'] . ' ?>';
				}
				elseif($echo) {
					$PhpCompiled = '<?php ' . ($echo ? 'echo ' : NULL) . $this->VariableTrueForm('$' . $Value['Var']) . ' ?>';
				}
				else
					$PhpCompiled = $this->VariableTrueForm('$' . $Value['Var']);
				$Code = str_replace($Key, $PhpCompiled, $Code);
			}
		}
		return $Code;
	}
	
	private function CompileConstant($Code, $echo = true) {
		if(preg_match_all('/\{\#(' . $this->VarElement . ')\}/', $Code, $matches)) {
			$n = count($matches[0]);
			$Parsed = array();
			for($i = 0; $i < $n; $i++ )
				$Parsed[$matches[0][$i]] = array('Var' => $matches[1][$i],'ExtraVar'=>$matches[2][$i]);
			foreach($Parsed as $Key => $Value) {
				$IsInitializeVar = false;
				$VarKey = '';
				if($echo) {
					$PhpCompiled = '<?php ' . ($echo ? 'echo ' : NULL) . $Value['Var'] . ' ?>';
				}
				else
					$PhpCompiled = $Value['Var'];
				$Code = str_replace($Key, $PhpCompiled, $Code);
			}
		}
		return $Code;
	}
	
	private function CompileCondition($Code, $echo = false) {
		if(preg_match_all('/\$(' . $this->VarElement . ')/', $Code, $matches)) {
			$n = count($matches[0]);
			$Parsed = array();
			for($i = 0; $i < $n; $i++ )
				$Parsed[$matches[0][$i]] = array('Var' => $matches[1][$i],'ExtraVar'=>$matches[2][$i]);
			foreach($Parsed as $Key => $Value) {
				if($echo)
					$PhpCompiled = '<?php ' . ($echo ? 'echo ' : NULL) . $this->VariableTrueForm('$' . $Value['Var']) . ' ?>';
				else
					$PhpCompiled = $this->VariableTrueForm('$' . $Value['Var']);
				$Code = str_replace($Key, $PhpCompiled, $Code);
			}
		}
		return $Code;
	}
	
	private function CompileTPL() {
		$TPLCodes = $this->DetectCodeTag();
		//n($TPLCodes);
		$CompiledCode = array();
		$IfOpen = $ForOpen = $WhileOpen = $CommentOpen = $SkipOpen = 0;
		$CheckCommand['if'] = '/\\' . $this->Tag['left'] . 'if\s*\(\s*(.*)\s*\)\s*\\' . $this->Tag['right'] . '/';
		$CheckCommand['elseif'] = '/\\' . $this->Tag['left'] . 'elseif(?: condition){0,1}\s*\(\s*(.*)\s*\)\s*\\' . $this->Tag['right'] . '/';
		$CheckCommand['for'] = '/\\' . $this->Tag['left'] . 'for\s+\$(?P<ArrayElement>' . $this->VarElement . ')\s+in\s+\$(?P<Array>' . $this->VarElement . ')\s*(?: as\s+\$(?P<ArrayKey>' . $this->VarElement . '))?\\' . $this->Tag['right'] . '/';
		$CheckCommand['while'] = '/\\' . $this->Tag['left'] . 'while\s*\(\s*(.*)\s*\)\s*\\' . $this->Tag['right'] . '/';
		
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
				$parsed_condition = $this->CompileCondition($IfCondition, false);
				$CompiledCode[] =   "<?php if($parsed_condition) { ?>";
			}
			//elseif
			elseif( preg_match($CheckCommand['elseif'], $Html, $Code ) ){
				$tag = $code[0];
				$condition = $code[1];
				$parsed_condition = $this->CompileCondition($condition, false);
				$CompiledCode[] =   "<?php } elseif($parsed_condition) { ?>";
			}
			//else
			elseif( strpos( $Html, '{else}' ) !== FALSE )
				$CompiledCode[] =   '<?php }else{ ?>';
			//close if tag
			elseif( strpos( $Html, '{/if}' ) !== FALSE ) {
				$IfOpen--;
				$CompiledCode[] =   '<?php } ?>';
			}
			// Compile For command
			elseif(preg_match($CheckCommand['for'], $Html, $Code)) {
				$ForOpen++;
				$Array = $this->VariableTrueForm('$' . $Code['Array']);
				$ArrayElement = $this->VariableTrueForm('$' . $Code['ArrayElement']);
				if(isset($Code['ArrayKey'])) {
					$ArrayKey = $this->VariableTrueForm('$' . $Code['ArrayKey']);
					$CompiledCode[] = "<?php foreach($Array as $ArrayKey => $ArrayElement) { ?>";
				}
				else
					$CompiledCode[] = "<?php foreach($Array as $ArrayElement) { ?>";
			}
			//close For tag
			elseif( strpos( $Html, '{/for}' ) !== FALSE ) {
				$ForOpen--;
				$CompiledCode[] =   '<?php } ?>';
			}
			// Compile While command
			elseif(preg_match($CheckCommand['while'], $Html, $Code)) {
				$WhileOpen++;
				$While = $Code[1];		
				$parsed_while = $this->CompileCondition($While, false);
				$CompiledCode[] =   "<?php while($parsed_while) { ?>";
			}
			//close For tag
			elseif( strpos( $Html, '{/while}' ) !== FALSE ) {
				$WhileOpen--;
				$CompiledCode[] =   '<?php } ?>';
			}
			else {
				$Html = $this->CompileFunction($Html, true);
				$Html = $this->CompileConstant($Html, true);
				$CompiledCode[] = $this->CompileVariable($Html, true);
			}	
			
			//else $CompiledCode[] = '<font color="red">' . $Html . '</font>';
		}
		file_put_contents($this->CompiledFilePath, $CompiledCode);
	}
	
	static function MergeCompiledFile($CompiledData,$MergedFileName) {
		$MergedContent = array();
		foreach($CompiledData as $D) {
			$_Var = var_export($D['var'], true);
			$_Content = $D['content'];
			$MergedContent[] = '<?php $_Var = ' . $_Var . '; extract($_Var); ?>' . $_Content;
		}
		file_put_contents(VTE::$MergedDir . $MergedFileName, implode(PHP_EOL, $MergedContent));
	}
	
	static function DeleteMergedFiles($Path = '') {
		if($Path == '') $Path = VTE::$MergedDir;
		$ListFiles = glob($Path . '*');
		foreach($ListFiles as $File)
			if(is_file($File)) unlink($File);
			
		/*
		foreach (new DirectoryIterator($Path) as $fileInfo) {
			if(!$fileInfo->isDot()) {
				unlink($fileInfo->getPathname());
				//unlink($Path . $fileInfo->getPathname());
			}
		}
		*/
	}
	static function DeleteCompiledFiles($Path = '') {
		if($Path == '') $Path = VTE::$CompiledDir;
		$ListFiles = glob($Path . '*');
		foreach($ListFiles as $File)
			if(is_file($File)) unlink($File);
	}
	static function DeleteCachedFiles($Path = '') {
		if($Path == '') $Path = VTE::$CacheDir;
		$ListFiles = glob($Path . '*');
		foreach($ListFiles as $File)
			if(is_file($File)) unlink($File);
	}
}

class MergedTPL
{
	private	$MergedFileList = array();
	private	$MergedData = array();
	private $TotalFile = 0;
	private $CurrentFile = 0;
	
	static	$TPLFileDir = '/';
	static	$CacheDir = '/';
	static	$MergedDir = '/';
	private $TPLFileExt = '.tpl';
	
	private function Init() {
		MergedTPL::$TPLFileDir	= VTE::$TPLFileDir;
		MergedTPL::$CacheDir	= VTE::$CacheDir;
		MergedTPL::$MergedDir	= VTE::$MergedDir;
	}
	public function Merge($TPLFileList) {
		$this->Init();
		$this->TotalFile = count($TPLFileList);
		$this->MergedFileList = $TPLFileList;
		return $this;
	}
	public function SavePath($Path = '') {
		if($Path != '') MergedTPL::$MergedDir = $Path;
		return $this;
	}
	public function AddFile($TPLFileName, $Vars = array(), $TPLFileDir = '') {
		$this->CurrentFile++;
		$TPLFileDir = ($TPLFileDir == '') ? MergedTPL::$TPLFileDir : $TPLFileDir;
		//$TPLFileName = rtrim($TPLFileName, '.tpl');
		$this->MergedData[$this->CurrentFile] = array('file' => $TPLFileName, 'dir' => $TPLFileDir, 'var' . $this->CurrentFile => $Vars);
		return $this;
	}
	public function OutputMerged($Return = false, $ReCompiled = false) {
		$MergedVars = array();
		$FileName = implode('_', $this->MergedFileList);
		$MergedFilePath = MergedTPL::$MergedDir . $FileName . '_' . md5($FileName) . '.php';
		
		$DetectTPLChanged = 0;
		$MergedFileTime = filemtime($MergedFilePath);
		foreach($this->MergedData as $i => $Data) {
			$MergedVars['var' . $i] = $Data['var' . $i];
			$_TPLFile = $Data['dir'] .  $Data['file'] . $this->TPLFileExt;
			if(filemtime($_TPLFile) > $MergedFileTime)
				$DetectTPLChanged++;
		}
		
		if(file_exists($MergedFilePath) && !$ReCompiled && $DetectTPLChanged == 0) {
					
		}
		else {
			$MergedContent = '';
			foreach($this->MergedData as $i => $Data) {
				$MergedVars['var' . $i] = $Data['var' . $i];
				$MergedContent .= '<?php extract($MergedVars[\'var' . $i . '\']); ?>';
				$_CompiledFile = TPL::File($Data['file'], true)
										->SetDir('TPLFileDir', $Data['dir'])
										//->Assign('var' . $i, $Data['var' . $i])
										->Output(false, true);
				$MergedContent .= $_CompiledFile['content'];
			}
			file_put_contents($MergedFilePath, '<?php if(!class_exists(\'MergedTPL\')) die(\'Invalid action!\') ?>' . $MergedContent);
		}
		if($Return) {
			ob_start();
			include $MergedFilePath;
			$OutputContent = ob_get_clean();
			return array('var' => $MergedVars, 'content' => $OutputContent);
		}
		else include $MergedFilePath;
	}
}

?>