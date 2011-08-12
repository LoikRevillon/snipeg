<?php

	function __autoload($className) {
		$classPath= 'classes/'.$className.'.class.php';
		require ($classPath);
	}			