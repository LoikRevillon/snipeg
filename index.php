<?php

/*
 * Preloading
*/

session_start();

require 'config.php';
require 'functions.php';

Tool::loadTheme();
Tool::loadLanguage();

/*
 * Logout
*/

if(isset($_GET['logout']))
	session_destroy();

/*
 * Need login ?
*/

// FAIL ! Ça sert à quoi de mettre les snippets privés ou public ?
if(isset($_SESSION['user']))
	$includeFile = 'home';
else
	$includeFile = 'login';

/*
 * File selection
*/

if (isset($_GET['action']) AND !empty($_GET['action'])) {

	if(array_key_exists($_GET['action'], $_SESSION['theme']))
		$includeFile= $_GET['action'];

} else {

	if (isset($_SESSION['user']))
		$includeFile= 'home';
	else
		$includeFile= 'login';

}

/*
 * Final inclusion
*/

$file = THEME_PATH . $_SESSION['theme']['dirName'] . '/' . $_SESSION['theme'][$includeFile];

if(file_exists($file) AND !is_dir($file))
	include $file;