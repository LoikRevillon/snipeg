<?php

function __autoload($className) {

	$classPath = 'classes/' . $className . '.class.php';

	if(file_exists($classPath))
		require $classPath;

}

function is_admin() {

	return isset($_SESSION['user']->_admin);

}