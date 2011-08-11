<?php

define('index');

session_start();

include ("config.php");
include ("functions.php");

switch ($_GET) {

	case 'admin':
		$title= 'Administration';
		$body= 'admin.php';
	break;
	
	case 'login':
		$title= 'Login';
		$body= 'login.php';
	break;

	case 'account';
		$title= 'Account settings';
		$body= 'account.php';
	break;

	case 'overview':
	default:
		$title= 'Overview';
		$body= 'overview.php';