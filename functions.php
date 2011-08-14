<?php

if (defined('index')) {

	function __autoload($className) {
		$classPath= 'classes/'.$className.'.class.php';
		if (file_exists($classPath))
			require ($classPath);
	}
}