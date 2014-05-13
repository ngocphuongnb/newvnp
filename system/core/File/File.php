<?php

class File
{
	static function Create($FilePath, $Content = '') {
		if(file_exists(dirname($FilePath))) {
			file_put_contents($FilePath, $Content);
		}
	}
	
	static function UpdateFile($FilePath, $Content = '') {
		if(file_exists(dirname($FilePath))) {
			file_put_contents($FilePath, $Content);
		}
	}
	
	static function CreateDirectory($pathname, $mode = 0777, $recursive = false, $context) {
		mkdir($pathname, $mode, $recursive, $context);
	}
	
	static function GetContent($FilePath) {
		if(file_exists($FilePath)) return file_get_contents($FilePath);
		else throw new Exception('File::GetFileContent() File not found!');
	}
}


?>