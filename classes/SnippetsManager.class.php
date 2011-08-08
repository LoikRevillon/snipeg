<?php

class SnippetsManager {

	private $arrayOfSnippets= array();

	public function __construct ($snippetName= false) {

		if (isset($name))
			return findMatchesSnippetsNames($snippetName);

	}

	public function findMatchesSnippetsNames ($snippetName) {

		$db= PDOSQLite::getDbLink();
		$request= $db->prepare('SELECT * FROM snippets WHERE name=:name ORDER BY DESC last_update');
		$request->execute( array('name' => $snippetName));

		while ($snippet= new Snippets($request->fetch(PDO::FETCH_ASSOC))) {
			$arrayOfSnippets[]= $snippet;
		}
		$request->closeCursor();

		if (empty($arrayOfResults))
			return false;
		else
			return $arrayOfSnippets;
			
	}

	public function getSnippetById ($id) {

		$db= PDOSQLite::getDbLink();
		$request= $db->prepare('SELECT * FROM snippets WHERE rowid = :id');
		$request->execute(array('id' => $id));

		$snippet= new Snippets($request->fetch(PDO::FETCH_ASSOC));
		return $snippet;

	}

	public function updateOldSnippetByNewOne ($oldSnippet, $newSnippet) {
		
		$db= PDOSQLite::getDbLink();
		$request= $db->prepare('UPDATE '.$this->_tableName.' SET
														:name,
														:owner,
														:content,
														:last_update,
														:comment,
														:category,
														:policy
														WHERE rowid = :id');
		$changes= $request->execute(array(
					'id' => $oldSnippet->_id,
					'name' => $newSnippet->_name,
					'owner' => $newSnippet->_owner,
					'content' => $newSnippet->_content,
					'last_update' => $newSnippet->_lastUpdate,
					'comment' => $newSnippet->_comment,
					'category' => $newSnippet->_category,
					'policy' => $newSnippet->policy
					));

		if ($changes == 1)
			return true;
		else
			return false;
			
	}

}
	