<?php

session_start();

define('index', 'index.php');

include ("config.php");
include ("functions.php");

Tool::loadTheme();
Tool::loadLanguage();

if (isset($_GET['logout'])) {
	session_destroy();
}

if (isset($_SESSION['user'])) {
	$includeFile= 'home';
} else {
	$includeFile= 'login';
}

if (isset($_GET['action']) AND !empty($_GET['action'])) {
	if (array_key_exists($_GET['action'], $_SESSION['theme'])) {
		$includeFile= $_GET['action'];
	}
} else {
	if (isset($_SESSION['user'])) {
		$includeFile= 'home';
	} else {
		$includeFile= 'login';
	}
}

include(THEME_PATH . $_SESSION['theme']['dirName'] . '/' . $_SESSION['theme'][$includeFile]);