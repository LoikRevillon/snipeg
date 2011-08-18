<?php

require '../../config.php';
require '../../functions.php';
require '../../classes/User.class.php';
require '../../classes/Snippet.class.php';
require '../../classes/SnippetsManager.class.php';
require '../../classes/PDOSQLite.class.php';
require '../../classes/Tool.class.php';

Tool::preload();

$User = null;
$Snippets = null;

// Set Global $User
if(!empty($_SESSION['user']))
	$User = Tool::formatUser($_SESSION['user']);

if(!empty($User)) {

	if(!empty($_GET['query'])) {

		$page = (empty($_GET['page']) OR !is_numeric($_GET['page'])) ? 1 : intval($_GET['page']);

		$manager = SnippetsManager::getReference();

		if(!empty($_GET['category']))
			$Snippets = $manager->instantSearch_GetSnippetsByCategory($User->id, $_GET['query'], $page);
		else
			$Snippets = $manager->instantSearch_GetSnippets($User->id, $_GET['query'], $page);

		$Snippets = array_map(function($s){ return Tool::formatSnippet($s); }, $Snippets);

	}

	echo json_encode($Snippets);

}