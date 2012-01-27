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

	private $_private;

	public function __construct($snippetInformations) {

		if(isset($snippetInformations['id']))
			$this->_id= $snippetInformations['id'];
		else
			$this->_id= false;

		$this->_name = $snippetInformations['name'];
		$this->_idUser = $snippetInformations['id_user'];
		$this->_lastUpdate = $snippetInformations['last_update'];
		$this->_content = $snippetInformations['content'];
		$this->_language = $snippetInformations['language'];
		$this->_comment = $snippetInformations['comment'];
		$this->_category = mb_strtolower($snippetInformations['category'], 'utf-8');
		$this->_tags = mb_strtolower($snippetInformations['tags'], 'utf-8');
		$this->_private = $snippetInformations['private'];

	}

	public function __get($varName){

		if(isset($this->$varName))
			return $this->$varName;

	}

	public function __set($varName, $value) {

		if(isset($this->{$varName}))
			$this->{$varName} = $value;

	}

	public function toStdObject() {

		$snippetStd = new stdClass();

		$snippetStd->id = intval($this->_id);
		$snippetStd->name = $this->_name;
		$snippetStd->idUser = intval($this->_idUser);
		$snippetStd->lastUpdate = $this->_lastUpdate;
		$snippetStd->content = $this->_content;
		$snippetStd->language = intval($this->_language);
		$snippetStd->comment = $this->_comment;
		$snippetStd->category = $this->_category;
		$snippetStd->tags = array();
		$tagsArray = explode(',', preg_replace('# *, *#', ',', strtolower($this->_tags)));
		foreach($tagsArray AS $tag) {
			if(!empty($tag))
				$snippetStd->tags[] = $tag;
		}

		$snippetStd->privacy = ($this->_private) ? true : false;

		return $snippetStd;
	}

	public function addNewSnippet() {

		try {
			$db = PDOSQLite::getDBLink();
			$request = $db->prepare('INSERT INTO `snippets` VALUES (:name, :id_user, :last_update, :content, :language, :comment, :category, :tags, :private)');

			$request->bindParam(':name', $this->_name, PDO::PARAM_STR, 255);
			$request->bindParam(':id_user', $this->_idUser, PDO::PARAM_INT, 1);
			$request->bindParam(':last_update', $this->_lastUpdate, PDO::PARAM_INT, 32);
			$request->bindParam(':content', $this->_content, PDO::PARAM_STR);
			$request->bindParam(':language', $this->_language, PDO::PARAM_INT, 1);
			$request->bindParam(':comment', $this->_comment, PDO::PARAM_STR);
			$request->bindParam(':category', $this->_category, PDO::PARAM_STR, 80);
			$request->bindParam(':tags', strtolower($this->_tags), PDO::PARAM_STR);
			$request->bindParam(':private', $this->_private, PDO::PARAM_INT, 1);

			return $request->execute();
		} catch(Exception $e) {
			return false;
		}

	}

	public function deleteSnippet() {

		if(empty($this->_id))
			return false;

		try {
			$db = PDOSQLite::getDBLink();
			$request = $db->prepare('DELETE FROM `snippets` WHERE rowid = :id');
			$request->bindParam(':id', $this->_id, PDO::PARAM_STR, 1);
			return $request->execute();
		} catch(Exception $e) {
			return false;
		}

	}

}
