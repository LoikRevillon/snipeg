<?php

class UsersManager {

	private static $_instance;

	private function __construct() {}

	final private function __clone () {}

	public static function getReference() {

		if (!isset(self::$_instance))
			self::$_instance= new self();

		return self::$_instance;

	}

	public function userExistInDB($name) {

		$db= PDOSQLite::getDBLink();
		$request= $db->prepare('SELECT rowid as id, * FROM users WHERE name = :name');
		$request->bindParam(':name', $name, PDO::PARAM_STR, 30);
		$request->execute();

		$result= $request->fetch(PDO::FETCH_ASSOC);
		
		if (!empty($result))
			$userMatched= new User ($result);
		else
			$userMatched= false;


		return $userMatched;

	}

	public function getAllUSers() {

		$db= PDOSQLite::getDBLink();
		$request= $db->query('SELECT rowid as id, * FROM users ORDER BY name ASC');

		$usersList= array();

		while ($result= $request->fetch(PDO::FETCH_ASSOC)) {
			$oneUserOfDB= new User($result);
			$usersList[]= $oneUserOfDB;
			unset($oneUserOfDB);
		}

		return $usersList;

	}

	public function getAllAdmins() {

		$db= PDOSQLite::getDBLink();
		$request= $db->query('SELECT rowid as id, * FROM users WHERE admin != 0 ORDER BY name ASC');

		$adminsList= array();

		while ($result= $request->fetch(PDO::FETCH_ASSOC)) {
			$oneAdminOfDB= new User($result);
			$adminsList[]= $oneAdminOfDB;
			unset($oneAdminOfDB);
		}

		return $adminsList;

	}
	
	public function getAllUserInformations($userId) {
		
		$db= PDOSQLite::getDBLink();
		$request= $db->prepare('SELECT rowid as id, * FROM users WHERE rowid = :id');
										
		$request->bindParam(':id', $userId, PDO::PARAM_INT, 1);
		$request->execute();

		$result= $request->fetch(PDO::FETCH_ASSOC);
		$matchedUser= new User($result);

		return $matchedUser;

	}

	public function updateUserInfo($userId, $newInfos) {

		if ($this->userExistInDB($newInfos->_name))
			return false;

		$db= PDOSQLite::getDBLink();
		$request= $db->prepare('UPDATE users SET admin = :admin, name = :name, email = :email, password = :password, locked = :locked, theme = :theme, font = :font, color_scheme = :color_scheme, language = :language, favorite_lang = :favorite_lang WHERE rowid = :id');

		$request->bindValue(':id', $userId, PDO::PARAM_INT);#, 1);
		$request->bindValue(':admin', $newInfos->_admin, PDO::PARAM_INT);#, 1);
		$request->bindValue(':name', $newInfos->_name, PDO::PARAM_STR);#, 30);
		$request->bindValue(':email', $newInfos->_email, PDO::PARAM_STR);#, 80);
		$request->bindValue(':password', $newInfos->_password, PDO::PARAM_STR);#, 64);
		$request->bindValue(':locked', $newInfos->_locked, PDO::PARAM_INT);#, 1);
		$request->bindValue(':theme', $newInfos->_theme, PDO::PARAM_STR);#, 50);
		$request->bindValue(':font', $newInfos->_font, PDO::PARAM_STR);#, 30);
		$request->bindValue(':color_scheme', $newInfos->_colorScheme, PDO::PARAM_STR);#, 20);
		$request->bindValue(':language', $newInfos->_language, PDO::PARAM_STR);#, 5);
		$request->bindValue(':favorite_lang', $newInfos->_favoriteLang, PDO::PARAM_STR);
		$updatedRow= $request->execute();
		
		if ($updatedRow == 1)
			return true;
		else
			return false;

	}

}