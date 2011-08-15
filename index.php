<?php

/*
 * Preloading
 * -------------------------------------------------------------------------------------
*/

session_start();

require 'config.php';
require 'functions.php';

Tool::preload();

/*
 * Global variables
 * -------------------------------------------------------------------------------------
*/

$Theme = Tool::loadTheme();
$Lang = Tool::loadLanguage();
$Snippet = null;

/*
 * Includes
 * -------------------------------------------------------------------------------------
*/

// Logout
if(isset($_GET['logout']))
	session_destroy();
var_dump($Theme);

/*
if (!empty($_GET['action'])) {
*/
if (!empty($_GET)) {
	switch($_GET) {
		case 'action':
			load_page();
			break;
		case 'delete':
			delete_snippet();
			break;
		case 'search':
			search_snippet();
			break;
	}	
} else {

	if (isset($_SESSION['user']))
		$includeFile= 'home';
	else
		$includeFile= 'login';

}

if (!empty($_POST)) {

	switch($_POST) {
		case 'dologin':
			do_login();
			break;
		case 'dosignup':
			do_sign_up();
			break;
		case 'doreset':
			do_reset();
			break;
		case 'doadmin':
			do_admin();
			break;
		case 'addsnippet':
			add_snippet();
			break;
		case 'id':
			delete_snippet();
			break;
		case 'dosearch':
			do_search();
			break;
		case 'updateaccount':
			do_account();
			break;
	}
}

$file = THEME_PATH . $_SESSION['theme']['name'] . '/' . $Theme->$includeFile;

if(file_exists($file) AND !is_dir($file))
	include $file;
