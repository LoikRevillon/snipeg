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
 * Warn : $Theme must be created before $Lang
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

/*
 * Debug
 * -------------------------------------------------------------------------------------
*/

$actions = array('admin', 'browse', 'login', 'new', 'search', 'settings', 'single');

if(isset($_GET['action']) AND in_array($_GET['action'], $actions)) {
	$include = THEME_PATH . $Theme->dirname . '/' . $Theme->$_GET['action'];
} else {
	$include = THEME_PATH . $Theme->dirname . '/' . $Theme->default;
}

if(file_exists($include))
	include $include;