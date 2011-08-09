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

			if (isset($snippetInformations['id']))
				$this->_id= $snippetInformations['id'];
			else
				$this->_id= false;
				
			$this->_name= $snippetInformations['name'];
			$this->_owner= $snippetInformations['owner'];
			$this->_content= $snippetInformations['content'];
			$this->_lastUpdate= $snippetInformations['last_update'];
			$this->_comment= $snippetInformations['comment'];
			$this->_category= $snippetInformations['category'];
			$this->_policy= $snippetInformations['policy'];
		
	}

	public function pushItInDB () {
		
		$db= PDOSQLite::getDbLink();
		$request= $db->prepare('INSERT INTO snippets VALUES (
															:name,
															:owner,
															:content,
															:last_update,
															:comment,
															:category,
															:policy)');
															
		$request->bindParam(':name', $this->_name, PDO::PARAM_STR, 255);
		$request->bindParam(':owner', $this->_owner, PDO::PARAM_STR, 30);
		$request->bindParam(':content', $this->_content, PDO::PARAM_STR);
		$request->bindParam(':last_update', $this->_lastUpdate, PDO::PARAM_INT, 32);
		$request->bindParam(':comment', $this->_comment, PDO::PARAM_STR, 30);
		$request->bindParam(':category', $this->_category, PDO::PARAM_INT);
		$request->bindParam(':policy', $this->_policy, PDO::PARAM_INT, 1);
		$request->execute();
		
/*
				$request->execute(array(
					'name' => $this->_name,
					'owner' => $this->_owner,
					'content' => $this->_content,
					'last_update' => $this->_lastUpdate,
					'comment' => $this->_comment,
					'category' => $this->_category,
					'policy' => $this->_policy
					));
*/

		return true;
		
	}

	public function deleteThisSnippetFromDB () {
		
		if (!empty($this->_id)) {
			$db= PDOSQLite::getDbLink();
			$request= $db->prepare('DELETE FROM snippets WHERE rowid = :id');
			$request->bindParam(':id', $this->_id, PDO::PARAM_STR);
			$request->execute();

			return true;
		}
		
		return false;

	}

	public function getId() {
		
		return $this->_id;
		
	}

	public function giveMeArray () {

		return array('id' => $this->_id,
					'name' => $this->_name,
					'owner' => $this->_owner,
					'content' => $this->_content,
					'last_update' => $this->_lastUpdate,
					'comment' => $this->_comment,
					'category' => $this->_category);

	}

}