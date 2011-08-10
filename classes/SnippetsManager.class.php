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
	
	public function getPublicSnippets($idUser) {

		$db= PDOSQLite::getDBLink();
		$request= $db->prepare('SELECT rowid as id, * FROM snippets WHERE id_user = :id_user AND privacy = 0 ORDER BY last_update DESC');
		$request->bindParam(':id_user', $userId, PDO::PARAM_INT, 1);

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

	public function getSnippetByCategory($userId, $cateoryName) {

		$db= PDOSQLite::getDBLink();
		$request= $db->prepare('SELECT rowid as id, * FROM snippets WHERE id_user = :id_user AND category = :category ORDER BY last_update DESC');
		$request->bindParam(':category', $categoryName, PDO::PARAM_STR, 80);
		$request->bindParam(':id_user', $userId, PDO::PARAM_INT, 1);
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

		$db= PDOSQLite::getDBLink();
		$request= $db->prepare('SELECT rowid as id, * FROM snippets WHERE id_user = :id_user tags LIKE %:tag% ORDER BY last_update DESC');
		$request->bindParam(':tag', $tag, PDO::PARAM_STR);
		$request->execute();

		$snippetsMatchedByTag= array();

		while ($result= $request->fetch(PDO::FETCH_ASSOC)) {
			$oneOfMatchedSnippet= new Snippet($result);
			$snippetsMatchedByTag[]= $oneOfMatchedSnippet;
			unset($oneOfMatchedSnippet);
		}

		return $snippetsMatchedByTag;
	}
	
	public function updateOldSnippetInfoByNew ($oldSnippet, $newSnippet) {
		
		$db= PDOSQLite::getDBLink();
		$request= $db->prepare('UPDATE snippets SET name = :name, id_user = :id_user, last_uodate = :last_update, content = :content, language = :language, comment = :comment, category = :category, tags = :tags, privacy = :privacy WHERE rowid = :id');

		$request->bindParam(':id', $oldSnippet->_id, PDO::PARAM_INT, 1);
		$request->bindParam(':name', $newSnippet->_name, PDO::PARAM_STR, 255);
		$request->bindParam(':id_user', $newSnippet->_idUser, PDO::PARAM_INT, 1);
		$request->bindParam(':last_update', $newSnippet->_lastUpdate, PDO::PARAM_INT, 32);
		$request->bindParam(':content', $newSnippet->_content, PDO::PARAM_STR);
		$request->bindParam(':language', $newSnippet->_language, PDO::PARAM_INT, 1);
		$request->bindParam(':comment', $newSnippet->_comment, PDO::PARAM_STR);
		$request->bindParam(':category', $newSnippet->_category, PDO::PARAM_STR, 80);
		$request->bindParam(':tags', $newSnippet->_tags, PDO::PARAM_STR);
		$request->bindParam(':privacy', $newSnippet->_privacy, PDO::PARAM_INT, 1);
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
	