<?php

class Snippet {
	
	private $_id;
	private $_name;
	private $_idUser;
	private $_lastUpdate;
	private $_content;
	private $_language;
	private $_comment;
	private $_category;
	private $_tags;
	private $_privacy;

	public function __construct($snippetInformations) {

			if (isset($snippetInformations['id']))
				$this->_id= $snippetInformations['id'];
			else
				$this->_id= false;
				
			$this->_name= $snippetInformations['name'];
			$this->_idUser= $snippetInformations['id_user'];
			$this->_lastUpdate= $snippetInformations['last_update'];
			$this->_content= $snippetInformations['content'];
			$this->_language= $snippetInformations['language'];			
			$this->_comment= $snippetInformations['comment'];			
			$this->_category= $snippetInformations['category'];
			$this->_tags= mb_strtolower($snippetInformations['tags'], 'utf-8');
			$this->_privacy= $snippetInformations['privacy'];
		
	}

	public function __get($varName){

		return $this->{$varName};
	
	}
	
	public function addNewSnippet () {
		
		$db= PDOSQLite::getDBLink();		
		$request= $db->prepare('INSERT INTO snippets VALUES (:name, :id_user, :last_update, :content, :language, :comment, :category, :tags, :privacy)');
															
		$request->bindParam(':name', $this->_name, PDO::PARAM_STR, 255);
		$request->bindParam(':id_user', $this->_idUser, PDO::PARAM_INT, 1);
		$request->bindParam(':last_update', $this->_lastUpdate, PDO::PARAM_INT, 32);
		$request->bindParam(':content', $this->_content, PDO::PARAM_STR);
		$request->bindParam(':language', $this->_language, PDO::PARAM_INT, 1);
		$request->bindParam(':comment', $this->_comment, PDO::PARAM_STR);
		$request->bindParam(':category', $this->_category, PDO::PARAM_STR, 80);
		$request->bindParam(':tags', $this->_tags, PDO::PARAM_STR);
		$request->bindParam(':privacy', $this->_privacy, PDO::PARAM_INT, 1);
		$addedRow= $request->execute();

		if ($addedRow == 1)
			return true;
		else
			return false;
		
	}

	public function deleteSnippet () {
		
		if (!empty($this->_id)) {
			$db= PDOSQLite::getDBLink();
			$request= $db->prepare('DELETE FROM snippets WHERE rowid = :id');
			$request->bindParam(':id', $this->_id, PDO::PARAM_STR, 1);
			$deletedRow= $request->execute();

			if (empty($deletedRow))
				return false;
			else
				return true;
				
		}
		
		return false;

	}

}