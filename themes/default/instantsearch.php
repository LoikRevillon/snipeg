<?php

require '../../config.php';
require '../../functions.php';
require '../../classes/User.class.php';
require '../../classes/Snippet.class.php';
require '../../classes/SnippetsManager.class.php';
require '../../classes/UsersManager.class.php';
require '../../classes/PDOSQLite.class.php';
require '../../classes/Tool.class.php';

Tool::preload();

$Pages = null;
$Snippets = null;
$User = null;

// Set Global $User
if(!empty($_SESSION['user']))
	$User = $_SESSION['user']->toStdObject();

if(!empty($User)) {

	if(!empty($_GET['query'])) {

		$page = (empty($_GET['page']) OR !is_numeric($_GET['page'])) ? 1 : intval($_GET['page']);

		$manager = SnippetsManager::getReference();

		if(!empty($_GET['category']))
		{
			$snippets = $manager->instantSearch_countOfSnippets( $User->id, $_GET['query'], $_GET['category'] );
			$page = create_paging( $snippets->count, NUM_SNIPPET_PER_PAGE );
			$Snippets = $manager->instantSearch_GetSnippetsByCategory($User->id, $_GET['query'], $_GET['category'], $page);
		}
		else
		{
			$snippets = $manager->instantSearch_countOfSnippets( $User->id, $_GET['query'] );
			$page = create_paging( $snippets->count, NUM_SNIPPET_PER_PAGE );
			$Snippets = $manager->instantSearch_GetSnippets($User->id, $_GET['query'], $page);
		}
		$Snippets = array_map( function( $s ){ return $s->toStdObject(); }, $Snippets );

		$manager = UsersManager::getReference();

		foreach( $Snippets as $snippet )
		{
			if ( empty( $lastId ) OR $lastId !== $snippet->idUser )
			{
				$lastId = $snippet->idUser;
				$userFromDB = $manager->getUserInformations( $lastId );
			}
			$snippet->owner = $userFromDB->_name;
		}
		$infos = new stdClass();
		$infos->snippets = $Snippets;
		$infos->page = $Pages;
	}

	echo json_encode($infos);

}
