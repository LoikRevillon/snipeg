<?php

/*
 * Preloading
 * -------------------------------------------------------------------------------------
*/

require 'config.php';
require 'functions.php';

Tool::preload();

/*
 * Global variables
 * -------------------------------------------------------------------------------------
*/

$Theme = Tool::loadTheme();
$Lang = Tool::loadLanguage();
$User = null;
$Users = array();
$Snippet = null;
$Snippets = array();
$Pages = array();

if(!file_exists(DB_NAME) OR is_dir(DB_NAME))
	Tool::appendMessage($Lang->warning_no_database_initialized, Tool::M_WARNING);

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
		update_account();
	elseif(array_key_exists('edit-snippet', $_POST) OR array_key_exists('delete-snippet', $_POST))
		update_snippet();
}

// Set Global $User
if(!empty($_SESSION['user']))
	$User = Tool::formatUser($_SESSION['user']);

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
	if(isset($_GET['action']) AND $_GET['action'] === 'single')
		load_page(&$includeFile);
	else
		$includeFile = 'login';
}

$file = THEME_PATH . $Theme->dirname . '/' . $Theme->$includeFile;

if(file_exists($file) AND !is_dir($file))
	include $file;
