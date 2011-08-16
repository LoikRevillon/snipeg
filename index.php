<?php

/*
 * Preloading
 * -------------------------------------------------------------------------------------
*/

require 'config.php';
require 'functions.php';

Tool::preload();

if(!file_exists(DB_NAME) OR is_dir(DB_NAME)) {
	Tool::appendMessage('There is currently no database initialized. Think to install Snipeg first.', Tool::M_WARNING);
}

/*
 * Global variables
 * -------------------------------------------------------------------------------------
*/

$Theme = Tool::loadTheme();
$Lang = Tool::loadLanguage();
$Snippet = null;
$Snippets = array();

/*
 * Includes
 * -------------------------------------------------------------------------------------
*/

if(!empty($_POST)) {

	if(array_key_exists('dologin', $_POST))
		do_login();
	elseif(array_key_exists('dosignup', $_POST))
		do_sign_up();
	elseif(array_key_exists('doreset', $_POST))
		do_reset();
	elseif(array_key_exists('doadmin', $_POST))
		do_admin();
	elseif(array_key_exists('addsnippet', $_POST))
		add_snippet();
	elseif(array_key_exists('id', $_POST))
		delete_snippet();
	elseif(array_key_exists('search', $_POST))
		do_search();
	elseif(array_key_exists('updateaccount', $_POST))
		do_account();
}

if(isset($_SESSION['user'])) {

	if(!empty($_GET)) {

		if(array_key_exists('action', $_GET))
			load_page(&$includeFile);
		elseif(array_key_exists('delete', $_GET))
			delete_snippet();
		elseif(array_key_exists('search', $_GET))
			search_snippet();

	} else {
		$includeFile = 'default';
	}

} else {
	if(isset($_GET['id']) AND SnippetsManager::isPublic($_GET['id'])) {
		$includeFile = 'single';
	} else {
		$includeFile = 'login';
	}
}

Tool::readMessages();

$file = THEME_PATH . $Theme->dirname . '/' . $Theme->$includeFile;

if(file_exists($file) AND !is_dir($file))
	include $file;
