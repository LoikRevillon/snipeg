<?php

class Snippets {
	
	private $_id;
	private $_name;
	private $_owner;
	private $_content;
	private $_lastUpdate;
	private $_comment;
	private $_category;
	private $_policy;

	public function __construct($snippetInformations) {

		if (!empty($snippetInformations)) {
			$this->_init= true;
			$this->_id= $snippetInformations['id'];
			$this->_name= $snippetInformations['name'];
			$this->_owner= $snippetInformations['owner'];
			$this->_content= $snippetInformations['content'];
			$this->_lastUpdate= $snippetInformations['lastUpdate'];
			$this->_comment= $snippetInformations['comment'];
			$this->_category= $snippetInformations['category'];
			$this->_policy= $snippetInformations['policy'];
		}
		
	}

	public function storeThisNewSnippetInDB () {
		
		$db= PDOSQLite::getDbLink();
		$request= $db->prepare('INSERT INTO snippets VALUES (
															:name,
															:owner,
															:content,
															:last_update,
															:comment,
															:category,
															:policy)');
		$request->execute(array(
					'name' => $this->_name,
					'owner' => $this->_owner,
					'content' => $this->_content,
					'last_update' => $this->_lastUpdate,
					'comment' => $this->_comment,
					'category' => $this->_category,
					'policy' => $this->_policy
					));
/*
					'owner' => $snippetInformations['owner'],
					'content' => $snippetInformations['content'],
					'last_update' => $snippetInformations['lastUpdate'],
					'comment' => $snippetInformations['comment'],
					'category' => $snippetInformations['category'],
					'policy' => $snippetInformations['policy']
					));
*/

		return true;
		
	}

/*
	public function updateSnippet ($idOfUpdatableSnippet) {
		
		$request= PDOSQLite::getDbLink()->prepare('UPDATE '.$this->_tableName.' SET :name, :owner, :content, :last_update, :comment, :category, :policy WHERE rowid = :id');
		$changes= $request->execute(array(
					'id' => $snippetInformations['id'],
					'name' => $snippetInformations['name'],
					'owner' => $snippetInformations['owner'],
					'content' => $snippetInformations['content'],
					'last_update' => $snippetInformations['lastUpdate'],
					'comment' => $snippetInformations['comment'],
					'category' => $snippetInformations['category'],
					'policy' => $snippetInformations['policy']
					));

		if ($changes == 1)
			return true;
		else
			return false;
			
	}
*/

	public function deleteThisSnippetFromDB () {

		$db= PDOSQLite::getDbLink();
		$request= $db->prepare('DELETE FROM '.$this->_tableName.' WHERE rowid = :id');
		$request->bindParam(':id', $this->_id, PDO::PARAM_INT);

		return true;

	}

}