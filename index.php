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
$ThemesList = null;
$Lang = Tool::loadLanguage();
$LangsList = null;
$User = null;
$Users = array();
$Snippet = null;
$Snippets = array();
$Pages = array();
$Categories = array();

if(!file_exists(DB_NAME) OR is_dir(DB_NAME))
	Tool::appendMessage($Lang->warning_no_database_initialized, Tool::M_WARNING);

/*
 * Includes
 * -------------------------------------------------------------------------------------
*/

// Set Global $User
if(!empty($_SESSION['user']))
	$User = Tool::formatUser($_SESSION['user']);

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
	elseif(array_key_exists('updateaccount', $_POST))
		update_account();
	elseif(array_key_exists('edit-snippet', $_POST) OR array_key_exists('delete-snippet', $_POST))
		update_snippet();
}

if(isset($_SESSION['user'])) {

	if(!empty($_GET)) {

		if(array_key_exists('action', $_GET))
			$includeFile = load_page();
		elseif(array_key_exists('delete', $_GET))
			delete_snippet();

	} else {
		$includeFile = 'default';
	}

} else {
	if(isset($_GET['action']) AND $_GET['action'] === 'single')
		$includeFile = load_page();
	else
		$includeFile = 'login';
}

$file = THEME_PATH . $Theme->dirname . '/' . $Theme->$includeFile;

if(file_exists($file) AND !is_dir($file))
	include $file;
