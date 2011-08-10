<?php

class SnippetsManager {

	private static $_instance;

	private function __construct() {}

	final private function __clone() {}

	public static function getReference() {

		if (!isset(self::$_instance))
			self::$_instance= new self();

		return self::$_instance;

	}

	public function getSnippetById ($id) {

		$db= PDOSQLite::getDBLink();
		$request= $db->prepare('SELECT rowid as id, * FROM snippets WHERE rowid = :id');
											
		$request->bindParam(':id', $id, PDO::PARAM_INT, 1);
		$request->execute();

		$result= $request->fetch(PDO::FETCH_ASSOC);
		$snippet= new Snippet($result);
		
		return $snippet;

	}
	
	public function getPublicSnippets($userId) {

		$db= PDOSQLite::getDBLink();
		$request= $db->prepare('SELECT rowid as id, * FROM snippets WHERE id_user = :id_user AND privacy != 0 ORDER BY last_update DESC');
		$request->bindParam(':id_user', $userId, PDO::PARAM_INT, 1);
		$request->execute();

		$publicSnippets= array();

		while ($result= $request->fetch(PDO::FETCH_ASSOC)) {
			$oneOfMatchedSnippet= new Snippet($result);
			$publicSnippets[]= $oneOfMatchedSnippet;
			unset($oneOfMatchedSnippet);
		}

		return $publicSnippets;

	}

	public function getSnippetsMatchedByName($idUser, $snippetName) {

		$db= PDOSQLite::getDBLink();
		$request= $db->prepare('SELECT rowid as id, * FROM snippets WHERE id_user = :id_user AND name = :name ORDER BY last_update DESC');
		$request->bindParam(':id_user', $idUser, PDO::PARAM_INT, 1);
		$request->bindParam(':name', $snippetName, PDO::PARAM_STR, 255);
		$request->execute();

		$snippetsMatchedByName= array();

		while ($result= $request->fetch(PDO::FETCH_ASSOC)) {
			$oneOfMatchedSnippet= new Snippet($result);
			$snippetsMatchedByName[]= $oneOfMatchedSnippet;
			unset($oneOfMatchedSnippet);
		}

		return $snippetsMatchedByName;

	} 

	public function getYoungerSnippets($userId, $timestamp) {

		$db= PDOSQLite::getDBLink();
		$request= $db->prepare('SELECT rowid as id, * FROM snippets WHERE id_user = :id_user AND last_update >= :timestamp  ORDER BY last_update');
		$request->bindParam(':id_user', $userId, PDO::PARAM_INT, 1);
		$request->bindParam(':timestamp', $timestamp, PDO::PARAM_INT, 32);
		$request->execute();

		$youngerSnippet= array();

		while ($result= $request->fetch(PDO::FETCH_ASSOC)) {
			$oneOfMatchedSnippet= new Snippet($result);
			$youngerSnippet[]= $oneOfMatchedSnippet;
			unset($oneOfMatchedSnippet);
		}

		return $youngerSnippet;
			
	}

	public function getSnippetByCategory($userId, $categoryName) {

		$db= PDOSQLite::getDBLink();
		$request= $db->prepare('SELECT rowid as id, * FROM snippets WHERE id_user = :id_user AND category = :category ORDER BY last_update DESC');
		$request->bindParam(':id_user', $userId, PDO::PARAM_INT, 1);
		$request->bindParam(':category', $categoryName, PDO::PARAM_STR, 80);
		$request->execute();

		$snippetsMatchedByCategory= array();

		while ($result= $request->fetch(PDO::FETCH_ASSOC)) {
			$oneOfMatchedSnippet= new Snippet($result);
			$snippetsMatchedByCategory[]= $oneOfMatchedSnippet;
			unset($oneOfMatchedSnippet);
		}

		return $snippetsMatchedByCategory;

	}

	public function getSnippetsByTag ($userId, $tag) {

		var_dump($userId);
		var_dump($tag);

		$db= PDOSQLite::getDBLink();
		$request= $db->prepare('SELECT rowid AS id, * FROM snippets WHERE id_user = :id_user AND tags LIKE :tag ORDER BY last_update DESC');
		$request->bindParam(':id_user', $userId, PDO::PARAM_INT, 1);
		$request->bindValue(':tag', '%'.$tag.'%', PDO::PARAM_STR);
		$request->execute();

		$snippetsMatchedByTag= array();

		while ($result= $request->fetch(PDO::FETCH_ASSOC)) {
			$oneOfMatchedSnippet= new Snippet($result);
			$snippetsMatchedByTag[]= $oneOfMatchedSnippet;
			unset($oneOfMatchedSnippet);
		}

		return $snippetsMatchedByTag;
	}

	public function getAllCateogies ($userId) {

		$db= PDOSQLite::getReference();
		$request= $db-prepare('SELECT DICTINCT category FROM snippets WHERE id_user = :id_user');
		$request->bindParam(':id_user', $userId, PDO::PARAM_INT, 1);
		$request->execute();

		return $request->fetchAll();
		
	}
	
	public function updateOldSnippetInfoByNew ($oldSnippet, $newSnippet) {
		
		$db= PDOSQLite::getDBLink();
		$request= $db->prepare('UPDATE snippets SET name = :name, id_user = :id_user, last_uodate = :last_update, content = :content, language = :language, comment = :comment, category = :category, tags = :tags, privacy = :privacy WHERE rowid = :id');

		$request->bindValue(':id', $oldSnippet->_id, PDO::PARAM_INT);#, 1);
		$request->bindValue(':name', $newSnippet->_name, PDO::PARAM_STR);#, 255);
		$request->bindValue(':id_user', $newSnippet->_idUser, PDO::PARAM_INT);#, 1);
		$request->bindValue(':last_update', $newSnippet->_lastUpdate, PDO::PARAM_INT);#, 32);
		$request->bindValue(':content', $newSnippet->_content, PDO::PARAM_STR);
		$request->bindValue(':language', $newSnippet->_language, PDO::PARAM_INT);#, 1);
		$request->bindValue(':comment', $newSnippet->_comment, PDO::PARAM_STR);#);
		$request->bindValue(':category', $newSnippet->_category, PDO::PARAM_STR);#, 80);
		$request->bindValue(':tags', $newSnippet->_tags, PDO::PARAM_STR);
		$request->bindValue(':privacy', $newSnippet->_privacy, PDO::PARAM_INT);#, 1);
		$updatedRow= $request->execute();

		if ($updatedRow == 1)
			return true;
		else
			return false;
			
	}

	public function deleteSnippetFromDB ($idSnippet) {
		
		if (!empty($idSnippet)) {
			$db= PDOSQLite::getDBLink();
			$request= $db->prepare('DELETE FROM snippets WHERE rowid = :id');
			$request->bindParam(':id', $idSnippet, PDO::PARAM_INT, 1);
			$deletedRow= $request->execute();

			if ($deletedRow == 1)
				return true;
			else
				return false;
		}
		
		return false;

	}

}
	