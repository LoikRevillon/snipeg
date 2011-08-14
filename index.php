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
