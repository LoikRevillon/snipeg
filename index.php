<?php

session_start();
session_destroy();

define('index', 'index.php');

include ("config.php");
include ("functions.php");

Tool::loadTheme();
Tool::loadLanguage();

$theme= $_SESSION['theme'];

/*
if (isset($_SESSION['user'])) {
	$includeFile= 'home';
} else {
	$includeFile= 'login';
}
*/

if (isset($_GET['action']) AND !empty($_GET['action'])) {
	if (array_key_exists($_GET['action'], $_SESSION['theme'])) {
		$includeFile= $_GET['action'];
	}
}

include('themes/' . $_SESSION['theme']['dirName'] . '/' . $_SESSION['theme'][$includeFile]);