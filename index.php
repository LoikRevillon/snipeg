<?php

/*
 * Preloading
 * -------------------------------------------------------------------------------------
*/

require 'config.php';
require 'functions.php';

Tool::preload();

if (!file_exists(DB_NAME) OR is_dir(DB_NAME)) {
	Tool::appendMessage('There is no database initialized. Think to install Snipeg first', M_WARNING);
}

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

Tool::readMessages();

// Logout
if(isset($_GET['logout']))
	session_destroy();

if (isset($_SESSION['user'])) {

	if (!empty($_GET)) {
		if (array_key_exists('action', $_GET))
			load_page();
		else if (array_key_exists('delete', $_GET))
			delete_snippet();
		else if (array_key_exists('search', $_GET))
			search_snippet();
	}

	if (!empty($_POST)) {

		if (array_key_exists('dologin', $_POST))
			do_login();
		else if (array_key_exists('dosignup', $_POST))
			do_sign_up();
		else if (array_key_exists('doreset', $_POST))
			do_reset();
		else if (array_key_exists('doadmin', $_POST))
			do_admin();
		else if (array_key_exists('addsnippet', $_POST))
			add_snippet();
		else if (array_key_exists('id', $_POST))
			delete_snippet();
		else if (array_key_exists('search', $_POST))
			do_search();
		else if (array_key_exists('updateaccount', $_POST))
			do_account();		
	}
} else {
	if (isset($_GET['id']) AND SnippetsManager::isPublic($_GET['id'])) {
		$includeFile = 'single';
	} else {
/*
		Tool::appendMessage($Lang->havetobelogin, Tool::M_ERROR);
*/
		$includeFile = 'login';
	}
}
	

$file = THEME_PATH . $Theme->dirname . '/' . $Theme->$includeFile;

if(file_exists($file) AND !is_dir($file))
	include $file;
