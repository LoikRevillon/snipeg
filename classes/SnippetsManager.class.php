<?php

class SnippetsManager {

	private $_snippetName;

	public function __construct ($snippetName= false) {

		$this->_snippetName= $snippetName;
	}

	public function findMatchesSnippetsNames ($snippetName= false) {

		if (!empty($snippetName))
			$this->_snippetName= $snippetName;

		$db= PDOSQLite::getDbLink();
		$request= $db->prepare('SELECT rowid as id,
												name,
												owner,
												last_update,
												content,
												comment,
												category,
												policy
											FROM snippets
											WHERE name=:name
											ORDER BY last_update DESC');

		$request->bindParam(':name', $this->_snippetName, PDO::PARAM_STR, 255);
		$request->execute();
											
/*
		$request->execute( array('name' => $this->_snippetName));
*/

		while ($arrayOfResults= $request->fetch(PDO::FETCH_ASSOC)) {
			$snippet= new Snippets($arrayOfResults);
			$arrayOfSnippets[]= $snippet;
		}
		$request->closeCursor();

		if (empty($arrayOfSnippets))
			return false;
		else
			return $arrayOfSnippets;
			
	}

	public function getSnippetById ($id) {

		$db= PDOSQLite::getDbLink();
		$request= $db->prepare('SELECT rowid as id,
											name,
											owner,
											last_update,
											content,
											comment,
											category,
											policy
											FROM snippets
											WHERE rowid = :id');
											
		$request->bindParam(':id', $id, PDO::PARAM_INT);
		$request->execute();

/*
		$request->execute(array('id' => $id));
*/

		$snippet= new Snippets($request->fetch(PDO::FETCH_ASSOC));
		return $snippet;

	}

	public function updateOldSnippetByNewOne ($oldSnippet, $newSnippet) {
		
		$db= PDOSQLite::getDbLink();
		$request= $db->prepare('UPDATE snippets SET
												name = :name,
												owner = :owner,
												content = :content,
												last_update = :last_update,
												comment = :comment,
												category = :category,
												policy = :policy
												WHERE rowid = :id');

		$arrayForOldSnippet= $newSnippet->giveMeArray();

		$request->bindParam(':id', $oldSnippet->getId(), PDO::PARAM_INT);
		$request->bindParam(':name', $arrayForOldSnippet['name'], PDO::PARAM_STR, 255);
		$request->bindParam(':owner', $arrayForOldSnippet['owner'], PDO::PARAM_STR, 30);
		$request->bindParam(':content', $arrayForOldSnippet['content'], PDO::PARAM_STR);
		$request->bindParam(':last_update', $arrayForOldSnippet['ladt_update'], PDO::PARAM_INT, 32);
		$request->bindParam(':comment', $arrayForOldSnippet['comment'], PDO::PARAM_STR, 30);
		$request->bindParam(':category', $arrayForOldSnippet['category'], PDO::PARAM_INT);
		$request->bindParam(':policy', $arrayForOldSnippet['policy'], PDO::PARAM_INT, 1);

		$changes= $request->execute();
		
/*
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
*/

		if ($changes == 1)
			return true;
		else
			return false;
			
	}

	public function deleteSnippetFromDB ($id) {
		
		if (!empty($id)) {
			$db= PDOSQLite::getDbLink();
			$request= $db->prepare('DELETE FROM snippets
											WHERE rowid = :id');
			$request->bindParam(':id', $id, PDO::PARAM_INT);
			$request->execute();

			return true;
		}
		
		return false;

	}

}
	