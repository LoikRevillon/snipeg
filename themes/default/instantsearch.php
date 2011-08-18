<?php

require 'config.php';
require 'functions.php';

Tool::preload();

$User;
$Snippets;
// Set Global $User
if(!empty($_SESSION['user']))
	$User = Tool::formatUser($_SESSION['user']);

if (!empty($User)) {

	if (!empty($_GET['action']) AND $_GET['action'] == 'search')
		if (!empty($_GET['dosearch']) AND $_GET['dosearch'] == 'Search')
			if (!empty($_GET['query']))
				do_search();

	var_dump($Snippets);
	echo json_encode($Snippets);

}