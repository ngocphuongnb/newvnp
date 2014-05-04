<?php

class File
{
	static function CreateFile($FilePath, $Content = '') {
		if(file_exists(dirname($FilePath))) {
			file_put_contents($FilePath, $Content);
		}
	}
	
	static function CreateDirectory($pathname, $mode = 0777, $recursive = false, $context) {
		mkdir($pathname, $mode, $recursive, $context);
	}
}


?>